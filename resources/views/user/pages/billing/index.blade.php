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
                            {{ __('Billing Details') }}
                        </h2>
                        <h6>{{ __('These details will be used for the invoice.') }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
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

                    <div class="col-sm-12 col-lg-12">
                        <form action="{{ route('user.update.billing') }}" method="post" class="card">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="row">
                                        <input type="hidden" class="form-control" name="plan_id"
                                            value="{{ Request::segment(3) }}">

                                        <div class="col-md-4 col-xl-4">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Name') }}</label>
                                                <input type="text" class="form-control" name="billing_name"
                                                    placeholder="{{ __('Name') }}..."
                                                    value="{{ Auth::user()->billing_name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Email') }}</label>
                                                <input type="email" class="form-control" name="billing_email"
                                                    placeholder="{{ __('Email') }}..."
                                                    value="{{ Auth::user()->billing_email }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Phone') }}</label>
                                                <input type="tel" class="form-control" name="billing_phone"
                                                    placeholder="{{ __('Phone') }}..."
                                                    value="{{ Auth::user()->billing_phone }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Billing Address') }}</label>
                                                <textarea class="form-control" name="billing_address" id="billing_address" cols="10" rows="3"
                                                    placeholder="{{ __('Billing Address') }}...">{{ Auth::user()->billing_address }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Billing City') }}</label>
                                                <input type="text" class="form-control" name="billing_city"
                                                    placeholder="{{ __('Billing City') }}..."
                                                    value="{{ Auth::user()->billing_city }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Billing State/Province') }}</label>
                                                <input type="text" class="form-control" name="billing_state"
                                                    placeholder="{{ __('Billing State/Province') }}..."
                                                    value="{{ Auth::user()->billing_state }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Billing Zip Code') }}</label>
                                                <input type="text" class="form-control" name="billing_zipcode"
                                                    placeholder="{{ __('Billing Zip Code') }}..."
                                                    value="{{ Auth::user()->billing_zipcode }}">
                                            </div>
                                        </div>

                                        @include('user.pages.billing.includes.countries')

                                        <div class="col-md-4 col-xl-4">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Tax Number') }} </label>
                                                <input type="text" class="form-control" name="vat_number"
                                                    placeholder="{{ __('Tax Number') }}..."
                                                    value="{{ Auth::user()->vat_number }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="type">{{ __('Type') }}</label>
                                                <select name="type" id="type" class="form-control">
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

                                <div class="col-md-4 col-xl-4 my-3">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Save') }}
                                        </button>
                                        <button type="submit" class="btn btn-dark">
                                            {{ __('Skip & Active') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('user.includes.footer')
    </div>

    {{-- Custom Js --}}
    @section('custom-js')
        <script src="{{ asset('js/tom-select.base.min.js') }}"></script>
        <script>
            // @formatter:off
            document.addEventListener("DOMContentLoaded", function() {
                var el;
                window.TomSelect && (new TomSelect(el = document.getElementById('select-country'), {
                    copyClassesToDropdown: false,
                    dropdownParent: 'body',
                    controlInput: '<input>',
                    render: {
                        item: function(data, escape) {
                            if (data.customProperties) {
                                return '<div><span class="dropdown-item-indicator">' + data
                                    .customProperties + '</span>' + escape(data.text) + '</div>';
                            }
                            return '<div>' + escape(data.text) + '</div>';
                        },
                        option: function(data, escape) {
                            if (data.customProperties) {
                                return '<div><span class="dropdown-item-indicator">' + data
                                    .customProperties + '</span>' + escape(data.text) + '</div>';
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
