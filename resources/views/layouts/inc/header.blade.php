<?php
// Search parameters
$queryString = request()->getQueryString() ? '?' . request()->getQueryString() : '';

// Check if the Multi-Countries selection is enabled
$multiCountriesIsEnabled = false;
$multiCountriesLabel = '';
if (config('settings.geo_location.show_country_flag')) {
    if (!empty(config('country.code'))) {
        if (isset($countries) && $countries->count() > 1) {
            $multiCountriesIsEnabled = true;
            $multiCountriesLabel = 'title="' . t('Select a Country') . '"';
        }
    }
}

// Logo Label
$logoLabel = '';
if ($multiCountriesIsEnabled) {
    $logoLabel = config('settings.app.name') . (!empty(config('country.name')) ? ' ' . config('country.name') : '');
}
?>
<div class="header">
    {{-- Navbar --}}
    <nav class="navbar fixed-top navbar-site bg-light navbar-light navbar-expand-md border-top border-5 border-top-header"
        role="navigation">
        <div class="container wide px-0">
            <div class="navbar-identity p-sm-0">
                {{-- Logo --}}
                <a href="{{ url('/') }}" class="navbar-brand logo logo-title m-0">
                    <img src="{{ config('settings.app.logo_url') }}" alt="{{ strtolower(config('settings.app.name')) }}"
                        class="main-logo" data-bs-placement="bottom" data-bs-toggle="tooltip"
                        title="{!! $logoLabel !!}" />
                </a>
                {{-- Add Post Btn in Mobile --}}
                    <?php
                    $addListingUrl = \App\Helpers\UrlGen::addPost();
                    $addListingAttr = '';
                    if (!auth()->check()) {
                        if (config('settings.single.guests_can_post_listings') != '1') {
                            $addListingUrl = url('/login');
                            $addListingAttr = '';
                        }
                    }
                    if (config('settings.single.pricing_page_enabled') == '1') {
                        $addListingUrl = \App\Helpers\UrlGen::pricing();
                        $addListingAttr = '';
                    }
                    ?>
                <a href="{{ $addListingUrl }}?new=1" {!! $addListingAttr !!} class="custom-mobile-postad d-none">
                    POST AD
                </a>
                {{-- Toggle Nav (Mobile)
                <button class="navbar-toggler -toggler float-end" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarsDefault" aria-controls="navbarsDefault" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30"
                        focusable="false">
                        <title>{{ t('Menu') }}</title>
                <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10"
                    d="M4 7h22M4 15h22M4 23h22"></path>
                </svg>
                </button> --}}
                {{-- Country Flag (Mobiles)
                @if ($multiCountriesIsEnabled)
                    @if (!empty(config('country.icode')))
                        @if (file_exists(public_path() . '/images/flags/24/' . config('country.icode') . '.png'))
                            <button class="flag-menu country-flag d-md-none d-sm-block d-none btn btn-default float-end"
                                href="#selectCountry" data-bs-toggle="modal">
                                <img src="{{ url('public/images/flags/24/' . config('country.icode') . '.png') . getPictureVersion() }}"
                alt="{{ config('country.name') }}" style="float: left;" width="36"
                height="32">
                <span class="caret d-none"></span>
                </button>
                @endif
                @endif
                @endif --}}
            </div>
            <div class="custom-navbar-identity d-none">
                <ul class="list-group list-group-horizontal px-3">
                    @php
                    $static_country = config('country.name');
                    $current_locationn = '';
                    @endphp
                    <li class="">
                        <a id="location-custom" data-bs-toggle="modal" data-bs-target="#search-Location"
                            class="px-3 position-relative top-50 start-50 translate-middle locationModalTrigger-555572005">
                            <i class="bi bi-geo-alt px-2"></i>
                            @if (session()->has('neighbour'))
                            <span class="text-3814801860 SubmitSearchButtonAdd">
                                {{ session('neighbour.name') }}
                            </span>
                            @elseif (session()->has('city'))
                            <span class="text-3814801860 SubmitSearchButtonAdd">
                                {{ session('city.name') }}
                            </span>
                            @elseif (session()->has('region'))
                            <span class="text-3814801860 SubmitSearchButtonAdd">
                                {{ session('region.name') }}
                            </span>
                            @elseif (session()->has('province'))
                            <span class="text-3814801860 SubmitSearchButtonAdd">
                                {{ session('province.name') }}
                            </span>
                            @elseif (session()->has('country'))
                            <span class="text-3814801860 SubmitSearchButtonAdd">
                                {{ session('country.name') }}
                            </span>
                            @else
                            <span class="text-3814801860 SubmitSearchButton">{{ $static_country }}</span>
                            <span class="caret d-lg-block d-md-none d-sm-none d-none float-end mx-0"></span>
                            @endif
                        </a>
                    </li>
                    @if (!auth()->check())
                    <li class="">
                        <div class="root-882857460">
                            <a class="link-3970392289 link__default-1151936189 register-4281208362" rel="nofollow"
                                href="{{ \App\Helpers\UrlGen::register() }}" title="Register">
                                Register
                            </a>
                            <span class="or-4281208362">&nbsp;or&nbsp;</span>
                            @if (config('settings.security.login_open_in_modal'))
                            <a href="#quickLogin" class="link-3970392289 link__default-1151936189"
                                title="Sign In" data-bs-toggle="modal">
                                Sign In
                            </a>
                            @else
                            <a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link"><i
                                    class="fas fa-user"></i>Sign In</a>
                            @endif
                        </div>
                    </li>
                    @else
                    <li class="">
                        <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i>
                            <span class="header_username">{{ auth()->user()->name }}</span>
                            <span
                                class="badge badge-pill badge-important count-threads-with-new-messages d-lg-inline-block d-md-none">0</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul id="userMenuDropdown" class="dropdown-menu user-menu shadow-sm">
                            @if (isset($userMenu) && !empty($userMenu))
                            <li class="dropdown-item">
                                <a href="{{ auth()->check() ? 'https://shop.ezead.com/login?u=' . auth()->user()->id . '&r=ezead.com' : 'https://shop.ezead.com/' }}"
                                    target="_blank">
                                    <i class="fa fa-store"></i> My Store
                                </a>
                            </li>
                            @php
                            $menuGroup = '';
                            $dividerNeeded = false;
                            @endphp
                            @foreach ($userMenu as $key => $value)
                            @continue(!$value['inDropdown'])
                            @php
                            if ($menuGroup != $value['group']) {
                            $menuGroup = $value['group'];
                            if (!empty($menuGroup) && !$loop->first) {
                            $dividerNeeded = true;
                            }
                            } else {
                            $dividerNeeded = false;
                            }
                            @endphp
                            @if ($dividerNeeded)
                            <li class="dropdown-divider"></li>
                            @endif
                            <li
                                class="dropdown-item{{ isset($value['isActive']) && $value['isActive'] ? ' active' : '' }}">
                                <a href="{{ $value['url'] }}">
                                    <i class="{{ $value['icon'] }}"></i> {{ $value['name'] }}
                                    @if (isset($value['countVar'], $value['countCustomClass']) &&
                                    !empty($value['countVar']) &&
                                    !empty($value['countCustomClass']))
                                    <span
                                        class="badge badge-pill badge-important{{ $value['countCustomClass'] }}">0</span>
                                    @endif
                                </a>
                            </li>
                            @endforeach
                            @endif

                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="navbar-collapse collapse" id="navbarsDefault">
                <ul class="nav navbar-nav me-md-auto navbar-left px-0">
                    {{-- Country Flag --}}
                    @if (config('settings.geo_location.show_country_flag'))
                    @if (!empty(config('country.icode')))
                    @if (file_exists(public_path() . '/images/flags/32/' . config('country.icode') . '.png'))
                    <li class="flag-menu country-flag d-md-block d-sm-none d-none nav-item p-3"
                        data-bs-toggle="tooltip"
                        data-bs-placement="{{ config('lang.direction') == 'rtl' ? 'bottom' : 'right' }}"
                        {!! $multiCountriesLabel !!}>
                        @if ($multiCountriesIsEnabled)
                        <a class="nav-link p-0" data-bs-toggle="modal" data-bs-target="#selectCountry">
                            <img class="flag-icon mt-1"
                                src="{{ url('/images/flags/32/' . config('country.icode') . '.png') . getPictureVersion() }}"
                                alt="{{ config('country.name') }}">
                            <span
                                class="caret d-lg-block d-md-none d-sm-none d-none float-end mt-3 mx-1"></span>
                        </a>
                        @else
                        <a class="p-0" style="cursor: default;">
                            <img class="flag-icon"
                                src="{{ url('/images/flags/32/' . config('country.icode') . '.png') . getPictureVersion() }}"
                                alt="{{ config('country.name') }}">
                        </a>
                        @endif
                    </li>
                    @endif
                    @endif
                    @endif
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    @php
                    $static_country = config('country.name');
                    $current_locationn = '';
                    @endphp
                    <li class="col-auto search-col locationicon px-1 mobile-input">
                        <a id="location-custom" data-bs-toggle="modal" data-bs-target="#search-Location"
                            class="px-3 position-relative top-50 start-50 translate-middle locationModalTrigger-555572005">
                            <i class="bi bi-geo-alt px-2"></i>
                            @if (session()->has('neighbour'))
                            <span class="text-3814801860 SubmitSearchButtonAdd">
                                {{ session('neighbour.name') }}
                            </span>
                            @elseif (session()->has('city'))
                            <span class="text-3814801860 SubmitSearchButtonAdd">
                                {{ session('city.name') }}
                            </span>
                            @elseif (session()->has('region'))
                            <span class="text-3814801860 SubmitSearchButtonAdd">
                                {{ session('region.name') }}
                            </span>
                            @elseif (session()->has('province'))
                            <span class="text-3814801860 SubmitSearchButtonAdd">
                                {{ session('province.name') }}
                            </span>
                            @elseif (session()->has('country'))
                            <span class="text-3814801860 SubmitSearchButtonAdd">
                                {{ session('country.name') }}
                            </span>
                            @else
                            <span class="text-3814801860 SubmitSearchButton">{{ $static_country }}</span>
                            <span class="caret d-lg-block d-md-none d-sm-none d-none float-end mx-0"></span>
                            @endif
                        </a>
                    </li>
                    @includeFirst([
                    config('larapen.core.customizedViewPath') . 'layouts.inc.menu.select-language',
                    'layouts.inc.menu.select-language',
                    ])
                    {{-- @if (config('settings.list.display_browse_listings_link'))
                        <li class="nav-item d-lg-block d-md-none d-sm-block d-block">
                            @php
                                $currDisplay = config('settings.list.display_mode');
                                $browseListingsIconClass = 'fas fa-th-large';
                                if ($currDisplay == 'make-list') {
                                    $browseListingsIconClass = 'fas fa-th-list';
                                }
                                if ($currDisplay == 'make-compact') {
                                    $browseListingsIconClass = 'fas fa-bars';
                                }
                            @endphp
                            <a style="margin-right: 100px" href="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}"
                    class="nav-link">
                    <i class="bi bi-geo-alt-fill"></i> {{ t('Browse Listings') }}
                    </a>
                    </li>
                    @endif --}}
                    @if (!auth()->check())
                    <li class="root-835198095 root__loggedOut-3587998771">
                        <div class="root-882857460">
                            <a class="link-3970392289 link__default-1151936189 register-4281208362" rel="nofollow"
                                href="{{ \App\Helpers\UrlGen::register() }}" title="Register">
                                Register
                            </a>
                            <span class="or-4281208362">&nbsp;or&nbsp;</span>
                            @if (config('settings.security.login_open_in_modal'))
                            <a href="#quickLogin" class="link-3970392289 link__default-1151936189"
                                title="Sign In" data-bs-toggle="modal">
                                Sign In
                            </a>
                            @else
                            <a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link"><i
                                    class="fas fa-user"></i>Sign In</a>
                            @endif
                        </div>
                    </li>
                    @else
                    <li class="nav-item dropdown no-arrow open-on-hover dropdown lang-menu">
                        <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i>
                            <span class="header_username">{{ auth()->user()->name }}</span>
                            <span
                                class="badge badge-pill badge-important count-threads-with-new-messages d-lg-inline-block d-md-none">0</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul id="userMenuDropdown" class="dropdown-menu user-menu shadow-sm">
                            @if (isset($userMenu) && !empty($userMenu))
                            <li class="dropdown-item">
                                <a href="{{ auth()->check() ? 'https://shop.ezead.com/login?u=' . auth()->user()->id . '&r=ezead.com' : 'https://shop.ezead.com/' }}"
                                    target="_blank">
                                    <i class="fa fa-store"></i> My Store
                                </a>
                            </li>
                            @php
                            $menuGroup = '';
                            $dividerNeeded = false;
                            @endphp
                            @foreach ($userMenu as $key => $value)
                            @continue(!$value['inDropdown'])
                            @php
                            if ($menuGroup != $value['group']) {
                            $menuGroup = $value['group'];
                            if (!empty($menuGroup) && !$loop->first) {
                            $dividerNeeded = true;
                            }
                            } else {
                            $dividerNeeded = false;
                            }
                            @endphp
                            @if ($dividerNeeded)
                            <li class="dropdown-divider"></li>
                            @endif
                            <li
                                class="dropdown-item{{ isset($value['isActive']) && $value['isActive'] ? ' active' : '' }}">
                                <a href="{{ $value['url'] }}">
                                    <i class="{{ $value['icon'] }}"></i> {{ $value['name'] }}
                                    @if (isset($value['countVar'], $value['countCustomClass']) &&
                                    !empty($value['countVar']) &&
                                    !empty($value['countCustomClass']))
                                    <span
                                        class="badge badge-pill badge-important{{ $value['countCustomClass'] }}">0</span>
                                    @endif
                                </a>
                            </li>
                            @endforeach
                            @endif

                        </ul>
                    </li>
                    @endif
                    {{-- @if (!auth()->check())
                        <li class="nav-item dropdown no-arrow open-on-hover d-md-block d-sm-none d-none">
                            <a href="#" class="dropdown-toggle nav-link text-left text-left"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i>
                                <span>{{ t('log_in') }}</span>
                    <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul id="authDropdownMenu" class="dropdown-menu user-menu shadow-sm">
                        <li class="dropdown-item">
                            @if (config('settings.security.login_open_in_modal'))
                            <a href="#quickLogin" class="nav-link" data-bs-toggle="modal"><i
                                    class="fas fa-user"></i> {{ t('log_in') }}</a>
                            @else
                            <a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link"><i
                                    class="fas fa-user"></i> {{ t('log_in') }}</a>
                            @endif
                        </li>
                        <li class="dropdown-item">
                            <a href="{{ \App\Helpers\UrlGen::register() }}" class="nav-link"><i
                                    class="far fa-user"></i> {{ t('sign_up') }}</a>
                        </li>
                    </ul>
                    </li>
                    <li class="nav-item d-md-none d-sm-block d-block">
                        @if (config('settings.security.login_open_in_modal'))
                        <a href="#quickLogin" class="nav-link" data-bs-toggle="modal"><i
                                class="fas fa-user"></i> {{ t('log_in') }}</a>
                        @else
                        <a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link"><i
                                class="fas fa-user"></i> {{ t('log_in') }}</a>
                        @endif
                    </li>
                    <li class="nav-item d-md-none d-sm-block d-block">
                        <a href="{{ \App\Helpers\UrlGen::register() }}" class="nav-link"><i
                                class="far fa-user"></i> {{ t('sign_up') }}</a>
                    </li>
                    @else
                    <li class="nav-item dropdown no-arrow open-on-hover">
                        <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ auth()->user()->name }}</span>
                            <span
                                class="badge badge-pill badge-important count-threads-with-new-messages d-lg-inline-block d-md-none">0</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul id="userMenuDropdown" class="dropdown-menu user-menu shadow-sm">
                            @if (isset($userMenu) && !empty($userMenu))
                            @php
                            $menuGroup = '';
                            $dividerNeeded = false;
                            @endphp
                            @foreach ($userMenu as $key => $value)
                            @continue(!$value['inDropdown'])
                            @php
                            if ($menuGroup != $value['group']) {
                            $menuGroup = $value['group'];
                            if (!empty($menuGroup) && !$loop->first) {
                            $dividerNeeded = true;
                            }
                            } else {
                            $dividerNeeded = false;
                            }
                            @endphp
                            @if ($dividerNeeded)
                            <li class="dropdown-divider"></li>
                            @endif
                            <li
                                class="dropdown-item{{ isset($value['isActive']) && $value['isActive'] ? ' active' : '' }}">
                                <a href="{{ $value['url'] }}">
                                    <i class="{{ $value['icon'] }}"></i> {{ $value['name'] }}
                                    @if (isset($value['countVar'], $value['countCustomClass']) && !empty($value['countVar']) && !empty($value['countCustomClass']))
                                    <span
                                        class="badge badge-pill badge-important{{ $value['countCustomClass'] }}">0</span>
                                    @endif
                                </a>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </li>
                    @endif --}}
                    @if (config('plugins.currencyexchange.installed'))
                    @include('currencyexchange::select-currency')
                    @endif

                    @if (config('settings.single.pricing_page_enabled') == '2')
                    <li class="nav-item pricing">
                        <a href="{{ \App\Helpers\UrlGen::pricing() }}" class="nav-link">
                            <i class="fas fa-tags"></i> {{ t('pricing_label') }}
                        </a>
                    </li>
                    @endif
                    <?php
                    $addListingUrl = \App\Helpers\UrlGen::addPost();
                    $addListingAttr = '';
                    if (!auth()->check()) {
                        if (config('settings.single.guests_can_post_listings') != '1') {
                            $addListingUrl = url('/login');
                            $addListingAttr = '';
                        }
                    }
                    if (config('settings.single.pricing_page_enabled') == '1') {
                        $addListingUrl = \App\Helpers\UrlGen::pricing();
                        $addListingAttr = '';
                    }
                    ?>
                    <li class="nav-item postadd add-post-max-width me-2">
                        <a class="btn btn-block btn-border btn-listing add-post-color shadow"
                            href="{{ $addListingUrl }}?new=1" {!! $addListingAttr !!}>
                            POST AD
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    {{-- Mega-Menu Navbar --}}
    <div class="nav-header pt-3 shadow">
        <nav id="megaMenu">
            {{-- <a onclick="myFunction()" id="sidebar-collapse" href="javascript:void(0);"
                class="sidebar-collapse-icon with-animation text-center mobile-menu-trigger">Browse All Categories
                <span class="bi bi-chevron-down"></span>
            </a> --}}
            <ul class="menu menu-bar mega-menu-hide pt-3">
                <li class="open-on-hover no-  open-on-hover">
                    <a href="{{ url(config('country.icode') . '/search') }}"
                        class="menu-link menu-bar-link hover-link" aria-haspopup="true">
                        <div id="loadCategoriesButton" class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-th-list"></i>
                            </span>
                            <span class="cat_name">
                                BROWSE ALL CATEGORIES
                            </span>
                        </div>
                    </a>
                    <ul id="nav-section" class="mega-menu mega-menu--multiLevel mega-menu-bg get-categories mega-ul-lg"
                        style="height:70vh; overflow-y:auto;margin-top: -20px">
                        <li class="active-sub-category">
                            <a style="background-color: transparent!important; color:#369!important;"
                                href="{{ url(config('country.icode') . '/search') }}"
                                class="menuLink-3427205540 menu-link menu-bar-link">
                                <span class="childName-3872504796 ">
                                    <b><i class="fas fa-th-list"></i> MAIN CATEGORIES </b>
                                </span>
                            </a>
                        </li>
                        <li class="mobile-menu-back-item">
                            <a href="#" style="color: black!important"
                                class="menu-link mobile-menu-back-link">Back</a>
                        </li>
                    </ul>
                </li>
                <li class="open-on-hover no-  open-on-hover">
                    <a href="//www.ezead.auction" target="_blank" class="menu-link menu-bar-link hover-link" tooltip="Discover the Vision Behind EzeAD" flow="down">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-gavel"></i>
                            </span>
                            <span class="cat_name">
                                Eze Auction
                            </span>
                        </div>
                    </a>
                </li>
                <li class="open-on-hover no-  open-on-hover">
                    <a href="//community.ezead.com/" class="menu-link menu-bar-link hover-link" target="_blank" tooltip="Discover the Vision Behind EzeAD" flow="down">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-users"></i>
                            </span>
                            <span class="cat_name">
                                Community
                            </span>
                        </div>
                    </a>
                </li>
                <li class="open-on-hover no-  open-on-hover">
                    <a href="//eze.email" target="_blank" class="menu-link menu-bar-link hover-link" tooltip="Discover the Vision Behind EzeAD" flow="down">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <span class="cat_name">
                                Eze.email
                            </span>
                        </div>
                    </a>
                </li>
                <li class="open-on-hover no-  open-on-hover">
                    <a href="//ezelive.com" target="_blank" class="menu-link menu-bar-link hover-link" tooltip="Discover the Vision Behind EzeAD" flow="down">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-question-circle"></i>
                            </span>
                            <span class="cat_name">
                                Ezelive Help
                            </span>
                        </div>
                    </a>
                </li>
                <li class="open-on-hover no-  open-on-hover">
                    <a href="//ezeadhost.com" class="menu-link menu-bar-link hover-link" target="_blank" tooltip="Discover the Vision Behind EzeAD" flow="down">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-server"></i>
                            </span>
                            <span class="cat_name">
                                Hosting
                            </span>
                        </div>
                    </a>
                </li>
                <li class="open-on-hover no-  open-on-hover">
                    <a href="//ezeadmedia.com/ezead-insight/" class="menu-link menu-bar-link hover-link" target="_blank" tooltip="Discover the Vision Behind EzeAD" flow="down">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fa fa-info-circle"></i>
                            </span>
                            <span class="cat_name">
                                Info
                            </span>
                        </div>
                    </a>
                </li>
                <li class="open-on-hover no-  open-on-hover">
                    <a href="//ezead.work" class="menu-link menu-bar-link hover-link" target="_blank" tooltip="Discover the Vision Behind EzeAD" flow="down">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-tasks"></i>
                            </span>
                            <span class="cat_name">
                                Jobs
                            </span>
                        </div>
                    </a>
                </li>
                {{-- <li class="open-on-hover no-  open-on-hover">
                    <a class="menu-link menu-bar-link hover-link">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-building"></i>
                            </span>
                            <span class="cat_name">
                                Rentals
                            </span>
                        </div>
                    </a>
                </li> --}}
                <li class="open-on-hover no-  open-on-hover">
                    <a href="//ezelancers.com" class="menu-link menu-bar-link hover-link" target="_blank" tooltip="Discover the Vision Behind EzeAD" flow="down">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-blog"></i>
                            </span>
                            <span class="cat_name">
                                Web Services
                            </span>
                        </div>
                    </a>
                </li>
                <li class="open-on-hover no-  open-on-hover">
                    <a href="//www.ezead.services" class="menu-link menu-bar-link hover-link" target="_blank" tooltip="Discover the Vision Behind EzeAD" flow="down">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-wrench"></i>
                            </span>
                            <span class="cat_name">
                                Services
                            </span>
                        </div>
                    </a>
                </li>
                <li class="open-on-hover no-  open-on-hover">
                    {{-- <a href="{{ auth()->check() ? '//shop.ezead.com/login?u=' . auth()->user()->id . '&r=ezead.com' : '//shop.ezead.com' }}"
                    target="_blank" class="menu-link menu-bar-link hover-link"> --}}
                    <a href="//shop.ezead.com" class="menu-link menu-bar-link hover-link" target="_blank" tooltip="Discover the Vision Behind EzeAD" flow="down">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-store"></i>
                            </span>
                            <span class="cat_name">
                                Stores
                            </span>
                        </div>
                    </a>
                </li>
                <li class="open-on-hover no-  open-on-hover">
                    <a href="https://play.google.com/store/apps/details?id=com.ezead.app" class="menu-link menu-bar-link hover-link" target="_blank" tooltip="Discover the Vision Behind EzeAD" flow="down">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-mobile"></i>
                            </span>
                            <span class="cat_name">
                                EzeAd App
                            </span>
                        </div>
                    </a>
                </li>
                <li class="open-on-hover no-  open-on-hover">
                    <a href="https://www.ezead.com/lp/search" class="menu-link menu-bar-link hover-link" target="_blank" tooltip="EzeAD All Listings" flow="down">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-search"></i>
                            </span>
                            <span class="cat_name">
                                Quick Search
                            </span>
                        </div>
                    </a>
                </li>
                <li class="nav-item postadd add-post-max-width" style="position: absolute;right: 0px;top: 35px">
                    <a id="themeMode" class="btn btn-light themeMode themeModeButton border shadow">
                        <i class="fa fa-moon"></i>
                        Light Mode </a>
                </li>
                <li class="mobile-menu-header">
                    <a href="javascript:void(0);" class="">
                        <span>Menu</span>
                    </a>
                </li>
            </ul>
            <ul class="nav-mobile-scrolling-links">
                <li class="nav-item">
                    <a href="//www.ezead.auction" class="nav-link custom-nav-link" aria-current="page"
                        target="_blank">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-gavel"></i>
                            </span>
                            <span class="cat_name">
                                Eze Auction
                            </span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="//community.ezead.com/" class="nav-link custom-nav-link" aria-current="page"
                        target="_blank">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-users"></i>
                            </span>
                            <span class="cat_name">
                                Community
                            </span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="//eze.email" class="nav-link custom-nav-link" aria-current="page" target="_blank">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <span class="cat_name">
                                Eze.email
                            </span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="//ezelive.com" class="nav-link custom-nav-link" aria-current="page" target="_blank">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-question-circle"></i>
                            </span>
                            <span class="cat_name">
                                Ezelive Help
                            </span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="//ezeadhost.com" class="nav-link custom-nav-link" aria-current="page" target="_blank">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-server"></i>
                            </span>
                            <span class="cat_name">
                                Hosting
                            </span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="//ezeadmedia.com/ezead-insight/" class="nav-link custom-nav-link" aria-current="page" target="_blank">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fa fa-info-circle"></i>
                            </span>
                            <span class="cat_name">
                                Info
                            </span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="//ezead.work" class="nav-link custom-nav-link" aria-current="page" target="_blank">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-tasks"></i>
                            </span>
                            <span class="cat_name">
                                Jobs
                            </span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="//ezelancers.com" class="nav-link custom-nav-link" aria-current="page">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-blog"></i>
                            </span>
                            <span class="cat_name">
                                Web Services
                            </span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="//www.ezead.services" class="nav-link custom-nav-link" aria-current="page"
                        target="_blank">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-wrench"></i>
                            </span>
                            <span class="cat_name">
                                Services
                            </span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="//shop.ezead.com" class="nav-link custom-nav-link" aria-current="page" target="_blank">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-store"></i>
                            </span>
                            <span class="cat_name">
                                Store
                            </span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://play.google.com/store/apps/details?id=com.ezead.app" class="nav-link custom-nav-link" aria-current="page" target="_blank">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-mobile"></i>
                            </span>
                            <span class="cat_name">
                                EzeAd App
                            </span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://www.ezead.com/lp/search" class="nav-link custom-nav-link" aria-current="page" target="_blank">
                        <div class="main-category-wrapper" style="display: grid;">
                            <span class="cat_icon text-center" style="font-size: 24px">
                                <i class="fas fa-search"></i>
                            </span>
                            <span class="cat_name">
                                Quick Search
                            </span>
                        </div>
                    </a>
                </li>
                <li class="nav-item postadd add-post-max-width pt-3">
                    <a id="themeMode" class="btn btn-light themeMode themeModeButton border shadow">
                        <i class="fa fa-moon"></i>
                        Light Mode </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<script>
    function myFunction() {
        if ($(".mega-menu-hide").is(":visible")) {
            $(".mega-menu-hide").hide();
        } else if ($(".mega-menu-hide").is(":hidden")) {
            $(".mega-menu-hide").show();
        }
    }
    var data = "";
    data +='<input class="form-control locinput input-rel searchtag-input" type="text" id="locSearch" name="location" placeholder="{{ t(' where ') }}" value="" data-bs-placement="top" data-bs-toggle="tooltipHover" >';
    document.getElementById("location-custom").onclick = function() {
        document.getElementById("errorModalBody").innerHTML = data;
    }
</script>