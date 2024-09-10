<?php
$plugins = array_keys((array) config('plugins'));
$publicDisk = \Storage::disk(config('filesystems.default'));

$currentUrl = url()->current();
if (strpos($currentUrl, '/public') !== false) {
    header('Location: ' . env('APP_URL'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="{{ ietfLangTag(config('app.locale')) }}" {!! config('lang.direction') == 'rtl' ? ' dir="rtl"' : '' !!}>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @includeFirst([config('larapen.core.customizedViewPath') . 'common.meta-robots', 'common.meta-robots'])
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-title" content="{{ config('settings.app.name') }}">

    {{-- Start Custom Hide Orginal favicon --}}
    {{-- <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{ $publicDisk->url('app/default/ico/apple-touch-icon-144-precomposed.png') . getPictureVersion() }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="{{ $publicDisk->url('app/default/ico/apple-touch-icon-114-precomposed.png') . getPictureVersion() }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="{{ $publicDisk->url('app/default/ico/apple-touch-icon-72-precomposed.png') . getPictureVersion() }}">
    <link rel="apple-touch-icon-precomposed"
        href="{{ $publicDisk->url('app/default/ico/apple-touch-icon-57-precomposed.png') . getPictureVersion() }}">
    <link rel="shortcut icon" href="{{ config('settings.app.favicon_url') }}"> --}}
    {{-- End Custom Hide Orginal favicon --}}
    {{-- Start Custom Add favicon --}}
    <link rel="apple-touch-icon" sizes="57x57" href="https://eze.pics/ezead-com/public/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="https://eze.pics/ezead-com/public/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="https://eze.pics/ezead-com/public/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="https://eze.pics/ezead-com/public/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114"
        href="https://eze.pics/ezead-com/public/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120"
        href="https://eze.pics/ezead-com/public/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144"
        href="https://eze.pics/ezead-com/public/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152"
        href="https://eze.pics/ezead-com/public/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180"
        href="https://eze.pics/ezead-com/public/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"
        href="https://eze.pics/ezead-com/public/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="https://eze.pics/ezead-com/public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96"
        href="https://eze.pics/ezead-com/public/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="https://eze.pics/ezead-com/public/favicon/favicon-16x16.png">
    {{-- <link rel="manifest" href="https://eze.pics/ezead-com/public/favicon/manifest.json"> --}}
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="https://eze.pics/ezead-com/public/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    {{-- End Custom Add favicon --}}

    {{-- <title>{!! MetaTag::get('title') !!}</title> --}}
    {{-- CUSTOM TITLE --}}
    <title>@yield('title', MetaTag::get('title')) </title>
    {!! MetaTag::tag('description') !!}{!! MetaTag::tag('keywords') !!}
    {{-- Custom Add Canonical Link --}}
    <link rel="canonical" href="{{ url()->current() }}" />
    {{-- Custom Hide Canonical Link
    <link rel="canonical" href="{{ request()->fullUrl() }}" /> --}}
    {{-- Specify a default target for all hyperlinks and forms on the page --}}
    <base target="_top" />
    @if (isset($post))
        @if (isVerifiedPost($post))
            @if (config('services.facebook.client_id'))
                <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />
            @endif
            {!! $og->renderTags() !!}
            {!! MetaTag::twitterCard() !!}
        @endif
    @else
        @if (config('services.facebook.client_id'))
            <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />
        @endif
        {!! $og->renderTags() !!}
        {!! MetaTag::twitterCard() !!}
    @endif
    @include('feed::links')
    {!! seoSiteVerification() !!}

    {{-- @if (file_exists(public_path('manifest.json')))
        <link rel="manifest" href="/manifest.json">
    @endif --}}

    @stack('before_styles_stack')
    @yield('before_styles')
        
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    @if (config('lang.direction') == 'rtl')
        <link href="https://fonts.googleapis.com/css?family=Cairo|Changa" rel="stylesheet">
        <link href="{{ url('css/app.rtl.css') }}" rel="stylesheet">
    @else
        {{-- Custom Hide - Orignal --}}
        {{-- <link href="{{ url(mix('css/app.css')) }}" rel="stylesheet"> --}}
        {{-- Custom Add - After Page Load CSS --}}
        <link rel="preload" href="{{ url('css/app.css') }}" as="style"
            onload="this.onload=null;this.rel='stylesheet'">
        <noscript>
            <link href="{{ url('css/app.css') }}" rel="stylesheet">
        </noscript>
    @endif
    @if (config('plugins.detectadsblocker.installed'))
        <link href="{{ url('assets/detectadsblocker/css/style.css') . getPictureVersion() }}" rel="stylesheet">
    @endif

    <?php
    $skinQs = request()->filled('skin') ? '?skin=' . request()->get('skin') : null;
    if (request()->filled('display')) {
        $skinQs .= !empty($skinQs) ? '&' : '?';
        $skinQs .= 'display=' . request()->get('display');
    }
    ?>
    {{-- Custom Hide - Orignal --}}
    {{-- <link href="{{ url('common/css/style.css') . $skinQs . getPictureVersion(!empty($skinQs)) }}" rel="stylesheet"> --}}
    {{-- Custom Add - After Page Load CSS --}}
    <link rel="preload" href="{{ url('common/css/style.css') . $skinQs . getPictureVersion(!empty($skinQs)) }}"
        as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="{{ url('common/css/style.css') . $skinQs . getPictureVersion(!empty($skinQs)) }}" rel="stylesheet">
    </noscript>
    <?php
    if (isset($getSearchFormOp) && is_array($getSearchFormOp)) {
        $homeStyle = view('common.css.homepage', ['getSearchFormOp', $getSearchFormOp])->render();
        echo $homeStyle;
    }
    ?>
    {{-- Custom Hide - Orignal --}}
    {{-- <link href="{{ url('css/custom.css') . getPictureVersion() }}" rel="stylesheet">
    <link href="{{ url('css/mobileCustom.css') . getPictureVersion() }}" rel="stylesheet"> --}}

    {{-- Custom Add - After Page Load CSS --}}
    <link rel="stylesheet" href="{{ url('css/custom.css') . getPictureVersion() }}">
    <noscript>
        <link href="{{ url('css/custom.css') . getPictureVersion() }}" rel="stylesheet">
    </noscript>
    <link rel="preload" href="{{ url('css/mobileCustom.css') . getPictureVersion() }}" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="{{ url('css/mobileCustom.css') . getPictureVersion() }}" rel="stylesheet">
    </noscript>
    <link rel="preload" href="{{ url('css/custom-theme.css') . getPictureVersion() }}" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="{{ url('css/custom-theme.css') . getPictureVersion() }}" rel="stylesheet">
    </noscript>
    <link rel="preload" href="{{ url('css/scroll-top.css') . getPictureVersion() }}" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="{{ url('css/scroll-top.css') . getPictureVersion() }}" rel="stylesheet">
    </noscript>

    {{-- Start custom add meta tags --}}
    <meta name="rating" content="General" />
    <meta name="expires" content="never" />
    <meta name="language" content="english" />
    <meta name="charset" content="ISO-8859-1" />
    <meta name="distribution" content="Global" />
    <meta name="robots" content="INDEX,FOLLOW" />
    <meta name="email" content="admin@ezead.com" />
    <meta name="author" content="www.ezead.com" />
    <meta name="publisher" content="Ezead Media Group Inc" />
    <meta name="copyright" content="Copyright 2006 - 2023" />
    {{-- End custom add meta tags --}}

    @stack('after_styles_stack')
    @yield('after_styles')

    @if (isset($plugins) && !empty($plugins))
        @foreach ($plugins as $plugin)
            @yield($plugin . '_styles')
        @endforeach
    @endif

    @if (config('settings.style.custom_css'))
        {!! printCss(config('settings.style.custom_css')) . "\n" !!}
    @endif

    @if (config('settings.other.js_code'))
        {!! printJs(config('settings.other.js_code')) . "\n" !!}
    @endif

    <!--[if lt IE 9]>
 <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
 <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
 <![endif]-->

    <script>
        paceOptions = {
            elements: true
        };
    </script>
    {{-- Custom Hide - Orignal --}}
    {{-- <script src="{{ url('assets/js/pace.min.js') }}"></script>
    <script src="{{ url('assets/plugins/modernizr/modernizr-custom.js') }}"></script> --}}
    {{-- Custom Add - After Page Load JS --}}
    <script src="{{ url('assets/js/pace.min.js') }}" defer></script>
    <script src="{{ url('assets/plugins/modernizr/modernizr-custom.js') }}" defer></script>
    @yield('captcha_head')
    @section('recaptcha_head')
        @if (config('settings.security.captcha') == 'recaptcha' &&
                config('recaptcha.site_key') &&
                config('recaptcha.secret_key'))
            <style>
                .is-invalid .g-recaptcha iframe,
                .has-error .g-recaptcha iframe {
                    border: 1px solid #f85359;
                }
            </style>
            @if (config('recaptcha.version') == 'v3')
                <script type="text/javascript">
                    function myCustomValidation(token) {
                        /* read HTTP status */
                        /* console.log(token); */

                        if ($('#gRecaptchaResponse').length) {
                            $('#gRecaptchaResponse').val(token);
                        }
                    }
                </script>
                {!! recaptchaApiV3JsScriptTag([
                    'action' => request()->path(),
                    'custom_validation' => 'myCustomValidation',
                ]) !!}
            @else
                {!! recaptchaApiJsScriptTag() !!}
            @endif
        @endif
    @show

    <style>
        .nav-mobile-scrolling-links {
            display: none !important;
        }

        @media(max-width:1150px) {
            .nav-mobile-scrolling-links {
                display: flex !important;
                overflow: hidden;
                overflow-x: auto;
                white-space: nowrap;
            }

            .navbar.navbar-site {
                border-bottom-color: #ffffff !important;
            }

            #nav-section li {
                padding: 20px !important;
            }

            #nav-section li {
                font-size: 20px;
            }

            .chat-box img {
                width: 100px;
                max-width: 100% !important;
            }

            .mobile-profile-photo-center {
                text-align: center;
            }

            .mobile-profile-photo {
                padding: 16px 56px;
            }

            .mobile-profile-photo-button {
                padding: 0px 60px !important;
            }

            .mobile-profile-photo-chosen-button {
                padding: 16px;
            }
        }

        a.dropdown-toggle.nav-link {
            padding: 0px 0px 0px 30px;
        }

        .open-on-hover .header_username {
            display: inline !important;
        }

        .content-footer.text-start.printer-hide a {
            margin: 6px;
        }

        .nav-mobile-scrolling-links .main-category-wrapper {
            color: rgba(0, 0, 0, .55);
        }

        .loader-mask {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fff;
            z-index: 99999;
        }

        .loader {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 50px;
            height: 50px;
            font-size: 0;
            color: #00c9d0;
            display: inline-block;
            margin: -25px 0 0 -25px;
            text-indent: -9999em;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
        }

        .lead {
            font-size: 13px;
        }

        .loader div {
            background-color: #373373ad;
            display: inline-block;
            float: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 50px;
            height: 50px;
            opacity: 0.5;
            border-radius: 50%;
            -webkit-animation: ballPulseDouble 2s ease-in-out infinite;
            animation: ballPulseDouble 2s ease-in-out infinite;
        }

        .loader div:last-child {
            -webkit-animation-delay: -1s;
            animation-delay: -1s;
        }

        @-webkit-keyframes ballPulseDouble {

            0%,
            100% {
                -webkit-transform: scale(0);
                transform: scale(0);
            }

            50% {
                -webkit-transform: scale(1);
                transform: scale(1);
            }
        }

        @keyframes ballPulseDouble {

            0%,
            100% {
                -webkit-transform: scale(0);
                transform: scale(0);
            }

            50% {
                -webkit-transform: scale(1);
                transform: scale(1);
            }
        }


        /* new css updates  */
        #megaMenu li,
        #megaMenu ul {
            list-style: none;
            padding: 6px !important;
            margin: 0;
        }

        .mega-sub-menu-ul {
            position: fixed !important;
            top: 175px !important;
            height: 62vh !important;
            width: 66% !important;
            overflow-y: scroll;
        }

        .mega-menu--multiLevel>li>[aria-haspopup=true]~ul {
            /*left: 36.333333% !important;*/
            width: 100%;
        }

        @media screen and (min-width: 951px) {
            .mega-menu--multiLevel2>li>[aria-haspopup=true]~ul {
                left: 33.33333333% !important;
                width: 60% !important;
            }
        }

        .menu-link {
            padding: 20px 0 12px 0;
            background: #fff;
            color: #777 !important;
            position: relative;
            z-index: 1;
        }


        .make-compact .item-list .add-title {
            height: auto;
            padding: 5px 0;
        }

        input.form-control.is-invalid {
            z-index: 1 !important;
        }

        /* width */
        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .mega-menu-link,
        .menu-list-link {
            padding: 5px 0px !important;
        }
    </style>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-J7EN1M5B31"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-J7EN1M5B31');
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KPXJZ9CW');</script>
<!-- End Google Tag Manager -->

