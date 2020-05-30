<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        User::create([
            'email' => 'user@user.com',
            'password' => Hash::make('user'),
            'name' => 'user',
            'is_admin' => 0,
        ]);
        User::create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'name' => 'admin',
            'is_admin' => 1,
        ]);
    }
}
