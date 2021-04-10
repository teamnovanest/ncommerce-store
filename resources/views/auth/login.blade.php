@extends('layouts.store')

@section('content')
  <div class="bg-gray-50 text-gray-700">
    <div class="container mx-auto p-8 flex">
        <div class="max-w-md w-full mx-auto">
            <h1 class="text-3xl text-center mb-12">Login</h1>

            <div class="bg-white rounded-lg overflow-hidden shadow-2xl">
             <div class="p-8">
                <x-jet-validation-errors class="mb-4" />

                   @if (session('status'))
                       <div class="mb-4 font-medium text-sm text-green-600">
                           {{ session('status') }}
                       </div>
                   @endif

                    <form method="POST" class="" action="{{ route('login') }}">
                      @csrf
                        <div class="mb-5">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-600">Email</label>

                            <input type="text" placeholder="Enter a valid email" name="email" class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none">
                        </div>

                        <div class="mb-5">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-600">Password</label>

                            <input type="password" placeholder="Enter account password" name="password" class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none">
                        </div>

                        <button class="w-full p-3 mt-1 bg-indigo-600 text-white rounded shadow">Login</button>
                    </form>
                </div>

                <div class="flex justify-between p-8 text-sm border-t border-gray-300 bg-gray-100">
                    <a href="{{ route('register') }}" class="font-medium text-indigo-500">Create account</a>
                    {{-- Check on the password reset email sending --}}
                    @if (Route::has('password.request'))  
                        <a href="{{ route('password.request') }}" class="text-gray-600">Forgot password?</a>
                    @endif
                </div>
            </div>
               </div>
    </div>
</div>  
    
@endsection