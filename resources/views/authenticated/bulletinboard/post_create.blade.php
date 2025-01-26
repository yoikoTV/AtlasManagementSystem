@extends('layouts.sidebar')

@section('content')
<div class="post_create_container d-flex">
  <div class="post_create_area border w-50 m-5 p-5">
    <div class="">
      <p class="mb-0">カテゴリー</p>
      <select class="w-100" form="postCreate" name="post_category_id">
        @foreach($main_categories as $main_category)
        <!-- optgroupはoptionのデータをグループ化できる メインカテゴリーを繰り返し表示-->
        <optgroup label="{{ $main_category->main_category }}">
          @foreach($sub_categories as $sub_category)
          <!-- optionタグだけでは全てのサブカテゴリーを表示してしまうため、$main_categoryのidが$sub_categoryのmain_category_idと同じ時と条件を追加 -->
          @if($main_category->id == $sub_category->main_category_id)
          <!-- attachで追加するために、サブカテゴリーの情報が必要　ピカチュウなどではわからないので、id(1とか2とか)をValueに表示することで、PostsControllerの64行目で読み込める -->
          <option value="{{$sub_category->id}}">{{$sub_category->sub_category}}</option>
          @endif
          @endforeach
        </optgroup>
        @endforeach
      </select>
    </div>
    <div class="mt-3">
      @if($errors->first('post_title'))
      <span class="error_message">{{ $errors->first('post_title') }}</span>
      @endif
      <p class="mb-0">タイトル</p>
      <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
    </div>
    <div class="mt-3">
      @if($errors->first('post_body'))
      <span class="error_message">{{ $errors->first('post_body') }}</span>
      @endif
      <p class="mb-0">投稿内容</p>
      <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
    </div>
    <div class="mt-3 text-right">
      <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
    </div>
    <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
  </div>

  @can('admin')
  <div class="w-25 ml-auto mr-auto">
    <div class="category_area mt-5 p-5">
      <div class="">
        <p class="m-0">メインカテゴリー</p>
        <input type="text" class="w-100" name="main_category_name" form="mainCategoryRequest">
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="mainCategoryRequest">
      </div>
      <div class="">
        <p class="m-0">サブカテゴリー</p>
        <!-- メインカテゴリーを選択 -->
        <select class="w-100" form="mainCategoryRequest" name="main_category_id">
          <option value="">---</option>
          @foreach($main_categories as $main_category)
          <option value="{{$main_category->id}}">{{$main_category->main_category}}</option>
          @endforeach
        </select>
        <!-- サブカテゴリーの追加 -->
        <input type="text" class="w-100" name="sub_category_name" form="subCategoryRequest">
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="subCategoryRequest">
      </div>
      <!-- ルーティング　idの名前は、web.phpに記載がある！コントローラーの決まったメソッドに情報を飛ばす -->
      <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">{{ csrf_field() }}</form>
      <form action="{{ route('sub.category.create') }}" method="post" id="subCategoryRequest">{{ csrf_field() }}</form>
    </div>
  </div>
  @endcan
</div>
@endsection
