@extends('layouts.store')

@section('content')
  <div class="bg-gray-50 text-gray-700">
    <div class="container mx-auto p-8 flex">
        <div class="max-w-md w-full mx-auto">
            <h1 class="text-3xl text-center mb-12">Forgot Password</h1>

            <div class="bg-white rounded-lg overflow-hidden shadow-2xl">
             <div class="p-8">
                    <p class="mb-4 font-medium">Please provide your email address and we will email you a password reset link that will allow you to choose a new one.</p>

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                     <x-jet-validation-errors class="mb-4" />

                    <form method="POST" class="" action="{{ route('password.email') }}">
                      @csrf

                        <div class="mb-5">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-600">Email</label>

                            <input type="email" placeholder="Enter a valid email" name="email" value="{{old('email')}}" class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none" required autofocus>
                        </div>

                        <button class="w-full p-3 mt-1 bg-indigo-600 text-white rounded shadow">Email Password reset link</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection