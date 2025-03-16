<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use App\Http\Requests\BulletinBoard\SubCategoryFormRequest;
use App\Http\Requests\BulletinBoard\MainCategoryFormRequest;
use Auth;

class PostsController extends Controller
{
    public function show(Request $request)
    {
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();
        $sub_categories = SubCategory::get();
        $like = new Like;
        $post_comment = new Post;
        if (!empty($request->keyword)) {
            $posts = Post::with('user', 'postComments')
                ->where('post_title', 'like', '%' . $request->keyword . '%')
                ->orWhere('post', 'like', '%' . $request->keyword . '%')
                ->orWhereHas('subCategories', function ($query) use ($request) {
                    $query->where('sub_category', $request->keyword);
                })
                ->get();
        } else if ($request->category_word) {
            $sub_category =
                SubCategory::where('sub_category', $request->category_word)->first();
            // サブカテゴリーの名前と、送られてきた名前が一致しているもののデータ全てを取得
            $posts = Post::with('user', 'postComments', 'subCategories')
                ->whereHas('subCategories', function ($query) use ($sub_category) {
                    $query->where('sub_category_id', $sub_category->id);
                })
                ->get();
            // whereHas メソッドは、関連する別のテーブル（中間テーブル）に対して条件を追加するためのメソッドです。多対多や一対多などのリレーションが設定されている場合に使います。
            // whereHas を使うことで、リレーション先のテーブルに条件を指定し、それに一致するリレーションを持つ親テーブル（例えば、Post モデル）のデータを取得します。
            // $query を使わない場合、whereHas メソッドがどのように条件を追加するかがわからなくなります。
            // whereHas の中でリレーション先のデータに対して絞り込むために、$query を使う必要があるからです。
            // もし $query を省略してしまうと、whereHas の中でリレーション先（subCategories）に対する具体的な絞り込み条件が指定されなくなり、すべての関連する投稿を取得してしまうことになります。
        } else if ($request->like_posts) {
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
                ->whereIn('id', $likes)->get();
        } else if ($request->my_posts) {
            $posts = Post::with('user', 'postComments')
                ->where('user_id', Auth::id())->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'sub_categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id)
    {
        $user_id = Auth::id();
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post', 'user_id'));
    }

    public function postInput()
    {
        $main_categories = MainCategory::get();
        $sub_categories = SubCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories', 'sub_categories'));
    }

    public function postCreate(PostFormRequest $request)
    {
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        //$requestの後はbladeのnameを記述　$sub_category_idはbladeのform（post_category_id）の中にある　attachメソッドで使うために記述
        $sub_category_id = $request->post_category_id;
        //新規投稿した投稿のidを探す
        $post = Post::findOrFail($post->id);
        //新規投稿した投稿にsubCategoriesメソッドを用いて、attach（テーブルに情報を追加）でサブカテゴリーのidを追加する
        $post->subCategories()->attach($sub_category_id);
        return redirect()->route('post.show');
    }

    public function postEdit(PostFormRequest $request)
    {
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id)
    {
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    // メインカテゴリーの追加
    public function mainCategoryCreate(MainCategoryFormRequest $request)
    {
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }
    // サブカテゴリーの追加
    public function subCategoryCreate(SubCategoryFormRequest $request)
    {
        // 'DBのカラム名' => $request->bladeで入力した情報（nameで指定した名前を入力）->createする
        SubCategory::create([
            'sub_category' => $request->sub_category_name,
            'main_category_id' => $request->main_category_id
        ]);
        return redirect()->route('post.input');
    }


    public function commentCreate(Request $request)
    {
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard()
    {
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard()
    {
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
            ->where('like_post_id', $post_id)
            ->delete();

        return response()->json();
    }
}
