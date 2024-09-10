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

namespace App\Http\Controllers\Web;

use Larapen\LaravelMetaTags\Facades\MetaTag;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends FrontController
{
   
   
   public function loadMorePosts(Request $request)
	{
		$postsPerPage = 20;
		$page = $request->get('page', 1);

		$posts = Post::latest()->skip(($page - 1) * $postsPerPage)->take($postsPerPage)->get();
		$totalPosts = Post::count();

		// Check if the request is an API call
		if ($request->is('api/*')) {
		    return response()->json($posts);
		}

		// Web View: Build the HTML response
		$postsHtml = '<div class="row featured-list-slider">';
		foreach ($posts as $post) {
			$price = data_get($post, 'price') ?? data_get($post, 'price_formatted');
			$postUrl = \App\Helpers\UrlGen::post($post);
			$postTitle = str(data_get($post, 'title'))->limit(30);
			$rating = data_get($post, 'rating_cache');
			$countPictures = data_get($post, 'count_pictures');

			$imageUrl = env('CLOUDFLARE_R2_URL') . '/storage/' . data_get($post, 'picture');
			$imageTag = "<img src=\"$imageUrl\" style=\"border: 1px; border-radius:6px; margin-top: 0px; width: 100%; height: 160px;\" alt=\"" . data_get($post, 'title') . "\" loading=\"lazy\">";

			$postsHtml .= <<<HTML
            <div class="col-lg-2 col-md-4 col-sm-6 col-12 post-item">
                <div class="item item-margin">
                    <a href="$postUrl" class="custom-column">
                        <span class="item-carousel-thumb">
                            <span class="photo-count fa fa-camera">$countPictures</span>
                            $imageTag
                        </span>
                        <span class="item-name text-left mx-3" style="font-size: 0.74rem;">$postTitle</span>
                        <hr>
                        <div class="d-flex justify-content-between m-3">
                            <span class="price text-left" style="color: #131313;">$price</span>
                            <span class="text-right" style="color: #131313;">
                                <i class="fas fa-star" style="color: #fdc60a;"></i>
                                $rating
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        HTML;
		}
		$postsHtml .= '</div>';

		$hasMorePosts = ($page * $postsPerPage) < $totalPosts;

		return response()->json([
			'postsHtml' => $postsHtml,
			'hasMorePosts' => $hasMorePosts,
		]);
	}
   
   
   	/**
	 * @return \Illuminate\Contracts\View\View
	 */
	public function index()
	{
		$customPackage = Package::all();
		// Call API endpoint
		$endpoint = '/homeSections';
		$data = makeApiRequest('get', $endpoint);
		
		$message = $this->handleHttpError($data);
		$sections = (array)data_get($data, 'result.data');
		
		// Share sections' options in views,
		// that requires to be accessible everywhere in the app's views (including the master view).
		foreach ($sections as $section) {
			$optionName = data_get($section, 'method') . 'Op';
			view()->share($optionName, (array)data_get($section, $optionName));
		}
		
		// Get SEO
		$getSearchFormOp = data_get($sections, 'getSearchForm.getSearchFormOp') ?? [];
		$this->setSeo($getSearchFormOp);
		
		return appView('home.index', compact('sections', 'customPackage'));
	}
	
	/**
	 * Set SEO information
	 *
	 * @param array $getSearchFormOp
	 */
	private function setSeo(array $getSearchFormOp = [])
	{
		// Meta Tags
		[$title, $description, $keywords] = getMetaTag('home');
		MetaTag::set('title', $title);
		MetaTag::set('description', strip_tags($description));
		MetaTag::set('keywords', $keywords);
		
		// Open Graph
		$this->og->title($title)->description($description);
		$ogImageUrl = config('settings.seo.og_image_url');
		if (empty($ogImageUrl)) {
			if (!empty(config('country.background_image_url'))) {
				$ogImageUrl = config('country.background_image_url');
			}
		}
		if (empty($ogImageUrl)) {
			if (!empty(data_get($getSearchFormOp, 'background_image_url'))) {
				$ogImageUrl = data_get($getSearchFormOp, 'background_image_url');
			}
		}
		if (!empty($ogImageUrl)) {
			if ($this->og->has('image')) {
				$this->og->forget('image')->forget('image:width')->forget('image:height');
			}
			$this->og->image($ogImageUrl, [
				'width'  => 600,
				'height' => 600,
			]);
		}
		view()->share('og', $this->og);
	}
}