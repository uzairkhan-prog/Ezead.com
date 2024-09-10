@extends('layouts.master')

@section('search')
    @parent
    @includeFirst([
        config('larapen.core.customizedViewPath') . 'pages.inc.contact-intro',
        'pages.inc.contact-intro',
    ])
@endsection

@section('content')
    @includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
    <div class="main-container">
        <div class="container">
            <h1 class="text-center title-1" style="color: ;">
                <strong>Contact Us</strong>
            </h1>
            <hr class="center-block small mt-0" style="background-color: ;">
            <div class="row clearfix border rounded p-3" style="background: #f5f5f5 none repeat scroll 0 0">
                @if (isset($errors) && $errors->any())
                    <div class="col-xl-12">
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
                    </div>
                @endif

                @if (session()->has('flash_notification'))
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-12">
                                @include('flash::message')
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Custom Contact Info --}}
                <div class="col-md-12">
                    {{-- <h3 class="text-center" style="color: ;">Contact</h3> --}}
                    <div class="contact-form contact-heading rounded" style="background-color: #e6e6e6;">
                        <h5 class="list-title gray mt-0 px-3">
                            <strong>Contact Info</strong>
                        </h5>
                    </div>
                    <div class="py-3 px-3">
                        <h5>Below is our contact information:</h5>
                    </div>
                    <div class="px-3">
                        <h5><b>Phone :</b> 1-(833) 693-9323</h5>
                        <h5><b>General Email :</b> admin@ezead.com</h5>
                        <h5><b>Support Email:</b> support@ezead.com</h5>
                        <h5><b>Sales Email: </b> sales@ezead.com</h5>
                    </div><br>
                    <div class="px-3">
                        <h5>
                            <b>Mailing Address:</b>
                            <br><br> Ezead Media Group
                            <br> 1921 Lakeview Rd.
                            <br> Cambridge Narrows, NB E4C 1N1
                        </h5>
                    </div>
                </div>

                {{-- Custom Contact Us --}}
                <div class="col-md-12">
                    <div class="contact-form">
                        <div class="contact-heading rounded" style="background-color: #e6e6e6;">
                            <h5 class="list-title gray mt-0 px-3">
                                <strong>{{ t('Contact Us') }}</strong>
                            </h5>
                        </div>

                        <div class="contact-icons px-3">

                            <p class="p-3 mt-3">
                                Thank you for taking the time to visit The Ezead Community. Please use the data in the left
                                column of this page to contact us if you have any questions or suggestions regarding our
                                site.
                                We will respond to your inquiry as soon as we can. We appreciate your business and becoming
                                part
                                of the Ezead Community. Have a great day!
                            </p>
                            <h4>
                                <b>Customer Service of Ezead Media Group</b>
                            </h4>
                            <p>
                                In our efforts to always provide you with the best service, Ezead takes your questions and
                                comments very seriously. Feel free to contact us by any of the means listed on this page.
                            </p>
                            <p>
                                Our worldwide Customer Service is located Maple Ridge BC Canada.
                            </p>
                            <p>
                                We are available on working days from 08:30 - 18:30 (GMT +12)
                            </p>
                            <br>
                            <h4>
                                <b>Our Local time in Maple Ridge:</b>
                            </h4>

                            <br>
                            <h4>
                                <b>Chat live with our online helpdesk</b>
                            </h4>
                            <div class="row py-3">
                                <div class="col-1 text-center">
                                    <i class="fas fa-comments fa-lg"></i>
                                </div>
                                <div class="col-11">
                                    <p>
                                        Ask your question online on working days from 08:30 - 22:00 PST = GMT -8 hours
                                        <br>
                                        <b>PLEASE CLICK LIVE SUPPORT IN THE LOWER RIGHT CORNER</b>
                                    </p>
                                </div>
                            </div>

                            <br>
                            <h4>
                                <b>Give us a phone call or Skype call</b>
                            </h4>
                            <div class="row py-3">
                                <div class="col-1 text-center">
                                    <i class="fas fa-phone-alt fa-lg"></i>
                                </div>
                                <div class="col-11">
                                    <p>
                                        Call 1-(833) 693-9323 or <b>Fax</b> 1-(833) 693-9323 or contact
                                        <br>
                                        Ezead Media Group[ezead.media.group] on Skype
                                    </p>
                                </div>
                            </div>

                            <br>
                            <h4>
                                <b>Send an email</b>
                            </h4>
                            <div class="row py-3">
                                <div class="col-1 text-center">
                                    <i class="fas fa-envelope-open fa-lg"></i>
                                </div>
                                <div class="col-11">
                                    <p>
                                        <b>To: info@ezead.com</b>
                                        <br>
                                        we will reply on working days within 4 hours and 24 hours on weekends and holidays
                                    </p>
                                </div>
                            </div>

                            <br>
                            <h4>
                                <b>Write a letter</b>
                            </h4>
                            <div class="row py-3">
                                <div class="col-1 text-center">
                                    <i class="fas fa-edit fa-lg"></i>
                                </div>
                                <div class="col-11">
                                    <p>
                                        <b>Ezead Media Group Head Office</b>
                                        <br>
                                        1921 Lakeview Rd.
                                        Cambridge Narrows, NB E4C 1N1
                                    </p>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                {{-- Orignal Contact Us --}}
                <div class="col-md-12">
                    <div class="contact-form">
                        <div class="contact-heading rounded" style="background-color: #e6e6e6;">
                            <h5 class="list-title gray mt-0 px-3">
                                <strong>Contact Form</strong>
                            </h5>
                        </div>

                        <form class="form-horizontal needs-validation px-3" method="post"
                            action="{{ \App\Helpers\UrlGen::contact() }}">
                            {!! csrf_field() !!}
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <?php $firstNameError = (isset($errors) and $errors->has('first_name')) ? ' is-invalid' : ''; ?>
                                        <div class="form-floating required">
                                            <input id="first_name" name="first_name" type="text"
                                                placeholder="{{ t('first_name') }}"
                                                class="form-control{{ $firstNameError }}" value="{{ old('first_name') }}">
                                            <label for="first_name">{{ t('first_name') }}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <?php $lastNameError = (isset($errors) and $errors->has('last_name')) ? ' is-invalid' : ''; ?>
                                        <div class="form-floating required">
                                            <input id="last_name" name="last_name" type="text"
                                                placeholder="{{ t('last_name') }}" class="form-control{{ $lastNameError }}"
                                                value="{{ old('last_name') }}">
                                            <label for="last_name">{{ t('last_name') }}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <?php $companyNameError = (isset($errors) and $errors->has('company_name')) ? ' is-invalid' : ''; ?>
                                        <div class="form-floating required">
                                            <input id="company_name" name="company_name" type="text"
                                                placeholder="{{ t('company_name') }}"
                                                class="form-control{{ $companyNameError }}"
                                                value="{{ old('company_name') }}">
                                            <label for="company_name">{{ t('company_name') }}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <?php $emailError = (isset($errors) and $errors->has('email')) ? ' is-invalid' : ''; ?>
                                        <div class="form-floating required">
                                            <input id="email" name="email" type="text"
                                                placeholder="{{ t('email_address') }}"
                                                class="form-control{{ $emailError }}" value="{{ old('email') }}">
                                            <label for="email">{{ t('email_address') }}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <?php $messageError = (isset($errors) and $errors->has('message')) ? ' is-invalid' : ''; ?>
                                        <div class="form-floating required">
                                            <textarea class="form-control{{ $messageError }}" id="message" name="message" placeholder="{{ t('Message') }}"
                                                rows="7" style="height: 150px">{{ old('message') }}</textarea>
                                            <label for="message">{{ t('Message') }}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        @include('layouts.inc.tools.captcha')
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <button type="submit"
                                            class="btn btn-primary btn-lg">{{ t('submit') }}</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('after_scripts')
    <script src="{{ url('assets/js/form-validation.js') }}"></script>
@endsection
