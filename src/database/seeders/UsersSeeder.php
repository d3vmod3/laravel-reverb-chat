<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User;
        $user->name = "Alexie S. Tuzon";
        $user->email = "astuzon@gmail.com";
        $user->password = Hash::make("qwerty54321");
        $user->save();

        $user = new User;
        $user->name = "Glenda Abuzo";
        $user->email = "glendaabuzo@gmail.com";
        $user->password = Hash::make("qwerty54321");
        $user->save();



        $users = User::factory()->count(10)->create();
    }
}
