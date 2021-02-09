<?php

use Illuminate\Database\Seeder;
use App\ProductsAttribute;
class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productsAttributesRecords = [
            ['id'=>1,'product_id'=>1,'type'=>'i3','price'=>150000,'stock'=>20,'sku'=>'BT001-i3','status'=>1],
            ['id'=>2,'product_id'=>1,'type'=>'i5','price'=>170000,'stock'=>'10','sku'=>'BT001-i5','status'=>1],
            ['id'=>3,'product_id'=>1,'type'=>'i7','price'=>190000,'stock'=>'5','sku'=>'BT001-i7','status'=>1],
        ];
        ProductsAttribute::insert($productsAttributesRecords);
    }
}
