<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = "categories";
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

    public static function catDetails($url)
    {
        $catDetails = Category::select('id','parent_id','category_name','url','description')->with(['subcategories'=>
            function($query){
                $query->select('id','parent_id','category_name','url','description')->where('status',1);

        }])->where('url',$url)->first()->toArray();
        // dd($catDetails);
        if($catDetails['parent_id']==0){
            //only show main category in breadcrumb
            $breadcrumbs = '<a href="'.url($catDetails['url']).'">'.$catDetails['category_name'].'</a>';
        }else{
            //show main and sub category in breadcrumb
            $parentcategory = Category::select('category_name','url')->where('id',$catDetails['parent_id'])->first()->toArray();
            $breadcrumbs = '<a href="'.url($parentcategory['url']).'">'.$parentcategory['category_name'].'</a>&nbsp; <span class="divider">/ &nbsp;<a href="'.url($catDetails['url']).'">'.$catDetails['category_name'].'</a>';
        }

        $catIds = array();
        $catIds[] =$catDetails['id'];

        foreach ($catDetails['subcategories'] as $key => $subcat) {
            $catIds[] = $subcat['id'];
        }
        // dd($catIds); die;
        return array('catIds'=>$catIds,'catDetails'=>$catDetails,'breadcrumbs'=>$breadcrumbs);
    }

}
