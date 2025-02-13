@extends('layouts.guest')

@section('content')
{{-- Topbar --}}
@include('website.includes.topbar')

@php
use App\Models\Page;
$page = Page::where('slug', 'pricing')->where('status', 1)->get();
@endphp

{{-- Pricing --}}
<section class="py-20 xl:py-24 bg-white"
    style="background-image: url('{{ asset('images/web/elements/pattern-white.svg') }}'); background-position: center;">
    <div class="container px-4 mx-auto">
        <div class="text-center">
            <span
                class="inline-block py-px px-2 mb-4 text-xs leading-5 text-{{ $config[11]->config_value }}-500 bg-{{ $config[11]->config_value }}-100 font-medium uppercase rounded-9xl">{{ __($page[0]->body) }}</span>
            <h3 class="mb-4 text-3xl md:text-5xl text-gray-900 font-bold tracking-tighter">{{ __($page[1]->body) }}</h3>
            <p class="mb-12 text-lg md:text-xl text-gray-500 font-medium">{{ __($page[2]->body) }}</p>
        </div>
        <div class="flex flex-wrap justify-center -mx-4">
            {{-- all plans --}}
            @foreach ($plans as $plan)
            <div class="w-full md:w-1/2 lg:w-1/3 p-4">
                <div
                    class="flex flex-col pt-8 pb-8 bg-gray-50 rounded-md shadow-md hover:scale-105 transition duration-500">
                    <div class="px-8 pb-8">
                        <h3 class="mb-6 text-lg md:text-xl text-gray-800 font-medium">{{ __($plan->plan_name) }}</h3>
                        <div class="mb-6">
                            @if ($plan->plan_price == 0)
                            <span
                                class="text-6xl md:text-3xl font-semibold {{ $plan->recommended == '1' ? 'text-white' : '' }}">{{ __('Free') }}</span>
                            @endif
                            <span class="relative -top-10 right-1 text-3xl text-gray-900 font-bold">{{
                                $plan->plan_price == '0' ? '' : $currency->symbol }}</span>
                            <span class="text-6xl md:text-7xl text-gray-900 font-semibold">{{ $plan->plan_price == '0' ?
                                '' :
                                $plan->plan_price }}</span>
                            <span class="inline-block ml-1 text-gray-500 font-semibold">@if ($plan->plan_price != '0' &&
                                $plan->validity == '9999')
                                {{ __('forever') }}</span>
                            @endif
                            @if ($plan->validity == '31')
                            {{ __('per month') }}</span>
                            @endif
                            @if ($plan->validity == '366')
                            {{ __('per year') }}</span>
                            @endif
                            @if ($plan->validity > '1' && $plan->validity != '31' && $plan->validity != '366' &&
                            $plan->validity != '9999')
                            {{ 'per '.$plan->validity.' '.__('days') }}</span>
                            @endif</span>
                        </div>
                        <p class="mb-6 text-gray-400 font-medium">{{ __($plan->plan_description) }}</p>

                        @if(Route::has('register'))
                        <a class="inline-block mb-3 lg:mb-0 lg:mr-3 w-full lg:full py-2 px-6 leading-loose bg-{{ $config[11]->config_value }}-600 hover:bg-{{ $config[11]->config_value }}-700 text-white font-semibold rounded-l-xl rounded-t-xl transition duration-200 text-center"
                            href="{{ route('register') }}">{{ __('Get Started') }}</a>
                        @endif
                    </div>
                    <div class="border-b border-gray-100"></div>
                    <ul class="self-start px-8 pt-8">
                        {{-- QRCode Types --}}
                        <li class="flex items-center mb-3 text-gray-500 font-medium">
                            <img class="mr-3" src="{{ asset('images/web/elements/checkbox-green.svg') }}">
                            <span>{{ $plan->no_access_qr == '999' ? __('Unlimited') : $plan->no_access_qr }} {{ __('QRCode Types') }}</span>
                        </li>
                        {{-- No. Of QRCodes --}}
                        <li class="flex items-center mb-3 text-gray-500 font-medium">
                            <img class="mr-3" src="{{ asset('images/web/elements/checkbox-green.svg') }}">
                            <span>{{ $plan->no_qrcodes == '999' ? __('Unlimited') : $plan->no_qrcodes }} {{ __('QRCodes')
                                }}</span>
                        </li>
                        {{-- No Bar Code --}}
                        <li class="flex items-center mb-3 text-gray-500 font-medium">
                            <img class="mr-3" src="{{ asset('images/web/elements/checkbox-green.svg') }}">
                            <span>{{ $plan->no_barcodes == '999' ? __('Unlimited') : $plan->no_barcodes }} {{ __('Barcodes')
                                }}</span>
                        </li>
                        {{-- Additional Tools --}}
                        <li class="flex items-center mb-3 text-gray-500 font-medium">
                            @if ($plan->additional_tools == 1)
                            <img class="mr-3" src="{{ asset('images/web/elements/checkbox-green.svg') }}">
                            @else
                            <img class="mr-3" src="{{ asset('images/web/elements/icons8-cancel-1.svg') }}">
                            @endif
                            <span>{{ __('Additional Tools') }}</span>
                        </li>
                        {{-- Enable Analytics --}}
                        <li class="flex items-center mb-3 text-gray-500 font-medium">
                            @if ($plan->enable_analaytics == 1)
                            <img class="mr-3" src="{{ asset('images/web/elements/checkbox-green.svg') }}">
                            @else
                            <img class="mr-3" src="{{ asset('images/web/elements/icons8-cancel-1.svg') }}">
                            @endif
                            <span>{{ __('Include Analytics') }}</span>
                        </li>
                        {{-- Hide Branding --}}
                        <li class="flex items-center mb-3 text-gray-500 font-medium">
                            @if ($plan->hide_branding == 1)
                            <img class="mr-3" src="{{ asset('images/web/elements/checkbox-green.svg') }}">
                            @else
                            <img class="mr-3" src="{{ asset('images/web/elements/icons8-cancel-1.svg') }}">
                            @endif
                            <span>{{ __('Hide Branding') }}</span>
                        </li>
                        {{-- Support --}}
                        <li class="flex items-center mb-3 text-gray-500 font-medium">
                            @if ($plan->support == 1)
                            <img class="mr-3" src="{{ asset('images/web/elements/checkbox-green.svg') }}">
                            @else
                            <img class="mr-3" src="{{ asset('images/web/elements/icons8-cancel-1.svg') }}">
                            @endif
                            <span>{{ __('Support') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>

{{-- Footer --}}
@include('website.includes.footer')
@endsection