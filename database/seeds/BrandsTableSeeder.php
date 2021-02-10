<?php

use Illuminate\Database\Seeder;
use App\Brand;
class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brandRecords = [
            ['id'=>1,'name'=>'Asus','status'=>1],
            ['id'=>2,'name'=>'HP','status'=>1],
            ['id'=>3,'name'=>'Dell','status'=>1],
            ['id'=>4,'name'=>'Toshiba','status'=>1],
            ['id'=>5,'name'=>'Acer','status'=>1],

        ];
        Brand::insert($brandRecords);
    }
}
