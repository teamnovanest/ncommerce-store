@extends('layouts.usernav')
@section('content')
<div class="order-detail-header">
<div class="welcome-message"> 
    <h2 class="az-dashboard-title">Hi, {{ Auth::user()->name }}</h2>
    <p class="az-dashboard-text"> Edit your feature request</p>
</div>
<div class="section-center">
    <div class="az-content pd-y-20 pd-lg-y-30 pd-xl-y-40">
        <form action="{{ route('feature.update',['id'=>$request->id]) }}" method="post">
            @csrf
        <div class="row">
            <div class="col-md-8 mx-auto">            
            <div class="form-group has-success mg-b-0">
                <input class="form-control" value="{{$request->title}}" required type="text" name="title">
            </div><!-- form-group -->
            <div class="form-group has-success mg-b-0">
                <textarea rows="5" class="form-control mg-t-20"  required name="description">{{$request->description}} 
                </textarea>
            </div><!-- form-group -->
            <input type="submit" class="form-control-btn mg-t-20"></input>
            </div>
        </div><!-- col -->
    </form>
    </div>
</div>
</div>
</div>
</div>
@endsection
