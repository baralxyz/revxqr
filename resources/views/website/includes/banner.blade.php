@php
// Settings
use App\Models\Config;
use App\Models\Page;
$config = Config::get();
$page = Page::where('slug', 'home')->get();
@endphp

<div class="relative bg-gray-50 pt-20 pb-24 lg:py-40 overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap -mx-4">
            <div class="w-full lg:w-1/2 px-4 flex items-center">
                <div class="w-full text-center lg:text-left">
                    <img class="hidden lg:block absolute inset-0 w-full"
                        src="{{ asset('images/web/background/lines.svg') }}" alt="{{ config('app.name') }}">
                    <div class="relative max-w-md mx-auto lg:mx-0">
                        <h2 class="mb-3 text-4xl lg:text-5xl font-bold font-heading">
                            <span>{{ __($page[0]->body) }}</span>
                            <span class="text-{{ $config[11]->config_value }}-600">{{ __($page[1]->body) }}</span>
                        </h2>
                    </div>
                    <div class="relative max-w-sm mx-auto lg:mx-0">
                        <p class="mb-6 text-gray-400 leading-loose">{{ __($page[2]->body) }}</p>
                        <div><a class="inline-block mb-3 lg:mb-0 lg:mr-3 w-full lg:w-auto py-2 px-6 leading-loose bg-{{ $config[11]->config_value }}-700 hover:bg-{{ $config[11]->config_value }}-600 text-white font-semibold rounded-l-xl rounded-t-xl transition duration-200"
                                href="{{ url($page[4]->body) }}">{{ __($page[3]->body) }}</a><a
                                class="inline-block w-full lg:w-auto py-2 px-6 mr-2 leading-loose font-semibold text-gray-50 bg-gray-700 hover:bg-gray-600 rounded-l-xl rounded-t-xl transition duration-200"
                                href="{{ $page[6]->body }}">{{ __($page[5]->body) }}</a></div>
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-1/2 px-4">
                <img class="lg:absolute top-0 my-12 lg:my-0 h-full w-full lg:w-1/2 rounded-3xl lg:rounded-none object-cover"
                    src="{{ asset($config[12]->config_value) }}" alt="{{ config('app.name') }}">
            </div>
        </div>
    </div>
</div>