@extends('layouts.guest')

@section('content')
{{-- Topbar --}}
@include('website.includes.topbar')

@php
use App\Models\Page;
$page = Page::where('slug', 'faq')->where('status', 1)->get();
@endphp

{{-- FAQs --}}
<section class="pt-24 bg-white"
    style="background-image: url('{{ asset('images/web/elements/pattern-white.svg') }}'); background-position: center;">
    <div class="container px-4 mx-auto">
        <div class="max-w-4xl mb-16">
            <span
                class="inline-block py-px px-2 mb-4 text-xs leading-5 text-{{ $config[11]->config_value }}-500 bg-{{ $config[11]->config_value }}-100 font-medium rounded-full shadow-sm">{{ __($page[0]->body) }}</span>
            <h2 class="mb-4 text-4xl md:text-5xl leading-tight text-gray-900 font-bold tracking-tighter">{{
                __($page[1]->body) }}</h2>
            <p class="text-lg md:text-xl text-gray-500 font-medium">{{ __($page[2]->body) }}</p>
        </div>
        <div class="flex flex-wrap pb-16 -mx-4">
            <div class="w-full md:w-1/2 xl:w-1/3 px-4 mb-8">
                <div class="md:max-w-xs">
                    <div class="inline-flex mb-6 items-center justify-center w-12 h-12 rounded-full bg-{{ $config[11]->config_value }}-500">
                        <img src="{{ asset('images/web/elements/shield-icon.svg') }}" alt="">
                    </div>
                    <h3 class="mb-6 text-xl font-bold text-gray-900">{{ __($page[3]->body) }}
                    </h3>
                    <p class="font-medium text-gray-500">{{ __($page[4]->body) }}</p>
                </div>
            </div>
            <div class="w-full md:w-1/2 xl:w-1/3 px-4 mb-8">
                <div class="md:max-w-xs">
                    <div class="inline-flex mb-6 items-center justify-center w-12 h-12 rounded-full bg-{{ $config[11]->config_value }}-500">
                        <img src="{{ asset('images/web/elements/shield-icon.svg') }}" alt="">
                    </div>
                    <h3 class="mb-6 text-xl font-bold text-gray-900">{{ __($page[5]->body) }}
                    </h3>
                    <p class="font-medium text-gray-500">{{ __($page[6]->body) }}</p>
                </div>
            </div>
            <div class="w-full md:w-1/2 xl:w-1/3 px-4 mb-8">
                <div class="md:max-w-xs">
                    <div class="inline-flex mb-6 items-center justify-center w-12 h-12 rounded-full bg-{{ $config[11]->config_value }}-500">
                        <img src="{{ asset('images/web/elements/shield-icon.svg') }}" alt="">
                    </div>
                    <h3 class="mb-6 text-xl font-bold text-gray-900">{{ __($page[7]->body) }}</h3>
                    <p class="font-medium text-gray-500">{{ __($page[8]->body) }}</p>
                </div>
            </div>
            <div class="w-full md:w-1/2 xl:w-1/3 px-4 mb-8 xl:mb-0">
                <div class="md:max-w-xs">
                    <div class="inline-flex mb-6 items-center justify-center w-12 h-12 rounded-full bg-{{ $config[11]->config_value }}-500">
                        <img src="{{ asset('images/web/elements/shield-icon.svg') }}" alt="">
                    </div>
                    <h3 class="mb-6 text-xl font-bold text-gray-900">{{ __($page[9]->body) }}
                    </h3>
                    <p class="font-medium text-gray-500">{{ __($page[10]->body) }}</p>
                </div>
            </div>
            <div class="w-full md:w-1/2 xl:w-1/3 px-4 mb-8 md:mb-0">
                <div class="md:max-w-xs">
                    <div class="inline-flex mb-6 items-center justify-center w-12 h-12 rounded-full bg-{{ $config[11]->config_value }}-500">
                        <img src="{{ asset('images/web/elements/shield-icon.svg') }}" alt="">
                    </div>
                    <h3 class="mb-6 text-xl font-bold text-gray-900">{{ __($page[11]->body) }}
                    </h3>
                    <p class="font-medium text-gray-500">{{ __($page[12]->body) }}</p>
                </div>
            </div>
            <div class="w-full md:w-1/2 xl:w-1/3 px-4">
                <div class="md:max-w-xs">
                    <div class="inline-flex mb-6 items-center justify-center w-12 h-12 rounded-full bg-{{ $config[11]->config_value }}-500">
                        <img src="{{ asset('images/web/elements/shield-icon.svg') }}" alt="">
                    </div>
                    <h3 class="mb-6 text-xl font-bold text-gray-900">{{ __($page[13]->body) }}</h3>
                    <p class="font-medium text-gray-500">{{ __($page[14]->body) }}</p>
                </div>
            </div>
        </div>
        <div class="relative -mb-40 py-16 px-4 md:px-8 lg:px-16 bg-gray-900 rounded-xl overflow-hidden"
            style="background-image: url('{{ asset('images/web/elements/pattern-dark.svg') }}'); background-position: center;">
            <div class="relative max-w-max mx-auto text-center">
                <h3 class="mb-2 text-2xl md:text-5xl leading-tight font-bold text-white tracking-tighter">{{ __($page[15]->body) }}</h3>
                <p class="mb-6 text-base md:text-xl text-gray-400">{{ __($page[16]->body) }}</p>
                <a class="inline-block mb-3 lg:mb-0 lg:mr-3 w-1/3 lg:full py-2 px-6 leading-loose bg-{{ $config[11]->config_value }}-600 hover:bg-{{ $config[11]->config_value }}-700 text-white font-semibold rounded-l-xl rounded-t-xl transition duration-200 text-center"
                    href="{{ url($page[18]->body) }}">{{ __($page[17]->body) }}</a>
            </div>
        </div>
    </div>
    <div class="h-64 bg-gray-50"></div>
</section>

{{-- Footer --}}
@include('website.includes.footer')
@endsection