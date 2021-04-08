@extends('layouts.store')

@section('content')


<div>
		 <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Checkout</h2>
                                <!-- <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="/">Home</a>
                                  <span class="brd-separetor">/</span>
                                  <span class="breadcrumb-item active">Checkout</span>
                                </nav> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
		<!-- cart-main-area start -->
        <div class="cart-main-area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        {{-- <form action="#">                --}}
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-name">Product</th>
                                            <th>Color</th>
                                            <th class="product-quantity">Size</th>
                                            <th>Quantity</th>
                                            <th class="product-thumbnail">Image</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-subtotal">Total Price</th>
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                              @foreach($cart as $row)

                                        <tr>
                                            <td class="product-name">{{ $row->name  }}</td>
                                            @if($row->options->color == NULL)
                                            <td></td>
                                            @else
                                            <td>{{ $row->options->color }}</td>
                                            @endif

                                            @if($row->options->size == NULL)
                                            <td></td>
                                            @else
                                            <td class="product-quantity">{{ $row->options->size }}</td>
                                            @endif
                                            <td>
                                                <form method="post" action="{{ route('user.checkout') }}">
           	                                       @csrf
           	                                        <input type="hidden" name="productid" value="{{ $row->rowId }}">
           	                                        <input type="number" name="qty" value="{{ $row->qty }}" style="width: 50px;">
           	                                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check-square"></i>✔</button>
                                                </form>  
                                            </td>
                                            <td class="product-thumbnail"><a href="#"><img src="{{ asset($row->options->image) }}" alt="product img" /></a></>
                                            <td class="product-price">GH₵ {{ $row->price }}</td>
                                            <td class="product-subtotal">GH₵ {{ $row->price*$row->qty }}</td>
                                            <td class="product-remove"><a href="{{ url('remove/cart/'.$row->rowId ) }}">X</a></td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                   <div class="col-md-4">
                                        <select name="lender_organization_select" id="lender_organization_select" class="form-control">
                                            <option>Select your finance organization</option>
                                            @foreach ($lender_organizations as $organization)  
                                            <option value="{{$organization->id}}">{{$organization->registered_name}}({{$organization->trade_name}})</option>
                                            @endforeach
                                        </select>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="" id="" class="form-control">
                                                <option>Period</option>
                                                @foreach ($payment_periods as $period)  
                                                <option value="{{$period->Payment_period}}">{{$period->Payment_period}} Months</option>
                                                @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                            <select name="" id="" class="form-control">
                                                <option>Percentage</option>
                                                @foreach ($percentages as $row)  
                                                <option value="{{$row->percentage}}">{{$row->percentage}} %</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                   
                                    </div>
                            </div>
                          	<br><br>
								<div class="row">
                                    <div class="col-md-8 col-sm-7 col-xs-12">
                                          @if(Session::has('coupon'))

                                         @else

          	                       <form method="post" action="{{ route('apply.coupon') }}">
          		                       @csrf
                                       <div class="coupon">
                                        <h3>Coupon</h3>
                                        <p>Enter your coupon code if you have one.</p>
                                        <input type="text" name="coupon" class="form-control" required="" placeholder="Enter Your Coupon" />
                                        <input type="submit" value="Apply Coupon" />
                                    </div>		
          	                       </form>
          	                       @endif
			                         </div>
								<div class="col-md-4 col-sm-5 col-xs-12">
                                    <div class="cart_totals">
                                        <h2>Cart Totals</h2>
                                        <ul>
          	                                  @if(Session::has('coupon'))
          	                                  <li>Subtotal : <span class="amount">
          	                                  GH₵ {{ Session::get('coupon')['balance'] }} </span> </li>
          	                                   <li>Coupon : ({{ Session::get('coupon')['name'] }} )
                                                <a href="{{ route('coupon.remove') }}" class="btn btn-danger btn-sm">X</a>
                                             <span class="amount">GH₵ {{ Session::get('coupon')['discount'] }} </span> </li>
                                            	@else
          	                                  <li>Subtotal : <span class="amount">
          	                                  GH₵ {{  Cart::Subtotal() }} </span> </li>
          	                                  @endif
          	
          	                                  @if(Session::has('coupon'))
          	                                  <li>Total : <span class="amount">GH₵ {{ Session::get   ('coupon')                               ['balance']  }} </span> </li>
          	                                  @else
                                              <li>Total : <span class="amount">GH₵ {{ Cart::Subtotal()}} </span> </li>
          	                                  @endif
										</ul>  
                                        <div>
                                            <span class="wc-proceed-to-checkout">
                                                <a href="{{ route('checkout.process') }}">Checkout</a>
                                            </span>
                                            <span class="cart_buttons">
                                                <button style="height: 50px; background: #252525;" type="button" class="btn btn-danger">All Cancel</button>
                                            </span>
                                        </div>
                                    </div>                 
                                </div>
                            </div>
                        {{-- </form> --}}
                </div>
            </div>
        </div>
	</div>
    </div>
	@endsection