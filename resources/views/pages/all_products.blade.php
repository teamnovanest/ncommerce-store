@extends('layouts.store')

@section('content')

 <!-- Body main wrapper start -->
    <div class="">
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Products</h2>
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
			 <li class="brand"><a href="{{url('product/brand/'.$row->id.'/'.$row->brand_name)}}">{{ $row->brand_name }}</a></li>
								@endforeach
								 
							</ul>
                        </div>    
						</div>
							<!--brands  -->
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
                                    <div class="col-lg-3 single__pro col-xl-3 col-md-4 col-6 col-sm-6">
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="{{ url('product/details/'.$pro->id.'/'.$pro->slug) }}">
                                                        <img src="{{ asset($pro->image_one_secure_url) }}" alt="product images">
                                                    </a>
                                                </div>
                                                
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li><a title="Quick View" href="{{ url('product/details/'.$pro->id.'/'.$pro->slug) }}"><span class="ti-plus"></span></a></li>
                                                        <li><a class="addcart" title="Add to cart"  data-id="{{ $pro->id }}"><span class="ti-shopping-cart"></span></a></</li>
                                                        <li><a title="Add to wishlist" class="addwishlist" data-id="{{ $pro->id }}" ><span class="ti-heart"></span></a></li>
                                                    </ul>
                                                </div>
                                               
                                            </div>
                                            <div class="product__details">
                                                <h2 class="product-name"><a href="{{ url('product/details/'.$pro->id.'/'.$pro->slug) }}" tabindex="0">{{ $pro->product_name  }} </a></h2>
                                                <ul class="product__price">
					                                @if($pro->discount_price == NULL)
                                                    <li class="new__price">GH₵ {{ $pro->selling_price / 100 }}</li>
                                                    @else
                                                    <li class="new__price">GH₵ {{ $pro->discount_price / 100}}</li>
                                                    <li class="old__price">GH₵ {{ $pro->selling_price / 100}}</li>
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
                                                <!-- <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu sit amet…</p> -->
                                                <ul class="product__price">
                                                @if($pro-> discount_price == NULL)
                                                <li class="new__price">GH₵ {{ $pro->selling_price / 100 }}</li>
                                                    @else
                                                    <li class="new__price">GH₵ {{ $pro->discount_price / 100}}</li>
                                                    <li class="old__price">GH₵ {{ $pro->selling_price / 100}}</li>
                                                    @endif
                                                </ul>
                                                    <br>
                                                <div class="shop__btn">
                                                    <a class="htc__btn" href="{{ url('product/details/'.$pro->id.'/'.$pro->slug)}}"><span class="ti-plus"></span>View Product</a>
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