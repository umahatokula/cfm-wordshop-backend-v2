<?php

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
        // factory(App\Category::class, 10)->create();
        App\Models\Category::truncate();

        $category                        = new App\Category;
        $category->name                  = 'Audio';
        $category->save();

        $category                        = new App\Category;
        $category->name                  = 'Video';
        $category->save();

        $category                        = new App\Category;
        $category->name                  = 'Books';
        $category->save();

        $category                        = new App\Category;
        $category->name                  = 'Magazine';
        $category->save();
    }
}
