{{--
 * LaraClassifier - Classified Ads Web Application
 * Copyright (c) BeDigit. All Rights Reserved
 *
 * Website: https://laraclassifier.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
--}}
@extends('layouts.master')
@php
$admin ??= null;
$city ??= null;
$cat ??= null;

$cats ??= [];

// Keywords
$keywords = rawurldecode(request()->get('q'));

// Category
$qCategory = data_get($cat, 'id', request()->get('c'));
// Location
$qLocationId = 0;
$qAdminName = null;
if (!empty($city)) {
$qLocationId = data_get($city, 'id') ?? 0;
$qLocation = data_get($city, 'name');
} else {
$qLocationId = request()->get('l');
$qLocation = request()->get('location');
if (request()->filled('r')) {
$qAdminName = data_get($admin, 'name', request()->get('r'));
$isAdminCode = (bool) preg_match('#^[a-z]{2}\.(.+)$#i', $qAdminName);
$qLocation = !$isAdminCode ? t('area') . rawurldecode($qAdminName) : null;
}
}

$displayStatesSearchTip = config('settings.list.display_states_search_tip');
@endphp
@php
$apiResult ??= [];
$apiExtra ??= [];
$count = (array) data_get($apiExtra, 'count');
$posts = (array) data_get($apiResult, 'data');
$totalPosts = (int) data_get($apiResult, 'meta.total', 0);
$tags = (array) data_get($apiExtra, 'tags');

$postTypes ??= [];
$orderByOptions ??= [];
$displayModes ??= [];
@endphp

@section('search')
@parent
<div class="container">
    <h1 class="text-center title-3 my-3 p-0 mobile-font-size-heading custom-search-heading">
        Advanced Search
    </h1>
</div>
@endsection

@section('content')

<style>
    @media (min-width: 992px) {
        .col-lg-2 {
            width: 19.99999%;
        }

        #trigger-div {
            padding-right: 16px;
        }

        .your-ad-here {
            display: block !important;
        }
    }

    .btn-primary {
        border-color: #23222f !important;
    }

    .third-row-nav-buttons .owl-nav.disabled {
        display: flex;
    }

    .hide-background-color {
        border-bottom: none;
        background-color: transparent;
    }

    .hide-border {
        background-color: #f8f9f9;
        border: none;
        /* #ebebeb */
    }

    .light .featured-list-slider span.price {
        color: #f38520 !important;
    }

    .featured-list-slider .owl-nav i.home-page-gallary-nav {
        color: white;
        font-size: 16px;
        background: rgb(55, 168, 100);
        border: none;
        border-radius: 26.5px;
        cursor: pointer;
        height: 30px;
        opacity: .9;
        padding: 0;
        width: 30px;
        transition: opacity .2s ease-in-out;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        align-content: center;
        justify-content: center;
        align-items: center;
    }

    .your-ad-here {
        float: right;
    }

    a.custom-column {
        padding: 0px !important;
        margin: 0px !important;
        border-radius: 4px;
        background-color: #ffffff;
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        text-decoration: none;
        color: #3e4153;
        font-weight: 700;
        display: block;
        flex: 1;
        height: 100%;
        position: relative;
        width: 100%;
        -webkit-transition: all .1s ease-in;
        -moz-transition: all ease-in .1s;
        transition: all .1s ease-in;
    }

    .featured-list-slider .owl-nav i.fas.fa-angle-right.home-page-gallary-nav {
        position: absolute;
        top: 30%;
        right: 2px;
    }

    .featured-list-slider .owl-nav i.fas.fa-angle-left.home-page-gallary-nav {
        position: absolute;
        top: 30%;
        left: 2px;
    }

    .featured-list-slider .owl-nav button {
        margin: 100px;
    }

    /* Add CSS to reduce the height and spacing of the rows */
    #featured-list-slider {
        padding: 10px;
        margin-bottom: 10px;
        max-height: 300px;
        overflow: hidden;
    }

    .owl-theme .owl-nav {
        margin-top: 10px;
    }

    .item-margin {
        margin-top: 12px !important;
        margin-bottom: 1px !important;
    }

    .form-select,
    .form-control,
    .select2-container--default .select2-selection--single {
        border-radius: 0px !important;
    }
