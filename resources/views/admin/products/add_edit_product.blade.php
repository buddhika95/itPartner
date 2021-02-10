@extends('layouts.admin_layout.admin_layout')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Catalogues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @if ($errors->any())
        <div class="alert alert-danger" style="margin-top:10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(Session::has('flash_message_success'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:10px;">
                {{ Session::get('flash_message_success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            @endif
            @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:10px;">
            {{ Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        @endif
        <form name="productForm" id="ProductForm" @if(empty($productdata['id'])) action="{{ url('admin/add-edit-product') }}" @else action="{{ url('admin/add-edit-product/'.$productdata['id']) }}" @endif method="post" enctype="multipart/form-data">@csrf
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Select Category</label>
                        <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;">
                          <option value="">Select</option>
                            @foreach ($categories as $section)
                                <optgroup label="{{ $section['name'] }}"></optgroup>
                                @foreach ($section['categories'] as $category)
                                    <option value="{{ $category['id'] }}" @if(!empty(@old('category_id')) && $category['id']==old('category_id')) selected="" @elseif(!empty($productdata['category_id']) && $productdata['category_id']==$category['id']) selected=""@endif>
                                        &nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{ $category['category_name'] }}</option>
                                    @foreach ($category['subcategories'] as $subcategory)
                                        <option value="{{ $subcategory['id'] }}"@if(!empty(@old('category_id')) && $subcategory['id']==old('category_id')) selected=""@elseif(!empty($productdata['category_id']) && $productdata['category_id']==$subcategory['id']) selected=""@endif>>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Brand</label>
                        <select name="brand_id" id="brand_id" class="form-control select2" style="width: 100%;">
                          <option value="">Select</option>
                          @foreach ($brands as $brand)
                            <option value="{{ $brand['id'] }}" @if(!empty($productdata['brand_id']) && $productdata['brand_id']==$brand['id']) selected="" @endif>{{ $brand['name'] }}</option>
                          @endforeach
                        </select>
                    </div>
                  <div class="form-group">
                      <label for="product_name">Product Name</label>
                      <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter Product Name" @if(!empty($productdata['product_name'])) value="{{ $productdata['product_name'] }}" @else value="{{ old('product_name') }}" @endif>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_code">Product Code</label>
                        <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Enter Product Code" @if(!empty($productdata['product_code'])) value="{{ $productdata['product_code'] }}" @else value="{{ old('product_code') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="product_color">Product Color</label>
                        <input type="text" class="form-control" name="product_color" id="product_color" placeholder="Enter Product color" @if(!empty($productdata['product_color'])) value="{{ $productdata['product_color'] }}" @else value="{{ old('product_color') }}" @endif>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_code">Product Price</label>
                        <input type="text" class="form-control" name="product_price" id="product_price" placeholder="Enter Product price" @if(!empty($productdata['product_price'])) value="{{ $productdata['product_price'] }}" @else value="{{ old('product_price') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="product_discount">Product Discount (%)</label>
                        <input type="text" class="form-control" name="product_discount" id="product_discount" placeholder="Enter Product discount" @if(!empty($productdata['product_discount'])) value="{{ $productdata['product_discount'] }}" @else value="{{ old('product_discount') }}" @endif>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_weight">Product Weight</label>
                        <input type="text" class="form-control" name="product_weight" id="product_weight" placeholder="Enter Product weight" @if(!empty($productdata['product_weight'])) value="{{ $productdata['product_weight'] }}" @else value="{{ old('product_weight') }}" @endif>
                    </div>
                  <div class="form-group">
                      <label for="main_image">Product Main Image</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="main_image" id="main_image" >
                          <label class="custom-file-label" for="main_image">Choose file</label>
                        </div>
                        <div class="input-group-append">
                          <span class="input-group-text" id="">Upload</span>
                        </div>
                      </div>
                      <div>Recommended Image Size : Width:1040px, Height:1200px</div>
                        @if(!empty($productdata['main_image']))
                            <div> <img style="width:80px; margin-top:5px;" src="{{ asset('images/product_images/small/'.$productdata['main_image']) }}">
                                    &nbsp;
                                    <a class="confirmDelete" href="javascript:void(0)" record="product-image" recordid="{{$productdata['id']}}" >Delete Image </a>
                            </div>
                        @endif

                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="product_video">Product Video</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="product_video" name="product_video">
                            <label class="custom-file-label" for="product_video">Choose file</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text" id="">Upload</span>
                          </div>

                        </div>
                        @if(!empty($productdata['product_video']))
                        <div><a href="{{ url('videos/product_videos/'.$productdata['product_video']) }}" download>Download</a>&nbsp;|&nbsp;
                            <a class="confirmDelete" href="javascript:void(0)" record="product-video" recordid="{{$productdata['id']}}" >Delete video </a>
                        </div>
                        @endif
                    </div>
                  <div class="form-group">
                      <label for="product_description">
                          product Description</label>
                      <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter ..." >@if(!empty($productdata['description'])) {{ $productdata['description'] }} @else {{ old('description') }} @endif</textarea>
                  </div>
                </div>
                <div class="col-12 col-sm-6">


                    <div class="form-group">
                        <label for="product_name">Meta Titile</label>
                        <textarea name="meta_title" id="meta_title" class="form-control" rows="3" placeholder="Enter ..." >@if(!empty($productdata['meta_title'])) {{ $productdata['meta_title'] }} @else {{ old('meta_title') }} @endif</textarea>
                    </div>
                    <div class="form-group">
                        <label for="product_name">Meta Keywords</label>
                        <textarea name="meta_keywords" name="meta_keywords" class="form-control" rows="3" placeholder="Enter ..."> @if(!empty($productdata['meta_keywords'])) {{ $productdata['meta_keywords'] }} @else {{ old('meta_keywords') }} @endif</textarea>
                    </div>
                </div>
                <div class="col-12 col-sm-6">

                    <div class="form-group">
                        <label>Select Quality</label>
                        <select name="quality" id="quality" class="form-control select2" style="width: 100%;">
                          <option value="">Select</option>
                          @foreach ($qualityArray as $quality)
                            <option value="{{ $quality }}" @if(!empty($productdata['quality']) && $productdata['quality']==$quality ) selected="" @endif>{{ $quality }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Warrenty</label>
                        <select name="warrenty" id="warrenty" class="form-control select2" style="width: 100%;">
                          <option value="">Select</option>
                          @foreach ($warrentyArray as $warrenty)
                            <option value="{{ $warrenty }}" @if(!empty($productdata['warrenty']) && $productdata['warrenty']==$warrenty ) selected="" @endif>{{ $warrenty }}</option>
                          @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="product_name">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="Enter ..." >@if(!empty($productdata['meta_description'])) {{ $productdata['meta_description'] }} @else{{ old('meta_description') }} @endif</textarea>
                    </div>
                    <div class="form-group">
                        <label for="product_name">Featured Item</label>
                        <input type="checkbox" name="is_featured" id="is_featured" value="Yes" @if(!empty($productdata['is_featured']) && $productdata['is_featured']=="Yes") checked="" @endif>
                    </div>
                  </div>
            </div>


              </div>
            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection

