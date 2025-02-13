<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Site Description -->
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}

    @if (isset($setting))
    <!-- Favicon -->
    <link rel="icon" href="{{ asset($setting->favicon) }}" sizes="96x96" type="image/png" />
    @endif

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/tailwind.min.css') }}">

    <!-- Google Recaptcha -->
    {!! htmlScriptTagJsApi() !!}

    <!-- Custom Styles -->
    @yield('custom-css')

    <!-- Google Analytics -->
    @if (isset($setting))
    @if ($setting->google_analytics_id != "")
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $setting->google_analytics_id }}"
        type="b3a3e2ad58df728c3930cf27-text/javascript"></script>
    <script type="b3a3e2ad58df728c3930cf27-text/javascript">
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{ $setting->google_analytics_id }}');
    </script>
    @endif

    @if ($setting->google_tag != "")
    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $setting->google_tag }}');
    </script>
    <!-- End Google Tag Manager -->
    @endif
    @endif
</head>

<body class="antialiased bg-body text-body font-body zoom"
    dir="{{(App::isLocale('ar') || App::isLocale('ur') || App::isLocale('he') ? 'rtl' : 'ltr')}}">

    {{-- Page Content --}}
    <div class="" id="app">
        @yield('content')

        {{-- Cookie consent --}}
        @include('cookie-consent::index')
    </div>

    <!-- Custom JS -->
    @yield('custom-js')
    <!-- Tawk Chat -->
    @if (isset($setting))
    @if ($setting->tawk_chat_bot_key != "")
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/{{ $setting->tawk_chat_bot_key }}';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    @endif
    <!--End of Tawk.to Script-->

    @if ($setting->google_tag != "")
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $setting->google_tag }}" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif
    @endif

</body>

</html>