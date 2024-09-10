@php
    $bcTab ??= [];
    $admin ??= null;
    $city ??= null;
    
    $adminType = config('country.admin_type', 0);
    $relAdminType = in_array($adminType, ['1', '2']) ? $adminType : 1;
    $adminCode = data_get($city, 'subadmin' . $relAdminType . '_code') ?? (data_get($admin, 'code') ?? 0);
@endphp
{{-- Custom Hide Orignal Bread Crumb --}}
{{-- <div class="container my-3">
    <div class="row">
        <div class="col-10">
            <nav aria-label="breadcrumb" role="navigation" class="search-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>

                    @if (session()->has('country'))
                        <li class="breadcrumb-item">
                            <a href="#" class="country-select" code="{{ session('country.code') }}">
                                {{ session('country.name') }}
                            </a>
                        </li>
                    @else
                        <li class="breadcrumb-item">
                            <a href="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}">
                                {{ config('country.name') }}
                            </a>
                        </li>
                    @endif

                    @if (session()->has('province'))
                        <li class="breadcrumb-item">
                            <a href="#" class="province-select" provinceId="{{ session('province.id') }}">
                                {{ session('province.name') }}
                            </a>
                        </li>
                    @endif

                    @if (session()->has('region'))
                        <li class="breadcrumb-item">
                            <a href="#" class="region-select" regionId="{{ session('region.id') }}">
                                {{ session('region.name') }}
                            </a>
                        </li>
                    @endif

                    @if (session()->has('city'))
                        <li class="breadcrumb-item">
                            <a href="#" class="city-select" cityId="{{ session('city.id') }}">
                                {{ session('city.name') }}
                            </a>
                        </li>
                    @endif

                    @if (session()->has('neighbour'))
                        <li class="breadcrumb-item">
                            <a href="#">
                                {{ session('neighbour.name') }}
                            </a>
                        </li>
                    @endif

                    @if (is_array($bcTab) && count($bcTab) > 0)
                        @foreach ($bcTab as $key => $value)
                            @if ($value->has('position') && $value->get('position') > count($bcTab) + 1)
                                <li class="breadcrumb-item active">
                                    {!! $value->get('name') !!}
                                    &nbsp;
                                    @if (!empty($adminCode))
                                        <a href="#browseLocations" data-bs-toggle="modal"
                                            data-admin-code="{{ $adminCode }}"
                                            data-city-id="{{ data_get($city, 'id', 0) }}">
                                            <span class="caret"></span>
                                        </a>
                                    @endif
                                </li>
                            @else
                                <li class="breadcrumb-item"><a
                                        href="{{ $value->get('url') }}">{!! $value->get('name') !!}</a></li>
                            @endif
                        @endforeach
                    @endif

                </ol>
            </nav>
        </div>
        <div class="col-2 text-right">
            <a href="{{ route('advance-search') }}" class="btn btn-success">Advanced Search</a>
        </div>
    </div>
</div> --}}
{{-- Custom Add Bread Crumb --}}
<div class="bread-crumb">
    <div class="container custom-background-color wide pb-2 px-4">
        <div class="row row-featured row-featured-category">
            <nav class="px-0 mt-3 @if (session()->has('country')) @else d-none @endif" aria-label="breadcrumb">
                <ol class="default-breadcrumb">
                    @if (session()->has('country') ||
                    session()->has('province') ||
                    session()->has('region') ||
                    session()->has('city') ||
                    session()->has('neighbour'))
                    <li class="crumb country-breadcrumb @if (session()->has('country')) @else d-none @endif">
                        <div class="link pb-1">
                            <a class="px-2" href="{{ route('get-clear-section-search') }}">
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
        <div class="row row-cols-lg-6 row-cols-md-3 row-cols-sm-2 row-cols-2">
            @if (session()->has('city') && session()->has('city.childs') && count(session()->get('city.childs')) > 0)
            @foreach (session('city.childs')->sortBy('name') as $item) <!-- Sort by name -->
            <div class="col">
                <ol>
                    <li>
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
                    <li>
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
                    <li>
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
                    <li>
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
                    <li>
                        <a href="#" class="country-select" code="{{ str($country->get('code')) }}" style="font-size:16px;white-space:nowrap;">
                            <img class="pe-1" src="{{ str($country->get('flag_url')) }}" alt="{{ str($country->get('name')) }}">{{ str($country->get('name')) }}</a>
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
                <a href="{{ route('get-clear-section-search') }}" class="btn btn-primary" id="clear-section" style="padding-bottom:10px;">Clear
                    Section</a>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="container my-2 px-4">
<hr>
    <div class="row">
        <div class="col-10">
            <nav aria-label="breadcrumb" role="navigation" class="search-breadcrumb">
                <ol class="breadcrumb">

                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>

                    <li class="breadcrumb-item">
                        <a href="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}">
                            {{ t('all_categories') }}
                        </a>
                    </li>
                    
                    @if (is_array($bcTab) && count($bcTab) > 0)
                        @foreach ($bcTab as $key => $value)
                            @if ($value->has('position') && $value->get('position') > count($bcTab) + 1)
                                <li class="breadcrumb-item active">
                                    {!! $value->get('name') !!}
                                    &nbsp;
                                    @if (!empty($adminCode))
                                        <a href="#browseLocations" data-bs-toggle="modal"
                                            data-admin-code="{{ $adminCode }}"
                                            data-city-id="{{ data_get($city, 'id', 0) }}">
                                            <span class="caret"></span>
                                        </a>
                                    @endif
                                </li>
                            @else
                                <li class="breadcrumb-item"><a
                                        href="{{ $value->get('url') }}">{!! $value->get('name') !!}</a></li>
                            @endif
                        @endforeach
                    @endif

                </ol>
            </nav>
        </div>
    </div>
</div>

