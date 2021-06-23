@extends('layouts.usernav')
@section('content')


<div>
  <div class="order-detail-header">
    <div><h2 class="az-dashboard-title">Order Tracking</h2>
    @if ($current_status->status_id === 7 || $current_status->status_id === 8 || $current_status->status_id === 9)
    <h6><a href="#location">View pick up location</a></h6>
    @endif
    </div>
  </div>
  <div class="background">
    <div class="container">
      <div class="row header text-center element">
          <div class="col-xs-6 order">
            <div class="order-number">
              Order # {{ $order_code->order_code}}
            </div>
              
            @if($current_status === null)
            <div class="order-status">
            ORDER REJECTED
            </div>
            @else
            <div class="order-status">
              {{$current_status->status_name}}
            </div>
            @endif
          </div>
        </div>
      <div class="row content">
        <div class="timeline">
        @foreach($order_status as $status)
          <div class="item">
          @if($status->updated_at === null)
            <div class="item-label">
              <div class="item-label-date">
              {{date('Y-m-d',strtotime($status->created_at))}}
              </div>
            
              <div class="item-label-hour">
                {{date('H:i',strtotime($status->created_at))}}
              </div>
            </div>
            @endif

            @if($status->updated_at !== null)
            <div class="item-label">
              <div class="item-label-date">
              {{date('Y-m-d',strtotime($status->updated_at))}}
              </div>
              <div class="item-label-hour">
                {{date('H:i',strtotime($status->updated_at))}}
              </div>
            </div>
            @endif
            <div class="item-description">       
              @if($status->status_id !== 0)
              <div class="item-description-status">
                {{$status->description}}
              </div>
              <div class="item-description-location text-success">
                {{$status->status_name}}
              </div>
              @elseif($status->status_id === 0)
                <div class="item-description-location text-danger">
                ORDER REJECTED
              </div>
              <div class="item-description-status">
                {{$reason->reason_for_rejection}}
              </div>     
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<br>
<!-- Pickup Adress -->
 
 
@if ($current_status->status_id === 7 || $current_status->status_id === 8 || $current_status->status_id === 9)
      <div id="location" >
        <div class="az-content pd-y-20 pd-lg-y-30 pd-xl-y-40">
            <h3 class="text-center az-dashboard-title">Pick up location</h3>
            <br>
            <div class="container">
                <div class="az-content-body pd-lg-l-40 d-flex flex-column">
                    <div class="table-responsive table-bordered">
                        <table class="table mg-b-0">
                            <thead>
                                <tr>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Alt Phone</th>
                                    <th>Region</th>
                                    <th>City</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr>
                                    <td>{{$settings->address ?? ''}}</td>
                                    <td>{{$settings->phone ?? ''}}</td>
                                    <td>{{$settings->alt_phone ?? ''}}</td>
                                    <td>{{$settings->region_name ?? ''}}</td>
                                    <td>{{$settings->city_name ?? ''}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- container -->
            </div><!-- az-footer -->
        </div><!-- az-content-body -->
    </div>
@endif

@endsection