@extends('layouts.product_details')

@section('content')

<div class="section">
    <div id="quickview-wrapper">
        <!-- Modal -->
        <div>
            <div class="container" role="document">
                <div class="row">
                    <!-- Start product images -->
                    <div class="col-lg-6 col-xl-6 col-md-12 col-12">
                        <div class="product__details__container">
                            <!-- Start Small images -->
                            <ul class="product__small__images nav" role="tablist">
                                <li role="presentation" class="pot-small-img">
                                    <a class="active" href="#img-tab-1" role="tab" data-toggle="tab">
                                        <img src="{{ asset( $product->image_one_secure_url ) }}" alt="small-image">
                                    </a>
                                </li>
                                <li role="presentation" class="pot-small-img">
                                    <a href="#img-tab-2" role="tab" data-toggle="tab">
                                        <img src="{{ asset( $product->image_two_secure_url ) }}" alt="small-image">
                                    </a>
                                </li>
                                <li role="presentation" class="pot-small-img">
                                    <a href="#img-tab-3" role="tab" data-toggle="tab">
                                        <img src="{{ asset( $product->image_three_secure_url ) }}" alt="small-image">
                                    </a>
                                </li>
                            </ul>
                            <!-- End Small images -->
                            <div class="product__big__images">
                                <div class="portfolio-full-image tab-content">
                                    <div role="tabpanel" class="tab-pane fade show active product-video-position"
                                        id="img-tab-1">
                                        <img src="{{ asset( $product->image_one_secure_url ) }}" alt="full-image">
                                        @if($product->video_link)
                                        <div class="product-video">
                                            <a class="video-popup" href="{{$product->video_link}}">
                                                <i class="zmdi zmdi-videocam"></i> Watch video
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade product-video-position" id="img-tab-2">
                                        <img src="{{ asset( $product->image_two_secure_url ) }}" alt="full-image">
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade product-video-position" id="img-tab-3">
                                        <img src="{{ asset( $product->image_three_secure_url ) }}" alt="full-image">
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade product-video-position" id="img-tab-4">
                                        <img src="{{ asset( $product->image_one_secure_url ) }}" alt="full-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end product images -->
                    @php
                        $total_rating = DB::table('product_reviews')->where('product_id',$product->id)->count('rating');
                        $avg_rating = DB::table('product_reviews')->where('product_id',$product->id)->avg('rating');
                        $rating = intval(round($avg_rating));
                    @endphp
                    <div class="col-lg-6 col-xl-6 col-md-12 col-12 smt-30 xmt-30">
                        <h1 id="pname">{{ $product->product_name }} </h1>
                        <div class="pro__dtl__rating">
                            <ul class="pro__rating">
                                @if($rating === 0)
                                <li><span class="ti-star"></span></li>
                                <li><span class="ti-star"></span></li>
                                <li><span class="ti-star"></span></li>
                                <li><span class="ti-star"></span></li>
                                <li><span class="ti-star"></span></li> 
                                @elseif ($rating === 1)
                                <li><span class="ti-star mystar"></span></li>
                                <li><span class="ti-star"></span></li>
                                <li><span class="ti-star"></span></li>
                                <li><span class="ti-star"></span></li>
                                <li><span class="ti-star"></span></li>         
                                @elseif($rating === 2)
                                <li><span class="ti-star mystar"></span></li>
                                <li><span class="ti-star mystar"></span></li>
                                <li><span class="ti-star"></span></li>
                                <li><span class="ti-star"></span></li>
                                <li><span class="ti-star"></span></li>      
                                @elseif($rating === 3)
                                <li><span class="ti-star mystar"></span></li>
                                <li><span class="ti-star mystar"></span></li>
                                <li><span class="ti-star mystar"></span></li>
                                <li><span class="ti-star"></span></li>
                                <li><span class="ti-star"></span></li>     
                                @elseif($rating === 4)
                                <li><span class="ti-star mystar"></span></li>
                                <li><span class="ti-star mystar"></span></li>
                                <li><span class="ti-star mystar"></span></li>
                                <li><span class="ti-star mystar"></span></li>
                                <li><span class="ti-star"></span></li>    
                                @else    
                                <li><span class="ti-star mystar"></span></li>
                                <li><span class="ti-star mystar"></span></li>
                                <li><span class="ti-star mystar"></span></li>
                                <li><span class="ti-star mystar"></span></li>
                                <li><span class="ti-star mystar"></span></li>       
                                @endif

                            </ul>
                            <span class="rat__qun">(Based on {{$total_rating}} Ratings)</span>
                        </div>

                        <div class="price-box-3">
                            <div class="s-price-box">
                                @if($product->discount_price == NULL)

                                <span class="new-price" id="pdiscountPrice">GH₵
                                    {{number_format($product->selling_price,2)}}</span>
                                @else
                                <span class="new-price" id="pdiscountPrice">GH₵
                                    {{ number_format($product->selling_price - $product->discount_price,2)}}</span>
                                <span class="old-price" id="psellingPrice">GH₵
                                    {{ number_format($product->selling_price,2)}}</span>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div><span>Quantity Remaining: </span> <span> {{$product_quantity}}</span></div>
                        <div class="pro__details">
                            {!! (substr($product->product_details,0,500)) !!}
                            <span><a href="#description">View more</a></span>
                            
                            <h6 class="mt-2">
                            {{$location->region_name ?? ''}}- {{$location->city_name ?? ''}}
                            </h6>
                        </div>
                        <br>
                        <form action="{{ url('add/to/cart/'.$product->id) }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <h2 class="title__5">Color</h2>
                                        <select class="form-control input-lg" id="exampleFormControlSelect1"
                                            name="color"> @foreach($product_color as $color)
                                            <option value="{{ $color }}">{{ $color }}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                @if($product->product_size == NULL)

                                @else
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <h2 class="title__5">Size</h2>
                                        <select class="form-control input-lg" id="exampleFormControlSelect1"
                                            name="size">
                                            @foreach($product_size as $size)
                                            <option value="{{ $size }}">{{ $size }}</option>

                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                @endif


                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Quantity</label>
                                        <input class="form-control" type="number" value="1" pattern="[0-9]" name="qty"
                                            min="1">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="addtocart-btn">Add to cart</button>
                            </div>
                        </form>
                    </div><!-- .product-info -->
                </div><!-- .modal-content -->
            </div><!-- .modal-dialog -->
        </div>
        <br>
        <br>
        <!-- END Modal -->
    </div>
