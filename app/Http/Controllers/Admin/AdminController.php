<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Http\Middleware\Admin;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Admin;
use Hash;
use Image;
use PharIo\Manifest\Email;
use Session;


class AdminController extends Controller
{
    public function dashboard()
    {
        Session::put('page', 'dashboard');
        return view('admin.admin_dashboard');
    }

    public function settings()
    {
        Session::put('page', 'settings');
        // echo "<pre>"; print_r(Auth::guard('admin')->user()); die;
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_settings')->with(compact('adminDetails'));
    }

    public function login(Request $request)
    {
        if($request->isMethod('post'))
        {
          $data = $request->all();
        //   echo "<pre>"; print_r($data); die;

            $rules = ['email' => 'required|email|max:255',
            'password' => 'required',
            ];


                    $customMessages=[
                        'email.required'=>'Email is required',
                        'email.email'=>'Enter a Valid Email',
                        'password.required'=>'password is required',
                    ];

            $this->validate($request,$rules,$customMessages);

            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']]))
            {
                return redirect('admin/dashboard');
            }else{
                $request->session()->flash('error_message', 'Invalid Email or Password');
                return redirect()->back();
            }
        }
        return view('admin.admin_login');
    }
    public function logout()
    {
       Auth::guard('admin')->Logout();
       return redirect('/admin');
    }
    public function chkCurrentPassword(Request $request){
        $data = $request->all();
        //echo "<pre>"; print_r($data);
        if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
            echo "true";
        }else{
            echo "false";
        }
    }

    public function updateCurrentPassword(Request $request){
        Session::put('page', 'settings');
        if($request->isMethod('post')){
            $data =$request->all();
            // echo "<pre>"; print_r($data); die;
            //Check if current password is correct
            if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
                //check new password and confirm password is matching
                if($data['new_pwd']==$data['confirm_pwd']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_pwd'])]);
                    $request->session()->flash('success_message', 'Password has been Updated');
                }else{
                    $request->session()->flash('error_message', 'New Password and confirm password not matching');
                }
            }else{
                $request->session()->flash('error_message', 'your Current password is incorrect');


            }
            return redirect()->back();
            }

    }

    public function updateAdminDetails(Request $request)
    {
        Session::put('page', 'update-admin-details');
        if($request->isMethod('post')){
            $data=$request->all();
            // echo"<pre>"; print_r($data); die;
            $rules = [
                'admin_name'=>'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile'=>'required|numeric',
                'admin_image'=>'image',

            ];
            $customMessages=[
                'admin_name.required'=>'Name is required',
                'admin_name.regex'=>'Valid Name is required',
                'admin_mobile.required'=>'Mobile Number is required',
                'admin_mobile.numeric'=>'enter correct Number',
                'admin_image.image'=>'Valid image is required',

            ];
            $this->validate($request,$rules,$customMessages);

            //upload admin image
            if($request->hasFile('admin_image')){
                $image_tmp=$request->file('admin_image');
                if($image_tmp->isValid()){
                    //Get Image extention
                    $extension=$image_tmp->getClientOriginalExtension();
                    //generate New image name
                    $imageName=rand(111,99999).'.'.$extension;
                    $imagePath='images/admin_images/admin_photos/'.$imageName;
                    //upload the image
                    Image::make($image_tmp)->resize(400,400)->save($imagePath);
                }else if(!empty($data['current_admin_image'])){
                    $imagename = $data['current_admin_image'];
                }else{
                    $imageName="";
                }

            }

            //update Admin details
            Admin::where('email',Auth::guard('admin')->user()->email)
            ->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'],'image'=>$imageName]);
            $request->session()->flash('success_message', 'Admin details updated sucessfully');
            return redirect()->back();
        }
        return view('admin.update_admin_details');
    }
}

