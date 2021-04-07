@extends('layouts.store')

@section('content')

 <!-- Body main wrapper start -->
    <div class="">
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">All Products</h2>
                                <!-- <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="/">Home</a>
                                  <span class="brd-separetor">/</span>
                                  <span class="breadcrumb-item active">All Products</span>
                                </nav> -->
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
						  <!-- Start Product Cat -->
                        <div class="htc__shop__cat">
                                <h4 class="section-title-4">PRODUCT CATEGORIES</h4>
                                <ul class="sidebar__list">
                                         @php
                                         $category = DB::table('categories')->get();
                                            @endphp
                                    @foreach($category as $cat)
				                    <li><a href="{{ url('allcategory/'.$cat->id) }}">{{ $cat->category_name }}</a></li>
								    @endforeach
                                </ul>
                        </div>
                            <!-- End Product Cat -->
							<!-- brands -->
						<div class="sidebar_section">
							<div class="sidebar_subtitle brands_subtitle">Brands</div>
							<ul class="brands_list">
								
                            @php
                           $brands =  DB::table('brand_options')->get();
                            @endphp
								@foreach($brands as $row)
			 <li class="brand"><a href="#">{{ $row->brand_name }}</a></li>
								@endforeach
								 
							</ul>
						</div>
							<!--brands  -->
                        <div class="htc__shop__left__sidebar">
                            <!-- Start Range -->
                            <div class="htc-grid-range">
                                <h4 class="section-title-4">FILTER BY PRICE</h4>
                                <div class="content-shopby">
                                    <div class="price_filter s-filter clear">
                                        <form action="#" method="GET">
                                            <div id="slider-range"></div>
                                            <div class="slider__range--output">
                                                <div class="price__output--wrap">
                                                    <div class="price--output">
                                                        <span>Price :</span><input type="text" id="amount" readonly>
                                                    </div>
                                                    <div class="price--filter">
                                                        <a href="#">Filter</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Range -->
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-12 col-12 smt-30">
                        <div class="row">
                            <div class="col-lg-12 col-xl-12 col-md-12 col-12">
                                <div class="producy__view__container">
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
                                         @foreach($products as $pro)
                                    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-6 col-12">
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="{{ url('product/details/'.$pro->id) }}">
                                                        <img src="{{ asset($pro->image_one_secure_url) }}" alt="product images">
                                                    </a>
                                                </div>
                                                
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li><a title="Quick View" href="{{ url('product/details/'.$pro->id) }}"><span class="ti-plus"></span></a></li>
                                                        <li><a title="Add To Cart" href="{{ route('show.cart')}}"><span class="ti-shopping-cart"></span></a></li>
                                                        <li><a title="Wishlist" href="#"><span class="ti-heart"></span></a></li>
                                                    </ul>
                                                </div>
                                               
                                            </div>
                                            <div class="product__details">
                                                <h2><a href="{{ url('product/details/'.$pro->id.'/'.$pro->product_name) }}" tabindex="0">{{ $pro->product_name  }} </a></h2>
                                                <ul class="product__price">
					                                @if($pro->discount_price == NULL)
                                                    <li class="new__price">GH₵ {{ $pro->selling_price }}</li>
                                                    @else
                                                    <li class="new__price">GH₵ {{ $pro->discount_price }}</li>
                                                    <li class="old__price">GH₵ {{ $pro->selling_price }}</li>
                                                    @endif
                                                </ul>
																		 <ul class="product_marks">
       @if($pro->discount_price == NULL)
       <li class="product_mark product_new" style="background: blue;">New</li>
       @else
                       <li class="product_mark product_new" style="background: red;">
                       @php
                         $amount = $pro->selling_price - $pro->discount_price;
                         $discount = $amount/$pro->selling_price*100;

                       @endphp
                       
                       {{ intval($discount) }}%

                      </li>  
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
                                                <a href="product-details.html">
                                                    <img src="{{ asset($pro->image_one_secure_url) }}" alt="Product Image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-8 col-xl-9 col-sm-7 col-12">
                                            <div class="list__details__inner">
                                                <h2><a href="{{ url('product/details/'.$pro->id.'/'.$pro->product_name) }}" tabindex="0">{{ $pro->product_name  }} </a></h2>
                                                <!-- <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu sit amet…</p> -->
                                                <ul class="product__price">
                                                @if($pro-> discount_price == NULL)
                                                <li class="new__price">GH₵ {{ $pro->selling_price }}</li>
                                                    @else
                                                    <li class="new__price">GH₵ {{ $pro->discount_price }}</li>
                                                    <li class="old__price">GH₵ {{ $pro->selling_price }}</li>
                                                    @endif
                                                </ul>
							                    <ul class="product_marks">
                                                       @if($pro->discount_price == NULL)
                                                    <li class="product_mark product_new" style="background: blue;">New</li>
                                                       @else
                                                    <li class="product_mark product_new" style="background: red;">
                                                       @php
                                                            $amount = $pro->selling_price - $pro->discount_price;
                                                            $discount = $amount/$pro->selling_price*100;

                                                       @endphp
                       
                                                       {{ intval($discount) }}%

                                                    </li>  
                                                       @endif     
                                                </ul>
                                                    <br>
                                                <div class="shop__btn">
                                                    <a class="htc__btn" href="{{ url('product/details/'.$pro->id)}}"><span class="ti-plus"></span>View Product</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        @endforeach
                                <!-- End List Content-->
                            </div>
                            <!-- End Single View -->
							<!-- Shop Page Navigation -->
                        <br>
						<div class="shop_page_nav d-flex flex-row">
							 
							 
                               {{ $products->links() }}
							  
							 
						</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Our ShopSide Area -->
        <!-- Start Footer Area -->

<script type="text/javascript">
    function productview(id){
        $.ajax({
         url: "{{ url('/cart/product/view/') }}/"+id, 
         type: "GET",
         dataType:"json",
         success:function(data){
       $('#pcode').text(data.product.product_code);
       $('#pcat').text(data.product.category_name);
       $('#psub').text(data.product.subcategory_name);
       $('#pbrand').text(data.product.brand_name);
       $('#pname').text(data.product.product_name);
       $('#pimage').attr('src',data.product.image_one_secure_url);
       $('#product_id').val(data.product.id);

       var d = $('select[name="color"]').empty();
       $.each(data.color,function(key,value){
       $('select[name="color"]').append('<option value="'+value+'">'+value+'</option>'); 
        });

          var d = $('select[name="size"]').empty();
       $.each(data.size,function(key,value){
       $('select[name="size"]').append('<option value="'+value+'">'+value+'</option>'); 
        });


         }  
        })
    }


</script>
@endsection