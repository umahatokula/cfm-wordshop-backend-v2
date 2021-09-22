<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Umaha Tokula',
            'email' => 'umahatokula@gmail.com',
            'password' => \Hash::make('12345678'),
        ]);

        $user->assignRole('super_admin');
    }
}
