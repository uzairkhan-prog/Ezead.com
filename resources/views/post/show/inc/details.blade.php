@php
    $post ??= [];
    $carouselEl = '_' . createRandomString(6);
    $sectionOptions ??= [];
    $hideOnMobile = data_get($sectionOptions, 'hide_on_mobile') == '1' ? ' hidden-sm' : '';
   
@endphp
<style>
    .description-content {
        max-height: 300px;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }
    .read-more {
        text-align: center;
        margin-top: 10px;
    }
    .read-more-btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 8px 16px;
        cursor: pointer;
    }
</style>
<div class="items-details">
    <ul class="nav nav-tabs" id="itemsDetailsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="item-details-tab" data-bs-toggle="tab" data-bs-target="#item-details"
                role="tab" aria-controls="item-details" aria-selected="true">
                <h4>{{ t('listing_details') }}</h4>
            </button>
        </li>
        @if (config('plugins.reviews.installed'))
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="item-{{ config('plugins.reviews.name') }}-tab" data-bs-toggle="tab"
                    data-bs-target="#item-{{ config('plugins.reviews.name') }}" role="tab"
                    aria-controls="item-{{ config('plugins.reviews.name') }}" aria-selected="false">
                    <h4>
                        {{ trans('reviews::messages.Reviews') }} ({{ data_get($post, 'rating_count', 0) }})
                    </h4>
                </button>
            </li>
        @endif
    </ul>

    {{-- Tab panes --}}
    <div class="tab-content p-3 mb-3" id="itemsDetailsTabsContent">
        <div class="tab-pane show active" id="item-details" role="tabpanel" aria-labelledby="item-details-tab">
            <div class="row pb-3">
                <div class="items-details-info col-md-12 col-sm-12 col-12 enable-long-words from-wysiwyg">

                    <div class="row">
                        {{-- Location --}}
                        <div class="col-md-6 col-sm-6 col-6">
                            <h4 class="fw-normal p-0">
                                <span class="fw-bold"><i class="bi bi-geo-alt"></i> {{ t('location') }}: </span>
                                {{-- custom hide Location on Create Post --}}
                                {{-- <span>
                                    <a href="{!! \App\Helpers\UrlGen::city(data_get($post, 'city')) !!}">
                                        {{ data_get($post, 'city.name') }}
                                    </a>
                                </span> --}}

                                {{-- Start Custom Add --}}
                                @php
                                    $locationData = [
                                        'neighbour' => $neighbour,
                                        'new_city' => $new_city,
                                        'region' => $region,
                                        'province' => $province,
                                    ];
                                    $countryCode = data_get($post, 'country_code');
                                    $countryCodes = ['CA' => 'Canada', 'AU' => 'Australia', 'GB' => 'United Kingdom', 'US' => 'United States'];
                                    $country = $countryCodes[$countryCode] ?? 'No Location';
                                @endphp
                                {{-- custom Location on Create Post --}}
                                @if (empty(array_filter($locationData)))
                                    <span>
                                        <a>{{ $country }}</a>
                                    </span>
                                @else
                                    @foreach ($locationData as $location)
                                        @if (!empty($location))
                                         @if($location == "Fort Langley")
                                         @php
                                         $location = "Fort Langley - BC - Canada";
                                         @endphp
                                         @endif
                                            <span class="item-location"{!! config('lang.direction') == 'rtl' ? ' dir="rtl"' : '' !!}>
                                                <i class="bi bi-geo-alt"></i> {{ $location }}
                                            </span>&nbsp;
                                        @break
                                    @endif
                                @endforeach
                            @endif
                            {{-- End Custom Add --}}
                            </h4>
                        </div>

                        {{-- Price / Salary --}}
                        <div class="col-md-6 col-sm-6 col-6 text-end">
                            <h4 class="fw-normal p-0">
                                <span class="fw-bold">
                                    {{ data_get($post, 'price_label') }}
                                </span>
                                <span>
                                    @php
                                    $negotiable = DB::table('posts')->where('id', $post['id'])->value('negotiable');
                                    @endphp
                                    <!--{!! data_get($post, 'price_formatted') !!}-->
                                    {!! data_get($post, 'price') ?? data_get($post, 'price_formatted') !!}
                                    @if ($negotiable == '1')
                                        <small class="label bg-success"> {{ t('negotiable') }}</small>
                                    @endif
                                </span>
                            </h4>
                        </div>
                    </div>
                    <hr class="border-0 bg-secondary">

                    {{-- Description --}}
                    @php
                        $description = data_get($post, 'description');
                        $wordCount = str_word_count(strip_tags($description));
                    @endphp
                    <div class="row">
                        <div class="col-12 detail-line-content">
                            <div class="description-content">
                                {!! $description !!}
                            </div>
                            @if($wordCount > 20)
                                <div class="read-more">
                                    <button class="read-more-btn btn-primary rounded" onclick="toggleDescription()">Read More</button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <br>
                    
                    <button class="btn btn-success float-end m-2">
                        <i class="bi bi-eye"></i>
                        {{ \App\Helpers\Number::short(data_get($post, 'visits')) .
                            ' ' .
                            trans_choice('global.count_views', getPlural(data_get($post, 'visits')), [], config('app.locale')) }}
                    </button>
                    
                    {{-- Custom Fields --}}
                    @includeFirst([
                        config('larapen.core.customizedViewPath') . 'post.show.inc.details.fields-values',
                        'post.show.inc.details.fields-values',
                    ])

                    {{-- Custom Add Website Url --}}
                    @if (!empty(data_get($post, 'website_url')) && data_get($post, 'website_url_hidden') != '1')
                        <div class="row mt-3">
                            <div class="col-12">
                                <h4 class="p-0 my-3"><i class="fas fa-link"></i> Website Url:</h4>
                                <span
                                    class="d-inline-block border border-inverse bg-light rounded-1 py-1 px-2 my-1 me-1">
                                    <a href="{{ data_get($post, 'website_url') }}" target="_blank">
                                        {{ data_get($post, 'website_url') }}
                                    </a>
                                </span>
                            </div>
                        </div>
                    @endif

                    {{-- Tags --}}
                    @if (!empty(data_get($post, 'tags')))
                        <div class="row mt-3">
                            <div class="col-12">
                                <h4 class="p-0 my-3"><i class="bi bi-tags"></i> {{ t('Tags') }}:</h4>
                                @foreach (data_get($post, 'tags') as $iTag)
                                    <span
                                        class="d-inline-block border border-inverse bg-light rounded-1 py-1 px-2 my-1 me-1">
                                        <a href="{{ \App\Helpers\UrlGen::tag($iTag) }}">
                                            {{ $iTag }}
                                        </a>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Actions --}}
                    @if (!auth()->check() || (auth()->check() && auth()->id() != data_get($post, 'user_id')))
                        <div class="row text-center h2 mt-4 printer-hide">
                            <div class="col-3">
                                @if (auth()->check())
                                    @if (auth()->user()->id == data_get($post, 'user_id'))
                                        <a href="{{ \App\Helpers\UrlGen::editPost($post) }}">
                                            <i class="far fa-edit" data-bs-toggle="tooltip"
                                                title="{{ t('Edit') }}"></i>
                                        </a>
                                    @else
                                        <a id="postSendMail-custom" data-bs-toggle="modal"
                                            data-bs-target="#postSendMail" href="#">
                                            <i class="far fa-envelope-open" data-bs-toggle="tooltip"
                                                title="Tell a friend"></i>
                                        </a>
                                    @endif
                                @else
                                    <a href="#quickLogin" data-bs-toggle="modal" class="make-favorite">
                                        <i class="far fa-envelope-open" data-bs-toggle="tooltip"
                                            title="tell a friend"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="col-3">
                                @if (auth()->check())
                                    @if (auth()->user()->id == data_get($post, 'user_id'))
                                        <a href="{{ \App\Helpers\UrlGen::editPost($post) }}">
                                            <i class="far fa-edit" data-bs-toggle="tooltip"
                                                title="{{ t('Edit') }}"></i>
                                        </a>
                                    @else
                                        {!! genEmailContactBtn($post, false, true) !!}
                                    @endif
                                @else
                                    {!! genEmailContactBtn($post, false, true) !!}
                                @endif
                            </div>
                            @if (isVerifiedPost($post))
                                <div class="col-3">
                                    <a class="make-favorite" id="{{ data_get($post, 'id') }}"
                                        href="javascript:void(0)">
                                        @if (auth()->check())
                                            @if (!empty(data_get($post, 'savedByLoggedUser')))
                                                <i class="fas fa-bookmark" data-bs-toggle="tooltip"
                                                    title="{{ t('Remove favorite') }}"></i>
                                            @else
                                                <i class="far fa-bookmark" data-bs-toggle="tooltip"
                                                    title="{{ t('Save listing') }}"></i>
                                            @endif
                                        @else
                                            <i class="far fa-bookmark" data-bs-toggle="tooltip"
                                                title="{{ t('Save listing') }}"></i>
                                        @endif
                                    </a>
                                </div>
                                <div class="col-3">
                                    <a href="{{ \App\Helpers\UrlGen::reportPost($post) }}">
                                        <i class="far fa-flag" data-bs-toggle="tooltip"
                                            title="{{ t('Report abuse') }}"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

            </div>
        </div>

        @if (config('plugins.reviews.installed'))
            @if (view()->exists('reviews::comments'))
                @include('reviews::comments')
            @endif
        @endif
    </div>

    <div class="content-footer text-start printer-hide">
        @if (auth()->check())
            @if (auth()->user()->id == data_get($post, 'user_id'))
                <a class="btn btn-default" href="{{ \App\Helpers\UrlGen::editPost($post) }}">
                    <i class="far fa-edit"></i> {{ t('Edit') }}
                </a>
            @else
                {!! genPhoneNumberBtn($post) !!}
                <a id="postSendMail-custom" data-bs-toggle="modal" data-bs-target="#postSendMail"
                    class="btn btn-default" href="#">
                    <i class="far fa-envelope"></i> Tell a friend
                </a>
                {!! genEmailContactBtn($post) !!}
            @endif
        @else
            {!! genPhoneNumberBtn($post) !!}
            <a href="#quickLogin" data-bs-toggle="modal" class="btn btn-default"><i class="far fa-envelope"></i>
                Tell
                a
                friend </a>
            {!! genEmailContactBtn($post) !!}
        @endif
        {{-- ADD CUSTOM PRINTER IN POST --}}
        <a id="printer" class="btn btn-info printer-hide" href="#">
            <i class="fas fa-print"></i> Printer friendly
        </a>
    </div>
