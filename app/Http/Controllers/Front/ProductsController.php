<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;
use App\Category;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function listing(Request $request){
        Paginator::useBootstrap();
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $url = $data['url'];

            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){

                $categoryDetails = Category::catDetails($url);
                // echo "<pre>"; print_r($categoryDetails); die;
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->
                where('status',1);

                //if quality filter is selected
                if(isset($data['quality']) && !empty($data['quality'])){
                    $categoryProducts->whereIn('products.quality',$data['quality']);
                }

                //if Warrenty filter is selected
                if(isset($data['warrenty']) && !empty($data['warrenty'])){
                    $categoryProducts->whereIn('products.warrenty',$data['warrenty']);
                }

                //if Warrenty filter is selected
                if(isset($data['freeitem']) && !empty($data['freeitem'])){
                    $categoryProducts->whereIn('products.freeitem',$data['freeitem']);
                }





                // if sort option selected by user
                if(isset($data['sort']) && !empty($data['sort'])){
                    if($data['sort'] == "product_latest"){
                        $categoryProducts->orderBy('id','Desc');
                    }
                    elseif($data['sort'] == "product_name_a_z"){
                        $categoryProducts->orderBy('product_name','Asc');
                    }
                    elseif($data['sort'] == "product_name_z_a"){
                        $categoryProducts->orderBy('product_name','Desc');
                    }
                    elseif($data['sort'] == "price_lowest"){
                        $categoryProducts->orderBy('product_price','Asc');
                    }
                    elseif($data['sort'] == "price_highest"){
                        $categoryProducts->orderBy('product_price','Desc');
                    }
                }else{
                    $categoryProducts->orderBy('id','Desc');
                }
                $categoryProducts =$categoryProducts->paginate(9);

                // echo "<pre>"; print_r($categoryProducts); die;
                return view('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{

                abort(404);
            }

        }else{
           $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){

                $categoryDetails = Category::catDetails($url);
                // echo "<pre>"; print_r($categoryDetails); die;
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->
                where('status',1);
                $categoryProducts =$categoryProducts->paginate(9);
                // echo "<pre>"; print_r($categoryProducts); die;

                        //Product filters
                $productFilters = Product::productFilters();
                $qualityArray = $productFilters['qualityArray'];
                $warrentyArray = $productFilters['warrentyArray'];
                $freeItemArray = $productFilters['freeItemArray'];

                $page_name="listing";

                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url','qualityArray','warrentyArray','freeItemArray','page_name'));
            }else{

                abort(404);
            }
        }
    }

    public function detail($code,$id)
    {
        return view('front.products.detail');
    }
}
