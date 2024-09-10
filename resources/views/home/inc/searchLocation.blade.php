<form>
    @csrf
{{-- // COUNTRY --}}
<div class="pb-4">
    <label for="formGroupExampleInput" class="form-label" style="color: #3f6f9f;">
        <h4>
            Select Country <i class="bi bi-globe"></i>
        </h4>
    </label>
    <select id="country" class="form-select px-3 country" aria-label="Default select example">
        <option selected disabled>Select Country</option>
        @foreach ($countries as $code => $country)
            @if (str($country->get('code')) != 'LP')
                <option value="{{ str($country->get('code')) }}">{{ str($country->get('name')) }}</option>
            @endif
        @endforeach
    </select>
</div>

{{-- // PROVINCE / STATE --}}
<div class="pb-4 province d-none">
    <label for="formGroupExampleInput" class="form-label" style="color: #3f6f9f;">
        <h4>
            All Province/State <i class="fa fa-flag"></i>
        </h4>
    </label>
    <select id="province" class="form-select px-3 province" aria-label="Default select example">
        {{-- Provinces jquery append option --}}
    </select>
</div>

{{-- // REGION --}}
<div class="pb-4 regions d-none">
    <label for="formGroupExampleInput" class="form-label" style="color: #3f6f9f;">
        <h4>
            Select Region <i class="fa fa-map"></i>
        </h4>
    </label>
    <select id="regions" class="form-select px-3 regions" aria-label="Default select example">
        {{-- Provinces jquery append option --}}
    </select>
</div>

{{-- // CITY --}}
<div class="pb-4 cities d-none">
    <label for="formGroupExampleInput" class="form-label" style="color: #3f6f9f;">
        <h4>
            Select City <i class="fa fa-city"></i>
        </h4>
    </label>
    <select id="cities" class="form-select px-3 cities" aria-label="Default select example">
        <option selected disabled>Select City</option>
        {{-- Cities jquery append option --}}
    </select>
</div>

{{-- // NEIGHBHOUR --}}
<div class="pb-4 neighbours d-none">
    <label for="formGroupExampleInput" class="form-label" style="color: #3f6f9f;">
        <h4>
            Select Neighbour <i class="fa fa-map-marker"></i>
        </h4>
    </label>
    <select id="neighbours" class="form-select px-3 neighbours" aria-label="Default select example">
        <option selected disabled>Select Neighbour</option>
        {{-- Neighbours jquery append option --}}
    </select>
</div>
</form>
