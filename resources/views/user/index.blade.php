@extends('user.layouts.app')

{{-- Custom CSS --}}
@section('custom-css')
    <style>
        .dropdown-menu.show {
            margin: 0 -40px !important;
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
                        <!-- Page pre-title -->
                        <div class="page-pretitle">
                            {{ __('Overview') }}
                        </div>
                        <h2 class="page-title">
                            {{ __('Dashboard') }}
                        </h2>
                    </div>
                    {{-- Create new QR Code --}}
                    <div class="col-auto ms-auto d-print-none">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                {{ __('Create New') }}
                            </button>
                            <div class="dropdown-menu">
                                {{-- Check QR Code --}}
                                @if (env('APP_TYPE') == 'QRCODE')
                                    <a href="{{ route('user.create.qr') }}" class="dropdown-item">
                                        {{ __('QR Code') }}
                                    </a>
                                    <a href="{{ route('user.all.epc.qr') }}" class="dropdown-item">
                                        {{ __('EPC QR Codes') }} 
                                    </a>
                                @endif

                                {{-- Check Barcode --}}
                                @if (env('APP_TYPE') == 'BARCODE')
                                    <a href="{{ route('user.create.barcode') }}" class="dropdown-item">
                                        {{ __('Barcode') }}
                                    </a>
                                @endif

                                {{-- Check Both --}}
                                @if (env('APP_TYPE') == 'BOTH')
                                    <a href="{{ route('user.create.qr') }}" class="dropdown-item">
                                        {{ __('QR Code') }}
                                    </a>
                                    <a href="{{ route('user.all.epc.qr') }}" class="dropdown-item">
                                        {{ __('EPC QR Codes') }} 
                                    </a>
                                    <a href="{{ route('user.create.barcode') }}" class="dropdown-item">
                                        {{ __('Barcode') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">

                {{-- Access deined --}}
                @if (Session::has('access'))
                    <div class="alert alert-important alert-danger alert-dismissible mb-2" role="alert">
                        <div class="d-flex">
                            <div>
                                {{ Session::get('access') }}
                            </div>
                        </div>
                        <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif

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

                <div class="row row-deck row-cards">
                    {{-- Current plan --}}
                    <div class="col-sm-3 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="subheader">{{ __('Current Plan') }}</div>
                                </div>

                                @if ($active_plan->plan_price == 0)
                                    <div class="h1">{{ __($active_plan->plan_name) }}</div>
                                    <p class="fw-bold">{{ __('FREE PLAN') }}</p>
                                @else
                                    <h1 class="text-uppercase"><b>{{ __($active_plan->plan_name) }}</b></h1>
                                @endif
                                <a href="{{ route('user.plans') }}">
                                    {{ __('Show details') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Remaining datas --}}
                    <div class="col-sm-3 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="subheader">{{ __('Remaining Days') }}</div>
                                </div>

                                @if ($active_plan->validity == 9999)
                                    <p class="h1">{{ __('Lifetime') }}</p>
                                @else
                                    <p class="h1">{{ $remaining_days > 0 ? $remaining_days : __('Plan Expired!') }}</p>
                                    <p class="fw-bold">{{ __('Day(s) Left') }}</p>
                                @endif

                                <a href="{{ route('user.plans') }}">
                                    {{ __('Show details') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- QR Codes --}}
                    @if (env('APP_TYPE') == 'QRCODE' || env('APP_TYPE') == 'BOTH')
                        <div class="col-sm-3 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="subheader">{{ __('QR Codes') }}</div>
                                    </div>
                                    <p class="h1">{{ $qr_codes_count }}</p>
                                    <p class="fw-bold">{{ __('CREATED') }}</p>
                                    <a href="{{ route('user.all.qr') }}">
                                        {{ __('Show details') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Barcodes --}}
                    @if (env('APP_TYPE') == 'BARCODE' || env('APP_TYPE') == 'BOTH')
                        <div class="col-sm-3 col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="subheader">{{ __('Barcodes') }}</div>
                                    </div>
                                    <p class="h1">{{ $barcodes_count }}</p>
                                    <p class="fw-bold">{{ __('CREATED') }}</p>
                                    <a href="{{ route('user.all.barcode') }}">
                                        {{ __('Show details') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Check App Type --}}
                    @if (env('APP_TYPE') == 'QRCODE' || env('APP_TYPE') == 'BOTH')
                        {{-- Recent QR Codes --}}
                        <div class="col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('Recent 10 QR Codes') }}</h3>
                                </div>
                                <div class="card-table table-responsive">
                                    <table class="table table-vcenter card-table" id="table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('S.No') }}</th>
                                                <th>{{ __('Created on') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Type') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($qr_codes) && $qr_codes->count())
                                                {{-- QR Codes --}}
                                                @foreach ($qr_codes as $qr_code)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ date('d/m/Y h:i A', strtotime($qr_code->created_at)) }}
                                                        </td>
                                                        <td><a href="{{ route('user.download.qrcode', $qr_code->qr_code_id) }}">{{ $qr_code->name }}</a></td>
                                                        <td><a href="{{ route('user.type.qrcodes', strtolower($qr_code->type)) }}">{{ $qr_code->type }}</a></td>
                                                        @if ($qr_code->status == '1')
                                                            <td><span
                                                                    class="badge bg-success text-white">{{ __('Activated') }}</span>
                                                            </td>
                                                        @else
                                                            <td><span
                                                                    class="badge bg-danger text-white">{{ __('Deactivated') }}</span>
                                                            </td>
                                                        @endif
                                                        <td class="text-start">
                                                            <span class="dropdown">
                                                                <button
                                                                    class="btn small-btn dropdown-toggle align-text-top"
                                                                    data-bs-boundary="viewport" data-bs-toggle="dropdown"
                                                                    aria-expanded="false">{{ __('Actions') }}</button>
                                                                <div class="dropdown-menu dropdown-menu-end"
                                                                    style="">
                                                                    @if ($qr_code->type == 'url')
                                                                        <a class="dropdown-item" href="{{ route('user.qr.statistics', $qr_code->qr_code_id) }}">{{ __('Statistics') }}</a>
                                                                    @endif
                                                                    <a class="dropdown-item" href="{{ route('user.download.qrcode', $qr_code->qr_code_id) }}">{{ __('Download QR') }}</a>
                                                                    @if ($qr_code->type == 'epc')
                                                                    <a class="dropdown-item"
                                                                    href="{{ route('user.edit.epc.qr', $qr_code->qr_code_id) }}">{{ __('Edit') }}</a>
                                                                    @else
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('user.edit.qr', $qr_code->qr_code_id) }}">{{ __('Edit') }}</a>
                                                                    @endif
                                                                    
                                                                    @if ($qr_code->status == 0)
                                                                        <a class="dropdown-item" href="#"
                                                                            onclick="updateQrStatus('{{ $qr_code->qr_code_id }}', 'active'); return false;">{{ __('Activate') }}</a>
                                                                    @else
                                                                        <a class="dropdown-item" href="#"
                                                                            onclick="updateQrStatus('{{ $qr_code->qr_code_id }}', 'deactive'); return false;">{{ __('Deactivate') }}</a>
                                                                    @endif
                                                                    <a class="dropdown-item" href="#"
                                                                        onclick="deleteQr('{{ $qr_code->qr_code_id }}', 'delete'); return false;">{{ __('Delete') }}</a>
                                                                </div>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (env('APP_TYPE') == 'BARCODE' || env('APP_TYPE') == 'BOTH')
                        {{-- Recent Barcodes --}}
                        <div class="col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('Recent 10 Barcodes') }}</h3>
                                </div>
                                <div class="card-table table-responsive">
                                    <table class="table table-vcenter card-table" id="table1">
                                        <thead>
                                            <tr>
                                                <th>{{ __('S.No') }}</th>
                                                <th>{{ __('Created on') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($bar_codes) && $bar_codes->count())
                                                {{-- QR Codes --}}
                                                {{-- Bar Codes --}}
                                                @foreach ($bar_codes as $bar_code)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ date('d/m/Y h:i A', strtotime($bar_code->created_at)) }}
                                                        <td><a href="{{ route('user.download.barcode', $bar_code->barcode_id) }}">{{ $bar_code->name }}</a></td>
                                                        </td>
                                                        @if ($bar_code->status == '1')
                                                            <td><span
                                                                    class="badge bg-success text-white">{{ __('Activated') }}</span>
                                                            </td>
                                                        @else
                                                            <td><span
                                                                    class="badge bg-danger text-white">{{ __('Deactivated') }}</span>
                                                            </td>
                                                        @endif
                                                        <td class="text-start">
                                                            <span class="dropdown">
                                                                <button
                                                                    class="btn small-btn dropdown-toggle align-text-top"
                                                                    data-bs-boundary="viewport" data-bs-toggle="dropdown"
                                                                    aria-expanded="false">{{ __('Actions') }}</button>
                                                                <div class="dropdown-menu dropdown-menu-end"
                                                                    style="">
                                                                    <a class="dropdown-item" href="{{ route('user.download.barcode', $bar_code->barcode_id) }}">{{ __('Download Barcode') }}</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('user.edit.barcode', $bar_code->barcode_id) }}">{{ __('Edit') }}</a>
                                                                    @if ($bar_code->status == 0)
                                                                        <a class="dropdown-item" href="#"
                                                                            onclick="updateBarcodeStatus('{{ $bar_code->barcode_id }}', 'active'); return false;">{{ __('Activate') }}</a>
                                                                    @else
                                                                        <a class="dropdown-item" href="#"
                                                                            onclick="updateBarcodeStatus('{{ $bar_code->barcode_id }}', 'deactive'); return false;">{{ __('Deactivate') }}</a>
                                                                    @endif
                                                                    <a class="dropdown-item" href="#"
                                                                        onclick="deleteBarcode('{{ $bar_code->barcode_id }}', 'delete'); return false;">{{ __('Delete') }}</a>
                                                                </div>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- Footer --}}
        @include('user.includes.footer')
    </div>

    {{-- Update QR Code Status Modal --}}
    <div class="modal modal-blur fade" id="status-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">{{ __('Are you sure?') }}</div>
                    <div id="update_status"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <a class="btn btn-danger" id="status_qr_code_id">{{ __('Yes, proceed') }}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete QR Code Modal --}}
    <div class="modal modal-blur fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">{{ __('Are you sure?') }}</div>
                    <div id="delete_status"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <a class="btn btn-danger" id="delete_qr_code_id">{{ __('Yes, proceed') }}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Update Barcode Status Modal --}}
    <div class="modal modal-blur fade" id="barcode-status-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">{{ __('Are you sure?') }}</div>
                    <div id="barcode_update_status"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <a class="btn btn-danger" id="status_barcode_id">{{ __('Yes, proceed') }}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Barcode Modal --}}
    <div class="modal modal-blur fade" id="barcode-delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">{{ __('Are you sure?') }}</div>
                    <div id="barcode_delete_status"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <a class="btn btn-danger" id="delete_barcode_id">{{ __('Yes, proceed') }}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom JS --}}
