<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Session;
use Image;
class BannersController extends Controller
{
    public function banners()
    {
        Session::put('page','banners');
        $banners = Banner::get()->toArray();
        // dd($banners); die; //testing
        return view('admin.banners.banners')->with(compact('banners'));
    }

    public function addEditBanner($id=null,Request $request)
    {
        if($id==""){
            //add banner
            $banner =new Banner;
            $title="Add Banner Image";
            $message = "Banner added successfully";

        }else{
            //edit banner
            $banner=Banner::find($id);
            $title="Edit Banner Image";
            $message = "Banner updated successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $banner->link =$data['link'];
            $banner->title=$data['title'];
            $banner->alt =$data['alt'];

             // upload Banner Image
             if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    //get original image name
                    $image_name=$image_tmp->getClientOriginalName();
                    //get image extension
                    $extension =$image_tmp->getClientOriginalExtension();
                    //generate new image
                    $imageName = $image_name.'-'.rand(111,99999).'.'.$extension;
                    //set paths for small,meduim and large images
                    $banner_image_path = 'images/banner_images/'.$imageName;


                    //upload image after resize
                    Image::make($image_tmp)->resize(1170,480)->save($banner_image_path);

                    //save image in bannert table
                    $banner->image = $imageName;
                }
            }
            $banner->save();
            $request->session()->flash('success_message', $message);
                return redirect('admin/banners');

        }

        return view('admin.banners.add_edit_banner')->with(compact('title','banner'));
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
