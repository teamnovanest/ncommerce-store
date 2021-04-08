@extends('layouts.store')

@section('content')
  <div class="bg-gray-50 text-gray-700">
    <div class="container mx-auto p-8 flex">
        <div class="max-w-md w-full mx-auto">
            <h1 class="text-3xl text-center mb-12">Create an account</h1>

            <div class="bg-white rounded-lg overflow-hidden shadow-2xl">
             <div class="p-8">
                <x-jet-validation-errors class="mb-4" />

                    <form method="POST" class="" action="{{ route('register') }}">
                      @csrf
                        <div class="mb-5">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-600">Full Name</label>

                            <input type="text" placeholder="Full name" name="name" value="{{old('name')}}" class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none" required autofocus>
                        </div>

                        <div class="mb-5">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-600">Email</label>

                            <input type="text" placeholder="Enter a valid email" name="email" value="{{old('email')}}" class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none" required>
                        </div>
                
                        <div class="mb-5">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-600" required>Password</label>

                            <input type="password" placeholder="Enter password" name="password" class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none" required>
                        </div>

                        <div class="mb-5">
                            <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-600">Confirm Password</label>

                            <input type="password" placeholder="Confirm password" name="password_confirmation" class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none" required>
                        </div>

                        <button class="w-full p-3 mt-1 bg-indigo-600 text-white rounded shadow">Register</button>
                    </form>
                </div>
                
                <div class="flex justify-between p-8 text-sm border-t border-gray-300 bg-gray-100">
                    <a href="{{ route('login') }}" class="font-medium text-indigo-500">Login</a>

                    <a href="#" class="text-gray-600">Forgot password?</a>
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection