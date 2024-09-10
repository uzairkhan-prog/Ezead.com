{{-- Show AJAX Errors (for JS) --}}
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
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
</div>
<div class="modal fade" id="search-Location" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header px-3">
                <h4 class="modal-title" id="errorModalTitle" style="color: #373373">
                    <b>Search in</b>
                    <span class="country-breadcrumb d-none">
                        <i class="bi bi-arrow-right"></i>
                        <b></b>
                        <i class="bi bi-globe"></i>
                    </span>
                    <span class="province-breadcrumb d-none">
                        <i class="bi bi-arrow-right"></i>
                        <b></b>
                        <i class="fa fa-flag"></i>
                    </span>
                    <span class="regions-breadcrumb d-none">
                        <i class="bi bi-arrow-right"></i>
                        <b></b>
                        <i class="fa fa-map"></i>
                    </span>
                    <span class="cities-breadcrumb d-none">
                        <i class="bi bi-arrow-right"></i>
                        <b></b>
                        <i class="fa fa-city"></i>
                    </span>
                    <span class="neighbours-breadcrumb d-none">
                        <i class="bi bi-arrow-right"></i>
                        <b></b>
                        <i class="fa fa-map-marker"></i>
                    </span>
                </h4>

                <button type="button" class="close" data-bs-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">{{ t('Close') }}</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div id="" class="col-12">
                        @include('home.inc.searchLocation')
                    </div>
                </div>
            </div>
            <div class='modal-footer'>
                <button id="#" type="button" class="btn btn-primary search-location-btn"
                    data-bs-dismiss="modal">Submit</button>
                <button onclick="CloseSearchDropdown()" type="button" class="btn btn-success"
                    data-bs-dismiss="modal">{{ t('Close') }}</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="postSendMail" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header px-3">
                <h4 class="modal-title" id="errorModalTitle">
                    <i class="fas fa-envelope-open"></i>
                    Tell a friend
                </h4>

                <button type="button" class="close" data-bs-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">{{ t('Close') }}</span>
                </button>
            </div>

            <div class="modal-body px-0">
                <div class="row">
                    <div id="errorModalBody" class="col-12">
                        @include('home.inc.custom-sendMail')
                    </div>
                </div>
            </div>
            <div class='modal-footer'>
                <button onclick="PostSendMail()" type="button" class="btn btn-primary">Send message</button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cencel</button>
            </div>

        </div>
    </div>
</div>

@section('after_scripts')
    @parent
@endsection
