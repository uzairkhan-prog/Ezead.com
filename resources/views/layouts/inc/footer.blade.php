<?php
$socialLinksAreEnabled = config('settings.social_link.facebook_page_url') || config('settings.social_link.twitter_url') || config('settings.social_link.tiktok_url') || config('settings.social_link.linkedin_url') || config('settings.social_link.pinterest_url') || config('settings.social_link.instagram_url');
$appsLinksAreEnabled = config('settings.other.ios_app_url') || config('settings.other.android_app_url');
$socialAndAppsLinksAreEnabled = $socialLinksAreEnabled || $appsLinksAreEnabled;
?>
<footer class="main-footer">
    <?php
    $rowColsLg = $socialAndAppsLinksAreEnabled ? 'row-cols-lg-4' : 'row-cols-lg-3';
    $rowColsMd = 'row-cols-md-3';

    $ptFooterContent = '';
    $mbCopy = ' mb-3';
    if (config('settings.footer.hide_links')) {
        $ptFooterContent = ' pt-sm-5 pt-5';
        $mbCopy = ' mb-4';
    }
    ?>
    <div class="footer-content{{ $ptFooterContent }}">
        <div class="container">
            <div class="row {{ $rowColsLg }} {{ $rowColsMd }} row-cols-sm-2 row-cols-2 g-3">

                @if (!config('settings.footer.hide_links'))
                <div class="col">
                    <div class="footer-col">
                        <h2 class="footer-title">Community</h2>
                        <ul class="list-unstyled footer-nav">
                            @if (isset($pages) && $pages->count() > 0)
                            @foreach ($pages as $page)
                            @if ($page->type === 'tips')
                            <li>
                                <?php
                                $linkTarget = '';
                                if ($page->target_blank == 1) {
                                    $linkTarget = 'target="_blank"';
                                }
                                ?>
                                @if (!empty($page->external_link))
                                <a href="{!! $page->external_link !!}" rel="nofollow"
                                    {!! $linkTarget !!}>
                                    {{ $page->name }} </a>
                                @else
                                <a href="{{ \App\Helpers\UrlGen::page($page) }}"
                                    {!! $linkTarget !!}> {{ $page->name }} </a>
                                @endif
                            </li>
                            @endif
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="footer-col">
                        <h2 class="footer-title">{{ t('about_us') }}</h2>
                        <ul class="list-unstyled footer-nav">
                            <li>
                                <a href="https://ezeadmedia.com/ezead-insight/" target="_blank">Ezead Insight</a>
                            </li>
                            @if (isset($pages) && $pages->count() > 0)
                            @foreach ($pages as $page)
                            @if ($page->type !== 'tips')
                            <li>
                                <?php
                                $linkTarget = '';
                                if ($page->target_blank == 1) {
                                    $linkTarget = 'target="_blank"';
                                }
                                ?>
                                @if (!empty($page->external_link))
                                <a href="{!! $page->external_link !!}" rel="nofollow"
                                    {!! $linkTarget !!}> {{ $page->name }} </a>
                                @else
                                <a href="{{ \App\Helpers\UrlGen::page($page) }}"
                                    {!! $linkTarget !!}> {{ $page->name }} </a>
                                @endif
                            </li>
                            @endif
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col">
                    <div class="footer-col">
                        <h2 class="footer-title">{{ t('Contact and Sitemap') }}</h2>
                        <ul class="list-unstyled footer-nav">
                            <li><a href="{{ \App\Helpers\UrlGen::contact() }}"> {{ t('Contact') }} </a></li>
                            <li><a href="{{ \App\Helpers\UrlGen::sitemap() }}"> {{ t('sitemap') }} </a></li>
                            @if (isset($countries) && $countries->count() > 1)
                            <li><a href="{{ \App\Helpers\UrlGen::countries() }}"> {{ t('countries') }} </a>
                            </li>
                            @endif
                            <li><a href="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}"> All Listings </a></li>
                            <li><a href="{{ \App\Helpers\UrlGen::pricing() }}"> Pricing </a></li>
                            <li><a href="/advance-search"> EZE Search </a></li>
                        </ul>
                    </div>
                </div>

                <div class="col">
                    <div class="footer-col">
                        <h2 class="footer-title">{{ t('My Account') }}</h2>
                        <ul class="list-unstyled footer-nav">
                            @if (!auth()->user())
                            <li>
                                @if (config('settings.security.login_open_in_modal'))
                                <a href="#quickLogin" data-bs-toggle="modal"> Sign In </a>
                                @else
                                <a href="{{ \App\Helpers\UrlGen::login() }}"> Sign In </a>
                                @endif
                            </li>
                            <li><a href="{{ \App\Helpers\UrlGen::register() }}"> Sign Up </a></li>
                            <li><a href="//ezeadhost.com" target="_blank"> Hosting </a></li>
                            <li><a href="//ezeadmedia.com/ezead-insight" target="_blank"> Info </a></li>
                            <li><a href="//community.ezead.com/" target="_blank"> Community </a></li>
                            <li><a href="//ezelancers.com/" target="_blank"> Lancers </a></li>
                            @else
                            <li><a href="{{ url('account') }}"> {{ t('My Account') }} </a></li>
                            <li><a href="{{ url('account/posts/list') }}"> {{ t('my_listings') }} </a></li>
                            <li><a href="{{ url('account/posts/favourite') }}">
                                    {{ t('favourite_listings') }}</a></li>
                            <li><a href="{{ url('account/posts/archived') }}">
                                    {{ t('my_archived_listings') }}</a></li>
                            <li><a href="{{ url('account/saved-searches') }}"> {{ t('my_saved_search') }}</a>
                            </li>
                            <li><a href="{{ url('account/posts/pending-approval') }}">
                                    {{ t('pending_approval') }}</a></li>
                            @endif
                        </ul>
                    </div>
                </div>

                @if ($socialAndAppsLinksAreEnabled)
                <div class="col custom-col">
                    <div class="footer-col row">
                        <?php
                        $footerSocialClass = '';
                        $footerSocialTitleClass = '';
                        ?>
                        @if ($appsLinksAreEnabled)
                        <div class="col-sm-12 col-12 p-lg-0">
                            <div class="mobile-app-content">
                                <h2 class="footer-title">{{ t('Mobile Apps') }}</h2>
                                <div class="row">
                                    @if (config('settings.other.ios_app_url'))
                                    <div class="col-12 col-sm-6">
                                        <a class="app-icon" target="_blank"
                                            href="{{ config('settings.other.ios_app_url') }}">
                                            <span class="hide-visually">{{ t('iOS app') }}</span>
                                            <img src="{{ url('images/site/app-store-badge.svg') }}"
                                                alt="{{ t('Available on the App Store') }}">
                                        </a>
                                    </div>
                                    @endif
                                    @if (config('settings.other.android_app_url'))
                                    <div class="col-12 col-sm-6">
                                        <a class="app-icon" target="_blank"
                                            href="{{ config('settings.other.android_app_url') }}">
                                            <span class="hide-visually">{{ t('Android App') }}</span>
                                            <img src="{{ url('images/site/google-play-badge.svg') }}"
                                                alt="{{ t('Available on Google Play') }}">
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <?php
                        $footerSocialClass = 'hero-subscribe';
                        $footerSocialTitleClass = 'm-0';
                        ?>
                        @endif

                        @if ($socialLinksAreEnabled)
                        <div class="col-sm-12 col-12 p-lg-0">
                            <div class="{!! $footerSocialClass !!}">
                                <h2 class="footer-title {!! $footerSocialTitleClass !!}">{{ t('Follow us on') }}
                                </h2>
                                <ul
                                    class="list-unstyled list-inline mx-0 footer-nav social-list-footer social-list-color footer-nav-inline">
                                    @if (config('settings.social_link.facebook_page_url'))
                                    <li>
                                        <a class="icon-color fb" data-bs-placement="top"
                                            data-bs-toggle="tooltip"
                                            href="{{ config('settings.social_link.facebook_page_url') }}"
                                            title="Facebook" alt="Facebook" aria-label="Facebook"
                                            target="_blank">
                                            <i class="fab fa-facebook"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if (config('settings.social_link.twitter_url'))
                                    <li>
                                        <a class="icon-color tw" data-bs-placement="top"
                                            data-bs-toggle="tooltip"
                                            href="{{ config('settings.social_link.twitter_url') }}"
                                            title="Twitter" alt="Twitter" aria-label="Twitter"
                                            target="_blank">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if (config('settings.social_link.instagram_url'))
                                    <li>
                                        <a class="icon-color pin" data-bs-placement="top"
                                            data-bs-toggle="tooltip"
                                            href="{{ config('settings.social_link.instagram_url') }}"
                                            title="Instagram" alt="Instagram" aria-label="Instagram"
                                            target="_blank">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if (config('settings.social_link.linkedin_url'))
                                    <li>
                                        <a class="icon-color lin" data-bs-placement="top"
                                            data-bs-toggle="tooltip"
                                            href="{{ config('settings.social_link.linkedin_url') }}"
                                            title="LinkedIn" alt="LinkedIn" aria-label="LinkedIn"
                                            target="_blank">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if (config('settings.social_link.pinterest_url'))
                                    <li>
                                        <a class="icon-color pin" data-bs-placement="top"
                                            data-bs-toggle="tooltip"
                                            href="{{ config('settings.social_link.pinterest_url') }}"
                                            title="Pinterest" alt="Pinterest" aria-label="Pinterest"
                                            target="_blank">
                                            <i class="fab fa-pinterest-p"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if (config('settings.social_link.tiktok_url'))
                                    <li>
                                        <a class="icon-color tt" data-bs-placement="top"
                                            data-bs-toggle="tooltip"
                                            href="{{ config('settings.social_link.tiktok_url') }}"
                                            title="Tiktok" alt="Tiktok" aria-label="Tiktok"
                                            target="_blank">
                                            <i class="fab fa-tiktok"></i>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <div style="clear: both"></div>
                @endif

            </div>
            <!--<hr class="mb-0" style="color:#777;">-->
            <div class="row">
                <?php
                $mtPay = '';
                $mtCopy = ' mt-md-4 mt-3 pt-2';
                ?>
                <div class="col-12">
                    @if (!config('settings.footer.hide_payment_plugins_logos') && isset($paymentMethods) && $paymentMethods->count() > 0)
                    {{-- @if (config('settings.footer.hide_links'))
                            <?php $mtPay = ' mt-0'; ?>
                        @endif
                        <div class="text-center payment-method-logo{{ $mtPay }}"> --}}
                    {{-- Payment Plugins --}}
                    {{-- @foreach ($paymentMethods as $paymentMethod)
                                @if (file_exists(plugin_path($paymentMethod->name, 'public/images/ezeadmediagroup.png'))) --}}
                    {{-- <img src="{{ url('images/' . $paymentMethod->name . '/payment.png') }}"
                    alt="{{ $paymentMethod->display_name }}"
                    title="{{ $paymentMethod->display_name }}"> --}}
                    {{-- <a href="https://ezead.media/" target="_blank">
                                        <img src="{{ url('images/' . $paymentMethod->name . '/ezeadmediagroup.png') }}"
                    alt="Ezeadmediagroup" title="ezeadmediagroup">
                    </a>
                    @endif
                    @endforeach --}}
                </div>
                <hr class="my-3">
                <!--<div class="col-12">-->
                <!--    <div class="px-3 no-credit-custom text-center">-->
                <!--        <script async src="https://cse.google.com/cse.js?cx=65f21b233b04f48c9"></script>-->
                <!--        <div class="gcse-search"  enableAutoComplete="true"></div>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<hr>-->
                @else
                <?php $mtCopy = ' mt-0'; ?>
                @if (!config('settings.footer.hide_links'))
                <?php $mtCopy = ' mt-md-4 mt-3 pt-2'; ?>
                <hr class="bg-secondary border-0">
                @endif
                @endif

                <div class="copy-info text-center mb-md-0mt-3">
                    <div class="px-3 no-credit-custom text-center pb-4">
                        @php
                        $static_country = config('country.name');
                        $current_locationn = '';
                        @endphp
                        @if (session()->has('neighbour'))
                        {{ session('country.name') }} or {{ session('neighbour.name') }} Free Auctions and Classifieds
                        @elseif (session()->has('city'))
                        {{ session('country.name') }} or {{ session('city.name') }} Free Auctions and Classifieds
                        @elseif (session()->has('region'))
                        {{ session('country.name') }} or {{ session('region.name') }} Free Auctions and Classifieds
                        @elseif (session()->has('province'))
                        {{ session('country.name') }} or {{ session('province.name') }} Free Auctions and Classifieds
                        @elseif (session()->has('country'))
                        {{ session('country.name') }} Free Auctions and Classifieds
                        @else
                        Free Auctions and Classifieds
                        @endif
                        </a>
                        </li>
                    </div>
                    <div class="px-3 no-credit-custom text-center pb-4">
                        <a href="https://www.ezead.com/page/get-started-fees-bidding-help">( No Credit Card Required )</a>
                    </div>
                    {{-- © {{ date('Y') }} {{ config('settings.app.name') }}. {{ t('all_rights_reserved') }}. --}}
                    © {{ t('all_rights_reserved') }}.
                    @if (!config('settings.footer.hide_powered_by'))
                    @if (config('settings.footer.powered_by_info'))
                    {{ t('Powered by') }} <a href="https://ezeadmedia.com/" title="Ezead Media Group" target="_blank">{!! config('settings.footer.powered_by_info') !!}</a>
                    @else
                    {{ t('Powered by') }} <a href="https://laraclassifier.com"
                        title="LaraClassifier">LaraClassifier</a>.
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</footer>