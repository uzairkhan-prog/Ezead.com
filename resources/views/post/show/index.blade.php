@extends('layouts.master')

@php
    $post ??= [];
    $catBreadcrumb ??= [];
    $topAdvertising ??= [];
    $bottomAdvertising ??= [];
@endphp

@section('content')


{!! csrf_field() !!}
    <input type="hidden" id="postId" name="post_id" value="{{ data_get($post, 'id') }}">

    @if (session()->has('flash_notification'))
        @includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
        @php
            $paddingTopExists = true;
        @endphp
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @include('flash::message')
                </div>
            </div>
        </div>
        @php
            session()->forget('flash_notification.message');
        @endphp
    @endif

    {{-- Archived listings message --}}
    @if (!empty(data_get($post, 'archived_at')))
        @includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
        @php
            $paddingTopExists = true;
        @endphp

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        {!! t('This listing has been archived') !!}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="main-container">

        @if (!empty($topAdvertising))
            @includeFirst(
                [
                    config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.top',
                    'layouts.inc.advertising.top',
                ],
                ['paddingTopExists' => $paddingTopExists ?? false]
            )
            @php
                $paddingTopExists = false;
            @endphp
        @endif

        <div class="container {{ !empty($topAdvertising) ? 'mt-3' : 'mt-2' }} printer-container">
            <div class="row">
                <div class="col-md-12">

                    <nav aria-label="breadcrumb" role="navigation" class="float-start">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ config('country.name') }}</a></li>
                            @if (is_array($catBreadcrumb) && count($catBreadcrumb) > 0)
                                @foreach ($catBreadcrumb as $key => $value)
                                    <li class="breadcrumb-item">
                                        <a href="{{ $value->get('url') }}">
                                            {!! $value->get('name') !!}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ str(data_get($post, 'title'))->limit(70) }}</li>
                        </ol>
                    </nav>

                    <div class="float-end backtolist printer-hide">
                        <a href="{{ rawurldecode(url()->previous()) }}"><i class="fa fa-angle-double-left"></i>
                            {{ t('back_to_results') }}</a>
                    </div>

                </div>
            </div>
        </div>

        <div class="container printer-container">
            <div class="row">
                <div class="col-lg-9 page-content col-thin-right">
                    @php
                        $innerBoxStyle = !auth()->check() && plugin_exists('reviews') ? 'overflow: visible;' : '';
                    @endphp
                    <div class="inner inner-box items-details-wrapper pb-0" style="{{ $innerBoxStyle }}">
                        <h1 class="h4 fw-bold enable-long-words">
                            <strong>
                                <a href="{{ \App\Helpers\UrlGen::post($post) }}" title="{{ data_get($post, 'title') }}">
                                    {{ data_get($post, 'title') }}
                                </a>
                            </strong>
                            @if (config('settings.single.show_listing_types'))
                                @if (!empty(data_get($post, 'postType')))
                                    <small
                                        class="label label-default adlistingtype">{{ data_get($post, 'postType.name') }}</small>
                                @endif
                            @endif
                            @if (data_get($post, 'featured') == 1 && !empty(data_get($post, 'latestPayment.package')))
                                <i class="fas fa-check-circle"
                                    style="color: {{ data_get($post, 'latestPayment.package.ribbon') }};"
                                    data-bs-placement="bottom" data-bs-toggle="tooltip"
                                    title="{{ data_get($post, 'latestPayment.package.short_name') }}"></i>
                            @endif
                        </h1>
{{--                        <span class="info-row">--}}
{{--                            @if (!config('settings.single.hide_dates'))--}}
{{--                                <span class="date"{!! config('lang.direction') == 'rtl' ? ' dir="rtl"' : '' !!}>--}}
{{--                                    <i class="far fa-clock"></i> {!! data_get($post, 'created_at_formatted') !!}--}}
{{--                                </span>&nbsp;--}}
{{--                            @endif--}}
{{--                            <span class="category"{!! config('lang.direction') == 'rtl' ? ' dir="rtl"' : '' !!}>--}}
{{--                                <i class="bi bi-folder"></i>--}}
{{--                                {{ data_get($post, 'category.parent.name', data_get($post, 'category.name')) }}--}}
{{--                            </span>&nbsp;--}}

