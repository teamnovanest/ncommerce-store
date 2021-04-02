@extends('layouts.store')

@section('content')


    <div id="quickview-wrapper">
        <!-- Modal -->
        <div>
            <div class="container" role="document">
                <div class="modal-content">
                   
                    <div class="modal-body">
                        <div class="modal-product">
                            <!-- Start product images -->
                            <div class="product-images">
                                <div class="main-image images">
                                    <img alt="big images" src="{{ asset( $product->image_one_secure_url ) }}" id="pimage">
                                </div>
                            </div>
                            <!-- end product images -->
                            <div class="product-info">
                                <h1 id="pname">{{ $product->product_name }} </h1>
                                
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
                                <br>
                                
                            <form action="{{ url('cart/product/add/'.$product->id) }}" method="post">
                            @csrf
                               
      <div class="row">
        <div class="col-lg-4">
          	<div class="form-group">
          		<label for="exampleFormControlSelect1">Color</label>
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
          		      <label for="exampleFormControlSelect1">Size</label>
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
          		      <input class="form-control" type="number" value="1" pattern="[0-9]" name="qty">	
          	  </div> 
          	</div>    
        </div> 
                                <div>
                                    <button type="submit"  class="addtocart-btn">Add to cart</button>
                                </div>
                            </form>
                            </div><!-- .product-info -->
                        </div><!-- .modal-product -->
                    </div><!-- .modal-body -->
                </div><!-- .modal-content -->
            </div><!-- .modal-dialog -->
        </div>
        <br>
        <!-- END Modal -->
    </div>
    <!-- END QUICKVIEW PRODUCT -->

@endsection