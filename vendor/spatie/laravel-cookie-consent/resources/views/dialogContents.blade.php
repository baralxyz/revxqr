{{-- Custom JS --}}
@php
use App\Models\Config;
$config = Config::get();
@endphp

<div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 pb-2">
    <div class="max-w-7xl mx-auto px-6">
        <div class="p-2 rounded-lg bg-{{ $config[11]->config_value }}-500">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-1/2 flex-1 items-center md:inline">
                    <p class="ml-3 text-gray-100 cookie-consent__message">
                        {!! trans('cookie-consent::texts.message') !!}
                    </p>
                </div>
                <div class="mt-2 flex-shrink-0 w-full sm:mt-0 sm:w-auto">
                    <button
                        class="js-cookie-consent-agree cookie-consent__agree cursor-pointer flex items-center rounded justify-center px-4 py-2 rounded-md text-sm font-medium text-gray-100 bg-gray-800 hover:bg-white hover:text-black">
                        {{ trans('cookie-consent::texts.agree') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>