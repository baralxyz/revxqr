@extends('user.layouts.app')

{{-- Custom CSS --}}
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/tabler-flags.min.css') }}">
@endsection

{{-- Payments --}}
@php
    use App\Models\Config;
    $config = Config::get();
    $type = $config[13]->config_value;
@endphp

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
                            {{ __('Checkout') }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Choosed plan --}}
        @if ($selected_plan == null)
            <div class="container-xl mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">{{ __('No Plan Found') }}</h3>
                            <a href="{{ route('user.checkout', Request::segment(3)) }}"
                                class="btn btn-primary">{{ __('Back') }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container-xl mt-3">
                <div class="row">
                    <div class="col-lg-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">{{ __('Upgrade/Renewal Plan') }}</h3>
                                <div class="card-table table-responsive">
                                    <table class="table table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="w-1">{{ __('Description') }}</th>
                                                <th class="w-1">{{ __('Price') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="text-bold">
                                                        <h5>{{ __($selected_plan->plan_name) }} - {{ $selected_plan->validity }} {{ __('Days') }}</h5>
                                                    </div>
                                                </td>
                                                <td class="text-bold">
                                                    <h5>{{ $currency->symbol }}{{ $selected_plan->plan_price == '0' ? 0 : number_format($selected_plan->plan_price, 2) }}</h5>
                                                </td>
                                            </tr>
                                            @if ($config[25]->config_value > 0)
                                                <tr>
                                                    <td class="text-bold">
                                                        <div>
                                                            <h5>{{ __($config[24]->config_value) }}</h5>
                                                        </div>
                                                    </td>
                                                    <td class="text-bold">
                                                        <h5>{{ $currency->symbol }}{{ number_format(($selected_plan->plan_price * $config[25]->config_value) / 100, 2) }}</h5>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="text-bold"><h4>{{ __('Total Payable') }}</h4></td>
                                                <td class="text-bold">
                                                   <h4>{{ $currency->symbol }}{{ number_format($total, 2) }}</h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
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

                        <form action="{{ route('prepare.payment.gateway', $selected_plan->id) }}" method="post">
                            @csrf
                            <div class="col-lg-12 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="row">
                                                <h3 class="card-title text-muted mb-3">{{ __('Billing Details') }}</h1>
                                                    <div class="col-md-4 col-xl-4">
                                                        <div class="mb-3">
                                                            <label class="form-label required">{{ __('Name') }}</label>
                                                            <input type="text" class="form-control" name="billing_name"
                                                                placeholder="{{ __('Name') }}..."
                                                                value="{{ Auth::user()->billing_name }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xl-4">
                                                        <div class="mb-3">
                                                            <label class="form-label required">{{ __('Email') }}</label>
                                                            <input type="email" class="form-control" name="billing_email"
                                                                placeholder="{{ __('Email') }}..."
                                                                value="{{ Auth::user()->billing_email }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xl-4">
                                                        <div class="mb-3">
                                                            <label class="form-label required">{{ __('Phone') }}</label>
                                                            <input type="tel" class="form-control" name="billing_phone"
                                                                placeholder="{{ __('Phone') }}..."
                                                                value="{{ Auth::user()->billing_phone }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xl-12">
                                                        <div class="mb-3">
                                                            <label
                                                                class="form-label required">{{ __('Billing Address') }}</label>
                                                            <textarea class="form-control" name="billing_address" id="billing_address" cols="10" rows="2"
                                                                placeholder="{{ __('Billing Address') }}..." required>{{ Auth::user()->billing_address }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-6">
                                                        <div class="mb-3">
                                                            <label
                                                                class="form-label required">{{ __('Billing City') }}</label>
                                                            <input type="text" class="form-control"
                                                                name="billing_city"
                                                                placeholder="{{ __('Billing City') }}..."
                                                                value="{{ Auth::user()->billing_city }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-6">
                                                        <div class="mb-3">
                                                            <label
                                                                class="form-label required">{{ __('Billing State/Province') }}</label>
                                                            <input type="text" class="form-control"
                                                                name="billing_state"
                                                                placeholder="{{ __('Billing State/Province') }}..."
                                                                value="{{ Auth::user()->billing_state }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-6">
                                                        <div class="mb-3">
                                                            <label
                                                                class="form-label required">{{ __('Billing Zip Code') }}</label>
                                                            <input type="text" class="form-control"
                                                                name="billing_zipcode"
                                                                placeholder="{{ __('Billing Zip Code') }}..."
                                                                value="{{ Auth::user()->billing_zipcode }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-6">
                                                        <div class="mb-3">
                                                            <label
                                                                class="form-label required">{{ __('Billing Country') }}</label>
                                                            <select value="{{ Auth::user()->billing_country }}"
                                                                class="form-select" name="billing_country"
                                                                placeholder="{{ __('Choose Country') }}"
                                                                id="select-country" required>
                                                                {{-- Countries list --}}
                                                                @include('user.pages.checkout.includes.countries')
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('Tax Number') }} </label>
                                                            <input type="text" class="form-control" name="vat_number"
                                                                placeholder="{{ __('Tax Number') }}..."
                                                                value="{{ Auth::user()->vat_number }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-xl-6">
                                                        <div class="mb-3">
                                                            <label class="form-label required"
                                                                for="type">{{ __('Type') }}</label>
                                                            <select name="type" id="type" class="form-control"
                                                                required>
                                                                <option value="personal"
                                                                    {{ Auth::user()->type == 'personal' ? 'selected' : '' }}>
                                                                    {{ __('Personal') }}</option>
                                                                <option value="business"
                                                                    {{ Auth::user()->type == 'business' ? 'selected' : '' }}>
                                                                    {{ __('Business') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($type == 1)
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h3 class="card-title text-muted">{{ __('Payment method') }}</h3>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <div class="row">
                                                            @foreach ($gateways as $gateway)
                                                                <div class="col-lg-4 mb-3">
                                                                    <div
                                                                        class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                                                                        <label class="form-selectgroup-item flex-fill">
                                                                            <input type="radio"
                                                                                name="payment_gateway_id"
                                                                                value="{{ $gateway->id }}"
                                                                                class="form-selectgroup-input">
                                                                            <div
                                                                                class="form-selectgroup-label d-flex align-items-center p-3">
                                                                                <div class="me-3">
                                                                                    <span
                                                                                        class="form-selectgroup-check"></span>
                                                                                </div>
                                                                                <span class="avatar me-3"
                                                                                    style="background-image: url({{ asset($gateway->payment_gateway_logo) }})"></span>
                                                                                <div>
                                                                                    <div class="font-weight-medium h4">
                                                                                        {{ __($gateway->display_name) }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <input type="submit" value="{{ __('Continue for payment') }}"
                                                            class="btn btn-primary">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- Payments empty --}}
                                <div class="page-body">
                                    <div class="alert alert-danger">
                                        <p class="empty-title">{{ __('Payment module not available.') }}</p>
                                    </div>
                                </div>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        @endif

        {{-- Footer --}}
        @include('user.includes.footer')
    </div>

    {{-- Custom Js --}}
    @section('custom-js')
    <script src="{{ asset('js/tom-select.base.min.js') }}"></script>
    <script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
        var el;
        window.TomSelect && (new TomSelect(el = document.getElementById('select-country'), {
            copyClassesToDropdown: false,
            dropdownParent: 'body',
            controlInput: '<input>',
            render:{
                item: function(data,escape) {
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                option: function(data,escape){
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
            },
        }));
    });
    // @formatter:on
    </script>
    @endsection
@endsection
