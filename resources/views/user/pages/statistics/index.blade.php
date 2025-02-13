@extends('user.layouts.app')

{{-- Custom CSS --}}
@section('custom-css')
<link rel="stylesheet" href="{{ asset('css/tabler-flags.min.css') }}">
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
                        {{ __('URL Statistics') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                {{-- Countries --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-stamp">
                            <div class="card-stamp-icon bg-green">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-flag"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="5" y1="5" x2="5" y2="21"></line>
                                    <line x1="19" y1="5" x2="19" y2="14"></line>
                                    <path d="M5 5a5 5 0 0 1 7 0a5 5 0 0 0 7 0"></path>
                                    <path d="M5 14a5 5 0 0 1 7 0a5 5 0 0 0 7 0"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title">{{ __('Countries') }}</h1>
                            @foreach ($countries as $country)
                            <h3><span class="flag flag-country-{{ strtolower($country->iso_code) }} mr-3"></span>{{
                                $country->country_code }} <span class="float-end">{{ 100 / $countries->count()
                                    }}%</span></h3>
                            <div class="progress mb-3">
                                <div class="progress-bar" style="width: {{ 100 / $countries->count() }}%"
                                    role="progressbar" aria-valuenow="{{ $country->total }}" aria-valuemin="0"
                                    aria-valuemax="100" aria-label="{{ 100 / $country->total }}%">
                                    <span class="visually"></span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Referrers --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-stamp">
                            <div class="card-stamp-icon bg-green">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-share"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="6" cy="12" r="3"></circle>
                                    <circle cx="18" cy="6" r="3"></circle>
                                    <circle cx="18" cy="18" r="3"></circle>
                                    <line x1="8.7" y1="10.7" x2="15.3" y2="7.3"></line>
                                    <line x1="8.7" y1="13.3" x2="15.3" y2="16.7"></line>
                                </svg>
                            </div>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title">{{ __('Referrers') }}</h1>
                            @foreach ($referrer_hosts as $referrer_host)
                            <h3>{{ ucfirst($referrer_host->referrer_host) }} <span class="float-end">{{ 100 /
                                    $referrer_hosts->count() }}%</span></h3>
                            <div class="progress mb-3">
                                <div class="progress-bar" style="width: {{ 100 / $referrer_hosts->count() }}%"
                                    role="progressbar" aria-valuenow="{{ $referrer_hosts->count() }}" aria-valuemin="0"
                                    aria-valuemax="100" aria-label="{{ 100 / $referrer_hosts->count() }}%">
                                    <span class="visually"></span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Devices --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-stamp">
                            <div class="card-stamp-icon bg-green">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-brand-android" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="4" y1="10" x2="4" y2="16"></line>
                                    <line x1="20" y1="10" x2="20" y2="16"></line>
                                    <path d="M7 9h10v8a1 1 0 0 1 -1 1h-8a1 1 0 0 1 -1 -1v-8a5 5 0 0 1 10 0"></path>
                                    <line x1="8" y1="3" x2="9" y2="5"></line>
                                    <line x1="16" y1="3" x2="15" y2="5"></line>
                                    <line x1="9" y1="18" x2="9" y2="21"></line>
                                    <line x1="15" y1="18" x2="15" y2="21"></line>
                                </svg>
                            </div>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title">{{ __('Devices') }}</h1>
                            @foreach ($device_types as $device_type)
                            <h3>{{ ucfirst($device_type->device_type) }} <span class="float-end">{{ 100 /
                                    $device_types->count() }}%</span></h3>
                            <div class="progress mb-3">
                                <div class="progress-bar" style="width: {{ 100 / $device_types->count() }}%"
                                    role="progressbar" aria-valuenow="{{ $device_types->count() }}" aria-valuemin="0"
                                    aria-valuemax="100" aria-label="{{ 100 / $device_types->count() }}%">
                                    <span class="visually"></span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Operating Systems --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-stamp">
                            <div class="card-stamp-icon bg-green">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-brand-windows" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M17.8 20l-12 -1.5c-1 -.1 -1.8 -.9 -1.8 -1.9v-9.2c0 -1 .8 -1.8 1.8 -1.9l12 -1.5c1.2 -.1 2.2 .8 2.2 1.9v12.1c0 1.2 -1.1 2.1 -2.2 1.9z">
                                    </path>
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="4" y1="12" x2="20" y2="12"></line>
                                </svg>
                            </div>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title">{{ __('Operating Systems') }}</h1>
                            @foreach ($os_names as $os_name)
                            <h3>{{ ucfirst($os_name->os_name) }} <span class="float-end">{{ 100 /
                                    $os_names->count() }}%</span></h3>
                            <div class="progress mb-3">
                                <div class="progress-bar" style="width: {{ 100 / $os_names->count() }}%"
                                    role="progressbar" aria-valuenow="{{ $os_names->count() }}" aria-valuemin="0"
                                    aria-valuemax="100" aria-label="{{ 100 / $os_names->count() }}%">
                                    <span class="visually"></span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Browsers --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-stamp">
                            <div class="card-stamp-icon bg-green">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-brand-chrome" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <line x1="12" y1="9" x2="20.4" y2="9"></line>
                                    <line x1="12" y1="9" x2="20.4" y2="9" transform="rotate(120 12 12)"></line>
                                    <line x1="12" y1="9" x2="20.4" y2="9" transform="rotate(240 12 12)"></line>
                                </svg>
                            </div>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title">{{ __('Browsers') }}</h1>
                            @foreach ($browser_names as $browser_name)
                            <h3>{{ ucfirst($browser_name->browser_name) }} <span class="float-end">{{ 100 /
                                    $browser_names->count() }}%</span></h3>
                            <div class="progress mb-3">
                                <div class="progress-bar" style="width: {{ 100 / $browser_names->count() }}%"
                                    role="progressbar" aria-valuenow="{{ $browser_names->count() }}" aria-valuemin="0"
                                    aria-valuemax="100" aria-label="{{ 100 / $browser_names->count() }}%">
                                    <span class="visually"></span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Languages --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-stamp">
                            <div class="card-stamp-icon bg-green">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-language"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 5h7"></path>
                                    <path d="M9 3v2c0 4.418 -2.239 8 -5 8"></path>
                                    <path d="M5 9c-.003 2.144 2.952 3.908 6.7 4"></path>
                                    <path d="M12 20l4 -9l4 9"></path>
                                    <path d="M19.1 18h-6.2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title">{{ __('Languages') }}</h1>
                            @foreach ($browser_languages as $browser_language)
                            <h3>{{ $browser_language->browser_language }} <span class="float-end">{{ 100 /
                                    $browser_languages->count() }}%</span></h3>
                            <div class="progress mb-3">
                                <div class="progress-bar" style="width: {{ 100 / $browser_languages->count() }}%"
                                    role="progressbar" aria-valuenow="{{ $browser_languages->count() }}"
                                    aria-valuemin="0" aria-valuemax="100"
                                    aria-label="{{ 100 / $browser_languages->count() }}%">
                                    <span class="visually"></span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    @include('user.includes.footer')
</div>
@endsection