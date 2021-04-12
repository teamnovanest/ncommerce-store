@extends('layouts.usernav')
@section('content')
<div class="order-detail-header">
<div class="welcome-message"> 
    <h2 class="az-dashboard-title">Hi! {{ Auth::user()->name }}</h2>
      <p class="az-dashboard-text">Feature Requests</p>
</div>
<div class="sec-center">
  <div class="az-content pd-y-20 pd-lg-y-30 pd-xl-y-40">
    <div class="container">
        <div class="az-content-body pd-lg-l-40 d-flex flex-column">
          <div class="table-responsive">
            <table class="table mg-b-0">
              <thead>
                <tr>
                  <th>Feature title</th>
                  <th>Feature Description</th>
                  <th>Action </th>
                </tr>
              </thead>
              <tbody>
              
            @foreach($requests  as $request)
                <tr>
                  <td>{{ $request->title }}</td>
                  <td>{{ $request->description }}</td>
                  
                  <td>
                    @if ($request->user_id === Auth::id())
                    <a href="{{route('feature.edit',['id'=>$request->id])}}" class="btn btn-sm btn-info">Edit</a>
                    @else
                    <button class="like-btn" data-request-id="{{$request->id}}"><i class="material-icons" id="thumbsup{{$request->id}}">thumb_up_off_alt</i></button>
                    @endif
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
</div>
@endsection
