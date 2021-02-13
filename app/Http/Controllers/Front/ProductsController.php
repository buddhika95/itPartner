<?php

namespace App\Http\Controllers\Front;

use App\Category;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function listing($url,Request $request){
        if($request->ajax()){
            $data = $request->all();
            echo "<pre>"; print_r($data); die;
        }else{
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){

                $categoryDetails = Category::catDetails($url);
                // echo "<pre>"; print_r($categoryDetails); die;
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->
                where('status',1);

                // if sort option selected by user
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort'] == "product_latest"){
                        $categoryProducts->orderBy('id','Desc');
                    }
                    elseif($_GET['sort'] == "product_name_a_z"){
                        $categoryProducts->orderBy('product_name','Asc');
                    }
                    elseif($_GET['sort'] == "product_name_z_a"){
                        $categoryProducts->orderBy('product_name','Desc');
                    }
                    elseif($_GET['sort'] == "price_lowest"){
                        $categoryProducts->orderBy('product_price','Asc');
                    }
                    elseif($_GET['sort'] == "price_highest"){
                        $categoryProducts->orderBy('product_price','Desc');
                    }
                }else{
                    $categoryProducts->orderBy('id','Desc');
                }
                $categoryProducts =$categoryProducts->paginate(12);

                // echo "<pre>"; print_r($categoryProducts); die;
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{

                abort(404);
            }
        }

    }
}
