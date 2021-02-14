<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }

    public function section(){
        return $this->belongsTo('App\Section','section_id');
    }

    public function brand(){
        return $this->belongsTo('App\Brand','brand_id');
    }

    public function attributes(){
        return $this->hasMany('App\ProductsAttribute');
    }

    public function images()
    {
        return $this->hasMany('App\ProductsImage');
    }

    public static function productFilters(){
        //product filters
       $productFilters['qualityArray'] = array('Brandard','Grade A','Replica');
       $productFilters['warrentyArray'] = array('6 Months','1 Year','2 Years','3 Years');
       $productFilters['freeItemArray'] = array('Free Items','Free Delivery');
        return $productFilters;

    }

    public static function getDiscountedPrice($product_id){
        $proDetails= Product::select('product_price','product_discount','category_id')->where('id',$product_id)->first()->toArray();
        // echo "<pre>"; print_r($proDetails);die;
        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first()->toArray();

        if($proDetails['product_discount']>0){
           //if product discount is added from admin panel
            $discounted_price=$proDetails['product_price'] - ($proDetails['product_price']*$proDetails['product_discount']/100);
            //sale price = costprice-discountprice
        }else if($catDetails['category_discount']>0){
            //if product discount is not added  and category discount added from admin panel
            $discounted_price= $proDetails['product_price']-($proDetails['product_price']*$catDetails['category_discount']/100);
        }else{
            $discounted_price=0;
        }
        return $discounted_price;
    }


}


