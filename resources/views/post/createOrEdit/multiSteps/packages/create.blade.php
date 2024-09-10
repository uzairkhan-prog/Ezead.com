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

@section('wizard')
    @includeFirst([
        config('larapen.core.customizedViewPath') . 'post.createOrEdit.multiSteps.inc.wizard',
        'post.createOrEdit.multiSteps.inc.wizard',
    ])
@endsection

@section('content')
    @includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])

    {{-- Start custom Add Pre-Loaders --}}
    <div class="preloader-wrapper">
        <div class="preloader"></div>
    </div>
    <div class="check-preloader-wrapper">
        <div class="wrapper">
            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
            </svg>
        </div>
    </div>
    {{-- End custom Add Pre-Loaders --}}

    {{-- Modal --}}
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header custom-modal-header">
                    <h4 class="modal-title title-3" id="successModalLabel">
                        <span class="check-circle">
                            <i class="fa fa-check-circle"></i>
                        </span>
                        <span>
                            Success
                        </span>
                        <span class="pay-is-done">
                            Payment is done
                        </span>
                    </h4>
                    <button type="button" class="close custom-close" data-bs-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">{{ t('Close') }}</span>
                    </button>
                </div>
                <div class="modal-body custom-modal-body">
                    Your listing has been created successfully!
                </div>
                <div class="modal-footer custom-modal-footer">
                    <div class="col-6 text-center">
                        <button type="button" class="btn payment-button-1" data-bs-dismiss="modal" onclick="showPreloader()">New Listing</button>
                    </div>
                    <div class="col-6 text-center">
                        <a href="{{ url('/') }}" class="btn payment-button-2">Go back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-container bg-payment">
        <div class="container">
            <div class="row">

                @includeFirst([
                    config('larapen.core.customizedViewPath') . 'post.inc.notification',
                    'post.inc.notification',
                ])

                <div class="col-md-12 page-content">
                    <div class="py-5">

                        <h2 class="title-2">
                            <strong>
                                @if (isset($selectedPackage) && !empty($selectedPackage))
                                    <i class="fas fa-wallet"></i> {{ t('Payment') }}
                                @else
                                    <i class="fas fa-tags"></i> {{ t('Pricing') }}
                                @endif
                            </strong>
                        </h2>

                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form" id="postForm" method="POST" action="{{ url()->current() }}">
                                    {!! csrf_field() !!}
                                    <fieldset>

                                        @if (isset($selectedPackage) && !empty($selectedPackage))
                                            <?php $currentPackagePrice = $selectedPackage->price; ?>
                                            @includeFirst([
                                                config('larapen.core.customizedViewPath') .
                                                'post.createOrEdit.inc.packages.selected',
                                                'post.createOrEdit.inc.packages.selected',
                                            ])
                                        @else
                                            @includeFirst([
                                                config('larapen.core.customizedViewPath') .
                                                'post.createOrEdit.inc.packages',
                                                'post.createOrEdit.inc.packages',
                                            ])
                                        @endif

                                        <div class="row">
                                            <div class="col-md-12 text-center mt-4">
                                                <a href="{{ url('posts/create/photos') }}" class="btn btn-default btn-lg me-3 px-4">
                                                    {{ t('Previous') }}
                                                </a>
                                                <button id="submitPostForm" class="btn btn-lg px-5 submitPostForm" style="color: #ffffff; background-color: #23222f">
                                                    {{ t('Pay') }} </button>
                                            </div>
                                        </div>

                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.page-content -->
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <style>
        /* Check Pre-Loader */
        .check-preloader-wrapper {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 9999;
        }

        * {
            padding: 0;
            margin: 0
        }

        .wrapper {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #eee
        }

        .checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            stroke: #7ac142;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards
        }

        .checkmark {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: block;
            stroke-width: 2;
            stroke: #fff;
            stroke-miterlimit: 10;
            margin: 10% auto;
            box-shadow: inset 0px 0px 0px #7ac142;
            animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both
        }

        .checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards
        }

        @keyframes stroke {
            100% {
                stroke-dashoffset: 0
            }
        }

        @keyframes scale {

            0%,
            100% {
                transform: none
            }

            50% {
                transform: scale3d(1.1, 1.1, 1)
            }
        }

        @keyframes fill {
            100% {
                box-shadow: inset 0px 0px 0px 30px #7ac142
            }
        }

        /* Circle Pre-Loader */
        .preloader-wrapper {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 9999;
        }

        .preloader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -25px;
            margin-left: -25px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('after_scripts')
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js">
    </script>
    @if (file_exists(public_path() . '/assets/plugins/forms/validation/localization/messages_' . config('app.locale') . '.min.js'))
        <script src="{{ url('/assets/plugins/forms/validation/localization/messages_' . config('app.locale') . '.min.js') }}"
            type="text/javascript"></script>
    @endif

    <script>
        @if (isset($packages) && isset($paymentMethods) && $packages->count() > 0 && $paymentMethods->count() > 0)

            var currentPackagePrice = {{ isset($currentPackagePrice) ? $currentPackagePrice : 0 }};
            var currentPaymentIsActive = {{ isset($currentPaymentIsActive) ? $currentPaymentIsActive : 0 }};
            var isCreationFormPage = true;
            $(document).ready(function() {
                /* Show price & Payment Methods */
                var selectedPackage = $('input[name=package_id]:checked').val();
                var packagePrice = getPackagePrice(selectedPackage);
                var packageCurrencySymbol = $('input[name=package_id]:checked').data('currencysymbol');
                var packageCurrencyInLeft = $('input[name=package_id]:checked').data('currencyinleft');
                var paymentMethod = $('#paymentMethodId').find('option:selected').data('name');
                showAmount(packagePrice, packageCurrencySymbol, packageCurrencyInLeft);
                showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentIsActive, paymentMethod,
                    isCreationFormPage);

                /* Select a Package */
                $('.package-selection').click(function() {
                    selectedPackage = $(this).val();
                    packagePrice = getPackagePrice(selectedPackage);
                    packageCurrencySymbol = $(this).data('currencysymbol');
                    packageCurrencyInLeft = $(this).data('currencyinleft');
                    showAmount(packagePrice, packageCurrencySymbol, packageCurrencyInLeft);
                    showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentIsActive,
                        paymentMethod, isCreationFormPage);
                });

                /* Select a Payment Method */
                $('#paymentMethodId').on('change', function() {
                    paymentMethod = $(this).find('option:selected').data('name');
                    showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentIsActive,
                        paymentMethod, isCreationFormPage);
                });

                /* Custom Hide -> Form Default Submission
                $('#submitPostForm').on('click', function (e) {
                	e.preventDefault();
                	
                	if (packagePrice <= 0) {
                		$('#postForm').submit();
                	}
                	
                	return false;
                }); */

                /* Custom Add -> Form Default Submission */
                $('#submitPostForm').on('click', function(e) {
                    e.preventDefault();
                    var preloader = $('.preloader-wrapper');
                    preloader.show();
                    setTimeout(function() {
                        preloader.hide();
                        var checkPreloader = $('.check-preloader-wrapper');
                        checkPreloader.show();
                        setTimeout(function() {
                            checkPreloader.hide();
                            $('#successModal').modal('show');
                            $('#successModal').on('hidden.bs.modal', function() {
                                $('#postForm').submit();
                            });
                        }, 2000);
                    }, 3000);
                    return false;
                });
                
            });
        @endif

        /* Show or Hide the Payment Submit Button */
        /* NOTE: Prevent Package's Downgrading */
        /* Hide the 'Skip' button if Package price > 0 */
        function showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentIsActive, paymentMethod,
            isCreationFormPage = true) {
            let submitBtn = $('#submitPostForm');
            let submitBtnLabel = {
                'pay': '{{ t('Pay') }}',
                'submit': '{{ t('submit') }}',
            };
            let skipBtn = $('#skipBtn');

            if (packagePrice > 0) {
                submitBtn.html(submitBtnLabel.pay).show();
                skipBtn.hide();

                if (currentPackagePrice > packagePrice) {
                    submitBtn.hide().html(submitBtnLabel.submit);
                }
                if (currentPackagePrice == packagePrice) {
                    if (paymentMethod == 'offlinepayment') {
                        if (!isCreationFormPage && currentPaymentIsActive != 1) {
                            submitBtn.hide().html(submitBtnLabel.submit);
                            skipBtn.show();
                        }
                    }
                }
            } else {
                skipBtn.show();
                submitBtn.html(submitBtnLabel.submit);
            }
        }
    </script>
@endsection
