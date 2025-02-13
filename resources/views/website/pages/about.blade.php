@extends('layouts.guest')

@section('content')
{{-- Topbar --}}
@include('website.includes.topbar')

@php
use App\Models\Page;
$page = Page::where('slug', 'about')->where('status', 1)->get();
@endphp

{{-- About us --}}
<section class="py-20 xl:pt-24 xl:pb-28 bg-white"
    style="background-image: url('{{ asset('images/web/elements/pattern-white.svg') }}'); background-position: center;">
    <div class="container px-4 mx-auto">
        <div class="flex flex-wrap -mx-4">
            <div class="w-full lg:w-1/2 px-4 mb-5 lg:mb-0">
                <span
                    class="inline-block py-px px-2 mb-4 text-xs leading-5 text-{{ $config[11]->config_value }}-500 bg-{{ $config[11]->config_value }}-100 font-medium uppercase rounded-9xl">{{ __($page[0]->body)}}</span>
                <h3 class="mb-5 text-3xl md:text-4xl text-gray-900 font-bold tracking-tighter">{{ __($page[1]->body) }}</h3>
                <p class="mb-6 text-lg md:text-xl leading-8 text-gray-500 font-semibold">{{ __($page[2]->body) }}</p>
                <p class="mb-5 text-lg font-medium leading-7 text-gray-500">{{ __($page[3]->body) }}</p>
                <p class="mb-5 text-lg font-medium leading-7 text-gray-500">{{ __($page[4]->body) }}</p>
                <p class="text-lg font-medium leading-7 text-gray-500">{{ __($page[5]->body) }}</p>
            </div>
            <div class="w-full lg:w-1/2 px-4">
                <p class="mb-5 text-lg font-medium leading-7 text-gray-500">
                    <span>{{ __($page[6]->body) }}</span>
                </p>
                <ol class="mb-5 list-decimal list-inside text-lg font-medium leading-7 text-gray-500">
                    <li>
                        <span class="text-lg font-medium leading-8 text-gray-500">{{ __($page[7]->body) }}</span>
                    </li>
                    <li>
                        <span class="text-lg font-medium leading-8 text-gray-500">{{ __($page[8]->body) }}</span>
                    </li>
                    <li>
                        <span class="text-lg font-medium leading-8 text-gray-500">{{ __($page[9]->body) }}</span>
                    </li>
                </ol>

                <p class="text-lg font-medium leading-7 text-gray-500">{{ __($page[10]->body) }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Footer --}}
@include('website.includes.footer')
@endsection