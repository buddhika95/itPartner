<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Session;
Use App\Cart;
use Auth;

class UsersController extends Controller
{
    public function loginRegister(){
        return view('front.users.login_register');
    }

    public function registerUser(Request $request)
    {
       if($request->isMethod('post')){
           $data=$request->all();
        //    echo "<pre>";print_r($data); die;
           //check if user already exists
           $userCount = User::where('email',$data['email'])->count();
           if($userCount>0){
               $message = "Email Already Exists!";
               $request->session()->flash('error_message', $message);
               return redirect()->back();
           }else{
               //save the user
               $user =new User;
               $user->name = $data['name'];
               $user->mobile = $data['mobile'];
               $user->email = $data['email'];
               $user->password = bcrypt($data['password']);
               $user->status = 1;
               $user->save();

               if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){

                    //update user carrt with user ID
                    if(!empty(Session::get('session_id'))){
                        $user_id=Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }


                return redirect('cart');
               }

           }
       }
    }

    public function checkEmail(Request $request)
    {
        //check if email already exists
        $data = $request->all();
        $emailCount = User::where('email',$data['email'])->count();
        if($emailCount>0){
            return "false";
        }else{
            return "true";
        }
    }

    public function loginUser(Request $request)
    {
       if($request->isMethod('post')){
           $data = $request->all();
        //    echo "<pre>"; print_r($data);die;
           if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){

            //update user carrt with user ID
            if(!empty(Session::get('session_id'))){
                $user_id=Auth::user()->id;
                $session_id = Session::get('session_id');
                Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
            }

            return redirect('/cart');
           }else{
               $message = "Invalid Username or Password";
               $request->session()->flash('error_message', $message);
               return redirect()->back();
           }
       }
    }

    public function logoutUser(){
        Auth::logout();
        return redirect('/');
    }
}
