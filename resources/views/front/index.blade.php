<?php use App\Product; ?>
@extends('layouts.front_layout.front_layout')
@section('content')

<div class="span9">
    <div class="well well-small">
        <h4>Featured Products <small class="pull-right">{{ $featuredItemsCount}} featured products</small></h4>
        <div class="row-fluid">
            <div id="featured" @if($featuredItemsCount>4) class="carousel slide" @endif>
                <div class="carousel-inner">
                    @foreach($featuredItemsChunk as $key => $featuredItem)

                    <div class="item @if($key==1) active @endif">
                        <ul class="thumbnails">
                            @foreach($featuredItem as $item)
                            <li class="span3">
                                <div class="thumbnail" style="height: 290px;" >
                                    <i class="tag"></i>
                                    <a href="{{ url('product/'.$item['id'])  }}">
                                        <?php $product_image_path = 'images/product_images/small/'.$item['main_image']; ?>
                                        @if(!empty($item['main_image']) && file_exists($product_image_path))
                                            <img style="width: 160px;" src="{{ asset($product_image_path)}}" alt="">
                                        @else
                                        <img style="width: 160px;" src="{{ asset('images/product_images/small/no-image.jpg')}}" alt="">
                                        @endif
                                    </a>
                                    <div class="caption">
                                        <h5>{{ $item['product_name']}}</h5>
                                        <?php $discounted_price = Product::getDiscountedPrice($item['id']); ?>
                                        <h5><a class="btn" href="product_details.html">VIEW</a><br>
                                            <span class="pull-center" style="font-size: 14px;">
                                                @if($discounted_price>0)
                                                    <del>Rs.{{ $item['product_price']}}</del>
                                                    <font color="red">Rs. {{ $discounted_price }}</font>
                                                @else
                                                    Rs.{{ $item['product_price']}}


                                                @endif


                                            </span></h5>


                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    @endforeach
                </div>
                {{-- <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#featured" data-slide="next">›</a> --}}
            </div>
        </div>
    </div>
    <h4>Latest Products </h4>
    <ul class="thumbnails">
        @foreach($newProducts as $products)
            <li class="span3">
                <div class="thumbnail" style="height: 286px;">
                    <a  href="{{ url('product/'.$products['id'])  }}"><?php $product_image_path = 'images/product_images/small/'.$products['main_image']; ?>
                        @if(!empty($products['main_image']) && file_exists($product_image_path))
                            <img style="width: 160px;" src="{{ asset($product_image_path)}}" alt="">
                        @else
                            <img style="width: 160px;" src="{{ asset('images/product_images/small/no-image.jpg')}}" alt="">
                        @endif
                    </a>
                    <div class="caption">
                        <h5>{{ $products['product_name'] }}</h5>
                        <p>
                            {{-- {{ $products['product_color'] }} --}}
                        </p>
                        <?php $discounted_price = Product::getDiscountedPrice($products['id']); ?>

                        <h4 style="text-align:center">
                            {{-- <a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a>--}}
                            <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a>
                            <a class="btn btn-primary" href="#">
                                @if($discounted_price>0)
                                  <del> Rs.{{ $products['product_price'] }}</del>
                                  <font color="yellow">Rs.{{ $discounted_price }}</font>
                                @else
                                    {{ $products['product_price'] }}
                                @endif
                            </a></h4>
                        {{-- @if($discounted_price>0)
                            <h5><font color="red"> Discounted Price:Rs. {{ $discounted_price }}</font></h5>
                        @endif --}}

                    </div>
                </div>
            </li>
        @endforeach

    </ul>
</div>
@endsection
