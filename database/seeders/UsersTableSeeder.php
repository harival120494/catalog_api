<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserInformations;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->email = "admin@mail.com";
        $user->password = Hash::make('123456');
        $user->role = 1;
        $user->status = 1;
        $user->save();

        $info = new UserInformations;
        $info->name = "Administrator";
        $info->user_id = 1;
        $info->tempatLahir = "Jakarta";
        $info->tglLahir = "1994-04-12";
        $info->no_hp = "082387462649";
        $info->alamat = "Jakarta";
        $info->foto = "foto/1645361068.png";
        $info->save();
    }
}
