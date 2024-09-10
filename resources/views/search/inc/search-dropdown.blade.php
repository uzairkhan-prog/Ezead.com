<div class="container mb-2 serp-search-bar bg-custom rounded border d-none">
    <div class="row m-0">
        <div class="col-12 px-1 py-sm-1">
            <div class="row gx-1 gy-1">

                {{-- // COUNTRY --}}
                <div class="col-xl-3 col-md-3 col-sm-12 col-12">
                    <input type="hidden" value="{{ Route::currentRouteName() }}" class="searchPage">
                    <select class="form-select px-3 country py-2"
                        aria-label="Default select example">
                        <option selected disabled>Select Country</option>
                        @foreach ($countries as $code => $country)
                            @if (str($country->get('code')) != 'LP')
                                <option value="{{ str($country->get('code')) }}">
                                    {{ str($country->get('name')) }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                {{-- // PROVINCE / STATE --}}
                <div class="col-xl-3 col-md-3 col-sm-12 col-12 province d-none">
                    <select class="form-select px-3 province py-2" aria-label="Default select example">
                        {{-- Provinces jquery append option --}}
                    </select>
                </div>

                {{-- // REGION --}}
                <div class="col-xl-3 col-md-3 col-sm-12 col-12 regions d-none">
                    <select class="form-select px-3 regions py-2" aria-label="Default select example">
                        {{-- Provinces jquery append option --}}
                    </select>
                </div>

                {{-- // CITY --}}
                <div class="col-xl-3 col-md-3 col-sm-12 col-12 cities d-none">
                    <select class="form-select px-3 cities py-2" aria-label="Default select example">
                        <option selected disabled>Select City</option>
                        {{-- Cities jquery append option --}}
                    </select>
                </div>

                {{-- // NEIGHBHOUR --}}
                <div class="col-xl-3 col-md-3 col-sm-12 col-12 neighbours d-none">
                    <select class="form-select px-3 neighbours py-2"
                        aria-label="Default select example">
                        <option selected disabled>Select Neighbour</option>
                        {{-- Neighbours jquery append option --}}
                    </select>
                </div>

                {{-- // SUBMIT --}}
                <div class="col-xl-2 col-md-3 col-sm-12 col-12">
                    <button id="search-location-btn" type="button" class="btn btn-primary btn-block search-location-btn"
                        data-bs-dismiss="modal">Submit</button>
                </div>

            </div>
        </div>
    </div>
</div>
