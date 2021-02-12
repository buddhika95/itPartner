<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//admin routes
Route::prefix('/admin')->namespace('Admin')->group(function(){
 //all admin routes

    Route::match(['get','post'],'/','AdminController@login');
    Route::group(['middleware'=> ['admin']],function () {

        Route::get('dashboard','AdminController@dashboard');
        Route::get('settings','AdminController@settings');
        Route::get('logout','AdminController@logout');
        Route::post('check-current-pwd','AdminController@chkCurrentPassword');
        Route::post('update-current-pwd','AdminController@updateCurrentPassword');
        Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');

        //Section routes
        Route::get('sections','SectionController@sections');
        Route::post('update-section-status','SectionController@updateSectionStatus');

        //Brands routes
        Route::get('brands','BrandController@brands');
        Route::post('update-brand-status','BrandController@updateBrandStatus');
        Route::match(['get','post'],'add-edit-brand/{id?}','BrandController@addEditBrand');
        Route::get('delete-brand/{id}','BrandController@deleteBrand');

        //categories
        Route::get('categories','categoryController@categories');
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');
        Route::post('append-categories-level','CategoryController@appendCategoryLevel');
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');
        Route::get('delete-category/{id}','CategoryController@deleteCategory');

        //Products Routes
        Route::get('products','ProductController@products');
        Route::post('update-product-status','ProductController@updateProductStatus');
        Route::get('delete-product/{id}','ProductController@deleteProduct');
        Route::match(['get','post'],'add-edit-product/{id?}','ProductController@addEditProduct');
        Route::get('delete-product-image/{id}','ProductController@deleteProductImage');
        Route::get('delete-product-video/{id}','ProductController@deleteProductVideo');

        //Attributes
        Route::match(['get','post'],'add-attributes/{id}','ProductController@addAttributes');
        Route::post('edit-attributes/{id}','ProductController@editAttributes');
        Route::post('update-attribute-status','ProductController@updateAttributeStatus');
        Route::get('delete-attribute/{id}','ProductController@deleteAttribute');

        //add Images
        Route::match(['get','post'],'add-images/{id}','ProductController@addImages');
        Route::post('update-image-status','ProductController@updateImageStatus');
        Route::get('delete-image/{id}','ProductController@deleteImage');

        //Banners
        Route::get('banners','BannersController@banners');
        Route::post('update-banner-status','BannersController@updateBannerStatus');
        Route::get('delete-banner/{id}','BannersController@deleteBanner');

    });
});

//front routes
Route::namespace('Front')->group(function(){
    Route::get('/','IndexController@index');

    });













