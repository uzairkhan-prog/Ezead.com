<div class="container mb-3 hide-xs">
    <div class="row row-cols-lg-4 row-cols-md-3 g-2 p-1 px-2">
        @if (session()->has('city') && session()->has('city.childs') && count(session()->get('city.childs')) > 0)
            <div class="inner">
                <h3 class="pb-0">
                    <span style="font-weight: 700;" class="title-3">
                        All Neighbours
                    </span>
                </h3>
            </div>
        @elseif (session()->has('region'))
            <div class="inner">
                <h3 class="pb-0">
                    <span style="font-weight: 700;" class="title-3">
                        All Cities
                    </span>
                </h3>
            </div>
        @elseif (session()->has('province'))
            <div class="inner">
                <h3 class="pb-0">
                    <span style="font-weight: 700;" class="title-3">
                        All Regions
                    </span>
                </h3>
            </div>
        @elseif (session()->has('country'))
            <div class="inner">
                <h3 class="pb-0">
                    <span style="font-weight: 700;" class="title-3">
                        All Provinces
                    </span>
                </h3>
            </div>
        @else
            <div class="inner">
                <h3 class="pb-0">
                    <span style="font-weight: 700;" class="title-3">
                        All Countries
                    </span>
                </h3>
            </div>
        @endif
    </div>
    <div class="row row-cols-lg-4 row-cols-md-3 p-2 g-2">
        @if (session()->has('city') && session()->has('city.childs') && count(session()->get('city.childs')) > 0)
            @foreach (session('city.childs') as $item)
                <div class="col">
                    <ol>
                        <li class="pb-0">
                            <a href="#" class="neighbour-select" neighbourId="{{ $item->id }}">
                                <i class="fa fa-map-marker"></i> {{ $item->name }}
                            </a>
                        </li>
                    </ol>
                </div>
            @endforeach
        @elseif (session()->has('region'))
            @foreach (session('region.childs') as $item)
                <div class="col">
                    <ol>
                        <li class="pb-0">
                            <a href="#" class="city-select" cityId="{{ $item->id }}">
                                <i class="fa fa-city"></i> {{ $item->name }}
                            </a>
                        </li>
                    </ol>
                </div>
            @endforeach
        @elseif (session()->has('province'))
            @foreach (session('province.childs') as $item)
                <div class="col">
                    <ol>
                        <li class="pb-0">
                            <a href="#" class="region-select" regionId="{{ $item->id }}">
                                <i class="fa fa-map"></i> {{ $item->name }}
                            </a>
                        </li>
                    </ol>
                </div>
            @endforeach
        @elseif (session()->has('country'))
            @foreach (session('country.provinces') as $item)
                <div class="col">
                    <ol>
                        <li class="pb-0">
                            <a href="#" class="province-select" provinceId="{{ $item->id }}">
                                <i class="fa fa-flag"></i> {{ $item->name }}
                            </a>
                        </li>
                    </ol>
                </div>
            @endforeach
        @else
            @foreach ($countries as $country)
                @if (str($country->get('code')) != 'LP')
                    <div class="col">
                        <ol>
                            <li class="pb-0">
                                <a href="#" class="country-select" code="{{ str($country->get('code')) }}"
                                    style="font-size: 16px;">
                                    <img class="pe-1" src="{{ str($country->get('flag_url')) }}"
                                        alt="{{ str($country->get('name')) }}">
                                    {{ str($country->get('name')) }}
                                </a>
                            </li>
                        </ol>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
