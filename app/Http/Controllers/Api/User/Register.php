<?php
/*
 * LaraClassifier - Classified Ads Web Application
 * Copyright (c) BeDigit. All Rights Reserved
 *
 *  Website: https://laraclassifier.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers\Api\User;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Jobs_user;
use Illuminate\Support\Facades\Hash;

trait Register
{
	/**
	 * Register a new user account.
	 *
	 * @param UserRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Psr\Container\ContainerExceptionInterface
	 * @throws \Psr\Container\NotFoundExceptionInterface
	 */
	public function register(UserRequest $request): \Illuminate\Http\JsonResponse
	{
		// Conditions to Verify User's Email or Phone
		$emailVerificationRequired = config('settings.mail.email_verification') == '1' && $request->filled('email');
		$phoneVerificationRequired = config('settings.sms.phone_verification') == '1' && $request->filled('phone');

		// New User
		$user = new User();

		$input = $request->only($user->getFillable());
		foreach ($input as $key => $value) {
			if ($request->has($key)) {
				$user->{$key} = $value;
			}
		}

		if ($request->filled('password')) {
			if (isset($input['password'])) {
				$user->password = Hash::make($input['password']);
			}
		}

		if ($request->filled('email') || $request->filled('phone')) {
			$user->email_verified_at = now();
			$user->phone_verified_at = now();

			// Email verification key generation
			if ($emailVerificationRequired) {
				$user->email_token = md5(microtime() . mt_rand());
				$user->email_verified_at = null;
			}

			// Mobile activation key generation
			if ($phoneVerificationRequired) {
				$user->phone_token = mt_rand(100000, 999999);
				$user->phone_verified_at = null;
			}
		}
		
		if ($request->register_country_code) {
			$user->country_code	= $request->register_country_code;
		}
		
		// Save
		$user->save();
		
        if ($user->id) {
            $userdetail = new UserDetail();
            $userdetail->user_id = $user->id;
            $userdetail->email = $user->email;
            $userdetail->company_name = $request->company_name;
            $userdetail->account_type = $request->account_type;
            $userdetail->address = $request->address;
            $userdetail->country_code = $request->register_country_code;
            $userdetail->province_id = $request->register_province_id;
            $userdetail->region_id = $request->register_region_id;
            $userdetail->new_city_id = $request->register_city_id;
            $userdetail->neighbour_id = $request->register_neighbour_id;
            $userdetail->accept_terms = $request->accept_terms;
            $userdetail->zip_code = $request->zip_code;
            $userdetail->whatsapp_number = $request->whatsapp_number;
            $userdetail->fax = $request->fax;
            $userdetail->your_website_url = $request->your_website_url;
            $userdetail->facebook_url = $request->facebook_url;
            $userdetail->twitter_url = $request->twitter_url;
            $userdetail->linked_in_url = $request->linked_in_url;
            $userdetail->ebay_url = $request->ebay_url;

            // User Detail Save
            $userdetail->save();
        }
        
        if ($user->email) {
            $jobs_users = new Jobs_user();
            $jobs_users->user_type_id = $userdetail->account_type;
            $jobs_users->accept_terms = $userdetail->accept_terms;
            $jobs_users->country_code = $user->country_code;
            $jobs_users->name = $user->name;
            $jobs_users->email = $user->email;
            if ($request->filled('password')) {
                if (isset($input['password'])) {
                    $jobs_users->password = Hash::make($input['password']);
                }
            }
        
            // Jobs User Save
            $jobs_users->save();
        }

		$data = [
			'success' => true,
			'message' => t('your_account_has_been_created'),
			'result'  => (new UserResource($user))->toArray($request),
		];

		$extra = [];

		// Send Verification Link or Code
		if ($emailVerificationRequired || $phoneVerificationRequired) {

			// Email
			if ($emailVerificationRequired) {
				// Send Verification Link by Email
				$extra['sendEmailVerification'] = $this->sendEmailVerification($user);
				if (
					array_key_exists('success', $extra['sendEmailVerification'])
					&& array_key_exists('message', $extra['sendEmailVerification'])
					&& !$extra['sendEmailVerification']['success']
				) {
					$extra['mail']['success'] = $extra['sendEmailVerification']['success'];
					$extra['mail']['message'] = $extra['sendEmailVerification']['message'];
				}
			}

			// Phone
			if ($phoneVerificationRequired) {
				// Send Verification Code by SMS
				$extra['sendPhoneVerification'] = $this->sendPhoneVerification($user);
				if (
					array_key_exists('success', $extra['sendPhoneVerification'])
					&& array_key_exists('message', $extra['sendPhoneVerification'])
					&& !$extra['sendPhoneVerification']['success']
				) {
					$extra['mail']['success'] = $extra['sendPhoneVerification']['success'];
					$extra['mail']['message'] = $extra['sendPhoneVerification']['message'];
				}
			}

			// Once Verification Notification is sent (containing Link or Code),
			// Send Confirmation Notification, when user clicks on the Verification Link or enters the Verification Code.
			// Done in the "app/Observers/UserObserver.php" file.

		} else {

			// Redirect to the user area If Email or Phone verification is not required
			if (auth()->loginUsingId($user->id)) {
				// Create the API access token
				$deviceName = $request->input('device_name', 'Desktop Web');
				$token = $user->createToken($deviceName);

				$extra['authToken'] = $token->plainTextToken;
				$extra['tokenType'] = 'Bearer';
			}
		}

		$data['extra'] = $extra;

		return $this->apiResponse($data);
	}
}
