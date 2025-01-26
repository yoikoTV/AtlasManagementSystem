<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments()
    {
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    // belongsToMany('関係するモデル（相手のモデル）', '中間テーブルのテーブル名', '中間テーブル内で対応しているID名（自分のモデルのID）', '関係するモデルで対応しているID名（リレーションしたい相手のID）');
    // 投稿時サブカテゴリーを選択して投稿するための記述
    public function subCategories()
    {
        return $this->belongsToMany('App\Models\Categories\SubCategory', 'post_sub_categories', 'post_id', 'sub_category_id');
    }

    // コメント数
    public function commentCounts($post_id)
    {
        return Post::with('postComments')->find($post_id)->postComments();
    }
}
