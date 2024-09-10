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

namespace App\Http\Controllers\Api\User;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Scopes\VerifiedScope;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

trait Update
{
	/**
	 * @param $id
	 * @param \App\Http\Requests\UserRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Psr\Container\ContainerExceptionInterface
	 * @throws \Psr\Container\NotFoundExceptionInterface
	 */
	public function updateDetails($id, UserRequest $request): \Illuminate\Http\JsonResponse
	{
		$user = User::with('userDetail')->withoutGlobalScopes([VerifiedScope::class])->where('id', $id)->first();
// 		print_r($user); die;

		if (empty($user)) {
			return $this->respondNotFound(t('user_not_found'));
		}

		$authUser = request()->user() ?? auth('sanctum')->user();

		// Check logged User
		// Get the User Personal Access Token Object
		$personalAccess = $authUser->tokens()->where('id', getApiAuthToken())->first();
		if (!empty($personalAccess)) {
			if ($personalAccess->tokenable_id != $user->id) {
				return $this->respondUnauthorized();
			}
		} else {
			return $this->respondUnauthorized();
		}

		// Check if these fields has changed
		$emailChanged = $request->filled('email') && $request->input('email') != $user->email;
		$phoneChanged = $request->filled('phone') && $request->input('phone') != $user->phone;
		$usernameChanged = $request->filled('username') && $request->input('username') != $user->username;

		// Conditions to Verify User's Email or Phone
		$emailVerificationRequired = config('settings.mail.email_verification') == '1' && $emailChanged;
		$phoneVerificationRequired = config('settings.sms.phone_verification') == '1' && $phoneChanged;

		// Update User
		$input = $request->only($user->getFillable());

		$protectedColumns = ['username', 'password'];
		$protectedColumns = ($request->filled('auth_field'))
			? array_merge($protectedColumns, [$request->input('auth_field')])
			: array_merge($protectedColumns, ['email', 'phone']);

		foreach ($input as $key => $value) {
			if ($request->has($key)) {
				if (in_array($key, $protectedColumns) && empty($value)) {
					continue;
				}

				if ($key == 'photo' && isUploadedFile($value)) {
					continue;
				}

				$user->{$key} = $value;
			}
		}

		// Checkboxes
		$user->phone_hidden = (int)$request->input('phone_hidden');
		$user->disable_comments = (int)$request->input('disable_comments');
		$user->accept_marketing_offers = (int)$request->input('accept_marketing_offers');
		if ($request->filled('accept_terms')) {
			$user->accept_terms = (int)$request->input('accept_terms');
		}

		// Other fields
		if ($request->filled('password')) {
			if (isset($input['password'])) {
				$user->password = Hash::make($input['password']);
			}
		}

		// Email verification key generation
		if ($emailVerificationRequired) {
			$user->email_token = md5(microtime() . mt_rand());
			$user->email_verified_at = null;
		}

		// Phone verification key generation
		if ($phoneVerificationRequired) {
			$user->phone_token = mt_rand(100000, 999999);
			$user->phone_verified_at = null;
		}
		
		// Update Country Code
		if ($request->input('new_country_code')) {
			$user->country_code = $request->input('new_country_code');
		} else {
			$user->country_code = $request->input('country_code', config('country.code'));
		}

		$extra = [];

		// Don't log out the User (See User model)
		$extra['emailOrPhoneChanged'] = ($emailVerificationRequired || $phoneVerificationRequired);

		// Save
		
		$user->save();

		$userdetail = UserDetail::find($user->userDetail->id);
		$userdetail->company_name = $request->company_name;
		$userdetail->address = $request->address;
		$userdetail->zip_code = $request->zip_code;
		$userdetail->whatsapp_number  = $request->whatsapp_number;
		$userdetail->fax = $request->fax;
		$userdetail->your_website_url = $request->your_website_url;
		$userdetail->facebook_url = $request->facebook_url;
		$userdetail->twitter_url = $request->twitter_url;
		$userdetail->linked_in_url = $request->linked_in_url;
		$userdetail->ebay_url = $request->ebay_url;
		$userdetail->accept_terms = $request->accept_terms;
		$userdetail->account_type = $request->account_type;
		$userdetail->theme_mode = $request->theme_mode;

		if ($request->input('new_country_code')) {
			$userdetail->country_code = $request->input('new_country_code');
		} else {
			$userdetail->country_code = $request->input('country_code', config('country.code'));
		}
		if ($request->input('new_province_id')) {
			$userdetail->province_id = $request->input('new_province_id');
		} else {
			$userdetail->province_id = $request->input('province_id');
		}
		if ($request->input('new_region_id')) {
			$userdetail->region_id = $request->input('new_region_id');
		} else {
			$userdetail->region_id = $request->input('region_id');
		}
		if ($request->input('new_new_city_id')) {
			$userdetail->new_city_id = $request->input('new_new_city_id');
		} else {
			$userdetail->new_city_id = $request->input('new_city_id');
		}
		if ($request->input('new_neighbour_id')) {
			$userdetail->neighbour_id = $request->input('new_neighbour_id');
		} else {
			$userdetail->neighbour_id = $request->input('neighbour_id');
		}

		if ($request->hasFile('profile_photo')) {
			$file = $request->file('profile_photo');
			$extension = $file->getClientOriginalExtension();
			$filename = time() . '.' . $extension;
			$file->move('public/assets/images/', $filename);

            $filePath = 'public/assets/images/' . $filename;
            Storage::disk('r2')->put('ezead-com/public/assets/images/' . $filename, file_get_contents($filePath));

			if ($userdetail->profile_photo) {
				Storage::delete('public/assets/images/' . $userdetail->profile_photo);
			}
			$userdetail->profile_photo = $filename;
		}
// dd($userdetail->profile_photo);
		// User Detail Save
		
		$userdetail->save();

		$data = [
			'success' => true,
			'message' => t('account_details_has_updated_successfully'),
			'result'  => (new UserResource($user))->toArray($request),
		];

		// Send Email Verification message
		if ($emailVerificationRequired) {
			$extra['sendEmailVerification'] = $this->sendEmailVerification($user);
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
			$extra['sendPhoneVerification'] = $this->sendPhoneVerification($user);
			if (
				array_key_exists('success', $extra['sendPhoneVerification'])
				&& array_key_exists('message', $extra['sendPhoneVerification'])
			) {
				$extra['mail']['success'] = $extra['sendPhoneVerification']['success'];
				$extra['mail']['message'] = $extra['sendPhoneVerification']['message'];
			}
		}

		// User's Photo
		$extra['photo'] = [];
		if ($request->hasFile('photo')) {
			// Update User's Photo
			$extra['photo'] = $this->updatePhoto($user, $request);
		} else {
			// Remove User's Photo
			$photoRemovalRequested = ($request->filled('remove_photo') && $request->input('remove_photo'));
			if ($photoRemovalRequested) {
				$extra['photo'] = $this->removePhoto($user, $request);
			}
		}
		if (isset($extra['photo']['success'])) {
			// Update the '$data' result value, If photo is uploaded successfully
			if ($extra['photo']['success']) {
				if (isset($extra['photo']['result']) && !empty($extra['photo']['result'])) {
					$data['result'] = $extra['photo']['result'];
					unset($extra['photo']['result']);
				}
			}

			// Update the '$data' infos, If error found during the photo upload
			if (!$extra['photo']['success'] && isset($extra['photo']['message'])) {
				$data['success'] = $extra['photo']['success'];
				$data['message'] = $extra['photo']['message'];
				unset($extra['photo']['success']);
				unset($extra['photo']['message']);
			}
		}

		$data['extra'] = $extra;

		return $this->respondUpdated($data);
	}
}
