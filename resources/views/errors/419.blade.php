@extends('layouts.error')

@section('content')
   <div class="error-box">
    <img class="error-box__image" src="{{ asset('assets/img/sessionexpired.svg') }}" alt="">
    <div class='error-text'>
    <h3 class='error-text__heading--1'>Your session has expired</h3>
    <p class='error-text__paragraph'>Your session expired due to your inactivity. No worry, simply login again</p>
     {{-- <h3 class="error-text__heading--2">Here are some useful links</h3> --}}
     <div class="error-text__links">
      <a class="btn__secondary" href="{{ route('user.logout') }}">Login</a>
     </div>
    </div>
  </div> 
@endsection