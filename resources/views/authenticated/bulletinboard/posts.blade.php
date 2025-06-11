@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto"></p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p class="text-muted"><span>{{ $post->user->over_name }}</span><span class="ml-2 ">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}" class="font-weight-bold text-dark">{{ $post->post_title }}</a></p>
      <div class="post_bottom_area d-flex">
        @foreach($post->subCategories as $sub)
        <p class="category_btn">{{ $sub->sub_category }}</p>
        @endforeach
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment"></i>
            <span class="count_margin">{{$post->commentCounts($post->id)->count()}}</span>
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0">
              <i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i>
              <span class="count_margin like_counts{{ $post->id }}">{{$like->likeCounts($post->id)}}</span>
            </p>
            @else
            <p class="m-0">
              <i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i>
              <span class="count_margin like_counts{{ $post->id }}">{{$like->likeCounts($post->id)}}</span>
            </p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_areaw-25">
    <div class="m-4">
      <a href="{{ route('post.input') }}" class="text-decoration-none">
        <div class="category_btn post-btn mb-3">投稿</div>
      </a>
      <div class="mb-3 d-flex justify-content-between">
        <input type="text" class="keyword-text border" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" class="category_btn key-word-btn" value="検索" form="postSearchRequest">
      </div>
      <div class="d-flex justify-content-between mb-3">
        <input type="submit" name="like_posts" class="good_btn w-50" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" name="my_posts" class="mypost_btn w-50" value="自分の投稿" form="postSearchRequest">
      </div>

      <p>カテゴリー検索</p>
      <ul>
        @foreach($categories as $category)
        <li class="main_categories" category_id="{{ $category->id }}">
          <div class="accordion-header border-thick mb-3" onclick="toggleAccordion(this)">
            <span>{{ $category->main_category }}</span>
            <div class="mr-3">
              <span class="arrow"></span>
            </div>
          </div>
          <div class="accordion-content">
            <ul class="category_word-wrap mb-3 ml-3">
              @foreach($sub_categories as $sub_category)
              @if($category->id == $sub_category->main_category_id)
              <li class="border-thick" value="{{$sub_category->id}}">
                <span>
                  <input type="submit" name='category_word' class="category_word" value="{{$sub_category->sub_category}}" form="postSearchRequest">
                </span>
              </li>
              @endif
              @endforeach
            </ul>
          </div>
        </li>
        @endforeach
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
<script src="{{ asset('js/accordion.js') }}"></script>
@endsection
