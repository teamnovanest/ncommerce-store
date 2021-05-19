@extends('layouts.error')

@section('content')
  <div class="error-box">
    <img class="error-box__image" src="{{ asset('assets/img/pagenotfound.svg') }}" alt="">
    <div class='error-text'>
    <h3 class='error-text__heading--1'>Oops!!!</h3>
    <p class='error-text__paragraph'>We seem not to find the page you are looking for</p>
     {{-- <h3 class="error-text__heading--2">Here are some useful links</h3> --}}
     <div class="error-text__links">
      
      <a href="/">Home</>
      <a class="btn__secondary" href="{{ route('dashboard') }}">Login</a>
     </div>
    </div>
  </div> 
  
@endsection