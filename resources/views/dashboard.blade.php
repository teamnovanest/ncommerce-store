@extends('layouts.usernav')
@section('content')

<div class="order-detail-header">
<div class="welcome-message"> 
    <h2 class="az-dashboard-title">Hi, welcome back! {{ Auth::user()->name }}</h2>
      <p class="az-dashboard-text">Dashboard.</p>
</div>
<div class="section-center">
  <div class="az-content pd-y-20 pd-lg-y-30 pd-xl-y-40">
    <div class="container">
        <div class="az-content-body pd-lg-l-40 d-flex flex-column">
          <div class="table-responsive">
            <table class="table mg-b-0">
              <thead>
                <tr>
                  <th>Product name</th>
                  <th>Product image</th>
                  <th>Date </th>
                  <th>Amount </th>
                  <th>Total Financed</th>
                  <th>Order Code </th>
                  <th>Status  </th>
                  <th>Action </th>
                </tr>
              </thead>
              <tbody>
            @foreach($order as $row)
                <tr>
                  <td><a href="{{ url('product/details/'.$row->product_id.'/'.$row->slug) }}" target="_blank">{{$row->product_name}}</a></td>
                  <td><a href="{{ url('product/details/'.$row->product_id.'/'.$row->slug) }}" target="_blank"><img style="height: 100px" src="{{ asset( $row->image_one_secure_url )}}" alt="product images"></a></td>
                  <th>{{date('j F, Y', strtotime($row->created_at)) }}</th>
                  <td>GHC {{ number_format($row->total / 100,2)}}</td>
                  <td>GHC {{ number_format(((($row->total / 100) * $row->percentage * ($row->payment_period/12)) / 100) + ($row->total/100),2)}}</>
                  <td>{{ $row->order_code }}</td>
                  <td> 
                    @if($row->status_id === 0) 
                      <span class="badge badge-danger">ORDER_REJECTED</span>
                    @elseif ($row->status_id === 1)
                    <span class="badge badge-warning">{{$row->status_name}}</span>
                    @else
                    <span class="badge badge-success">{{$row->status_name}}</span>
                    @endif
                  </td>
                  <td><a href="{{ route('order.status',['id'=>$row->id,'orderDetailId'=>$row->order_detail_id])}}" class="btn btn-sm btn-info"> View</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div><!-- table-responsive -->
        </div><!-- container -->
    </div><!-- az-footer -->
</div><!-- az-content-body -->
<div class="center-pagination">
    {{ $order->links() }}
</div>
</div>
</div>
@endsection
