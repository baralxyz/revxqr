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
                        {{ __('Add Plan') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">

            {{-- Failed --}}
            @if (Session::has("failed"))
            <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        {{Session::get('failed')}}
                    </div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            @endif

            {{-- Success --}}
            @if(Session::has("success"))
            <div class="alert alert-important alert-success alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        {{Session::get('success')}}
                    </div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            @endif

            <div class="row row-deck row-cards">
                {{-- Save Plan --}}
                <div class="col-sm-12 col-lg-12">
                    <form action="{{ route('admin.save.plan') }}" method="post" class="card">
                        @csrf
                        <div class="card-header">
                            <h4 class="page-title">{{ __('Plan Details') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="row">

                                        {{-- Recommended --}}
                                        <div class="col-md-2 col-xl-2">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Recommended') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="recommended">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Plan Name --}}
                                        <div class="col-md-10 col-xl-10">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Plan Name') }}</label>
                                                <input type="text" class="form-control" name="plan_name"
                                                    placeholder="{{ __('Plan Name') }}" required>
                                            </div>
                                        </div>
                                        {{-- Plan Description --}}
                                        <div class="col-md-12 col-xl-12">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Description') }}</label>
                                                <textarea class="form-control" name="plan_description" rows="3"
                                                    placeholder="{{ __('Description') }}.." required></textarea>

                                            </div>
                                        </div>

                                        {{-- Plan Prices --}}
                                        <h2 class="page-title my-3">
                                            {{ __('Plan Prices') }}
                                        </h2>
                                        <div class="col-md-6 col-xl-6">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Price') }} <span
                                                        class="text-muted">({{ __('For free: 0')
                                                        }})</span></label>
                                                <input type="number" class="form-control" name="plan_price" min="0"
                                                    step="0.01" placeholder="{{ __('Price') }}" required>
                                            </div>
                                        </div>

                                        {{-- Plan Validity --}}
                                        <div class="col-md-6 col-xl-6">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Validity') }} <span
                                                        class="text-muted">({{ __('Enter no. of days') }})
                                                        ({{ __('For forever: 9999') }})</span></label>
                                                <input type="number" class="form-control" name="validity" min="1"
                                                    max="9999" placeholder="{{ __('Validity') }}"
                                                    value="{{ $config[8]->config_value == 'monthly' ? 31 : 365 }}"
                                                    required>
                                            </div>
                                        </div>

                                        {{-- Plan Features --}}
                                        <h2 class="page-title my-3">
                                            {{ __('Plan Features') }}
                                        </h2>
                                        {{-- QR Code Types --}}
                                        <div class="col-md-4 col-xl-4">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('QR Code Types') }} <span
                                                        class="text-muted"></label>
                                                <input type="number" class="form-control" name="no_access_qr" min="1"
                                                    max="999" placeholder="{{ __('QR Code Types') }}" value="1"
                                                    required>
                                            </div>
                                        </div>

                                        {{-- No. Of QR Codes --}}
                                        <div class="col-md-4 col-xl-4">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('No. Of QR Codes') }}
                                                    <span class="text-muted">({{ __('For unlimited: 999')
                                                        }})</span></label>
                                                <input type="number" class="form-control" name="no_qrcodes" min="1"
                                                    max="999" placeholder="{{ __('No. Of QR Codes') }}" value="1"
                                                    required>
                                            </div>
                                        </div>

                                        {{-- No. Of Barcodes --}}
                                        <div class="col-md-4 col-xl-4">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('No. Of Barcodes') }}
                                                    <span class="text-muted">({{ __('For unlimited: 999')
                                                        }})</span></label>
                                                <input type="number" class="form-control" name="no_barcodes" min="1"
                                                    max="999" placeholder="{{ __('No. Of Barcodes') }}" value="1"
                                                    required>
                                            </div>
                                        </div>

                                        {{-- Text --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Text') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="text">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- URL --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('URL') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="url">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Phone --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Phone') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="phone">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- SMS --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('SMS') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="sms">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Email --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Email') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="email">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- WhatsApp --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('WhatsApp') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="whatsapp">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Facetime --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Facetime') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="facetime">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Location --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Location') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="location">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Wifi --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Wifi') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="wifi">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Event --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Event') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="event">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Crypto --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Crypto') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="crypto">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- vCard --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('vCard') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="vcard">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Paypal --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Paypal') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="paypal">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- UPI --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('UPI') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="upi">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Additional Tools --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Additional Tools') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="additional_tools">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Enable Analytics --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Enable Analytics') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="enable_analaytics">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Hide Branding --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Hide Branding') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="hide_branding">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Support --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Support') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="support">
                                                </label>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <div class="d-flex">
                                                <button type="submit" class="btn btn-primary btn-md ms-auto">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-plus" width="24" height="24"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                                    </svg>
                                                    {{ __('Add') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    @include('admin.includes.footer')
</div>
@endsection