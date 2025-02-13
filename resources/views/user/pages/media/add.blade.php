@extends('user.layouts.app')

{{-- Custom CSS & JS --}}
@section('custom-css')
<link href="{{ asset('css/dropzone.min.css')}}" rel="stylesheet">
<script src="{{ asset('js/dropzone.min.js')}}"></script>
@endsection

@section('content')
<div class="page-wrapper">
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        {{ __('Overview') }}
                    </div>
                    <h2 class="page-title">
                        {{ __('Add Media') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-sm-12 col-lg-12">
                    <div id="dropzone">
                        <form action="{{ route('user.upload.media') }}" class="dropzone" id="dropzone"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="dz-message">
                                {{ __('Drag and Drop Single/Multiple Files Here') }} <br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Footer --}}
    @include('user.includes.footer')
</div>

{{-- Custom JS --}}
@section('custom-js')
<script type="text/javascript">
    "use strict";
        Dropzone.options.dropzone = {
        maxFilesize  : {{ env('SIZE_LIMIT')/1024 }},
        acceptedFiles: ".jpeg,.jpg,.png,.gif"
    };
</script>
@endsection
@endsection