</head>

<body class="skin">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KPXJZ9CW"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Back to top button -->
<a id="button-back-top"><i class="bi bi-chevron-up"></i></a>

<div id="loader" class="loader-container">
        <div class="loader-mask">
            <div class="loader">
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
    $(document).ready(function(){
    $(".preloader").fadeOut();
    })
    </script>

    <div id="wrapper top-main-wrapper" class="top-main-wrapper">

        @section('header')
            @includeFirst([
                config('larapen.core.customizedViewPath') . 'layouts.inc.header',
                'layouts.inc.header',
            ])
        @show

        @section('search')
        @show

        @section('wizard')
        @show

        @if (isset($siteCountryInfo))
            <div class="p-0 mt-lg-4 mt-md-3 mt-3"></div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning alert-dismissible mb-3">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="{{ t('Close') }}"></button>
                            {!! $siteCountryInfo !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')

        @section('info')
        @show

        @includeFirst([
            config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.auto',
            'layouts.inc.advertising.auto',
        ])

        @section('footer')
            @includeFirst([
                config('larapen.core.customizedViewPath') . 'layouts.inc.footer',
                'layouts.inc.footer',
            ])
        @show

    </div>

    @section('modal_location')
    @show
    @section('modal_abuse')
    @show
    @section('modal_message')
    @show

    @includeWhen(!auth()->check(), 'auth.login.inc.modal')
    @includeFirst([
        config('larapen.core.customizedViewPath') . 'layouts.inc.modal.change-country',
        'layouts.inc.modal.change-country',
    ])
    @includeFirst([
        config('larapen.core.customizedViewPath') . 'layouts.inc.modal.error',
        'layouts.inc.modal.error',
    ])
    @include('cookie-consent::index')

    @if (config('plugins.detectadsblocker.installed'))
        @if (view()->exists('detectadsblocker::modal'))
            @include('detectadsblocker::modal')
        @endif
    @endif

    @include('common.js.init')

    <script>
        var countryCode = '{{ config('country.code', 0) }}';
        var timerNewMessagesChecking = {{ (int) config('settings.other.timer_new_messages_checking', 0) }};

        /* Complete langLayout translations */
        langLayout.hideMaxListItems = {
            'moreText': "{{ t('View More') }}",
            'lessText': "{{ t('View Less') }}"
        };
        langLayout.select2 = {
            errorLoading: function() {
                return "{!! t('The results could not be loaded') !!}"
            },
            inputTooLong: function(e) {
                var t = e.input.length - e.maximum,
                    n = {!! t('Please delete X character') !!};
                return t != 1 && (n += 's'), n
            },
            inputTooShort: function(e) {
                var t = e.minimum - e.input.length,
                    n = {!! t('Please enter X or more characters') !!};
                return n
            },
            loadingMore: function() {
                return "{!! t('Loading more results') !!}"
            },
            maximumSelected: function(e) {
                var t = {!! t('You can only select N item') !!};
                return e.maximum != 1 && (t += 's'), t
            },
            noResults: function() {
                return "{!! t('No results found') !!}"
            },
            searching: function() {
                return "{!! t('Searching') !!}"
            }
        };
        var loadingWd = '{{ t('loading_wd') }}';

        {{-- The app's default auth field --}}
        var defaultAuthField = '{{ old('auth_field', getAuthField()) }}';
        var phoneCountry = '{{ config('country.code') }}';

        {{-- Others global variables --}}
        var fakeLocationsResults = "{{ config('settings.list.fake_locations_results', 0) }}";
        var stateOrRegionKeyword = "{{ t('area') }}";
        var errorText = {
            errorFound: "{{ t('error_found') }}"
        };
        var refreshBtnText = "{{ t('refresh') }}";
    </script>

    @stack('before_scripts_stack')
    @yield('before_scripts')

    <script src="{{ url('common/js/intl-tel-input/countries.js') . getPictureVersion() }}"></script>



    <script src="{{ url('js/scroll-top.js') }}"></script>
    <script src="{{ url('js/app.js') }}"></script>
    @if (config('settings.optimization.lazy_loading_activation') == 1)
        <script src="{{ url('assets/plugins/lazysizes/lazysizes.min.js') }}" async=""></script>
    @endif
    @if (file_exists(public_path() . '/assets/plugins/select2/js/i18n/' . config('app.locale') . '.js'))
        <script src="{{ url('assets/plugins/select2/js/i18n/' . config('app.locale') . '.js') }}"></script>
    @endif
    @if (config('plugins.detectadsblocker.installed'))
        <script src="{{ url('assets/detectadsblocker/js/script.js') . getPictureVersion() }}"></script>
    @endif
    <script>
        $(document).ready(function() {
            {{-- Searchable Select Boxes --}}
            let largeDataSelect2Params = {
                width: '100%',
                dropdownAutoWidth: 'true'
            };
            {{-- Simple Select Boxes --}}
            let select2Params = {
                ...largeDataSelect2Params
            };
            {{-- Hiding the search box --}}
            select2Params.minimumResultsForSearch = Infinity;

            if (typeof langLayout !== 'undefined' && typeof langLayout.select2 !== 'undefined') {
                select2Params.language = langLayout.select2;
                largeDataSelect2Params.language = langLayout.select2;
            }

            $('.selecter').select2(select2Params);
            $('.large-data-selecter').select2(largeDataSelect2Params);

            {{-- Social Share --}}
            $('.share').ShareLink({
                title: '{{ addslashes(MetaTag::get('title')) }}',
                text: '{!! addslashes(MetaTag::get('title')) !!}',
                url: '{!! request()->fullUrl() !!}',
                width: 640,
                height: 480
            });

            {{-- Modal Login --}}
            @if (isset($errors) && $errors->any())
                @if ($errors->any() && old('quickLoginForm') == '1')
                    {{-- Re-open the modal if error occured --}}
                    openLoginModal();
                @endif
            @endif
        });
    </script>

    {{-- Google tag (gtag.js) --}}
    <script>
        {{-- $(document).ready(function() {
            var gtagScript = document.createElement('script');
            gtagScript.src = 'https://www.googletagmanager.com/gtag/js?id=G-0YLWP2GGK6';
            gtagScript.async = true;
            document.head.appendChild(gtagScript);
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'G-0YLWP2GGK6');
        }); --}}
    </script>



    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
 --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"
        integrity="sha512-efAcjYoYT0sXxQRtxGY37CKYmqsFVOIwMApaEbrxJr4RwqVVGw8o+Lfh/+59TU07+suZn1BWq4fDl5fdgyCNkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- <script src="{{ url('assets/js/mask/ ') }}"></script> --}}

    <script>
        var phoneRegex = /^(\+|\d{1,4})?[\s\-\.]?\(?\d{1,6}\)?[\s\-\.]?\d{1,10}[\s\-\.]?\d{1,10}$/;
        var phoneMask = {
            mask: '+99 999 9999 999',
            placeholder: '-',
            definitions: {
                '0': {
                    validator: '[0-9]'
                }
            }
        };
        $('.telephone').inputmask('+99 999 9999 999', {
            oncomplete: function() {
                // Add success class when input is correct
                console.log("tel input correct");
                $(this).addClass('success');
            },
            onincomplete: function() {
                console.log("tel input not correct");

                // Remove success class when input is incomplete
                $(this).removeClass('success');
            }
        });





        $(document).ready(function() {

            $('#acceptTerms2').change(function() {
                if ($(this).is(':checked')) {
                    $('.disable-social-information').hide();
                } else {
                    $('.disable-social-information').show();
                }
            });
            
            // Define your input mask
            var maskOptions = {
                mask: '', // Regular expression to match alphabetic characters
                placeholder: "", // No placeholder
                clearMaskOnLostFocus: false // Keep the mask visible even if the input field loses focus
            };

            // Apply the mask to the input field
            $('.alphabet').inputmask(maskOptions);

            // Add event listeners for success class
            $('.alphabet').on('input', function() {
                if ($(this).inputmask('isComplete')) {
                    $(this).addClass('success');
                } else {
                    $(this).removeClass('success');
                }
            });
        });
    </script>


    @stack('after_scripts_stack')
    @yield('after_scripts')
    @yield('captcha_footer')

    @include('customJS.drop-downJS')

    @if (isset($plugins) && !empty($plugins))
        @foreach ($plugins as $plugin)
            @yield($plugin . '_scripts')
        @endforeach
    @endif

    @if (config('settings.footer.tracking_code'))
        {!! printJs(config('settings.footer.tracking_code')) . "\n" !!}
    @endif
</body>

</html>
