<div class="content-box layout-section d-none">
    <div class="row row-featured row-featured-category">

        <div class="col-xl-12">
            <section class="moduleWrapper-4129463801 signInMarketing-4274934412" aria-labelledby="signin-cta-home" data-qa-id="SignInBanner">
                <h2 class="signInMarketingHeading-549877605" id="signin-cta-home">Ezead better when you are a member
                </h2>
                <p class="signInMarketingBody-2245658267">See more relevant listings, find what you are looking for
                    quicker, and more!</p>
                @if (auth()->check())
                <a class="link-3970392289 link__default-1151936189 signInMarketingButton-2828027866" href="{{ \App\Helpers\UrlGen::addPost() }}">Start Now</a>
                @else
                <a href="#quickLogin" class="link-3970392289 link__default-1151936189 signInMarketingButton-2828027866" title="Sign In" data-bs-toggle="modal">
                    Sign In
                </a>
                @endif
            </section>
        </div>

    </div>
</div>
