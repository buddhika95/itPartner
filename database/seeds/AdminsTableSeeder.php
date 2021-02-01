<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
            [
                'id'=>1,'name'=>'admin','type'=>'admin','mobile'=>'0716923624',
                'email'=>'admin@admin.com','password'=>'$2y$10$uzPsZj81SBMBnX/I7jUzJOmF4Ed3JOt/3u9zUGhg3iRt2/s.DHUCa','image'=>'','status'=>1
            ],
            [
                'id'=>2,'name'=>'admin2','type'=>'subadmin','mobile'=>'0716923624',
                'email'=>'admin2@admin.com','password'=>'$2y$10$uzPsZj81SBMBnX/I7jUzJOmF4Ed3JOt/3u9zUGhg3iRt2/s.DHUCa','image'=>'','status'=>1
            ],
            [
                'id'=>3,'name'=>'admin4','type'=>'subadmin','mobile'=>'0716923624',
                'email'=>'admin3@admin.com','password'=>'$2y$10$uzPsZj81SBMBnX/I7jUzJOmF4Ed3JOt/3u9zUGhg3iRt2/s.DHUCa','image'=>'','status'=>1
            ],
            [
                'id'=>4,'name'=>'admin4','type'=>'admin','mobile'=>'0716923624',
                'email'=>'admin4@admin.com','password'=>'$2y$10$uzPsZj81SBMBnX/I7jUzJOmF4Ed3JOt/3u9zUGhg3iRt2/s.DHUCa','image'=>'','status'=>1
            ],
        ];

        DB::table('admins')->insert($adminRecords);
        // foreach($adminRecords as $key => $record){}
        //     \App\Admin::create($record);
        }
    }

