@extends('layouts.error')

@section('content')
   <div class="error-box">
    <img class="error-box__image" src="{{ asset('assets/img/server_down.svg') }}" alt="">
    <div class='error-text'>
    <h3 class='error-500 error-text__heading--1'>Sorry, something went wrong</h3>
    <p class='error-text__paragraph'>We are having an issue, please try one of these options to get you back on track</p>
     {{-- <h3 class="error-text__heading--2">Here are some useful links</h3> --}}
     <div class="error-text__links">
      <a href="/">Home</a>
      <a class="btn__secondary" href="{{ route('dashboard') }}">Dashboard</a>
     </div>
    </div>
  </div> 
@endsection