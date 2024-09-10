@if (Auth::check())
    @php
        $createCountryAuth = Auth::User()->country_code;
    @endphp
    <input id="hidden_user_id" type="hidden" value="{{ Auth::id() }}">
    {{-- Country --}}
    <div class="row create-countries">
        <div class="col-md-3"></div>
        <label class="col-md-3 text-start col-form-label" for="tags">Country <sup>*</sup></label>
    </div>
    <div class="row mb-3 create-countries">
        <div class="col-md-3"></div>
        <div class="col-md-6 removeClassEditPage">
            <select id="country" name="new_country_code" class="form-control countries country">
                <option disabled>Select a Country</option>
                @foreach ($countries as $code => $country)
                    @if (str($country->get('code')) != 'LP')
                        {{ $selected = '' }}
                        @if (str($country->get('code')) == $createCountryAuth)
                            {{ $selected = 'selected' }}
                        @endif
                        <option value="{{ str($country->get('code')) }}" {{ $selected }}>
                            {{ str($country->get('name')) }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    {{-- Country --}}
    {{-- <div class="row mb-3 create-countries">
        <label class="col-md-3 col-form-label" for="tags">Country <sup>*</sup></label>
        <div class="col-md-8 removeClassEditPage">
            <select id="create-countries" country-code="{{ isset($post) ? $post['country_code'] : 0 }}" name="country_code"
                class="form-control">
                create-countries with jquery
            </select>
        </div>
    </div> --}}

    {{-- Province --}}
    <div class="row create-province d-none">
        <div class="col-md-3"></div>
        <label class="col-md-3 text-start col-form-label" for="tags">All Provinces / States <sup>*</sup></label>
    </div>
    <div class="row mb-3 create-province d-none">
        <div class="col-md-3"></div>
        <div class="col-md-6 removeClassEditPage">
            <select id="create-provinces" province-id="{{ isset($post) ? $post['province_id'] : 0 }}" name="province_id"
                class="form-control">
                {{-- create-provinces with jquery --}}
            </select>
        </div>
    </div>
    {{-- Region --}}
    <div class="row create-regions d-none">
        <div class="col-md-3"></div>
        <label class="col-md-3 text-start col-form-label" for="tags">Region <sup>*</sup></label>
    </div>
    <div class="row mb-3 create-regions d-none">
        <div class="col-md-3"></div>
        <div class="col-md-6 removeClassEditPage">
            <select id="create-regions" region-id="{{ isset($post) ? $post['region_id'] : 0 }}" name="region_id"
                class="form-control">
                {{-- create-regions with jquery --}}
            </select>
        </div>
    </div>
    {{-- City--}}
    <div class="row create-cities d-none">
        <div class="col-md-3"></div>
        <label class="col-md-3 text-start col-form-label" for="tags">City <sup>*</sup></label>
    </div>
    <div class="row mb-3 create-cities d-none">
        <div class="col-md-3"></div>
        <div class="col-md-6 removeClassEditPage">
            <select id="create-cities" new-city-id="{{ isset($post) ? $post['new_city_id'] : 0 }}" name="new_city_id"
                class="form-control">
                {{-- create-cities with jquery --}}
            </select>
        </div>
    </div>
    {{-- Neighbour --}}
    <div class="row create-neighbours d-none">
        <div class="col-md-3"></div>
        <label class="col-md-3 text-start col-form-label" for="tags">Neighbour <sup>*</sup></label>
    </div>
    <div class="row mb-3 create-neighbours d-none">
        <div class="col-md-3"></div>
        <div class="col-md-6 removeClassEditPage">
            <select id="create-neighbours" neighbour-id="{{ isset($post) ? $post['neighbour_id'] : 0 }}"
                name="neighbour_id" class="form-control">
                create-neighbours with jquery
            </select>
        </div>
    </div>

    {{-- Province --}}
    <div class="row province d-none">
        <div class="col-md-3"></div>
        <label class="col-md-3 text-start col-form-label" for="tags">Province <sup>*</sup></label>
    </div>
    <div class="row mb-3 province d-none">
        <div class="col-md-3"></div>
        <div class="col-md-6 removeClassEditPage">
            <select id="province" name="new_province_id" class="form-control province">
                {{-- provinces with jquery --}}
            </select>
        </div>
    </div>
    {{-- Region --}}
    <div class="row regions d-none">
        <div class="col-md-3"></div>
        <label class="col-md-3 text-start col-form-label" for="tags">Region <sup>*</sup></label>
    </div>
    <div class="row mb-3 regions d-none">
        <div class="col-md-3"></div>
        <div class="col-md-6 removeClassEditPage">
            <select id="regions" name="new_region_id" class="form-control regions">
                {{-- regions with jquery --}}
            </select>
        </div>
    </div>
    {{-- City --}}
    <div class="row cities d-none">
        <div class="col-md-3"></div>
        <label class="col-md-3 text-start col-form-label" for="tags">City <sup>*</sup></label>
    </div>
    <div class="row mb-3 cities d-none">
        <div class="col-md-3"></div>
        <div class="col-md-6 removeClassEditPage">
            <select id="cities" name="new_new_city_id" class="form-control cities">
                {{-- cities with jquery --}}
            </select>
        </div>
    </div>
    {{-- Neighbour --}}
    <div class="row neighbours d-none">
        <div class="col-md-3"></div>
        <label class="col-md-3 text-start col-form-label" for="tags">Neighbour <sup>*</sup></label>
    </div>
    <div class="row mb-3 neighbours d-none">
        <div class="col-md-3"></div>
        <div class="col-md-6 removeClassEditPage">
            <select id="neighbours" name="new_neighbour_id" class="form-control neighbours">
                {{-- neighbours with jquery --}}
            </select>
        </div>
    </div>
@endif