@extends('admin.layouts.app')

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
                            {{ __('QR Codes') }}
                        </h2>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <a href="{{ route('admin.create.qr') }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                                {{ __('Create') }}
                            </a>
                        </div>
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

                <div class="row row-deck row-cards">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">

                            {{-- QR Codes --}}
                            <div class="table-responsive">
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
                                        {{-- QR Codes --}}
                                        @foreach ($qr_codes as $qr_code)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('d/m/Y h:i A', strtotime($qr_code->created_at)) }}</td>
                                                <td><a href="{{ route('admin.download.qrcode', $qr_code->qr_code_id) }}">{{ $qr_code->name }}</a></td>
                                                <td><a href="{{ route('admin.type.qrcodes', strtolower($qr_code->type)) }}"><span
                                                            class="badge bg-dark text-white">{{ __(strtoupper($qr_code->type)) }}</span></a>
                                                </td>
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
                                                        <button class="btn dropdown-toggle align-text-top small-btn"
                                                            data-bs-boundary="viewport" data-bs-toggle="dropdown"
                                                            aria-expanded="false">{{ __('Actions') }}</button>
                                                        <div class="dropdown-menu dropdown-menu-end" style="">
                                                            @if ($qr_code->type == 'url')
                                                                <a class="dropdown-item" href="{{ route('admin.qr.statistics', $qr_code->qr_code_id) }}">{{ __('Statistics') }}</a>
                                                            @endif
                                                            <a class="dropdown-item" href="{{ route('admin.download.qrcode', $qr_code->qr_code_id) }}">{{ __('Download QR') }}</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.edit.qr', $qr_code->qr_code_id) }}">{{ __('Edit') }}</a>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        @include('admin.includes.footer')
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
            status_link.setAttribute("href", "{{ route('admin.update.qr.status') }}?id=" + statusQrCodeId);
        }

        // Delete QR
        function deleteQr(deleteQrCodeId, deleteQrCodeStatus) {
            "use strict";
            $("#delete-modal").modal("show");
            var delete_status = document.getElementById("delete_status");
            delete_status.innerHTML = "<?php echo __('If you proceed, you will'); ?> " + deleteQrCodeStatus + " <?php echo __('this QR Code.'); ?>"
            var delete_link = document.getElementById("delete_qr_code_id");
            delete_link.getAttribute("href");
            delete_link.setAttribute("href", "{{ route('admin.delete.qr') }}?id=" + deleteQrCodeId);
        }
    </script>
@endsection
@endsection
