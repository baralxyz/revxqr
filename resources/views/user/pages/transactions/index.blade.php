@extends('user.layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="container-xl mt-3">
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
            
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Transactions') }}</h3>
                    </div>
                    <div class="table-responsive px-2 py-2">
                        <table class="table card-table table-vcenter text-nowrap datatable" id="table">
                            <thead>
                                <tr>
                                    <th>{{ __('S.No') }}</th>
                                    <th>{{ __('Transaction Date') }}</th>
                                    <th class="w-1">{{ __('Payment ID') }}</th>
                                    <th>{{ __('Trans ID') }}</th>
                                    <th>{{ __('Payment Mode') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transaction->created_at->format('d-m-Y H:i:s A') }}</td>
                                        <td><span>{{ $transaction->transaction_id }}</span></td>
                                        <td>{{ $transaction->transaction_id }}</td>
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
                                                <span class="badge bg-yellow text-white">{{ __('Pending') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-start">
                                            @if ($transaction->transaction_amount != 0 && $transaction->payment_status == 'SUCCESS')
                                                <span class="dropdown">
                                                    <button class="btn small-btn dropdown-toggle align-text-top"
                                                        data-bs-boundary="viewport" data-bs-toggle="dropdown"
                                                        aria-expanded="false">{{ __('Actions') }}</button>
                                                    <div class="dropdown-menu dropdown-menu-end" style="">
                                                        @if ($transaction->invoice_number > 0)
                                                            <a class="dropdown-item"
                                                                href="{{ route('user.view.invoice', ['id' => $transaction->id]) }}">{{ __('Invoice') }}</a>
                                                        @endif
                                                    </div>
                                                </span>
                                            @endif
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
        @include('user.includes.footer')
    </div>
@endsection
