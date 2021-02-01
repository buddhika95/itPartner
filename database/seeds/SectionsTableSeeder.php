<?php

use Illuminate\Database\Seeder;
use App\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectionRecords=[
            ['id'=>1,'name'=>'BrandNew','status'=>1],
            ['id'=>2,'name'=>'Used','status'=>1],
            ['id'=>3,'name'=>'Refurbished','status'=>1],
        ];
        Section::insert($sectionRecords);
    }
}
