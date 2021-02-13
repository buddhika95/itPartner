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
}


