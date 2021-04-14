@extends('layouts.store')

@section('content')
  <div class="bg-gray-50 text-gray-700">
    <div class="container mx-auto p-8 flex">
        <div class="max-w-md w-full mx-auto">
            <h1 class="text-3xl text-center mb-12">Reset password</h1>

            <div class="bg-white rounded-lg overflow-hidden shadow-2xl">
             <div class="p-8">
                <x-jet-validation-errors class="mb-4" />

                    <form method="POST" class="" action="{{ route('password.update') }}">
                      @csrf
                       <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="mb-5">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-600">Email</label>

                            <input id="email" type="email" name="email" class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none" value={{ old('email', $request->email) }} required autofocus>
                        </div>

                        <div class="mb-5">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-600">Password</label>

                            <input type="password" name="password" class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none" required autocomplete="new-password">
                        </div>

                        <div class="mb-5">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-600">Confirm Password</label>

                            <input type="password" name="password_confirmation" class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none" required autocomplete="new-password">
                        </div>

                        <button class="w-full p-3 mt-1 bg-indigo-600 text-white rounded shadow">Reset Password</button>
                    </form>
                </div>
            </div>
               </div>
    </div>
</div>  
    
@endsection