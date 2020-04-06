<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Action', 'Horror', 'Comedy', 'Fiction', 'Cult'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
