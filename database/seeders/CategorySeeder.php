<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = ['computer','clothes','books','mobiles','electronics','foods','medicines','cards','papers','pens','magazines'];

        foreach($categories as $c){
            Category::create([
                'name' => $c
            ]);
        }

    }
}
