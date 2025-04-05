@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>
<div>
  <div class="modal js-modal">
    <div class="modal__bg js-modal-close"></div>
    <div class="modal__content">
      <p>予約日<span class="modal_date"></span></p>
      <p>時間<span class="modal_part"></span></p>
      <p>上記の予約をキャンセルしてよろしいですか？</p>
      <div class="modal_buttons d-flex">
        <button type="button" class="btn btn-primary close_button_modal js-modal-close">
          閉じる
        </button>
        <button type="submit" class="btn btn-danger cancel_button_modal" form="deleteParts">
          キャンセル
        </button>
        <input class="delete_date" name="delete_getdate" type="hidden" value="" form="deleteParts">
        <input class="delete_part" name="delete_getpart" type="hidden" value="" form="deleteParts">
      </div>
    </div>
  </div>
</div>
@endsection
