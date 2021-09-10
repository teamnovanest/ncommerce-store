 @php

$seo = DB::table('seos')->where('deleted_at', NULL)->first();

@endphp


 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $seo->meta_title }}</title>
    <meta name="description" content="{{ $seo->meta_description }}">
    <meta name="keywords" content="{{ $seo->meta_keywords }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="canonical" href="https://vestashi.com/">

    <!-- Open Graph / Facebook -->
    <meta property="og:image:type" content="image/jpg">
    <meta property="og:url" content="https://vestashi.com/">
    <meta property="og:title" content="{{ $seo->meta_title }}">
    <meta property="og:description" content="{{ $seo->meta_description }}">
    <meta property="og:image" content="{{ $seo->image_secure_url }}">
    <meta property="og:image:secure_url" content="{{ $seo->image_secure_url }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://vestashi.com/">
    <meta property="twitter:title" content="{{ $seo->meta_title }}">
    <meta property="twitter:description" content="{{ $seo->meta_description }}">
    <meta property="twitter:image" content="{{ $seo->image_secure_url }}">
    
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/frontend_new/css/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('/frontend_new/css/apple-touch-icon.png') }}">
    

    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="{{ asset('/frontend_new/css/bootstrap.min.css') }}">
    <!-- Owl Carousel main css -->
    <link rel="stylesheet" href= "{{ asset('/frontend_new/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend_new/css/owl.theme.default.min.css') }}">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href=" {{ asset('/frontend_new/css/core.css') }}">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href=" {{ asset('/frontend_new/css/shortcode/shortcodes.css') }}">
    <!-- Theme main style -->
    <link rel="stylesheet" href=" {{ asset('/frontend_new/style.css') }}">
    <!-- Responsive css -->
    <link rel="stylesheet" href=" {{ asset('/frontend_new/css/responsive.css') }}">
    <!-- User style -->
    <link rel="stylesheet" href="{{ asset('/frontend_new/css/custom.css') }}">

    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/lib/toastr/toastr.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- <link rel="stylesheet" href="sweetalert2.min.css"> -->
    <!-- vendor css -->
    <!-- <link href="{{ asset('../lib/fontawesome-free/css/all.min.css')}}" rel="stylesheet"> -->
    <!-- <link href="{{ asset('../lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet"> -->
    <link href="{{ asset('/lib/typicons.font/typicons.css')}}" rel="stylesheet">
    <!-- <link href="{{ asset('../lib/flag-icon-css/css/flag-icon.min.css')}}" rel="stylesheet"> -->

    <!-- azia CSS -->
    <link rel="stylesheet" href="{{ asset('/lib/css/azia.css')}}">


     <link rel='stylesheet' href="{{ asset('/lib/nprogress/nprogress.css') }}" />

    <!-- Modernizr JS -->
    <script src="{{ asset('/frontend_new/js/vendor/modernizr-2.8.3.min.js')}}"></script>


<script>
// For the search only version
//import   algoliasearch from 'algoliasearch/lite' ;
//import instantsearch from 'instantsearch.js';

//var index = searchClient.initIndex('product_idx');
/* index.setSettings({
  // Select the attributes you want to search in
  searchableAttributes: [
    'product_name', 'product_details'
  ],
  // Define business metrics for ranking and sorting
  customRanking: [
    'desc(popularity)'
  ],
  // Set up some attributes to filter results on
  attributesForFaceting: [ 'product_color','price', 'product_size']
}); */



</script>

</head>


<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->  


    
    <!-- Header -->
