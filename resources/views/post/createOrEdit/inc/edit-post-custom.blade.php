{{-- // Provinces \\ --}}
@if (Auth::check())
    <input id="hidden_user_id" type="hidden" value="{{ Auth::id() }}">
    <input id="hidden_post_id" type="hidden" value="{{ $post['id'] }}">
    {{-- // Country \\ --}}
    <div class="row mb-3 create-countries">
        <label class="col-md-3 col-form-label" for="tags">Country <sup>*</sup></label>
        <div class="col-md-8 removeClassEditPage">
            <select id="country" name="new_country_code" class="form-control countries country">
                <option disabled>Select a Country</option>
                @foreach ($countries as $code => $country)
                    @if (str($country->get('code')) != 'LP')
                        {{ $selected = '' }}
                        @if (str($country->get('code')) == $post['country_code'])
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
    <div class="row mb-3 create-province d-none">
        <label class="col-md-3 col-form-label" for="tags">Province <sup>*</sup></label>
        <div class="col-md-8">
            <select id="create-provinces" province-id="{{ isset($post) ? $post['province_id'] : 0 }}" name="province_id"
                class="form-control selected-location-province">
                {{-- create-provinces with jquery --}}
            </select>
        </div>
    </div>
    {{-- // Region \\ --}}
    <div class="row mb-3 create-regions d-none">
        <label class="col-md-3 col-form-label" for="tags">Region <sup>*</sup></label>
        <div class="col-md-8">
            <select id="create-regions" region-id="{{ isset($post) ? $post['region_id'] : 0 }}" name="region_id"
                class="form-control selected-location-region">
                {{-- create-regions with jquery --}}
            </select>
        </div>
    </div>
    {{-- // City \\ --}}
    <div class="row mb-3 create-cities d-none">
        <label class="col-md-3 col-form-label" for="tags">City <sup>*</sup></label>
        <div class="col-md-8">
            <select id="create-cities" new-city-id="{{ isset($post) ? $post['new_city_id'] : 0 }}" name="new_city_id"
                class="form-control selected-location-city">
                {{-- create-cities with jquery --}}
            </select>
        </div>
    </div>
    {{-- // Neighbour \\ --}}
    <div class="row mb-3 create-neighbours d-none">
        <label class="col-md-3 col-form-label" for="tags">Neighbour <sup>*</sup></label>
        <div class="col-md-8">
            <select id="create-neighbours" neighbour-id="{{ isset($post) ? $post['neighbour_id'] : 0 }}"
                name="neighbour_id" class="form-control selected-location-neighbour">
                create-neighbours with jquery
            </select>
        </div>
    </div>

    {{-- // Province \\ --}}
    <div class="row mb-3 province d-none">
        <label class="col-md-3 col-form-label" for="tags">Province <sup>*</sup></label>
        <div class="col-md-8 removeClassEditPage">
            <select id="province" name="new_province_id" class="form-control province selected-location-province">
                {{-- provinces with jquery --}}
            </select>
        </div>
    </div>
    {{-- // Region \\ --}}
    <div class="row mb-3 regions d-none">
        <label class="col-md-3 col-form-label" for="tags">Region <sup>*</sup></label>
        <div class="col-md-8 removeClassEditPage">
            <select id="regions" name="new_region_id" class="form-control regions selected-location-region">
                {{-- regions with jquery --}}
            </select>
        </div>
    </div>
    {{-- // City \\ --}}
    <div class="row mb-3 cities d-none">
        <label class="col-md-3 col-form-label" for="tags">City <sup>*</sup></label>
        <div class="col-md-8 removeClassEditPage">
            <select id="cities" name="new_new_city_id" class="form-control cities selected-location-city">
                {{-- cities with jquery --}}
            </select>
        </div>
    </div>
    {{-- // Neighbour \\ --}}
    <div class="row mb-3 neighbours d-none">
        <label class="col-md-3 col-form-label" for="tags">Neighbour <sup>*</sup></label>
        <div class="col-md-8 removeClassEditPage">
            <select id="neighbours" name="new_neighbour_id" class="form-control neighbours selected-location-neighbour">
                {{-- neighbours with jquery --}}
            </select>
        </div>
    </div>
@endif
