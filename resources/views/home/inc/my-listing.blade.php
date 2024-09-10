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
            <div class="col-xl-9">
                <div class="content-box layout-section">
                    <div class="row row-featured row-featured-category">
                        <div class="col-xl-12 box-title">
                            <div class="inner">
                                <h2>
                                    <span style="font-weight: 700;" class="title-3">
                                        Homepage Gallery <i class="bi bi-question-circle-fill"></i>
                                    </span>
                                    <a href="{{ data_get($widget, 'link') }}" class="sell-your-item">
                                        See All <i class="fas fa-bars"></i>
                                    </a>
                                </h2>
                            </div>
                        </div>

                        <div style="clear: both"></div>

                        <div class="relative content featured-list-row clearfix">

                            <div class="large-12 columns">
                                <div class="no-margin featured-list-slider {{ $carouselEl }} owl-carousel owl-theme">
                                    @foreach ($posts as $key => $post)
                                        {{ dd($post) }}
                                        <div class="item">
                                            <a href="{{ \App\Helpers\UrlGen::post($post) }}">
                                                <span class="item-carousel-thumb">
                                                    <span class="photo-count">
                                                        <i class="fa fa-camera"></i>
                                                        {{ data_get($post, 'count_pictures') }}
                                                    </span>
                                                    @php
                                                        echo imgTag(data_get($post, 'picture.filename'), 'medium', [
                                                            'style' => 'border: 1px solid #e7e7e7; margin-top: 2px;',
                                                            'alt' => data_get($post, 'title'),
                                                        ]);
                                                    @endphp
                                                </span>
                                                <span
                                                    class="item-name">{{ str(data_get($post, 'title'))->limit(70) }}</span>

                                                @if (config('plugins.reviews.installed'))
                                                    @if (view()->exists('reviews::ratings-list'))
                                                        @include('reviews::ratings-list')
                                                    @endif
                                                @endif

                                                <span class="price">
                                                    {!! data_get($post, 'price_formatted') !!}
                                                </span>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="ads position-sticky">
                    <!-- responsive ads -->
                    <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-5615746995217894"
                        data-ad-slot="2477 556778" data-ad-format="auto" data-full-width-responsive="true"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>
        </div>
    </div>
@endif

@section('after_style')
    @parent
@endsection

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
                'prev': "{{ t('prev') }}",
                'next': "{{ t('next') }}"
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
                nav: false
            },
            768: {
                items: 3,
                nav: false
            },
            992: {
                items: 5,
                nav: false,
                loop: (carouselItems > 5)
            }
        };
        carouselObject.owlCarousel({
            rtl: rtlIsEnabled,
            nav: false,
            navText: [carouselLang.navText.prev, carouselLang.navText.next],
            loop: true,
            responsiveClass: true,
            responsive: responsiveObject,
            autoWidth: true,
            autoplay: carouselAutoplay,
            autoplayTimeout: carouselAutoplayTimeout,
            autoplayHoverPause: true
        });
    </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5615746995217894"
        crossorigin="anonymous"></script>
@endsection