{{--                            --}}{{-- custom Hide Location on Create Post --}}
{{--                            --}}{{-- <span class="item-location"{!! config('lang.direction') == 'rtl' ? ' dir="rtl"' : '' !!}>--}}
{{--                                <i class="bi bi-geo-alt"></i> {{ data_get($post, 'city.name') }}--}}
{{--                            </span>&nbsp; --}}

{{--                            --}}{{-- Start Custom Add --}}
{{--                            @php--}}
{{--                                $locationData = [--}}
{{--                                    'neighbour' => $neighbour,--}}
{{--                                    'new_city' => $new_city,--}}
{{--                                    'region' => $region,--}}
{{--                                    'province' => $province,--}}
{{--                                ];--}}
{{--                                $countryCode = data_get($post, 'country_code');--}}
{{--                                $countryCodes = ['CA' => 'Canada', 'AU' => 'Australia', 'GB' => 'United Kingdom', 'US' => 'United States'];--}}
{{--                                $country = $countryCodes[$countryCode] ?? 'No Location';--}}
{{--                            @endphp--}}
{{--                            --}}{{-- Custom Location on Create Post --}}
{{--                            @if (empty(array_filter($locationData)))--}}
{{--                                <span class="item-location"{!! config('lang.direction') == 'rtl' ? ' dir="rtl"' : '' !!}>--}}
{{--                                    <i class="bi bi-geo-alt"></i> {{ $country }}--}}
{{--                                </span>&nbsp;--}}
{{--                            @else--}}
{{--                                @foreach($locationData as $location)--}}
{{--                                    @if (!empty($location))--}}
{{--                                        <span class="item-location"{!! config('lang.direction') == 'rtl' ? ' dir="rtl"' : '' !!}>--}}
{{--                                            <i class="bi bi-geo-alt"></i> {{ $location }}--}}
{{--                                        </span>&nbsp;--}}
{{--                                        @break--}}
{{--                                    @endif--}}
{{--                                @endforeach--}}
{{--                            @endif--}}
{{--                            --}}{{-- End Custom Add --}}

{{--                            <span class="category"{!! config('lang.direction') == 'rtl' ? ' dir="rtl"' : '' !!}>--}}
{{--                                <i class="bi bi-eye"></i>--}}
{{--                                {{ \App\Helpers\Number::short(data_get($post, 'visits')) .--}}
{{--                                    ' ' .--}}
{{--                                    trans_choice('global.count_views', getPlural(data_get($post, 'visits')), [], config('app.locale')) }}--}}
{{--                            </span>--}}

{{--                            <span class="category float-md-end"{!! config('lang.direction') == 'rtl' ? ' dir="rtl"' : '' !!}>--}}
{{--                                {{ t('reference') }}: {{ hashId(data_get($post, 'id'), false, false) }}--}}
{{--                            </span>--}}
{{--                        </span>--}}

                        <div class="icon-container">
                            <button class="icon-btn share s_facebook" data-bs-toggle="tooltip" title="Share on Facebook">
                                <i class="fab fa-facebook"></i>
                            </button>
                            <button class="icon-btn share s_twitter" data-bs-toggle="tooltip" title="Share on Twitter">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button class="icon-btn share s_whatsapp" data-bs-toggle="tooltip" title="Share on WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </button>
                            <button class="icon-btn share s_linkedin" data-bs-toggle="tooltip" title="Share on LinkedIn">
                                <i class="fab fa-linkedin"></i>
                            </button>
                        </div>

                        <span class="info-row">
                            <script async src="https://cse.google.com/cse.js?cx=91b4bb4a046c344d6"></script>
                        </span>

                        @include('post.show.inc.pictures-slider')

                        @if (config('plugins.reviews.installed'))
                            @if (view()->exists('reviews::ratings-single'))
                                @include('reviews::ratings-single')
                            @endif
                        @endif

                        @includeFirst([
                            config('larapen.core.customizedViewPath') . 'post.show.inc.details',
                            'post.show.inc.details',
                        ])
                    </div>
                </div>

                <div class="col-lg-3 page-sidebar-right">
                    @includeFirst([
                        config('larapen.core.customizedViewPath') . 'post.show.inc.sidebar',
                        'post.show.inc.sidebar',
                    ])
                </div>
            </div>

        </div>

    </div>
