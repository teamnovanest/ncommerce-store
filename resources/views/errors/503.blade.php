@extends('layouts.error')

@section('content')
   <div class="error-box">
    <img class="error-box__image" src="{{ asset('assets/img/construction.svg') }}" alt="">
    <div class='error-text'>
    <h3 class='error-500 error-text__heading--1'>We'll be right back</h3>
    <p class='error-text__paragraph'>We are temporarily under maintenance. We hope to <br> not keep you waiting for long</p>
    </div>
  </div> 
@endsection