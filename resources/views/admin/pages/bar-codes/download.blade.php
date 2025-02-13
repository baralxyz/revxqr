@extends('admin.layouts.app')

{{-- Custom CSS & JS --}}
@section('custom-css')
<script src="{{ asset('js/clipboard.min.js') }}"></script>
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
                        {{ __('Download Barcode') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">

            {{-- Failed --}}
            @if(Session::has("failed"))
            <div class="alert alert-important alert-danger alert-dismissible mb-2 d-print-none" role="alert">
                <div class="d-flex">
                    <div>
                        {{ __(Session::get('failed')) }}
                    </div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            @endif

            {{-- Success --}}
            @if(Session::has("success"))
            <div class="alert alert-important alert-success alert-dismissible mb-2 d-print-none" role="alert">
                <div class="d-flex">
                    <div>
                        {{ __(Session::get('success')) }}
                    </div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            @endif

            {{-- Check barcode status --}}
            @if ($barcode_details->status == 1)
            <div class="row row-deck row-cards">
                {{-- Download bar code --}}
                <div class="col-xl-12">
                    <div class="card">
                        <div class="visible-print text-center m-4 printable-area">
                            <div class="flapImage code-style" id="download">
                                {{-- Show Bar code --}}
                                <img src="data:image/svg+xml;base64,{{ base64_encode($barcode_details->bar_code) }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="visible-print text-center m-4 d-print-none">
                            <div class="col-auto ms-auto d-print-none">

                                {{-- Download Formats --}}
                                <div class="row g-2 align-items-center mb-3 mt-3">
                                    <div class="col-12 col-xl-2 mb-3 font-weight-semibold h5">{{ __('Download Formats') }}</div>

                                    {{-- Print --}}
                                    <div class="col-6 col-sm-4 col-md-2 col-xl mb-3">
                                        <a href="#" onclick="doPrint();" class="btn btn-indigo w-100">
                                            {{ __('PRINT') }}
                                        </a>
                                    </div>
                                    
                                    {{-- .PNG --}}
                                    <div class="col-6 col-sm-4 col-md-2 col-xl mb-3">
                                        <a href="#" onclick="downloadBarCode('png')" class="btn btn-pink w-100">
                                            {{ __('.PNG') }}
                                        </a>
                                    </div>

                                    {{-- .JPG --}}
                                    <div class="col-6 col-sm-4 col-md-2 col-xl mb-3">
                                        <a href="#" onclick="downloadBarCode('jpg')" class="btn btn-secondary w-100">
                                            {{ __('.JPG') }}
                                        </a>
                                    </div>

                                    {{-- .SVG --}}
                                    <div class="col-6 col-sm-4 col-md-2 col-xl mb-3">
                                        <a href="#" onclick="downloadBarCode('svg')" class="btn btn-success w-100">
                                            {{ __('.SVG') }}
                                        </a>
                                    </div>

                                    {{-- .WebP --}}
                                    <div class="col-6 col-sm-4 col-md-2 col-xl mb-3">
                                        <a href="#" onclick="downloadBarCode('webp')" class="btn btn-warning w-100">
                                            {{ __('.WebP') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            {{-- If QR Code is empty --}}
            <div class="page-body">
                <div class="container-xl d-flex flex-column justify-content-center">
                    <div class="empty">
                        <div class="empty-img"><img src="{{ asset('images/undraw_printing_invoices_5r4r.svg') }}"
                                height="128" alt="">
                        </div>
                        <p class="empty-title">{{ __('No download found') }}</p>
                        <p class="empty-subtitle text-muted">
                            {{ __('Your barcode is disabled. Once, enable the barcode and try again.') }}
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Footer --}}
    @include('admin.includes.footer')
</div>

{{-- Custom JS --}}
@section('custom-js')
<script>
    // Default Download Image
$("#download_barcode").attr("href", $("#download").children().attr("src"));

// Download Barcode
function downloadBarCode(type) {
    "use strict";
    // Download variables
    var barcodeSvgSrc = $("#download").children().attr("src");
    var barcodeName = "{{ $barcode_details->name == null ? 'Barcode' : $barcode_details->name }}";
    var barcode_type = "{{ json_decode($barcode_details->settings)->barcode_type }}";
    var barcode_width = {{ json_decode($barcode_details->settings)->width }} * 200

    // Check type is "2D"
    if(barcode_type == "DNS2D"){
      barcode_width = {{ json_decode($barcode_details->settings)->width }};
    }

    var barcode_height = {{ json_decode($barcode_details->settings)->height }};

    // Call function
    svgToBarcodeDownload(barcodeSvgSrc, type, barcodeName, barcode_width, barcode_height);
}
</script>
@endsection
@endsection