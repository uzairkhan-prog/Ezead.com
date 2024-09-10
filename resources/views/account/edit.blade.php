{{--
 * LaraClassifier - Classified Ads Web Application
 * Copyright (c) BeDigit. All Rights Reserved
 *
 * Website: https://laraclassifier.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
--}}
@extends('layouts.master')

@php
    $stats ??= [];
    $countThreads = data_get($stats, 'threads.all') ?? 0;
    $postsVisits = data_get($stats, 'posts.visits') ?? 0;
    $countPosts = (data_get($stats, 'posts.published') ?? 0) + (data_get($stats, 'posts.archived') ?? 0) + (data_get($stats, 'posts.pendingApproval') ?? 0);
    $countFavoritePosts = data_get($stats, 'posts.favourite') ?? 0;
@endphp

@section('content')
    @includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
    
    <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-3 page-sidebar">
                    @includeFirst([
                        config('larapen.core.customizedViewPath') . 'account.inc.sidebar',
                        'account.inc.sidebar',
                    ])
                </div>

                <div class="col-md-9 page-content">

                    @include('flash::message')

                    @if (isset($errors) && $errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="{{ t('Close') }}"></button>
                            <h5><strong>{{ t('oops_an_error_has_occurred') }}</strong></h5>
                            <ul class="list list-check">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div id="avatarUploadError" class="center-block" style="width:100%; display:none"></div>
                    <div id="avatarUploadSuccess" class="alert alert-success fade show" style="display:none;"></div>

                    <div class="inner-box default-inner-box">
                        <div class="row">
                            <div class="col-md-4 col-sm-3 col-12">
                                <h3 class="no-padding text-center-480 useradmin">
                                    <a href="">
                                        {{-- <img id="userImg" class="userImg" src="{{ $user->photo_url }}"
                                            alt="user">&nbsp; --}}
                                        @if ($user && $user->userDetail && $user->userDetail->profile_photo)
                                            <img id="userImg" class="userImg"
                                                src="{{ env('CLOUDFLARE_R2_URL') . '/assets/images/' . $user->userDetail->profile_photo }}"
                                                alt="user">&nbsp;
                                        @else
                                            <img id="userImg" class="userImg"
                                                src="{{ env('CLOUDFLARE_R2_URL') . '/storage/app/default/user.png' }}" alt="user">&nbsp;
                                        @endif
                                        {{ $user->name }}
                                    </a>
                                </h3>
                            </div>

                            <div class="col-md-8 col-sm-9 col-12">
                                <div class="header-data text-center-xs">

                                    {{-- Threads Stats --}}
                                    <div class="hdata">
                                        <div class="mcol-left">
                                            <i class="fas fa-envelope ln-shadow"></i>
                                        </div>
                                        <div class="mcol-right">
                                            {{-- Number of messages --}}
                                            <p>
                                                <a href="{{ url('account/messages') }}">
                                                    {{ \App\Helpers\Number::short($countThreads ?? 0) }}
                                                    <em>{{ trans_choice('global.count_mails', getPlural($countThreads ?? 0), [], config('app.locale')) }}</em>
                                                </a>
                                            </p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    {{-- Traffic Stats --}}
                                    <div class="hdata">
                                        <div class="mcol-left">
                                            <i class="fa fa-eye ln-shadow"></i>
                                        </div>
                                        <div class="mcol-right">
                                            {{-- Number of visitors --}}
                                            <p>
                                                <a href="{{ url('account/posts/list') }}">
                                                    {{ \App\Helpers\Number::short($postsVisits ?? 0) }}
                                                    <em>{{ trans_choice('global.count_visits', getPlural($postsVisits ?? 0), [], config('app.locale')) }}</em>
                                                </a>
                                            </p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    {{-- Listings Stats --}}
                                    <div class="hdata">
                                        <div class="mcol-left">
                                            <i class="fas fa-bullhorn ln-shadow"></i>
                                        </div>
                                        <div class="mcol-right">
                                            {{-- Number of listings --}}
                                            <p>
                                                <a href="{{ url('account/posts/list') }}">
                                                    {{ \App\Helpers\Number::short($countPosts ?? 0) }}
                                                    <em>{{ trans_choice('global.count_listings', getPlural($countPosts ?? 0), [], config('app.locale')) }}</em>
                                                </a>
                                            </p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    {{-- Favorites Stats --}}
                                    <div class="hdata">
                                        <div class="mcol-left">
                                            <i class="fa fa-user ln-shadow"></i>
                                        </div>
                                        <div class="mcol-right">
                                            {{-- Number of favorites --}}
                                            <p>
                                                <a href="{{ url('account/posts/favourite') }}">
                                                    {{ \App\Helpers\Number::short($countFavoritePosts ?? 0) }}
                                                    <em>{{ trans_choice('global.count_favorites', getPlural($countFavoritePosts ?? 0), [], config('app.locale')) }}
                                                    </em>
                                                </a>
                                            </p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    {{-- Custom Visit Store Stats --}}
                                    <div class="hdata">
                                        <div class="mcol-left">
                                            <i class="fa fa-store ln-shadow"></i>
                                        </div>
                                        <div class="mcol-right">
                                            {{-- Number of favorites --}}
                                            <p>
                                                <a href="{{ auth()->check() ? 'https://shop.ezead.com/login?u=' . auth()->user()->id . '&r=ezead.com' : 'https://shop.ezead.com/' }}"
                                                    target="_blank">
                                                    &nbsp;
                                                    <em>mystore</em>
                                                </a>
                                            </p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            {{-- Custom Add col All Listing --}}
                            <div class="col-md-4 col-sm-3 col-12 py-3">
                                <h4 class="no-padding text-center-480 useradmin">
                                    <a href="{{ url('account/posts/list') }}">
                                        <i class="fas fa-th-list"></i>
                                        <span>All
                                            {{ trans_choice('global.count_listings', getPlural($countPosts ?? 0), [], config('app.locale')) }}</span>
                                        ({{ \App\Helpers\Number::short($countPosts ?? 0) }})
                                    </a>
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="inner-box default-inner-box create-page-change-class" style="overflow: visible;">
                        <div class="welcome-msg">
                            <h3 class="page-sub-header2 clearfix no-padding">{{ t('Hello') }} {{ $user->name }} !
                            </h3>
                            <span class="page-sub-header-sub small">
                                {{ t('You last logged in at') }}:
                                {{ \App\Helpers\Date::format($user->last_login_at, 'datetime') }}
                            </span>
                        </div>

                        <div id="accordion" class="panel-group">

                            {{-- PHOTO --}}
                            <div class="card card-default d-none">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <a href="#photoPanel" data-bs-toggle="collapse"
                                            data-parent="#accordion">{{ t('Photo or Avatar') }}</a>
                                    </h4>
                                </div>
                                @php
                                    $photoPanelClass = '';
                                    $photoPanelClass = request()->filled('panel') ? (request()->get('panel') == 'photo' ? 'show' : $photoPanelClass) : (old('panel') == '' || old('panel') == 'photo' ? 'show' : $photoPanelClass);
                                @endphp
                                <div class="panel-collapse collapse {{ $photoPanelClass }}" id="photoPanel">
                                    <div class="card-body">
                                        <form name="photoUpdate" class="form-horizontal" role="form" method="POST"
                                            action="{{ url('account/photo') }}">
                                            <input type="hidden" value="{{ auth()->user()->id }}" name="id" />
                                            <div class="row">
                                                <div class="col-xl-12 text-center">

                                                    <?php $photoError = (isset($errors) and $errors->has('photo')) ? ' is-invalid' : ''; ?>
                                                    <div class="photo-field">
                                                        <div class="file-loading">
                                                            <input id="photoField" name="photo" type="file"
                                                                class="file {{ $photoError }}">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            {{-- USER --}}
                            <div class="card card-default">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <a href="#userPanel" aria-expanded="true" data-bs-toggle="collapse"
                                            data-parent="#accordion">{{ t('Account Details') }}</a>
                                    </h4>
                                </div>
                                @php
                                    $userPanelClass = '';
                                    $userPanelClass = request()->filled('panel') ? (request()->get('panel') == 'user' ? 'show' : $userPanelClass) : (old('panel') == '' || old('panel') == 'user' ? 'show' : $userPanelClass);
                                @endphp
                                <div class="panel-collapse collapse {{ $userPanelClass }}" id="userPanel">
                                    <div class="card-body">
                                        <form name="details" class="form-horizontal" role="form" method="POST"
                                            action="{{ url('account') }}" enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <input name="_method" type="hidden" value="PUT">
                                            <input name="panel" type="hidden" value="user">

                                            {{-- PHOTO --}}
                                            <div class="card card-default mb-4">
                                                <div class="card-header">
                                                    <h4 class="card-title">
                                                        <a href="#photoPanel" data-bs-toggle="collapse"
                                                            data-parent="#accordion">{{ t('Photo or Avatar') }}</a>
                                                    </h4>
                                                </div>

                                                {{-- Custom Profile Photo Photo --}}
                                                 <div class="row my-4 auth-field-item">
                                                    <label class="col-md-3 col-form-label mobile-profile-photo-center">
                                                        Profile Photo </label>
                                                    <div class="col-md-9 col-lg-8 col-xl-6">
                                                        <div class="input-group">
                                                            <label for="formFile" class="mobile-profile-photo">
                                                                @if ($user->userDetail && $user->userDetail->profile_photo)
                                                                    <img id="blah"
                                                                        src="{{ env('CLOUDFLARE_R2_URL') . '/assets/images/' . $user->userDetail->profile_photo }}"
                                                                        class="w-50 rounded" alt="profile photo">
                                                                @else
                                                                    <img id="blah"
                                                                        src="{{ env('CLOUDFLARE_R2_URL') . '/storage/app/default/user.png' }}"
                                                                        class="d-block w-50 rounded" alt="profile photo">
                                                                @endif
                                                            </label>
                                                            <div class="px-4 py-5 mobile-profile-photo-button">
                                                                <button type="submit"
                                                                    class="btn btn-primary" id="image-update">{{ t('Update') }}</button>
                                                                <a href="{{ route('deleteuserProfilePhoto', ['id' => auth()->user()->id]) }}"
                                                                   id="delete-profile-pic-link"
                                                                   class="btn btn-dark">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-4 auth-field-item">
                                                    <label class="col-md-3 col-form-label mobile-profile-photo-center">
                                                        Change Photo </label>
                                                    <div class="col-md-9 col-lg-8 col-xl-6">
                                                        <div class="input-group mobile-profile-photo-chosen-button">
                                                            <input class="form-control file_custom" type="file"
                                                                id="formFile" name="profile_photo" accept="image/*">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- gender_id --}}
                                            <?php $genderIdError = isset($errors) && $errors->has('gender_id') ? ' is-invalid' : ''; ?>
                                            <div class="row mb-3 required">
                                                <label class="col-md-3 col-form-label"
                                                    for="gender_id">{{ t('gender') }}</label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <select name="gender_id" id="genderId"
                                                        class="form-control selecter{{ $genderIdError }}">
                                                        <option value="0" @selected(empty(old('gender_id')))>
                                                            {{ t('Select') }}
                                                        </option>
                                                        @if ($genders->count() > 0)
                                                            @foreach ($genders as $gender)
                                                                <option value="{{ $gender->id }}"
                                                                    @selected(old('gender_id', $user->gender_id) == $gender->id)>
                                                                    {{ $gender->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- name --}}
                                            <?php $nameError = isset($errors) && $errors->has('name') ? ' is-invalid' : ''; ?>
                                            <div class="row mb-3 required">
                                                <label class="col-md-3 col-form-label{{ $nameError }}"
                                                    for="name">{{ t('Name') }} <sup>*</sup></label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <input name="name" type="text"
                                                        class="form-control{{ $nameError }}" placeholder=""
                                                        value="{{ old('name', $user->name) }}">
                                                </div>
                                            </div>

                                            {{-- username --}}
                                            <?php $usernameError = isset($errors) && $errors->has('username') ? ' is-invalid' : ''; ?>
                                            <div class="row mb-3 required">
                                                <label class="col-md-3 col-form-label{{ $usernameError }}"
                                                    for="username">{{ t('Username') }}</label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="far fa-user"></i></span>
                                                        <input id="username" name="username" type="text"
                                                            class="form-control{{ $usernameError }}"
                                                            placeholder="{{ t('Username') }}"
                                                            value="{{ old('username', $user->username) }}">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- auth_field (as notification channel) --}}
                                            @php
                                                $authFields = getAuthFields(true);
                                                $authFieldError = isset($errors) && $errors->has('auth_field') ? ' is-invalid' : '';
                                                $usersCanChooseNotifyChannel = isUsersCanChooseNotifyChannel(true);
                                                $authFieldValue = $user->auth_field ?? getAuthField();
                                                $authFieldValue = $usersCanChooseNotifyChannel ? old('auth_field', $authFieldValue) : $authFieldValue;
                                            @endphp
                                            @if ($usersCanChooseNotifyChannel)
                                                <div class="row mb-3 required">
                                                    <label class="col-md-3 col-form-label"
                                                        for="auth_field">{{ t('notifications_channel') }}
                                                        <sup>*</sup></label>
                                                    <div class="col-md-9">
                                                        @foreach ($authFields as $iAuthField => $notificationType)
                                                            <div class="form-check form-check-inline pt-2">
                                                                <input name="auth_field"
                                                                    id="{{ $iAuthField }}AuthField"
                                                                    value="{{ $iAuthField }}"
                                                                    class="form-check-input auth-field-input{{ $authFieldError }}"
                                                                    type="radio" @checked($authFieldValue == $iAuthField)>
                                                                <label class="form-check-label mb-0"
                                                                    for="{{ $iAuthField }}AuthField">
                                                                    {{ $notificationType }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                        <div class="form-text text-muted">
                                                            {{ t('notifications_channel_hint') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <input id="{{ $authFieldValue }}AuthField" name="auth_field"
                                                    type="hidden" value="{{ $authFieldValue }}">
                                            @endif

                                            @php
                                                $forceToDisplay = isBothAuthFieldsCanBeDisplayed() ? ' force-to-display' : '';
                                            @endphp

                                            {{-- email --}}
                                            @php
                                                $emailError = isset($errors) && $errors->has('email') ? ' is-invalid' : '';
                                            @endphp
                                            <div class="row mb-3 auth-field-item required{{ $forceToDisplay }}">
                                                <label class="col-md-3 col-form-label{{ $emailError }}"
                                                    for="email">{{ t('email') }}
                                                    @if (getAuthField() == 'email')
                                                        <sup>*</sup>
                                                    @endif
                                                </label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="far fa-envelope"></i></span>
                                                        <input id="email" name="email" type="email"
                                                            class="form-control{{ $emailError }}"
                                                            placeholder="{{ t('email_address') }}"
                                                            value="{{ old('email', $user->email) }}">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- phone --}}
                                            @php
                                                // Start Custom Add Phone Country
                                                if (config('country.code') == 'LP') {
                                                    $phoneCountry = 'lp';
                                                    $user->phone_country = $phoneCountry;
                                                }
                                                // End Custom Add Phone Country
                                                $phoneError = isset($errors) && $errors->has('phone') ? ' is-invalid' : '';
                                                $phoneValue = $user->phone ?? null;
                                                $phoneCountryValue = $user->phone_country ?? config('country.code');
                                                $phoneValue = phoneE164($phoneValue, $phoneCountryValue);
                                                $phoneValueOld = phoneE164(old('phone', $phoneValue), old('phone_country', $phoneCountryValue));
                                            @endphp
                                            <div class="row mb-3 auth-field-item required{{ $forceToDisplay }}">
                                                <label class="col-md-3 col-form-label{{ $phoneError }}"
                                                    for="phone">{{ t('phone') }}
                                                    @if (getAuthField() == 'phone')
                                                        <sup>*</sup>
                                                    @endif
                                                </label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <div class="input-group">
                                                        <input id="phone" name="phone" type="tel"
                                                            class="form-control{{ $phoneError }}"
                                                            value="{{ $phoneValueOld }}">
                                                        <span class="input-group-text iti-group-text">
                                                            <input name="phone_hidden" id="phoneHidden" type="checkbox"
                                                                value="1" @checked(old('phone_hidden', $user->phone_hidden) == '1')>&nbsp;
                                                            <small>{{ t('Hide') }}</small>
                                                        </span>
                                                    </div>
                                                    <input name="phone_country" type="hidden"
                                                        value="{{ old('phone_country', $phoneCountryValue) }}">
                                                </div>
                                            </div>

                                            {{-- Custom WhatsApp Phone Number Update --}}
                                            <div class="row mb-3 auth-field-item required">
                                                <label class="col-md-3 col-form-label"> WhatsApp Number
                                                    <sup>*</sup></label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="fab fa-whatsapp"></i></span>
                                                        <input id="whatsapp_number" name="whatsapp_number" type="text"
                                                            class="form-control" placeholder="506-234-5678"
                                                            value="{{ $user->userDetail->whatsapp_number ?? '' }}"
                                                            oninput="validateNumber(this)">
                                                    </div>
                                                    <div id="whatsapp_number_error" style="color:green;"></div>
                                                </div>
                                            </div>

                                            {{-- Custom Fax Update --}}
                                            <div class="row mb-3 auth-field-item required">
                                                <label class="col-md-3 col-form-label"> Fax <sup>*</sup></label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fa fa-fax"></i></span>
                                                        <input id="fax" name="fax" type="text"
                                                            class="form-control" placeholder="506-234-5678"
                                                            value="{{ $user->userDetail->fax ?? '' }}"
                                                            oninput="validateNumber(this)">
                                                    </div>
                                                    <div id="fax_error" style="color:green;"></div>
                                                </div>
                                            </div>

                                            {{-- Custom Company Name Update --}}
                                            <div class="row mb-3 auth-field-item required">
                                                <label class="col-md-3 col-form-label"> Company Name
                                                    <sup>*</sup></label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <div class="input-group">
                                                        <input name="company_name" placeholder="Company Name: (Optional)"
                                                            class="form-control input-md" type="text"
                                                            value="{{ $user->userDetail->company_name ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Custom Radio Button --}}
                                            <div class="row mb-3 required">
                                                <label class="col-md-3 text-right">Account Type?</label>
                                                <div class="col-md-9 col-lg-6">
                                                    <input class="form-check-input" type="radio" name="account_type"
                                                        id="account_type_individual" value="1"
                                                        {{ ($user->userDetail->account_type ?? '') == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="account_type_individual">Individual</label>
                                                    <input class="form-check-input" type="radio" name="account_type"
                                                        id="account_type_business" value="2"
                                                        {{ ($user->userDetail->account_type ?? '') == 2 ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="account_type_business">Business</label>
                                                </div>
                                            </div>



                                            {{-- Custom Address Update --}}
                                            <div class="row mb-3 auth-field-item required">
                                                <label class="col-md-3 col-form-label"> Address
                                                    <sup>*</sup></label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <div class="input-group">
                                                        <input name="address" placeholder="Address"
                                                            class="form-control input-md" type="text"
                                                            value="{{ $user->userDetail->address ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Province / state - Region - NewCity - Neighbour --}}
                                            @include('post.createOrEdit.inc.create-post-custom')

                                            {{-- Custom Zip Code Update --}}
                                            <div class="row mb-3 auth-field-item required">
                                                <label class="col-md-3 col-form-label"> Zip Code
                                                    <sup>*</sup></label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <div class="input-group">
                                                        <input name="zip_code" placeholder="Zip Code"
                                                            class="form-control input-md" type="text"
                                                            value="{{ $user->userDetail->zip_code ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Custom Website URL Update --}}
                                            <div class="row mb-3 auth-field-item required">
                                                <label class="col-md-3 col-form-label"> My Website URL
                                                    <sup>*</sup></label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <div class="input-group">
                                                        <input name="your_website_url" placeholder="Website URL"
                                                            class="form-control input-md" type="text"
                                                            value="{{ $user->userDetail->your_website_url ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Custom My Facebook Url Update --}}
                                            <div class="row mb-3 auth-field-item required">
                                                <label class="col-md-3 col-form-label"> Facebook Url
                                                    <sup>*</sup></label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <div class="input-group">
                                                        <input name="facebook_url" placeholder="Facebook Account URL"
                                                            class="form-control input-md" type="text"
                                                            value="{{ $user->userDetail->facebook_url ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Custom My Twitter Url Update --}}
                                            <div class="row mb-3 auth-field-item required">
                                                <label class="col-md-3 col-form-label"> Twitter Url
                                                    <sup>*</sup></label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <div class="input-group">
                                                        <input name="twitter_url" placeholder="Twitter Account URL"
                                                            class="form-control input-md" type="text"
                                                            value="{{ $user->userDetail->twitter_url ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Custom My Linkdin Url Update --}}
                                            <div class="row mb-3 auth-field-item required">
                                                <label class="col-md-3 col-form-label"> Linkdin Url
                                                    <sup>*</sup></label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <div class="input-group">
                                                        <input name="linked_in_url" placeholder="Linkdin Account URL"
                                                            class="form-control input-md" type="text"
                                                            value="{{ $user->userDetail->linked_in_url ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Custom My Ebay Url Update --}}
                                            <div class="row mb-3 auth-field-item required">
                                                <label class="col-md-3 col-form-label"> Ebay Url
                                                    <sup>*</sup></label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <div class="input-group">
                                                        <input name="ebay_url" placeholder="Ebay Account URL"
                                                            class="form-control input-md" type="text"
                                                            value="{{ $user->userDetail->ebay_url ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Custom Show And Hide Links --}}
                                            <div class="row mb-3 required">
                                                <label class="col-md-3 text-right">
                                                    @if ($user->userDetail && $user->userDetail->accept_terms == '1')
                                                        <!-- Checkbox is checked, do something -->
                                                        <input name="accept_terms" id="acceptTerms"
                                                            class="form-check-input" value="1" type="checkbox"
                                                            checked>
                                                    @else
                                                        <!-- Checkbox is not checked, do something else -->
                                                        <input name="accept_terms" id="acceptTerms"
                                                            class="form-check-input" value="1" type="checkbox">
                                                    @endif
                                                </label>

                                                <div class="col-md-9 px-0">
                                                    <div class="form-check px-0">
                                                        <label class="form-check-label" for="acceptTerms"
                                                            style="font-weight: normal;">
                                                            Disable sharing of Social Information
                                                        </label>
                                                    </div>
                                                    <div style="clear:both"></div>
                                                </div>
                                            </div>

                                            {{-- country_code --}}
                                            <input name="country_code" type="hidden" value="{{ $user->country_code }}">

                                            <div class="row mb-3">
                                                <div class="offset-md-3 col-md-9"></div>
                                            </div>

                                            {{-- button --}}
                                            <div class="row">
                                                <div class="offset-md-3 col-md-9">
                                                    <button type="submit"
                                                        class="btn btn-primary" id="profile-update">{{ t('Update') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- SETTINGS --}}
                            <div class="card card-default">
                                <div class="card-header">
                                    <h4 class="card-title"><a href="#settingsPanel" data-bs-toggle="collapse"
                                            data-parent="#accordion">{{ t('Settings') }}</a></h4>
                                </div>
                                @php
                                    $settingsPanelClass = '';
                                    $settingsPanelClass = request()->filled('panel') ? (request()->get('panel') == 'settings' ? 'show' : $settingsPanelClass) : (old('panel') == 'settings' ? 'show' : $settingsPanelClass);
                                @endphp
                                <div class="panel-collapse collapse {{ $settingsPanelClass }}" id="settingsPanel">
                                    <div class="card-body">
                                        <form name="settings" class="form-horizontal" role="form" method="POST"
                                            action="{{ url('account/settings') }}" enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <input name="_method" type="hidden" value="PUT">
                                            <input name="panel" type="hidden" value="settings">

                                            <input name="gender_id" type="hidden" value="{{ $user->gender_id }}">
                                            <input name="name" type="hidden" value="{{ $user->name }}">
                                            <input name="phone" type="hidden" value="{{ $user->phone }}">
                                            <input name="phone_country" type="hidden"
                                                value="{{ $user->phone_country }}">
                                            <input name="email" type="hidden" value="{{ $user->email }}">

                                            @if (config('settings.single.activation_facebook_comments') && config('services.facebook.client_id'))
                                                {{-- disable_comments --}}
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label"></label>
                                                    <div class="col-md-9">
                                                        <div class="form-check pt-2">
                                                            <input id="disableComments" name="disable_comments"
                                                                class="form-check-input" value="1" type="checkbox"
                                                                @checked($user->disable_comments == 1)>
                                                            <label class="form-check-label" for="disable_comments"
                                                                style="font-weight: normal;">
                                                                {{ t('Disable comments on my listings') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- password --}}
                                            <?php $passwordError = isset($errors) && $errors->has('password') ? ' is-invalid' : ''; ?>
                                            <div class="row mb-2">
                                                <label
                                                    class="col-md-3 col-form-label{{ $passwordError }}">{{ t('New Password') }}</label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <input id="password" name="password" type="password"
                                                        class="form-control{{ $passwordError }}"
                                                        placeholder="{{ t('password') }}" autocomplete="new-password">
                                                </div>
                                            </div>

                                            {{-- password_confirmation --}}
                                            <?php $passwordError = isset($errors) && $errors->has('password') ? ' is-invalid' : ''; ?>
                                            <div class="row mb-3">
                                                <label
                                                    class="col-md-3 col-form-label{{ $passwordError }}">{{ t('Confirm Password') }}</label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <input id="password_confirmation" name="password_confirmation"
                                                        type="password" class="form-control{{ $passwordError }}"
                                                        placeholder="{{ t('Confirm Password') }}">
                                                </div>
                                            </div>

                                            @if ($user->accept_terms != 1)
                                                {{-- accept_terms --}}
                                                <?php $acceptTermsError = isset($errors) && $errors->has('accept_terms') ? ' is-invalid' : ''; ?>
                                                <div class="row mb-1 required">
                                                    <label class="col-md-3 col-form-label"></label>
                                                    <div class="col-md-9">
                                                        <div class="form-check">
                                                            <input name="accept_terms" id="acceptTerms"
                                                                class="form-check-input{{ $acceptTermsError }}"
                                                                value="1" type="checkbox"
                                                                @checked(old('accept_terms', $user->accept_terms) == '1')>
                                                            <label class="form-check-label" for="acceptTerms"
                                                                style="font-weight: normal;">
                                                                {!! t('accept_terms_label', ['attributes' => getUrlPageByType('terms')]) !!}
                                                            </label>
                                                        </div>
                                                        <div style="clear:both"></div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="user_accept_terms"
                                                    value="{{ (int) $user->accept_terms }}">
                                            @endif

                                            {{-- accept_marketing_offers --}}
                                            <?php $acceptMarketingOffersError = isset($errors) && $errors->has('accept_marketing_offers') ? ' is-invalid' : ''; ?>
                                            <div class="row mb-3 required">
                                                <label class="col-md-3 col-form-label"></label>
                                                <div class="col-md-9">
                                                    <div class="form-check">
                                                        <input name="accept_marketing_offers" id="acceptMarketingOffers"
                                                            class="form-check-input{{ $acceptMarketingOffersError }}"
                                                            value="1" type="checkbox" @checked(old('accept_marketing_offers', $user->accept_marketing_offers) == '1')>
                                                        <label class="form-check-label" for="acceptMarketingOffers"
                                                            style="font-weight: normal;">
                                                            {!! t('accept_marketing_offers_label') !!}
                                                        </label>
                                                    </div>
                                                    <div style="clear:both"></div>
                                                </div>
                                            </div>

                                            {{-- time_zone --}}
                                            <?php $timeZoneError = isset($errors) && $errors->has('time_zone') ? ' is-invalid' : ''; ?>
                                            <div class="row mb-4 required">
                                                <label class="col-md-3 col-form-label{{ $timeZoneError }}"
                                                    for="time_zone">
                                                    {{ t('preferred_time_zone_label') }}
                                                </label>
                                                <div class="col-md-9 col-lg-8 col-xl-6">
                                                    <select name="time_zone"
                                                        class="form-control large-data-selecter{{ $timeZoneError }}">
                                                        <option value="" @selected(empty(old('time_zone')))>
                                                            {{ t('select_a_time_zone') }}
                                                        </option>
                                                        @php
                                                            $tz = !empty($user->time_zone) ? $user->time_zone : '';
                                                        @endphp
                                                        @foreach (\App\Helpers\Date::getTimeZones() as $key => $item)
                                                            <option value="{{ $key }}"
                                                                @selected(old('time_zone', $tz) == $key)>
                                                                {{ $item }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="form-text text-muted">
                                                        @if (auth()->user()->can(\App\Models\Permission::getStaffPermissions()))
                                                            {!! t('admin_preferred_time_zone_info', [
                                                                'frontTz' => config('country.time_zone'),
                                                                'country' => config('country.name'),
                                                                'adminTz' => config('app.timezone'),
                                                            ]) !!}
                                                        @else
                                                            {!! t('preferred_time_zone_info', [
                                                                'frontTz' => config('country.time_zone'),
                                                                'country' => config('country.name'),
                                                            ]) !!}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- button --}}
                                            <div class="row">
                                                <div class="offset-md-3 col-md-9">
                                                    <button type="submit"
                                                        class="btn btn-primary">{{ t('Update') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
    @if (config('lang.direction') == 'rtl')
        <link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
    @endif
    <style>
        .krajee-default.file-preview-frame:hover:not(.file-preview-error) {
            box-shadow: 0 0 5px 0 #666666;
        }

        .file-loading:before {
            content: " {{ t('loading_wd') }}";
        }
    </style>
    <style>
        /* Avatar Upload */
        .photo-field {
            display: inline-block;
            vertical-align: middle;
        }

        .photo-field .krajee-default.file-preview-frame,
        .photo-field .krajee-default.file-preview-frame:hover {
            margin: 0;
            padding: 0;
            border: none;
            box-shadow: none;
            text-align: center;
        }

        .photo-field .file-input {
            display: table-cell;
            width: 150px;
        }

        .photo-field .krajee-default.file-preview-frame .kv-file-content {
            width: 150px;
            height: 160px;
        }

        .kv-reqd {
            color: red;
            font-family: monospace;
            font-weight: normal;
        }

        .file-preview {
            padding: 2px;
        }

        .file-drop-zone {
            margin: 2px;
            min-height: 100px;
        }

        .file-drop-zone .file-preview-thumbnails {
            cursor: pointer;
        }

        .krajee-default.file-preview-frame .file-thumbnail-footer {
            height: 30px;
        }

        /* Allow clickable uploaded photos (Not possible) */
        .file-drop-zone {
            padding: 20px;
        }

        .file-drop-zone .kv-file-content {
            padding: 0
        }
    </style>

    <style>
        .file_custom {
            cursor: pointer;
        }
        #blah {
            height: 160px;
            width: 160px !important;
            border-radius: 50% !important;
            background-color: #f7f7f7;
            cursor: pointer;
            object-fit: contain;
        }
    </style>
@endsection

@section('after_scripts')
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/plugins/bootstrap-fileinput/themes/fas/theme.js') }}" type="text/javascript"></script>
    <script src="{{ url('common/js/fileinput/locales/' . config('app.locale') . '.js') }}" type="text/javascript">
    </script>
    <script>
        document.getElementById('delete-profile-pic-link').addEventListener('click', function(event) {
    event.preventDefault(); 

    const csrfToken = "{{ csrf_token() }}";
    const apiUrl = this.href;

    fetch(apiUrl, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-AppApiToken': 'WDZjc0hPaGd1aDN1OTRFd3ViY0ZqZ0VoNTlpNlp2Qjk='
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === 'image deleted successfullu') {
            const profileImg = document.getElementById('blah');
            profileImg.src = "{{ env('CLOUDFLARE_R2_URL') . '/storage/app/default/user.png' }}"; 
        } else {
            console.error('Error:', data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});

    </script>
    <script>
$(document).ready(function(){
    $('#profile-update').click(function(){
        $.ajax({
            event.preventDefault();
            type: "PUT",
            url: "https://www.ezead.com/api/users/{{ $user->id }}",
            headers: {
                "X-AppApiToken": "WDZjc0hPaGd1aDN1OTRFd3ViY0ZqZ0VoNTlpNlp2Qjk="
            },
            success: function(data) {
                console.log('First API call succeeded');
                $.ajax({
                    type: "POST",
                    url: "https://www.ezead.com/api/users/update-profile-pic",
                    headers: {
                        "X-AppApiToken": "WDZjc0hPaGd1aDN1OTRFd3ViY0ZqZ0VoNTlpNlp2Qjk="
                    },
                    success: function(data) {
                        console.log('Second API call succeeded');
                    },
                    error: function(error) {
                        console.log('Second API call failed', error);
                    }
                });
            },
            error: function(error) {
                console.log('First API call failed', error);
            }
        });
    });

    $('#image-update').click(function(){
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "https://www.ezead.com/api/users/update-profile-pic",
            headers: {
                "X-AppApiToken": "WDZjc0hPaGd1aDN1OTRFd3ViY0ZqZ0VoNTlpNlp2Qjk="
            },
            success: function(data) {
                console.log('Image update API call succeeded');
            },
            error: function(error) {
                console.log('Image update API call failed', error);
            }
        });
    });
});
</script>

    <script>
        phoneCountry = '{{ old('phone_country', $phoneCountryValue ?? '') }}';

        var uploadExtraData = {
            _token: '{{ csrf_token() }}',
            _method: 'PUT',
            name: '{{ $user->name }}',
            phone: '{{ $user->phone }}',
            phone_country: '{{ $user->phone_country }}',
            email: '{{ $user->email }}'
        };
        var initialPreviewConfigExtra = uploadExtraData;
        initialPreviewConfigExtra.remove_photo = 1;
        {{-- Parameter for user's photo deleting --}}

        var photoInfo = '<h6 class="text-muted pb-0">{{ t('Click to select') }}</h6>';
        var footerPreview = '<div class="file-thumbnail-footer pt-2">\n' +
            '    {actions}\n' +
            '</div>';

        $('#photoField').fileinput({
            theme: 'fas',
            language: '{{ config('app.locale') }}',
            @if (config('lang.direction') == 'rtl')
                rtl: true,
            @endif
            overwriteInitial: true,
            showCaption: false,
            showPreview: true,
            allowedFileExtensions: {!! getUploadFileTypes('image', true) !!},
            uploadUrl: '{{ url('account/photo') }}',
            uploadExtraData: uploadExtraData,
            uploadAsync: false,
            showBrowse: false,
            showCancel: true,
            showUpload: false,
            showRemove: false,
            minFileSize: {{ (int) config('settings.upload.min_image_size', 0) }},
            {{-- in KB --}}
            maxFileSize: {{ (int) config('settings.upload.max_image_size', 1000) }},
            {{-- in KB --}}
            browseOnZoneClick: true,
            minFileCount: 0,
            maxFileCount: 1,
            validateInitialCount: true,
            uploadClass: 'btn btn-primary',
            defaultPreviewContent: '<img src="{{ imgUrl(config('larapen.core.avatar.default')) }}" alt="{{ t('Your Photo or Avatar') }}">' +
                photoInfo,
            /* Retrieve current images */
            /* Setup initial preview with data keys */
            initialPreview: [
                @if (isset($user->photo_url) && !empty($user->photo_url))
                    '{{ $user->photo_url }}'
                @endif
            ],
            initialPreviewAsData: true,
            initialPreviewFileType: 'image',
            /* Initial preview configuration */
            initialPreviewConfig: [{
                <?php
                // Get the file size
                try {
                    $fileSize = isset($disk) && !empty($user->photo) && $disk->exists($user->photo) ? (int) $disk->size($user->photo) : 0;
                } catch (\Throwable $e) {
                    $fileSize = 0;
                }
                ?>
                @if (isset($user->photo) && !empty($user->photo))
                    caption: '{{ basename($user->photo) }}',
                    size: {{ $fileSize }},
                    url: '{{ url('account/photo/delete') }}',
                    key: {{ (int) $user->id }},
                    extra: initialPreviewConfigExtra
                @endif
            }],

            showClose: false,
            fileActionSettings: {
                showDrag: false,
                /* Show/hide move (rearrange) icon */
                removeIcon: '<i class="far fa-trash-alt"></i>',
                removeClass: 'btn btn-danger btn-sm',
                zoomClass: 'btn btn-outline-secondary btn-sm',
                removeTitle: '{{ t('Remove file') }}'
            },

            elErrorContainer: '#avatarUploadError',
            msgErrorClass: 'alert alert-block alert-danger',

            layoutTemplates: {
                main2: '{preview} {remove} {browse}',
                footer: footerPreview
            }
        });

        /* Auto-upload added file */
        $('#photoField').on('filebatchselected', function(event, data, id, index) {
            $(this).fileinput('upload');
        });

        /* Show upload status message */
        $('#photoField').on('filebatchpreupload', function(event, data, id, index) {
            $('#avatarUploadSuccess').html('<ul></ul>').hide();
        });

        /* Show success upload message */
        $('#photoField').on('filebatchuploadsuccess', function(event, data, previewId, index) {
            /* Show uploads success messages */
            var out = '';
            $.each(data.files, function(key, file) {
                if (typeof file !== 'undefined') {
                    var fname = file.name;
                    out = out + {!! t('Uploaded file X successfully') !!};
                }
            });
            $('#avatarUploadSuccess ul').append(out);
            $('#avatarUploadSuccess').fadeIn('slow');

            $('#userImg').attr({
                'src': $('.photo-field .kv-file-content .file-preview-image').attr('src')
            });
        });

        /* Delete picture */
        // $('#photoField').on('filepredelete', function(xhr) {
        //     var abort = true;
        //     if (confirm("{{ t('Are you sure you want to delete this picture') }}")) {
        //         abort = false;
        //     }

        //     return abort;
        // });
        $('#photoField').on('filepredelete', function(xhr) {
            var abort = true;
            if (true) {
                abort = false;
            }

            return abort;
        });

        $('#photoField').on('filedeleted', function() {
            $('#userImg').attr({
                'src': '{!! imgUrl(config('larapen.core.avatar.default')) !!}'
            });

            var out = "{{ t('Your photo or avatar has been deleted') }}";
            $('#avatarUploadSuccess').html('<ul><li></li></ul>').hide();
            $('#avatarUploadSuccess ul li').append(out);
            $('#avatarUploadSuccess').fadeIn('slow');
        });
        $('.create-page-change-class .removeClassEditPage').removeClass('col-md-8');
        $('.create-page-change-class .removeClassEditPage').addClass('col-md-6');

        // Custom JS For Selected Profile Picture Showing.
        $("#formFile").change(function(e) {
            readURL(this);

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $("#blah").attr("src", e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        });
    </script>
    <script>
        function validateNumber(input) {
            // Remove any characters that are not digits or hyphen
            let value = input.value.replace(/[^\d-]/g, '');

            // Update the input field with the cleaned value
            input.value = value;

            // Create the error message element ID based on the input field ID
            let errorMessageId = input.id + "_error";

            // Get the error message element by ID
            let errorMessageElement = document.getElementById(errorMessageId);

            // Check if the cleaned value contains only digits and hyphen
            if (!/^\d+(-\d+)*$/.test(value)) {
                errorMessageElement.textContent = "Add numeric numbers only.";
            } else {
                // If the value is valid, clear the error message
                errorMessageElement.textContent = "";
            }
        }
    </script>
@endsection
