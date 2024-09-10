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
@includeFirst([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'])
<style>
    #error-message {
        display: none;
        top: 20px;
        padding: 20px;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }

    .custom-findarea {
        display: flex;
        align-items: center;
        flex-grow: 1;
    }

    .custom-findarea input {
        flex-grow: 1;
        border: none;
    }

    .advanced-search-btn {
        background: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
        font-size: 13px;
        font-weight: 400;
        padding: 18px;
    }

    @media (max-width: 768px) {

        .custom-findarea,
        .advanced-search-btn {
            flex-direction: column;
            align-items: stretch;
            margin-left: 0;
            margin-top: 10px;
        }
    }

    @media (max-width: 576px) {

        .custom-findarea,
        .advanced-search-btn {
            flex-direction: column;
            align-items: stretch;
            margin-left: 0;
            margin-top: 10px;
        }
    }
</style>

<div class="container serp-search-bar">
    <h1 class="text-center title-3 my-4 pb-0 mobile-font-size-heading">
        Find Anything - Anywhere
    </h1>
    <p class="text-center title-3 mb-4 mt-5 pb-0 mobile-font-size-heading" style="color: #37a864;"> Your EZE Posts, Free Global to Local Reach </p>
    <form id="custom-hide-search" class="px-5 mx-5" name="search" action="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}" method="GET">
        <div class="row m-0">
            <div class="col-12 custom-findarea-spacing d-flex flex-wrap align-items-center">
                <div class="custom-findarea">
                    <img src="{{ url('images/flags/32/lp.png') }}" alt="All Regions" class="flag-icon custom-flag-icon">
                    <i class="fa fa-globe pe-1 d-none" style="color:#777777; position: absolute; padding: 16px;"></i>
                    <input name="q" class="keyword border-none-custom" type="text" placeholder="What are you looking for, today?" value="{{ $keywords }}">
                    <button class="btn btn-border btn-post btn-listing custom-btn-block">
                        <i class="fa fa-search"></i>
                        Find Now
                    </button>
                </div>
                <input type="hidden" name="r" value="{{ $qAdminName }}">
                <input type="hidden" name="l" value="{{ $qLocationId }}">
            </div>
        </div>
    </form>
</div>

@php
$static_country = config('country.name');
$current_locationn = '';
@endphp

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