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
                            {{ __('Logs') }}
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('admin.clear.logs') }}" class="btn btn-primary btn-sm">
                                {{ __('Clear All') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
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

                <div class="row row-deck row-cards">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">

                            {{-- Logs --}}
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table" id="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('S.No') }}</th>
                                            <th>{{ __('IP Address') }}</th>
                                            <th>{{ __('Browser') }}</th>
                                            <th>{{ __('Location') }}</th>
                                            <th>{{ __('Login At') }}</th>
                                            <th>{{ __('Login Successful') }}</th>
                                            <th>{{ __('Logout at') }}</th>
                                            <th>{{ __('Cleared by user') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Logs --}}
                                        @foreach ($logs as $log)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $log->ip_address }}</td>

                                                <td><span class="badge bg-success text-white">{{ $log->platform }} -
                                                        {{ $log->browser }}</span></td>

                                                <td><a href="https://www.google.com/maps/place/{{ $log->location }}"
                                                        target="_blank">{{ $log->location }}</a></td>

                                                @if ($log->login_at == '')
                                                    <td>{{ __('-') }}</td>
                                                @else
                                                    <td>{{ date('d M Y h:i A', strtotime($log->login_at)) }}</td>
                                                @endif

                                                @if ($log->login_successful == '1')
                                                    <td><span
                                                            class="badge bg-success text-white">{{ __('YES') }}</span>
                                                    </td>
                                                @else
                                                    <td><span class="badge bg-danger text-white">{{ __('NO') }}</span>
                                                    </td>
                                                @endif

                                                @if ($log->logout_at == '')
                                                    <td>{{ __('-') }}</td>
                                                @else
                                                    <td>{{ date('d M Y h:i A', strtotime($log->logout_at)) }}</td>
                                                @endif

                                                @if ($log->cleared_by_user == '1')
                                                    <td><span
                                                            class="badge bg-success text-white">{{ __('YES') }}</span>
                                                    </td>
                                                @else
                                                    <td><span class="badge bg-danger text-white">{{ __('NO') }}</span>
                                                    </td>
                                                @endif
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
@endsection