</div>

@if($widgetSimilarPosts)
<div class="content-box layout-section mb-2">
    <div class="row row-featured row-featured-category">
        <div class="col-xl-12 box-title">
            <div class="inner">
                <h2>
                    <span style="font-weight: 700;" class="title-3">
                        Recommended for you
                        <i class="fas fa-eye"></i>
                    </span>
                </h2>
            </div>
        </div>
        <div style="clear: both"></div>
        <div class="relative content featured-list-row clearfix hide-recommended-arrows-buttons py-0">
            <div class="large-12 columns">
                <div class="no-margin featured-list-slider {{ $carouselEl }} owl-carousel owl-theme">
                    @foreach(data_get($widgetSimilarPosts, 'posts', []) as $post)
                        @php
                            $price = data_get($post, 'price_formatted');
                        @endphp
                        <div class="item px-2 item-margin">
                            <a href="{{ \App\Helpers\UrlGen::post($post) }}" class="custom-column">
                                <span class="item-carousel-thumb">
                                    @php
                                        echo imgTag(data_get($post, 'picture.filename'), 'medium', [
                                            'style' =>
                                                'border: 1px border-radius: 50px solid #e7e7e7; margin-top: 0px; width: 100%; height: 160px; border-radius: .25rem;',
                                            'alt' => data_get($post, 'title'),
                                        ]);
                                    @endphp
                                </span>
                                <span class="item-name text-left mx-3" style="font-size: 0.74rem; color: #3e4153">{{ str(data_get($post, 'title'))->limit(30) }}</span>
                                <span class="price m-3 text-left" style="color: rgb(45, 132, 76);">{!! $price !!}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
    <script>
        function toggleDescription() {
            var description = document.querySelector('.description-content');
            var btn = document.querySelector('.read-more-btn');
            
            if (description.style.maxHeight) {
                description.style.maxHeight = null;
                btn.innerHTML = 'Read More';
            } else {
                description.style.maxHeight = description.scrollHeight + 'px';
                btn.innerHTML = 'Read Less';
            }
        }
    </script>
    <script>
        $(document).ready(function() {
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