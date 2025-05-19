@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-75 m-auto h-75">
    <p><span>{{ \Carbon\Carbon::parse($date)->format('Y年m月d日') }}</span><span class="ml-3">{{$part}}部</span></p>
    <div class="h-75 border shadow p-2" style="border-radius:10px; background:#FFF;">
      <table class="w-100">
        <tr class="text-center table-bg">
          <th style="width: 20%;">ID</th>
          <th style="width: 40%;">名前</th>
          <th style="width: 40%;">場所</th>
        </tr>
        @php $i = 0; @endphp
        @foreach($reservePersons as $reservePerson)
        @foreach($reservePerson->users as $user)
        @php $i++; @endphp
        <tr class="text-center custom-row-height striped-list {{ $i % 2 == 0 ? 'bg-custom' : 'bg-white' }}">
          <td class="w-25">{{ $user->id }}</td>
          <td class="w-25">{{ $user->over_name }}{{ $user->under_name }}</td>
          <td class="w-25">リモート</td>
        </tr>
        @endforeach
        @endforeach
      </table>
    </div>
  </div>
</div>
@endsection
