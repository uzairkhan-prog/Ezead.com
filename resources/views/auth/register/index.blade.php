{{--
 * LaraClassifier - Classified Ads Web Application
 * Copyright (c) BeDigit. All Rights Reserved
 *
 * Website: https://www.ezead.com/
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
--}}
@extends('layouts.master')

@section('content')

<style>
    .disable-social-information {
        /* You can set initial styles for the div here */
    }
</style>

<div class="container">
    <div class="theme-border-line py-2"></div>
</div>

@if (!(isset($paddingTopExists) and $paddingTopExists))
<div class="p-0 mt-lg-4 mt-md-3 mt-3"></div>
@endif
<div class="main-container">
    <div class="container">
        <div class="row">

            @if (isset($errors) && $errors->any())
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ t('Close') }}"></button>
                    <h5><strong>{{ t('oops_an_error_has_occurred') }}</strong></h5>
                    <ul class="list list-check">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            @if (session()->has('flash_notification'))
            <div class="col-12">
                @include('flash::message')
            </div>
            @endif

            <div class="col-md-12 page-content">
                <div class="inner-box-none">
                    <div class="top-register p-5 rounded">
                        <h2 class="title-2">
                            <strong><i class="fas fa-user-plus"></i> {{ t('create_your_account_it_is_quick') }}</strong>
                        </h2>

                        @includeFirst([
                        config('larapen.core.customizedViewPath') . 'auth.login.inc.social',
                        'auth.login.inc.social',
                        ])

                        <h3 class="subtitle"></h3>

                        <h2>
                            Member Standard Registration - Welcome to Ezead Community
                            -
                            Sign up now for
                            <br>
                            our FREE and perpetual membership! <b>**  NO CREDIT CARD REQUIRED  **</b>
                        </h2>

                        <p><span style="color: rgb(43, 43, 43);">Please take note of the following important
                                information:<br>
                                <br>

                                <span style="color: rgb(43, 43, 43);"><b>Pre-filled Information:</b> To streamline the listing
                                    process and enhance your experience, we automatically prefill most fields in your
                                    listing pages. This ensures a quick and efficient listing process, saving you valuable
                                    time.</span><br>
                                <br>

                                <span style="color: rgb(43, 43, 43);"><b>Accuracy and Completeness:</b> Registrations must be
                                    submitted with accurate and complete information. Our team rigorously checks and
                                    verifies each registration for authenticity. Verification methods include IP Location
                                    Verification, Telephone Prefix Location Verification, Postal Code Location Verification,
                                    and, on occasion, Telephone Confirmation.</span><br>

                                <br>

                                <span style="color: rgb(43, 43, 43);"><b>Maintaining Integrity:</b> Our stringent registration
                                    requirements are in place to uphold the integrity of the Ezead Community. This measure
                                    helps us combat the issues and problems commonly encountered on many other online
                                    platforms.<br>

                                </span> <br>

                                <span style="color: rgb(43, 43, 43);"><b>Privacy Control:</b> You have the option to choose which
                                    personal information you wish to display when listing items. We put you in control of
                                    your content and privacy settings.<br>

                                </span> <br>

                                <span style="color: rgb(43, 43, 43);"><b>Zero Tolerance Policy:</b> We do not tolerate add spammers
                                    or individuals promoting pay-to-work
                                    or pay-in-advance loan schemes. Any such ads or posters will be promptly removed from
                                    our
                                    platform.<br>

                                </span> <br>

                                <span style="color: rgb(43, 43, 43);">Thank you for choosing Ezead Community, where we
                                    prioritise safety, authenticity, and a positive user experience. We look forward to your
                                    participation in our thriving community.<br>

                                </span>
                        </p>

                        <p class="page_instructions"><b> ( * ) indicates required
                                fields </b></p>
                    </div>

                    @php
                    $mtAuth = !socialLoginIsEnabled() ? ' mt-5' : ' mt-4';
                    @endphp
                    <div class="row">
                        <div class="col-12">
                            <form id="signupForm" class="form-horizontal" method="POST" action="{{ url()->current() }}">
                                {!! csrf_field() !!}
                                <fieldset>

                                    <div class="bg-register-feilds p-5 rounded">

                                        {{-- name --}}
                                        <?php $nameError = isset($errors) && $errors->has('name') ? ' is-invalid' : ''; ?>
                                        <div class="row required">
                                            <div class="col-md-3"></div>
                                            <label class="col-md-6">{{ t('Name') }} <sup>*</sup></label>
                                        </div>
                                        <div class="row mb-3 required">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <input name="name" placeholder="{{ t('Name') }}" class="form-control input-md{{ $nameError }}" type="text" value="{{ old('name') }}">
                                            </div>
                                        </div>

                                        {{-- Custom Company Name Optional --}}
                                        <div class="row required">
                                            <div class="col-md-3"></div>
                                            <label class="col-md-6"> Company </label>
                                        </div>
                                        <div class="row mb-3 required">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <input name="company_name" placeholder="Company Name: (Optional)" class="form-control input-md" type="text" value="{{ old('company_name') }}">
                                            </div>
                                        </div>

                                        {{-- Custom Radio Button --}}
                                        <div class="row mb-3 required">
                                            <div class="col-md-3"></div>
                                            <label class="col-md-2"> Account Type ? </label>
                                            <div class="col-md-7 col-lg-6">
                                                <input class="form-check-input" type="radio" name="account_type" id="account_type_individual" value="1" {{ old('account_type') == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="account_type_individual">Individual</label>
                                                <input class="form-check-input" type="radio" name="account_type" id="account_type_business" value="2" {{ old('account_type') == 2 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="account_type_business">Business</label>
                                            </div>
                                        </div>

                                        @include('auth.register.custom-register')

                                        {{-- Custom Address --}}
                                        <div class="row required">
                                            <div class="col-md-3"></div>
                                            <label class="col-md-3"> Address </label>
                                        </div>
                                        <div class="row mb-3 required">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                                    <input name="address" placeholder="Address" class="form-control input-md" type="text" value="{{ old('address') }}">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Custom Actual City Name --}}
                                        {{-- <div class="row mb-3 required">
                                                <label class="col-md-3 col-form-label"> Actual City Name <sup>*</sup></label>
                                                <div class="col-md-9 col-lg-6">
                                                    <input name="actual_city_name"
                                                        placeholder="Please Input Your Actual City Name (Please Confirm)"
                                                        class="form-control input-md" type="text"
                                                        value="{{ old('actual_city_name') }}">
                                    </div>
                        </div> --}}

                        {{-- Custom Zip Code --}}
                        <div class="row required">
                            <div class="col-md-3"></div>
                            <label class="col-md-3"> Zip Code </label>
                        </div>
                        <div class="row mb-3 required">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <input name="zip_code" placeholder="Zip Code" class="form-control input-md" type="text" value="{{ old('zip_code') }}">
                            </div>
                        </div>

                        {{-- country_code --}}
                        @if (empty(config('country.code')))
                        @php
                        $countryCodeError = isset($errors) && $errors->has('country_code') ? ' is-invalid' : '';
                        $countryCodeValue = !empty(config('ipCountry.code')) ? config('ipCountry.code') : 0;
                        @endphp
                        <div class="row mb-3 required">
                            <label class="col-md-3 col-form-label{{ $countryCodeError }}" for="country_code">
                                {{ t('your_country') }} <sup>*</sup>
                            </label>
                            <div class="col-md-9 col-lg-6">
                                <select id="countryCode" name="country_code" class="form-control large-data-selecter{{ $countryCodeError }}">
                                    <option value="0" @selected(empty(old('country_code')))>
                                        {{ t('Select') }}
                                    </option>
                                    @foreach ($countries as $code => $item)
                                    <option value="{{ $code }}" @selected(old('country_code', $countryCodeValue)==$code)>
                                        {{ $item->get('name') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @else
                        <input id="countryCode" name="country_code" type="hidden" value="{{ config('country.code') }}">
                        @endif

                        {{-- auth_field (as notification channel) --}}
                        @php
                        $authFields = getAuthFields(true);
                        $authFieldError = isset($errors) && $errors->has('auth_field') ? ' is-invalid' : '';
                        $usersCanChooseNotifyChannel = isUsersCanChooseNotifyChannel();
                        $authFieldValue = $usersCanChooseNotifyChannel ? old('auth_field', getAuthField()) : getAuthField();
                        @endphp
                        @if ($usersCanChooseNotifyChannel)
                        <div class="row mb-3 required">
                            <label class="col-md-3 col-form-label" for="auth_field">{{ t('notifications_channel') }} <sup>*</sup></label>
                            <div class="col-md-9">
                                @foreach ($authFields as $iAuthField => $notificationType)
                                <div class="form-check form-check-inline pt-2">
                                    <input name="auth_field" id="{{ $iAuthField }}AuthField" value="{{ $iAuthField }}" class="form-check-input auth-field-input{{ $authFieldError }}" type="radio" @checked($authFieldValue==$iAuthField)>
                                    <label class="form-check-label mb-0" for="{{ $iAuthField }}AuthField">
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
                        <input id="{{ $authFieldValue }}AuthField" name="auth_field" type="hidden" value="{{ $authFieldValue }}">
                        @endif

                        @php
                        $forceToDisplay = isBothAuthFieldsCanBeDisplayed() ? ' force-to-display' : '';
                        @endphp

                        {{-- email --}}
                        @php
                        $emailError = isset($errors) && $errors->has('email') ? ' is-invalid' : '';
                        @endphp

                        @if (config('country.code') == 'LP')
                        {{-- Custom LP Phone Number --}}
                        <div class="row required">
                            <div class="col-md-3"></div>
                            <label class="col-md-3"> Phone Number
                                @if (getAuthField() == 'phone')
                                <sup>*</sup>
                                @endif
                            </label>
                        </div>
                        <div class="row mb-3 required">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><img src="{{ url('images/flags/16/lp.png') }}" alt="All Regions" style="border-radius:10px;"></span>
                                    <input id="whatsapp_number" name="#" type="text" class="form-control" placeholder="506-234-5678" value="{{ old('whatsapp_number') }}" oninput="validateNumber(this)">
                                </div>
                                <div id="whatsapp_number_error" style="color:green;"></div>
                            </div>
                        </div>
                        @else
                        {{-- phone --}}
                        @php
                        $phoneError = isset($errors) && $errors->has('phone') ? ' is-invalid' : '';
                        $phoneCountryValue = config('country.code');
                        @endphp

                        <div class="row auth-field-item required{{ $forceToDisplay }}">
                            <div class="col-md-3"></div>
                            <label class="col-md-3 pt-0" for="phone">{{ t('phone_number') }}
                                @if (getAuthField() == 'phone')
                                <sup>*</sup>
                                @endif
                            </label>
                        </div>
                        <div class="row mb-3 auth-field-item required{{ $forceToDisplay }}">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <input id="phone" name="phone" class="form-control input-md{{ $phoneError }}" type="tel" value="{{ phoneE164(old('phone'), old('phone_country', $phoneCountryValue)) }}" autocomplete="off">
                                <input name="phone_country" type="hidden" value="{{ old('phone_country', $phoneCountryValue) }}">
                            </div>
                        </div>
                        @endif

                        {{-- Custom Whatsapp Number --}}
                        <div class="row required">
                            <div class="col-md-3"></div>
                            <label class="col-md-3"> WhatsApp Number </label>
                        </div>
                        <div class="row mb-3 required">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                    <input id="whatsapp_number" name="whatsapp_number" type="text" class="form-control" placeholder="506-234-5678" value="{{ old('whatsapp_number') }}" oninput="validateNumber(this)">
                                </div>
                                <div id="fax_error" style="color:green;"></div>
                            </div>
                        </div>

                        {{-- Custom Fax --}}
                        <div class="row required">
                            <div class="col-md-3"></div>
                            <label class="col-md-3"> Fax </label>
                        </div>
                        <div class="row mb-3 required">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-fax"></i></span>
                                    <input id="fax" name="fax" type="text" class="form-control" placeholder="506-234-5678" value="{{ old('fax') }}" oninput="validateNumber(this)">
                                </div>
                                <div id="fax_error" style="color:green;"></div>
                            </div>
                        </div>

                        <div class="row auth-field-item required{{ $forceToDisplay }}">
                            <div class="col-md-3"></div>
                            <label class="col-md-3 pt-0" for="email">{{ t('email') }}
                                @if (getAuthField() == 'email')
                                <sup>*</sup>
                                @endif
                            </label>
                        </div>
                        <div class="row mb-3 auth-field-item required{{ $forceToDisplay }}">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input id="email" name="email" type="email" class="form-control{{ $emailError }}" placeholder="{{ t('email_address') }}" value="{{ old('email') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Custom Website URL --}}
                        <div class="row required">
                            <div class="col-md-3"></div>
                            <label class="col-md-3"> Your Website URL </label>
                        </div>
                        <div class="row mb-4 required">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                    <input name="your_website_url" placeholder="Website URL" class="form-control input-md" type="text" value="{{ old('your_website_url') }}">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="p-5 rounded bg-register-feilds-2">

                        {{-- Custom Show And Hide Links --}}
                        <div class="row mb-3 required">
                            <div class="col-md-12 px-0 text-center">
                                <div class="form-check px-0 pt-3 pb-2 bg-disable-social">
                                    <label class="form-check-label" for="acceptTerms2" style="font-weight: normal; color: white !important;">
                                        <input name="accept_terms" id="acceptTerms2" class="form-check-input" value="1" type="checkbox" {{ old('accept_terms') }}>
                                        Disable sharing of Social Information
                                    </label>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                        </div>

                        {{-- Custom Heading Social links --}}
                        <div class="disable-social-information pt-4">
                            <h1 class="subtitle">Enter Your Full&nbsp;User Name URL as shown in the address
                                bar&nbsp;to display&nbsp;a direct link to your&nbsp;<br> Facebook, Twitter,
                                &nbsp;LinkedIn and/or MY Ebay page In all your selected listings..</h1>

                            <br>

                            {{-- Custom Your Facebook Account URL --}}
                            <div class="row mb-3 required">
                                <label class="col-md-3">
                                    Your Facebook Account Name URL (optional - displays link in your listings)
                                </label>
                                <div class="col-md-8 col-lg-6">
                                    <input name="facebook_url" placeholder="Facebook Account URL" class="form-control input-md" type="text" value="{{ old('facebook_url') }}">
                                </div>
                            </div>

                            {{-- Custom Your Twitter Account URL --}}
                            <div class="row mb-3 required">
                                <label class="col-md-3">
                                    Your Twitter Account Name URL (optional - displays link in your listings)
                                </label>
                                <div class="col-md-8 col-lg-6">
                                    <input name="twitter_url" placeholder="Twitter Account URL" class="form-control input-md" type="text" value="{{ old('twitter_url') }}">
                                </div>
                            </div>

                            {{-- Custom Your LinkedIn Account URL --}}
                            <div class="row mb-3 required">
                                <label class="col-md-3">
                                    Your LinkedIn Account Name URL (optional - displays link in your listings)
                                </label>
                                <div class="col-md-8 col-lg-6">
                                    <input name="linked_in_url" placeholder="LinkedIn Account URL" class="form-control input-md" type="text" value="{{ old('linked_in_url') }}">
                                </div>
                            </div>

                            {{-- Custom Your Ebay Account URL --}}
                            <div class="row mb-3 required">
                                <label class="col-md-3">
                                    Your My Ebay Account Name URL (optional - displays link in your listings)
                                </label>
                                <div class="col-md-8 col-lg-6">
                                    <input name="ebay_url" placeholder="Ebay Account URL" class="form-control input-md" type="text" value="{{ old('ebay_url') }}">
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">

                        {{-- username --}}
                        @php
                        $usernameIsEnabled = !config('larapen.core.disable.username');
                        @endphp
                        @if (!$usernameIsEnabled)
                        <?php $usernameError = isset($errors) && $errors->has('username') ? ' is-invalid' : ''; ?>
                        <div class="row required">
                            <div class="col-md-3"></div>
                            <label class="col-md-3" for="username">{{ t('Username') }}</label>
                        </div>
                        <div class="row mb-3 required">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-user"></i></span>
                                    <input id="username" name="username" type="text" class="form-control{{ $usernameError }}" placeholder="{{ t('Username') }}" value="{{ old('username') }}">
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- password --}}
                        <?php $passwordError = isset($errors) && $errors->has('password') ? ' is-invalid' : ''; ?>
                        <div class="row required">
                            <div class="col-md-3"></div>
                            <label class="col-md-3" for="password">{{ t('password') }}
                                <sup>*</sup>
                                <span class="form-text text-muted">{{ t('at_least_num_characters', ['num' => config('settings.security.password_min_length', 6)]) }}</span>
                                </label>
                        </div>
                        <div class="row mb-3 required">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="input-group show-pwd-group mb-2">
                                    <input id="password" name="password" type="password" class="form-control{{ $passwordError }}" placeholder="{{ t('password') }}" autocomplete="new-password">
                                    <span class="icon-append show-pwd">
                                        <button type="button" class="eyeOfPwd">
                                            <i class="far fa-eye-slash"></i>
                                        </button>
                                    </span>
                                </div>
                                <div class="input-group mb-2">
                                    <input id="passwordConfirmation" name="password_confirmation" type="password" class="form-control{{ $passwordError }}"
                                        placeholder="{{ t('Password Confirmation') }}" autocomplete="off">
                                    <span class="icon-append show-pwd">
                                        <button type="button" class="eyeOfPwd2" id="eyeicon_confirmation_password">
                                            <i class="far fa-eye-slash"></i>
                                        </button>
                                    </span>
                                </div>
                                <!--<div class="form-text text-muted">-->
                                <!--    {{ t('at_least_num_characters', ['num' => config('settings.security.password_min_length', 6)]) }}-->
                                <!--</div>-->
                            </div>
                        </div>

                        {{-- captcha --}}
                        <center>
                            <div class="col-md-9 col-lg-6">
                                <div class="input-group show-pwd-group mb-2">
                                    <label class="" for="username">Please solve the math problem
                                        to verify you are not a robot <sup>*</sup></label>
                                </div>
                            </div>
                            <div class="col-md-9 col-lg-6">
                                <div class="input-group show-pwd-group mb-2">
                                    <div class="captcha">
                                        <span>{!! captcha_img('math') !!}</span>
                                        <button type="button" class="btn btn-danger reload" id="reload">
                                            &#x21bb;
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9 col-lg-6">
                                <div class="input-group show-pwd-group mb-2">
                                    <input type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                </div>
                            </div>
                        </center>
                    </div>

                    {{-- Custom Terms --}}
                    <div class="row">
                        <div class="custom-terms-register">
                            <div class="container terms-bg-color rounded">
                                <div class="section-content">
                                    <div class="row">

                                        <h1 class="text-center title-1 pt-3" style="color: #ffffff;">
                                            <strong>Terms</strong>
                                        </h1>
                                        <hr class="center-block small mt-0" style="background-color: #ffffff;">

                                        <div class="col-md-12 page-content">

                                            <div class="relative">
                                                <div class="row">
                                                    <div class="col-sm-12 page-content">
                                                        <div class="text-content text-start from-wysiwyg">
                                                            <h4><b>Definitions</b></h4>
                                                            <p>Each of the terms mentioned below have in
                                                                these Conditions of Sale EzeAd
                                                                Service (hereinafter the "Conditions")
                                                                the
                                                                following meanings:</p>
                                                            <ol>
                                                                <li><b>Announcement</b>&nbsp;: refers to all
                                                                    the
                                                                    elements and data (visual, textual,
                                                                    sound, photographs, drawings),
                                                                    presented
                                                                    by an Advertiser editorial under his
                                                                    sole responsibility, in order to
                                                                    buy,
                                                                    rent or sell a product or service
                                                                    and
                                                                    broadcast on the Website and Mobile
                                                                    Site.</li>
                                                                <li><b>Advertiser</b>&nbsp;: means any natural
                                                                    or
                                                                    legal person, a major, established
                                                                    in
                                                                    France, holds an account and having
                                                                    submitted an announcement, from it,
                                                                    on
                                                                    the Website. Any Advertiser must be
                                                                    connected to the Personal Account
                                                                    for
                                                                    deposit and or manage its listings.
                                                                    Add
                                                                    first deposit automatically entails
                                                                    the
                                                                    establishment of a Personal Account
                                                                    to
                                                                    the Advertiser.</li>
                                                                <li><b>Personal Account</b>&nbsp;: refers to
                                                                    the
                                                                    free space than any Advertiser must
                                                                    create and which it should connect
                                                                    from
                                                                    the Website to disseminate, manage
                                                                    and
                                                                    view its listings.</li>
                                                                <li><b>EzeAd</b>&nbsp;: means the
                                                                    company
                                                                    that publishes and operates the
                                                                    Website
                                                                    and Mobile Site {YourCompany},
                                                                    registered at the Trade and
                                                                    Companies
                                                                    Register of {YourCity} under the
                                                                    number
                                                                    {YourCompany Registration Number}
                                                                    whose
                                                                    registered office is at {YourCompany
                                                                    Address}.</li>
                                                                <li><b>Customer Service</b>&nbsp;:
                                                                    EzeAd
                                                                    means the department to which the
                                                                    Advertiser may obtain further
                                                                    information. This service can be
                                                                    contacted via email by clicking the
                                                                    link
                                                                    on the Website and Mobile Site.</li>
                                                                <li><b>EzeAd Service</b>&nbsp;:
                                                                    EzeAd means the services
                                                                    made
                                                                    available to Users and Advertisers
                                                                    on
                                                                    the Website and Mobile Site.</li>
                                                                <li><b>Website</b>&nbsp;: means the website
                                                                    operated by EzeAd accessed
                                                                    mainly from the URL <a href="{{ url('/') }}">{{ url('/') }}</a>
                                                                    and allowing Users and Advertisers
                                                                    to
                                                                    access the Service via internet
                                                                    EzeAd.</li>
                                                                <li><b>Mobile Site</b>&nbsp;: is the mobile
                                                                    site
                                                                    operated by EzeAd
                                                                    accessible
                                                                    from the URL <a href="{{ url('/') }}">{{ url('/') }}</a>
                                                                    and allowing Users and Advertisers
                                                                    to
                                                                    access via their mobile phone
                                                                    service
                                                                    {YourSiteName}.</li>
                                                                <li><b>User</b>&nbsp;: any visitor with access
                                                                    to
                                                                    EzeAd Service via the
                                                                    Website
                                                                    and Mobile Site and Consultant
                                                                    Service
                                                                    EzeAd accessible from
                                                                    different
                                                                    media.</li>
                                                            </ol>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="custom-terms-register">
                            <div class="container terms-bg-color-2 rounded">
                                <h4><b>Subject</b></h4>
                                <p>These Terms and Conditions Of Use
                                    establish
                                    the contractual conditions applicable to
                                    any
                                    subscription by an Advertiser connected
                                    to
                                    its Personal Account from the Website
                                    and
                                    Mobile Site.<br></p>
                                <h4><b>Acceptance</b></h4>
                                <p>Any use of the website by an Advertiser
                                    is
                                    full acceptance of the current
                                    Terms.<br>
                                </p>
                                <h4><b>Responsibility</b></h4>
                                <p>Responsibility for EzeAd can not
                                    be
                                    held liable for non-performance or
                                    improper
                                    performance of due control, either
                                    because
                                    of the Advertiser, or a case of major
                                    force.<br></p>
                                <h4><b>Modification of these terms</b></h4>
                                <p>EzeAd reserves the right, at any
                                    time, to modify all or part of the Terms
                                    and
                                    Conditions.</p>
                                <p>Advertisers are advised to consult the
                                    Terms
                                    to be aware of the changes.</p>
                                <h4><b>Miscellaneous</b></h4>
                                <p>If part of the Terms should be illegal,
                                    invalid or unenforceable for any reason
                                    whatsoever, the provisions in question
                                    would
                                    be deemed unwritten, without questioning
                                    the
                                    validity of the remaining provisions
                                    will
                                    continue to apply between Advertisers
                                    and
                                    EzeAd.</p>
                                <p>Any complaints should be addressed to
                                    Customer Service EzeAd.</p>
                            </div>
                        </div>
                    </div>

                    {{-- accept_terms --}}
                    <?php $acceptTermsError = isset($errors) && $errors->has('accept_terms') ? ' is-invalid' : ''; ?>
                    <div class="row m-0 required register-button-bg">
                        <label class="col-md-4 col-form-label"></label>
                        <div class="col-md-8">
                            <div class="form-check">
                                <input name="accept_terms" id="acceptTerms" class="form-check-input{{ $acceptTermsError }}" value="1" type="checkbox" @checked(old('accept_terms')=='1' )>
                                <label class="form-check-label" for="acceptTerms" style="font-weight: normal;">
                                    {!! t('accept_terms_label', ['attributes' => getUrlPageByType('terms')]) !!}
                                </label>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                    </div>

                    {{-- accept_marketing_offers --}}
                    <?php $acceptMarketingOffersError = isset($errors) && $errors->has('accept_marketing_offers') ? ' is-invalid' : ''; ?>
                    <div class="row m-0 required register-button-bg">
                        <label class="col-md-4 col-form-label"></label>
                        <div class="col-md-8">
                            <div class="form-check">
                                <input name="accept_marketing_offers" id="acceptMarketingOffers" class="form-check-input{{ $acceptMarketingOffersError }}" value="1" type="checkbox" @checked(old('accept_marketing_offers')=='1' )>
                                <label class="form-check-label" for="acceptMarketingOffers" style="font-weight: normal;">
                                    {!! t('accept_marketing_offers_label') !!}
                                </label>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                    </div>

                    {{-- Orginal Button --}}
                    {{-- <div class="row mb-3">
                            <label class="col-md-3 col-form-s"></label>
                            <div class="col-md-7">
                                <button id="signupBtn" class="btn btn-primary btn-lg">{{ t('register') }} </button>
                </div>
            </div> --}}

            {{-- Custom Button --}}
            <div class="register-button-bg py-4">
                <div class="row mb-3">
                    <div class="col-md-12 text-center">
                        <button id="signupBtn" class="register-button btn-lg">
                            {{ t('register') }} </button>
                        {{-- Custom Cencel Button
                                                    <button onClick="window.location.reload();"
                                                        class="btn btn-success btn-lg">
                                                        Cancel </button> --}}
                    </div>
                </div>

                <div class="mb-4"></div>
            </div>

            </fieldset>
            </form>
        </div>
    </div>
</div>
</div>

{{-- <div class="col-md-4 reg-sidebar">
                    <div class="reg-sidebar-inner text-center">
                        <div class="promo-text-box">
                            <i class="far fa-image fa-4x icon-color-1"></i>
                            <h3><strong>{{ t('create_new_listing') }}</strong></h3>
<p>
    {{ t('do_you_have_something_text', ['appName' => config('app.name')]) }}
</p>
</div>
<div class="promo-text-box">
    <i class="fas fa-pen-square fa-4x icon-color-2"></i>
    <h3><strong>{{ t('create_and_manage_items') }}</strong></h3>
    <p>{{ t('become_a_best_seller_or_buyer_text') }}</p>
</div>
<div class="promo-text-box"><i class="fas fa-heart fa-4x icon-color-3"></i>
    <h3><strong>{{ t('create_your_favorite_listings_list') }}</strong></h3>
    <p>{{ t('create_your_favorite_listings_list_text') }}</p>
</div>
</div>
</div> --}}
</div>
</div>
</div>
@endsection

@section('after_scripts')
<script>
    $(document).ready(function() {
        $('#reload').click(function(){
           $.ajax({
               type : 'GET',
               url  : 'reload-captcha',
               success:function(data){
                $('.captcha span').html(data.captcha)   
               }
           });
        });
    });
</script>
<script>
  let eyeicon_confirmation_password = document.getElementById('eyeicon_confirmation_password');
let passwordConfirmation = document.getElementById('passwordConfirmation');

eyeicon_confirmation_password.addEventListener('click', function() {
    if (passwordConfirmation.type === 'password') {
        passwordConfirmation.type = 'text';
    } else {
        passwordConfirmation.type = 'password';
    }
});
</script>
<script>

    $(document).ready(function() {
        {
            {
                --Submit Form--
            }
        }
        $(document).on('click', '#signupBtn', function(e) {
            e.preventDefault();
            $("#signupForm").submit();
            return false;
        });
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