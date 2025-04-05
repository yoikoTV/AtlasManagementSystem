<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show()
    {
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request)
    {
        DB::beginTransaction();
        try {
            $getPart = $request->getPart;
            $getDate = $request->getData;
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            //複数日選択してまとめて予約できるからforeachで繰り返す
            //foreachがないと、1日ずつ予約ボタンを押して予約することになるから面倒
            foreach ($reserveDays as $key => $value) {
                //ReserveSettingsモデルからカラム名（setting_reserve）が$key（データ）の場合＆setting_partが$valueの場合のデータを取得する
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                //decrementメソッドは（）の中の数を−１できる
                //limit_users（予約可能な人数）を減らしている
                $reserve_settings->decrement('limit_users');
                //カレンダーのIDとユーザーのIDを中間テーブルに登録している（予約をしている）
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
    public function delete(Request $request)
    {
        $delete_getdate = $request->delete_getdate;
        $delete_getpart = $request->delete_getpart;
        if ($delete_getpart == "リモ1部") {
            $delete_getpart = 1;
        } else if ($delete_getpart == "リモ2部") {
            $delete_getpart = 2;
        } else if ($delete_getpart == "リモ3部") {
            $delete_getpart = 3;
        }
        $reserve_settings = ReserveSettings::where('setting_reserve', $delete_getdate)->where('setting_part', $delete_getpart)->first();
        $reserve_settings->increment('limit_users');
        $reserve_settings->users()->detach(Auth::id());
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
}
//日付と部数を取得
//予約を1個増やす、decrementの逆
//中間テーブルからデータを消す、attachの逆
