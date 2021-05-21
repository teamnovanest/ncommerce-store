@extends('layouts.error')

@section('content')
  <div class="error-box">
    <img class="error-box__image" src="{{ asset('assets/img/login.svg') }}" alt="">
    <div class='error-text'>
    <h3 class='error-text__heading--1'>We are sorry...</h3>
    <p class='error-text__paragraph'>You don't have the right permission to access this page</p>
     {{-- <h3 class="error-text__heading--2">Here are some useful links</h3> --}}
     <div class="error-text__links">
      {{-- <a href="{{ route('dashboard') }}">Dashboard</a> --}}
      <a class="btn__secondary" href="{{ route('user.logout') }}">Login</a>
     </div>
    </div>
  </div> 

@endsection