<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

use function GuzzleHttp\json_decode;

class IndexController extends Controller
{
    public function index()
    {
        //querry to get featured items
        $featuredItemsCount=Product::where('is_featured','Yes')->where('status',1)->count();
        $featuredItems =Product::where('is_featured','Yes')->where('status',1)->get()->toArray();
        $featuredItemsChunk = array_chunk($featuredItems,4);

       //Get New Products
       $newProducts= Product::orderBy('id','Desc')->where('status',1)->limit(6)->get()->toArray();
       $newProducts= json_decode(json_encode($newProducts),true);
    //    echo "<pre>"; print_r($newProducts);die;

        $page_name = "index";
        return view('front.index')->with(compact('page_name','featuredItemsChunk','featuredItemsCount','newProducts'));
    }
}
