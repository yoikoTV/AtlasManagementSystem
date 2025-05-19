@extends('layouts.sidebar')
@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5 shadow" style="border-radius:10px; background:#FFF;">
    <div class="w-75  m-auto">
      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="table-responsive calendar-wrapper mb-3">
        {!! $calendar->render() !!}
      </div>
      <div class="text-right m-auto">
        <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
      </div>
    </div>
  </div>
</div>
@endsection
