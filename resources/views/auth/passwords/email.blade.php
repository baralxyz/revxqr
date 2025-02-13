@extends('layouts.guest')

{{-- Custom CSS --}}
@section('custom-css')
<title>{{ __('Reset Password') }}</title>
@endsection

@section('content')
{{-- Queries --}}
@php
use App\Models\Config;
use App\Models\Setting;
$config = Config::get();
$setting = Setting::where('status', 1)->first();
@endphp

{{-- Forget Password --}}
<section class="relative pt-16 pb-0 md:py-22 bg-white"
    style="background-image: url('{{ asset('images/web/elements/pattern-white.svg') }}'); background-position: center;">
    <div class="container px-4 mx-auto mb-16">
        <div class="w-full">
            <div class="max-w-sm mx-auto">
                <div class="mb-6 text-center">
                    <a class="inline-block mb-6" href="{{ route('web.index') }}">
                        <img class="h-16" src="{{ asset($setting->site_logo) }}" alt="{{ config('app.name') }}">
                    </a>
                    <h3 class="mb-4 text-2xl md:text-3xl font-bold">{{ __('Reset Password') }}</h3>
                </div>

                {{-- Success --}}
                @if (session('status'))
                <div class="alert flex flex-row items-center bg-{{ $config[11]->config_value }}-200 p-5 rounded border-b-2 border-{{ $config[11]->config_value }}-300 mb-3">
                    <div
                        class="alert-icon flex items-center bg-{{ $config[11]->config_value }}-100 border-2 border-{{ $config[11]->config_value }}-500 justify-center h-10 w-10 flex-shrink-0 rounded-full">
                        <span class="text-{{ $config[11]->config_value }}-500">
                            <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="alert-content ml-4">
                        <div class="alert-description text-sm text-{{ $config[11]->config_value }}-600">
                            {{ session('status') }}
                        </div>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    {{-- Email --}}
                    <div class="mb-6">
                        <label class="block mb-2 text-coolGray-800 font-medium" for="email">{{ __('Email*') }}</label>
                        <input
                            class="appearance-none block w-full p-3 leading-5 text-coolGray-900 border border-coolGray-200 rounded-lg shadow-md placeholder-coolGray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 @error('email') is-invalid @enderror"
                            type="email" id="email" name="email" value="{{ old('email') }}" required
                            autocomplete="email" autofocus placeholder="{{ __('dev@domain.com') }}">

                        @error('email')
                        <span class="invalid-feedback mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <button type="submit"
                        class="inline-block py-3 px-7 mb-6 lg:mb-0 lg:mr-3 w-full lg:full py-2 px-6 leading-loose bg-{{ $config[11]->config_value }}-500 hover:bg-{{ $config[11]->config_value }}-700 text-white font-semibold rounded-l-xl rounded-t-xl transition duration-200 text-center">{{
                        __('Send Password Reset Link') }}</button>

                    {{-- Back to Home --}}
                    <a class="inline-block py-3 px-7 mb-6 lg:mb-0 lg:mr-3 w-full lg:full py-2 px-6 leading-loose bg-gray-900 hover:bg-gray-700 text-white font-semibold rounded-l-xl rounded-t-xl transition duration-200 text-center mt-3"
                        href="{{ route('web.index') }}">{{ __('Go back to Homepage') }}</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection