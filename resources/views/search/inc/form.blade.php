@php
$admin ??= null;
$city ??= null;
$cat ??= null;

$cats ??= [];

// Keywords
$keywords = rawurldecode(request()->get('q'));

// Category
$qCategory = data_get($cat, 'id', request()->get('c'));
// Location
$qLocationId = 0;
$qAdminName = null;
if (!empty($city)) {
$qLocationId = data_get($city, 'id') ?? 0;
$qLocation = data_get($city, 'name');
} else {
$qLocationId = request()->get('l');
$qLocation = request()->get('location');
if (request()->filled('r')) {
$qAdminName = data_get($admin, 'name', request()->get('r'));
$isAdminCode = (bool) preg_match('#^[a-z]{2}\.(.+)$#i', $qAdminName);
$qLocation = !$isAdminCode ? t('area') . rawurldecode($qAdminName) : null;
}
}

$displayStatesSearchTip = config('settings.list.display_states_search_tip');
@endphp
<div class="container mt-2 mb-4 serp-search-bar">
    <form id="search" name="search" action="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}" method="GET">
        <div class="row m-0">
            <div class="col-12 px-0">
                <div class="row gx-1 gy-1 custom-search-findarea">

                    <div class="col-xl-4 col-md-3 col-sm-12 col-12">
                        <select name="c" id="catSearch" class="form-control selecter">
                            <option value="" {{ $qCategory == '' ? 'selected="selected"' : '' }}>
                                {{ t('all_categories') }}
                            </option>
                            @if (!empty($cats))
                            @foreach ($cats as $itemCat)
                            <option value="{{ data_get($itemCat, 'id') }}" @selected($qCategory==data_get($itemCat, 'id' ))>
                                {{ data_get($itemCat, 'name') }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-xl-5 col-md-4 col-sm-12 col-12">
                        <i class="fa fa-globe pe-1" style="color:#777777; position: absolute; padding: 16px;"></i>
                        <input name="q" class="form-control keyword border-none-custom border-none-custom-2" type="text" placeholder="What are you looking for ?" value="{{ $keywords }}">
                    </div>

                    <input type="hidden" id="rSearch" name="r" value="{{ $qAdminName }}">
                    <input type="hidden" id="lSearch" name="l" value="{{ $qLocationId }}">

                    <!--<div class="col-xl-3 col-md-3 col-sm-12 col-12 search-col locationicon">-->
                    <!--    @if ($displayStatesSearchTip)
-->
                    <!--        <input class="form-control locinput input-rel searchtag-input" type="text" id="locSearch"-->
                    <!--            name="location" placeholder="{{ t('where') }}" value="{{ $qLocation }}"-->
                    <!--            data-bs-placement="top" data-bs-toggle="tooltipHover"-->
                    <!--            title="{{ t('Enter a city name OR a state name with the prefix', ['prefix' => t('area')]) . t('State Name') }}">-->
                    <!--    @else-->
                    <!--        <input class="form-control locinput input-rel searchtag-input" type="text" id="locSearch"-->
                    <!--            name="location" placeholder="{{ t('where') }}" value="{{ $qLocation }}">-->
                    <!--
@endif-->
                    <!--</div>-->

                    <div class="col-xl-3 col-md-2 col-sm-12 col-12">
                        <button class="btn btn-block btn-primary">
                            <i class="fa fa-search"></i> <strong>{{ t('find') }}</strong>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>

@section('after_scripts')
@parent
<script>
    $(document).ready(function() {
        $('#locSearch').on('change', function() {
            if ($(this).val() == '') {
                $('#lSearch').val('');
                $('#rSearch').val('');
            }
        });
    });
</script>
@endsection