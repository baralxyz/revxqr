@extends('admin.layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="container-xl mt-3">

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

            {{-- Transactions --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Transactions') }}</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable" id="table">
                            <thead>
                                <tr>
                                    <th>{{ __('#') }}</th>
                                    <th>{{ __('Transaction Date') }}</th>
                                    <th>{{ __('Payment Trans ID') }}</th>
                                    <th>{{ __('Customer Name') }}</th>
                                    <th>{{ __('Gateway Name') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transaction->created_at->format('d-m-Y H:i A') }}</td>
                                        <td>{{ $transaction->transaction_id }}</td>
                                        <td><a
                                                href="{{ route('admin.view.user', $transaction->userId) }}">{{ __($transaction->name) }}</a>
                                        </td>
                                        <td>
                                            {{ __($transaction->payment_gateway_name) }}
                                        </td>
                                        <td>
                                            @foreach ($currencies as $currency)
                                                @if ($transaction->transaction_currency == $currency->iso_code)
                                                    {{ $currency->symbol }}{{ $transaction->transaction_amount }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($transaction->payment_status == 'SUCCESS')
                                                <span class="badge bg-green text-white">{{ __('Paid') }}</span>
                                            @endif
                                            @if ($transaction->payment_status == 'FAILED')
                                                <span class="badge bg-red text-white">{{ __('Failed') }}</span>
                                            @endif
                                            @if ($transaction->payment_status == 'PENDING')
                                                <span class="badge bg-orange text-white">{{ __('Pending') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-start">
                                            <span class="dropdown">
                                                <button class="btn dropdown-toggle align-text-top small-btn"
                                                    data-bs-boundary="viewport" data-bs-toggle="dropdown"
                                                    aria-expanded="false">{{ __('Actions') }}</button>
                                                <div class="dropdown-menu dropdown-menu-end" style="">
                                                    @if ($transaction->payment_status == 'SUCCESS')
                                                        <a class="dropdown-item" target="_blank"
                                                            href="{{ route('admin.view.invoice', ['id' => $transaction->id]) }}">{{ __('Invoice') }}</a>
                                                    @endif

                                                    @if ($transaction->payment_status != 'PENDING')
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.trans.status', ['id' => $transaction->id, 'status' => 'PENDING']) }}">{{ __('Pending') }}</a>
                                                    @endif
                                                    @if ($transaction->payment_status != 'SUCCESS')
                                                        <a class="dropdown-item" href="#"
                                                            onclick="getTransaction('{{ $transaction->id }}'); return false;">{{ __('Success') }}</a>
                                                    @endif
                                                    @if ($transaction->payment_status != 'FAILED')
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.trans.status', ['id' => $transaction->id, 'status' => 'FAILED']) }}">{{ __('Failed') }}</a>
                                                    @endif
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

        {{-- Footer --}}
        @include('admin.includes.footer')
    </div>

    {{-- Update transaction status --}}
    <div class="modal modal-blur fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">{{ __('Are you sure?') }}</div>
                    <div>{{ __('If you proceed with this transaction, you will have payment status success this plan.') }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto"
                        data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <a class="btn btn-danger" id="transaction_id">{{ __('Yes, proceed') }}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom JS --}}
@section('custom-js')
    <script>
        function getTransaction(parameter) {
            "use strict";
            $("#delete-modal").modal("show");
            var link = document.getElementById("transaction_id");
            link.getAttribute("href");
            link.setAttribute("href", "/admin/transaction-status/" + parameter + "/SUCCESS");
        }
    </script>
@endsection
@endsection
