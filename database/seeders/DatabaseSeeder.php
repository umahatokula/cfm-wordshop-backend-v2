<?php

namespace Database\Seeders;

use App\Models\Pin;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\PreachersTableSeeder;
use Database\Seeders\CategoriesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Pin::factory(100)->create();
        Product::factory(1000)->create();

        $this->call([
            CategoriesTableSeeder::class,
            PreachersTableSeeder::class,
            RolesTableSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
