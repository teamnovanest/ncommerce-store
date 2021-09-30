@extends('layouts.store')

@section('content')

<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area">
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
                                <td class="product-thumbnail"><a href="#"><img src="{{ asset($row->options->image) }}"
                                            alt="product img" /></a></td>
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
                @if ($cart->count() > 0)
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="cart_totals">
                            <h3>Cart Total</h3>
                            <ul>
                                <li>Total : GH₵ <span class="amount" id="cart-total">{{ Cart::Subtotal()}} </span>
                                </li>

                            </ul>
                            <div class="wc-proceed-to-checkout">
                                <a href="{{ route('user.checkout') }}">Proceed to Checkout</a>
                            </div>

                        </div>
                    </div>
                </div>



                @else
                <div></div>

                @endif
                <!-- </form> -->
            </div>
        </div>
    </div>
</div>

<!-- Body main wrapper end -->
<!-- Placed js at the end of the document so the pages load faster -->




@endsection
