<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Session;
class BannersController extends Controller
{
    public function banners()
    {
        $banners = Banner::get()->toArray();
        // dd($banners); die; //testing
        return view('admin.banners.banners')->with(compact('banners'));
    }


    public function updateBannerStatus(Request $request)
    {
       if($request->ajax()){
           $data=$request->all();
        //    echo "<pre>"; print_r($data); die;
        if($data['status']=="Active"){
            $status=0;
        }else{
            $status=1;
        }
        Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);
       }
    }

    public function deleteBanner($id)
    {
        //get banner image
        $bannerImage = Banner::where('id',$id)->first();

        //get Banner Image PAths
        $banner_image_path = 'images/banner_images/';

        //delete banner Image from banners folder if exists
        if(file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }

        //delete banner form banners table
        Banner::where('id',$id)->delete();
        $message = "Banner has been deleted successfully.!";
        session()->flash('success_message', $message);
        return redirect()->back();
}
}
