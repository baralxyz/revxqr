@extends('admin.layouts.app')

{{-- Custom CSS & JS --}}
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/lightgallery.min.css') }}" />
    <script src="{{ asset('js/lightgallery.min.js') }}"></script>
    <script src="{{ asset('js/clipboard.min.js') }}"></script>
    <style>
        .lg-outer {
            background: #e9e9e9;
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
                            {{ __('View Group') }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">

                {{-- Failed --}}
                @if (Session::has('failed'))
                    <div class="alert alert-important alert-danger alert-dismissible mb-2" role="alert">
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
                    <div class="alert alert-important alert-success alert-dismissible mb-2" role="alert">
                        <div class="d-flex">
                            <div>
                                {{ Session::get('success') }}
                            </div>
                        </div>
                        <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif

                <div class="row row-cards" id="captions">
                    {{-- Group barcodes --}}
                    @if (!empty($groupBarcodes) && $groupBarcodes->count())
                        @foreach ($groupBarcodes as $groupBarcode)
                            <div class="col-sm-6 col-lg-3">
                                <div class="card card-sm">
                                    <div class="d-block">
                                        <div class="item card-img-top img-responsive img-responsive-16by9"
                                            data-src="data:image/svg+xml;base64,{{ base64_encode($groupBarcode->bar_code) }}"
                                            data-sub-html="<h4>{{ __('Name') }} : {{ $groupBarcode->name }}</h4>"
                                            style="background-image: url(data:image/svg+xml;base64,{{ base64_encode($groupBarcode->bar_code) }})">
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="font-weight-bold mb-2">
                                                    <strong>{{ strlen($groupBarcode->name) > 20 ? substr($groupBarcode->name, 0, 20) . '...' : $groupBarcode->name }}</strong>
                                                </div>
                                                <div class="small"><small>
                                                        {{ __('Upload on:') }} <br>
                                                        {{ $groupBarcode->created_at->format('d-m-Y h:i A') }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="ms-auto d-flex cursor-pointer">
                                                {{-- Download --}}
                                                <a href="{{ route('admin.download.barcode', $groupBarcode->barcode_id) }}"
                                                    class="btn btn-icon mx-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-download" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                        <path d="M7 11l5 5l5 -5" />
                                                        <path d="M12 4l0 12" />
                                                    </svg>
                                                </a>
                                                {{-- Edit --}}
                                                <a href="{{ route('admin.edit.barcode', $groupBarcode->barcode_id) }}"
                                                    class="btn btn-icon mx-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-edit" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                        <path
                                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                        <path d="M16 5l3 3" />
                                                    </svg>
                                                </a>
                                                {{-- Delete --}}
                                                <a onclick="deleteBarcode('{{ $groupBarcode->barcode_id }}')"
                                                    title="{{ __('Delete') }}" class="btn btn-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-trash" width="44"
                                                        height="44" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="#ff4433" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <line x1="4" y1="7" x2="20" y2="7" />
                                                        <line x1="10" y1="11" x2="10" y2="17" />
                                                        <line x1="14" y1="11" x2="14" y2="17" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                </a>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty">
                            <div class="empty-img"><img src="{{ asset('images/undraw_printing_invoices_5r4r.svg') }}"
                                    height="128" alt="">
                            </div>
                            <p class="empty-title">{{ __('No group barcodes found') }}</p>
                        </div>
                    @endif

                    <div class="d-flex">
                        <ul class="pagination ms-auto">
                            {{ $groupBarcodes->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    @include('admin.includes.footer')
    </div>

    {{-- Delete modal --}}
    <div class="modal modal-blur fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">{{ __('Are you sure?') }}</div>
                    <div>{{ __('If you proceed, you will delete this barcode.') }}</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <a class="btn btn-danger" id="barcode_id">{{ __('Yes, proceed') }}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom JS --}}
@section('custom-js')
    <script>
        "use strict";
        $('#captions').lightGallery({
            thumbnail: true,
            download: true,
            selector: '.item'
        });

        // Delete barcode
        function deleteBarcode(mid) {
            swal({
                    title: "{{ __('Are you sure?') }}",
                    text: "{{ __('Do you want to remove this barcode?') }}",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = "../../delete-barcode?id=" + mid;
                    } else {
                        //Nothing...
                    }
                });
        }
    </script>
@endsection
@endsection
