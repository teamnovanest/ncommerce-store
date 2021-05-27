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

                            @foreach($category as $cat)
                            <li>
                                <a
                                    href="{{route('category.name',['id'=>$cat->id,'category_name'=> $cat->category_name]) }}">{{ $cat->category_name }}<i
                                        class="zmdi zmdi-chevron-right"></i></a>
                                <ul>

                                    @php
                                    $subcategory = DB::table('subcategory_options')
                                    ->join('category_options','subcategory_options.category_id','=','category_options.id')
                                    ->select('subcategory_options.*','category_options.category_name')
                                    ->where('subcategory_options.category_id',$cat->id)->where('subcategory_options.deleted_at',
                                    NULL)->get();
                                    @endphp

                                    <div class="category-menu-dropdown">
                                        <div class="category-part-1 category-common mb--30">
                                            @foreach($subcategory as $row)
                                            <ul>
                                                <li>
                                                    <a
                                                        href="{{ url($row->category_name.'/'.$row->id.'/'.$row->subcategory_name) }}">{{ $row->subcategory_name }}<i
                                                            class="fas fa-chevron-right"></i></a>

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
            <div class="col-lg-9 col-xl-9 col-md-8 col-12">
                <!-- Start Slider Area -->
                <div class="slider__container slider--one mrg-xs" id="advertIndicators">
                    <ol class="carousel-indicators">
                    @foreach( $publicity as $image )
                        <li data-target="#advertIndicators" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                    </ol>

                    <div class="slider__activation__wrap owl-carousel owl-theme">
                            <!-- Start Single Slide -->
                            @if (sizeof($publicity) > 0) 
                            @foreach( $publicity as $image )
                            @if ($image->start_date <= date(now()) && $image->end_date > date(now()))
                            <div class="item {{ $loop->first ? ' active' : '' }}" >
                                <img src="{{ $image->image_secure_url }}" alt="">
                            </div>
                            @endif
                            @endforeach
                            @else
                                <div>
                                    <img src="{{'assets\img\c.jpg'}}">
                                </div>
                            @endif

                        <!-- End Single Slide -->
                    </div>
                </div>
            <!-- Start Slider Area -->
            </div>
    </div>
    </div>
</section>
<!-- End Feature Product -->

<!-- Start Our Product Area -->
<section class="htc__product__area ptb--10 bg__white">
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
            <div class="another-product-style ">
                <div class="row">

                    @foreach($featured as $row)
                    <!-- Start Single Product -->
                    <div class="col-lg-3 single__pro col-xl-3 cat--1 col-md-4 col-sm-6 col-6">
                        <div class="product foo">
                            <div class="product__inner">
                                <div class="pro__thumb">
                                    <a href="{{ url('product/details/'.$row->id.'/'.$row->slug)}}">
                                        <img src="{{ asset( $row->image_one_secure_url )}}" alt="product images">
                                    </a>
                                </div>
                                <div class="product__hover__info">
                                    <ul class="product__action">
                                        <li><a title="Quick view"
                                                href="{{ url('/product/details/'.$row->id.'/'.$row->slug) }}"><span
                                                    class="ti-plus"></span></a></li>
                                        <li><a class="addcart" title="Add to cart" data-id="{{ $row->id }}"><span
                                                    class="ti-shopping-cart"></span></a></</li> <li><a
                                                title="Add to wishlist" class="addwishlist"
                                                data-id="{{ $row->id }}"><span class="ti-heart"></span></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product__details">
                                <h2 class="product-name"><a
                                        href="{{ url('/product/details/'.$row->id.'/'.$row->slug) }}">{{$row->product_name}}
                                    </a></h2>
                                <ul class="product__price">
                                    @if($row->discount_price == NULL)
                                    <li>GH₵ {{number_format($row->selling_price,2) }}</li>
                                    @else
                                    <li class="new__price">GH₵
                                        {{number_format($row->selling_price - $row->discount_price,2) }}</li>
                                    <li class="old__price">GH₵ {{number_format($row->selling_price,2) }}</li>
                                    @endif
                                </ul>

                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        <div class="links-pagination">
            <div class="center-pagination">
                {{ $featured->links() }}
            </div>
        </div>
    </div>
</section>

@endsection
