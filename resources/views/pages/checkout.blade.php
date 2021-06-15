@extends('layouts.store')

@section('content')
<div>
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area">
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
    <div class="cart-main-area ptb--80 bg__white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
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
                                          @include('partials.quantity_update')
                                    </td>
                                    <td class="product-thumbnail"><a href="#"><img
                                                src="{{ asset($row->options->image) }}" alt="product img" /></a></>
                                    <td class="product-price">GH₵ {{ number_format($row->price,2) }}</td>
                                    <td class="product-subtotal">GH₵ {{ number_format($row->price*$row->qty,2) }}</td>
                                    <td class="product-remove"><a href="{{ url('remove/cart/'.$row->rowId ) }}">X</a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section>
        @if($cart->count() > 0)

        <div class="container">
            <h4 class="pb--30 text-center">FINANCE PAYMENT PLANS</h4>
            <div class="row">
                <div class="col-md-12">
                @if (auth()->user()->lender_organization_id && isset($special_association_offers))
                    <ul>
                         @foreach($special_association_offers as $offer)
                            <li class="h3">
                                <div class="form-check">
                                    <div class="row">
                                        @if (floatval(str_replace(",","",Cart::Subtotal())) <= ($offer->max_financed / 100))
                                        <div class="col-2 col-lg-1 col-md-2 col-xs-2">
                                            <input class="form-check-input" type="radio" name="lenderOfferingRadio"
                                            id="{{$offer->id}}" value="{{$offer->id}}" data-id="{{$offer->id}}">
                                        </div>
                                            <div class="col-10 col-lg-11 col-md-10 col-xs-10">
                                                <label class="form-check-label" for="{{$offer->id}}">
                                                @if (Session::has('coupon'))
                                                    <p>
                                                    {{ $offer->registered_name}} finances at {{ $offer->percentage }}% 
                                                    for
                                                    {{ $offer->payment_period }} months for {{$offer->union_name}} ({{$offer->union_common_name}}) members
                                                    </p>
                                                    <p>
                                                    Total financed GH₵
                                                    {{ number_format(((Session::get('coupon')['balance'] * $offer->percentage * ($offer->payment_period/12)) / 100) + Session::get('coupon')['balance'] ,2 )  }} 
                                                    </p>
                                                    <p>
                                                    Total Interest on price GH₵ {{ number_format((Session::get('coupon')['balance'] * $offer->percentage * ($offer->payment_period/12) / 100) ,2
                                                    ) }}
                                                    </p>
                                                @else
                                                    <p>
                                                        {{ $offer->registered_name}} finances at {{ $offer->percentage }}%
                                                        for
                                                        {{ $offer->payment_period }} months for {{$offer->union_name}} ({{$offer->union_common_name}}) members
                                                    </p>
                                                    
                                                    <p>Total financed GH₵
                                                        {{ number_format(((floatval(str_replace(",","",Cart::Subtotal())) * $offer->percentage * ($offer->payment_period/12)) / 100) + floatval(str_replace(",","",Cart::Subtotal())),2)}}
                                                    </p>

                                                    <p>
                                                        Total Interest on price GH₵ {{number_format(((floatval(str_replace(",","",Cart::Subtotal())) * $offer->percentage * ($offer->payment_period/12)) / 100),2)}}
                                                    </p>    
                                                @endif
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <hr />
                            @endforeach
                        </ul>

                @elseif (auth()->user()->lender_organization_id && isset($credit_offers))  
                    <ul>

                        @foreach($credit_offers as $offer)

                        <li class="h3">
                            <div class="form-check">
                                <div class="row">
                                    @if (floatval(str_replace(",","",Cart::Subtotal()))  <= ($offer->max_financed / 100))
                                   
                                    <div class="col-2 col-lg-1 col-md-2 col-xs-2">
                                        <input class="form-check-input" type="radio" name="lenderOfferingRadio"
                                        id="{{$offer->id}}" value="{{$offer->id}}" data-id="{{$offer->id}}">
                                    </div>
                                        <div class="col-10 col-lg-11 col-md-10 col-xs-10">
                                            <label class="form-check-label" for="{{$offer->id}}">
                                            @if (Session::has('coupon'))
                                                <p>
                                                   {{ $offer->registered_name}} finances at {{ $offer->percentage }}% 
                                                   for
                                                   {{ $offer->payment_period }} months
                                                </p>
                                                <p>
                                                   Total financed GH₵
                                                   {{ number_format(((Session::get('coupon')['balance'] * $offer->percentage * ($offer->payment_period/12)) / 100) + Session::get('coupon')['balance'] ,2 )  }} 
                                                </p>
                                                <p>
                                                   Total Interest on price GH₵ {{ number_format((Session::get('coupon')['balance'] * $offer->percentage * ($offer->payment_period/12) / 100) ,2
                                                   ) }}
                                                </p>
                                            @else
                                                <p>
                                                    {{ $offer->registered_name}} finances at {{ $offer->percentage }}%
                                                    for
                                                    {{ $offer->payment_period }} months
                                                </p>
                                                
                                                <p>Total financed GH₵
                                                    {{ number_format(((floatval(str_replace(",","",Cart::Subtotal())) * $offer->percentage * ($offer->payment_period/12)) / 100) + floatval(str_replace(",","",Cart::Subtotal())),2)}}
                                                </p>

                                                <p>
                                                    Total Interest on price GH₵ {{number_format(((floatval(str_replace(",","",Cart::Subtotal())) * $offer->percentage * ($offer->payment_period/12)) / 100),2)}}
                                                </p>    
                                            @endif
                                            </label>
                                        </div>
                                      
                                       
                                    {{-- @foreach($cart as $row)
                                    @if (((($offer->percentage  * ($row->price * $row->qty)) / 100 ) +  ($row->price * $row->qty)) <= $offer->max_financed)
                                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
                                        <input class="form-check-input" type="radio" name="lenderOfferingRadio"
                                        id="{{$offer->id}}" value="{{$offer->id}}" data-id="{{$offer->id}}">
                                    </div>
                                        <div class="col-lg-11 col-md-11 col-sm-10 col-xs-10">
                                            <label class="form-check-label" for="{{$offer->id}}">
                                                <p>
                                                    {{ $offer->registered_name}} finances at {{ $offer->percentage }}%
                                                    for
                                                    {{ $offer->payment_period }} months
                                                </p>


                                                <p>Total financed GH₵
                                                    {{ (($offer->percentage  * ($row->price * $row->qty)) / 100 ) +  ($row->price * $row->qty) }}
                                                </p>

                                                <p>
                                                    Total Interest on price GH₵ {{(($offer->percentage  * ($row->price * $row->qty)) / 100 )}}
                                                </p>
                                            </label>
                                        </div>
                                        @endif
                                        @endforeach --}}
                                             
                                    @endif
                                </div>
                            </div>
                        </li>
                        <hr />
                        @endforeach

                    </ul>
                     @else
                        @if (auth()->user()->lender_organization_id)    
                            <div class="finance-offer__error">
                                <h4>Your cart subtotal is greater than the maximum amount your organization is willing to finance</h4>
                                <h5>Your subtotal should be less than GHC {{ $amount->max_financed }} </h5>
                            </div>
                        @endif
                     @endif
                </div>
            </div>
        </div>
        @else
        <div></div>
        @endif
    </section>
    <section>
        <div class="container ptb--50">
            @if($cart->count() > 0)
            <div class="row">
                <div class="col-md-6 col-sm-7 col-xs-12">
                    @if(Session::has('coupon'))

                    @else

                    <form method="post" action="{{ route('apply.coupon') }}">
                        @csrf
                        <div class="coupon">
                            <h3>Coupon</h3>
                            <p>Enter your coupon code if you have one.</p>
                            <input type="text" name="coupon" class="form-control" required=""
                                placeholder="Enter Your Coupon" />
                            <input type="submit" value="Apply Coupon" />
                        </div>
                    </form>
                    @endif
                    
                </div>
                <div class="col-md-6 col-sm-5 col-xs-12">
                <div class="cart_totals">
                        <h3>Cart Total</h3>
                        <ul>
                            @if(Session::has('coupon'))
                            <li>Subtotal : <span class="amount">
                                GH₵ {{ number_format(Session::get('coupon')['balance'],2) }} </span> 
                            </li>
                            <li>Coupon : ({{ Session::get('coupon')['name'] }} )
                                <a href="{{ route('remove.coupon') }}" class="btn btn-danger btn-sm">X</a>
                                <span class="amount">{{ Session::get('coupon')['discount'] }} % </span> 
                            </li>
                            @else
                            <li>Subtotal : <span class="amount">
                                GH₵ {{  Cart::Subtotal() }} </span> 
                            </li>
                            @endif

                            @if(Session::has('coupon'))
                            <li>Total : <span class="amount"> GH₵
                                {{ number_format(Session::get   ('coupon')['balance'],2)  }}  </span>
                            </li>
                            @else
                            <li>Total : <span class="amount">GH₵ {{ Cart::Subtotal()}} </span> 
                            </li>
                            @endif
                        </ul>

                        <div>
                            <span class="wc-proceed-to-checkout">
                                <button id="checkout" class="checkout-btn btn" type="button">CHECKOUT</button>
                            </span>
                            <span class="cart_buttons">
                                <button style="height: 50px; background: black;" type="button"
                                    class="btn btn-danger">CANCEL</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
                @else
                <div></div>
                     
                 @endif
        </div>
    </section>
</div>
@endsection
