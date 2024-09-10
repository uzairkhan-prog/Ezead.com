<?php
$addListingUrl = (isset($addListingUrl)) ? $addListingUrl : \App\Helpers\UrlGen::addPost();
$addListingAttr = '';
if (!auth()->check()) {
	if (config('settings.single.guests_can_post_listings') != '1') {
		$addListingUrl = '#quickLogin';
		$addListingAttr = ' data-bs-toggle="modal"';
	}
}
?>
<style>
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

	#preloader {
		position: fixed;
		top: 27%;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 9999;
	}
</style>
@if (isset($packages, $paymentMethods) && $packages->count() > 0 && $paymentMethods->count() > 0)
<div class="well pb-0" id="test">
	<h3><i class="fas fa-certificate icon-color-1"></i> {{ t('Premium Listing') }} </h3>
	<p>
		{{ t('premium_plans_hint') }}
	</p>
	<?php $packageIdError = (isset($errors) && $errors->has('package_id')) ? ' is-invalid' : ''; ?>
	<div class="row mb-3 mb-0 d-none">
		<table id="packagesTable" class="table table-hover checkboxtable mb-0">
			@foreach ($packages as $package)
			@php
			$packageStatus = '';
			$badge = '';
			if (isset($currentPackageId, $currentPackagePrice, $currentPaymentIsActive)) {
			// Prevent Package's Downgrading
			if ($currentPackagePrice > $package->price) {
			$packageStatus = ' disabled';
			$badge = ' <span class="badge bg-danger">' . t('Not available') . '</span>';
			} elseif ($currentPackagePrice == $package->price) {
			$badge = '';
			} else {
			if ($package->price > 0) {
			$badge = ' <span class="badge bg-success">' . t('Upgrade') . '</span>';
			}
			}
			if ($currentPackageId == $package->id) {
			$badge = ' <span class="badge bg-secondary">' . t('Current') . '</span>';
			if ($currentPaymentIsActive == 0) {
			$badge .= ' <span class="badge bg-warning">' . t('Payment pending') . '</span>';
			}
			}
			} else {
			if ($package->price > 0) {
			$badge = ' <span class="badge bg-success">' . t('Upgrade') . '</span>';
			}
			}
			@endphp
			<tr>
				<td class="text-start align-middle p-3">
					<div class="form-check">
						<input class="form-check-input package-selection{{ $packageIdError }}" type="radio" name="package_id" id="packageId-{{ $package->id }}" value="{{ $package->id }}" data-name="{{ $package->name }}" data-currencysymbol="{{ $package->currency->symbol }}" data-currencyinleft="{{ $package->currency->in_left }}" {{ (old('package_id', $currentPackageId ?? 0)==$package->id) ? ' checked' : (($package->price==0) ? ' checked' : '') }} {{
										$packageStatus }}>
						<label class="form-check-label mb-0{{ $packageIdError }}">
							<strong class="" data-bs-placement="right" data-bs-toggle="tooltip" title="{!! $package->description_string !!}">{!! $package->name . $badge !!} </strong>
						</label>
					</div>
				</td>
				<td class="text-end align-middle p-3">
					<p id="price-{{ $package->id }}" class="mb-0">
						@if ($package->currency->in_left == 1)
						<span class="price-currency">{!! $package->currency->symbol !!}</span>
						@endif
						<span class="price-int">{{ $package->price }}</span>
						@if ($package->currency->in_left == 0)
						<span class="price-currency">{!! $package->currency->symbol !!}</span>
						@endif
					</p>
				</td>
			</tr>
			@endforeach

			<tr>
				<td class="text-start align-middle p-3">
					@includeFirst([
					config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.payment-methods',
					'post.createOrEdit.inc.payment-methods'
					])
				</td>
				<td class="text-end align-middle p-3">
					<p class="mb-0">
						<strong>
							{{ t('Payable Amount') }}:
							<span class="price-currency amount-currency currency-in-left" style="display: none;"></span>
							<span class="payable-amount">0</span>
							<span class="price-currency amount-currency currency-in-right" style="display: none;"></span>
						</strong>
					</p>
				</td>
			</tr>
		</table>
	</div>
	<center>
		<div class="preloader-wrapper">
			<div id="preloader" class="d-none">
				<div class="spinner-border text-primary" role="status">
				</div>
			</div>
		</div>
	</center>

	<div class="row my-2 justify-content-center">
		@foreach($packages as $package)
		<?php
		$boxClass = (data_get($package, 'recommended') == 1) ? ' border-color-primary' : '';
		$boxHeaderClass = (data_get($package, 'recommended') == 1) ? ' bg-primary border-color-primary text-white' : ' bg-dark text-white';
		$boxBtnClass = (data_get($package, 'recommended') == 1) ? ' btn-primary' : ' btn-outline-primary';
		$listBorder = (data_get($package, 'price') == 0.00) ? ' custom-border-list' : '';
		?>
		<div class="col-md-3">
			<div class="card mb-4 custom-card-hover mb-4 box-shadow{{ $boxClass }}">
				<div class="card-header text-center{{ $boxHeaderClass }}">
					<h4 class="my-0 fw-normal pb-0 h4">{{ data_get($package, 'short_name') }}</h4>
				</div>
				<div class="card-body">
					<h1 class="text-center">
						<span class="fw-bold">
							@if (data_get($package, 'currency.in_left') == 1)
							{!! data_get($package, 'currency.symbol') !!}
							@endif
							{{ \App\Helpers\Number::format(data_get($package, 'price')) }}
							@if (data_get($package, 'currency.in_left') == 0)
							{!! data_get($package, 'currency.symbol') !!}
							@endif
						</span>
						<small class="text-muted">/ {{ t('package_entity') }}</small>
					</h1>
					<ul class="list list-border text-center mt-3 mb-4{{ $listBorder }}">
						@if (is_array(data_get($package, 'description_array')) && count(data_get($package, 'description_array')) > 0)
						@foreach(data_get($package, 'description_array') as $option)
						<li>{!! $option !!}</li>
						@endforeach
						@else
						<li> *** </li>
						@endif
					</ul>
					<?php
					$pricingUrl = '';
					if (str_starts_with($addListingUrl, '#')) {
						$pricingUrl = '' . $addListingUrl;
					} else {
						$pricingUrl = $addListingUrl . '?package=' . data_get($package, 'id');
					}
					?>
					<a href="{{ $pricingUrl }}" class="d-none btn btn-lg btn-block{{ $boxBtnClass }}" {!! $addListingAttr !!}>
						{{ t('get_started') }}
					</a>

					<tr>
						<td class="text-start align-middle p-3">
							<div class="form-check">
								<input class="form-check-input package-selection{{ $packageIdError }}" type="radio" name="package_id" id="packageId-{{ $package->id }}" value="{{ $package->id }}" data-name="{{ $package->name }}" data-currencysymbol="{{ $package->currency->symbol }}" data-currencyinleft="{{ $package->currency->in_left }}" {{ (old('package_id', $currentPackageId ?? 0)==$package->id) ? ' checked' : (($package->price==0) ? ' checked' : '') }} {{
												$packageStatus }}>
								<label class="form-check-label mb-0{{ $packageIdError }}">
									<strong class="" data-bs-placement="right" data-bs-toggle="tooltip" title="{!! $package->description_string !!}">{!! $package->name . $badge !!} </strong>
								</label>
							</div>
						</td>
					</tr>

				</div>
			</div>
		</div>
		@endforeach


		<table id="packagesTable" class="custom-packagesTable table table-hover checkboxtable mb-0">
			<tr>
				<td class="text-start align-middle p-3">
					@includeFirst([
					config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.payment-methods',
					'post.createOrEdit.inc.payment-methods'
					])
				</td>
				<td class="text-end align-middle p-3 pt-0">
					<p class="mb-0">
						<strong>
							{{ t('Payable Amount') }}:
							<span class="price-currency amount-currency currency-in-left" style="display: none;"></span>
							<span class="payable-amount">0</span>
							<span class="price-currency amount-currency currency-in-right" style="display: none;"></span>
						</strong>
					</p>
				</td>
			</tr>
		</table>
	</div>

</div>
<script>
	function showPreloader() {
		var preloader = $('.preloader-wrapper');
		preloader.show();
	}

	function hidePreloader() {
		document.getElementById('preloader').classList.add('d-none');
	}
</script>
<script>
	$(document).ready(function() {
		$("input[type=radio]:checked").closest('.custom-card-hover').addClass('custom-card-hover-selected');
		$('input[type=radio][name=package_id]').change(function() {
			$('.custom-card-hover').removeClass('custom-card-hover-selected');
			$(this).closest('.custom-card-hover').addClass('custom-card-hover-selected');
		});
	});
</script>
@includeFirst([
config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.payment-methods.plugins',
'post.createOrEdit.inc.payment-methods.plugins'
])

@endif