<?php use App\Product; ?>
@extends('layouts.front_layout.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
        <li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
        <li><a href="{{url('/'.$productDetails['category']['url'])}}">{{ $productDetails['category']['category_name'] }}</a> <span class="divider">/</span></li>
        <li class="active">{{ $productDetails['product_name'] }}</li>
    </ul>
    <div class="row">
        <div id="gallery" class="span3">
            <a href="{{asset('images/product_images/large/'.$productDetails['main_image'])}}" title="{{ $productDetails['product_name'] }}">
                <img src="{{asset('images/product_images/large/'.$productDetails['main_image'])}}" style="width:100%" alt="Blue Casual T-Shirt"/>

            </a>
            <div id="differentview" class="moreOptopm carousel slide">
                <div class="carousel-inner">
                    <div class="item active">
                        @foreach ($productDetails['images'] as $image)
                            <a href="{{asset('images/product_images/large/'.$image['image'])}}"> <img style="width:29%" src="{{asset('images/product_images/large/'.$image['image'])}}" alt=""/></a>
                        @endforeach
                    </div>

                </div>
                <!--
                            <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
                -->
            </div>
            <div class="btn-toolbar">
                <div class="btn-group">
                    <span class="btn"><i class="icon-envelope"></i></span>
                    <span class="btn" ><i class="icon-print"></i></span>
                    <span class="btn" ><i class="icon-zoom-in"></i></span>
                    <span class="btn" ><i class="icon-star"></i></span>
                    <span class="btn" ><i class=" icon-thumbs-up"></i></span>
                    <span class="btn" ><i class="icon-thumbs-down"></i></span>
                </div>
            </div>
        </div>
        <div class="span6">
            @if(Session::has('success_message'))
                <div class="alert alert-success" role="alert" >
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            @endif

            @if(Session::has('error_message'))
                <div class="alert alert-danger " role="alert">
                {{ Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            @endif
            <h3>{{ $productDetails['product_name'] }} </h3>
            <small>- {{ $productDetails['brand']['name'] }}</small>
            <hr class="soft"/>
            <p> {{$total_stock}} items in stock</p>
            <form action="{{ url('add-to-cart') }}" method="post" class="form-horizontal qtyFrm">@csrf
                <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                <div class="control-group">
                    <?php $discounted_price = Product::getDiscountedPrice($productDetails['id']); ?>


                    <h4 class="getAttrPrice">
                        @if($discounted_price>0)
                           <del> Rs. {{ $productDetails['product_price'] }}.00  </del>
                           Rs. {{$discounted_price}}.00
                        @else
                            Rs. {{ $productDetails['product_price'] }}.00
                        @endif
                    </h4>
                        <select name="type" id="getPrice" product-id="{{ $productDetails['id'] }}" class="span2 pull-left" required="">
                            <option value="" selected>Select Warrenty Type</option>
                            @foreach($productDetails['attributes'] as $attribute)
                                <option value="{{$attribute['type']}}">{{$attribute['type']}}</option>
                            @endforeach
                        </select>
                        <input name="quantity" type="number" class="span1" placeholder="Qty." required=""/>
                        <button type="submit" class="btn btn-large btn-primary pull-right"> Add to cart <i class=" icon-shopping-cart"></i></button>
                    </div>
                </div>
            </form>

            <hr class="soft clr"/>
            <p class="span6">
                {{ $productDetails['description'] }}
            </p>
            <a class="btn btn-small pull-right" href="#detail">More Details</a>
            <br class="clr"/>
            <a href="#" name="detail"></a>
            <hr class="soft"/>
        </div>

        <div class="span9">
            <ul id="productDetail" class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab">Product Details</a></li>
                <li><a href="#profile" data-toggle="tab">Related Products</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="home">
                    <h4>Product Information</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="techSpecRow"><th colspan="2">Product Details</th></tr>

                            <tr class="techSpecRow"><td class="techSpecTD1">Brand: </td><td class="techSpecTD2">{{ $productDetails['brand']['name'] }}</td></tr>

                            <tr class="techSpecRow"><td class="techSpecTD1">Code:</td><td class="techSpecTD2">{{ $productDetails['product_code']}}</td></tr>
                            @if(!empty($productDetails['product_color']))
                            <tr class="techSpecRow"><td class="techSpecTD1">Color:</td><td class="techSpecTD2">{{ $productDetails['product_color']}}</td></tr>
                            @endif
                            @if(!empty($productDetails['quality']))
                            <tr class="techSpecRow"><td class="techSpecTD1">Quality:</td><td class="techSpecTD2">{{ $productDetails['quality']}}</td></tr>
                            @endif
                            @if(!empty($productDetails['warrenty']))
                            <tr class="techSpecRow"><td class="techSpecTD1">Warrenty:</td><td class="techSpecTD2">{{ $productDetails['warrenty']}}</td></tr>
                            @endif

                            @if(!empty($productDetails['freeitem']))
                            <tr class="techSpecRow"><td class="techSpecTD1">Free Items:</td><td class="techSpecTD2">{{ $productDetails['freeitem']}}</td></tr>
                            @endif
                        </tbody>
                    </table>

                    <h5>Best Products in the Sri Lanka</h5>
                    <p>100% Guranteed </p>
                    <h5>Best After Service</h5>
                    <p>
                        Friendly after service for the all the products sold by us.
                    </p>
                </div>
                <div class="tab-pane fade" id="profile">
                    <div id="myTab" class="pull-right">
                        <a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
                        <a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
                    </div>
                    <br class="clr"/>
                    <hr class="soft"/>
                    <div class="tab-content">
                        <div class="tab-pane" id="listView">
                            @foreach($relatedProducts as $product)
                            <div class="row">
                                <div class="span2">
                                    <a href="{{ url('product/'.$product['id'])  }}">

                                        @if(isset($product['main_image']))
                                            <?php $product_image_path = 'images/product_images/small/'.$product['main_image']; ?>
                                        @else
                                        <?php $product_image_path = ''; ?>
                                        @endif
                                                    @if(!empty($product['main_image']) && file_exists($product_image_path))
                                                        <img style="width: 250px;" src="{{ asset($product_image_path)}}" alt="">
                                                    @else
                                                    <img style="width: 250px;" src="{{ asset('images/product_images/small/no-image.jpg')}}" alt="">
                                                    @endif
                                </div>
                                <div class="span4">
                                    <h3>{{ $product['product_name'] }}</h3>
                                    <hr class="soft"/>
                                    <h5>{{ $product['product_code'] }} </h5>
                                    <p>
                                        {{ $product['description'] }}
                                    </p>
                                    <a class="btn btn-small pull-right" href="{{ url('product/'.$product['id'])  }}">View Details</a>
                                    <br class="clr"/>
                                </div>
                                <div class="span3 alignR">
                                    <form class="form-horizontal qtyFrm">
                                        <h3> Rs. {{ $product['product_price'] }}</h3>
                                        <label class="checkbox">
                                            <input type="checkbox">  Adds product to compair
                                        </label><br/>
                                        <div class="btn-group">
                                            <a href="product_details.html" class="btn btn-large btn-primary"> Add to <i class=" icon-shopping-cart"></i></a>
                                            <a href="product_details.html" class="btn btn-large"><i class="icon-zoom-in"></i></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <hr class="soft"/>
                            @endforeach

                        </div>
                        <div class="tab-pane active" id="blockView">
                            <ul class="thumbnails">
                                @foreach($relatedProducts as $product)
                                <li class="span3">
                                    <div class="thumbnail">
                                        <a href="product_details.html">
                                            <a href="{{ url('product/'.$product['id'])  }}">

                                                @if(isset($product['main_image']))
                                                    <?php $product_image_path = 'images/product_images/small/'.$product['main_image']; ?>
                                                @else
                                                <?php $product_image_path = ''; ?>
                                                @endif
                                                            @if(!empty($product['main_image']) && file_exists($product_image_path))
                                                                <img style="width: 250px;" src="{{ asset($product_image_path)}}" alt="">
                                                            @else
                                                            <img style="width: 250px;" src="{{ asset('images/product_images/small/no-image.jpg')}}" alt="">
                                                            @endif
                                        </a>
                                        <div class="caption">
                                            <h5>{{ $product['product_name'] }}</h5>
                                            <p>
                                                {{ $product['description'] }}
                                            </p>
                                            <h4 style="text-align:center"><a class="btn" href="{{ url('product/'.$product['id'])  }}"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add<i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs. {{ $product['product_price'] }}</a></h4>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <hr class="soft"/>
                        </div>
                    </div>
                    <br class="clr">
                </div>
            </div>
        </div>
    </div>

@endsection
