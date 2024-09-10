@php
    $post ??= [];
    $user ??= [];
    $countPackages ??= 0;
    $countPaymentMethods ??= 0;
@endphp
<aside>
    <div class="card card-user-info sidebar-card">
        @if (auth()->check() && auth()->id() == data_get($post, 'user_id'))
            <div class="card-header">{{ t('Manage Listing') }}</div>
        @else
            <div class="block-cell user">
                <div class="cell-media">
                    {{-- <img src="{{ data_get($post, 'user_photo_url') }}" alt="{{ data_get($post, 'contact_name') }}"> --}}
                    @if (!empty($user_detail) && !empty($user_detail->profile_photo))
                        <img id="userImg" class="userImg"
                            src="{{ env('CLOUDFLARE_R2_URL') . '/assets/images/' . $user_detail->profile_photo }}"
                            alt="user">&nbsp;
                    @else
                        <img id="userImg" class="userImg"
                            src="{{ env('CLOUDFLARE_R2_URL') . '/storage/app/default/user.png' }}" alt="user">&nbsp;
                    @endif
                </div>
                <div class="cell-content">
                    <h5 class="title">{{ t('Posted by') }}</h5>
                    <span class="name">
                        @if (!empty($user))
                            <a href="{{ \App\Helpers\UrlGen::user($user) }}">
                                {{ data_get($post, 'contact_name') }}
                            </a>
                        @else
                            {{ data_get($post, 'contact_name') }}
                        @endif
                    </span>

                    @if (config('plugins.reviews.installed'))
                        @if (view()->exists('reviews::ratings-user'))
                            @include('reviews::ratings-user')
                        @endif
                    @endif
                </div>
            </div>
        @endif

        <div class="card-content">
            @php
                $evActionStyle = 'style="border-top: 0;"';
            @endphp
            @if (!auth()->check() || (auth()->check() && auth()->user()->getAuthIdentifier() != data_get($post, 'user_id')))
                <div class="card-body text-start">
                    <div class="grid-col">
                        <div class="col from">
                            <i class="bi bi-geo-alt"></i>
                            <span>{{ t('location') }}</span>
                        </div>
                        <div class="col to">
                            @php
                                $locationData = [
                                    'neighbour' => $neighbour,
                                    'new_city' => $new_city,
                                    'region' => $region,
                                    'province' => $province,
                                ];
                                $countryCode = data_get($post, 'country_code');
                                $countryCodes = ['CA' => 'Canada', 'AU' => 'Australia', 'GB' => 'United Kingdom', 'US' => 'United States'];
                                $country = $countryCodes[$countryCode] ?? 'No Location';
                            @endphp
                            @if (empty(array_filter($locationData)))
                                <span>
                                    <a>{{ $country }}</a>
                                </span>
                            @else
                                @foreach ($locationData as $location)
                                    @if (!empty($location))
                                        <span class="item-location"{!! config('lang.direction') == 'rtl' ? ' dir="rtl"' : '' !!}>
                                            <i class="bi bi-geo-alt"></i> {{ $location }}
                                        </span>&nbsp;
                                        @break
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @if (!config('settings.single.hidecard-body text-start_dates'))
                        @if (!empty($user) && !empty(data_get($user, 'created_at_formatted')))
                            <div class="grid-col">
                                <div class="col from">
                                    <i class="bi bi-person-check"></i>
                                    <span>{{ t('Joined') }}</span>
                                </div>
                                <div class="col to">
                                    <span>{!! data_get($user, 'created_at_formatted') !!}</span>
                                </div>
                            </div>
                        @endif
                    @endif
                    @if (!empty(data_get($post, 'website_url')) && data_get($post, 'website_url_hidden') != '1')
                        <div class="grid-col text-center">
                            <div class="col from" style="margin-top: 15px;">
                                <i class="fas fa-external-link-alt"></i>
                                <a href="{{ data_get($post, 'website_url') }}" target="_blank"
                                    style="font-size: 16px;">
                                    Visit website
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                @php
                    $evActionStyle = 'style="border-top: 1px solid #ddd;"';
                @endphp
            @endif

            <div class="ev-action" {!! $evActionStyle !!}>
                @if (auth()->check())
                    @if (auth()->user()->id == data_get($post, 'user_id'))
                        <a href="{{ \App\Helpers\UrlGen::editPost($post) }}" class="btn btn-default btn-block">
                            <i class="far fa-edit"></i> {{ t('Update the details') }}
                        </a>
                        @if (config('settings.single.publication_form_type') == '1')
                            <a href="{{ url('posts/' . data_get($post, 'id') . '/photos') }}"
                                class="btn btn-default btn-block">
                                <i class="fas fa-camera"></i> {{ t('Update Photos') }}
                            </a>
                            @if ($countPackages > 0 && $countPaymentMethods > 0)
                                <a href="{{ url('posts/' . data_get($post, 'id') . '/payment') }}"
                                    class="btn btn-success btn-block">
                                    <i class="far fa-check-circle"></i> {{ t('Make It Premium') }}
                                </a>
                            @endif
                        @endif
                        @if (empty(data_get($post, 'archived_at')) && isVerifiedPost($post))
                            <a href="{{ url('account/posts/list/' . data_get($post, 'id') . '/offline') }}"
                                class="btn btn-warning btn-block confirm-simple-action">
                                <i class="fas fa-eye-slash"></i> {{ t('put_it_offline') }}
                            </a>
                        @endif
                        @if (!empty(data_get($post, 'archived_at')))
                            <a href="{{ url('account/posts/archived/' . data_get($post, 'id') . '/repost') }}"
                                class="btn btn-info btn-block confirm-simple-action">
                                <i class="fa fa-recycle"></i> {{ t('re_post_it') }}
                            </a>
                        @endif
                    @else
                        {!! genPhoneNumberBtn($post, true) !!}
                        {!! genEmailContactBtn($post, true) !!}
                    @endif
                    @php
                        try {
                            if (
                                auth()
                                    ->user()
                                    ->can(\App\Models\Permission::getStaffPermissions())
                            ) {
                                $btnUrl = admin_url('blacklists/add') . '?';
                                $btnQs = !empty(data_get($post, 'email')) ? 'email=' . data_get($post, 'email') : '';
                                $btnQs = !empty($btnQs) ? $btnQs . '&' : $btnQs;
                                $btnQs = !empty(data_get($post, 'phone')) ? $btnQs . 'phone=' . data_get($post, 'phone') : $btnQs;
                                $btnUrl = $btnUrl . $btnQs;

                                if (!isDemoDomain($btnUrl)) {
                                    $btnText = trans('admin.ban_the_user');
                                    $btnHint = $btnText;
                                    if (!empty(data_get($post, 'email')) && !empty(data_get($post, 'phone'))) {
                                        $btnHint = trans('admin.ban_the_user_email_and_phone', [
                                            'email' => data_get($post, 'email'),
                                            'phone' => data_get($post, 'phone'),
                                        ]);
                                    } else {
                                        if (!empty(data_get($post, 'email'))) {
                                            $btnHint = trans('admin.ban_the_user_email', ['email' => data_get($post, 'email')]);
                                        }
                                        if (!empty(data_get($post, 'phone'))) {
                                            $btnHint = trans('admin.ban_the_user_phone', ['phone' => data_get($post, 'phone')]);
                                        }
                                    }
                                    $tooltip = ' data-bs-toggle="tooltip" data-bs-placement="bottom" title="' . $btnHint . '"';

                                    $btnOut = '<a href="' . $btnUrl . '" class="btn btn-outline-danger btn-block confirm-simple-action"' . $tooltip . '>';
                                    $btnOut .= $btnText;
                                    $btnOut .= '</a>';

                                    echo $btnOut;
                                }
                            }
                        } catch (\Throwable $e) {
                        }
                    @endphp
                @else
                    {!! genPhoneNumberBtn($post, true) !!}
                    {!! genEmailContactBtn($post, true) !!}
                @endif
                @if (!empty($user_detail) && $user_detail->accept_terms)
                    <a href="#" title="facebook" class="btn btn-fb share s_facebook btn-block"><i
                            class="fab fa-facebook"></i>
                        FaceBook</a>
                    <a href="#" title="twitter" class="btn btn-tw share s_twitter btn-block"><i
                            class="fab fa-twitter"></i>
                        Twitter</a>
                    <a href="#" title="linkedin" class="btn btn-lkin share s_linkedin btn-block"><i
                            class="fab fa-linkedin"></i>
                        Linkedin</a>
                    <a href="#" title="ebay" class="btn btn-info btn-block"><i class="fab fa-ebay"></i>
                        Ebay</a>
                @endif
            </div>
        </div>
    </div>

    @if (config('settings.single.show_listing_on_googlemap'))
        @php
            $mapHeight = 250;
            $mapPlace = !empty(data_get($post, 'city')) ? data_get($post, 'city.name') . ',' . config('country.name') : config('country.name');
            $mapUrl = getGoogleMapsEmbedUrl(config('services.googlemaps.key'), $mapPlace);
        @endphp
        <div class="card sidebar-card">
            <div class="card-header">{{ t('location_map') }}</div>
            <div class="card-content">
                <div class="card-body text-start p-0">
                    <div class="posts-googlemaps">
                        <iframe id="googleMaps" width="100%" height="{{ $mapHeight }}"
                            src="{{ $mapUrl }}"></iframe>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="card sidebar-card">
        <div class="card-header">{{ t('Safety Tips for Buyers') }}</div>
        <div class="card-content">
            <div class="card-body text-start">
                <ul class="list-check">
                    <li>{{ t('Meet seller at a public place') }}</li>
                    <li>{{ t('Check the item before you buy') }}</li>
                    <li>{{ t('Pay only after collecting the item') }}</li>
                </ul>
                @php
                    $tipsLinkAttributes = getUrlPageByType('tips');
                @endphp
                @if (!str_contains($tipsLinkAttributes, 'href="#"') && !str_contains($tipsLinkAttributes, 'href=""'))
                    <p>
                        <a class="float-end" {!! $tipsLinkAttributes !!}>
                            {{ t('Know more') }} <i class="fa fa-angle-double-right"></i>
                        </a>
                    </p>
                @endif
            </div>
        </div>
    </div>
</aside>
