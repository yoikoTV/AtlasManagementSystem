<?php

namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

class CalendarWeekDay
{
  protected $carbon;

  function __construct($date)
  {
    $this->carbon = new Carbon($date);
  }

  function getClassName()
  {
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function render()
  {
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay()
  {
    return $this->carbon->format("Y-m-d");
  }

  function dayPartCounts($ymd)
  {
    $html = [];
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();

    $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();

    $html[] = '<div class="text-left">';
    if ($one_part) {
      $one_part_user_count = $one_part->users->count();
      $html[] = '<p class="day_part m-0 pt-1">';
      $html[] = '<a href="/calendar/' . $ymd . '/' . $one_part->setting_part . '">1部</a>';
      $html[] = '<span class="ml-4">' . $one_part_user_count . '</span>';
      $html[] = '</p>';
    }
    if ($two_part) {
      $two_part_user_count = $two_part->users->count();
      $html[] = '<p class="day_part m-0 pt-1">
      <a href="/calendar/' . $ymd . '/' . $two_part . '">2部</a>
      <span class="ml-3">' . $two_part_user_count . '</span>
      </p>';
    }
    if ($three_part) {
      $three_part_user_count = $three_part->users->count();
      $html[] = '<p class="day_part m-0 pt-1">
      <a href="/calendar/' . $ymd . '/' . $three_part . '">3部</a>
      <span class="ml-3">' . $three_part_user_count . '</span>
      </p>';
    }
    $html[] = '</div>';

    return implode("", $html);
  }


  function onePartFrame($day)
  {
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if ($one_part_frame) {
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
    } else {
      $one_part_frame = "20";
    }
    return $one_part_frame;
  }
  function twoPartFrame($day)
  {
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if ($two_part_frame) {
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    } else {
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }
  function threePartFrame($day)
  {
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if ($three_part_frame) {
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    } else {
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //スクール枠登録のページ設定
  function dayNumberAdjustment()
  {
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }
}
