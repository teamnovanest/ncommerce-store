@extends('layouts.store')

@section('content')

        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Wishlist</h2>
                                <!-- <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="/">Home</a>
                                  <span class="brd-separetor">/</span>
                                  <span class="breadcrumb-item active">Wishlist</span>
                                </nav> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- wishlist-area start -->
        <div class="wishlist-area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="wishlist-content">
                            <form action="#">
                                <div class="wishlist-table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-remove"><span class="nobr">Remove</span></th>
                                                <th class="product-thumbnail">Image</th>
                                                <th class="product-name"><span class="nobr">Product Name</span></th>
                                                <th><span class="nobr"> Color</span></th>
                                                <th><span class="nobr"> Size </span></th>
                                                <th><span class="nobr">View Product</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                              @foreach($product as $row)
                                            <tr>
                                                <td class="product-remove"><a href="{{ url('delete/wishlist/'.$row->id)}}">×</a></td>
                                                <td class="product-thumbnail"><a href="#"><img src="{{ asset($row->image_one_secure_url) }}" alt="" /></a></td>
                                                <td class="product-name">{{ $row->product_name  }}</td>
												@if($row->product_color == NULL)
                                                <td><span></span></td>
                                                @else
                                                <td><span>{{ $row->product_color }}</span></td>
												@endif

												@if($row->product_size == NULL)
                                                <td><span></span></td>
                                                @else
                                                <td><span>{{ $row->product_size }}</span></td>
												@endif
                                                <td class="product-add-to-cart"><a href="{{ url('product/details/'.$row->id) }}">View</a></td>
                                            </tr>
                                        </tbody>
										@endforeach
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="wishlist-share">
                                                        <h4 class="wishlist-share-title">Share on:</h4>
                                                        <div class="social-icon">
                                                            <ul>
                                                                <li><a href="#"><i class="zmdi zmdi-rss"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-vimeo"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-tumblr"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-pinterest"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-linkedin"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- wishlist-area end -->
@endsection