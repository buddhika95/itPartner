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
              <li class="breadcrumb-item active">Products Attributes</li>
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
        @if(Session::has('error_message'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-top:10px;">
            {{ Session::get('error_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        @endif
        <form name="attributeForm" id="attributeForm"  method="post" action="{{ url('admin/add-attributes/'.$productdata['id']) }}">@csrf

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
                            <label for="product_name">Product Name :  </label> {{ $productdata['product_name'] }}

                        </div>
                        <div class="form-group">
                            <label for="product_code">Product Code :  </label> {{ $productdata['product_code'] }}

                        </div>
                        <div class="form-group">
                            <label for="product_color">Product Color :  </label> {{ $productdata['product_color'] }}

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">

                            <img style="width:120px;" src="{{ asset('images/product_images/small/'.$productdata['main_image']) }}">
                                            &nbsp;
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">

                            <div class="field_wrapper">
                                <div>
                                    <input id="type" name="type[]" type="text"  value="" placeholder="Product Type" style="width:120px;" required/>
                                    <input id="sku" name="sku[]" type="text"  value="" placeholder="Product SKU" style="width:120px;"required/>
                                    <input id="price" name="price[]" type="number"  value="" placeholder="Product Price" style="width:120px;"required/>
                                    <input id="stock" name="stock[]" type="number"  value="" placeholder="Product stock" style="width:120px;"required/>
                                    <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                </div>
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

