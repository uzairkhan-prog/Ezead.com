<?php

/**
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
 */

namespace App\Http\Controllers\Api\Post\CreateOrEdit\MultiSteps;

use App\Helpers\Ip;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\City;
use App\Models\Post;
use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\VerifiedScope;

trait UpdateMultiStepsFormTrait
{
	/**
	 * @param $id
	 * @param \App\Http\Requests\PostRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Psr\Container\ContainerExceptionInterface
	 * @throws \Psr\Container\NotFoundExceptionInterface
	 */
	public function updateMultiStepsForm($id, PostRequest $request)
	{
		// $countryCode = $request->input('country_code', config('country.code'));

		$user = null;
		if (auth('sanctum')->check()) {
			$user = auth('sanctum')->user();
		}

		$post = null;
		if (!empty($user)) {
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('user_id', $user->id)
				->where('id', $id)
				->first();
			// $post = Post::countryOf($countryCode)->withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
			// 	->where('user_id', $user->id)
			// 	->where('id', $id)
			// 	->first();
		}

		if (empty($post)) {
			return $this->respondNotFound(t('post_not_found'));
		}
		
		// Get the Post's City
		$city = City::find($request->input('city_id', 0));
		if (empty($city)) {
			return $this->respondError(t('posting_listings_is_disabled'));
		}

		// Conditions to Verify User's Email or Phone
		$emailVerificationRequired = config('settings.mail.email_verification') == '1'
			&& $request->filled('email')
			&& $request->input('email') != $post->email;
		$phoneVerificationRequired = config('settings.sms.phone_verification') == '1'
			&& $request->filled('phone')
			&& $request->input('phone') != $post->phone;

		/*
		 * Allow admin users to approve the changes,
		 * If listings approbation option is enable,
		 * And if important data have been changed.
		 */
		if (config('settings.single.listings_review_activation')) {
			if (
				md5($post->title) != md5($request->input('title'))
				|| md5($post->description) != md5($request->input('description'))
			) {
				$post->reviewed_at = null;
			}
		}

		// Update Post
		$input = $request->only($post->getFillable());
		foreach ($input as $key => $value) {
			$post->{$key} = $value;
		}

		// Checkboxes
		$post->negotiable = $request->input('negotiable');
		$post->phone_hidden = $request->input('phone_hidden');
		// Custom Add website_url_hidden
		$post->website_url_hidden = $request->input('website_url_hidden');

		// Other fields
		$post->lat = $city->latitude;
		$post->lon = $city->longitude;
		$post->ip_addr = $request->input('ip_addr', Ip::get());

		// Email verification key generation
		if ($emailVerificationRequired) {
			$post->email_token = md5(microtime() . mt_rand());
			$post->email_verified_at = null;
		}

		// Phone verification key generation
		if ($phoneVerificationRequired) {
			$post->phone_token = mt_rand(100000, 999999);
			$post->phone_verified_at = null;
		}

		// Custo add Website url
		if ($request->filled('website_url')) {
			$websiteUrl = $request->input('website_url');
			// Check if 'https://' or 'http://' is present, if not, add 'https://'
			if (!preg_match("~^(?:https?://)~i", $websiteUrl)) {
				$websiteUrl = "https://" . $websiteUrl;
			}
			$post->website_url = $websiteUrl;
		}

		// $post->province_id = $request->input('province_id');
		// $post->region_id = $request->input('region_id');
		// $post->new_city_id = $request->input('new_city_id');
		// $post->neighbour_id = $request->input('neighbour_id');

		if ($request->input('new_country_code')) {
			$post->country_code = $request->input('new_country_code', config('country.code'));
		} else {
			$post->country_code = $request->input('country_code', config('country.code'));
		}
		if ($request->input('new_province_id')) {
			$post->province_id = $request->input('new_province_id');
		} else {
			$post->province_id = $request->input('province_id');
		}
		if ($request->input('new_region_id')) {
			$post->region_id = $request->input('new_region_id');
		} else {
			$post->region_id = $request->input('region_id');
		}
		if ($request->input('new_new_city_id')) {
			$post->new_city_id = $request->input('new_new_city_id');
		} else {
			$post->new_city_id = $request->input('new_city_id');
		}
		if ($request->input('new_neighbour_id')) {
			$post->neighbour_id = $request->input('new_neighbour_id');
		} else {
			$post->neighbour_id = $request->input('neighbour_id');
		}

		// Save
		$post->save();

		// Start Custom Add View Listing Link
		$viewListing = '<a href="' . \App\Helpers\UrlGen::post($post) . '" style="font-size:14px;float:inline-end;"><i class="fas fa-eye"></i> View Listing</a>';
		// End Custom Add View Listing Link

		$data = [
			'success' => true,
			'message' => t('your_listing_has_been_updated') . $viewListing,
			'result'  => (new PostResource($post))->toArray($request),
		];

		$extra = [];

		// Custom Fields
		$this->storeFieldsValues($post, $request);

		// Send Email Verification message
		if ($emailVerificationRequired) {
			$extra['sendEmailVerification'] = $this->sendEmailVerification($post);
			if (
				array_key_exists('success', $extra['sendEmailVerification'])
				&& array_key_exists('message', $extra['sendEmailVerification'])
			) {
				$extra['mail']['success'] = $extra['sendEmailVerification']['success'];
				$extra['mail']['message'] = $extra['sendEmailVerification']['message'];
			}
		}

		// Send Phone Verification message
		if ($phoneVerificationRequired) {
			$extra['sendPhoneVerification'] = $this->sendPhoneVerification($post);
			if (
				array_key_exists('success', $extra['sendPhoneVerification'])
				&& array_key_exists('message', $extra['sendPhoneVerification'])
			) {
				$extra['mail']['success'] = $extra['sendPhoneVerification']['success'];
				$extra['mail']['message'] = $extra['sendPhoneVerification']['message'];
			}
		}

		$data['extra'] = $extra;

		return $this->apiResponse($data);
	}
}