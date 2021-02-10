<?php

use App\ProductsImage;
use Illuminate\Database\Seeder;

class ProductsImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productImageRecords= [
            ['id'=>1,'product_id'=>1,'image'=>'6t8Zh249QiFmVnkQdCCtHK.jpg-50702.jpg','status'=>1]
        ];
        ProductsImage::insert($productImageRecords);
    }
}
