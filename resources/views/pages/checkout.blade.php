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
                            @php
                            $order = [];
                            @endphp

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
                                    <td class="product-thumbnail"><a href="#"><img src="{{ asset($row->options->image) }}" alt="product img" /></a></>
                                    <td class="product-price">GH₵ {{ number_format($row->price,2) }}</td>
                                    <td class="product-subtotal">GH₵ <span>{{ number_format($row->price*$row->qty,2) }}</span></td>
                                    <td class="product-remove"><a href="{{ url('remove/cart/'.$row->rowId ) }}">X</a>
                                    </td>
                                </tr>
                                @php
                                
                                  array_push($order, ['product_id' => $row->id, 'quantity' => $row->qty,'color' => $row->options->color, 'size' => $row->options->size, 
                                  'merchant_id' => $row->options->merchant_organization_id, 'product_name' => $row->name, 'price' => $row->price, 'totalprice' => $row->price * $row->qty ]); 
                                @endphp
                                @endforeach
      
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start: Pay online without finance -->
    <section>
         <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5">
        @if($cart->count() > 0)

        <div class="container">
            <h4 class="pb--30 text-center">PAY WITHOUT FINANCING</h4>
            <div class="row">
                <div class="col-md-12">


                    <form id="paymentForm">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email-address" @if (Auth::check()) value="{{auth()->user()->email}}"  @endif />
                        </div>
                        <div class="form-group">
                            <!-- <label for="amount">Amount</label> -->
                           <input type="hidden" id="amount-cart"  step="0.01" min="0" value="0" disabled/>
                        </div>
                        <div class="form-group">
                            <label for="first-name">First Name</label>
                            <input type="text" id="first-name"  @if (Auth::check()) value="{{explode(' ',auth()->user()->name)[0] }}" @endif />
                        </div>
                        <div class="form-group">
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last-name" @if (Auth::check()) value="{{explode(' ',auth()->user()->name)[1] }}" @endif />
                        </div>
                        <div class="form-submit">
                            <button type="button" class="checkout-btn btn" id="pay-btn" onclick="payWithPaystack()">CHECKOUT WITH PAYMENT </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        @endif
  
    </div>
    <!-- End: Pay online without finance -->

    <div class="overlay" id="loader">
        <div class="overlay__inner">
            <div class="overlay__content"><span class="loader_spinner"></span></div>
        </div>
    </div>

  <div class="col-lg-6 mb-5">
      @if (isset($special_association_offers) || isset($credit_offers))
          
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
                                            <input class="form-check-input" type="radio" name="lenderOfferingRadio" id="{{$offer->id}}" value="{{$offer->id}}" data-id="{{$offer->id}}">
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
                                    @if (floatval(str_replace(",","",Cart::Subtotal())) <= ($offer->max_financed / 100))

                                        <div class="col-2 col-lg-1 col-md-2 col-xs-2">
                                            <input class="form-check-input" type="radio" name="lenderOfferingRadio" id="{{$offer->id}}" value="{{$offer->id}}" data-id="{{$offer->id}}">
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
                                            Total Interest on price GH₵ {{(($offer->percentage * ($row->price * $row->qty)) / 100 )}}
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
        @endif
</div>
@else
<div></div>
@endif
</div>
</div>
</div>
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
                        <input type="text" name="coupon" class="form-control" required="" placeholder="Enter Your Coupon" />
                        <input type="submit" value="Apply Coupon" />
                    </div>
                </form>
                @endif

            </div>
           @if (isset($special_association_offers) || isset($credit_offers))
            <div class="col-md-6 col-sm-5 col-xs-12">
                <div class="cart_totals">
                    <h3>Cart Total</h3>
                    <ul>
                        @if(Session::has('coupon'))
                        <li>Subtotal : <span class="amount">
                                GH₵ {{ number_format(Session::get('coupon')['balance'],2) }} </span>
                        </li>
                        <li>Total : GH₵<span class="amount" id="cart-total"> 
                                {{ number_format(Session::get   ('coupon')['balance'],2)  }} </span>
                        </li>
                        <li>Coupon : ({{ Session::get('coupon')['name'] }} )
                            <span class="amount">{{ Session::get('coupon')['discount'] }} % </span>
                            <a href="{{ route('remove.coupon') }}" class="btn btn-danger btn-sm ml-1">X</a>
                        </li>
                        @else
                        <li>Subtotal : <span class="amount">
                                GH₵ {{ Cart::Subtotal() }} </span>
                        </li>
                         <li>Total : GH₵ <span class="amount" id="cart-total">{{ Cart::Subtotal()}} </span>
                        </li>
                        @endif
                    </ul>

                    <div>
                        <span class="wc-proceed-to-checkout">
                            <button id="checkout" class="checkout-btn btn" type="button">CHECKOUT WITH FINANCE</button>
                        </span>
                        {{-- <span class="cart_buttons">
                            <button style="height: 50px; background: black;" type="button" class="btn btn-danger">CANCEL</button>
                        </span> --}}
                    </div>
                </div>
            </div>
              @endif
        </div>
        @else
        <div></div>

        @endif
    </div>
</section>
</div>

<script>


(function() {
   

    function uuidv4() {
        return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
          (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
        );
      }
      
    
    var purchaseSubtotal = parseFloat(document.querySelector("#cart-total").textContent.replace(',', '')) ;
    var purchaseAmount = purchaseSubtotal * 100;
 

  
    // Get php varibale and use them
    var paymentPublicKey =  {!! json_encode(env('PAYMENT_PUBLIC_KEY')) !!};
    var order =  {!! json_encode($order) !!};
    var customerId =  {!! json_encode(auth()->user()->id) !!};
  
    var loader = document.getElementById("loader");

    var payWithPaystack = function (e) {
      
        e.preventDefault();
        var handler = PaystackPop.setup({
            key: paymentPublicKey, // Replace with your public key
            currency: 'GHS',
            email: document.getElementById("email-address").value,
            amount: purchaseAmount,
            channels:['card','mobile_money'],
             // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            // label: "Optional string that replaces customer email",
            metadata:{
                order: order,
                customerId: customerId

            },
            onClose: function () {
              Swal.fire({
                icon: 'error',
                text: 'Window closed!',
                });
            },
            callback: async function (response) {
                var message = 'Payment complete! Reference: ' + response.reference;

                //start loader
                loader.classList.add("show_loader");
                fetch(`/payment/verify/${response.reference}`, {
                    method: 'get',
                    headers:{
                        'Content-Type': 'application/json',
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => response.json())
                .then(data => {
                      // Stop a loading here
                    loader.classList.remove('show_loader');
                    if (data.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: data.success,
                            showCloseButton: true,
                        });
                        window.location.href="/dashboard";     
                    } else {
                         Swal.fire({
                        icon: "error",
                        title: "Error",
                        text:data.error ,
                        showCloseButton: true,
                    }); 
                    }
                })
                .catch((error) => {
                     // Stop a loading here
                    loader.classList.remove('show_loader');
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text:error.error,
                        showCloseButton: true,
                    });
                });
                
            }
        });
        handler.openIframe();
    }
    var payButton = document.querySelector('#pay-btn');
    
    payButton.addEventListener("click", payWithPaystack, false);
})();

</script>
@endsection