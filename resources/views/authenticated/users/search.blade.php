@extends('layouts.sidebar')

@section('content')
<div class="search_content w-100 d-flex">
  <div class="reserve_users_area d-flex flex-wrap justify-content-start align-items-start">
    @foreach($users as $user)
    <div class="border one_person postcreate-border shadow">
      <div class="m-2">
        <span class="my_bold user_font">ID : </span>
        <span class="my_bold">{{ $user->id }}</span>
      </div>
      <div class="m-2">
        <span class="my_bold user_font">名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span class="my_bold">{{ $user->over_name }}</span>
          <span class="my_bold">{{ $user->under_name }}</span>
        </a>
      </div>
      <div class="m-2">
        <span class="my_bold user_font">カナ : </span>
        <span class="my_bold">({{ $user->over_name_kana }}</span>
        <span class="my_bold">{{ $user->under_name_kana }})</span>
      </div>
      <div class="m-2">
        @if($user->sex == 1)
        <span class="my_bold user_font">性別 : </span><span class="my_bold">男</span>
        @elseif($user->sex == 2)
        <span class="my_bold user_font">性別 : </span><span class="my_bold">女</span>
        @else
        <span class="my_bold user_font">性別 : </span><span class="my_bold">その他</span>
        @endif
      </div>
      <div class="m-2">
        <span class="my_bold user_font">生年月日 : </span><span class="my_bold">{{ $user->birth_day }}</span>
      </div>
      <div class="m-2">
        @if($user->role == 1)
        <span class="my_bold user_font">権限 : </span><span class="my_bold">教師(国語)</span>
        @elseif($user->role == 2)
        <span class="my_bold user_font">権限 : </span><span class="my_bold">教師(数学)</span>
        @elseif($user->role == 3)
        <span class="my_bold user_font">権限 : </span><span class="my_bold">講師(英語)</span>
        @else
        <span class="my_bold user_font">権限 : </span><span class="my_bold">生徒</span>
        @endif
      </div>
      <div class="m-2">
        @if($user->role == 4)
        <span class="my_bold user_font">選択科目 :</span>
        @foreach($user->subjects as $subject)
        <span class="my_bold">{{ $subject->subject }}</span>
        @endforeach
        @endif
      </div>
    </div>
    @endforeach
  </div>
  <form action="{{ route('user.show') }}" method="get" id="userSearchRequest">
    <div class="search_area">
      <div class="m-3 mt-5">
        <div class="mb-3">
          <h5>検索</h5>
        </div>
        <div class="mb-3">
          <input type="text" class="free_word p-2 user_search_bg" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
        </div>
        <div class="mb-3">
          <label>カテゴリ</label><br>
          <select class="user_search_bg" form="userSearchRequest" name="category">
            <option value="name">名前</option>
            <option value="id">社員ID</option>
          </select>
        </div>
        <div class="mb-4">
          <label>並び替え</label><br>
          <select class="user_search_bg" form="userSearchRequest" name="updown">
            <option value="ASC">昇順</option>
            <option value="DESC">降順</option>
          </select>
        </div>
        <div class="accordion-header search_border ml-3 mb-3" onclick="toggleAccordion(this)">
          <div class="d-flex justify-content-between align-items-center w-100">
            <span class="search_conditions">検索条件の追加</span>
            <span class="arrow"></span>
          </div>
        </div>
        <div class="accordion-content search_conditions_inner">
          <div class="mb-3">
            <label>性別</label><br>
            <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
            <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
            <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
          </div>
          <div class="mb-3">
            <label>権限</label><br>
            <select class="user_search_bg" name="role" form="userSearchRequest" class="engineer">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="mb-3 selected_engineer">
            <label>選択科目</label><br>
            @foreach($subjects as $subject)
            <span>{{$subject->subject}}</span><input type="checkbox" name="subject[]" value="{{ $subject->id }}" form="userSearchRequest">
            @endforeach
          </div>
        </div>
        <div class="mb-3">
          <input class="category_btn free_word p-2" type="submit" name="search_btn" value="検索" form="userSearchRequest">
        </div>
        <div>
          <input class="no-style-input" type="reset" value="リセット" form="userSearchRequest">
        </div>
      </div>
    </div>
  </form>
</div>
</div>
<script src="{{ asset('js/accordion.js') }}"></script>
@endsection