<!-- <div class="wrapper fixed__footer"> -->
    <div class="ais-InstantSearch"">
    <header id="header" class="htc-header header--3 bg__white clearfix">
            <!-- Start Mainmenu Area -->
            <div id="sticky-header-with-topbar" class="mainmenu__area sticky__header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-lg-2  col-sm-8 col-3">
                            <div class="logo">
                               <h5><a href="/">Vestashi</a></h5>
                            </div>
                        </div>
                        <!-- Start MAinmenu Ares -->
                        <div class="col-md-6 col-lg-8 col-sm-2 col-6 ">
                            <nav class="mainmenu__nav d-none d-lg-block">
                                <ul class="main__menu">
                                    <li class="drop"><a href="/">Home</a></li>
                                    <li class="drop"><a href="/shop">Shop</a></li>
                                    <li><a href="/contact">Contact</a></li>
                                    <li class="drop"><a href="#">Shop By City</a>
                                        <ul class="dropdown mega_dropdown">
                                            <!-- Start Single Mega MEnu -->
                                            <li><a class="mega__title" href="">Cities</a>
                                                <ul class="mega__item">
                                                    @php
                                                    $all_cities = DB::table('cities')
                                                    ->join('merchant_locations', 'merchant_locations.city_id', '=', 'cities.id')
                                                    ->select('merchant_locations.city_id','cities.id','cities.city_name')
                                                    ->distinct()
                                                    ->get();
                                                    @endphp
                                                    @foreach ($all_cities as $cities)
                                                    <div class="col-3">
                                                        <li>
                                                            <a href="{{ url('/city/'.$cities->city_id.'/'.$cities->city_name.'/products') }}">{{$cities->city_name}}</a>
                                                        </li>
                                                    </div>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <!-- End Single Mega MEnu -->
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                            <div class="mobile-menu clearfix d-none">
                                <nav id="mobile_dropdown">
                                    <ul>
                                        <li><a href="/">Home</a></li>
                                        <li><a href="/shop">Shop</a></li>
                                        <li><a href="/contact">Contact</a></li>
                                        <li><a class="mega__title" href="#">Cities</a>
                                                <ul class="mega__item">
                                                @php
                                                $all_cities = DB::table('cities')
                                                ->join('merchant_locations', 'merchant_locations.city_id', '=', 'cities.id')
                                                ->select('merchant_locations.city_id','cities.id','cities.city_name')
                                                ->get();
                                                @endphp
                                                @foreach ($all_cities as $cities)
                                               <div class="col-3">
                                                <li>
                                                <a href="{{ url('/city/'.$cities->city_id.'/'.$cities->city_name.'/products') }}">{{$cities->city_name}}</a>
                                                </li>
                                                </div>
                                                @endforeach
                                                </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>                          
                        </div>
                        <!-- End main menu Area -->
                        <div class="col-md-3 col-lg-2 col-sm-2 col-3 ">  
                            <ul class="menu-extra">
                                <li class="search search__open d-none d-md-block d-lg-block"><span class="ti-search"></span></li>
                                <li><a href="/login"><span class="ti-user"></span></a></li>
                                @guest
                                <li><a href="#"><span class="ti-heart"></span></a></li>
                                @else
                                @php
                                $wishlist = DB::table('wishlists')->where('user_id',Auth::id())->count();
                                @endphp
                                <li><a href="/wishlist"><span class="ti-heart">{{ $wishlist > 0 ? $wishlist  : "" }}</span></a></li>
                                @endguest
                                <li class="cart__menu"><span class="ti-shopping-cart">{{ Cart::count() > 0 ? Cart::count(): "" }}</span></li>
                                <li class="toggle__menu d-none d-lg-block"><span class="ti-menu"></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mobile-menu-area"></div>
                </div>
            </div>
            <!-- End Mainmenu Area -->