@section('custom-js')
    <script>
        // Update QR Status
        function updateQrStatus(statusQrCodeId, statusQrCodeStatus) {
            "use strict";
            $("#status-modal").modal("show");
            var update_status = document.getElementById("update_status");
            update_status.innerHTML = "<?php echo __('If you proceed, you will'); ?> " + statusQrCodeStatus + " <?php echo __('this QR Code.'); ?>"
            var status_link = document.getElementById("status_qr_code_id");
            status_link.getAttribute("href");
            status_link.setAttribute("href", "{{ route('user.update.qr.status') }}?id=" + statusQrCodeId);
        }

        // Delete QR
        function deleteQr(deleteQrCodeId, deleteQrCodeStatus) {
            "use strict";
            $("#delete-modal").modal("show");
            var delete_status = document.getElementById("delete_status");
            delete_status.innerHTML = "<?php echo __('If you proceed, you will'); ?> " + deleteQrCodeStatus + " <?php echo __('this QR Code.'); ?>"
            var delete_link = document.getElementById("delete_qr_code_id");
            delete_link.getAttribute("href");
            delete_link.setAttribute("href", "{{ route('user.delete.qr') }}?id=" + deleteQrCodeId);
        }

        // Update Barcode Status
        function updateBarcodeStatus(statusBarcodeId, statusBarcodeStatus) {
            "use strict";
            $("#barcode-status-modal").modal("show");
            var update_status = document.getElementById("barcode_update_status");
            update_status.innerHTML = "<?php echo __('If you proceed, you will'); ?> " + statusBarcodeStatus + " <?php echo __('this barcode.'); ?>"
            var status_link = document.getElementById("status_barcode_id");
            status_link.getAttribute("href");
            status_link.setAttribute("href", "{{ route('user.update.barcode.status') }}?id=" + statusBarcodeId);
        }

        // Delete Barcode
        function deleteBarcode(deleteBarcodeId, deleteBarcodeStatus) {
            "use strict";
            $("#barcode-delete-modal").modal("show");
            var delete_status = document.getElementById("barcode_delete_status");
            delete_status.innerHTML = "<?php echo __('If you proceed, you will'); ?> " + deleteBarcodeStatus + " <?php echo __('this barcode.'); ?>"
            var delete_link = document.getElementById("delete_barcode_id");
            delete_link.getAttribute("href");
            delete_link.setAttribute("href", "{{ route('user.delete.barcode') }}?id=" + deleteBarcodeId);
        }
    </script>
@endsection
@endsection
