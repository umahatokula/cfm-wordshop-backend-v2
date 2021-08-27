<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        $category                        = new Category;
        $category->name                  = 'Audio';
        $category->save();

        $category                        = new Category;
        $category->name                  = 'Video';
        $category->save();

        $category                        = new Category;
        $category->name                  = 'Books';
        $category->save();

        $category                        = new Category;
        $category->name                  = 'Magazine';
        $category->save();
    }
}
