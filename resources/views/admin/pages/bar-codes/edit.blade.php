@extends('admin.layouts.app')

{{-- Custom CSS --}}
@section('custom-css')
    <style>
        #nameError.visible {
            display: block;
        }

        input.invalid {
            border-color: red;
        }

        #loader {
            display: flex;
            text-align: center;
            justify-content: center;
        }
    </style>
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
                            {{ __('Edit Barcode') }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">

                {{-- Failed --}}
                @if (Session::has('failed'))
                    <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                        <div class="d-flex">
                            <div>
                                {{ Session::get('failed') }}
                            </div>
                        </div>
                        <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif

                {{-- Success --}}
                @if (Session::has('success'))
                    <div class="alert alert-important alert-success alert-dismissible" role="alert">
                        <div class="d-flex">
                            <div>
                                {{ Session::get('success') }}
                            </div>
                        </div>
                        <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif

                <div class="row row-deck row-cards">
                    {{-- Save Bar Code --}}
                    <div class="col-sm-12 col-lg-12">
                        <form action="{{ route('admin.update.barcode') }}" method="post" class="card"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    {{-- Generate Form --}}
                                    <div class="col-xl-6">
                                        <div class="row">

                                            <input type="hidden" class="form-control" name="barcode_id" id="barcode_id"
                                                value="{{ $barcode_details->barcode_id }}">

                                            {{-- Groups --}}
                                            <div class="col-md-6 col-xl-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">{{ __('Group') }}</label>
                                                    <select type="text" name="group" class="form-select"
                                                        id="select-groups" value="" required>
                                                        <option value="" selected disabled>{{ __('Choose group') }}
                                                        </option>
                                                        <option value="" {{ $barcode_details->group_id == null ? 'selected' : '' }}>{{ __('General') }}</option>
                                                        {{-- Groups --}}
                                                        @foreach ($groups as $group)
                                                            <option value="{{ $group->group_id }}" {{ $barcode_details->group_id == $group->group_id ? 'selected' : '' }}>
                                                                {{ __($group->group_name) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Barcode Name --}}
                                            <div class="col-md-6 col-xl-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">{{ __('Barcode Name') }}</label>
                                                    <input type="text" class="form-control" name="name" id="name"
                                                        value="{{ $barcode_details->name }}" minlength="3" maxlength="30"
                                                        required>
                                                </div>
                                            </div>

                                            {{-- Barcode Type --}}
                                            <div class="col-md-6 col-xl-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">{{ __('Barcode Type') }}</label>
                                                    <select class="form-select" name="barcode_type" id="barcode_type"
                                                        onchange="getFormat(this.value)" required>
                                                        <option value="DNS1D"
                                                            {{ json_decode($barcode_details->settings)->barcode_type == 'DNS1D' ? 'selected' : '' }}>
                                                            {{ __('1D') }}</option>
                                                        <option value="DNS2D"
                                                            {{ json_decode($barcode_details->settings)->barcode_type == 'DNS2D' ? 'selected' : '' }}>
                                                            {{ __('2D') }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Barcode Format --}}
                                            <div class="col-md-6 col-xl-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">{{ __('Barcode Format') }}</label>
                                                    <select class="form-select" name="barcode_format" id="barcode_format"
                                                        onchange="getFormatValue(this), regenerateBarCode()" required>
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Value --}}
                                            <div class="col-md-12 col-xl-12">
                                                <div class="mb-3">
                                                    <label class="form-label required">{{ __('Value') }}</label>
                                                    <input type="text" class="form-control" name="content"
                                                        id="content"
                                                        value="{{ json_decode($barcode_details->settings)->content }}"
                                                        minlength="1" onchange="regenerateBarCode()" required>
                                                </div>
                                            </div>

                                            {{-- Width --}}
                                            <div class="col-md-6 col-xl-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">{{ __('Width') }}</label>
                                                    <input type="number" class="form-control" name="width"
                                                        id="width"
                                                        value="{{ json_decode($barcode_details->settings)->width }}"
                                                        onchange="regenerateBarCode()" required>
                                                </div>
                                            </div>

                                            {{-- Height --}}
                                            <div class="col-md-6 col-xl-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">{{ __('Height') }}</label>
                                                    <input type="number" class="form-control" name="height"
                                                        id="height"
                                                        value="{{ json_decode($barcode_details->settings)->height }}"
                                                        onchange="regenerateBarCode()" required>
                                                </div>
                                            </div>

                                            {{-- Color --}}
                                            <div class="col-md-12 col-xl-12">
                                                <div class="mb-3">
                                                    <label class="form-label required">{{ __('Color') }}</label>
                                                    <input type="color" class="form-control" name="color"
                                                        id="color"
                                                        value="{{ json_decode($barcode_details->settings)->color }}"
                                                        onchange="regenerateBarCode()" required>
                                                </div>
                                            </div>

                                            {{-- Show text --}}
                                            <div class="col-md-12 col-xl-12">
                                                <div class="mb-3">
                                                    <label class="form-check required">
                                                        <input class="form-check-input" type="checkbox" name="showtext"
                                                            id="showtext" onchange="regenerateBarCode()"
                                                            {{ json_decode($barcode_details->settings)->showtext != null ? 'checked' : '' }}>
                                                        <span class="form-check-label">{{ __('Show text') }}</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="text-left">
                                                <span
                                                    class="text-muted mt-1">{{ __('Note: Double-check your QR Code once before using it.') }}</span>
                                                <div class="mb-3 text-end">
                                                    <button type="submit" class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-edit" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path
                                                                d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3">
                                                            </path>
                                                            <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3">
                                                            </path>
                                                            <line x1="16" y1="5" x2="19"
                                                                y2="8"></line>
                                                        </svg>
                                                        {{ __('Update') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Show Generated Bar Code --}}
                                    <div class="col-xl-6">
                                        {{-- Regenerate Bar Code --}}
                                        <div id="regenerate_barcode" class="visible-print text-center code-style">
                                            <img
                                                src="data:image/svg+xml;base64,{{ base64_encode($barcode_details->bar_code) }}">
                                        </div>

                                        {{-- Loader --}}
                                        <div id="loader">
                                            <img
                                                src="data:image/gif;base64,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">
                                        </div>
                                        <br>

                                        {{-- Download Formats --}}
                                        <div class="row g-2 align-items-center mb-n3">
                                            <div class="col-12 col-xl-2 mb-3 font-weight-semibold h5">
                                                {{ __('Download Formats') }}</div>

                                            <div class="col-6 col-sm-4 col-md-2 col-xl mb-3">
                                                <a href="#" onclick="downloadBarCode('png')"
                                                    class="btn btn-pink w-100">
                                                    {{ __('.PNG') }}
                                                </a>
                                            </div>

                                            <div class="col-6 col-sm-4 col-md-2 col-xl mb-3">
                                                <a href="#" onclick="downloadBarCode('jpg')"
                                                    class="btn btn-secondary w-100">
                                                    {{ __('.JPG') }}
                                                </a>
                                            </div>

                                            <div class="col-6 col-sm-4 col-md-2 col-xl mb-3">
                                                <a href="#" onclick="downloadBarCode('svg')"
                                                    class="btn btn-success w-100">
                                                    {{ __('.SVG') }}
                                                </a>
                                            </div>

                                            <div class="col-6 col-sm-4 col-md-2 col-xl mb-3">
                                                <a href="#" onclick="downloadBarCode('webp')"
                                                    class="btn btn-warning w-100">
                                                    {{ __('.WebP') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        @include('admin.includes.footer')
    </div>

    {{-- Custom JS --}}
@section('custom-js')
    <script>
        // Check barcode format
        getFormat(`{{ json_decode($barcode_details->settings)->barcode_type }}`);

        // Hide loader
        $("#loader").hide();
        $("#regenerate_barcode").show();

        // Default Download Image
        $("#download_barcode").attr("href", "data:image/svg+xml;base64,{{ base64_encode($barcode_details->bar_code) }}");

        // Regenerate Barcode
        function regenerateBarCode() {
            "use strict";
            var barcode_type = $("#barcode_type").val();
            var barcode_format = $("#barcode_format").val();
            var content = $("#content").val();
            var width = $("#width").val();
            var height = $("#height").val();
            var color = $("#color").val();
            var showtext = $("#showtext").prop('checked');

            // Check content field value
            if (content != '') {
                // Remove content field class
                $("#content").removeClass("invalid");

                // Pass values
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var formData = {
                    _token: CSRF_TOKEN,
                    barcode_type: barcode_type,
                    barcode_format: barcode_format,
                    content: content,
                    width: width,
                    height: height,
                    color: color,
                    showtext: showtext
                };

                // Show loader
                $("#regenerate_barcode").hide();
                $("#loader").show();

                $.ajax({
                    /* the route pointing to the post function */
                    url: `{{ route('admin.regenerate.barcode') }}`,
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: formData,
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function(data) {
                        // Show qr code
                        $("#regenerate_barcode").html("<img src='" + data.source + "'>");
                        $("#download_barcode").attr("href", data.source);
                        $("#regenerate_barcode").show();
                        $("#loader").hide();

                    }
                });
            } else {
                // Add content field class
                $("#content").addClass("invalid");
                $("#content").attr("aria-hidden", false);
                $("#content").attr("aria-invalid", true);
            }
        }

        // Get Barcode Format
        function getFormat(format) {
            "use strict";
            // Value
            var getFormat = format;

            // Check value is DNS1D
            if (getFormat == "DNS1D") {
                $("#barcode_format").html(
                    `<option value='C39' {{ json_decode($barcode_details->settings)->barcode_format == 'C39' ? 'selected' : '' }}>{{ __('C39') }}</option><option value='C39+' {{ json_decode($barcode_details->settings)->barcode_format == 'C39+' ? 'selected' : '' }}>{{ __('C39+') }}</option><option value='C39E' {{ json_decode($barcode_details->settings)->barcode_format == 'C39E' ? 'selected' : '' }}>{{ __('C39E') }}</option><option value='C39E+' {{ json_decode($barcode_details->settings)->barcode_format == 'C39E+' ? 'selected' : '' }}>{{ __('C39E+') }}</option><option value='C93' {{ json_decode($barcode_details->settings)->barcode_format == 'C93' ? 'selected' : '' }}>{{ __('C93') }}</option><option value='S25' {{ json_decode($barcode_details->settings)->barcode_format == 'S25' ? 'selected' : '' }}>{{ __('S25') }}</option><option value='S25+' {{ json_decode($barcode_details->settings)->barcode_format == 'S25+' ? 'selected' : '' }}>{{ __('S25+') }}</option><option value='I25' {{ json_decode($barcode_details->settings)->barcode_format == 'I25' ? 'selected' : '' }}>{{ __('I25') }}</option><option value='I25+' {{ json_decode($barcode_details->settings)->barcode_format == 'I25+' ? 'selected' : '' }}>{{ __('I25+') }}</option><option value='C128' {{ json_decode($barcode_details->settings)->barcode_format == 'C128' ? 'selected' : '' }}>{{ __('C128') }}</option><option value='C128A' {{ json_decode($barcode_details->settings)->barcode_format == 'C128A' ? 'selected' : '' }}>{{ __('C128A') }}</option><option value='C128B' {{ json_decode($barcode_details->settings)->barcode_format == 'C128B' ? 'selected' : '' }}>{{ __('C128B') }}</option><option value='EAN2' {{ json_decode($barcode_details->settings)->barcode_format == 'EAN2' ? 'selected' : '' }}>{{ __('EAN2') }}</option><option value='EAN5' {{ json_decode($barcode_details->settings)->barcode_format == 'EAN5' ? 'selected' : '' }}>{{ __('EAN5') }}</option><option value='EAN8' {{ json_decode($barcode_details->settings)->barcode_format == 'EAN8' ? 'selected' : '' }}>{{ __('EAN8') }}</option><option value='EAN13' {{ json_decode($barcode_details->settings)->barcode_format == 'EAN13' ? 'selected' : '' }}>{{ __('EAN13') }}</option><option value='UPCA' {{ json_decode($barcode_details->settings)->barcode_format == 'UPCA' ? 'selected' : '' }}>{{ __('UPCA') }}</option><option value='UPCE' {{ json_decode($barcode_details->settings)->barcode_format == 'UPCE' ? 'selected' : '' }}>{{ __('UPCE') }}</option><option value='MSI' {{ json_decode($barcode_details->settings)->barcode_format == 'MSI' ? 'selected' : '' }}>{{ __('MSI') }}</option><option value='MSI+' {{ json_decode($barcode_details->settings)->barcode_format == 'MSI+' ? 'selected' : '' }}>{{ __('MSI+') }}</option><option value='POSTNET' {{ json_decode($barcode_details->settings)->barcode_format == 'POSTNET' ? 'selected' : '' }}>{{ __('POSTNET') }}</option><option value='PLANET' {{ json_decode($barcode_details->settings)->barcode_format == 'PLANET' ? 'selected' : '' }}>{{ __('PLANET') }}</option><option value='RMS4CC' {{ json_decode($barcode_details->settings)->barcode_format == 'RMS4CC' ? 'selected' : '' }}>{{ __('RMS4CC') }}</option><option value='KIX' {{ json_decode($barcode_details->settings)->barcode_format == 'KIX' ? 'selected' : '' }}>{{ __('KIX') }}</option><option value='IMB' {{ json_decode($barcode_details->settings)->barcode_format == 'IMB' ? 'selected' : '' }}>{{ __('IMB') }}</option><option value='CODABAR' {{ json_decode($barcode_details->settings)->barcode_format == 'CODABAR' ? 'selected' : '' }}>{{ __('CODABAR') }}</option><option value='CODE11' {{ json_decode($barcode_details->settings)->barcode_format == 'CODE11' ? 'selected' : '' }}>{{ __('CODE11') }}</option><option value='PHARMA' {{ json_decode($barcode_details->settings)->barcode_format == 'PHARMA' ? 'selected' : '' }}>{{ __('PHARMA') }}</option><option value='PHARMA2T' {{ json_decode($barcode_details->settings)->barcode_format == 'PHARMA2T' ? 'selected' : '' }}>{{ __('PHARMA2T') }}</option>`
                    );
                $("#width").val('3');
                $("#height").val('83');
            }

            // Check value is DNS1D
            if (getFormat == "DNS2D") {
                $("#barcode_format").html(
                    `<option value='QRCODE' {{ json_decode($barcode_details->settings)->barcode_format == 'QRCODE' ? 'selected' : '' }}>{{ __('QRCODE') }}</option><option value='PDF417' {{ json_decode($barcode_details->settings)->barcode_format == 'PDF417' ? 'selected' : '' }}>{{ __('PDF417') }}</option><option value='DATAMATRIX' {{ json_decode($barcode_details->settings)->barcode_format == 'DATAMATRIX' ? 'selected' : '' }}>{{ __('DATAMATRIX') }}</option>`
                    );
                $("#width").val('500');
                $("#height").val('500');
            }

            regenerateBarCode();
        }

        // Get Barcode Format
        function getFormatValue(format) {
            "use strict";
            // Value
            var getFormatValue = format.value;

            // Check value is DNS1D
            if (getFormatValue == "C39" || getFormatValue == "C39+" || getFormatValue == "C39E" || getFormatValue ==
                "C39E+" || getFormatValue == "C93" || getFormatValue == "C128" || getFormatValue == "C128B" ||
                getFormatValue == "RMS4CC" || getFormatValue == "KIX" || getFormatValue == "PHARMA" || getFormatValue ==
                "PHARMA2T") {
                $('#content').attr('type', 'text');
                $("#content").val('');
            } else {
                $('#content').attr('type', 'number');
                $("#content").val('');
            }
        }

        // Download Barcode
        function downloadBarCode(type) {
            "use strict";
            // Download variables
            var barcodeSvgSrc = $("#regenerate_barcode").children().attr("src");
            var barcodeName = $("#name").val() == "" ? 'Barcode' : $("#name").val();
            var barcode_type = $("#barcode_type").val();
            var barcode_width = $("#width").val() * 200;

            // Check type is "2D"
            if (barcode_type == "DNS2D") {
                barcode_width = $("#width").val();
            }

            var barcode_height = $("#height").val();

            // Call function
            svgToBarcodeDownload(barcodeSvgSrc, type, barcodeName, barcode_width, barcode_height);
        }
    </script>
@endsection
@endsection
