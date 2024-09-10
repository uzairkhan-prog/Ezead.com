<div class="banner-background">
    <div class="bread-crumb">
        <div class="container custom-background-color wide pb-4">
            <div class="row row-featured row-featured-category">
                <div class="col-xl-12 box-title px-0 pt-3">
                    <div class="inner">
                        <div class="row">
                            <div class="col-lg-8">
                                {{-- <h2>
                                    <span class="title-3 pe-3" style="font-weight: 600;">
                                        <i class="fa fa-globe pe-1"></i>
                                        Select Your Region To Search And Browse Local Listings
                                    </span>
                                </h2> --}}
                                <h2>
                                    <span>
                                        <img src="{{ url('images/flags/32/lp.png') }}" alt="All Regions" class="flag-icon custom-flag-icon mb-1">
                                    </span>
                                    <span class="theme-color" style="font-weight: 600;">
                                        Search Global Opportunities - Select Your Region to Browse Local Listings
                                    </span>
                                </h2>
                            </div>
                            <div class="col-lg-4 text-right custom-theme">
                                <h2 class="my-3">
                                    <span>
                                        <a href="{{ \App\Helpers\UrlGen::search() }}"
                                            style="font-size: 14px;font-weight:600;color:#37a864;">
                                            <i class="fa fa-eye"></i>
                                            EZE Search
                                        </a>
                                    </span>
                                </h2>
                                <h2 class="my-3">
                                    <span>
                                        <a href="{{ route('advance-search') }}"
                                            style="font-size: 14px;font-weight:600;color:#737373;">
                                            <i class="fa fa-filter"></i>
                                            Advanced Search
                                        </a>
                                    </span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <nav class="px-0 mt-3 @if (session()->has('country')) @else d-none @endif" aria-label="breadcrumb">
                    <ol class="default-breadcrumb">
                        @if (session()->has('country') ||
                        session()->has('province') ||
                        session()->has('region') ||
                        session()->has('city') ||
                        session()->has('neighbour'))
                        <li class="crumb country-breadcrumb @if (session()->has('country')) @else d-none @endif">
                            <div class="link pb-1">
                                <a class="px-2" href="{{ route('get-clear-section') }}">
                                    <i class="fas fa-home px-1"></i>
                                    World Home
                                </a>
                            </div>
                        </li>
                        @endif
                        <li class="crumb country-breadcrumb @if (session()->has('country')) @else d-none @endif">
                            <div class="link pb-1">
                                <a href="#" class="country-select" code="{{ session('country.code') }}">
                                    <i class="bi bi-globe"></i>
                                    <span class="breadcrumb-input px-2">{{ session('country.name') }}</span>
                                </a>
                            </div>
                        </li>
                        <li class="crumb province-breadcrumb @if (session()->has('province')) @else d-none @endif">
                            <div class="link pb-    1">
                                <a href="#" class="province-select" provinceId="{{ session('province.id') }}">
                                    <i class="fa
                                    fa-flag"></i>
                                    <span class="breadcrumb-input px-2">{{ session('province.name') }}</span>
                                </a>
                            </div>
                        </li>
                        <li class="crumb regions-breadcrumb @if (session()->has('region')) @else d-none @endif">
                            <div class="link pb-1">
                                <a href="#" class="region-select" regionId="{{ session('region.id') }}">
                                    <i class="fa
                                    fa-map"></i>
                                    <span class="breadcrumb-input px-2">{{ session('region.name') }}</span>
                                </a>
                            </div>
                        </li>
                        <li class="crumb cities-breadcrumb @if (session()->has('city')) @else d-none @endif">
                            <div class="link pb-1">
                                <a href="#" class="city-select" cityId="{{ session('city.id') }}">
                                    <i class="fa fa-city"></i>
                                    <span class="breadcrumb-input px-2">{{ session('city.name') }}</span>
                                </a>
                            </div>
                        </li>
                        <li class="crumb neighbours-breadcrumb d-none">
                            <div class="link pb-1">
                                <a href="#">
                                    <i class="fa fa-map-marker"></i>
                                    <span class="breadcrumb-input px-2"></span>
                                </a>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <hr>
            <div class="row">
                <div class="row row-cols-lg-12">
                    @if (session()->has('city') && session()->has('city.childs') && count(session()->get('city.childs')) > 0)
                    <div class="inner">
                        <h3 style="padding-left: 5px;">
                            <span style="font-weight: 700;" class="title-3">
                                All Neighbours
                            </span>
                        </h3>
                    </div>
                    @elseif (session()->has('region'))
                    <div class="inner">
                        <h3 style="padding-left: 5px;">
                            <span style="font-weight: 700;" class="title-3">
                                All Cities
                            </span>
                        </h3>
                    </div>
                    @elseif (session()->has('province'))
                    <div class="inner">
                        <h3 style="padding-left: 5px;">
                            <span style="font-weight: 700;" class="title-3">
                                All Regions
                            </span>
                        </h3>
                    </div>
                    @elseif (session()->has('country'))
                    <div class="inner">
                        <h3 style="padding-left: 5px;">
                            <span style="font-weight: 700;" class="title-3">
                                All Provinces
                            </span>
                        </h3>
                    </div>
                    @else
                    <div class="inner">
                        <h3 style="padding-left: 5px;">
                            <span style="font-weight: 700;" class="title-3">
                                <i class="far fa-map"></i>
                                All Countries
                            </span>
                        </h3>
                    </div>
                    @endif
                </div>
                <div class="row row-cols-lg-6 row-cols-md-3 row-cols-sm-2 row-cols-2">
                    @if (session()->has('city') && session()->has('city.childs') && count(session()->get('city.childs')) > 0)
                    @foreach (session('city.childs')->sortBy('name') as $item) <!-- Sort by name -->
                    <div class="col">
                        <ol>
                            <li class="border-bottom" style="padding:10px;">
                                <a href="#" class="neighbour-select" neighbourId="{{ $item->id }}">
                                    {{ $item->name }}
                                </a>
                            </li>
                        </ol>
                    </div>
                    @endforeach
                    @elseif (session()->has('region'))
                    @foreach (session('region.childs')->sortBy('name') as $item) <!-- Sort by name -->
                    <div class="col">
                        <ol>
                            <li class="border-bottom" style="padding:10px;">
                                <a href="#" class="city-select" cityId="{{ $item->id }}">
                                    {{ $item->name }}
                                </a>
                            </li>
                        </ol>
                    </div>
                    @endforeach
                    @elseif (session()->has('province'))
                    @foreach (session('province.childs')->sortBy('name') as $item) <!-- Sort by name -->
                    <div class="col">
                        <ol>
                            <li class="border-bottom" style="padding:10px;">
                                <a href="#" class="region-select" regionId="{{ $item->id }}">
                                    {{ $item->name }}
                                </a>
                            </li>
                        </ol>
                    </div>
                    @endforeach
                    @elseif (session()->has('country'))
                    @foreach (session('country.childs')->sortBy('name') as $item) <!-- Sort by name -->
                    <div class="col">
                        <ol>
                            <li class="border-bottom" style="padding:10px;">
                                <a href="#" class="province-select" provinceId="{{ $item->id }}">
                                    {{ $item->name }}
                                </a>
                            </li>
                        </ol>
                    </div>
                    @endforeach
                    @else
                    @foreach ($countries->sortBy('name') as $country) <!-- Sort by name -->
                    @if (str($country->get('code')) != 'LP')
                    <div class="col">
                        <ol>
                            <li style="padding:10px;">
                                <a href="#" class="country-select"
                                    code="{{ str($country->get('code')) }}" style="font-size:16px;white-space:nowrap;">
                                    <img class="pe-1" src="{{ str($country->get('flag_url')) }}"
                                        alt="{{ str($country->get('name')) }}">{{ str($country->get('name')) }}</a>
                            </li>
                        </ol>
                    </div>
                    @endif
                    @endforeach
                    @endif
                </div>
                @if (session()->has('country') ||
                session()->has('province') ||
                session()->has('region') ||
                session()->has('city') ||
                session()->has('neighbour'))
                <div class="row pt-3">
                    <div class="col-12 text-center">
                        <a href="{{ route('get-clear-section') }}" class="btn btn-primary" id="clear-section" style="padding-bottom:10px;">Clear
                            Section</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>