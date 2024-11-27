<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'over_name' => '長瀬',
                'under_name' => '萌英',
                'over_name_kana' => 'ナガセ',
                'under_name_kana' => 'モエ',
                'mail_address' => 'moe@mail.com',
                'sex' => '2',
                'birth_day' => '2000-07-13',
                'role' => '1',
                'password' => bcrypt('nagase')
            ],
        ]);
    }
}
