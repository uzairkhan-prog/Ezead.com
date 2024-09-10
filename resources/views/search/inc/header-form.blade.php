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

<!-- Modal -->
{{-- <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header px-3">
                <h4 class="modal-title" id="errorModalTitle">
                    Title
                </h4>

                <button type="button" class="close" data-bs-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">{{ t('Close') }}</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div id="errorModalBody" class="col-12">
                        Content...
                    </div>
                </div>
            </div>

            <div class='modal-footer'>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ t('Close') }}</button>
            </div>

        </div>
    </div>
</div> --}}

<li class="serp-search-bar custom-serp-search-bar">
    <form name="search" action="{{ \App\Helpers\UrlGen::searchWithoutQuery() }}" method="GET">
        <div class="row gx-1 gy-1 header-col-margin">
            <div class="col-auto input-icons mobile-input ipad-input px-0">
                <i class="fa fa-search icon"></i>
                <input class="height-header-serch-bar border-what input-field form-control keyword" type="text"
                    value="{{ $keywords }}" placeholder="What are you looking for ?">
                {{-- <input name="q" class="form-control keyword" type="text"
                            placeholder="What are you looking for ?" value="{{ $keywords }}"> --}}
            </div>
            <input type="hidden" name="r" value="{{ $qAdminName }}">
            <input type="hidden" name="l" value="{{ $qLocationId }}">
            <div class="col-auto px-0 mobile-input">
                <select name="c" class="height-header-serch-bar select-category form-control selecter custom">
                    <option value="" {{ $qCategory == '' ? 'selected="selected"' : '' }}>
                        {{ t('all_categories') }}
                    </option>
                    @if (!empty($categories))
                        @foreach ($categories->sortBy('name') as $itemCat)
                            @if ($itemCat->parent_id == null)
                                <option value="{{ data_get($itemCat, 'id') }}" @selected($qCategory == data_get($itemCat, 'id'))>
                                    <i class="{{ data_get($itemCat, 'icon_class') ?? 'fas fa-folder' }}"></i>
                                    {{ data_get($itemCat, 'name') }}
                                </option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-auto px-0 mobile-input">
                <button class="btn-block height-header-serch-bar btn border button__futureSecondary-3729380201">Search</button>
            </div>

            @php
                $static_country = config('country.name');
                $current_locationn = '';
            @endphp

            <div class="col-auto search-col locationicon px-1 mobile-input">
                <a id="location-custom" data-bs-toggle="modal" data-bs-target="#search-Location"
                    class="position-relative top-50 start-50 translate-middle locationModalTrigger-555572005">
                    <i class="bi bi-geo-alt px-2"></i>
                    @if (session()->has('neighbour'))
                        <span class="text-3814801860 SubmitSearchButtonAdd">
                            {{ session('neighbour.name') }}
                        </span>
                    @elseif (session()->has('city'))
                        <span class="text-3814801860 SubmitSearchButtonAdd">
                            {{ session('city.name') }}
                        </span>
                    @elseif (session()->has('region'))
                        <span class="text-3814801860 SubmitSearchButtonAdd">
                            {{ session('region.name') }}
                        </span>
                    @elseif (session()->has('province'))
                        <span class="text-3814801860 SubmitSearchButtonAdd">
                            {{ session('province.name') }}
                        </span>
                    @elseif (session()->has('country'))
                        <span class="text-3814801860 SubmitSearchButtonAdd">
                            {{ session('country.name') }}
                        </span>
                    @else
                        <span class="text-3814801860 SubmitSearchButton">{{ $static_country }}</span>
                    @endif
                </a>
            </div>
        </div>
    </form>
</li>

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
