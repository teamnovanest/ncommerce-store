@extends('layouts.usernav')
@section('content')


<div>
  <div class="order-detail-header">
  <div><h2 class="az-dashboard-title">Order Detail</h2></div>
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
           ORDER PENDING
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
              {{date('H-i',strtotime($status->created_at))}}
            </div>
          </div>
          @endif

           @if($status->updated_at !== null)
          <div class="item-label">
            <div class="item-label-date">
            {{date('Y-m-d',strtotime($status->updated_at))}}
            </div>
            <div class="item-label-hour">
              {{date('H-i',strtotime($status->updated_at))}}
            </div>
          </div>
          @endif
          <div class="item-description">
            @if($status->description === null)
            <div class="item-description-status">
               Order Pending
            </div>
               @endif
               
            
            <div class="item-description-status">
              {{$status->description}}
            </div>
            @if($status->status_name === null)
            <div class="item-description-location text-warning">
             ORDER PENDING
            </div>
            @elseif($status->status_name === 'ORDER REJECTED')
              <div class="item-description-location text-danger">
              {{$status->status_name}}
            </div>
            <div class="item-description-status">
               {{$current_status->reason_for_rejection}}
            </div>
            @else
            <div class="item-description-location text-success">
              {{$status->status_name}}
            </div>
            @endif
          </div>
        </div>
        @endforeach
        <!-- <div class="item">
          <div class="item-label">
            <div class="item-label-date">
            13.11.2016
            </div>
            <div class="item-label-hour">
              12:38
            </div>
          </div>
          <div class="item-description">
            <div class="item-description-status">
              The shipment is ready to be picked up
            </div>
            <div class="item-description-location">
              Beijing
            </div>
          </div>
        </div>
        <div class="item">
          <div class="item-label">
            <div class="item-label-date">
              14.11.2016
            </div>
            <div class="item-label-hour">
              03:24
            </div>
          </div>
          <div class="item-description">
            <div class="item-description-status">
              The shipment has been processed in location
            </div>
            <div class="item-description-location">
              Beijing
            </div>
          </div>
        </div>
        <div class="item active">
          <div class="item-label">
            <div class="item-label-date">
            17.11.2016
            </div>
            <div class="item-label-hour">
              10:19
            </div>
          </div>
          <div class="item-description">
            <div class="item-description-status">
              The shipment has been processed in location
            </div>
            <div class="item-description-location">
              Tianjin
            </div>
          </div>
        </div> -->
      </div>
    </div>
</div>
</div>
</div>

@endsection