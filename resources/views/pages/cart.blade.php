@extends('layouts.store')

@section('content')

		 <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Cart</h2>
                                <!-- <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="/">Home</a>
                                  <span class="brd-separetor">/</span>
                                  <span class="breadcrumb-item active">Cart</span>
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
                        <!-- <form action="#">                -->
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">Image</th>
                                            <th class="product-name">Product</th>
                                            <th>Color</th>
                                            <th class="product-quantity">Size</th>
                                            <th>Quantity</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-subtotal">Total Price</th>
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                              @foreach($cart as $row)

                                        <tr>
                                            <td class="product-thumbnail"><a href="#"><img src="{{ asset($row->options->image) }}" alt="product img" /></a></td>
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
                                                @include('partials.quantity_update')
                                            </td>
                                            <td class="product-price">GH₵ {{ number_format($row->price,2) }}</td>
                                            <td class="product-subtotal">GH₵ {{ number_format($row->price*$row->qty,2) }}</td>
                                            <td class="product-remove"><a href="{{ url('remove/cart/'.$row->rowId ) }}">X</a></td>
                                        </tr>
								@endforeach

                            </tbody>
                        </table>
                    </div>
                                <div class="row">
                                <div class="col-md-8 col-sm-7 col-xs-12">
                                </div>
                                <div class="col-md-4 col-sm-5 col-xs-12">
                                    <div class="cart_totals">
                                        <h2>Cart Total</h2>
                                        <table>
                                            <tbody>
                                                <tr class="order-total">
                                                    <th>Total</th>
                                                    <td>
                                                        <strong><span class="amount">GH₵ {{ (Cart::Subtotal()) }}</span></strong>
                                                    </td>
                                                </tr>                                           
                                            </tbody>
                                        </table>
                                        <div class="wc-proceed-to-checkout">
                                            <a href="{{ route('user.checkout') }}">Proceed to Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>         
    
	 <!-- Body main wrapper end -->
    <!-- Placed js at the end of the document so the pages load faster -->




@endsection