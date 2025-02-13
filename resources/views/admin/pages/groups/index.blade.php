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
                            {{ __('Groups') }}
                        </h2>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <a href="{{ route('admin.create.group') }}" class="btn btn-primary">
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

                            {{-- Groups --}}
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table" id="table">
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
                                        {{-- Groups --}}
                                        @foreach ($groups as $group)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('d/m/Y h:i A', strtotime($group->created_at)) }}</td>
                                                <td><a href="{{ route('admin.view.group', $group->group_id) }}">{{ $group->group_name }}</a></td>
                                                </td>
                                                @if ($group->status == 1)
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
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.edit.group', $group->group_id) }}">{{ __('Edit') }}</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.view.group', $group->group_id) }}">{{ __('View') }}</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.download.group', $group->group_id) }}">{{ __('Download Barcodes') }}</a>
                                                            @if ($group->status == 0)
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="updateGroupStatus('{{ $group->group_id }}', 'active'); return false;">{{ __('Activate') }}</a>
                                                            @else
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="updateGroupStatus('{{ $group->group_id }}', 'deactive'); return false;">{{ __('Deactivate') }}</a>
                                                            @endif
                                                            <a class="dropdown-item" href="#"
                                                                onclick="deleteGroup('{{ $group->group_id }}', 'delete'); return false;">{{ __('Delete') }}</a>
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
                    <a class="btn btn-danger" id="status_group">{{ __('Yes, proceed') }}</a>
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
                    <a class="btn btn-danger" id="delete_group">{{ __('Yes, proceed') }}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom JS --}}
@section('custom-js')
    <script>
        // Update Group
        function updateGroupStatus(statusGroupId, statusGroupStatus) {
            "use strict";
            $("#status-modal").modal("show");
            var update_status = document.getElementById("update_status");
            update_status.innerHTML = "<?php echo __('If you proceed, you will'); ?> " + statusGroupStatus + " <?php echo __('this group.'); ?>"
            var status_link = document.getElementById("status_group");
            status_link.getAttribute("href");
            status_link.setAttribute("href", "{{ route('admin.update.group.status') }}?id=" + statusGroupId);
        }

        // Delete Group
        function deleteGroup(deleteGroupId, deleteGroupStatus) {
            "use strict";
            $("#delete-modal").modal("show");
            var delete_status = document.getElementById("delete_status");
            delete_status.innerHTML = "<?php echo __('If you proceed, you will'); ?> " + deleteGroupStatus + " <?php echo __('this group.'); ?>"
            var delete_link = document.getElementById("delete_group");
            delete_link.getAttribute("href");
            delete_link.setAttribute("href", "{{ route('admin.delete.group') }}?id=" + deleteGroupId);
        }
    </script>
@endsection
@endsection
