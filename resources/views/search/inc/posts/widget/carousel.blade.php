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
    {{-- <div class="wide container{{ $isFromHome ? '' : ' my-2' }}{{ $hideOnMobile }}"> --}}
    <div class="wide-container">
        <div class="row">
            <div class="col-xl-12">
                <div class="content-box layout-section theme-recommended mb-2 theme-recommended pb-5 pt-4 px-3">
                    <div class="row row-featured row-featured-category">
                        <div class="col-xl-12 box-title theme-inner-recommended">
                            <div class="inner">
                                <h2>
                                    <span style="font-weight: 500;" class="title-3">
                                        Recommended for you
                                        <i class="fas fa-eye"></i>
                                    </span>
                                    {{-- <a href="{{ data_get($widget, 'link') }}" class="sell-your-item">
                                        See All <i class="fas fa-bars"></i>
                                    </a> --}}
                                </h2>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div class="relative content featured-list-row clearfix hide-recommended-arrows-buttons py-0">
                            <div class="large-12 columns">
                                <div class="no-margin featured-list-slider {{ $carouselEl }} owl-carousel owl-theme">
                                    @foreach (collect($posts)->sortByDesc(function ($post) {
                                        return data_get($post, 'visits');
                                    })->take(20) as $post)
                                        @php
                                            $price = data_get($post, 'price_formatted');
                                        @endphp
                                        @if (is_int($price) || (is_string($price) && !str_contains($price, 'Contact us') && !str_contains($price, 'Free')))
                                            <div class="item pe-3 item-margin">
                                                <a href="{{ \App\Helpers\UrlGen::post($post) }}" class="custom-column">
                                                    <span class="item-carousel-thumb">
                                                        <span class="photo-count fa fa-camera">
                                                            {{ data_get($post, 'count_pictures') }}
                                                        </span>

                                                        @php
                                                            echo imgTag(data_get($post, 'picture.filename'), 'medium', [
                                                                'style' => 'border: 1px; border-radius:6px; margin-top: 0px; width: 100%; height: 160px;',
                                                                'alt' => data_get($post, 'title'),
                                                                'loading' => 'lazy',
                                                            ]);
                                                        @endphp

                                                    </span>
                                                    <span class="item-name text-left mx-3"
                                                        style="font-size: 0.74rem;">{{ str(data_get($post, 'title'))->limit(30) }}</span>
                                                    <hr>
                                                    <div class="d-flex justify-content-between m-3">
                                                        <span class="price text-left" style="color: #131313;">
                                                            {!! $price !!}
                                                        </span>
                                                        <span class="review text-right" style="color: #131313;">
                                                            <i class="fas fa-star" style="color: #fdc60a;"></i>
                                                            {!! data_get($post, 'rating_cache') !!}
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-box layout-section theme-recommended-2 pt-4 px-3">
                    <div class="row row-featured row-featured-category">
                        <div class="col-xl-12 box-title hide-background-color head-theme-recommended">
                            <div class="inner">
                                <h2>
                                    <span style="font-weight: 700;" class="title-3">
                                        Homepage Gallery <i class="bi bi-question-circle-fill"></i>
                                    </span>
                                    {{-- <a href="{{ data_get($widget, 'link') }}" class="sell-your-item">
                                        See All <i class="fas fa-bars"></i>
                                    </a> --}}
                                </h2>
                                {{-- <h2 class="your-ad-here d-none">
                                    @if (auth()->check())
                                        <a href="{{ \App\Helpers\UrlGen::addPost() }}" class="sell-your-item"
                                            style="margin-right: 100px; font-weight: 500;color: #898989;text-decoration: underline;text-transform: capitalize;">
                                            Your Ad here
                                        </a>
                                    @else
                                        @if (config('settings.security.login_open_in_modal'))
                                            <a href="#quickLogin" class="sell-your-item" data-bs-toggle="modal"
                                                style="margin-right: 100px; font-weight: 500;color: #898989;text-decoration: underline;text-transform: capitalize;">
                                                Your Ad here
                                            </a>
                                        @else
                                            <a href="{{ \App\Helpers\UrlGen::login() }}" class="sell-your-item"
                                                data-bs-toggle="modal"
                                                style="margin-right: 100px; font-weight: 500;color: #898989;text-decoration: underline;text-transform: capitalize;">
                                                Your Ad here
                                            </a>
                                        @endif
                                    @endif
                                </h2> --}}
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div id="trigger-div" class="relative content featured-list-row clearfix">
                            <div class="row featured-list-slider">
                                @foreach ($posts as $index => $post)
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
                                                        echo imgTag(data_get($post, 'picture.filename'), 'medium', [
                                                            'style' => 'border: 1px; border-radius:6px; margin-top: 0px; width: 100%; height: 160px;',
                                                            'alt' => data_get($post, 'title'),
                                                            'loading' => 'lazy',
                                                        ]);
                                                    @endphp
                                                </span>
                                                <span class="item-name text-left mx-3"
                                                    style="font-size: 0.74rem;">{{ str(data_get($post, 'title'))->limit(30) }}</span>
                                                    <hr>
                                                <div class="d-flex justify-content-between m-3">
                                                    <span class="price text-left" style="color: #131313;">
                                                        {!! $price !!}
                                                    </span>
                                                    <span class="review text-right" style="color: #131313;">
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
    <div id="loading" class="spinner pt-4" style="display: none;">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
    <div class="mb20 text-center pt-3 pb-4">
        <button id="loadMoreBtn" class="btn btn-default mt10">
            <i class="fa fa-arrow-circle-right"></i> Browse More Ads
        </button>
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

    .light .featured-list-slider span.price,
    .light .featured-list-slider span.review {
        color: #737373 !important;
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
@section('after_scripts')
    @parent
    <script>
        $(document).ready(function() {
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
        });
    </script>
    
    <script>
    
    $(document).ready(function() {
            var postsPerPage = 20;
            var currentPage = 1;
        
            $('#loadMoreBtn').on('click', function() {
                $('#loading').show();
        
                $.ajax({
                    url: '/load-more-posts',
                    type: 'GET',
                    data: {
                        page: currentPage + 1,
                    },
                    success: function(data) {
                        console.log(data.postsHtml); // Log the returned HTML

                        if (data.postsHtml.length > 0) {
                            currentPage++;
                            
                            $('#trigger-div').append(data.postsHtml);
                            {{--  $('#posts-container').append(data.postsHtml);  --}}

                            
                            $('#loading').hide();
        
                            if (!data.hasMorePosts) {
                                $('#loadMoreBtn').hide();
                            }
                        } else {
                            $('#loadMoreBtn').hide();
                            $('#loading').hide();
                        }
                    },
                    error: function() {
                        $('#loading').hide();
                        alert('Failed to load more posts.');
                    }
                });
            });
        });
        // Add Browse More Ads Button And Showing Posts
        // $(document).ready(function() {
        //     var postsPerPage = 20; // Number of posts to show per batch
        //     var totalPosts = $(".featured-list-slider .col-lg-2").length; // Total number of posts
        //     var currentIndex = 20;
        //     // Initially show only the first 5 posts
        //     $(".featured-list-slider .col-lg-2").slice(postsPerPage).hide();
        //     function showNextBatch() {
        //         var nextIndex = currentIndex + postsPerPage;
        //         if (nextIndex <= totalPosts) {
        //             $("#loading").show(); // Show loading animation
        //             setTimeout(function() {
        //                 $(".featured-list-slider .col-lg-2").slice(currentIndex, nextIndex).fadeIn(); // Show the next batch of posts
        //                 currentIndex = nextIndex;
        //                 $("#loading").hide(); // Hide loading animation
        //                 if (currentIndex >= totalPosts) {
        //                     $("#loadMoreBtn").hide(); // Hide button if no more posts to show
        //                 }
        //             }, 500); // Delay to simulate loading
        //         }
        //     }
        //     $("#loadMoreBtn").click(function() {
        //         showNextBatch(); // Show the next batch of posts on button click
        //     });
        // });
    
        // Hide Scrolling Posts
        // $(document).ready(function() {
        //     var currentIndex = 0;
        //     var rows = $(".featured-list-slider");
        //     rows.slice(1).hide(); // Hide all rows except the first one
    
        //     function showNextRow() {
        //         if (currentIndex < rows.length - 1) {
        //             $("#loading").show(); // Show loading animation
        //             setTimeout(function() {
        //                 $(rows[currentIndex + 1]).fadeIn(); // Show the next row
        //                 currentIndex++;
        //                 $("#loading").hide(); // Hide loading animation
        //                 if (currentIndex >= rows.length - 1) {
        //                     $("#loadMoreBtn").hide(); // Hide button if no more rows
        //                 }
        //             }, 1000); // Delay to simulate loading
        //         }
        //     }
    
        //     $("#loadMoreBtn").click(function() {
        //         showNextRow(); // Show the next row on button click
        //     });
        // });
    </script>
@endsection
