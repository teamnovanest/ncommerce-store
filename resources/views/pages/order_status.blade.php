@extends('layouts.usernav')
@section('content')


<div>
  <div class="order-detail-header">
  <div><h2 class="az-dashboard-title">Order Tracking</h2></div>
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

@endsection