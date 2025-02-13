@extends('layouts.guest')

@section('content')
{{-- Topbar --}}
@include('website.includes.topbar')

{{-- About us --}}
<section class="pt-24 bg-white" style="background-image: url({{ asset('images/web/elements/pattern-white.svg') }}); background-position: center;">
    <div class="container px-4 mx-auto">
        {{-- Page content --}}
        @if (!empty($page->body))
        {!! __($page->body) !!}
        @endif
    </div>
</section>

{{-- Footer --}}
@include('website.includes.footer')
@endsection