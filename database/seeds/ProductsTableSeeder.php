<?php


use Illuminate\Database\Seeder;
use App\Product;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords =[
            ['id'=>1,'category_id'=>4,'section_id'=>1,'product_name'=>'Laptop Test Product 1',
            'product_code'=>'BT001','product_color'=>'black','product_price'=>'150000',
            'product_discount'=>10,'product_weight'=>150,'product_video'=>'','main_image'=>'',
            'description'=>'test Product laptop','brand'=>'','quality'=>'','warrenty'=>'',
            'meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'No','status'=>1],

            ['id'=>2,'category_id'=>4,'section_id'=>1,'product_name'=>'Laptop Test Product 2',
            'product_code'=>'BT002','product_color'=>'blue','product_price'=>'230000',
            'product_discount'=>10,'product_weight'=>150,'product_video'=>'','main_image'=>'',
            'description'=>'test Product laptop','brand'=>'','quality'=>'','warrenty'=>'',
            'meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'Yes','status'=>1],

        ];
        Product::insert($productRecords);
    }
}
