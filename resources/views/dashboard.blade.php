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
                  <th>Product image</th>
                  <th>Date </th>
                  <th>Amount </th>
                  <th>Order Code </th>
                  <th>Status  </th>
                  <th>Action </th>
                </tr>
              </thead>
              <tbody>
            @foreach($order as $row)
                <tr>
                  <td><a href="{{ url('product/details/'.$row->product_id) }}" target="_blank"><img style="height: 100px" src="{{ asset( $row->image_one_secure_url )}}" alt="product images"></a></td>
                  <th>{{ $row->date }}</th>
                  <td>{{ $row->total }}$</td>
                  <td>{{ $row->order_code }}</td>
                  <td> 
                    @if($row->status_name === null) 
                      <span class="badge badge-warning">Pending</span>
                    @endif
                      <span class="badge badge-warning">{{$row->status_name}}</span>
                  </td>
                  <td><a href="{{ route('order.status',['id'=>$row->id])}}" class="btn btn-sm btn-info"> View</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div><!-- table-responsive -->
        </div><!-- container -->
    </div><!-- az-footer -->
</div><!-- az-content-body -->
</div>
</div>
@endsection
