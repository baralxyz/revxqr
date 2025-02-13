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
                        {{ __('Edit Plan') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                {{-- Update Plan --}}
                <div class="col-sm-12 col-lg-12">
                    <form action="{{ route('admin.update.plan') }}" method="post" class="card">
                        @csrf

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

                        <div class="card-header">
                            <h4 class="page-title">{{ __('Plan Details') }}</h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="row">
                                        <input type="hidden" class="form-control" name="plan_id"
                                            placeholder="{{ __('Plan ID') }}..." value="{{ $plan_details->id }}"
                                            readonly>
                                            
                                        {{-- Recommended --}}
                                        <div class="col-md-2 col-xl-2">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Recommended') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="recommended"
                                                        {{ $plan_details->recommended == 1 ? 'checked' : '' }}>
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Plan Name --}}
                                        <div class="col-md-10 col-xl-10">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Plan Name') }}</label>
                                                <input type="text" class="form-control" name="plan_name"
                                                    placeholder="{{ __('Plan Name') }}..."
                                                    value="{{ $plan_details->plan_name }}" required>
                                            </div>
                                        </div>

                                        {{-- Plan Description --}}
                                        <div class="col-md-12 col-xl-12">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Description') }}</label>
                                                <textarea class="form-control" name="plan_description" rows="3"
                                                    placeholder="{{ __('Description') }}.."
                                                    required>{{ $plan_details->plan_description }}</textarea>

                                            </div>
                                        </div>

                                        {{-- Plan Pricing --}}
                                        <h2 class="page-title my-3">
                                            {{ __('Plan Prices') }}
                                        </h2>
                                        <div class="col-md-6 col-xl-6">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Price') }} <span
                                                        class="text-muted">({{ __('For free: 0')
                                                        }})</span></label>
                                                <input type="number" class="form-control" name="plan_price" min="0"
                                                    step="0.01" placeholder="{{ __('Price') }}..."
                                                    value="{{ $plan_details->plan_price }}" required>
                                            </div>
                                        </div>

                                        {{-- Validity --}}
                                        <div class="col-md-6 col-xl-6">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Validity') }} <span
                                                        class="text-muted">({{ __('Enter no. of days') }})
                                                        ({{ __('For forever: 9999') }})</span></label>
                                                <input type="number" class="form-control" name="validity" min="1"
                                                    max="9999" placeholder="{{ __('Validity') }}..."
                                                    value="{{ $plan_details->validity }}" required>
                                            </div>
                                        </div>

                                        {{-- Plan Features --}}
                                        <h2 class="page-title my-3">
                                            {{ __('Plan Features') }}
                                        </h2>

                                        {{-- QR Code Types --}}
                                        <div class="col-md-4 col-xl-4">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('QR Code Types') }}</label>
                                                <input type="number" class="form-control" name="no_access_qr" min="1"
                                                    max="999" placeholder="{{ __('QR Code Types') }}..."
                                                    value="{{ $plan_details->no_access_qr }}" required>
                                            </div>
                                        </div>

                                        {{-- No. Of QR Codes --}}
                                        <div class="col-md-4 col-xl-4">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('No. Of QR Codes') }}
                                                    <span class="text-muted">({{ __('For unlimited: 999')
                                                        }})</span></label>
                                                <input type="number" class="form-control" name="no_qrcodes" min="1"
                                                    max="999" placeholder="{{ __('No. Of QR Codes') }}..."
                                                    value="{{ $plan_details->no_qrcodes }}" required>
                                            </div>
                                        </div>

                                        {{-- No. Of Barcodes --}}
                                        <div class="col-md-4 col-xl-4">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('No. Of Barcodes') }}
                                                    <span class="text-muted">({{ __('For unlimited: 999')
                                                        }})</span></label>
                                                <input type="number" class="form-control" name="no_barcodes" min="1"
                                                    max="999" placeholder="{{ __('No. Of Barcodes') }}"
                                                    value="{{ $plan_details->no_barcodes }}" required>
                                            </div>
                                        </div>

                                        {{-- Text --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Text') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->access_text ==
                                                    1 ? 'checked' : '' }} name="text">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- URL --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('URL') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->access_url ==
                                                    1 ? 'checked' : '' }} name="url">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Phone --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Phone') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->access_phone ==
                                                    1 ? 'checked' : '' }} name="phone">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- SMS --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('SMS') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->access_sms ==
                                                    1 ? 'checked' : '' }} name="sms">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Email --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Email') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->access_email ==
                                                    1 ? 'checked' : '' }} name="email">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- WhatsApp --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('WhatsApp') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->access_whatsapp ==
                                                    1 ? 'checked' : '' }} name="whatsapp">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Facetime --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Facetime') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->access_facetime ==
                                                    1 ? 'checked' : '' }} name="facetime">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Location --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Location') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->access_location ==
                                                    1 ? 'checked' : '' }} name="location">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Wifi --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Wifi') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->access_wifi ==
                                                    1 ? 'checked' : '' }} name="wifi">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Event --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Event') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->access_event ==
                                                    1 ? 'checked' : '' }} name="event">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Crypto --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Crypto') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->access_crypto ==
                                                    1 ? 'checked' : '' }} name="crypto">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- vCard --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('vCard') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->access_vcard ==
                                                    1 ? 'checked' : '' }} name="vcard">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Paypal --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Paypal') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->access_paypal ==
                                                    1 ? 'checked' : '' }} name="paypal">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- UPI --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('UPI') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->access_upi ==
                                                    1 ? 'checked' : '' }} name="upi">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Additional Tools --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Additional Tools') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->additional_tools ==
                                                    1 ? 'checked' : '' }}
                                                    name="additional_tools">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Enable Analytics --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Enable Analytics') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{
                                                        $plan_details->enable_analaytics ==
                                                    1 ? 'checked' : '' }}
                                                    name="enable_analaytics">
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Hide Branding --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Hide Branding') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="hide_branding"
                                                        {{ $plan_details->hide_branding == 1 ? 'checked' : '' }}>
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Support --}}
                                        <div class="col-md-3 col-xl-3">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Support') }}</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="support" {{
                                                        $plan_details->support == 1 ? 'checked' : '' }}>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <div class="d-flex">
                                                <button type="submit" class="btn btn-primary btn-md ms-auto">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-edit" width="24" height="24"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path
                                                            d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3">
                                                        </path>
                                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3">
                                                        </path>
                                                        <line x1="16" y1="5" x2="19" y2="8"></line>
                                                    </svg>
                                                    {{ __('Update') }}
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