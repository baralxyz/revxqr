@extends('user.layouts.app')

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
                            {{ __('Barcodes') }}
                        </h2>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            {{-- Bluk upload --}}
                            <a href="{{ route('user.bulk.upload') }}" class="btn btn-primary d-none d-sm-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" /> 
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                    <path d="M7 9l5 -5l5 5" />
                                    <path d="M12 4l0 12" />
                                </svg>
                                {{ __('Bulk Upload') }}
                            </a>
                            {{-- Create single barcode --}}
                            <a href="{{ route('user.create.barcode') }}" class="btn btn-primary d-none d-sm-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                                {{ __('Create') }}
                            </a>

                            {{-- Mobile --}}
                            {{-- Bluk upload --}}
                            <a href="{{ route('user.bulk.upload') }}" class="btn btn-primary d-sm-none btn-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                    <path d="M7 9l5 -5l5 5" />
                                    <path d="M12 4l0 12" />
                                </svg>
                            </a>
                            {{-- Create single barcode --}}
                            <a href="{{ route('user.create.barcode') }}" class="btn btn-primary d-sm-none btn-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
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

                            {{-- Bar Codes --}}
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table" id="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('S.No') }}</th>
                                            <th>{{ __('Created on') }}</th>
                                            <th>{{ __('Group') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Bar Codes --}}
                                        @foreach ($bar_codes as $bar_code)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('d/m/Y h:i A', strtotime($bar_code->created_at)) }}</td>
                                                <td><a href="{{ route('user.view.group', $bar_code->group_id ? $bar_code->group_id : "general") }}">{{ __($bar_code->group_name ? $bar_code->group_name : "General") }}</a></td>
                                                <td><a href="{{ route('user.download.barcode', $bar_code->barcode_id) }}">{{ $bar_code->name }}</a></td>
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
                                                        <button class="btn small-btn dropdown-toggle align-text-top"
                                                            data-bs-boundary="viewport" data-bs-toggle="dropdown"
                                                            aria-expanded="false">{{ __('Actions') }}</button>
                                                        <div class="dropdown-menu dropdown-menu-end" style="">
                                                            <a class="dropdown-item" href="{{ route('user.download.barcode', $bar_code->barcode_id) }}">{{ __('Download Barcode') }}</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('user.edit.barcode', $bar_code->barcode_id) }}">{{ __('Edit') }}</a>
                                                            @if ($bar_code->status == 0)
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="updateBarStatus('{{ $bar_code->barcode_id }}', 'active'); return false;">{{ __('Activate') }}</a>
                                                            @else
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="updateBarStatus('{{ $bar_code->barcode_id }}', 'deactive'); return false;">{{ __('Deactivate') }}</a>
                                                            @endif
                                                            <a class="dropdown-item" href="#"
                                                                onclick="deleteBar('{{ $bar_code->barcode_id }}', 'delete'); return false;">{{ __('Delete') }}</a>
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
        @include('user.includes.footer')
    </div>


    {{-- Update Bar Code Status Modal --}}
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
                    <a class="btn btn-danger" id="status_bar_code_id">{{ __('Yes, proceed') }}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Bar Code Modal --}}
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
                    <a class="btn btn-danger" id="delete_bar_code_id">{{ __('Yes, proceed') }}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom JS --}}
@section('custom-js')
    <script>
        // Update Bar Status
        function updateBarStatus(statusBarCodeId, statusBarCodeStatus) {
            "use strict";
            $("#status-modal").modal("show");
            var update_status = document.getElementById("update_status");
            update_status.innerHTML = "<?php echo __('If you proceed, you will'); ?> " + statusBarCodeStatus + " <?php echo __('this barcode.'); ?>"
            var status_link = document.getElementById("status_bar_code_id");
            status_link.getAttribute("href");
            status_link.setAttribute("href", "{{ route('user.update.barcode.status') }}?id=" + statusBarCodeId);
        }

        // Delete Bar
        function deleteBar(deleteBarCodeId, deleteBarCodeStatus) {
            "use strict";
            $("#delete-modal").modal("show");
            var delete_status = document.getElementById("delete_status");
            delete_status.innerHTML = "<?php echo __('If you proceed, you will'); ?> " + deleteBarCodeStatus + " <?php echo __('this barcode.'); ?>"
            var delete_link = document.getElementById("delete_bar_code_id");
            delete_link.getAttribute("href");
            delete_link.setAttribute("href", "{{ route('user.delete.barcode') }}?id=" + deleteBarCodeId);
        }
    </script>
@endsection
@endsection