@endsection
@php
    if (!session()->has('emailVerificationSent') && !session()->has('phoneVerificationSent')) {
        if (session()->has('message')) {
            session()->forget('message');
        }
    }
@endphp

@section('modal_message')
    @if (config('settings.single.show_security_tips') == '1')
        @includeFirst([
            config('larapen.core.customizedViewPath') . 'post.show.inc.security-tips',
            'post.show.inc.security-tips',
        ])
    @endif
    @if (auth()->check() || config('settings.single.guests_can_contact_authors') == '1')
        @includeFirst([
            config('larapen.core.customizedViewPath') . 'account.messenger.modal.create',
            'account.messenger.modal.create',
        ])
    @endif
@endsection

@section('after_styles')
    <style>
        .icon-btn {
            background: none;
            /*height: 50px;*/
            /*width:50px;*/
            color: #333;
            font-size: 1.5em;
            margin: 0 0.25rem;
            border: none;
            border-radius: 9999px;
        }
        .icon-btn:hover {
            color: #007bff;
        }
    </style>
@endsection

@section('before_scripts')
    <script>
        var showSecurityTips = '{{ config('settings.single.show_security_tips', '0') }}';
    </script>
@endsection

@section('after_scripts')
    @if (config('services.googlemaps.key'))
        {{-- More Info: https://developers.google.com/maps/documentation/javascript/versions --}}
        <script async src="https://maps.googleapis.com/maps/api/js?v=weekly&key={{ config('services.googlemaps.key') }}">
        </script>
    @endif

    <script>
        {{-- Favorites Translation --}}
        var lang = {
            labelSavePostSave: "{!! t('Save listing') !!}",
            labelSavePostRemove: "{!! t('Remove favorite') !!}",
            loginToSavePost: "{!! t('Please log in to save the Listings') !!}",
            loginToSaveSearch: "{!! t('Please log in to save your search') !!}"
        };

        $(document).ready(function() {
            {{-- Tooltip --}}
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[rel="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            @if (config('settings.single.show_listing_on_googlemap'))
                {{--
				let mapUrl = '{{ addslashes($mapUrl) }}';
				let iframe = document.getElementById('googleMaps');
				iframe.setAttribute('src', mapUrl);
				--}}
            @endif

            {{-- Keep the current tab active with Twitter Bootstrap after a page reload --}}
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                /* save the latest tab; use cookies if you like 'em better: */
                /* localStorage.setItem('lastTab', $(this).attr('href')); */
                localStorage.setItem('lastTab', $(this).attr('data-bs-target'));
            });
            {{-- Go to the latest tab, if it exists: --}}
            let lastTab = localStorage.getItem('lastTab');
            if (lastTab) {
                {{-- let triggerEl = document.querySelector('a[href="' + lastTab + '"]'); --}}
                let triggerEl = document.querySelector('button[data-bs-target="' + lastTab + '"]');
                if (typeof triggerEl !== 'undefined' && triggerEl !== null) {
                    let tabObj = new bootstrap.Tab(triggerEl);
                    if (tabObj !== null) {
                        tabObj.show();
                    }
                }
            }
        });
    </script>
@endsection