</header>
        <!-- End Header Style -->

        <div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- Start Search Popap -->
            <div class="search__area">
                <div class="container" >
                    <div class="row" >
                        <div class="col-md-12" >
                            <div class="search__inner">
                                <form method="get" action="{{ route('product.search') }}">
                                @csrf
                                    <input type="text" id="searchbox" required="required" placeholder="Search for products..." name="search">
                                    <button type="submit"></button>
                                 
                                </form>
                                <div class="search__close__btn">
                                    <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Search Popap -->
            <!-- Start Offset MEnu -->
            <div class="offsetmenu">
                <div class="offsetmenu__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <div class="off__contact">
                        <div class="logo">
                            <a href="/">
                                <h1>Vestashi</h1>
                            </a>
                        </div>
                        {{-- <p>Lorem ipsum dolor sit amet consectetu adipisicing elit sed do eiusmod tempor incididunt ut labore.</p> --}}
                    </div>
                    <ul class="sidebar__thumd">
                        {{-- <li><a href="#"><img src="/frontend_new/images/sidebar-img/1.jpg" alt="sidebar images"></a></li>
                        <li><a href="#"><img src="/frontend_new/images/sidebar-img/2.jpg" alt="sidebar images"></a></li>
                        <li><a href="#"><img src="/frontend_new/images/sidebar-img/3.jpg" alt="sidebar images"></a></li>
                        <li><a href="#"><img src="/frontend_new/images/sidebar-img/4.jpg" alt="sidebar images"></a></li>
                        <li><a href="#"><img src="/frontend_new/images/sidebar-img/5.jpg" alt="sidebar images"></a></li>
                        <li><a href="#"><img src="/frontend_new/images/sidebar-img/6.jpg" alt="sidebar images"></a></li>
                        <li><a href="#"><img src="/frontend_new/images/sidebar-img/7.jpg" alt="sidebar images"></a></li>
                        <li><a href="#"><img src="/frontend_new/images/sidebar-img/8.jpg" alt="sidebar images"></a></li> --}}
                    </ul>

                    {{-- @php
                  $language = Session()->get('lang');
                @endphp
                    <div class="offset__widget">
                        <div class="offset__single">
                            <h4 class="offset__title">Language</h4>
                            <ul>
                                @if(Session()->get('lang') == 'hindi' )
                                <li><a href="{{ route('language.english') }}"> Engish </a></li>
                                @else
                                <li><a href="{{ route('language.hindi') }}"> hindi </a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="offset__single">
                            <h4 class="offset__title">Currencies</h4>
                            <ul>
                                <li><a href="#"> USD : Dollar </a></li>
                                <li><a href="#"> EUR : Euro </a></li>
                                <li><a href="#"> POU : Pound </a></li>
                            </ul>
                        </div>
                    </div> --}}
                    <div class="offset__sosial__share">
                        <h4 class="offset__title">Follow Us On Social</h4>
                        <ul class="off__soaial__link">
                            <li><a class="bg--twitter" href="#"  title="Twitter"><i class="zmdi zmdi-twitter"></i></a></li>
                            
                            <li><a class="bg--instagram" href="#" title="Instagram"><i class="zmdi zmdi-instagram"></i></a></li>

                            <li><a class="bg--facebook" href="#" title="Facebook"><i class="zmdi zmdi-facebook"></i></a></li>

                            <li><a class="bg--googleplus" href="#" title="Google Plus"><i class="zmdi zmdi-google-plus"></i></a></li>

                            <li><a class="bg--google" href="#" title="Google"><i class="zmdi zmdi-google"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End Offset MEnu -->
            <!-- Start Cart Panel -->
            <div class="shopping__cart">
                <div class="shopping__cart__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <div class="shp__cart__wrap">
                        @foreach($cart as $row)
                        <div class="shp__single__product">
                            <div class="shp__pro__thumb">
                                <a href="#">
                                    <img src="{{ asset($row->options->image) }}" alt="product images">
                                </a>
                            </div>
                            <div class="shp__pro__details">
                                <h2><a href="#">{{ $row->name  }}</a></h2>
                                <span class="quantity">QTY: {{ $row->qty }}</span>
                                <span class="shp__price">GH₵ {{number_format( $row->price*$row->qty,2)}}</span>
                            </div>
                            <div class="remove__btn">
                                <a href="{{ url('remove/cart/'.$row->rowId ) }}"" title="Remove this item"><i class="zmdi zmdi-close"></i></a>
                            </div>
                        </div>
                            @endforeach
                    </div>
                    <ul class="shoping__total">
                        <li class="subtotal">Total:</li>
                        <li class="total__price">GH₵ {{ Cart::Subtotal() }}</li>
                    </ul>
                    <ul class="shopping__btn">
                        <li><a href="{{ route('show.cart')}}">View Cart</a></li>
                        <li class="shp__checkout"><a href="{{ route('user.checkout') }}"">Checkout</a></li>
                    </ul>
                </div>
            </div>
            <!-- End Cart Panel -->
        </div>
        <!-- End Offset Wrapper -->
        <!-- Main Navigation -->

     
    <!-- Characteristics -->

@yield('content')
    <!-- Footer -->
 @php