</style>
<style>
    @media(max-width:450px) {
        .owl-carousel .owl-stage {
            width: 99999px !important;
        }
    }

    .spinner {
        margin: 0 auto 0;
        width: 70px;
        text-align: center;
    }

    .spinner>div {
        width: 18px;
        height: 18px;
        background-color: #373373ad;
        border-radius: 100%;
        display: inline-block;
        -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
        animation: sk-bouncedelay 1.4s infinite ease-in-out both;
    }

    .spinner .bounce1 {
        -webkit-animation-delay: -0.32s;
        animation-delay: -0.32s;
    }

    .spinner .bounce2 {
        -webkit-animation-delay: -0.16s;
        animation-delay: -0.16s;
    }

    @-webkit-keyframes sk-bouncedelay {

        0%,
        80%,
        100% {
            -webkit-transform: scale(0);
        }

        40% {
            -webkit-transform: scale(1);
        }
    }

    @keyframes sk-bouncedelay {

        0%,
        80%,
        100% {
            -webkit-transform: scale(0);
            transform: scale(0);
        }

        40% {
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }
</style>

<div class="main-container custom-search-main my-5">

    @if (session()->has('flash_notification'))
    @includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
    <?php $paddingTopExists = true; ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                @include('flash::message')
            </div>
        </div>
    </div>
    @endif

    <div class="container">

        <form action="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}" method="GET">

            <div class="row m-0">
                <div class="col-12 py-3">

                    <div class="row gx-1 gy-1">
                        <div class="col-xl-12">
                            <div class="inner">
                                <h2>
                                    <span class="title-3">
                                        Please enter in your search criteria below:
                                    </span>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="row gx-1 gy-1 pb-3">

                        <div class="col-xl-4 col-md-6 col-sm-12 col-12">
                            <input name="q" class="form-control keyword" type="text" placeholder="Keyword(s) Search: " value="{{ $keywords }}">
                        </div>

                        <div class="col-xl-4 col-md-3 col-sm-12 col-12">
                            <select id="matching" name="matching" class="form-control selecter">
                                <option value="1" selected>Partial Word Match</option>
                                <option value="2">Match Whole Words</option>
                                <option value="3">By Item # Only</option>
                            </select>
                        </div>

                        <div class="col-xl-4 col-md-3 col-sm-12 col-12">
                            <select name="#" class="form-control selecter">
                                <option value="Auctions And Classifieds">Auctions And Classifieds</option>
                                <option value="Classifieds Only">Classifieds Only</option>
                                <option value="Auctions Only">Auctions Only</option>
                                <option value="Only Auctions Using Buy Now">Only Auctions Using Buy Now</option>
                            </select>
                        </div>

                    </div>

                    <div class="row gx-1 gy-1 pb-3">

                        <div class="col-xl-3 col-md-6 col-sm-12 col-12">
                            <div class="form-check">
                                <div class="p-2 custom-form-check">
                                    <input class="form-check-input" type="checkbox" name="search_title" value="1" id="search_title" />
                                    Search Title
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-3 col-sm-12 col-12">
                            <div class="form-check">
                                <div class="p-2 custom-form-check">
                                    <input class="form-check-input" type="checkbox" name="search_description" value="1" id="search_description" />
                                    Search description
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-3 col-sm-12 col-12">
                            <div class="form-check">
                                <div class="p-2 custom-form-check">
                                    <input class="form-check-input" type="checkbox" name="listing_hours" value="1" id="exp_24_hours" / disabled>
                                    Only show listings ending in the next 24 hours
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-2 col-sm-12 col-12">
                            <button class="btn btn-block btn-primary">
                                <i class="fa fa-search"></i> <strong>{{ t('find') }}</strong>
                            </button>
                        </div>

                    </div>

                    <div class="row gx-1 gy-1">
                        <div class="col-xl-12">
                            <div class="inner">
                                <h2>
                                    <span style="font-weight: 700;" class="title-3">
                                        By Category:
                                    </span>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="row gx-1 gy-1 pb-3">

                        <div class="col-xl-4 col-md-6 col-sm-12 col-12 custom-spacing">
                            <select class="form-select selectbox-advance-search-categories " name="c" size="10" aria-label="size 3 select example">
                                @if (!empty($categories))
                                @foreach ($categories->sortBy('name') as $itemCat)
                                @if ($itemCat->parent_id == null)
                                <option value="{{ data_get($itemCat, 'id') }}" @selected($qCategory==data_get($itemCat, 'id' ))>
                                    {{ data_get($itemCat, 'name') }}
                                </option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-xl-4 col-md-6 col-sm-12 col-12 custom-spacing rounded col-advance-search-sub-categories d-none">
                            <select class="form-select get-advance-search-sub-categories" name="c" size="10" aria-label="size 3 select example">
                                {{-- ajax call --}}
                            </select>
                        </div>

                        <div class="col-xl-4 col-md-6 col-sm-12 col-12 custom-spacing rounded col-advance-search-sub-sub-categories d-none">
                            <select class="form-select get-advance-search-sub-sub-categories" name="c" size="10" aria-label="size 3 select example">
                                {{-- ajax call --}}
                            </select>
                        </div>

                    </div>

                    <div class="row gx-1 gy-1">
                        <div class="col-xl-12">
                            <div class="inner">
                                <h2>
                                    <span style="font-weight: 700;" class="title-3">
                                        Location:
                                    </span>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="row gx-1 gy-1 pb-3">

                        {{-- COUNTRY --}}
                        <div class="col-xl-4 col-md-4 col-sm-12 col-12">
                            <select class="form-select px-3 search_country py-2" name="search_country" aria-label="Default select example">
                                <option selected disabled>Select Country</option>
                                @foreach ($countries as $code => $country)
                                @if (str($country->get('code')) != 'LP')
                                <option value="{{ str($country->get('code')) }}">
                                    {{ str($country->get('name')) }}
                                </option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                        {{-- PROVINCE / STATE --}}
                        <div class="col-xl-4 col-md-4 col-sm-12 col-12 col_search_province d-none">
                            <select class="form-select px-3 search_province py-2" name="search_province" aria-label="Default select example">
                                {{-- Provinces jquery append option --}}
                            </select>
                        </div>

                        {{-- REGION --}}
                        <div class="col-xl-4 col-md-4 col-sm-12 col-12 col_search_region d-none">
                            <select class="form-select px-3 search_region py-2" name="search_region" aria-label="Default select example">
                                {{-- Regions jquery append option --}}
                            </select>
                        </div>

                        {{-- CITY --}}
                        <div class="col-xl-4 col-md-4 col-sm-12 col-12 col_search_city d-none">
                            <select class="form-select px-3 search_city py-2" name="search_city" aria-label="Default select example">
                                {{-- Cities jquery append option --}}
                            </select>
                        </div>

                        {{-- NEIGHBHOUR --}}
                        <div class="col-xl-4 col-md-4 col-sm-12 col-12 col_search_neighbour d-none">
                            <select class="form-select px-3 search_neighbour py-2" name="search_neighbour" aria-label="Default select example">
                                {{-- Neighbours jquery append option --}}
                            </select>
                        </div>

                    </div>

                    <div class="row gx-1 gy-1 pb-3">
                        <div class="col-12 col-xl-12">
                            <div class="inner pt-1">
                                <span class="title-3 custom-business-type">
                                    By Business Type:
                                </span>
                                <label class="radio-inline" for="Individual">
                                    <input type="radio" name="type" value="1" id="Individual">
                                    <span class="custom-radio">Individual</span>
                                </label>
                                <label class="radio-inline" for="Business">
                                    <input type="radio" name="type" value="2" id="Business">
                                    <span class="custom-radio">Business</span>
                                </label>
                                <label class="radio-inline" for="Either">
                                    <input type="radio" name="type" value="" id="Either" checked>
                                    <span class="custom-radio">Either</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row gx-1 gy-1 pb-3">
                        <div class="col-12 col-xl-12">
                            <div class="inner">
                                <h2>
                                    <span style="font-weight: 700;" class="title-3">
                                        By Price Range:
                                    </span>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="row gx-1 gy-1 pb-3">

                        <div class="col-xl-12 col-md-12 col-sm-12 col-12 advance-search-price">
                            @includeFirst([
                            config('larapen.core.customizedViewPath') . 'search.inc.sidebar.custom-price',
                            'search.inc.sidebar.custom-price',
                            ])
                        </div>

                    </div>

                    {{-- Advance Search Button --}}
                    <div class="row gx-1 gy-1 pt-5">

                        <div class="col-xl-12 col-md-2 col-sm-12 col-12 text-center">
                            <button type="submit" class="btn btn-primary px-5 py-3">
                                <strong> Advance Search </strong>
                            </button>
                            @if (session()->has('business_type') ||
                            session()->has('keyword') ||
                            session()->has('matching') ||
                            session()->has('search_title') ||
                            session()->has('search_description') ||
                            session()->has('business_type') ||
                            session()->has('keyword') ||
                            session()->has('matching') ||
                            session()->has('search_title') ||
                            session()->has('search_description') ||
                            session()->has('search_category') ||
                            session()->has('search_sub_category') ||
                            session()->has('search_sub_sub_category') ||
                            session()->has('search_country') ||
                            session()->has('search_province') ||
                            session()->has('search_region') ||
                            session()->has('search_city') ||
                            session()->has('search_neighbour'))
                            <a href="{{ route('get-clear-advance-search-session') }}" class="btn btn-dark" id="clear-section">
                                Clear Section
                            </a>
                            @endif
                        </div>

                    </div>

                </div>
            </div>
        </form>

    </div>

</div>

<div class="wide-container">
    <div class="row">
        <div class="col-xl-12">
            <div class="content-box layout-section theme-recommended-2 pt-4 px-3">
                <div class="row row-featured row-featured-category">
                    <div class="col-xl-12 box-title hide-background-color head-theme-recommended">
                        <div class="inner">
                            <h2>
                                <span style="font-weight: 700;" class="title-3">
                                    Homepage Gallery <i class="bi bi-question-circle-fill"></i>
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div style="clear: both"></div>
                    <div id="trigger-div" class="relative content featured-list-row clearfix">
                        <div class="row featured-list-slider">
                            @foreach ($customPosts as $index => $post)
                            @php
                            $price = data_get($post, 'price_formatted');
                            @endphp
                            <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                                <div class="item item-margin">
                                    <a href="{{ \App\Helpers\UrlGen::post($post) }}" class="custom-column">
                                        <span class="item-carousel-thumb">
                                            <span class="photo-count fa fa-camera">
                                                {{ data_get($post, 'count_pictures') }}
                                            </span>
                                            @php
                                            echo imgTag(data_get($post, 'picture'), 'medium', [
                                            'style' => 'border: 1px; border-radius:6px; margin-top: 0px; width: 100%; height: 160px;',
                                            'alt' => data_get($post, 'title'),
                                            ]);
                                            @endphp
                                        </span>
                                        <span class="item-name text-left mx-3" style="font-size: 0.74rem;">{{ str(data_get($post, 'title'))->limit(30) }}</span>
                                        <hr>
                                        <div class="d-flex justify-content-between m-3">
                                            <span class="price text-left" style="color: #131313;">
                                                {!! $price !!}
                                            </span>
                                            <span class="text-right" style="color: #131313;">
                                                <i class="fas fa-star" style="color: #fdc60a;"></i>
                                                {!! data_get($post, 'rating_cache') !!}
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @if (($index + 1) % 5 == 0)
                        </div>
                        <div class="row featured-list-slider">
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="single-brand-item text-center">
                        <div id="loading" class="spinner py-4">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('modal_location')
@includeFirst([
config('larapen.core.customizedViewPath') . 'layouts.inc.modal.location',
'layouts.inc.modal.location',
])
@endsection
@section('after_scripts')
<script>
    $(document).ready(function() {
        $('#postType a').click(function(e) {
            e.preventDefault();
            var goToUrl = $(this).attr('href');
            redirect(goToUrl);
        });
        $('#orderBy').change(function() {
            var goToUrl = $(this).val();
            redirect(goToUrl);
        });

        $('.selectbox-advance-search-categories').change(function() {
            $.ajax({
                type: "get",
                url: "{{ route('get-advance-search-categories') }}",
                data: {
                    catID: $('.selectbox-advance-search-categories').val(),
                },
                success: function(response) {
                    if (response.search_advance_categories_html && response
                        .search_advance_categories_html != null && response
                        .search_advance_categories_html != "") {
                        $(".get-advance-search-sub-categories option").remove();
                        $(".col-advance-search-sub-categories").removeClass("d-none");
                        $(".col-advance-search-sub-sub-categories").addClass("d-none");
                        $('.get-advance-search-sub-categories').append(response
                            .search_advance_categories_html);
                    }
                },
            });
        });

        $('.get-advance-search-sub-categories').change(function() {
            $.ajax({
                type: "get",
                url: "{{ route('get-advance-search-sub-categories') }}",
                data: {
                    subCatID: $('.get-advance-search-sub-categories').val(),
                },
                success: function(response) {
                    if (response.search_advance_sub_categories_html && response
                        .search_advance_sub_categories_html != null && response
                        .search_advance_sub_categories_html != "") {
                        $(".get-advance-search-sub-sub-categories option").remove();
                        $(".col-advance-search-sub-sub-categories").removeClass("d-none");
                        $('.get-advance-search-sub-sub-categories').append(response
                            .search_advance_sub_categories_html);
                    } else {
                        $(".col-advance-search-sub-sub-categories").addClass("d-none");
                    }
                },
            });
        });

        $('.search_country').change(function() {
            $.ajax({
                type: "get",
                url: "{{ route('get-advance-search-location') }}",
                data: {
                    countryCode: $('.search_country').val(),
                },
                success: function(response) {
                    if (response.provinces && response.provinces != null && response
                        .provinces != "") {
                        $(".search_province option").remove();
                        $(".col_search_province").removeClass("d-none");
                        $(".col_search_region").addClass("d-none");
                        $(".col_search_city").addClass("d-none");
                        $(".col_search_neighbour").addClass("d-none");
                        $('.search_province').append(
                            '<option selected disabled>Select Provinces / State</option>',
                            response.provinces);
                    } else {
                        $(".col_search_province").addClass("d-none");
                    }
                },
            });
        });

        $('.search_province').change(function() {
            $.ajax({
                type: "get",
                url: "{{ route('get-advance-search-location') }}",
                data: {
                    provinceID: $('.search_province').val(),
                },
                success: function(response) {
                    if (response.regions && response.regions != null && response.regions !=
                        "") {
                        $(".search_region option").remove();
                        $(".col_search_region").removeClass("d-none");
                        $(".col_search_city").addClass("d-none");
                        $(".col_search_neighbour").addClass("d-none");
                        $('.search_region').append(
                            '<option selected disabled>Select Region</option>', response
                            .regions);
                    } else {
                        $(".col_search_region").addClass("d-none");
                    }
                },
            });
        });

        $('.search_region').change(function() {
            $.ajax({
                type: "get",
                url: "{{ route('get-advance-search-location') }}",
                data: {
                    regionID: $('.search_region').val(),
                },
                success: function(response) {
                    if (response.cities && response.cities != null && response.cities !=
                        "") {
                        $(".search_city option").remove();
                        $(".col_search_city").removeClass("d-none");
                        $(".col_search_neighbour").addClass("d-none");
                        $('.search_city').append(
                            '<option selected disabled>Select City</option>', response
                            .cities);
                    } else {
                        $(".col_search_city").addClass("d-none");
                    }
                },
            });
        });

        $('.search_city').change(function() {
            $.ajax({
                type: "get",
                url: "{{ route('get-advance-search-location') }}",
                data: {
                    cityID: $('.search_city').val(),
                },
                success: function(response) {
                    if (response.neighbours && response.neighbours != null && response
                        .neighbours != "") {
                        $(".search_neighbour option").remove();
                        $(".col_search_neighbour").removeClass("d-none");
                        $('.search_neighbour').append(
                            '<option selected disabled>Select Neighbour</option>',
                            response.neighbours);
                    } else {
                        $(".col_search_neighbour").addClass("d-none");
                    }
                },
            });
        });

        $('#matching').on('change', function() {
            if ($(this).val() === '3') {
                $('#search_title').prop('disabled', true);
                $('#search_description').prop('disabled', true);
            } else if ($(this).val() === '2') {
                $('#search_title').prop('disabled', false);
                $('#search_description').prop('disabled', true);
            } else {
                $('#search_title').prop('disabled', false);
                $('#search_description').prop('disabled', false);
            }
        });

    });
</script>

<script>
    $(document).ready(function() {
        var currentIndex = 0;
        var isLoading = false;
        var rows = $(".featured-list-slider");
        rows.slice(2).hide();

        function showNextRow() {
            if (currentIndex < rows.length - 1) {
                $("#loading").show();
                setTimeout(function() {
                    $(rows[currentIndex + 1]).fadeIn();
                    currentIndex++;
                    $("#loading").hide();
                    isLoading = false;
                }, 1000);
            }
        }

        function handleScroll() {
            var footerDiv = $(".featured-list-slider:visible:last");
            if (!isLoading && footerDiv.length && isScrolledIntoView(footerDiv)) {
                isLoading = true;
                showNextRow();
            }
        }

        function isScrolledIntoView(elem) {
            var docViewTop = $(window).scrollTop();
            var docViewBottom = docViewTop + $(window).height();
            var elemTop = $(elem).offset().top;
            return elemTop <= docViewBottom;
        }
        showNextRow();
        $(window).scroll(handleScroll);
    });
</script>
@endsection