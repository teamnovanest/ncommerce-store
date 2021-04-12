@extends('layouts.usernav')
@section('content')
<div class="order-detail-header">
<div class="welcome-message"> 
    <h2 class="az-dashboard-title">Hi, {{ Auth::user()->name }}</h2>
    <p class="az-dashboard-text"> Request a feature you want to be added </p>
</div>
<div class="section-center">
    <div class="az-content pd-y-20 pd-lg-y-30 pd-xl-y-40">
        <form action="{{route('feature.save')}}" method="POST">
            @csrf
        <div class="container">
            <div class="form-group has-success mg-b-0  col-md-9 col-sm-12 mx-auto">
                <input class="form-control" placeholder="Feature Tittle"  required type="text" name="title">
                <textarea rows="5" class="form-control mg-t-20"  required name="description" >Feature Description
                </textarea>
                <input type="submit" class="form-control-btn mg-t-20"></input>
            </div><!-- form-group -->
        </div><!-- col -->
    </form>
    </div>
</div>
</div>
</div>
</div>
@endsection
