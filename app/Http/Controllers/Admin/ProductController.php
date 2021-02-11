<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Section;
use App\Category;
use App\Product;
use App\Brand;
use App\ProductsAttribute;
use App\ProductsImage;
use Illuminate\Http\Request;

use Session;
use Image;


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
            $productdata = array();
            $message = "product added Successfully";
        }else{
            $title="edit Product";
            $productdata = Product::find($id);
            $productdata = json_decode(json_encode($productdata),true);
            // echo "<pre>"; print_r($productdata); die;
            $product = Product::find($id);
            $message = "product updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data); die;.
            //add product validateions

                $rules = [
                'category_id'=>'required',
                'brand_id'=>'required',
                'product_name'=>'required',
                'product_code'=>'required|regex:/^[\w-]*$/',
                'product_price'=>'required|numeric',
                'product_color'=>'required|regex:/^[\pL\s\-]+$/u',
                'category_image'=>'image',

                ];
                $customMessages=[
                    'category_id.required'=>'category is required',
                    'product_name.required'=>'Product Name is required',
                    'product_code.required'=>'Product Code is required',
                    'product_code.regex'=>'Valid Product Codeis required',
                    'product_price.required'=>'Product price is required',
                    'product_price.numeric'=>'Valid Product Name is required',
                    'product_color.required'=>'Product Color is required',
                    'product_color.regex'=>'Valid Product Color is required',


                ];
                $this->validate($request,$rules,$customMessages);


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

                // upload Product Main Image
                if($request->hasFile('main_image')){
                    $image_tmp = $request->file('main_image');
                    if($image_tmp->isValid()){
                        //get original image name
                        $image_name=$image_tmp->getClientOriginalName();
                        //get image extension
                        $extension =$image_tmp->getClientOriginalExtension();
                        //generate new image
                        $imageName = $image_name.'-'.rand(111,99999).'.'.$extension;
                        //set paths for small,meduim and large images
                        $large_image_path = 'images/product_images/large/'.$imageName;
                        $medium_image_path = 'images/product_images/medium/'.$imageName;
                        $small_image_path = 'images/product_images/small/'.$imageName;
                        Image::make($image_tmp)->save($large_image_path); //W-1040 H-1200
                        //upload image after resize
                        Image::make($image_tmp)->resize(600,450)->save($medium_image_path);
                        Image::make($image_tmp)->resize(300,240)->save($small_image_path);
                        //save image in products table
                        $product->main_image = $imageName;
                    }
                }

                //upload Product Video
                if($request->hasFile('product_video')){
                    $video_tmp=$request->file('product_video');
                        if($video_tmp->isValid()){
                            //upload video
                            $video_name = $video_tmp->getClientOriginalName();
                            $extension = $video_tmp->getClientOriginalExtension();
                            $videoName= $video_name.'-'.rand().'.'.$extension;
                            $video_path = 'videos/product_videos/';
                            $video_tmp->move($video_path,$videoName);
                            //save video in products table
                            $product->product_video = $videoName;
                        }



                }

                //Save Product Details in Products table
                $categoryDetails = Category::find($data['category_id']);
                // echo "<pre>";print_r($categoryDetails); die;
                $product->section_id = $categoryDetails['section_id'];
                $product->category_id =$data['category_id'];
                $product->brand_id =$data['brand_id'];
                $product->product_name  =$data['product_name'];
                $product->product_code =$data['product_code'];
                $product->product_color =$data['product_color'];
                $product->product_price =$data['product_price'];
                $product->product_discount =$data['product_discount'];
                $product->product_weight =$data['product_weight'];
                $product->description =$data['description'];
                // $product->brand =$data['brand'];
                $product->quality =$data['quality'];
                $product->warrenty =$data['warrenty'];
                $product->meta_title  =$data['meta_title'];
                $product->meta_description =$data['meta_description'];
                $product->meta_keywords =$data['meta_keywords'];
                if(!empty($data['is_featured'])){
                    $product->is_featured=$data['is_featured'];
                }else{
                    $product->is_featured="No";
                }


                $product->status = 1;
                $product->save();
                $request->session()->flash('success_message', $message);
                return redirect('admin/products');
                }






        //filter Arrays

        $qualityArray = array('Brandard','Grade A','Grade B');
        $warrentyArray = array('6 Months','1 Year','3 Year');

        //Sections with categories and sub categories
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories),true);
        // echo "<pre>"; print_r($categories); die;

        //get All Brands
        $brands = Brand::where('status',1)->get();
        $brands =json_decode(json_encode($brands),true);

        return view('admin.products.add_edit_product')->with(compact('title','qualityArray','warrentyArray','categories','productdata','brands'));
    }

    public function deleteProductImage($id)
    {
        //get the product image that we want to dlete
        $productImage = Product::select('main_image')->where('id',$id)->first();

        //product Image path
        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';

        //delete product small image from product_images folder if exists
        if(file_exists($small_image_path.$productImage->main_image)){
            unlink($small_image_path. $productImage->main_image);
        }

         //delete product medium image from product_images folder if exists
         if(file_exists($medium_image_path.$productImage->main_image)){
            unlink($medium_image_path. $productImage->main_image);
        }
         //delete product large image from product_images folder if exists
         if(file_exists($large_image_path.$productImage->main_image)){
            unlink($large_image_path. $productImage->main_image);
        }
        //delete product image in databse
        Product::where('id',$id)->update(['main_image'=>'']);
        $message = "Product image has been deleted successfully.!";
        session()->flash('success_message', $message);
        return redirect()->back();
    }

    public function deleteProductVideo($id)
    {
        //get the product video
        $productVideo = Product::select('product_video')->where('id',$id)->first();

        //product videopath
        $video_path = 'videos/product_videos/';


        //delete product small image from product_images folder if exists
        if(file_exists($video_path .$productVideo->product_video)){
            unlink($video_path . $productVideo->product_video);
        }



        //delete product image in databse
        Product::where('id',$id)->update(['product_video'=>'']);
        $message = "Product Video has been deleted successfully.!";
        session()->flash('success_message', $message);
        return redirect()->back();
    }

    public function addAttributes(Request $request,$id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach ($data['sku'] as $key => $value){
                 if(!empty($value)){

                    //sku already exists check
                    $attrCountSKU = ProductsAttribute::where('sku',$value)->count();
                    if($attrCountSKU>0){
                        $message= 'SKU already exists. Please add another SKU!';
                        $request->session()->flash('error_message', $message);
                        return redirect()->back();
                    }
                    //type already exists check
                    $attrCountType = ProductsAttribute::where(['product_id'=>$id,'type'=>$data['type'][$key]])->count();
                    if($attrCountType>0){
                        $message= 'TYPE already exists. Please add another Type!';
                        $request->session()->flash('error_message', $message);
                        return redirect()->back();
                    }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->type = $data['type'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status=1;
                    $attribute->save();

                 }
            }
            $message= 'Product Attributes has been added Successfully!';
            $request->session()->flash('success_message', $message);
        }
        //get data from attribiutes and product relationship
        $productdata= Product::select('id','product_name','product_code','product_color','product_price','main_image')->with('attributes')->find($id);
        $productdata = json_decode(json_encode($productdata),true);
        // echo "<pre>"; print_r($productdata); die;



        $title ="Product Attributes";
        return view('admin.products.add_attributes')->with(compact('productdata','title'));
    }

    public function editAttributes(Request $request,$id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach ($data['attrId'] as $key => $attr) {
                if(!empty($attr)){
                    ProductsAttribute::where(['id'=>$data['attrId'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
                }
            }

        $message = "Product Attributes has been Updated successfully.!";
        session()->flash('success_message', $message);
        return redirect()->back();
        }
    }


    public function updateAttributeStatus(Request $request)
    {
       if($request->ajax()){
           $data=$request->all();
        //    echo "<pre>"; print_r($data); die;
        if($data['status']=="Active"){
            $status=0;
        }else{
            $status=1;
        }
        ProductsAttribute::where('id',$data['attribute_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
       }
    }

    public function updateImageStatus(Request $request)
    {
       if($request->ajax()){
           $data=$request->all();
        //    echo "<pre>"; print_r($data); die;
        if($data['status']=="Active"){
            $status=0;
        }else{
            $status=1;
        }
        ProductsAttribute::where('id',$data['image_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'image_id'=>$data['image_id']]);
       }
    }

    public function deleteAttribute($id)
    {
        //delete Product
        ProductsAttribute::where('id',$id)->delete();
        $message = "Product Attribute has been deleted successfully.!";
        session()->flash('success_message', $message);
        return redirect()->back();
    }

    public function addImages(Request $request, $id)
    {
        if($request->isMethod('post')){
            // $data = $request->all();
            // echo "<pre>"; print_r($data); die; // for testing
            if($request->hasFile('images')){
                $images = $request->file('images');
                // echo "<pre>"; print_r($images); die;
                foreach ($images as $key=>$image) {
                    $productImage= new ProductsImage();
                    $image_tmp=Image::make($image);
                    $extension = $image->getClientOriginalExtension();
                    $imageName=rand(111,999999).time().".".$extension;

                    //set paths for small,meduim and large images
                    $large_image_path = 'images/product_images/large/'.$imageName;
                    $medium_image_path = 'images/product_images/medium/'.$imageName;
                    $small_image_path = 'images/product_images/small/'.$imageName;
                    Image::make($image_tmp)->save($large_image_path); //W-1040 H-1200
                    //upload image after resize
                    Image::make($image_tmp)->resize(600,450)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,240)->save($small_image_path);
                    //save image in products table
                    $productImage->image = $imageName;
                    $productImage->product_id=$id;
                    $productImage->status = 1;
                    $productImage->save();
                }
                $message = "Product Images have been added successfully.!";
                session()->flash('success_message', $message);
                return redirect()->back();
            }
        }

        $productdata = Product::with('images')->select('id','product_name','product_code','product_color','product_price','main_image')->find($id);
        $productdata= json_decode(json_encode($productdata),true);
        // echo "<pre>"; print_r($productdata); die;
        $title="Product Images";
        return view('admin.products.add_images')->with(compact('title','productdata'));
    }

    public function deleteImage($id)
    {
        //get the product image that we want to dlete
        $productImage = ProductsImage::select('image')->where('id',$id)->first();

        //product Image path
        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';

        //delete product small image from product_images folder if exists
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path. $productImage->image);
        }

         //delete product medium image from product_images folder if exists
         if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path. $productImage->image);
        }
         //delete product large image from product_images folder if exists
         if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path. $productImage->image);
        }
        //delete product image in products_images table
        ProductsImage::where('id',$id)->delete();
        $message = "Product image has been deleted successfully.!";
        session()->flash('success_message', $message);
        return redirect()->back();
    }


}
