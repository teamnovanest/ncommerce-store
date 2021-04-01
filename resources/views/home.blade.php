@extends ('layouts.store')

@section ('content')

<section class="categories-slider-area bg__white">
            <div class="container">
                <div class="row">
                    <!-- Start Left Feature -->
                    <div class="col-lg-3 col-xl-3 col-md-4 col-12">
                        <div class="categories-menu">
                            <div class="category-heading">
                               <h3> Browse Categories</h3>
                            </div>
                        <div class="category-menu-list">
                         <ul>
                     @php
$category = DB::table('category')->get();
   @endphp

            
            @foreach($category as $cat)
            <li>
                <a href="{{ url('allcategory/'.$cat->id) }}">{{ $cat->category_name }}<i class="zmdi zmdi-chevron-right"></i></a>
                <ul>

    @php
  $subcategory = DB::table('subcategory')->where('category_id',$cat->id)->get();
    @endphp

    <div class="category-menu-dropdown">
        <div class="category-part-1 category-common mb--30">
                  @foreach($subcategory as $row)
                  <ul>
                    <li>
                        <a href="{{ url('products/'.$row->id) }}">{{ $row->subcategory_name }}<i class="fas fa-chevron-right"></i></a>
                   
                    </li>
                </ul>
                    @endforeach
                    
                </ul>
            </li>
            @endforeach
            </ul>
            </div>
            </div>
            </div>
                        <!-- </div> -->
                    <!-- End Left Feature -->
                    <div class="col-lg-9 col-xl-9 col-md-8 col-12">
                        <!-- Start Slider Area -->
                        <div class="slider__container slider--one mrg-xs">
                            <div class="slider__activation__wrap owl-carousel owl-theme">
                                <!-- Start Single Slide -->
                                <div class="slide slider__full--screen slider-height-inherit  slider-text-left" style="background:rgba(0, 0, 0, 0) no-repeat scroll center center / cover ;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-8 col-xl-8 col-md-12 col-12">
                                                <div class="slider__inner">
                                                    <h1>New Product <span class="text--theme">Collection</span></h1>
                                                    <div class="slider__btn">
                                                        <a class="htc__btn" href="cart.html">shop now</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Start Slider Area -->
                    </div>
                </div>
            </div>
        </section>
        <!-- End Feature Product -->

        <!-- Start Our Product Area -->
        <section class="htc__product__area ptb--130 bg__white">
            <div class="container">
                <div class="htc__product__container">
                    <!-- Start Product MEnu -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <div class="product__menu">
                                <button data-filter="*"  class="is-checked">All</button>
                                <button data-filter=".cat--1">Furnitures</button>
                                <button data-filter=".cat--2">Bags</button>
                                <button data-filter=".cat--3">Decoration</button>
                                <button data-filter=".cat--4">Accessories</button>
                            </div> -->
                        </div>
                    </div>
                    <!-- End Product MEnu -->
                    <div class="product__list another-product-style ">
                        <div class="row">
                        
                             @foreach($featured as $row)
                            <!-- Start Single Product -->
                            <div class="col-lg-3 single__pro col-xl-3 cat--1 col-md-4 col-sm-6 col-12">
                                <div class="product foo">
                                    <div class="product__inner">
                                        <div class="pro__thumb">
                                            <a href="{{ url('product/details/'.$row->id)}}">
                                                <img src="{{ asset( $row->image_one_secure_url )}}" alt="product images">
                                            </a>
                                        </div>
                                         <div class="product__hover__info">
                                            <ul class="product__action">
                                                <li><a title="Quick view" href="{{ url('/product/details/'.$row->id) }}"><span class="ti-plus"></span></a></li>
                                                <li><a title="Add to cart" href="{{ route('show.cart')}}"><span class="ti-shopping-cart"></span></a></</li>
                                                <li><a title="Add to wishlist" class="addwishlist" data-id="{{ $row->id }}" ><span class="ti-heart"></span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product__details">
                                        <h2><a href="product-details.html">{{$row->product_name}} </a></h2>
                                        <ul class="product__price">
                                             @if($row->discount_price == NULL)
                                            <li >GH₵ {{$row->selling_price }}</li>
                                              @else
                                              <li class="new__price">GH₵ {{$row->discount_price }}</li>
                                            <li class="old__price">GH₵ {{$row->selling_price }}</li>
                                              @endif
                                        </ul>
                                       
                                    </div>
                                </div>
                            </div>
                             @endforeach   

                        </div>
                    </div>
                </div>
            </div>
        </section>














@endsection