$setting = DB::table('sitesettings')->first();
 @endphp

     <!-- Start Footer Area -->
        <footer class="htc__foooter__area gray-bg">
            <div class="container">
                <div class="footer__container clearfix ">
                    <div class="row">
                         <!-- Start Single Footer Widget -->
                        <div class="col-lg-3 col-xl-3 col-md-6 col-sm-6">
                            @if ($setting)
                            <div class="ft__widget">
                                <div class="ft__logo">
                                    <a href="#">
                                      {{ $setting->company_name ?? ''}}
                                       Vestashi
                                    </a>
                                   
                                </div>
                                <div class="footer-address">
                                    <ul>
                                        <li>
                                            <div class="address-icon">
                                                <i class="zmdi zmdi-pin"></i>
                                            </div>
                                            <div class="address-text">
                                                <p>{{ $setting->company_address ?? ''}}</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="address-icon">
                                                <i class="zmdi zmdi-email"></i>
                                            </div>
                                            <div class="address-text">
                                                <a href="#"> {{ $setting->email ?? ''}}</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="address-icon">
                                                <i class="zmdi zmdi-phone-in-talk"></i>
                                            </div>
                                            <div class="address-text">
                                                <p>{{ $setting->phone_one ?? ''}}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="social__icon">
                                    <li><a href="{{ $setting->twitter ?? ''}}"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="{{ $setting->instagram ?? ''}}"><i class="zmdi zmdi-instagram"></i></a></li>
                                    <li><a href="{{ $setting->facebook ?? ''}}"><i class="zmdi zmdi-facebook"></i></a></li>
                                    <li><a href="{{ $setting->facebook ?? ''}}"><i class="zmdi zmdi-google-plus"></i></a></li>
                                </ul>
                            </div>
                            @endif
                        </div>
                        <!-- End Single Footer Widget -->
                        <!-- Start Single Footer Widget -->
                        <div class="col-lg-3 col-xl-2 col-md-6 col-sm-6 xmt-30 mrg-sm-none">
                            <div class="ft__widget">
                                <h2 class="ft__title">Categories</h2>
                                @php
                                $category = DB::table('category_options')->where('deleted_at', NULL)->get();
                                @endphp
                                <ul class="footer-categories">
                            @foreach($category as $cat)
                                    <li><a href="{{route('category.name',['id'=>$cat->id,'category_name'=> $cat->category_name]) }}">{{ $cat->category_name }}</a></li>
                            @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- Start Single Footer Widget -->
                        <div class="col-lg-3 col-xl-2 col-md-6 col-sm-6 smt-30 xmt-30">
                            <div class="ft__widget">
                                <h2 class="ft__title">Infomation</h2>
                                <ul class="footer-categories">
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="/contact">Contact Us</a></li>
                                    <li><a href="/terms-conditions">Terms & Conditions</a></li>
                                    <li><a href="#">Returns & Exchanges</a></li>
                                    <li><a href="#">Shipping & Delivery</a></li>
                                    <li><a href="/privacy-policy">Privacy Policy</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Start Single Footer Widget -->
                        <div class="col-lg-3 col-xl-3 ml-auto mr-auto col-md-6 col-sm-6 smt-30 xmt-30">
                            <div class="ft__widget">
                                <h2 class="ft__title">Newsletter</h2>
                                <div class="newsletter__form">
                                    <p>Subscribe to our newsletter and get 10% off your first purchase .</p>
                                    <div class="input__box">
                                        <div id="mc_embed_signup">
                                            <form action="/newsletter/create" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" novalidate>
                                                @csrf
                                                <div id="mc_embed_signup_scroll" class="htc__news__inner">
                                                    <div class="news__input">
                                                        <input type="email" name="email" class="email" id="mce-EMAIL" placeholder="Email Address" required>
                                                    </div>
                                                    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                                    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_6bbb9b6f5827bd842d9640c82_05d85f18ef" tabindex="-1" ></div>
                                                    <div class="clearfix subscribe__btn"><input type="submit" value="Send" name="subscribe" id="mc-embedded-subscribe" class="bst__btn btn--white__color">
                                                        
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>        
                                </div>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->
                    </div>
                </div>


 <!-- Start Copyright Area -->
                <div class="htc__copyright__area">
                    <div class="row">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-12">
                            <div class="copyright__inner">
                                <div class="copyright">
                                    <p>© <script>document.write(new Date().getFullYear());</script> <a href="#">Vestashi</a>
                                    All Right Reserved.</p>
                                </div>
                                <ul class="footer__menu">
                                    <li><a href="/">Home</a></li>
                                    <li><a href="/shop">Product</a></li>
                                    <li><a href="/contact">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Copyright Area -->
                   </div>
        </footer>
    </div>

<!-- </div> -->
        
        <!-- End Footer Area -->


