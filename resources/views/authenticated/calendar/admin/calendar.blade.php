@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5 shadow" style="border-radius:10px; background:#FFF;">
    <div class="w-75 m-auto" style="border-radius:5px;">
      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="table-responsive">
        {!! $calendar->render() !!}
      </div>
    </div>
  </div>
</div>
@endsection
