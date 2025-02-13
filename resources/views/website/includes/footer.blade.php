@php
    // Settings
    use App\Models\Setting;
    use App\Models\Page;
    $setting = Setting::where('status', 1)->first();
    $pages = Page::get();
    $socialLinks = Page::where('slug', 'contact')->get();
@endphp

<section>
    <div class="skew skew-top mr-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 0 10 10 0 10"></polygon>
        </svg>
    </div>
    <div class="skew skew-top ml-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 10 10 0 10 10"></polygon>
        </svg>
    </div>
    <div class="py-20 px-5 bg-gray-50 radius-for-skewed">
        <div class="container mx-auto">
            <div class="pb-12 flex flex-wrap items-center justify-between border-b border-gray-100">
                <div class="w-full lg:w-1/5 mb-12 lg:mb-4">
                    <a class="inline-block text-3xl font-bold leading-none" href="{{ url('/') }}">
                        <img class="h-12" src="{{ asset($setting->site_logo) }}" alt="{{ config('app.name') }}"
                            width="auto">
                    </a>
                </div>
                <div class="w-full lg:w-auto">
                    <ul class="flex flex-wrap lg:space-x-5 items-center">
                        @if ($pages[46]->slug == 'about' && $pages[46]->status == 1)
                            <li class="w-full md:w-auto mb-2 md:mb-0"><a
                                    class="lg:text-sm text-gray-900 hover:text-gray-500 {{ request()->is('about') ? 'font-bold' : '' }}"
                                    href="{{ route('web.about') }}">{{ __('About us') }}</a></li>
                            <li class="hidden md:block">
                                <svg class="mx-4 w-4 h-4 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                    </path>
                                </svg>
                            </li>
                        @endif

                        @if ($pages[60]->slug == 'pricing' && $pages[60]->status == 1)
                            <li class="w-full md:w-auto mb-2 md:mb-0"><a
                                    class="lg:text-sm text-gray-900 hover:text-gray-500 {{ request()->is('contact') ? 'font-bold' : '' }}"
                                    href="{{ route('web.contact') }}">{{ __('Help') }}</a></li>
                            <li class="hidden md:block">
                                <svg class="mx-4 w-4 h-4 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                    </path>
                                </svg>
                            </li>
                        @endif

                        @if ($pages[77]->slug == 'faq' && $pages[77]->status == 1)
                            <li class="w-full md:w-auto mb-2 md:mb-0"><a
                                    class="lg:text-sm text-gray-900 hover:text-gray-500 {{ request()->is('faq') ? 'font-bold' : '' }}"
                                    href="{{ route('web.faq') }}">{{ __('FAQs') }}</a></li>
                            <li class="hidden md:block">
                                <svg class="mx-4 w-4 h-4 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                    </path>
                                </svg>
                            </li>
                        @endif

                        @if ($pages[96]->slug == 'privacy-policy' && $pages[96]->status == 1)
                            <li class="w-full md:w-auto mb-2 md:mb-0"><a
                                    class="lg:text-sm text-gray-900 hover:text-gray-500 {{ request()->is('privacy-policy') ? 'font-bold' : '' }}"
                                    href="{{ route('web.privacy') }}">{{ __('Privacy Policy') }}</a></li>
                            <li class="hidden md:block">
                                <svg class="mx-4 w-4 h-4 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                    </path>
                                </svg>
                            </li>
                        @endif

                        @if ($pages[109]->slug == 'refund-policy' && $pages[109]->status == 1)
                            <li class="w-full md:w-auto mb-2 md:mb-0"><a
                                    class="lg:text-sm text-gray-900 hover:text-gray-500 {{ request()->is('refund-policy') ? 'font-bold' : '' }}"
                                    href="{{ route('web.refund') }}">{{ __('Refund Policy') }}</a></li>
                            <li class="hidden md:block">
                                <svg class="mx-4 w-4 h-4 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                    </path>
                                </svg>
                            </li>
                        @endif

                        @if ($pages[123]->slug == 'terms-and-conditions' && $pages[123]->status == 1)
                            <li class="w-full md:w-auto mb-2 md:mb-0"><a
                                    class="lg:text-sm text-gray-900 hover:text-gray-500 {{ request()->is('terms-and-conditions') ? 'font-bold' : '' }}"
                                    href="{{ route('web.terms') }}">{{ __('Terms and Conditions') }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="mt-8 flex flex-wrap justify-between items-center">
                <p class="order-last text-sm text-gray-900">© {{ date('Y') }} {{ __(config('app.name')) }}.
                    {{ __('All
                                                            rights reserved.') }}</p>
                <div class="mb-4 lg:mb-0 order-first lg:order-last">
                    <a class="inline-block mr-2 p-2 bg-gray-50 hover:bg-gray-100 rounded"
                        href="{{ $socialLinks[13]->body }}" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-facebook"
                            width="24" height="24" viewbox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3"></path>
                        </svg>
                    </a>
                    <a class="inline-block mr-2 p-2 bg-gray-50 hover:bg-gray-100 rounded"
                        href="{{ $socialLinks[14]->body }}" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-x"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                            <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                        </svg>
                    </a>
                    <a class="inline-block mr-2 p-2 bg-gray-50 hover:bg-gray-100 rounded"
                        href="{{ $socialLinks[15]->body }}" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-instagram"
                            width="24" height="24" viewbox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <rect x="4" y="4" width="16" height="16" rx="4"></rect>
                            <circle cx="12" cy="12" r="3"></circle>
                            <line x1="16.5" y1="7.5" x2="16.5" y2="7.501"></line>
                        </svg>
                    </a>
                    <a class="inline-block mr-2 p-2 bg-gray-50 hover:bg-gray-100 rounded"
                        href="{{ $socialLinks[16]->body }}" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-linkedin"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                            <path d="M8 11l0 5" />
                            <path d="M8 8l0 .01" />
                            <path d="M12 16l0 -5" />
                            <path d="M16 16v-3a2 2 0 0 0 -4 0" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="skew skew-bottom mr-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 0 10 0 0 10"></polygon>
        </svg>
    </div>
    <div class="skew skew-bottom ml-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-gray-50" viewbox="0 0 10 10" preserveaspectratio="none">
            <polygon fill="currentColor" points="0 0 10 0 10 10"></polygon>
        </svg>
    </div>
</section>
