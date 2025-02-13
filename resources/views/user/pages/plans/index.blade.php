@extends('user.layouts.app', ['settings' => $settings])

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
                            {{ __('Plans') }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-xl mt-3">

            {{-- Plan First --}}
            @if (!isset($active_plan))
                <div class="alert alert-important alert-danger alert-dismissible mb-2" role="alert">
                    <div class="d-flex">
                        <div>
                            {{ __('Please choose your plan first.') }}
                        </div>
                    </div>
                    <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

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
                    <div class="card-body">
                        <h3 class="card-title">{{ __('My plan') }}</h3>

                        @if (isset($active_plan))
                            @if ($active_plan->plan_price == 0)
                                <p class="text-uppercase"><b>{{ __($active_plan->plan_name) }}</b></p>
                                <p>{{ __('FREE PLAN') }}</p>
                            @else
                                <p class="text-uppercase"><b>{{ __($active_plan->plan_name) }}</b></p>
                                <p>{{ $remaining_days > 0 ? __('Remaining Days') . ' : ' . $remaining_days : __('Plan Expired!') }}
                                </p>
                            @endif

                            <div class="card-text">
                                @if ($free_plan == 0 || $active_plan->plan_price != 0)
                                    <a href="{{ route('user.checkout', $active_plan->id) }}" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-rotate"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M19.95 11a8 8 0 1 0 -.5 4m.5 5v-5h-5"></path>
                                        </svg>
                                        {{ __('Renew') }}
                                    </a>
                                @endif
                                <a href="#plans" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-circle-arrow-up-filled" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M17 3.34a10 10 0 1 1 -14.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 14.995 -8.336zm-4.98 3.66l-.163 .01l-.086 .016l-.142 .045l-.113 .054l-.07 .043l-.095 .071l-.058 .054l-4 4l-.083 .094a1 1 0 0 0 1.497 1.32l2.293 -2.293v5.586l.007 .117a1 1 0 0 0 1.993 -.117v-5.585l2.293 2.292l.094 .083a1 1 0 0 0 1.32 -1.497l-4 -4l-.082 -.073l-.089 -.064l-.113 -.062l-.081 -.034l-.113 -.034l-.112 -.02l-.098 -.006z"
                                            stroke-width="0" fill="currentColor"></path>
                                    </svg>
                                    {{ __('Upgrade') }}
                                </a>
                            </div>
                        @else
                            <p>{{ __('No active plans!') }}</p>

                            <div class="card-text">
                                <a href="#plans" class="btn btn-primary">{{ __('Choose plan') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div id="plans" class="page-body">
            <div class="container-xl">

                <div class="row">

                    {{-- Plans --}}
                    @foreach ($plans as $plan)
                        <div class="col-sm-6 col-lg-4 mt-2">
                            <div class="card card-md">

                                {{-- Check plan is "recommended" --}}
                                @if ($plan->recommended == '1')
                                    <div class="ribbon ribbon-top ribbon-bookmark bg-green">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-filled" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="card-body">
                                    <div class="text-capitalize h3 font-weight-bold">{{ __($plan->plan_name) }}</div>
                                    <div class="my-3">
                                        <h1 class="display-5 font-weight-bold">
                                            <strong>
                                                {{ $plan->plan_price == '0' ? '' : $currency->symbol }}{{ $plan->plan_price == '0' ? __('FREE') : $plan->plan_price }}
                                            </strong>
                                        </h1>

                                        <small class="text-capitalize">
                                            @if ($plan->plan_price == '0')
                                                {{ __('Forever') }}
                                            @endif
                                            @if ($plan->validity == '31' && $plan->plan_price != '0')
                                                {{ __('Per') }} {{ __('Month') }}</span>
                                            @endif
                                            @if ($plan->validity == '366')
                                                {{ __('Per') }} {{ __('Year') }}</span>
                                            @endif
                                            @if ($plan->validity > '1' && $plan->validity != '31' && $plan->validity != '366' && $plan->validity != '9999')
                                                {{ __('Per') . ' ' . $plan->validity . ' ' . __('Days') }}
                                            @endif
                                        </small>
                                    </div>
                                    <hr>
                                    <p class="mt-3">{{ __($plan->plan_description) }}</p>
                                    <ul class="list-unstyled lh-lg">
                                        {{-- QRCode Types --}}
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-success"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 12l5 5l10 -10" />
                                            </svg>
                                            <span>{{ $plan->no_access_qr == '999' ? __('Unlimited') : $plan->no_access_qr }}
                                                {{ __('QRCode Types') }}</span>
                                            <div class="col-auto align-self-center display-line">
                                                <span class="form-help display-inline" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="{{ str_replace(' ', ', ', $plan->access_types) }}">?</span>
                                            </div>
                                        </li>
                                        {{-- No. Of QRCodes --}}
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-success"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 12l5 5l10 -10" />
                                            </svg>
                                            <span>{{ $plan->no_qrcodes == '999' ? __('Unlimited') : $plan->no_qrcodes }}
                                                {{ __('QRCodes') }}</span>
                                        </li>
                                        {{-- No. Of Barcodes --}}
                                        <li>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-success"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 12l5 5l10 -10" />
                                            </svg>
                                            <span>{{ $plan->no_barcodes == '999' ? __('Unlimited') : $plan->no_barcodes }}
                                                {{ __('Barcodes') }}</span>
                                        </li>
                                        {{-- Additional Tools --}}
                                        <li>
                                            @if ($plan->additional_tools == '1')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-success"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M5 12l5 5l10 -10" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-danger"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <line x1="18" y1="6" x2="6" y2="18" />
                                                    <line x1="6" y1="6" x2="18" y2="18" />
                                                </svg>
                                            @endif
                                            {{ __('Additional Tools') }}
                                        </li>
                                        {{-- Enable Analytics --}}
                                        <li>
                                            @if ($plan->enable_analaytics == '1')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-success"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M5 12l5 5l10 -10" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-danger"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <line x1="18" y1="6" x2="6" y2="18" />
                                                    <line x1="6" y1="6" x2="18" y2="18" />
                                                </svg>
                                            @endif
                                            {{ __('Enable Analytics') }}
                                        </li>
                                        {{-- Hide Branding --}}
                                        <li>
                                            @if ($plan->hide_branding == '1')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-success"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M5 12l5 5l10 -10" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-danger"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <line x1="18" y1="6" x2="6" y2="18" />
                                                    <line x1="6" y1="6" x2="18" y2="18" />
                                                </svg>
                                            @endif
                                            {{ __('Hide Branding') }}
                                        </li>
                                        {{-- Support --}}
                                        <li>
                                            @if ($plan->support == '1')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-success"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M5 12l5 5l10 -10" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-danger"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <line x1="18" y1="6" x2="6" y2="18" />
                                                    <line x1="6" y1="6" x2="18" y2="18" />
                                                </svg>
                                            @endif
                                            {{ __('Support') }}
                                        </li>
                                    </ul>
                                    <div class="text-center mt-4">
                                        @if ($free_plan == 0 || $plan->plan_price != '0')
                                            <a class="open-plan-model btn btn-outline-primary w-100"
                                                data-id="{{ $plan->id }}"
                                                href="#openPlanModel">{{ __('Choose plan') }}</a>
                                        @else
                                            <a class="down-plan-model btn btn-outline-primary w-100"
                                                data-id="{{ $plan->id }}"
                                                href="#downPlanModel">{{ __('Choose plan') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        @include('user.includes.footer')

        {{-- Downgrade / Upgrade --}}
        <div class="modal modal-blur fade" id="planModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-title">{{ __('Are you sure?') }}</div>
                        <div class="text-danger">
                            {{ __('If you upgrade or downgrade from your current plan, It will temporarily disable your old QR Codes / Barcodes. You need to enable it manually.') }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary me-auto"
                            data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <a class="btn btn-danger" id="plan_id">{{ __('Yes, proceed') }}</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- If you set free plan --}}
        <div class="modal modal-blur fade" id="downPlanModel" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-title text-danger">{{ __('UNABLE TO DOWNGRADE') }}</div>
                        <div class="mb-2">{{ __("Because you are already activated the 'Free' plan.") }}</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger me-auto"
                            data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom JS --}}
@section('custom-js')
    <script>
        // Choose plan
        $(document).on("click", ".open-plan-model", function() {
            "use strict";
            $('#planModal').modal('show');
            var planId = $(this).data('id');
            var link = '{{ route('user.checkout', ':planId') }}';
            link = link.replace(':planId', planId);
            var preview = document.getElementById("plan_id"); //getElementById instead of querySelectorAll
            preview.setAttribute("href", link);
        });

        // Choose downgrade plan
        $(document).on("click", ".down-plan-model", function() {
            "use strict";
            $('#downPlanModel').modal('show');
        });
    </script>
@endsection
@endsection
