@extends('user.layouts.app')

{{-- Custom CSS & JS --}}
@section('custom-css')
<script src="{{ asset('js/clipboard.min.js') }}"></script>
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
                        {{ __('Download QR Code') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">

            {{-- Failed --}}
            @if(Session::has("failed"))
            <div class="alert alert-important alert-danger alert-dismissible mb-2 d-print-none" role="alert">
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
            <div class="alert alert-important alert-success alert-dismissible mb-2 d-print-none" role="alert">
                <div class="d-flex">
                    <div>
                        {{Session::get('success')}}
                    </div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            @endif

            {{-- Check QR code status --}}
            @if ($qrcode_details->status == 1)
            <div class="row row-deck row-cards">
                {{-- Download QR Code --}}
                <div class="col-xl-8">
                    <div class="card">
                        <div class="visible-print text-center m-4 printable-area">
                            <div class="flapImage code-style" id="idHot">
                                <img src="{{ asset($qrcode_details->qr_code) }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="visible-print text-center m-4 d-print-none">
                            <h2 class="card-title h2">{{ __('OPTIONS') }}</h2>
                            <div class="col-auto ms-auto d-print-none">
                                {{-- Print --}}
                                <button type="button" class="btn btn-primary w-40 btn-icon"
                                    onclick="doPrint();" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="{{ __('Print') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                        <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                        <rect x="7" y="13" width="10" height="8" rx="2" />
                                    </svg>
                                </button>

                                {{-- Share --}}
                                <a data-id="{{ $qrcode_details->qr_code_id }}" href="#openShare"
                                    class="btn btn-primary w-40 btn-icon open-share-model" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="{{ __('Share') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-share"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="6" cy="12" r="3"></circle>
                                        <circle cx="18" cy="6" r="3"></circle>
                                        <circle cx="18" cy="18" r="3"></circle>
                                        <line x1="8.7" y1="10.7" x2="15.3" y2="7.3"></line>
                                        <line x1="8.7" y1="13.3" x2="15.3" y2="16.7"></line>
                                    </svg>
                                </a>

                                {{-- Download --}}
                                <a download="{{ $qrcode_details->name }}" href="{{ asset($qrcode_details->qr_code) }}"
                                    class="btn btn-primary w-40 btn-icon" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="{{ __('Download') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-download" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                        <polyline points="7 11 12 16 17 11"></polyline>
                                        <line x1="12" y1="4" x2="12" y2="16"></line>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            {{-- If QR Code is empty --}}
            <div class="page-body">
                <div class="container-xl d-flex flex-column justify-content-center">
                    <div class="empty">
                        <div class="empty-img"><img src="{{ asset('images/undraw_printing_invoices_5r4r.svg') }}"
                                height="128" alt="">
                        </div>
                        <p class="empty-title">{{ __('No download found') }}</p>
                        <p class="empty-subtitle text-muted">
                            {{ __('Your QR code is disabled. Once, enable the QR code and try again.') }}
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

{{-- Share modal --}}
<div class="modal modal-blur fade" id="shareModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="modal-title">{{ __('Share')}}</div>

                {{-- Link --}}
                <input type="text" class="form-control mb-3" value="{{ asset($qrcode_details->qr_code) }}" id="qrLink">

                {{-- Facebook --}}
                <a id="facebook" target="_blank" class="btn btn-dark w-20 btn-icon mb-2" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3"></path>
                    </svg>
                </a>

                {{-- Twitter --}}
                <a id="twitter" target="_blank" class="btn btn-dark w-20 btn-icon mb-2" aria-label="Twitter">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-twitter"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path
                            d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335 -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395 -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0 0 .497 -3.753c-.002 -.249 1.51 -2.772 1.818 -4.013z">
                        </path>
                    </svg>
                </a>

                {{-- LinkedIn --}}
                <a id="linkedin" class="btn btn-dark w-20 btn-icon mb-2" aria-label="LinkedIn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-linkedin"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <rect x="4" y="4" width="16" height="16" rx="2"></rect>
                        <line x1="8" y1="11" x2="8" y2="16"></line>
                        <line x1="8" y1="8" x2="8" y2="8.01"></line>
                        <line x1="12" y1="16" x2="12" y2="11"></line>
                        <path d="M16 16v-3a2 2 0 0 0 -4 0"></path>
                    </svg>
                </a>

                {{-- WhatsApp --}}
                <a id="whatsapp" target="_blank" class="btn btn-dark w-20 btn-icon mb-2" aria-label="Whatsapp">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9"></path>
                        <path
                            d="M9 10a0.5 .5 0 0 0 1 0v-1a0.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a0.5 .5 0 0 0 0 -1h-1a0.5 .5 0 0 0 0 1">
                        </path>
                    </svg>
                </a>

                {{-- Telegram --}}
                <a id="telegram" target="_blank" class="btn btn-dark w-20 btn-icon mb-2" aria-label="Telegram">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-telegram"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4"></path>
                    </svg>
                </a>

                {{-- Email --}}
                <a id="email" class="btn btn-dark w-20 btn-icon mb-2" aria-label="Email">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                        <polyline points="3 7 12 13 21 7"></polyline>
                    </svg>
                </a>

                {{-- Copy link --}}
                <button type="button" class="btn btn-dark w-20 btn-icon mb-2 copyLink" data-clipboard-target="#qrLink"
                    title="{{ __('Copy') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <rect x="8" y="8" width="12" height="12" rx="2"></rect>
                        <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path>
                    </svg>
                </button>
            </div>
            <div class="modal-footer">
                {{-- Cancel --}}
                <button type="button" class="btn btn-danger w-100 me-auto" data-bs-dismiss="modal">{{
                    __('Cancel')}}</button>
            </div>
        </div>
    </div>
</div>

@php
$shareContent = $config[30]->config_value;
$shareContent = str_replace("{ appName }", env('APP_NAME'), $shareContent);
$shareContent = str_replace("{ qr_code_link }", asset($qrcode_details->qr_code), $shareContent);
@endphp

{{-- Custom JS --}}
@section('custom-js')
<script>
    // Open share modal
    $(document).on("click", ".open-share-model", function () {
    "use strict";
    $('#shareModal').modal('show');
    var qrCodeId = $(this).data('id');

    // Set Facebook link
    var facebookLink = 'https://www.facebook.com/sharer.php?u=' + `{{ asset($qrcode_details->qr_code) }}`+ '&t=' + `{{ $shareContent }}`;
    facebookLink = facebookLink.replace(':qrCodeId', qrCodeId);
    var facebookLinkPreview = document.getElementById("facebook");
    facebookLinkPreview.setAttribute("href", facebookLink);

    // Set Twitter link
    var twitterLink = 'https://twitter.com/intent/tweet?text='+ `{{ $shareContent }}`;
    twitterLink = twitterLink.replace(':qrCodeId', qrCodeId);
    var twitterLinkPreview = document.getElementById("twitter");
    twitterLinkPreview.setAttribute("href", twitterLink);

    // Set LinkedIn link
    var linkedInLink = 'http://www.linkedin.com/shareArticle?mini=true&url=' + `{{ asset($qrcode_details->qr_code) }}` + '&title=This is your QR code link&summary=This is your QR code link&source='+`{{ env('APP_URL') }}`;
    linkedInLink = linkedInLink.replace(':qrCodeId', qrCodeId);
    var linkedInLinkPreview = document.getElementById("linkedin");
    linkedInLinkPreview.setAttribute("href", linkedInLink);

    // Set Whatsapp link
    var whatsappLink = 'https://api.whatsapp.com/send?text='+ `{{ $shareContent }}`;
    whatsappLink = whatsappLink.replace(':qrCodeId', qrCodeId);
    var whatsappLinkPreview = document.getElementById("whatsapp");
    whatsappLinkPreview.setAttribute("href", whatsappLink);

    // Set Telegram link
    var telegramLink = 'https://telegram.me/share/url?text='+ `{{ $shareContent }}` + 'url=' + `{{ asset($qrcode_details->qr_code) }}`;
    telegramLink = telegramLink.replace(':qrCodeId', qrCodeId);
    var telegramLinkPreview = document.getElementById("telegram");
    telegramLinkPreview.setAttribute("href", telegramLink);

    // Set Email link
    var emailLink = 'mailto:?subject=My QR Code&amp;body=This is your QR code link :'+ `{{ asset($qrcode_details->qr_code) }}`;
    emailLink = emailLink.replace(':qrCodeId', qrCodeId);
    var emailLinkPreview = document.getElementById("email");
    emailLinkPreview.setAttribute("href", emailLink);

    // Copy link
    var clipboard = new ClipboardJS('.copyLink');
    clipboard.on('success', function (e) {
      swal({
         title: "Copied!",
         text: "QR Code path was copied.",
         icon: "success",
         buttons: false,
         timer: 2000
         });
      });

    clipboard.on('error', function (e) {
        swal({
         title: "Oops!",
         text: "Something wrong.",
         icon: "error",
          buttons: false,
         timer: 2000
        });
    });
});
</script>
@endsection
@endsection