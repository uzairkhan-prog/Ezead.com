@php
    $widget ??= [];
    $posts = (array) data_get($widget, 'posts');
    $totalPosts = (int) data_get($widget, 'totalPosts', 0);
    
    $sectionOptions ??= [];
    $hideOnMobile = data_get($sectionOptions, 'hide_on_mobile') == '1' ? ' hidden-sm' : '';
    $carouselEl = '_' . createRandomString(6);
@endphp
@if ($totalPosts > 0)
    @php
        $isFromHome = str_contains(Illuminate\Support\Facades\Route::currentRouteAction(), 'Web\HomeController');
    @endphp
    @if ($isFromHome)
        @includeFirst(
            [config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'],
            ['hideOnMobile' => $hideOnMobile]
        )
    @endif
    <div class="wide container{{ $isFromHome ? '' : ' my-3' }}{{ $hideOnMobile }}">
        <div class="row">
            <div class="col-xl-12">
                <div class="content-box layout-section mb-5">
                    <div class="row row-featured row-featured-category">
                        <div class="col-xl-12 box-title">
                            <div class="inner">
                                <h2>
                                    <span style="font-weight: 700;" class="title-3">
                                        Recommended for you
                                        <i class="fas fa-eye"></i>
                                    </span>
                                    <a href="{{ data_get($widget, 'link') }}" class="sell-your-item">
                                        See All <i class="fas fa-bars"></i>
                                    </a>
                                </h2>
                            </div>
                        </div>

                        <div style="clear: both"></div>

                        <div class="relative content featured-list-row clearfix hide-recommended-arrows-buttons">

                            <div class="large-12 columns">
                                <div class="no-margin featured-list-slider {{ $carouselEl }} owl-carousel owl-theme">

                                    {{-- @foreach (collect($posts)->sortByDesc(function ($post) {
            return data_get($post, 'visits');
        })->take(8) as $post)
                                    
                                            <div class="item px-2 my-4">
                                                <a href="{{ \App\Helpers\UrlGen::post($post) }}" class="custom-column">
                                                    <span class="item-carousel-thumb">
                                                        <span class="photo-count">
                                                            <i class="fa fa-camera"></i>
                                                            {{ data_get($post, 'count_pictures') }}
                                                        </span>
                                                        @php
                                                            echo imgTag(data_get($post, 'picture.filename'), 'medium', [
                                                                'style' => 'border: 1px border-radius: 50px solid #e7e7e7; margin-top: 0px; width: 100%; height: auto;',
                                                                'alt' => data_get($post, 'title'),
                                                            ]);
                                                        @endphp
                                                    </span>
                                                    <span class="item-name text-left mx-3" style="font-size: 0.74rem;">{{ str(data_get($post, 'title'))->limit(30) }}</span>
                                                    <span class="price m-3 text-left" style="color: #d5590e;">
                                                        {!! data_get($post, 'price_formatted') !!}
                                                    </span>
                                                </a>
                                            </div>
                                            
                                    @endforeach --}}

                                    @foreach (collect($posts)->sortByDesc(function ($post) {
            return data_get($post, 'visits');
        })->take(25) as $post)
                                        @php
                                            $price = data_get($post, 'price_formatted');
                                        @endphp
                                        @if (is_int($price) || (is_string($price) && !str_contains($price, 'Contact us') && !str_contains($price, 'Free')))
                                            <div class="item px-2 my-4">
                                                <a href="{{ \App\Helpers\UrlGen::post($post) }}" class="custom-column">
                                                    <span class="item-carousel-thumb">
                                                        <span class="photo-count">
                                                            <i class="fa fa-camera"></i>
                                                            {{ data_get($post, 'count_pictures') }}
                                                        </span>
                                                        @php
                                                            echo imgTag(data_get($post, 'picture.filename'), 'medium', [
                                                                'style' => 'border: 1px border-radius: 50px solid #e7e7e7; margin-top: 0px; width: 100%; height: auto;',
                                                                'alt' => data_get($post, 'title'),
                                                            ]);
                                                        @endphp
                                                    </span>
                                                    <span class="item-name text-left mx-3"
                                                        style="font-size: 0.74rem;">{{ str(data_get($post, 'title'))->limit(30) }}</span>
                                                    <span class="price m-3 text-left" style="color: #d5590e;">
                                                        {!! $price !!}
                                                    </span>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="content-box layout-section hide-border mb-5">
                    <div class="row row-featured row-featured-category">
                        <div class="col-xl-12 box-title hide-background-color">
                            <div class="inner">
                                <h2>
                                    <span style="font-weight: 700;" class="title-3">
                                        Homepage Gallery <i class="bi bi-question-circle-fill"></i>
                                    </span>
                                    <a href="{{ data_get($widget, 'link') }}" class="sell-your-item">
                                        See All <i class="fas fa-bars"></i>
                                    </a>
                                </h2>
                                <h2 class="your-ad-here">
                                    <a href="https://ezead.com/posts/create" class="sell-your-item"
                                        style="margin-right: 100px; font-weight: 500;color: #898989;text-decoration: underline;text-transform: capitalize;">
                                        Your Ad here
                                    </a>
                                </h2>
                            </div>
                        </div>

                        <div style="clear: both"></div>

                        <div class="relative content featured-list-row clearfix">

                            {{-- <div class="large-12 columns">
                                <div class="no-margin featured-list-slider {{ $carouselEl }} owl-carousel owl-theme">
                                    @foreach ($posts as $key => $post)
                                        <div class="item px-2 my-4">
                                            <a href="{{ \App\Helpers\UrlGen::post($post) }}" class="custom-column">
                                                <span class="item-carousel-thumb">
                                                    <span class="photo-count">
                                                        <i class="fa fa-camera"></i>
                                                        {{ data_get($post, 'count_pictures') }}
                                                    </span>
                                                    @php
                                                        echo imgTag(data_get($post, 'picture.filename'), 'medium', [
                                                            'style' => 'border: 1px border-radius: 50px solid #e7e7e7; margin-top: 0px; width: 100%; height: auto;',
                                                            'alt' => data_get($post, 'title'),
                                                        ]);
                                                    @endphp
                                                </span>
                                                <span class="item-name text-left mx-3"
                                                    style="font-size: 0.74rem;">{{ str(data_get($post, 'title'))->limit(30) }}</span>

                                                <span class="price m-3 text-left" style="color: #d5590e;">
                                                    {!! data_get($post, 'price_formatted') !!}
                                                </span>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div> --}}

                            <div class="large-12 columns">
                                <div
                                    class="my-3 no-margin featured-list-slider {{ $carouselEl }} owl-carousel owl-theme">
                                    @for ($i = 0; $i < 8 && $i < count($posts); $i++)
                                        @php
                                            $post = $posts[$i];
                                        @endphp
                                        <div class="item px-2 my-4">
                                            <a href="{{ \App\Helpers\UrlGen::post($post) }}" class="custom-column">
                                                <span class="item-carousel-thumb">
                                                    <span class="photo-count">
                                                        <i class="fa fa-camera"></i>
                                                        {{ data_get($post, 'count_pictures') }}
                                                    </span>
                                                    @php
                                                        echo imgTag(data_get($post, 'picture.filename'), 'medium', [
                                                            'style' => 'border: 1px border-radius: 50px solid #e7e7e7; margin-top: 0px; width: 100%; height: auto;',
                                                            'alt' => data_get($post, 'title'),
                                                        ]);
                                                    @endphp
                                                </span>
                                                <span class="item-name text-left mx-3"
                                                    style="font-size: 0.74rem;">{{ str(data_get($post, 'title'))->limit(30) }}</span>

                                                <span class="price m-3 text-left" style="color: #d5590e;">
                                                    {!! data_get($post, 'price_formatted') !!}
                                                </span>
                                            </a>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="large-12 columns">
                                <div
                                    class="my-3 no-margin featured-list-slider {{ $carouselEl }} owl-carousel owl-theme">
                                    @for ($i = 9; $i < 16 && $i < count($posts); $i++)
                                        @php
                                            $post = $posts[$i];
                                        @endphp
                                        <div class="item px-2 my-4">
                                            <a href="{{ \App\Helpers\UrlGen::post($post) }}" class="custom-column">
                                                <span class="item-carousel-thumb">
                                                    <span class="photo-count">
                                                        <i class="fa fa-camera"></i>
                                                        {{ data_get($post, 'count_pictures') }}
                                                    </span>
                                                    @php
                                                        echo imgTag(data_get($post, 'picture.filename'), 'medium', [
                                                            'style' => 'border: 1px border-radius: 50px solid #e7e7e7; margin-top: 0px; width: 100%; height: auto;',
                                                            'alt' => data_get($post, 'title'),
                                                        ]);
                                                    @endphp
                                                </span>
                                                <span class="item-name text-left mx-3"
                                                    style="font-size: 0.74rem;">{{ str(data_get($post, 'title'))->limit(30) }}</span>

                                                <span class="price m-3 text-left" style="color: #d5590e;">
                                                    {!! data_get($post, 'price_formatted') !!}
                                                </span>
                                            </a>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="large-12 columns">
                                <div
                                    class="my-3 no-margin featured-list-slider {{ $carouselEl }} owl-carousel owl-theme">
                                    @for ($i = 17; $i < 24 && $i < count($posts); $i++)
                                        @php
                                            $post = $posts[$i];
                                        @endphp
                                        <div class="item px-2 my-4">
                                            <a href="{{ \App\Helpers\UrlGen::post($post) }}" class="custom-column">
                                                <span class="item-carousel-thumb">
                                                    <span class="photo-count">
                                                        <i class="fa fa-camera"></i>
                                                        {{ data_get($post, 'count_pictures') }}
                                                    </span>
                                                    @php
                                                        echo imgTag(data_get($post, 'picture.filename'), 'medium', [
                                                            'style' => 'border: 1px border-radius: 50px solid #e7e7e7; margin-top: 0px; width: 100%; height: auto;',
                                                            'alt' => data_get($post, 'title'),
                                                        ]);
                                                    @endphp
                                                </span>
                                                <span class="item-name text-left mx-3"
                                                    style="font-size: 0.74rem;">{{ str(data_get($post, 'title'))->limit(30) }}</span>

                                                <span class="price m-3 text-left" style="color: #d5590e;">
                                                    {!! data_get($post, 'price_formatted') !!}
                                                </span>
                                            </a>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="large-12 columns">
                                <div
                                    class="my-3 no-margin featured-list-slider {{ $carouselEl }} owl-carousel owl-theme">
                                    @for ($i = 25; $i < 32 && $i < count($posts); $i++)
                                        @php
                                            $post = $posts[$i];
                                        @endphp
                                        <div class="item px-2 my-4">
                                            <a href="{{ \App\Helpers\UrlGen::post($post) }}" class="custom-column">
                                                <span class="item-carousel-thumb">
                                                    <span class="photo-count">
                                                        <i class="fa fa-camera"></i>
                                                        {{ data_get($post, 'count_pictures') }}
                                                    </span>
                                                    @php
                                                        echo imgTag(data_get($post, 'picture.filename'), 'medium', [
                                                            'style' => 'border: 1px border-radius: 50px solid #e7e7e7; margin-top: 0px; width: 100%; height: auto;',
                                                            'alt' => data_get($post, 'title'),
                                                        ]);
                                                    @endphp
                                                </span>
                                                <span class="item-name text-left mx-3"
                                                    style="font-size: 0.74rem;">{{ str(data_get($post, 'title'))->limit(30) }}</span>

                                                <span class="price m-3 text-left" style="color: #d5590e;">
                                                    {!! data_get($post, 'price_formatted') !!}
                                                </span>
                                            </a>
                                        </div>
                                    @endfor
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                {{-- @include('home.inc.popular-listing') --}}
                @include('home.inc.signin-homepage')
            </div>
            {{-- <div class="col-xl-3">
                <div class="ads position-sticky">
                    <!-- responsive ads -->
                    <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-5615746995217894"
                        data-ad-slot="2477 556778" data-ad-format="auto" data-full-width-responsive="true"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div> --}}
        </div>
    </div>
@endif

@section('after_style')
    @parent
@endsection
<style>
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

    .featured-list-slider .owl-nav i.home-page-gallary-nav {
        color: white;
        font-size: 30px;
        background: #d85200;
        border: none;
        border-radius: 26.5px;
        cursor: pointer;
        height: 45px;
        opacity: .9;
        padding: 0;
        width: 45px;
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
</style>
@section('after_scripts')
    @parent
    <script>
        {{-- Check if RTL or LTR --}}
        var rtlIsEnabled = false;
        if ($('html').attr('dir') === 'rtl') {
            rtlIsEnabled = true;
        }

        {{-- Carousel Parameters --}}
        var carouselItems = {{ $totalPosts ?? 0 }};
        var carouselAutoplay = {{ data_get($sectionOptions, 'autoplay') ?? 'false' }};
        var carouselAutoplayTimeout = {{ (int) (data_get($sectionOptions, 'autoplay_timeout') ?? 1500) }};
        var carouselLang = {
            'navText': {
                'prev': '<i class="fas fa-angle-left home-page-gallary-nav"></i>',
                'next': '<i class="fas fa-angle-right home-page-gallary-nav"></i>'
            }
        };

        {{-- Featured Listings Carousel --}}
        var carouselObject = $('.featured-list-slider.{{ $carouselEl }}');
        var responsiveObject = {
            0: {
                items: 1,
                nav: true
            },
            576: {
                items: 2,
                nav: true
            },
            768: {
                items: 3,
                nav: true
            },
            992: {
                items: 4,
                nav: true,
                loop: (carouselItems > 5)
            }
        };
        carouselObject.owlCarousel({
            rtl: rtlIsEnabled,
            nav: true,
            navText: [carouselLang.navText.prev, carouselLang.navText.next],
            loop: true,
            responsiveClass: true,
            responsive: responsiveObject,
            autoWidth: true,
            autoplay: carouselAutoplay,
            autoplayTimeout: carouselAutoplayTimeout,
            autoplayHoverPause: true,
            dots: false
        });
    </script>
@endsection
