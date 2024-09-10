<div class="banner mt-2 mb-5">
    <div class="container price-banner-container">
        <div class="row">
            <div class="col-md-6">
                <div class="price-banner-bg radius-mobile-1">
                    <h1 class="pt-3 pb-0 px-4 pricing-free-posts">
                        Unlimited Free Posts
                    </h1>
                    <ul class="price-banner-ul pt-3 pricing-banner-background-image">
                        <li>
                            <i class="bi bi-dot"></i>
                            30 Days Of Global to Local Online Promotion
                        </li>
                        <li>
                            <i class="bi bi-dot"></i>
                            Up to 20 Uploaded Images Allowed
                        </li>
                        @foreach ($customPackage as $package)
                            @if ($package->price == '0.00')
                                @php
                                    $lines = explode("\n", $package->description);
                                @endphp
                                @foreach ($lines as $line)
                                    @if (!empty(trim($line)))
                                        <li>
                                            <i class="bi bi-dot"></i>
                                            {{ $line }}
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                    <div class="text-end">
                        <a href="/posts/create?package=1" class="btn btn-default pricing-banner-gs">
                            {{ t('get_started') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="price-banner-bg radius-mobile-2">
                    <a href="https://www.ezead.com/page/crowd-funding">
                        <figure style="background-image: url(https://eze.pics/banner-images/Banner%202.webp);min-height: 235px;background-position: center;background-size: contain;background-repeat: no-repeat;"></figure>
                        <div class="text-center">
                            <span class="btn btn-default pricing-banner-gs-2">
                                Support Our Progress: Donate Today
                            </span>
                        </div>
                        <div class="text-center mb-3">
                            <span class="pricing-banner-gs-3">
                                Support our free, user-friendly website to help us grow. Your contribution makes a difference!
                            </span>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>