<?php

use Illuminate\Database\Seeder;
use App\Banner;
class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannerRecords = [
            ['id'=>1,'image'=>'banner1.png','link'=>'','title'=>'Gaming Laptop','alt'=>'Gaming Laptop','status'=>1],
            ['id'=>2,'image'=>'banner2.png','link'=>'','title'=>'Mini Laptop','alt'=>'Mini Laptop','status'=>1],
            ['id'=>3,'image'=>'banner3.png','link'=>'','title'=>'Laptop Accesories','alt'=>'Laptop Accesories','status'=>1]

        ];
        Banner::insert($bannerRecords);
    }
}
