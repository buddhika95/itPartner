<?php

use App\Category;
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
        $categoryRecords = [
            ['id'=>1,'parent_id'=>0,'section_id'=>1,'category_name'=>'Laptops','category_image'=>'','category_discount'=>0,'description'=>'','url'=>'laptops','meta_title'=>'',
            'meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>2,'parent_id'=>0,'section_id'=>1,'category_name'=>'PC','category_image'=>'','category_discount'=>0,'description'=>'PC','url'=>'','meta_title'=>'',
            'meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>3,'parent_id'=>0,'section_id'=>1,'category_name'=>'Laptop Accesories','category_image'=>'','category_discount'=>0,'description'=>'','url'=>'Laptop-Accesories','meta_title'=>'',
            'meta_description'=>'','meta_keywords'=>'','status'=>1]
       
        ];
        Category::insert($categoryRecords);
    }
}
