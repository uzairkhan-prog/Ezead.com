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

namespace App\Http\Controllers\Web\Search;

use Larapen\LaravelMetaTags\Facades\MetaTag;
use App\Models\Picture;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class SearchController extends BaseController
{
	/**
	 * @return \Illuminate\Contracts\View\View
	 * @throws \Psr\Container\ContainerExceptionInterface
	 * @throws \Psr\Container\NotFoundExceptionInterface
	 */
	public function index()
	{
		// Call API endpoint
		$endpoint = '/posts';
		$queryParams = [
			'op' => 'search',
		];
		$queryParams = array_merge(request()->all(), $queryParams);
		$headers = [
			'X-WEB-CONTROLLER' => class_basename(get_class($this)),
		];
		$data = makeApiRequest('get', $endpoint, $queryParams, $headers);

		$apiMessage = $this->handleHttpError($data);
		$apiResult = data_get($data, 'result');
		$apiExtra = data_get($data, 'extra');
		$preSearch = data_get($apiExtra, 'preSearch');

		// Sidebar
		$this->bindSidebarVariables((array)data_get($apiExtra, 'sidebar'));

		// Get Titles
		$this->getHtmlTitle($preSearch);
		$this->getBreadcrumb($preSearch);

		// Meta Tags
		[$title, $description, $keywords] = $this->getMetaTag($preSearch);
		// Custom hide title
		// MetaTag::set('title', $title);
		// Custom title
		MetaTag::set('title', 'Find Items Through Our Search Feature Ezead Buy sell trade...');
		MetaTag::set('description', $description);
		MetaTag::set('keywords', $keywords);

		// Open Graph
		$this->og->title($title)->description($description)->type('website');
		view()->share('og', $this->og);

		return appView('search.results', compact('apiMessage', 'apiResult', 'apiExtra'));
	}

	// ADVANCE SEARCH
	public function advanceSearch()
	{
		// Call API endpoint
		$endpoint = '/posts';
		$queryParams = [
			'op' => 'search',
		];
		$queryParams = array_merge(request()->all(), $queryParams);
		$headers = [
			'X-WEB-CONTROLLER' => class_basename(get_class($this)),
		];
		$data = makeApiRequest('get', $endpoint, $queryParams, $headers);

		$apiMessage = $this->handleHttpError($data);
		$apiResult = data_get($data, 'result');
		$apiExtra = data_get($data, 'extra');
		$preSearch = data_get($apiExtra, 'preSearch');

		// Sidebar
		$this->bindSidebarVariables((array)data_get($apiExtra, 'sidebar'));

		// Get Titles
		$this->getHtmlTitle($preSearch);
		$this->getBreadcrumb($preSearch);

		// Meta Tags
		[$title, $description, $keywords] = $this->getMetaTag($preSearch);
		// Custom hide title
		// MetaTag::set('title', $title);
		// Custom title
		MetaTag::set('title', 'Find Items Through Our Search Feature Ezead Buy sell trade...');
		MetaTag::set('description', $description);
		MetaTag::set('keywords', $keywords);

		// Open Graph
		$this->og->title($title)->description($description)->type('website');
		view()->share('og', $this->og);

		$customPosts = Post::with(['pictures' => function ($query) {
			$query->select('id', 'post_id', 'filename');
		}])->orderBy('created_at', 'desc')->take(100)->get();

		return appView('search.advance-search', compact('apiMessage', 'apiResult', 'apiExtra', 'customPosts'));
	}

	// TESTING CLOUDFLARE R2 IMAGE
	public function test(Request $request)
	{
	    
	   // // Get the image content from the configured disk (e.g., 'public' disk)
    //     $imagePath = 'files/ca/400/thumb-320x240-27f6fa7e6718ccc5b8b62b72b31e9790.jpg';
    //     $imageData = Storage::disk('public')->get($imagePath);
        
    //     $newPath = 'ezead-com/test/files/ca/400/thumb-320x240-27f6fa7e6718ccc5b8b62b72b31e9790.jpg';
    //     Storage::disk('r2')->put($newPath, $imageData);

        // Get all files from the 'files/ca/' directory in the 'public' disk
        // $directory = 'files/ca/158/';
        // $files = Storage::disk('public')->files($directory);
        // if ($files) {
        //     foreach ($files as $file) {
        //         $imageData = Storage::disk('public')->get($file);
        //         $newPathOnR2 = 'ezead-com/public/storage/' . $file;
        //         $data = Storage::disk('r2')->put($newPathOnR2, $imageData);
        //     }
        //     if ($data === true) {
        //         dd('True', $data);
        //     } else {
        //         dd('False', $data);
        //     }
        // } else {
        //     dd('False Files');
        // }
        
        // $directories = ['files/lp/154/', 'files/lp/155/', 'files/lp/176/'];
        // $newPathOnR2 = 'ezead-com/public/storage/';
        // foreach ($directories as $directory) {
        //     $files = Storage::disk('public')->files($directory);
        //     if ($files) {
        //         foreach ($files as $file) {
        //             $imageData = Storage::disk('public')->get($file);
        //             $newFilePath = $newPathOnR2 . $file;
        //             $data = Storage::disk('r2')->put($newFilePath, $imageData);
        //             // $data = Storage::disk('r2')->delete($newFilePath);
        //             if ($data === true) {
        //                 \Log::info('File transferred successfully: ' . $file);
        //             } else {
        //                 \Log::error('Failed to transfer file: ' . $file);
        //             }
        //         }
        //     } else {
        //         \Log::warning('No files found in directory: ' . $directory);
        //     }
        // }

		// Image Upload
		if ($request->hasFile('image')) {
			$request->validate([
				'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
			]);

			$image = $request->file('image');
			$imageName = $image->getClientOriginalName();

			// Set the correct path for storing the image in the r2 storage
			$imagePath = 'ezead-com/test/' . $imageName;

			// Resize the image using the r2_disk() function
			$resized = Image::make($image)->resize(320, 213)->stream();

			// Store the resized image using the r2_disk() function
			$is_uploaded = Storage::disk('r2')->put($imagePath, $resized->__toString());

			// Check if the image is successfully uploaded
			if ($is_uploaded) {
				// Save $imageName to the database or perform other actions
				return redirect()->back()->with('success', 'Image uploaded successfully.');
			} else {
				// Handle the case where the image upload fails
				return redirect()->back()->with('error', 'Failed to upload image.');
			}
		}
		return appView('search.test');
	}
}
