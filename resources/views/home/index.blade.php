@extends('layouts.master')
@php
    $static_title = 'EzeAd Buy Sell Trade from Auctions & Classified Ads in USA, Canada and WorldWide';
    $current_title = '';
    if (session()->has('neighbour')) {
        $current_title = session('neighbour.name') . ' : ';
    } elseif (session()->has('city')) {
        $current_title = session('city.name') . ' : ';
    } elseif (session()->has('region')) {
        $current_title = session('region.name') . ' : ';
    } elseif (session()->has('province')) {
        $current_title = session('province.name') . ' : ';
    } elseif (session()->has('country')) {
        $current_title = session('country.name') . ' : ';
    }
@endphp
@section('title', $current_title . $static_title)
@section('search')
    @parent
@endsection

@section('content')
    <div class="main-container" id="homepage">

        @if (session()->has('flash_notification'))
            @includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
            <?php $paddingTopExists = true; ?>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @include('flash::message')
                    </div>
                </div>
            </div>
        @endif
        @include('home.inc.banner')
        @include('home.inc.breadCrumb')
        @if (!empty($sections))
            @foreach ($sections as $section)
                <?php
                $section ??= [];
                $sectionView = data_get($section, 'view');
                $sectionData = (array) data_get($section, 'data');
                ?>
                @if (!empty($sectionView) && view()->exists($sectionView))
                    @includeFirst(
                        [config('larapen.core.customizedViewPath') . $sectionView, $sectionView],
                        [
                            'sectionData' => $sectionData,
                            'firstSection' => $loop->first,
                        ]
                    )
                @endif
            @endforeach
        @endif
        @include('home.inc.promotions-banner')
    </div>
@endsection

@section('after_scripts')
@endsection