</div>
<!-- END QUICKVIEW PRODUCT -->


<br>


</section>
<!-- End Product Details -->
<!-- Start Product tab -->
<section class="htc__product__details__tab bg__white pb--120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-12">
                <ul class="product__deatils__tab mb--60 nav" role="tablist">
                    <li role="presentation">
                        <a class="active" href="#description" role="tab" data-toggle="tab">Description</a>
                    </li>
                    <li role="presentation">
                        <a href="#reviews" role="tab" data-toggle="tab">Reviews</a>
                    </li>
                    <li role="presentation">
                        <a href="#QA" role="tab" data-toggle="tab" id="QandATab">Q & A</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="product__details__tab__content">
                    <!-- Start Single Content -->
                    <div role="tabpanel" id="description" class="product__tab__content fade show active">
                        <div class="product__description__wrap">
                            <div class="product__desc">
                                <h2 class="title__6">Details</h2>
                                <p>{!! $product->product_details !!}</p>
                            </div>
                            <div class="pro__feature">
                                <h2 class="title__6">Features</h2>
                                <p> Product name:
                                    <span class="feature">
                                        {{ $product->product_name }}
                                    </span>
                                </p>


                                <p>Colors:
                                    @foreach($product_color as $color)
                                    <span class="feature">
                                        {{ $color }}
                                    </span>
                                    ,
                                    @endforeach
                                </p>


                                <p>Sizes:
                                    @foreach($product_size as $size)
                                    <span class="feature">
                                        {{ $size }}
                                    </span>
                                    ,
                                    @endforeach
                                </p>

                            </div>
                        </div>
                    </div>
                    <!-- End Single Content -->
                    <!-- Start Single Content -->
                    <br>
                    @php
                    $reviews = DB::table('product_reviews')
                    ->join('users','users.id','=','product_reviews.user_id')
                    ->leftJoin('profile_images','product_reviews.user_id','=','profile_images.user_id')
                    ->select('product_reviews.user_id','product_reviews.rating','product_reviews.reviews','product_reviews.created_at','users.name','profile_images.profile_secure_url')
                    ->orderBy('product_reviews.id','DESC')
                    ->where('product_reviews.product_id',$product->id)
                    ->get();

                    $user_review = DB::table('product_reviews')->where('user_id',Auth::id())->where('product_id',$product->id)->first();
                    $user_bought_product = DB::table('order_details')
                    ->join('orders','order_details.order_id','=','orders.id')
                    ->join('order_status_histories','order_details.product_id','=','order_status_histories.product_id')
                    ->where('order_details.product_id',$product->id)
                    ->where('orders.user_id',Auth::id())
                    ->where('order_status_histories.status_id',9)
                    ->first();
                    @endphp
                    <div role="tabpanel" id="reviews" class="product__tab__content fade">
                        <div class="review__address__inner"></div>
                        <!-- Start RAting Area -->
                        @auth
                        @if(!$user_review && $user_bought_product)
                        <div class="rating__wrap" id="rating__wrap__div">
                            <h2 class="rating-title">Write A review</h2>
                            <h4 class="rating-title-2">Your Rating</h4>
                            <div class="rating__list">
                                <!-- Start Single List -->
                                <ul class="rating">
                                    <li><i class="zmdi zmdi-star rate" id="star1" data-rate-id="1"></i></li>
                                    <li><i class="zmdi zmdi-star rate" id="star2" data-rate-id="2"></i></li>
                                    <li><i class="zmdi zmdi-star rate" id="star3" data-rate-id="3"></i></li>
                                    <li><i class="zmdi zmdi-star rate" id="star4" data-rate-id="4"></i></li>
                                    <li><i class="zmdi zmdi-star rate" id="star5" data-rate-id="5"></i></li>
                                </ul>
                                <!-- End Single List -->
                            </div>
                        </div>
                        <!-- End RAting Area -->
                        <div class="review__box" id="review__form__div">
                            <form id="review-form">
                                <input type="hidden"  name="product_id" value="{{$product->id}}">    
                                <div class="single-review-form">
                                    <div class="review-box message">
                                        <textarea placeholder="Write your review" name="review"></textarea>
                                    </div>
                                </div>
                                <div class="review-btn">
                                    <span class="wc-proceed-to-checkout">
                                        <button id="submit-review-btn" class="checkout-btn btn" type="submit" data-product-id="{{$product->id}}">SUBMIT REVIEW</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                        @endif

                        @if (!$user_review)
                            <div class="pro__review ans">
                                <div class="review__thumb" id="review_image">
                                    
                                </div>
                                <div class="review__details">
                                    <div class="review__info">
                                        <h4 id="review_name"></h4> 
                                        <ul class="rating" id="review_rating">
                                    
                                        </ul>
                                    </div>
                                    <div class="review__date">
                                        
                                    </div>
                                    <p id="review_message"></p>
                                </div>
                            </div>
                        @endif
                        @endauth

                        <!-- Start Single Review -->
                        @foreach($reviews as $review)
                            <div class="pro__review ans">
                                <div class="review__thumb">
                                    @if ($review->profile_secure_url !== null)
                                    <img src="{{$review->profile_secure_url}}" alt="user_image" class="thumb_image"> 
                                    @else   
                                    <img src={{asset('frontend_new/images/user/user_image.svg')}} class="thumb_image" alt="user_image">
                                    @endif
                                </div>
                                <div class="review__details">
                                    <div class="review__info">
                                        <h4><a href="#">{{ $review->name}}</a></h4> 
                                        <ul class="rating">
                                            @if ($review->rating === 1)
                                                <li><i class="zmdi zmdi-star mystar"></i></li>
                                                <li><i class="zmdi zmdi-star"></i></li>
                                                <li><i class="zmdi zmdi-star"></i></li>
                                                <li><i class="zmdi zmdi-star"></i></li>
                                                <li><i class="zmdi zmdi-star"></i></li>
                                            @elseif($review->rating === 2)
                                            <li><i class="zmdi zmdi-star mystar"></i></li>
                                            <li><i class="zmdi zmdi-star mystar"></i></li>
                                            <li><i class="zmdi zmdi-star"></i></li>
                                            <li><i class="zmdi zmdi-star"></i></li>
                                            <li><i class="zmdi zmdi-star"></i></li>
                                            @elseif($review->rating === 3)
                                            <li><i class="zmdi zmdi-star mystar"></i></li>
                                            <li><i class="zmdi zmdi-star mystar"></i></li>
                                            <li><i class="zmdi zmdi-star mystar"></i></li>
                                            <li><i class="zmdi zmdi-star"></i></li>
                                            <li><i class="zmdi zmdi-star"></i></li>
                                            @elseif($review->rating === 4)
                                            <li><i class="zmdi zmdi-star mystar"></i></li>
                                            <li><i class="zmdi zmdi-star mystar"></i></li>
                                            <li><i class="zmdi zmdi-star mystar"></i></li>
                                            <li><i class="zmdi zmdi-star mystar"></i></li>
                                            <li><i class="zmdi zmdi-star"></i></li>
                                            @elseif($review->rating === 5)    
                                            <li><i class="zmdi zmdi-star mystar"></i></li>
                                            <li><i class="zmdi zmdi-star mystar"></i></li>
                                            <li><i class="zmdi zmdi-star mystar"></i></li>
                                            <li><i class="zmdi zmdi-star mystar"></i></li>
                                            <li><i class="zmdi zmdi-star mystar"></i></li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="review__date">
                                        <span>{{ date('Y-m-d',strtotime($review->created_at))}}</span>
                                    </div>
                                    <p> {{ $review->reviews}}</p>
                                </div>
                            </div>           
                        @endforeach
                        <!-- End Single Review -->
                    </div>


                    <div role="tabpanel" id="QA" class="product__tab__content fade">
                        <div class="review__address__inner"></div>
                        <!-- Start Single Review -->
                    <div class="review__box">
                            <form id="review-form" class="QandAform">
                                @csrf
                                <input type="hidden"  name="product_id" value="{{$product->id}}">    
                                <div class="single-review-form">
                                    <div class="review-box message">
                                        <textarea placeholder="Write your question" name="question"></textarea>
                                    </div>
                                </div>
                                <div class="review-btn">
                                    <span class="wc-proceed-to-checkout">
                                        <button id="submit-questions-btn" class="checkout-btn btn" type="submit" data-product-id="{{$product->id}}" data-merchant-organization-id="{{$product->merchant_organization_id}}">SUBMIT QUESTION</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div id="productQuestionContainer">

                        </div>
                    </div>
                </div>
                <!-- End Single Content -->
            </div>
        </div>
    </div>
    </div>
</section>
<!-- End Product tab -->


{{-- @include('partials.finance-offerings') --}}

@push('scripts')

@endpush


@endsection
