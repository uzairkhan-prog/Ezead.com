<?php
$sectionOptions = $getCategoriesOp ?? [];
$sectionData ??= [];
$categories = (array) data_get($sectionData, 'categories');
$subCategories = (array) data_get($sectionData, 'subCategories');
$countPostsPerCat = (array) data_get($sectionData, 'countPostsPerCat');
$countPostsPerCat = collect($countPostsPerCat)
    ->keyBy('id')
    ->toArray();

$hideOnMobile = data_get($sectionOptions, 'hide_on_mobile') == '1' ? ' hidden-sm' : '';

$catDisplayType = data_get($sectionOptions, 'cat_display_type');
$maxSubCats = (int) data_get($sectionOptions, 'max_sub_cats');
?>
{{-- @includeFirst(
    [config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'],
    ['hideOnMobile' => $hideOnMobile]
) --}}

{{-- ORIGNAL CATEGORIES --}}
{{-- <div class="container{{ $hideOnMobile }} wide">
    <div class="col-xl-12 content-box layout-section">
        <div class="row row-featured row-featured-category">
            <div class="col-xl-12 box-title no-border">
                <div class="inner">
                    <h2>
                        <span class="title-3">{{ t('Browse by') }} <span
                                style="font-weight: bold;">{{ t('category') }}</span></span>
                        <a href="{{ \App\Helpers\UrlGen::sitemap() }}" class="sell-your-item">
                            {{ t('View more') }} <i class="fas fa-bars"></i>
                        </a>
                    </h2>
                </div>
            </div>

            @if ($catDisplayType == 'c_picture_list')

                @if (!empty($categories))
                    @foreach ($categories as $key => $cat)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 f-category">
                            <a href="{{ \App\Helpers\UrlGen::category($cat) }}">
                                <img src="{{ data_get($cat, 'picture_url') }}" class="lazyload img-fluid"
                                    alt="{{ data_get($cat, 'name') }}">
                                <h6>
                                    {{ data_get($cat, 'name') }}
                                    @if (config('settings.list.count_categories_listings'))
                                        &nbsp;({{ $countPostsPerCat[data_get($cat, 'id')]['total'] ?? 0 }})
                                    @endif
                                </h6>
                            </a>
                        </div>
                    @endforeach
                @endif
            @elseif ($catDisplayType == 'c_bigIcon_list')
                @if (!empty($categories))
                    @foreach ($categories as $key => $cat)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 f-category">
                            <a href="{{ \App\Helpers\UrlGen::category($cat) }}">
                                @if (in_array(config('settings.list.show_category_icon'), [2, 6, 7, 8]))
                                    <i class="{{ data_get($cat, 'icon_class') ?? 'fas fa-folder' }}"></i>
                                @endif
                                <h6>
                                    {{ data_get($cat, 'name') }}
                                    @if (config('settings.list.count_categories_listings'))
                                        &nbsp;({{ $countPostsPerCat[data_get($cat, 'id')]['total'] ?? 0 }})
                                    @endif
                                </h6>
                            </a>
                        </div>
                    @endforeach
                @endif
            @elseif (in_array($catDisplayType, ['cc_normal_list', 'cc_normal_list_s']))
                <div style="clear: both;"></div>
                <?php $styled = $catDisplayType == 'cc_normal_list_s' ? ' styled' : ''; ?>

                @if (!empty($categories))
                    <div class="col-xl-12">
                        <div class="list-categories-children{{ $styled }}">
                            <div class="row px-3">
                                @foreach ($categories as $key => $cols)
                                    <div
                                        class="col-md-4 col-sm-4 {{ count($categories) == $key + 1 ? 'last-column' : '' }}">
                                        @foreach ($cols as $iCat)
                                            <?php
                                            $randomId = '-' . substr(uniqid(rand(), true), 5, 5);
                                            ?>

                                            <div class="cat-list">
                                                <h3 class="cat-title rounded">
                                                    @if (in_array(config('settings.list.show_category_icon'), [2, 6, 7, 8]))
                                                        <i
                                                            class="{{ data_get($iCat, 'icon_class') ?? 'fas fa-check' }}"></i>&nbsp;
                                                    @endif
                                                    <a href="{{ \App\Helpers\UrlGen::category($iCat) }}">
                                                        {{ data_get($iCat, 'name') }}
                                                        @if (config('settings.list.count_categories_listings'))
                                                            &nbsp;({{ $countPostsPerCat[data_get($iCat, 'id')]['total'] ?? 0 }})
                                                        @endif
                                                    </a>
                                                    <span class="btn-cat-collapsed collapsed" data-bs-toggle="collapse"
                                                        data-bs-target=".cat-id-{{ data_get($iCat, 'id') . $randomId }}"
                                                        aria-expanded="false">
                                                        <span class="icon-down-open-big"></span>
                                                    </span>
                                                </h3>
                                                <ul
                                                    class="cat-collapse collapse show cat-id-{{ data_get($iCat, 'id') . $randomId }} long-list-home">
                                                    @if (isset($subCategories[data_get($iCat, 'id')]))
                                                        <?php $catSubCats = $subCategories[data_get($iCat, 'id')]; ?>
                                                        @foreach ($catSubCats as $iSubCat)
                                                            <li>
                                                                <a
                                                                    href="{{ \App\Helpers\UrlGen::category($iSubCat) }}">
                                                                    {{ data_get($iSubCat, 'name') }}
                                                                </a>
                                                                @if (config('settings.list.count_categories_listings'))
                                                                    &nbsp;({{ $countPostsPerCat[data_get($iSubCat, 'id')]['total'] ?? 0 }})
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                @endif
            @else
                <?php
                $listTab = [
                    'c_border_list' => 'list-border',
                ];
                $catListClass = isset($listTab[$catDisplayType]) ? 'list ' . $listTab[$catDisplayType] : 'list';
                ?>
                @if (!empty($categories))
                    <div class="col-xl-12">
                        <div class="list-categories">
                            <div class="row">
                                @foreach ($categories as $key => $items)
                                    <ul
                                        class="cat-list {{ $catListClass }} col-md-4 {{ count($categories) == $key + 1 ? 'cat-list-border' : '' }}">
                                        @foreach ($items as $k => $cat)
                                            <li>
                                                @if (in_array(config('settings.list.show_category_icon'), [2, 6, 7, 8]))
                                                    <i
                                                        class="{{ data_get($cat, 'icon_class') ?? 'fas fa-check' }}"></i>&nbsp;
                                                @endif
                                                <a href="{{ \App\Helpers\UrlGen::category($cat) }}">
                                                    {{ data_get($cat, 'name') }}
                                                </a>
                                                @if (config('settings.list.count_categories_listings'))
                                                    &nbsp;({{ $countPostsPerCat[data_get($cat, 'id')]['total'] ?? 0 }})
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            @endif

        </div>
    </div>
</div> --}}

{{-- CUSTOM CATEGORIES --}}
<div class="container{{ $hideOnMobile }} wide custom-wide-categories px-0">
    <div class="col-xl-12 content-box layout-section rounded-0 p-3">
        <div class="row row-featured row-featured-category">
            <div class="col-xl-12 box-title no-border">
                <div class="inner">
                    <h2>
                        <span class="title-3">{{ t('Browse by') }} <span
                                style="font-weight: bold;">{{ t('category') }}</span></span>
                        <a href="{{ \App\Helpers\UrlGen::sitemap() }}" class="sell-your-item mt-3">
                            View all categories <i class="fas fa-bars"></i>
                        </a>
                    </h2>
                </div>
            </div>

            @if ($catDisplayType == 'c_picture_list')

                @if (!empty($categories))
                    @foreach ($categories as $key => $cat)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                            <a href="{{ \App\Helpers\UrlGen::category($cat) }}">
                                <img src="{{ data_get($cat, 'picture_url') }}" class="lazyload img-fluid"
                                    alt="{{ data_get($cat, 'name') }}">
                                <h6>
                                    {{ data_get($cat, 'name') }}
                                    @if (config('settings.list.count_categories_listings'))
                                        &nbsp;({{ $countPostsPerCat[data_get($cat, 'id')]['total'] ?? 0 }})
                                    @endif
                                </h6>
                            </a>
                        </div>
                    @endforeach
                @endif
            @elseif ($catDisplayType == 'c_bigIcon_list')
                {{-- With Out Alphabetical  --}}
                {{-- @if (!empty($categories))
                    <ul class="custom-category mb-3">
                        @foreach ($categories as $key => $cat)
                            <li class="px-3 py-3 border-bottom">
                                <a href="{{ \App\Helpers\UrlGen::category($cat) }}">
                                    {{ data_get($cat, 'name') }}
                                    @if (config('settings.list.count_categories_listings'))
                                        &nbsp;({{ $countPostsPerCat[data_get($cat, 'id')]['total'] ?? 0 }})
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif --}}
                {{-- Custom Alphabetical --}}
                @if (!empty($categories))
                    @php
                        // Sort the categories alphabetically by name
                        usort($categories, function ($a, $b) {
                            return strcmp($a['name'], $b['name']);
                        });
                    @endphp
                    <ul class="custom-category mb-3">
                        @foreach ($categories as $key => $cat)
                            <li class="border-bottom">
                                <a href="{{ \App\Helpers\UrlGen::category($cat) }}">
                                    {{-- @if (in_array(config('settings.list.show_category_icon'), [2, 6, 7, 8]))
                                        <i class="{{ data_get($cat, 'icon_class') ?? 'fas fa-folder' }}"></i>
                                        @endif --}}
                                    {{ data_get($cat, 'name') }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
                {{-- Custom Get Ajax Categories --}}
                {{-- <ul id="get-parent-categories"
                    class="custom-category mb-3 categories-loader-middle banner-loader-middle">
                    <div class="spinner-grow banner-image-loader" style="width:4rem;height:4rem;color:#d85200;"
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </ul> --}}
            @elseif (in_array($catDisplayType, ['cc_normal_list', 'cc_normal_list_s']))
                <div style="clear: both;"></div>
                <?php $styled = $catDisplayType == 'cc_normal_list_s' ? ' styled' : ''; ?>

                @if (!empty($categories))
                    <div class="col-xl-12">
                        <div class="list-categories-children{{ $styled }}">
                            <div class="row px-3">
                                @foreach ($categories as $key => $cols)
                                    <div
                                        class="col-md-4 col-sm-4 {{ count($categories) == $key + 1 ? 'last-column' : '' }}">
                                        @foreach ($cols as $iCat)
                                            <?php
                                            $randomId = '-' . substr(uniqid(rand(), true), 5, 5);
                                            ?>

                                            <div class="cat-list">
                                                <h3 class="cat-title rounded">
                                                    @if (in_array(config('settings.list.show_category_icon'), [2, 6, 7, 8]))
                                                        <i
                                                            class="{{ data_get($iCat, 'icon_class') ?? 'fas fa-check' }}"></i>&nbsp;
                                                    @endif
                                                    <a href="{{ \App\Helpers\UrlGen::category($iCat) }}">
                                                        {{ data_get($iCat, 'name') }}
                                                        @if (config('settings.list.count_categories_listings'))
                                                            &nbsp;({{ $countPostsPerCat[data_get($iCat, 'id')]['total'] ?? 0 }})
                                                        @endif
                                                    </a>
                                                    <span class="btn-cat-collapsed collapsed" data-bs-toggle="collapse"
                                                        data-bs-target=".cat-id-{{ data_get($iCat, 'id') . $randomId }}"
                                                        aria-expanded="false">
                                                        <span class="icon-down-open-big"></span>
                                                    </span>
                                                </h3>
                                                <ul
                                                    class="cat-collapse collapse show cat-id-{{ data_get($iCat, 'id') . $randomId }} long-list-home">
                                                    @if (isset($subCategories[data_get($iCat, 'id')]))
                                                        <?php $catSubCats = $subCategories[data_get($iCat, 'id')]; ?>
                                                        @foreach ($catSubCats as $iSubCat)
                                                            <li>
                                                                <a
                                                                    href="{{ \App\Helpers\UrlGen::category($iSubCat) }}">
                                                                    {{ data_get($iSubCat, 'name') }}
                                                                </a>
                                                                @if (config('settings.list.count_categories_listings'))
                                                                    &nbsp;({{ $countPostsPerCat[data_get($iSubCat, 'id')]['total'] ?? 0 }})
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                @endif
            @else
                <?php
                $listTab = [
                    'c_border_list' => 'list-border',
                ];
                $catListClass = isset($listTab[$catDisplayType]) ? 'list ' . $listTab[$catDisplayType] : 'list';
                ?>
                @if (!empty($categories))
                    <div class="col-xl-12">
                        <div class="list-categories">
                            <div class="row">
                                @foreach ($categories as $key => $items)
                                    <ul
                                        class="cat-list {{ $catListClass }} col-md-4 {{ count($categories) == $key + 1 ? 'cat-list-border' : '' }}">
                                        @foreach ($items as $k => $cat)
                                            <li>
                                                @if (in_array(config('settings.list.show_category_icon'), [2, 6, 7, 8]))
                                                    <i
                                                        class="{{ data_get($cat, 'icon_class') ?? 'fas fa-check' }}"></i>&nbsp;
                                                @endif
                                                <a href="{{ \App\Helpers\UrlGen::category($cat) }}">
                                                    {{ data_get($cat, 'name') }}
                                                </a>
                                                @if (config('settings.list.count_categories_listings'))
                                                    &nbsp;({{ $countPostsPerCat[data_get($cat, 'id')]['total'] ?? 0 }})
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            @endif

        </div>
    </div>
</div>
@section('before_scripts')
    @parent
    @if ($maxSubCats >= 0)
        <script>
            var maxSubCats = {{ $maxSubCats }};
        </script>
    @endif
@endsection

@include('home.inc.price-banner')
