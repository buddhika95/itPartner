<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category_image'];

    public function subcategories(){
        return $this->hasMany('App\Category','parent_id')->where('status',1);
    }
    //relation to section table to get section
    public function section()
    {
        return $this->belongsTo('App\Section','section_id')->select('id','name');
    }
    // relation to get parent_id and name
    public function parentcategory()
    {
        return $this->belongsTo('App\Category','parent_id')->select('id','category_name');
    }

    public static function categoryDetails($url)
    {
        $categoryDetails = Category::select('id','category_name','url')->with(['subcategories'=>
        function($query){
            $query->select('id','parent_id')->where('status',1);
        }])->where('url',$url)->first()->toArray();
        // dd($categoryDetails); die;
        $catIds=array();
        $catIds[]=$categoryDetails['id'];
        foreach($categoryDetails['subcategories'] as $key =>$subcat ){
            $catIDs = $subcat['id'];
        }
        // dd($catIds);die;
        return array('catIds'=>$catIds,'categoryDetails'=>$categoryDetails);
    }

}
