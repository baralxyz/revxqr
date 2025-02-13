@php
// Get plan details
use App\Models\User;
$plan = User::where('id', Auth::user()->id)->where('status', 1)->first();
$plan_details = json_decode($plan->plan_details);
@endphp

<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
            <div class="container-xl">
                <ul class="navbar-nav">

                    {{-- Dashboard --}}
                    <li class="nav-item {{ request()->is('user/dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <polyline points="5 12 3 12 12 3 21 12 19 12" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                {{ __('Dashboard') }}
                            </span>
                        </a>
                    </li>

                    {{-- QR Codes --}}
                    @if(env('APP_TYPE') == 'QRCODE' || env('APP_TYPE') == 'BOTH')
                    <li
                        class="nav-item dropdown {{ request()->is('user/qrcodes') || request()->is('user/qrcode*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <rect x="3" y="4" width="18" height="16" rx="3"></rect>
                                    <circle cx="9" cy="10" r="2"></circle>
                                    <line x1="15" y1="8" x2="17" y2="8"></line>
                                    <line x1="15" y1="12" x2="17" y2="12"></line>
                                    <line x1="7" y1="16" x2="17" y2="16"></line>
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                {{ __('QR Codes') }}
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('user.all.qr') }}">
                                {{ __('QR Codes') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('user.all.epc.qr') }}">
                                {{ __('EPC QR Codes') }} 
                            </a>
                        </div>
                    </li>
                    @endif

                    @if(env('APP_TYPE') == 'BARCODE' || env('APP_TYPE') == 'BOTH')
                    {{-- Barcodes --}}
                    <li
                        class="nav-item dropdown {{ request()->is('user/barcodes') || request()->is('user/barcode*') || request()->is('user/groups') || request()->is('user/group*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <rect x="3" y="4" width="18" height="16" rx="3"></rect>
                                    <circle cx="9" cy="10" r="2"></circle>
                                    <line x1="15" y1="8" x2="17" y2="8"></line>
                                    <line x1="15" y1="12" x2="17" y2="12"></line>
                                    <line x1="7" y1="16" x2="17" y2="16"></line>
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                {{ __('Barcodes') }}
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('user.all.barcode') }}">
                                {{ __('Barcodes') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('user.all.groups') }}">
                                {{ __('Groups') }}
                            </a>
                        </div>
                    </li>
                    @endif

                    {{-- Plans --}}
                    <li class="nav-item {{ request()->is('user/plans') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.plans') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <rect x="3" y="4" width="18" height="16" rx="3"></rect>
                                    <circle cx="9" cy="10" r="2"></circle>
                                    <line x1="15" y1="8" x2="17" y2="8"></line>
                                    <line x1="15" y1="12" x2="17" y2="12"></line>
                                    <line x1="7" y1="16" x2="17" y2="16"></line>
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                {{ __('Plans') }}
                            </span>
                        </a>
                    </li>

                    {{-- Transactions --}}
                    <li class="nav-item {{ request()->is('user/transactions') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.transactions') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                    <rect x="9" y="3" width="6" height="4" rx="2" />
                                    <path d="M14 11h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                                    <path d="M12 17v1m0 -8v1" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                {{ __('Transactions') }}
                            </span>
                        </a>
                    </li>

                    @if (isset($plan_details))
                    @if ($plan_details->additional_tools == 1)
                    {{-- Additional Tools --}}
                    <li class="nav-item dropdown {{ request()->is('user/tools*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tools"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 21h4l13 -13a1.5 1.5 0 0 0 -4 -4l-13 13v4"></path>
                                    <line x1="14.5" y1="5.5" x2="18.5" y2="9.5"></line>
                                    <polyline points="12 8 7 3 3 7 8 12"></polyline>
                                    <line x1="7" y1="8" x2="5.5" y2="9.5"></line>
                                    <polyline points="16 12 21 17 17 21 12 16"></polyline>
                                    <line x1="16" y1="17" x2="14.5" y2="18.5"></line>
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                {{ __('Addtional Tools') }}
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('user.whois-lookup') }}">
                                {{ __('Whois Lookup') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('user.dns-lookup') }}">
                                {{ __('DNS Lookup') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('user.ip-lookup') }}">
                                {{ __('IP Lookup') }}
                            </a>
                        </div>
                    </li>
                    @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>