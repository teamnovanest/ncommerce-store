@extends('layouts.store')

@section('content')

<div class="">
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-12"> 
                            <div class="bradcaump__inner text-center">
                            @if(isset($cat_name))
                                <h2 class="bradcaump-title">Products <span>/</span>{{$cat_name->category_name }}</h2>                                    
                            @else
                                <h2 class="bradcaump-title">All Products</h2>                                    
                            @endif
                            
                                <!-- <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="/">Home</a>
                                  <span class="brd-separetor">/</span>
                                  <span class="breadcrumb-item active">Product</span>
                                </nav> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Our Product Area -->
        <section class="htc__product__area shop__page ptb--130 bg__white">
            <div class="container">
                <div class="htc__product__container">
                    <!-- Start Product MEnu -->
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="filter__menu__container">
                                <div class="product__menu">
                                    @foreach($category as $cat)
                                    <p class="shop-category"><a href="{{ url('/shop/'.$cat->id.'/'.$cat->category_name.'/products') }}">{{ $cat->category_name }}</a></p>
                               
                                    @endforeach
                                    
                                </div>
                            </div>
                        </div>
                    </div> --}}
                   
                    <!-- End Product MEnu -->
                    <div class="another-product-style">
                        <div class="row">
                            <!-- Start Single Product -->
                             @foreach($allProducts as $row)
                            <div class="col-lg-3 single__pro col-xl-3 col-md-4 col-6 col-sm-6">
                                <div class="product foo">
                                    <div class="product__inner">
                                        <div class="pro__thumb">
                                            <a href="{{ url('product/'.$row->id.'/details/'.$row->slug)}}">
                                                <img src="{{ asset( $row->image_one_secure_url )}}" alt="product images">
                                            </a>
                                        </div>
                                        <div class="product__hover__info">
                                            <ul class="product__action">
                                                <li><a title="Quick view" href="{{ url('product/'.$row->id.'/details/'.$row->slug) }}"><span class="ti-plus"></span></a></li>
                                                 <li><a class="addcart" title="Add to cart"  data-id="{{ $row->id }}"><span class="ti-shopping-cart"></span></a></li>
                                                <li><a title="Add to wishlist" class="addwishlist" data-id="{{ $row->id }}" ><span class="ti-heart"></span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="product__details">
                                        <h2 class="product-name"><a href="{{ url('product/'.$row->id.'/details/'.$row->slug) }}" >{{$row->product_name}}</a></h2>
                                        <div style="background-color:black; color: white;" class="product-name">
                                            <span>{{$row->city_name}}</span>
                                            -
                                            <span>{{$row->region_name}}</span>
                                        </div>
                                        <ul class="product__price">
                                             @if($row->discount_price == NULL)
                                            <li >GH₵ {{number_format($row->selling_price / 100,2)}}</li>
                                              @else
                                              <li class="new__price">GH₵ {{number_format($row->selling_price / 100 - $row->discount_price / 100,2)}}</li>
                                            <li class="old__price">GH₵ {{number_format($row->selling_price / 100,2)}}</li>
                                              @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <!-- End Single Product -->
                        </div>
                    </div>
                    <!-- Start Load More BTn -->
                            <div class="row d-flex justify-content-center">
                                <div class="cols-lg-3">
                                    {{ $allProducts->links() }}
                                </div>
                            </div>
                    <!-- End Load More BTn -->
                </div>
            </div>
        </section>
        <!-- End Our Product Area -->
</div>

@endsection