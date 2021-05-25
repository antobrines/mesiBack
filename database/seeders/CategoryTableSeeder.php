<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->name = "Vêtements";
        $category->image = "https://images.unsplash.com/photo-1601642731307-595a8319c128?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80";
        $category->save();

        $category = new Category();
        $category->name = "Mobilier";
        $category->image = "https://images.unsplash.com/photo-1588706235076-627d896e9f67?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8Y2hhaXNlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60";
        $category->save();

        $category = new Category();
        $category->name = "Bijoux";
        $category->image = "https://images.unsplash.com/photo-1598472142296-b9e8f89bd9a5?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8YnJhY2VsZXR8ZW58MHx8MHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60";
        $category->save();
    }
}
