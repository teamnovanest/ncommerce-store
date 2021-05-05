@extends('layouts.store')

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
                                    <div role="tabpanel" class="tab-pane fade show active product-video-position" id="img-tab-1">
                                        <img src="{{ asset( $product->image_one_secure_url ) }}" alt="full-image">
                                        <div class="product-video">
                                            <a class="video-popup" href="https://www.youtube.com/watch?v=cDDWvj_q-o8">
                                                <i class="zmdi zmdi-videocam"></i> View Video
                                            </a>
                                        </div>
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
                    </div>                            <!-- end product images -->
                            <div class="col-lg-6 col-xl-6 col-md-12 col-12 smt-30 xmt-30">
                                <h1 id="pname">{{ $product->product_name }} </h1>
                                <div class="pro__dtl__rating">
                                <ul class="pro__rating">
                                    <li><span class="ti-star"></span></li>
                                    <li><span class="ti-star"></span></li>
                                    <li><span class="ti-star"></span></li>
                                    <li><span class="ti-star"></span></li>
                                    <li><span class="ti-star"></span></li>
                                </ul>
                                <span class="rat__qun">(Based on 0 Ratings)</span>
                            </div>
                                
                                <div class="price-box-3">
                                    <div class="s-price-box">
                                @if($product->discount_price == NULL)
                                        
                                        <span class="new-price" id="pdiscountPrice" >GH₵ {{ $product-> selling_price}}</span>
                                @else        
                                        <span class="new-price" id="pdiscountPrice">GH₵ {{ $product-> discount_price}}</span>
                                        <span class="old-price" id="psellingPrice">GH₵ {{ $product-> selling_price}}</span>
                                @endif        
                                    </div>
                                </div>
                                <br><br>

                            <div class="pro__details">
                                {{ substr( $product->product_details,0,900)}}
                                <span><a href="#description">View more</a></span>
                            </div>
                            <br>
                            <form action="{{ url('cart/product/add/'.$product->id) }}" method="post">
                            @csrf
                               
      <div class="row">
        <div class="col-lg-4">
          	<div class="form-group">
          		<h2 class="title__5">Color</h2>
          		<select class="form-control input-lg" id="exampleFormControlSelect1" name="color"> @foreach($product_color as $color)
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
          		        <select class="form-control input-lg" id="exampleFormControlSelect1" name="size"> 
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
          		      <input class="form-control" type="number" value="1" pattern="[0-9]" name="qty" min="1">	
          	  </div> 
          	</div>    
        </div> 
                                <div>
                                    <button type="submit"  class="addtocart-btn">Add to cart</button>
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
                                        <p>{{$product->product_details}}</p>
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
                            $reviews = DB::table('product_reviews')->get();
                            @endphp
                            <div role="tabpanel" id="reviews" class="product__tab__content fade">
                                <div class="review__address__inner"></div>
                                <!-- Start Single Review -->
                                @foreach($reviews as $review)
                                    <div class="pro__review ans">
                                        <div class="review__thumb">
                                            <img src="images/review/2.jpg" alt="review images">
                                        </div>
                                        <div class="review__details">
                                            <div class="review__info">
                                                <h4><a href="#">{{ $review->name}}</a></h4>
                                                <ul class="rating">
                                                    <li><i class="zmdi zmdi-star"></i></li>
                                                    <li><i class="zmdi zmdi-star"></i></li>
                                                    <li><i class="zmdi zmdi-star"></i></li>
                                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                                </ul>
                                                <div class="rating__send">
                                                    <a href="#"><i class="zmdi zmdi-mail-reply"></i></a>
                                                    <a href="#"><i class="zmdi zmdi-close"></i></a>
                                                </div>
                                            </div>
                                            <div class="review__date">
                                                <span>{{ $review->created_at}}</span>
                                            </div>
                                            <p> {{ $review->reviews}}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                    <!-- End Single Review -->
                                </div>
                                <!-- Start RAting Area -->
                                <div class="rating__wrap">
                                    <h2 class="rating-title">Write  A review</h2>
                                    <h4 class="rating-title-2">Your Rating</h4>
                                    <div class="rating__list">
                                        <!-- Start Single List -->
                                        <ul class="rating">
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                        </ul>
                                        <!-- End Single List -->
                                        <!-- Start Single List -->
                                        <ul class="rating">
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                        </ul>
                                        <!-- End Single List -->
                                        <!-- Start Single List -->
                                        <ul class="rating">
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                        </ul>
                                        <!-- End Single List -->
                                        <!-- Start Single List -->
                                        <ul class="rating">
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                        </ul>
                                        <!-- End Single List -->
                                        <!-- Start Single List -->
                                        <ul class="rating">
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                        </ul>
                                        <!-- End Single List -->
                                    </div>
                                </div>
                                <!-- End RAting Area -->
                                <div class="review__box">
                                    <form id="review-form" action="{{ route('review.create')}}" method="post">
                                        @csrf
                                        <div class="single-review-form">
                                            <div class="review-box name">
                                                <input type="text" placeholder="Type your name" name="name">
                                                <input type="email" placeholder="Type your email" name="email">
                                            </div>
                                        </div>
                                        <div class="single-review-form">
                                            <div class="review-box message">
                                                <textarea placeholder="Write your review" name="reviews"></textarea>
                                            </div>
                                        </div>
                                        <div class="review-btn">
                                            <button type="submit" class="fv-btn">submit review</button>
                                        </div>
                                    </form>                                
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


@endsection