
    @if(Request::is('user/checkout'))
    
    <section>
        <div class="container">
            <h4 class="pb--30 text-center">FINANCE PAYMENT PLANS</h4>
            <div class="row">
                <div class="col-md-12">
                    <ul class="">

                        @foreach($credit_offers as $offer)

                        <li class="h3">
                            <div class="form-check">
                                <div class="row">
                                    @foreach($cart as $row)
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


                                                <p>Total financed GHC
                                                    {{ (($offer->percentage  * ($row->price * $row->qty)) / 100 ) +  ($row->price * $row->qty) }}
                                                </p>

                                                <p>
                                                    Commission GHC {{(($offer->percentage  * ($row->price * $row->qty)) / 100 )}}
                                                </p>
                                            </label>
                                        </div>
                                        @endif
                                        @endforeach
                                </div>
                            </div>
                        </li>
                        <hr />
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </section>
    @else









    <section>
    <div class="container">
        <h1 class="offer-header">Financial Institution Offers</h1>
        <div class="row">
        @if(!$credit_offers->isEmpty())
            @foreach($credit_offers as $offer)
            <div class="col-lg-1">
                <ul>
                    <li class="h3">
                        <!-- <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="{{-- $offer->id --}}" value="{{-- $offer->id --}}" >
                        </div> -->
                    </li>    
                </ul>
            </div>
            <div class="col-lg-5">
                <label class="form-check-label" for="{ $offer->id}">
                        <p class="card-hover title__5">
                        {{ $offer->lender->registered_name}}  finances  at  {{ $offer->percentage }}%  for {{ $offer->payment_period }} months
                        </p>
                        <p>Total financed  {{ (($offer->percentage  * $product->selling_price) / 100 ) +  $product->selling_price }}</p>
                </label>
            <hr>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section> 


    @endif