<!--Order Traking Modal -->
{{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Your Status Code</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
   <form method="post" action="{{ route('order.tracking') }}">
    @csrf
    <div class="modal-body">
        <label> Status Code</label>
        <input type="text" name="code" required="" class="form-control" placeholder="Your Order Status Code">        
    </div>
     
     <button class="btn btn-danger" type="submit">Track Now </button>  

   </form>
  
        
      </div>
       
    </div>
  </div>
</div> --}}

    <!--  Search -->
    <!--Plyfill for IE 11 support  -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=Promise%2CObject.entries%2CObject.assign"></script>

    <!-- for the search only version -->
    <script  src="https://cdn.jsdelivr.net/npm/algoliasearch@4.5.1/dist/algoliasearch-lite.umd.js" integrity="sha256-EXPXz4W6pQgfYY3yTpnDa3OH8/EPn16ciVsPQ/ypsjk=" crossorigin="anonymous"></script>
    <!-- Instant search  -->
    <script   src="https://cdn.jsdelivr.net/npm/instantsearch.js@4.8.3/dist/instantsearch.production.min.js" integrity="sha256-LAGhRRdtVoD6RLo2qDQsU2mp+XVSciKRC8XPOBWmofM=" crossorigin="anonymous"></script>

    <!-- jquery latest version -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    
    <!-- Paystack -->
    <script src="https://js.paystack.co/v2/inline.js"></script>

   
    
    {{-- <script type="text/javascript" src="{{ asset('/lib/toastr/toastr.min.js') }}"></script> --}}
    <script src="{{ asset('/lib/sweetalert/sweetalert.js') }}"></script> 
    <!-- <script src="{{ asset('/lib/sweetalert/sweetalert.min.js')}}"></script> -->
    <script src="{{ asset('/lib/nprogress/nprogress.js')}}"></script>

  <!-- <script src="{{ asset('/frontend_new/js/vendor/jquery-1.12.0.min.js')}}"></script>  -->
    <!-- Bootstrap framework js -->
    <script src="{{ asset('/frontend_new/js/bootstrap.min.js')}}"></script>
    <!-- All js plugins included in this file. -->
    <script src="{{ asset('/frontend_new/js/plugins.js')}}"></script>
   <!--  <script src="{{ asset('/frontend_new/js/slick.min.js')}}"></script> -->
    <script src="{{ asset('/frontend_new/js/owl.carousel.min.js')}}"></script>  
   
    <!-- Waypoints.min.js. -->
    <!-- <script src="{{ asset('/frontend_new/js/waypoints.min.js')}}"></script> -->
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="{{ asset('/frontend_new/js/main.js')}}"></script>


<!-- <script src="{{ asset('/frontend/js/product_custom.js')}}"></script> -->
<script src="{{ asset('js/custom.js')}}"></script>

<!-- Init Search -->
<!-- <script src="{{ asset('/js/search.js')}}"></script> -->
  
@stack('scripts')
<!-- cus dashboard script -->
   {{-- <script src="{{asset('lib/jquery/jquery.min.js')}}"></script> --}}
    <!-- <script src="../lib/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="../lib/ionicons/ionicons.js"></script> -->
    <!-- <script src="../lib/jquery.flot/jquery.flot.js"></script> -->
    <!-- <script src="../lib/jquery.flot/jquery.flot.resize.js"></script> -->
    <!-- <script src="../lib/chart.js/Chart.bundle.min.js"></script> -->
    <!-- <script src="../lib/peity/jquery.peity.min.js"></script> -->

    <!-- <script src="../js/azia.js"></script> -->
    <!-- <script src="../js/chart.flot.sampledata.js"></script> -->
    <!-- <script src="../js/dashboard.sampledata.js"></script> -->
    <!-- <script src="../js/jquery.cookie.js" type="text/javascript"></script> -->
<!--End cus dashboard script  -->


 <script>
        @if(Session::has('messege'))
          var type="{{Session::get('alert-type','info')}}"
          var Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        onOpen: (toast) => {
                            toast.addEventListener(
                                "mouseenter",
                                Swal.stopTimer
                            );
                            toast.addEventListener(
                                "mouseleave",
                                Swal.resumeTimer
                            );
                        },
                    });
          switch(type){
              case 'info':
                   Toast.fire({
                            icon: "info",
                            title: "{{ Session::get('messege') }}",
                        });
                   break;
              case 'success':
                    Toast.fire({
                            icon: "success",
                            title: "{{ Session::get('messege') }}",
                        });
                  break;
              case 'warning':
                   Toast.fire({
                            icon: "warning",
                            title: "{{ Session::get('messege') }}",
                        });
                  break;
              case 'error':
                    Toast.fire({
                            icon: "error",
                            title: "{{ Session::get('messege') }}",
                        });
                  break;
          }
        @endif
     </script>  


 <script>  
//  <script>
//         @if(Session::has('messege'))
//           var type="{{Session::get('alert-type','info')}}"
//           switch(type){
//               case 'info':
//                    toastr.info("{{ Session::get('messege') }}");
//                    break;
//               case 'success':
//                   toastr.success("{{ Session::get('messege') }}");
//                   break;
//               case 'warning':
//                  toastr.warning("{{ Session::get('messege') }}");
//                   break;
//               case 'error':
//                   toastr.error("{{ Session::get('messege') }}");
//                   break;
//           }
//         @endif
//    </script>  

</body>

</html>

