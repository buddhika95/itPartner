<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Section;
use App\Category;
use App\Product;
use Illuminate\Http\Request;

use Session;


class ProductController extends Controller
{
    public function products()
    {
        Session::put('page','products');
        $products = Product::with(['category'=>function($querry){
            $querry->select('id','category_name');
        },'section'=>function($querry){
            $querry->select('id','name');
        }])->get();
        // $products = json_decode(json_encode($products));
        // echo "<pre>"; print_r($products); die;
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request)
    {
       if($request->ajax()){
           $data=$request->all();
        //    echo "<pre>"; print_r($data); die;
        if($data['status']=="Active"){
            $status=0;
        }else{
            $status=1;
        }
        Product::where('id',$data['product_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
       }
    }

    public function deleteProduct($id)
    {
        //delete Product
        Product::where('id',$id)->delete();
        $message = "Product has been deleted successfully.!";
        session()->flash('success_message', $message);
        return redirect()->back();
    }

    public function addEditProduct(Request $request,$id=null)
    {
        if($id==""){
            $title='Add Product';
            $product = new Product;
        }else{
            $title="edit Product";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data); die;.
            //add product validateions

            $rules = [
            'category_id'=>'required',
            'product_name'=>'required|regex:/^[\pL\s\-]+$/u',
            'product_code'=>'required|regex:/^[\w-]*$/',
            'product_price'=>'required|numeric',
            'product_color'=>'required|regex:/^[\pL\s\-]+$/u',
            'category_image'=>'image',

        ];
        $customMessages=[
            'category_id.required'=>'category is required',
            'product_name.required'=>'Product Name is required',
            'product_name.regex'=>'Valid Product Name is required',
            'product_code.required'=>'Product Code is required',
            'product_code.regex'=>'Valid Product Codeis required',
            'product_price.required'=>'Product price is required',
            'product_price.numeric'=>'Valid Product Name is required',
            'product_color.required'=>'Product Color is required',
            'product_color.regex'=>'Valid Product Color is required',


        ];
        $this->validate($request,$rules,$customMessages);

        if(empty($data['is_featured'])){
            $is_featured = "No";
        }else{
            $is_featured  = "Yes";
        }

        // echo $is_featured; die;
        if(empty($data['product_discount'])){
            $data['product_discount']=00;
        }
        if(empty($data['product_weight'])){
            $data['product_weight']=00;
        }
        if(empty($data['description'])){
            $data['description']="";
        }


        //Save Product Details in Products table
        $categoryDetails = Category::find($data['category_id']);
        // echo "<pre>";print_r($categoryDetails); die;
        $product->section_id = $categoryDetails['section_id'];
        $product->category_id =$data['category_id'];
        $product->product_name  =$data['product_name'];
        $product->product_code =$data['product_code'];
        $product->product_color =$data['product_color'];
        $product->product_price =$data['product_price'];
        $product->product_discount =$data['product_discount'];
        $product->product_weight =$data['product_weight'];
        $product->description =$data['description'];
        $product->brand =$data['brand'];
        $product->quality =$data['quality'];
        $product->warrenty =$data['warrenty'];
        $product->meta_title  =$data['meta_title'];
        $product->meta_description =$data['meta_description'];
        $product->meta_keywords =$data['meta_keywords'];
        $product->is_featured = $is_featured;
        $product->status = 1;
        $product->save();
        $request->session()->flash('success', 'Products Added Successfully!');
        return redirect('admin/products');
        }



        //filter Arrays
        $brandArray = array('HP','Asus','Dell');
        $qualityArray = array('Brandard','Grade A','Grade B');
        $warrentyArray = array('6 Months','1 Year','3 Year');

        //Sections with categories and sub categories
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories),true);
        // echo "<pre>"; print_r($categories); die;

        return view('admin.products.add_edit_product')->with(compact('title','brandArray','qualityArray','warrentyArray','categories'));
    }

}
