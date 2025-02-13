@extends('user.layouts.app')

{{-- Custom CSS --}}
@section('custom-css')
    <style>
        #loader {
            display: flex;
            text-align: center;
            justify-content: center;
        }
    </style>
@endsection

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
                            {{ __('Edit QR Code') }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">

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

                {{-- Check QR Code details --}}
                @if ($qr_code_details)
                    <div class="row row-deck row-cards">
                        <div class="col-sm-12 col-lg-12">
                            {{-- Update Form --}}
                            <form action="{{ route('user.update.qr') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col">
                                    <div class="row">

                                        {{-- Show Generated QR Code --}}
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="sticky-top card p-3">
                                                {{-- Regenerate QR Code --}}
                                                <div id="regenerate_qr" class="visible-print p-3 text-center">
                                                    <img src="{{ asset($qr_code_details->qr_code) }}">
                                                </div>

                                                {{-- Loader --}}
                                                <div id="loader">
                                                    <img
                                                        src="data:image/gif;base64,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">
                                                </div>
                                                <br>


                                                {{-- Download Formats --}}
                                                <div class="row g-2 align-items-center mb-3 mt-3">
                                                    <div class="col-12 col-xl-2 mb-3 font-weight-semibold">
                                                        {{ __('Download Formats') }}</div>

                                                    {{-- .PNG --}}
                                                    <div class="col-6 col-sm-4 col-md-2 col-xl mb-3">
                                                        <a href="#" onclick="downloadQR('png')"
                                                            class="btn btn-pink w-100">
                                                            {{ __('.PNG') }}
                                                        </a>
                                                    </div>

                                                    {{-- .JPG --}}
                                                    <div class="col-6 col-sm-4 col-md-2 col-xl mb-3">
                                                        <a href="#" onclick="downloadQR('jpg')"
                                                            class="btn btn-secondary w-100">
                                                            {{ __('.JPG') }}
                                                        </a>
                                                    </div>

                                                    {{-- .SVG --}}
                                                    <div class="col-6 col-sm-4 col-md-2 col-xl mb-3">
                                                        <a href="#" onclick="downloadQR('svg')"
                                                            class="btn btn-success w-100">
                                                            {{ __('.SVG') }}
                                                        </a>
                                                    </div>

                                                    {{-- .WebP --}}
                                                    <div class="col-6 col-sm-4 col-md-2 col-xl mb-3">
                                                        <a href="#" onclick="downloadQR('webp')"
                                                            class="btn btn-warning w-100">
                                                            {{ __('.WebP') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        {{-- Generate Form --}}
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="card p-3">
                                                <div class="row">

                                                    <input type="hidden" class="form-control" name="qr_code_id"
                                                        value="{{ $qr_code_details->qr_code_id }}" required>

                                                    <input type="hidden" class="form-control" name="qrcode_type"
                                                        value="{{ $qr_code_details->type }}" required>

                                                    {{-- Name --}}
                                                    <div class="col-md-12 col-xl-12">
                                                        <div class="mb-3">
                                                            <label class="form-label required">{{ __('Name') }}</label>
                                                            <input type="text" class="form-control" name="name"
                                                                maxlength="100" value="{{ $qr_code_details->name }}"
                                                                id="name" placeholder="{{ __('Name') }}"
                                                                required>
                                                        </div>
                                                    </div>

                                                    @if ($qr_code_details->type == 'text')
                                                        {{-- Content --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Content') }}</label>
                                                                <textarea name="content" id="content" minlength="1" maxlength="350" placeholder="Lorem ipsum..."
                                                                    class="form-control" cols="30" rows="5" onchange="regenerateQrCode()" required>{{ json_decode($qr_code_details->settings)->text_value }}</textarea>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if ($qr_code_details->type == 'url')
                                                        {{-- Link Url --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Link Url') }}</label>
                                                                <input type="url" class="form-control" name="url"
                                                                    value="{{ json_decode($qr_code_details->settings)->url_value }}"
                                                                    onchange="regenerateQrCode()" id="content"
                                                                    placeholder="{{ __('Ex: http://domain.com') }}"
                                                                    required>
                                                            </div>
                                                        </div>

                                                        {{-- Enable Analytics --}}
                                                        <div data-bs-toggle="tooltip" data-bs-placement="top">
                                                            <div class="col-md-12 col-xl-12">
                                                                <div class="mb-3">
                                                                    <label class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="enable_analytics" id="enable_analytics"
                                                                            onclick="regenerateQrCode()"
                                                                            {{ json_decode($qr_code_details->settings)->url_enable_analytics_value == 'on' ? 'checked' : '' }}>
                                                                        <span
                                                                            class="form-check-label">{{ __('Enable Analytics') }}</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if ($qr_code_details->type == 'phone')
                                                        {{-- Text Content --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Mobile Number') }}</label>
                                                                <input type="text" class="form-control" maxlength="25"
                                                                    name="content"
                                                                    value="{{ json_decode($qr_code_details->settings)->phone_value }}"
                                                                    onchange="regenerateQrCode()" id="content"
                                                                    placeholder="{{ __('Mobile Number') }}" required>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- SMS --}}
                                                    @if ($qr_code_details->type == 'sms')
                                                        {{-- Mobile Number --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Mobile Number') }}</label>
                                                                <input type="text" class="form-control" maxlength="25"
                                                                    name="phone"
                                                                    value="{{ json_decode($qr_code_details->settings)->sms_phone_value }}"
                                                                    onchange="regenerateQrCode()" id="phone"
                                                                    placeholder="{{ __('Mobile Number') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Message --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Message') }}</label>
                                                                <textarea name="content" id="content" maxlength="256" class="form-control" cols="30" rows="5"
                                                                    onchange="regenerateQrCode()" required>{{ json_decode($qr_code_details->settings)->sms_msg_value }}</textarea>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Email --}}
                                                    @if ($qr_code_details->type == 'email')
                                                        {{-- Email ID --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Email ID') }}</label>
                                                                <input type="text" class="form-control" maxlength="50"
                                                                    name="email"
                                                                    value="{{ json_decode($qr_code_details->settings)->email_address_value }}"
                                                                    onchange="regenerateQrCode()" id="email"
                                                                    placeholder="{{ __('Email ID') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Subject --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Subject') }}</label>
                                                                <input type="text" class="form-control" maxlength="50"
                                                                    name="subject"
                                                                    value="{{ json_decode($qr_code_details->settings)->email_subject_value }}"
                                                                    onchange="regenerateQrCode()" id="subject"
                                                                    placeholder="{{ __('Subject') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Body --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Body') }}</label>
                                                                <textarea name="content" id="content" maxlength="300" class="form-control" cols="30" rows="5"
                                                                    onchange="regenerateQrCode()" required>{{ json_decode($qr_code_details->settings)->email_body_value }}</textarea>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- WhatsApp --}}
                                                    @if ($qr_code_details->type == 'whatsapp')
                                                        {{-- WhatsApp Number --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('WhatsApp Number') }}</label>
                                                                <input type="text" class="form-control" name="phone"
                                                                    maxlength="25"
                                                                    value="{{ json_decode($qr_code_details->settings)->whatsapp_no_value }}"
                                                                    onchange="regenerateQrCode()" id="phone"
                                                                    placeholder="{{ __('WhatsApp Number') }}" required>
                                                                <small
                                                                    class="mt-2">{{ __('Include country code (For ex: 919876543210)') }}</small>
                                                            </div>
                                                        </div>

                                                        {{-- Message --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Message') }}</label>
                                                                <textarea name="content" id="content" class="form-control" maxlength="350" cols="30" rows="5"
                                                                    onchange="regenerateQrCode()" required>{{ json_decode($qr_code_details->settings)->whatsapp_msg_value }}</textarea>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Facetime --}}
                                                    @if ($qr_code_details->type == 'facetime')
                                                        {{-- Mobile number/email ID --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Mobile number/email ID') }}</label>
                                                                <input type="text" class="form-control" name="content"
                                                                    value="{{ json_decode($qr_code_details->settings)->facetime_value }}"
                                                                    onchange="regenerateQrCode()" id="content"
                                                                    placeholder="{{ __('Mobile number/email ID') }}"
                                                                    required>
                                                                <small
                                                                    class="mt-3">{{ __('Only support on iOS & MacOS Devices') }}</small>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Location --}}
                                                    @if ($qr_code_details->type == 'location')
                                                        {{-- Latitude --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Latitude') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="latitude" maxlength="50"
                                                                    value="{{ json_decode($qr_code_details->settings)->location_latitude_value }}"
                                                                    onchange="regenerateQrCode()" id="latitude"
                                                                    placeholder="{{ __('Latitude') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Longitude --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Longitude') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="longitude" maxlength="50"
                                                                    value="{{ json_decode($qr_code_details->settings)->location_longitude_value }}"
                                                                    onchange="regenerateQrCode()" id="longitude"
                                                                    placeholder="{{ __('Longitude') }}" required>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Wifi --}}
                                                    @if ($qr_code_details->type == 'wifi')
                                                        {{-- Network Name (SSID) --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Network Name (SSID)') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="wifi_ssid" maxlength="100"
                                                                    value="{{ json_decode($qr_code_details->settings)->wifi_ssid_value }}"
                                                                    onchange="regenerateQrCode()" id="wifi_ssid"
                                                                    placeholder="{{ __('Network Name (SSID)') }}"
                                                                    required>
                                                            </div>
                                                        </div>

                                                        {{-- Security --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ __('Security') }}</label>
                                                                <select class="form-select" name="wifi_encryption"
                                                                    id="wifi_encryption" onchange="regenerateQrCode()">
                                                                    <option value="nopass"
                                                                        {{ json_decode($qr_code_details->settings)->wifi_encryption_value == 'nopass' ? 'selected' : '' }}>
                                                                        {{ __('None') }}</option>
                                                                    <option value="WEP"
                                                                        {{ json_decode($qr_code_details->settings)->wifi_encryption_value == 'WEP' ? 'selected' : '' }}>
                                                                        {{ __('WEP') }}</option>
                                                                    <option value="WPA"
                                                                        {{ json_decode($qr_code_details->settings)->wifi_encryption_value == 'WPA' ? 'selected' : '' }}>
                                                                        {{ __('WPA/WPA2-Personal') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        {{-- Password --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Password') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="wifi_password" maxlength="25"
                                                                    value="{{ json_decode($qr_code_details->settings)->wifi_password_value }}"
                                                                    onchange="regenerateQrCode()" id="wifi_password"
                                                                    placeholder="{{ __('Password') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Hidden? --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ __('Hidden?') }}</label>
                                                                <select class="form-select" name="wifi_is_hidden"
                                                                    id="wifi_is_hidden" onchange="regenerateQrCode()">
                                                                    <option value="1"
                                                                        {{ json_decode($qr_code_details->settings)->wifi_is_hidden_value == '1' ? 'selected' : '' }}>
                                                                        {{ __('Yes') }}</option>
                                                                    <option value="0"
                                                                        {{ json_decode($qr_code_details->settings)->wifi_is_hidden_value == '1' ? 'selected' : '' }}>
                                                                        {{ __('No') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Event --}}
                                                    @if ($qr_code_details->type == 'event')
                                                        {{-- Title --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Title') }}</label>
                                                                <input type="text" class="form-control" name="event"
                                                                    value="{{ json_decode($qr_code_details->settings)->event_name_value }}"
                                                                    onchange="regenerateQrCode()" id="event"
                                                                    placeholder="{{ __('Title') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Message --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Message') }}</label>
                                                                <textarea name="event_note" id="event_note" class="form-control" maxlength="220" cols="30" rows="2"
                                                                    onchange="regenerateQrCode()" required>{{ json_decode($qr_code_details->settings)->event_note_value }}</textarea>
                                                            </div>
                                                        </div>

                                                        {{-- Location --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Location') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="event_location"
                                                                    value="{{ json_decode($qr_code_details->settings)->event_location_value }}"
                                                                    onchange="regenerateQrCode()" id="event_location"
                                                                    placeholder="{{ __('Location') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- From --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('From') }}</label>
                                                                <input type="datetime-local" class="form-control"
                                                                    name="event_start_datetime"
                                                                    value="{{ json_decode($qr_code_details->settings)->event_start_datetime_value }}"
                                                                    onchange="regenerateQrCode()"
                                                                    id="event_start_datetime"
                                                                    placeholder="{{ __('From') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- To --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('To') }}</label>
                                                                <input type="datetime-local" class="form-control"
                                                                    name="event_end_datetime"
                                                                    value="{{ json_decode($qr_code_details->settings)->event_end_datetime_value }}"
                                                                    onchange="regenerateQrCode()" id="event_end_datetime"
                                                                    placeholder="{{ __('To') }}" required>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Crypto --}}
                                                    @if ($qr_code_details->type == 'crypto')
                                                        {{-- Cryptocurrency --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Cryptocurrency') }}</label>
                                                                <select class="form-select" name="crypto_coin"
                                                                    id="crypto_coin" onchange="regenerateQrCode()"
                                                                    required>
                                                                    <option value="bitcoin"
                                                                        {{ json_decode($qr_code_details->settings)->crypto_coin_value == 'bitcoin' ? 'selected' : '' }}>
                                                                        {{ __('Bitcoin') }}</option>
                                                                    <option value="bitcoincash"
                                                                        {{ json_decode($qr_code_details->settings)->crypto_coin_value == 'bitcoincash' ? 'selected' : '' }}>
                                                                        {{ __('Bitcoin cash address') }} </option>
                                                                    <option value="ethereum"
                                                                        {{ json_decode($qr_code_details->settings)->crypto_coin_value == 'ethereum' ? 'selected' : '' }}>
                                                                        {{ __('Ether') }}</option>
                                                                    <option value="litecoin"
                                                                        {{ json_decode($qr_code_details->settings)->crypto_coin_value == 'litecoin' ? 'selected' : '' }}>
                                                                        {{ __('Litecoin') }}</option>
                                                                    <option value="dash"
                                                                        {{ json_decode($qr_code_details->settings)->crypto_coin_value == 'dash' ? 'selected' : '' }}>
                                                                        {{ __('Dash') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        {{-- Receiver --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Receiver') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="crypto_address" maxlength="250"
                                                                    value="{{ json_decode($qr_code_details->settings)->crypto_address_value }}"
                                                                    onchange="regenerateQrCode()" id="crypto_address"
                                                                    placeholder="{{ __('Receiver') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Amount --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Amount') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="crypto_amount" maxlength="15"
                                                                    value="{{ json_decode($qr_code_details->settings)->crypto_amount_value }}"
                                                                    onchange="regenerateQrCode()" id="crypto_amount"
                                                                    placeholder="{{ __('Amount') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Message --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Message') }}</label>
                                                                <textarea name="crypto_msg" id="crypto_msg" class="form-control" cols="30" rows="2" maxlength="150"
                                                                    onchange="regenerateQrCode()" required>{{ json_decode($qr_code_details->settings)->crypto_msg_value }}</textarea>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- vCard --}}
                                                    @if ($qr_code_details->type == 'vcard')
                                                        {{-- First name --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('First name') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="vcard_first_name" maxlength="40"
                                                                    value="{{ json_decode($qr_code_details->settings)->vcard_first_name_value }}"
                                                                    onchange="regenerateQrCode()" id="vcard_first_name"
                                                                    placeholder="{{ __('First name') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Last name --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Last name') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="vcard_last_name" maxlength="40"
                                                                    value="{{ json_decode($qr_code_details->settings)->vcard_last_name_value }}"
                                                                    onchange="regenerateQrCode()" id="vcard_last_name"
                                                                    placeholder="{{ __('Last name') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Mobile number --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Phone number') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="vcard_phone" maxlength="20"
                                                                    value="{{ json_decode($qr_code_details->settings)->vcard_phone_value }}"
                                                                    onchange="regenerateQrCode()" id="vcard_phone"
                                                                    placeholder="{{ __('Mobile number') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Email Address --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Email Address') }}</label>
                                                                <input type="email" class="form-control"
                                                                    name="vcard_email" maxlength="50"
                                                                    value="{{ json_decode($qr_code_details->settings)->vcard_email_value }}"
                                                                    onchange="regenerateQrCode()" id="vcard_email"
                                                                    placeholder="{{ __('Email Address') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Website Link --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Website Link') }}</label>
                                                                <input type="url" class="form-control"
                                                                    name="vcard_url" maxlength="50"
                                                                    value="{{ json_decode($qr_code_details->settings)->vcard_url_value }}"
                                                                    onchange="regenerateQrCode()" id="vcard_url"
                                                                    placeholder="{{ __('Website Link') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Company Name --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Company Name') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="vcard_company" maxlength="50"
                                                                    value="{{ json_decode($qr_code_details->settings)->vcard_company_value }}"
                                                                    onchange="regenerateQrCode()" id="vcard_company"
                                                                    placeholder="{{ __('Company Name') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Job position --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Job position') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="vcard_job_title" maxlength="50"
                                                                    value="{{ json_decode($qr_code_details->settings)->vcard_job_title_value }}"
                                                                    onchange="regenerateQrCode()" id="vcard_job_title"
                                                                    placeholder="{{ __('Job position') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- DOB --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('DOB') }}</label>
                                                                <input type="date" class="form-control"
                                                                    name="vcard_birthday"
                                                                    value="{{ json_decode($qr_code_details->settings)->vcard_birthday_value }}"
                                                                    onchange="regenerateQrCode()" id="vcard_birthday"
                                                                    placeholder="{{ __('DOB') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Street --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Street') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="vcard_street" maxlength="100"
                                                                    value="{{ json_decode($qr_code_details->settings)->vcard_street_value }}"
                                                                    onchange="regenerateQrCode()" id="vcard_street"
                                                                    placeholder="{{ __('Street') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- City --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('City') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="vcard_city" maxlength="50"
                                                                    value="{{ json_decode($qr_code_details->settings)->vcard_city_value }}"
                                                                    onchange="regenerateQrCode()" id="vcard_city"
                                                                    placeholder="{{ __('City') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Postal Code --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Postal Code') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="vcard_postal" maxlength="25"
                                                                    value="{{ json_decode($qr_code_details->settings)->vcard_postal_value }}"
                                                                    onchange="regenerateQrCode()" id="vcard_postal"
                                                                    placeholder="{{ __('Postal Code') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Region --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Region') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="vcard_region" maxlength="50"
                                                                    value="{{ json_decode($qr_code_details->settings)->vcard_region_value }}"
                                                                    onchange="regenerateQrCode()" id="vcard_region"
                                                                    placeholder="{{ __('Region') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- Country --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Country') }}</label>
                                                                <input type="text" class="form-control"
                                                                    name="vcard_country" maxlength="50"
                                                                    value="{{ json_decode($qr_code_details->settings)->vcard_country_value }}"
                                                                    onchange="regenerateQrCode()" id="vcard_country"
                                                                    placeholder="{{ __('Country') }}" required>
                                                            </div>
                                                        </div>

                                                        {{-- More Info --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('More Info') }}</label>
                                                                <textarea name="vcard_note" id="vcard_note" class="form-control" cols="30" rows="2" maxlength="100"
                                                                    onchange="regenerateQrCode()" required>{{ json_decode($qr_code_details->settings)->vcard_note_value }}</textarea>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Paypal --}}
                                                    @if ($qr_code_details->type == 'paypal')
                                                        {{-- Paypal --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Paypal.Me Link') }}</label>
                                                                <div class="input-group input-group-flat">
                                                                    <span
                                                                        class="input-group-text">{{ __('https://paypal.me/') }}</span>
                                                                    <input type="text" class="form-control ps-0"
                                                                        name="paypal_link"
                                                                        value="{{ json_decode($qr_code_details->settings)->paypal_link_value }}"
                                                                        id="paypal_link" onchange="regenerateQrCode()"
                                                                        placeholder="{{ __('yourpaypalmelink') }}"
                                                                        autocomplete="off" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- UPI --}}
                                                    @if ($qr_code_details->type == 'upi')
                                                        {{-- UPI ID / VPA --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('UPI ID / VPA') }}</label>
                                                                <input type="text" class="form-control"
                                                                    onchange="regenerateQrCode()" maxlength="150"
                                                                    placeholder="{{ __('Eg: abi@okicici') }}"
                                                                    name="upi_id" id="upi_id"
                                                                    value="{{ json_decode($qr_code_details->settings)->upi_id_value }}"
                                                                    required autocomplete="off">
                                                            </div>
                                                        </div>

                                                        {{-- Payee Name --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Payee Name') }}</label>
                                                                <input type="text" class="form-control"
                                                                    onchange="regenerateQrCode()" maxlength="50"
                                                                    placeholder="{{ __('Eg: Abi') }}"
                                                                    name="upi_payee_name"
                                                                    value="{{ json_decode($qr_code_details->settings)->upi_payee_name_value }}"
                                                                    id="upi_payee_name" required autocomplete="off">
                                                            </div>
                                                        </div>

                                                        {{-- Currency --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label required">{{ __('Currency') }}</label>
                                                                <select class="form-select" name="upi_currency"
                                                                    id="upi_currency" onchange="regenerateQrCode()"
                                                                    required>
                                                                    @include('user.pages.qr-codes.includes.currency')
                                                                </select>
                                                            </div>
                                                        </div>

                                                        {{-- Amount --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ __('Amount') }}</label>
                                                                <input type="number" min="0" step="0.001"
                                                                    max="100000" placeholder="{{ __('Eg: 500') }}"
                                                                    class="form-control" onchange="regenerateQrCode()"
                                                                    placeholder="{{ __('Amount') }}" name="upi_amount"
                                                                    value="{{ json_decode($qr_code_details->settings)->upi_amount_value }}"
                                                                    id="upi_amount" autocomplete="off">
                                                            </div>
                                                        </div>

                                                        {{-- Transaction Remark --}}
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="form-label">{{ __('Transaction Remark') }}</label>
                                                                <textarea name="upi_msg" id="upi_msg" class="form-control" maxlength="150" onchange="regenerateQrCode()"
                                                                    placeholder="{{ __('Transaction Remark') }}" cols="30" rows="2">{{ json_decode($qr_code_details->settings)->upi_msg_value }}</textarea>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Advance Settings --}}
                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="card-title">{{ __('Advanced Settings') }}
                                                                </div>

                                                                {{-- QR code settings --}}
                                                                <div class="pt-1">
                                                                    {{-- QR Code Style --}}
                                                                    <div class="col-md-12 col-xl-12">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('QR Code Style') }}</label>
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="qrcode_style"
                                                                                        id="qrcode_style" value="square"
                                                                                        onclick="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->qrcode_style == 'square' ? 'checked' : '' }}>
                                                                                    <span
                                                                                        class="form-selectgroup-label"><!-- Download SVG icon from http://tabler-icons.io/i/home -->

                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                            class="icon icon-tabler me-1 icon-tabler-square"
                                                                                            width="24" height="24"
                                                                                            viewBox="0 0 24 24"
                                                                                            stroke-width="2"
                                                                                            stroke="currentColor"
                                                                                            fill="none"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round">
                                                                                            <desc>Download more icon
                                                                                                variants from
                                                                                                https://tabler-icons.io/i/square
                                                                                            </desc>
                                                                                            <path stroke="none"
                                                                                                d="M0 0h24v24H0z"
                                                                                                fill="none"></path>
                                                                                            <rect x="4" y="4"
                                                                                                width="16"
                                                                                                height="16"
                                                                                                rx="2"></rect>
                                                                                        </svg>

                                                                                        {{ __('Square') }}</span>
                                                                                </label>

                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="qrcode_style"
                                                                                        id="qrcode_style" value="dot"
                                                                                        onclick="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->qrcode_style == 'dot' ? 'checked' : '' }}>
                                                                                    <span
                                                                                        class="form-selectgroup-label"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                            class="icon me-1 icon-tabler icon-tabler-grain"
                                                                                            width="24" height="24"
                                                                                            viewBox="0 0 24 24"
                                                                                            stroke-width="2"
                                                                                            stroke="currentColor"
                                                                                            fill="none"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round">
                                                                                            <desc>Download more icon
                                                                                                variants from
                                                                                                https://tabler-icons.io/i/grain
                                                                                            </desc>
                                                                                            <path stroke="none"
                                                                                                d="M0 0h24v24H0z"
                                                                                                fill="none"></path>
                                                                                            <circle cx="4.5"
                                                                                                cy="9.5" r="1">
                                                                                            </circle>
                                                                                            <circle cx="9.5"
                                                                                                cy="4.5" r="1">
                                                                                            </circle>
                                                                                            <circle cx="9.5"
                                                                                                cy="14.5" r="1">
                                                                                            </circle>
                                                                                            <circle cx="4.5"
                                                                                                cy="19.5" r="1">
                                                                                            </circle>
                                                                                            <circle cx="14.5"
                                                                                                cy="9.5" r="1">
                                                                                            </circle>
                                                                                            <circle cx="19.5"
                                                                                                cy="4.5" r="1">
                                                                                            </circle>
                                                                                            <circle cx="14.5"
                                                                                                cy="19.5" r="1">
                                                                                            </circle>
                                                                                            <circle cx="19.5"
                                                                                                cy="14.5" r="1">
                                                                                            </circle>
                                                                                        </svg>
                                                                                        {{ __('Dot') }}</span>
                                                                                </label>

                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="qrcode_style"
                                                                                        id="qrcode_style" value="round"
                                                                                        onclick="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->qrcode_style == 'round' ? 'checked' : '' }}>
                                                                                    <span
                                                                                        class="form-selectgroup-label"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                            class="icon icon-tabler me-1 icon-tabler-border-radius"
                                                                                            width="24" height="24"
                                                                                            viewBox="0 0 24 24"
                                                                                            stroke-width="2"
                                                                                            stroke="currentColor"
                                                                                            fill="none"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round">
                                                                                            <desc>Download more icon
                                                                                                variants from
                                                                                                https://tabler-icons.io/i/border-radius
                                                                                            </desc>
                                                                                            <path stroke="none"
                                                                                                d="M0 0h24v24H0z"
                                                                                                fill="none"></path>
                                                                                            <path
                                                                                                d="M4 12v-4a4 4 0 0 1 4 -4h4">
                                                                                            </path>
                                                                                            <line x1="16"
                                                                                                y1="4"
                                                                                                x2="16"
                                                                                                y2="4.01"></line>
                                                                                            <line x1="20"
                                                                                                y1="4"
                                                                                                x2="20"
                                                                                                y2="4.01"></line>
                                                                                            <line x1="20"
                                                                                                y1="8"
                                                                                                x2="20"
                                                                                                y2="8.01"></line>
                                                                                            <line x1="20"
                                                                                                y1="12"
                                                                                                x2="20"
                                                                                                y2="12.01"></line>
                                                                                            <line x1="4"
                                                                                                y1="16"
                                                                                                x2="4"
                                                                                                y2="16.01"></line>
                                                                                            <line x1="20"
                                                                                                y1="16"
                                                                                                x2="20"
                                                                                                y2="16.01"></line>
                                                                                            <line x1="4"
                                                                                                y1="20"
                                                                                                x2="4"
                                                                                                y2="20.01"></line>
                                                                                            <line x1="8"
                                                                                                y1="20"
                                                                                                x2="8"
                                                                                                y2="20.01"></line>
                                                                                            <line x1="12"
                                                                                                y1="20"
                                                                                                x2="12"
                                                                                                y2="20.01"></line>
                                                                                            <line x1="16"
                                                                                                y1="20"
                                                                                                x2="16"
                                                                                                y2="20.01"></line>
                                                                                            <line x1="20"
                                                                                                y1="20"
                                                                                                x2="20"
                                                                                                y2="20.01"></line>
                                                                                        </svg>
                                                                                        {{ __('Round') }}</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Color Style --}}
                                                                    <div class="col-md-12 col-xl-12">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('Color Style') }}</label>
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="color_style" value="color"
                                                                                        onclick="checkColor(this); regenerateQrCode();"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->color_style == 'color' ? 'checked' : '' }}>
                                                                                    <span
                                                                                        class="form-selectgroup-label"><!-- Download SVG icon from http://tabler-icons.io/i/home -->

                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                            class="icon icon-tabler me-1 icon-tabler-brush"
                                                                                            width="24" height="24"
                                                                                            viewBox="0 0 24 24"
                                                                                            stroke-width="2"
                                                                                            stroke="currentColor"
                                                                                            fill="none"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round">
                                                                                            <desc>Download more icon
                                                                                                variants from
                                                                                                https://tabler-icons.io/i/brush
                                                                                            </desc>
                                                                                            <path stroke="none"
                                                                                                d="M0 0h24v24H0z"
                                                                                                fill="none"></path>
                                                                                            <path
                                                                                                d="M3 21v-4a4 4 0 1 1 4 4h-4">
                                                                                            </path>
                                                                                            <path
                                                                                                d="M21 3a16 16 0 0 0 -12.8 10.2">
                                                                                            </path>
                                                                                            <path
                                                                                                d="M21 3a16 16 0 0 1 -10.2 12.8">
                                                                                            </path>
                                                                                            <path
                                                                                                d="M10.6 9a9 9 0 0 1 4.4 4.4">
                                                                                            </path>
                                                                                        </svg>

                                                                                        {{ __('Single Color') }}</span>
                                                                                </label>

                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="color_style"
                                                                                        value="gradient"
                                                                                        onclick="checkColor(this); regenerateQrCode();"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->color_style == 'gradient' ? 'checked' : '' }}>
                                                                                    <span
                                                                                        class="form-selectgroup-label"><!-- Download SVG icon from http://tabler-icons.io/i/home -->

                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                            class="icon icon-tabler me-1 icon-tabler-palette"
                                                                                            width="24" height="24"
                                                                                            viewBox="0 0 24 24"
                                                                                            stroke-width="2"
                                                                                            stroke="currentColor"
                                                                                            fill="none"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round">
                                                                                            <desc>Download more icon
                                                                                                variants from
                                                                                                https://tabler-icons.io/i/palette
                                                                                            </desc>
                                                                                            <path stroke="none"
                                                                                                d="M0 0h24v24H0z"
                                                                                                fill="none"></path>
                                                                                            <path
                                                                                                d="M12 21a9 9 0 1 1 0 -18a9 8 0 0 1 9 8a4.5 4 0 0 1 -4.5 4h-2.5a2 2 0 0 0 -1 3.75a1.3 1.3 0 0 1 -1 2.25">
                                                                                            </path>
                                                                                            <circle cx="7.5"
                                                                                                cy="10.5" r=".5"
                                                                                                fill="currentColor">
                                                                                            </circle>
                                                                                            <circle cx="12"
                                                                                                cy="7.5" r=".5"
                                                                                                fill="currentColor">
                                                                                            </circle>
                                                                                            <circle cx="16.5"
                                                                                                cy="10.5" r=".5"
                                                                                                fill="currentColor">
                                                                                            </circle>
                                                                                        </svg>
                                                                                        {{ __('Gradient Color') }}</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Color --}}
                                                                    <div class="col-md-12 col-xl-12 color-form-group">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('Color') }}</label>
                                                                            <input type="color" class="form-control"
                                                                                name="color" id="color"
                                                                                value="{{ json_decode($qr_code_details->settings)->color }}"
                                                                                onchange="regenerateQrCode()"
                                                                                placeholder="{{ __('Foreground color') }}">
                                                                        </div>
                                                                    </div>

                                                                    {{-- Gradient type --}}
                                                                    <div class="col-md-12 col-xl-12 gradient-form-group">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('Gradient type') }}</label>
                                                                            {{-- Vertical --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="foreground_gradient_type"
                                                                                        id="foreground_gradient_type"
                                                                                        value="vertical"
                                                                                        onclick="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->foreground_gradient_type == 'vertical' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Vertical') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            {{-- Vertical --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="foreground_gradient_type"
                                                                                        id="foreground_gradient_type"
                                                                                        value="horizontal"
                                                                                        onclick="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->foreground_gradient_type == 'horizontal' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Horizontal') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            {{-- Diagonal --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="foreground_gradient_type"
                                                                                        id="foreground_gradient_type"
                                                                                        value="diagonal"
                                                                                        onclick="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->foreground_gradient_type == 'diagonal' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Diagonal') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            {{-- Inverse diagonal --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="foreground_gradient_type"
                                                                                        id="foreground_gradient_type"
                                                                                        value="inverse_diagonal"
                                                                                        onclick="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->foreground_gradient_type == 'inverse_diagonal' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Inverse diagonal') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            {{-- Radial --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="foreground_gradient_type"
                                                                                        id="foreground_gradient_type"
                                                                                        value="radial"
                                                                                        onclick="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->foreground_gradient_type == 'radial' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Radial') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Primary color --}}
                                                                    <div class="col-md-12 col-xl-12 gradient-form-group">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('Primary color') }}</label>
                                                                            <input type="color" class="form-control"
                                                                                name="primary_color" id="primary_color"
                                                                                value="{{ json_decode($qr_code_details->settings)->primary_color }}"
                                                                                onchange="regenerateQrCode()"
                                                                                placeholder="{{ __('Primary color') }}">
                                                                        </div>
                                                                    </div>

                                                                    {{-- Secondary color --}}
                                                                    <div class="col-md-12 col-xl-12 gradient-form-group">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('Secondary color') }}</label>
                                                                            <input type="color" class="form-control"
                                                                                name="secondary_color"
                                                                                id="secondary_color"
                                                                                value="{{ json_decode($qr_code_details->settings)->secondary_color }}"
                                                                                onchange="regenerateQrCode()"
                                                                                placeholder="{{ __('Secondary color') }}">
                                                                        </div>
                                                                    </div>

                                                                    {{-- Need eye color? --}}
                                                                    <div class="col-md-12 col-xl-12">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('Need eye color?') }}</label>
                                                                            {{-- Yes --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="need_eye_color"
                                                                                        id="need_eye_color" value="1"
                                                                                        onchange="checkEyeColor(this.value); regenerateQrCode();"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->need_eye_color == '1' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Yes') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            {{-- No --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="need_eye_color"
                                                                                        id="need_eye_color" value="0"
                                                                                        onchange="checkEyeColor(this.value); regenerateQrCode();"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->need_eye_color == '0' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('No') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Change the eye colors --}}
                                                                    <div class="col-md-12 col-xl-12 eyes_control">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('Change the eye colors') }}</label>
                                                                            <input type="color" class="form-control"
                                                                                name="eye_color" id="eye_color"
                                                                                value="{{ json_decode($qr_code_details->settings)->eye_color }}"
                                                                                onchange="regenerateQrCode()"
                                                                                placeholder="{{ __('Change the eye colors') }}">
                                                                        </div>
                                                                    </div>

                                                                    {{-- EyeColor Position --}}
                                                                    <div class="col-md-12 col-xl-12 eyes_control">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('Eye Color Position') }}</label>
                                                                            {{-- Left --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="eyeColor_position"
                                                                                        id="eyeColor_position"
                                                                                        value="0"
                                                                                        onchange="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->eyeColor_position == '0' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                            class="icon icon-tabler me-1 icon-tabler-float-left"
                                                                                            width="24" height="24"
                                                                                            viewBox="0 0 24 24"
                                                                                            stroke-width="2"
                                                                                            stroke="currentColor"
                                                                                            fill="none"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round">
                                                                                            <desc>Download more icon
                                                                                                variants from
                                                                                                https://tabler-icons.io/i/float-left
                                                                                            </desc>
                                                                                            <path stroke="none"
                                                                                                d="M0 0h24v24H0z"
                                                                                                fill="none"></path>
                                                                                            <rect width="6"
                                                                                                height="6" x="4" y="5"
                                                                                                rx="1"></rect>
                                                                                            <line x1="14"
                                                                                                y1="7"
                                                                                                x2="20"
                                                                                                y2="7"></line>
                                                                                            <line x1="14"
                                                                                                y1="11"
                                                                                                x2="20"
                                                                                                y2="11"></line>
                                                                                            <line x1="4"
                                                                                                y1="15"
                                                                                                x2="20"
                                                                                                y2="15"></line>
                                                                                            <line x1="4"
                                                                                                y1="19"
                                                                                                x2="20"
                                                                                                y2="19"></line>
                                                                                        </svg>
                                                                                        {{ __('Left') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            {{-- Right --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="eyeColor_position"
                                                                                        id="eyeColor_position"
                                                                                        value="1"
                                                                                        onchange="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->eyeColor_position == '1' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                            class="icon icon-tabler me-1 icon-tabler-float-right"
                                                                                            width="24" height="24"
                                                                                            viewBox="0 0 24 24"
                                                                                            stroke-width="2"
                                                                                            stroke="currentColor"
                                                                                            fill="none"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round">
                                                                                            <desc>Download more icon
                                                                                                variants from
                                                                                                https://tabler-icons.io/i/float-right
                                                                                            </desc>
                                                                                            <path stroke="none"
                                                                                                d="M0 0h24v24H0z"
                                                                                                fill="none"></path>
                                                                                            <rect width="6"
                                                                                                height="6" x="14" y="5"
                                                                                                rx="1"></rect>
                                                                                            <line x1="4"
                                                                                                y1="7"
                                                                                                x2="10"
                                                                                                y2="7"></line>
                                                                                            <line x1="4"
                                                                                                y1="11"
                                                                                                x2="10"
                                                                                                y2="11"></line>
                                                                                            <line x1="4"
                                                                                                y1="15"
                                                                                                x2="20"
                                                                                                y2="15"></line>
                                                                                            <line x1="4"
                                                                                                y1="19"
                                                                                                x2="20"
                                                                                                y2="19"></line>
                                                                                        </svg>
                                                                                        {{ __('Right') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            {{-- Bottom --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="eyeColor_position"
                                                                                        id="eyeColor_position"
                                                                                        value="2"
                                                                                        onchange="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->eyeColor_position == '2' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                            class="icon icon-tabler me-1 icon-tabler-float-center"
                                                                                            width="24"
                                                                                            height="24"
                                                                                            viewBox="0 0 24 24"
                                                                                            stroke-width="2"
                                                                                            stroke="currentColor"
                                                                                            fill="none"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round">
                                                                                            <desc>Download more icon
                                                                                                variants from
                                                                                                https://tabler-icons.io/i/float-center
                                                                                            </desc>
                                                                                            <path stroke="none"
                                                                                                d="M0 0h24v24H0z"
                                                                                                fill="none"></path>
                                                                                            <rect width="6"
                                                                                                height="6" x="9" y="5"
                                                                                                rx="1"></rect>
                                                                                            <line x1="4"
                                                                                                y1="7"
                                                                                                x2="5"
                                                                                                y2="7"></line>
                                                                                            <line x1="4"
                                                                                                y1="11"
                                                                                                x2="5"
                                                                                                y2="11"></line>
                                                                                            <line x1="19"
                                                                                                y1="7"
                                                                                                x2="20"
                                                                                                y2="7"></line>
                                                                                            <line x1="19"
                                                                                                y1="11"
                                                                                                x2="20"
                                                                                                y2="11"></line>
                                                                                            <line x1="4"
                                                                                                y1="15"
                                                                                                x2="20"
                                                                                                y2="15"></line>
                                                                                            <line x1="4"
                                                                                                y1="19"
                                                                                                x2="20"
                                                                                                y2="19"></line>
                                                                                        </svg>
                                                                                        {{ __('Bottom') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Eye Color Style --}}
                                                                    <div class="col-md-12 col-xl-12 eyes_control">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('Eye Color Style') }}</label>
                                                                            {{-- Square --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="eye_color_style"
                                                                                        id="eye_color_style"
                                                                                        value="square"
                                                                                        onchange="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->eye_color_style == 'square' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                            class="icon icon-tabler me-1 icon-tabler-square"
                                                                                            width="24"
                                                                                            height="24"
                                                                                            viewBox="0 0 24 24"
                                                                                            stroke-width="2"
                                                                                            stroke="currentColor"
                                                                                            fill="none"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round">
                                                                                            <desc>Download more icon
                                                                                                variants from
                                                                                                https://tabler-icons.io/i/square
                                                                                            </desc>
                                                                                            <path stroke="none"
                                                                                                d="M0 0h24v24H0z"
                                                                                                fill="none"></path>
                                                                                            <rect x="4" y="4"
                                                                                                width="16"
                                                                                                height="16"
                                                                                                rx="2"></rect>
                                                                                        </svg>
                                                                                        {{ __('Square') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            {{-- Circle --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="eye_color_style"
                                                                                        id="eye_color_style"
                                                                                        value="circle"
                                                                                        onchange="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->eye_color_style == 'circle' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                            class="icon icon-tabler me-1 icon-tabler-circle"
                                                                                            width="24"
                                                                                            height="24"
                                                                                            viewBox="0 0 24 24"
                                                                                            stroke-width="2"
                                                                                            stroke="currentColor"
                                                                                            fill="none"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round">
                                                                                            <desc>Download more icon
                                                                                                variants from
                                                                                                https://tabler-icons.io/i/circle
                                                                                            </desc>
                                                                                            <path stroke="none"
                                                                                                d="M0 0h24v24H0z"
                                                                                                fill="none"></path>
                                                                                            <circle cx="12"
                                                                                                cy="12" r="9">
                                                                                            </circle>
                                                                                        </svg>
                                                                                        {{ __('Circle') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- Merge Logo --}}
                                                                <div class="pt-1">
                                                                    {{-- Merge Logo --}}
                                                                    <div class="col-md-12 col-xl-12">
                                                                        <div class="mb-3">
                                                                            <div class="form-label">
                                                                                {{ __('Upload Logo') }}
                                                                            </div>
                                                                            <input type="file" class="form-control"
                                                                                name="upload_logo" id="upload_logo"
                                                                                accept=".jpg, .jpeg, .png, .gif"
                                                                                onchange="regenerateQrCode()">
                                                                        </div>
                                                                    </div>

                                                                    {{-- Upload Logo size --}}
                                                                    <div class="col-md-12 col-xl-12">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('Upload Logo Size') }}</label>
                                                                            {{-- Small --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="upload_logo_size"
                                                                                        id="upload_logo_size"
                                                                                        value="0.1"
                                                                                        onclick="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ $qr_code_details->qr_code_logo_size == '0.10' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Small') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                            {{-- Medium --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="upload_logo_size"
                                                                                        id="upload_logo_size"
                                                                                        value="0.2"
                                                                                        onclick="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ $qr_code_details->qr_code_logo_size == '0.20' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Medium') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                            {{-- Large --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="upload_logo_size"
                                                                                        id="upload_logo_size"
                                                                                        value="0.5"
                                                                                        onclick="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ $qr_code_details->qr_code_logo_size == '0.50' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Large') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- More settings --}}
                                                                <div class="pt-1">
                                                                    {{-- Download Quality --}}
                                                                    <div class="col-md-12 col-xl-12">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('Download Quality') }}</label>
                                                                            {{-- Basic --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio" name="size"
                                                                                        id="size" value="200"
                                                                                        onchange="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->size == '200' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Basic') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            {{-- Normal --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio" name="size"
                                                                                        id="size" value="500"
                                                                                        onchange="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->size == '500' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Normal') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            {{-- Fine --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio" name="size"
                                                                                        id="size" value="1000"
                                                                                        onchange="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->size == '1000' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Fine') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            {{-- High --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio" name="size"
                                                                                        id="size" value="1500"
                                                                                        onchange="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->size == '1500' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('High') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            {{-- Very High --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio" name="size"
                                                                                        id="size" value="2000"
                                                                                        onchange="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->size == '2000' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Very High') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Level of error correction --}}
                                                                    <div class="col-md-12 col-xl-12">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                class="form-label">{{ __('Level of error correction') }}</label>
                                                                            {{-- Low --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="qrcode_ecc"
                                                                                        id="qrcode_ecc" value="L"
                                                                                        onchange="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->qrcode_ecc == 'L' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Low') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            {{-- Medium --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="qrcode_ecc"
                                                                                        id="qrcode_ecc" value="M"
                                                                                        onchange="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->qrcode_ecc == 'M' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Medium') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            {{-- Quartile --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="qrcode_ecc"
                                                                                        id="qrcode_ecc" value="Q"
                                                                                        onchange="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->qrcode_ecc == 'Q' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('Quartile') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>

                                                                            {{-- High --}}
                                                                            <div class="form-selectgroup">
                                                                                <label class="form-selectgroup-item">
                                                                                    <input type="radio"
                                                                                        name="qrcode_ecc"
                                                                                        id="qrcode_ecc" value="H"
                                                                                        onchange="regenerateQrCode()"
                                                                                        class="form-selectgroup-input"
                                                                                        {{ json_decode($qr_code_details->settings)->qrcode_ecc == 'H' ? 'checked' : '' }}>
                                                                                    <span class="form-selectgroup-label">
                                                                                        {{ __('High') }}
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Generate QR Code --}}
                                                    <span
                                                        class="text-muted mt-3">{{ __('Note: Double-check your QR Code once before using it.') }}</span>
                                                    <div class="text-left mt-3">
                                                        <div class="text-end">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-md ms-auto">
                                                                {{ __('Generate and Save QR') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    {{-- If QR Code is empty --}}
                    <div class="page-body">
                        <div class="container-xl d-flex flex-column justify-content-center">
                            <div class="empty">
                                <div class="empty-img"><img
                                        src="{{ asset('images/undraw_printing_invoices_5r4r.svg') }}" height="128"
                                        alt="">
                                </div>
                                <p class="empty-title">{{ __('No results found') }}</p>
                                <p class="empty-subtitle text-muted">
                                    {{ __('Try adjusting your search or filter to find what you`re looking for.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Footer --}}
        @include('user.includes.footer')
    </div>

    {{-- Check QR code details --}}
    @if ($qr_code_details)
        {{-- Custom JS --}}
        @section('custom-js')
            <script>
                // Check current color type
                currentColor(`{{ json_decode($qr_code_details->settings)->color_style }}`);
                // Check current eye color
                checkEyeColor(`{{ json_decode($qr_code_details->settings)->need_eye_color }}`);

                // Hide loader
                $("#loader").hide();
                $("#regenerate_qr").show();

                // Default Download Image
                $("#download_qr").attr("href",
                    "data:image/png;base64, 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 "
                );

                // Regenerate QR Code
                function regenerateQrCode() {
                    "use strict";
                    var qrcode_type = "{{ $qr_code_details->type }}";
                    var phone = $("#phone").val();
                    var email = $("#email").val();
                    var subject = $("#subject").val();
                    var content = $("#content").val();
                    var enable_analytics = $("#enable_analytics").prop("checked");
                    var latitude = $("#latitude").val();
                    var longitude = $("#longitude").val();
                    var wifi_ssid = $("#wifi_ssid").val();
                    var wifi_encryption = $("#wifi_encryption").val();
                    var wifi_password = $("#wifi_password").val();
                    var wifi_is_hidden = $("#wifi_is_hidden").val();
                    var event = $("#event").val();
                    var event_location = $("#event_location").val();
                    var event_note = $("#event_note").val();
                    var event_start_datetime = $("#event_start_datetime").val();
                    var event_end_datetime = $("#event_end_datetime").val();
                    var crypto_coin = $("#crypto_coin").val();
                    var crypto_address = $("#crypto_address").val();
                    var crypto_amount = $("#crypto_amount").val();
                    var crypto_msg = $("#crypto_msg").val();

                    var vcard_first_name = $("#vcard_first_name").val();
                    var vcard_last_name = $("#vcard_last_name").val();
                    var vcard_phone = $("#vcard_phone").val();
                    var vcard_email = $("#vcard_email").val();
                    var vcard_url = $("#vcard_url").val();
                    var vcard_company = $("#vcard_company").val();
                    var vcard_job_title = $("#vcard_job_title").val();
                    var vcard_birthday = $("#vcard_birthday").val();
                    var vcard_street = $("#vcard_street").val();
                    var vcard_city = $("#vcard_city").val();
                    var vcard_postal = $("#vcard_postal").val();
                    var vcard_region = $("#vcard_region").val();
                    var vcard_country = $("#vcard_country").val();
                    var vcard_note = $("#vcard_note").val();
                    var paypal_link = $("#paypal_link").val();
                    var upi_id = $("#upi_id").val();
                    var upi_payee_name = $("#upi_payee_name").val();
                    var upi_currency = $("#upi_currency").val();
                    var upi_amount = $("#upi_amount").val();
                    var upi_msg = $("#upi_msg").val();
                    var qrcode_style = $('input[name="qrcode_style"]:checked').val();
                    var color_style = $('input[name="color_style"]:checked').val();
                    var color = $("#color").val();
                    var foreground_gradient_type = $('input[name="foreground_gradient_type"]:checked').val();
                    var primary_color = $("#primary_color").val();
                    var secondary_color = $("#secondary_color").val();
                    var background_color = "#ffffff";
                    var background_color_transparency = 0;
                    var need_eye_color = $('input[name="need_eye_color"]:checked').val();
                    var eye_color = $("#eye_color").val();
                    var eyeColor_position = $('input[name="eyeColor_position"]:checked').val();
                    var eye_color_style = $('input[name="eye_color_style"]:checked').val();
                    var upload_logo = $("#upload_logo").prop('files')[0];
                    var upload_logo_size = $('input[name="upload_logo_size"]:checked').val();
                    var size = $('input[name="size"]:checked').val();
                    var qrcode_ecc = $('input[name="qrcode_ecc"]:checked').val();

                    // Form Data
                    var formData = new FormData();

                    formData.append('qrcode_type', qrcode_type);
                    formData.append('email', email);
                    formData.append('subject', subject);
                    formData.append('content', content);
                    formData.append('phone', phone);
                    formData.append('enable_analytics', enable_analytics);
                    formData.append('latitude', latitude);
                    formData.append('longitude', longitude);
                    formData.append('wifi_ssid', wifi_ssid);
                    formData.append('wifi_encryption', wifi_encryption);
                    formData.append('wifi_password', wifi_password);
                    formData.append('wifi_is_hidden', wifi_is_hidden);
                    formData.append('event', event);
                    formData.append('event_location', event_location);
                    formData.append('event_note', event_note);
                    formData.append('event_start_datetime', event_start_datetime);
                    formData.append('event_end_datetime', event_end_datetime);
                    formData.append('crypto_coin', crypto_coin);
                    formData.append('crypto_address', crypto_address);
                    formData.append('crypto_amount', crypto_amount);
                    formData.append('crypto_msg', crypto_msg);
                    formData.append('vcard_first_name', vcard_first_name);
                    formData.append('vcard_last_name', vcard_last_name);
                    formData.append('vcard_phone', vcard_phone);
                    formData.append('vcard_email', vcard_email);
                    formData.append('vcard_url', vcard_url);
                    formData.append('vcard_company', vcard_company);
                    formData.append('vcard_job_title', vcard_job_title);
                    formData.append('vcard_birthday', vcard_birthday);
                    formData.append('vcard_street', vcard_street);
                    formData.append('vcard_city', vcard_city);
                    formData.append('vcard_postal', vcard_postal);
                    formData.append('vcard_region', vcard_region);
                    formData.append('vcard_country', vcard_country);
                    formData.append('vcard_note', vcard_note);
                    formData.append('paypal_link', paypal_link);
                    formData.append('upi_id', upi_id);
                    formData.append('upi_payee_name', upi_payee_name);
                    formData.append('upi_currency', upi_currency);
                    formData.append('upi_amount', upi_amount);
                    formData.append('upi_msg', upi_msg);
                    formData.append('qrcode_style', qrcode_style);
                    formData.append('color_style', color_style);
                    formData.append('color', color);
                    formData.append('foreground_gradient_type', foreground_gradient_type);
                    formData.append('primary_color', primary_color);
                    formData.append('secondary_color', secondary_color);
                    formData.append('background_color', background_color);
                    formData.append('background_color_transparency', background_color_transparency);
                    formData.append('need_eye_color', need_eye_color);
                    formData.append('eye_color', eye_color);
                    formData.append('eyeColor_position', eyeColor_position);
                    formData.append('eye_color_style', eye_color_style);
                    formData.append('upload_logo', upload_logo);
                    formData.append('upload_logo_size', upload_logo_size);
                    formData.append('size', size);
                    formData.append('qrcode_ecc', qrcode_ecc);

                    // Show loader
                    $("#regenerate_qr").hide();
                    $("#loader").show();

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        /* the route pointing to the post function */
                        url: `{{ route('user.regenerate.qr') }}`,
                        method: 'POST',
                        /* send the csrf-token and the input to the controller */
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        /* remind that 'data' is the response of the AjaxController */
                        success: function(data) {
                            // Show qr code
                            $("#regenerate_qr").html("<img src='" + data.source + "'>");
                            $("#download_qr").attr("href", data.source);
                            $("#regenerate_qr").show();
                            $("#loader").hide();

                        }
                    });
                }

                // Download QR
                function downloadQR(type) {
                    "use strict";
                    var svgSrc = $("#regenerate_qr").children().attr("src");
                    var name = $("#name").val() == null ? 'QrCode' : $("#name").val();
                    var size = $('input[name="size"]:checked').val();

                    // Call download function
                    svgToQrCodeDownload(svgSrc, type, name, size);
                }
            </script>
        @endsection
    @endif
@endsection
