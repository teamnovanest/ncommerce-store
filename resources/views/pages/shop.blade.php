@extends('layouts.store')

@section('content')

<div class="">
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(paper.gif) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-12"> 
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Products</h2>
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
            <div class="container-fluid">
                <div class="htc__product__container">
                    <!-- Start Product MEnu -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="filter__menu__container">
                                <div class="product__menu">
                                    @php
                                    $category = DB::table('category_options')->get();
                                    @endphp

                                    
                                    @foreach($category as $cat)
                                    <p class="shop-category"><a href="{{ url('/shop/'.$cat->id) }}">{{ $cat->category_name }}</a></p>
                               
                                    @endforeach
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <!-- End Product MEnu -->
                    <div class="another-product-style">
                        <div class="row">
                            <!-- Start Single Product -->
                             @foreach($allProducts as $row)
                            <div class="col-lg-2 single__pro col-xl-2 col-md-4 col-6 col-sm-6">
                                <div class="product foo">
                                    <div class="product__inner">
                                        <div class="pro__thumb">
                                            <a href="{{ url('product/details/'.$row->id.'/'.$row->slug)}}">
                                                <img src="{{ asset( $row->image_one_secure_url )}}" alt="product images">
                                            </a>
                                        </div>
                                        <div class="product__hover__info">
                                            <ul class="product__action">
                                                <li><a title="Quick view" href="{{ url('/product/details/'.$row->id.'/'.$row->slug) }}"><span class="ti-plus"></span></a></li>
                                                 <li><a class="addcart" title="Add to cart"  data-id="{{ $row->id }}"><span class="ti-shopping-cart"></span></a></</li>
                                                <li><a title="Add to wishlist" class="addwishlist" data-id="{{ $row->id }}" ><span class="ti-heart"></span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product__details">
                                        <h2 class="product-name"><a href="{{ url('/product/details/'.$row->id.'/'.$row->slug) }}" >{{$row->product_name}}</a></h2>
                                        <ul class="product__price">
                                             @if($row->discount_price == NULL)
                                            <li >GH₵ {{$row->selling_price / 100}}</li>
                                              @else
                                              <li class="new__price">GH₵ {{$row->discount_price / 100}}</li>
                                            <li class="old__price">GH₵ {{$row->selling_price / 100}}</li>
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
                            <div class="center-pagination">
                                    {{ $allProducts->links() }}
                            </div>
                    <!-- End Load More BTn -->
                </div>
            </div>
        </section>
        <!-- End Our Product Area -->
</div>

<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

<script type="text/javascript">
    
   $(document).ready(function(){
     $('.addwishlist').on('click', function(){
        var id = $(this).data('id');

        if (id) {
            $.ajax({
                url: " {{ url('add/wishlist/') }}/"+id,
                type:"GET",
                datType:"json",
                success:function(data){
             const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true,
                  onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
                })

             if ($.isEmptyObject(data.error)) {

                Toast.fire({
                  icon: 'success',
                  title: data.success
                })
             }else{
                 Toast.fire({
                  icon: 'error',
                  title: data.error
                })
             }
 

                },
            });

        }else{
            alert('danger');
        }
     });

   });


</script>

<script type="text/javascript">
    
   $(document).ready(function(){
     $('.addcart').on('click', function(){
        var id = $(this).data('id');
        if (id) {
            $.ajax({
                url: " {{ url('/add/to/cart/') }}/"+id,
                type:"GET",
                datType:"json",
                success:function(data){
             const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true,
                  onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
                })
                  window.location.reload();
             if ($.isEmptyObject(data.error)) {
                Toast.fire({
                  icon: 'success',
                  title: data.success
                })
             }else{
                 Toast.fire({
                  icon: 'error',
                  title: data.error
                })
             }
 
                },
            });
        }else{
            alert('danger');
        }
     });
   });
</script>

@endsection