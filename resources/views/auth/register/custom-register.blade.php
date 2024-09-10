{{-- COUNTRY --}}
<?php $countryError = isset($errors) && $errors->has('register_country_code') ? ' is-invalid' : ''; ?>
<div class="row required">
    <div class="col-md-3"></div>
    <label class="col-md-3"> Country <sup>*</sup></label>
</div>
<div class="row mb-3 required">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <select name="register_country_code" id="register-country" class="form-control input-md{{ $countryError }}"
            aria-label="Default select example" style="background-color: #ffffff">
            <option value="" selected disabled>Select Country</option>
            @foreach ($countries as $code => $country)
                @php
                    $selected = old('register_country_code') == $country->get('code') ? 'selected' : '';
                @endphp
                @if (str($country->get('code')) != 'LP')
                    <option value="{{ str($country->get('code')) }}" {{ $selected }}>
                        {{ str($country->get('name')) }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>
</div>

{{-- PROVINCE / STATE --}}
<div class="row required register-province d-none">
    <div class="col-md-3"></div>
    <label class="col-md-3"> All Provinces / States </label>
</div>
<div class="row mb-3 required register-province d-none">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <select name="register_province_id" id="register-province" class="form-control input-md"
            aria-label="Default select example" style="background-color: #ffffff">
            {{-- Provinces jquery append option --}}
        </select>
    </div>
</div>

{{-- REGION --}}
<div class="row required register-regions d-none">
    <div class="col-md-3"></div>
    <label class="col-md-3"> Region </label>
</div>
<div class="row mb-3 required register-regions d-none">
    <div class="col-md-3"></div>
    <div class="col-md-9 col-lg-6">
        <select name="register_region_id" id="register-regions" class="form-control input-md"
            aria-label="Default select example" style="background-color: #ffffff">
            {{-- Regions jquery append option --}}
        </select>
    </div>
</div>

{{-- CITY --}}
<div class="row required register-cities d-none">
    <div class="col-md-3"></div>
    <label class="col-md-3"> City </label>
</div>
<div class="row mb-3 required register-cities d-none">
    <div class="col-md-3"></div>
    <div class="col-md-9 col-lg-6">
        <select name="register_city_id" id="register-cities" class="form-control input-md"
            aria-label="Default select example" style="background-color: #ffffff">
            <option selected disabled>Select City</option>
            {{-- Cities jquery append option --}}
        </select>
    </div>
</div>

{{-- NEIGHBHOUR --}}
<div class="row required register-neighbours d-none">
    <div class="col-md-3"></div>
    <label class="col-md-3"> Neighbour </label>
</div>
<div class="row mb-3 required register-neighbours d-none">
    <div class="col-md-3"></div>
    <div class="col-md-9 col-lg-6">
        <select name="register_neighbour_id" id="register-neighbours" class="form-control input-md"
            aria-label="Default select example" style="background-color: #ffffff">
            <option selected disabled>Select Neighbour</option>
            {{-- Neighbours jquery append option --}}
        </select>
    </div>
</div>
