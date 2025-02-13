@extends('layouts.guest')

{{-- Custom CSS --}}
@section('custom-css')
<title>{{ __('Confirm Password') }}</title>
@endsection

@php
// Settings
use App\Models\Setting;
$setting = Setting::where('status', 1)->first();
@endphp

@section('content')
{{-- Confirm Password --}}
<section class="relative pt-16 pb-0 md:py-22 bg-white"
    style="background-image: url('{{ asset('images/web/elements/pattern-white.svg') }}'); background-position: center;">
    <div class="container px-4 mx-auto mb-16">
        <div class="w-full">
            <div class="max-w-sm mx-auto">
                <div class="mb-6 text-center">
                    <a class="inline-block mb-6" href="{{ route('web.index') }}">
                        <img class="h-16" src="{{ asset($setting->site_logo) }}" alt="{{ config('app.name') }}">
                    </a>
                    <h3 class="mb-4 text-2xl md:text-3xl font-bold">{{ __('Confirm Password') }}</h3>
                </div>

                {{-- Information --}}
                <div class="alert flex flex-row items-center bg-red-200 p-5 rounded border-b-2 border-red-300 mb-3">
                    <div
                        class="alert-icon flex items-center bg-red-100 border-2 border-red-500 justify-center h-10 w-10 flex-shrink-0 rounded-full">
                        <span class="text-red-500">
                            <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="alert-content ml-4">
                        <div class="alert-description text-sm text-red-600">
                            {{ __('Please confirm your password before continuing.') }}
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    {{-- Password --}}
                    <div class="mb-1">
                        <label class="block mb-2 text-coolGray-800 font-medium" for="password">{{ __('Password*')
                            }}</label>
                        <input
                            class="appearance-none block w-full p-3 leading-5 text-coolGray-900 border border-coolGray-200 rounded-lg shadow-md placeholder-coolGray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 @error('password') is-invalid @enderror"
                            type="password" name="password" id="password" required autocomplete="current-password"
                            placeholder="{{ __('************') }}">

                        @error('password')
                        <span class="invalid-feedback mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <a class="ml-7 text-xs text-coolGray-800 font-medium float-right" title="Show password"
                            data-bs-toggle="tooltip" onclick="showPassword()">{{ __('Show / Hide Password')}}</a>
                    </div>

                    <button type="submit"
                        class="inline-block py-3 px-7 mb-4 w-full text-base text-blue-50 font-medium text-center leading-6 bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm">{{
                        __('Confirm Password') }}</button>

                    {{-- Forget password --}}
                    <div class="flex flex-wrap items-center justify-between mb-6">
                        @if (Route::has('password.request'))
                        <div class="w-full md:w-auto mt-1"><a
                                class="inline-block text-xs font-medium text-blue-500 hover:text-blue-600"
                                href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a></div>
                        @endif
                    </div>

                    {{-- Back to Home --}}
                    <a class="inline-block py-3 px-7 w-full text-base md:text-lg leading-4 text-red-50 font-medium text-center bg-red-500 hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 border border-red-500 rounded-md shadow-sm"
                        href="{{ route('login') }}">{{ __('Go back to Login') }}</a>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- Show / Hide Password --}}
@section('custom-js')
<script>
    function showPassword() {
        "use strict";
        var temp = document.getElementById("password");
        if (temp.type === "password") {
            temp.type = "text";
        } else {
            temp.type = "password";
        }
    }
</script>
@endsection
@endsection