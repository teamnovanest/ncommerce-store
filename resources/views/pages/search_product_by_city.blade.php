@extends('layouts.store')

@section('content')

    <div>
        <div class="ht__bradcaump__area">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Products In {{$city->city_name}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area --> 
        <!-- Start Our ShopSide Area -->
        <section class="htc__shop__sidebar bg__white ptb--120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-12 col-12">
                        <div class="htc__shop__left__sidebar">
                              <!-- Start Product Cat -->
                            <div class="categories-menu">
                                <div class="category-heading">
                               <h3>Product Categories</h3>
                                   </div>
                            <div class="category-menu-list"> 
                                <ul class="sidebar__list">
                                         @php
                                         $category = DB::table('category_options')->where('deleted_at', NULL)->get();
                                            @endphp
                                    @foreach($category as $cat)
				                    <li><a href="{{ route('category.name',['id'=>$cat->id,'category_name'=> $cat->category_name]) }}">{{ $cat->category_name }}</a></li>
								    @endforeach
                                </ul>
                            </div>    
                        </div>
                        <br>
                            <!-- End Product Cat -->
							<!-- brands -->
						 <div class="categories-menu">
                                <div class="category-heading">
                               <h3>Brands</h3>
                                </div>
                            <div class="category-menu-list"> 
                            <ul class="sidebar__list">
								
                            @php
                            $brands =  DB::table('brand_options')->where('deleted_at', NULL)->get();
                            @endphp
							@foreach($brands as $row)
			                <li class="brand"><a href="{{ url('product/brand/'.$row->id.'/'.$row->brand_name) }}">{{ $row->brand_name }}</a></li>
								@endforeach
								 
							</ul>
                        </div>    
						</div>
							<!--brands  -->
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-12 col-12 smt-30">
                        <div class="row">
                            <div class="col-lg-12 col-xl-12 col-md-12 col-12">
                                <div class="producy__view__container">
                                     <!-- Start Short Form -->
                                    <div class="product__list__option">
                                        <!-- <div class="order-single-btn">
                                            <select class="select-color selectpicker">
                                              <option>Sort by newness</option>
                                              <option>Match</option>
                                              <option>Updated</option>
                                              <option>Title</option>
                                              <option>Category</option>
                                              <option>Rating</option>
                                            </select>
                                        </div>
                                        <div class="shp__pro__show">
                                            <span>Showing 1 - 4 of 25 results</span>
                                        </div> -->
                                    </div>
                                    <!-- End Short Form -->
                                    <!-- Start List And Grid View -->
                                    <ul class="view__mode nav" role="tablist">
                                        <li role="presentation" class="grid-view"><a class="active" href="#grid-view" role="tab" data-toggle="tab"><i class="zmdi zmdi-grid"></i></a></li>
                                        <li role="presentation" class="list-view"><a href="#list-view" role="tab" data-toggle="tab"><i class="zmdi zmdi-view-list"></i></a></li>
                                    </ul>
                                    <!-- End List And Grid View -->
                                </div>
                            </div>
                        </div>
                        <div class="shop__grid__view__wrap another-product-style">
                            <!-- Start Single View -->
                            <div role="tabpanel" id="grid-view" class="single-grid-view tab-pane fade show active clearfix">
                                <div class="row">
                                    <!-- Start Single Product -->
                                    @foreach ($products as $product)
                                    <div class="col-lg-3 single__pro col-xl-3 col-md-4 col-6 col-sm-6">
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="{{url('product/details/'.$product->id.'/'.$product->slug)}}">
                                                        <img src="{{ asset($product->image_one_secure_url) }}" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li><a title="Quick View" href="{{ url('product/details/'.$product->id.'/'.$product->slug) }}"><span class="ti-plus"></span></a></li>
                                                        <li><a class="addcart" title="Add to cart"  data-id="{{ $product->id }}"><span class="ti-shopping-cart"></span></a></</li>
                                                        <li><a title="Add to wishlist" class="addwishlist" data-id="{{ $product->id }}" ><span class="ti-heart"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2 class="product-name"><a href="{{ url('product/details/'.$product->id.'/'.$product->slug) }}" tabindex="0">{{ $product->product_name  }} </a></h2>
                                                
                                                <div style="background-color:black; color: white;" class="product-name">
                                                <span>{{$product->region_name}}</span>
                                                -
                                                <span>{{$product->city_name}}</span>
                                                </div>
                                                
                                                <ul class="product__price">
                                                    @if($product->discount_price == NULL)
                                                    <li>GH₵ {{number_format($product->selling_price/ 100 ,2) }}</li>
                                                    @else
                                                    <li class="new__price">GH₵
                                                        {{number_format($product->selling_price /100 - $product->discount_price / 100 ,2) }}</li>
                                                    <li class="old__price">GH₵ {{number_format($product->selling_price / 100 ,2) }}</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <!-- End Single Product -->
                                </div>
                            </div>
                            <!-- End Single View -->
                             <!-- Start Single View -->
                            <div role="tabpanel" id="list-view" class="single-grid-view tab-pane fade clearfix">
                                <!-- Start List Content-->
                                    @foreach($products as $pro)
                                <div class="single__list__content clearfix">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-4 col-xl-3 col-sm-5 col-12">
                                            <div class="list__thumb">
                                                <a href="{{ url('product/details/'.$pro->id.'/'.$pro->slug) }}">
                                                    <img src="{{ asset($pro->image_one_secure_url) }}" alt="Product Image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-8 col-xl-9 col-sm-7 col-12">
                                            <div class="list__details__inner">
                                                <h2 class="product-name"><a href="{{ url('product/details/'.$pro->id.'/'.$pro->slug) }}" tabindex="0">{{ $pro->product_name  }} </a></h2>
                                                
                                                <div style="background-color:black; color: white; width: 30%;" class="product-name">
                                                <span>{{$pro->region_name}}</span>
                                                -
                                                <span>{{$pro->city_name}}</span>
                                                </div>
                                                
                                                
                                                <ul class="product__price">
                                                   @if($pro->discount_price == NULL)
                                                    <li>GH₵ {{number_format($pro->selling_price/ 100 ,2) }}</li>
                                                    @else
                                                    <li class="new__price">GH₵
                                                        {{number_format($pro->selling_price /100 - $pro->discount_price / 100 ,2) }}</li>
                                                    <li class="old__price">GH₵ {{number_format($pro->selling_price / 100 ,2) }}</li>
                                                    @endif
                                                </ul>
                                                    <br>
                                                <div class="shop__btn">
                                                    <a class="htc__btn" href="{{ url('product/details/'.$pro->id.'/'.$pro->slug) }}"><span class="ti-plus"></span>View Product</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        @endforeach
                                <!-- End List Content-->
                            </div>
                            <!-- End Single View -->

                            <div class="row d-flex justify-content-center">
                                <div class="cols-lg-3">
                                    {{ $products->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        </section>
        <!-- End Our ShopSide Area -->
@endsection