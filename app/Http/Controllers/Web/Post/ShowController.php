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

namespace App\Http\Controllers\Web\Post;

use App\Helpers\UrlGen;
use App\Http\Controllers\Web\Post\Traits\CatBreadcrumbTrait;
use App\Http\Controllers\Web\Post\Traits\ReviewsPlugin;
use App\Models\Package;
use App\Models\User;
use App\Models\Post;
use App\Models\Region;
use App\Http\Controllers\Web\FrontController;
use Larapen\LaravelMetaTags\Facades\MetaTag;
use DB;

class ShowController extends FrontController
{
	use CatBreadcrumbTrait, ReviewsPlugin;

	/**
	 * DetailsController constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->middleware(function ($request, $next) {
			$this->commonQueries();

			return $next($request);
		});
	}

	/**
	 * Common Queries
	 */
	public function commonQueries()
	{
		// Count Packages
		$countPackages = Package::applyCurrency()->count();
		view()->share('countPackages', $countPackages);

		// Count Payment Methods
		view()->share('countPaymentMethods', $this->countPaymentMethods);
	}

	/**
	 * Show Post's Details.
	 *
	 * @param $postId
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Psr\Container\ContainerExceptionInterface
	 * @throws \Psr\Container\NotFoundExceptionInterface
	 */
	public function index($postId)
	{
		// Get and Check the Controller's Method Parameters
		$parameters = request()->route()->parameters();

		// Check if the Listing's ID key exists
		$idKey = array_key_exists('hashableId', $parameters) ? 'hashableId' : 'id';
		$idKeyDoesNotExist = (empty($parameters[$idKey])
			|| (!isHashedId($parameters[$idKey]) && !is_numeric($parameters[$idKey]))
		);

		// Show 404 error if the Listing's ID key cannot be found
		abort_if($idKeyDoesNotExist, 404);

		// Set the Parameters
		$postId = $parameters[$idKey];
		$slug = $parameters['slug'] ?? null;

		// Forcing 301 redirection for hashed (or non-hashed) ID to update links in search engine indexes
		if (config('settings.seo.listing_hashed_id_seo_redirection')) {
			if (config('settings.seo.listing_hashed_id_enabled') && !isHashedId($postId) && is_numeric($postId)) {
				// Don't lose important notification, so we need to persist your flash data for the request (the redirect request)
				request()->session()->reflash();

				$uri = UrlGen::postPathBasic(hashId($postId), $slug);

				return redirect($uri, 301)->withHeaders(config('larapen.core.noCacheHeaders'));
			}
			if (!config('settings.seo.listing_hashed_id_enabled') && isHashedId($postId) && !is_numeric($postId)) {
				// Don't lose important notification, so we need to persist your flash data for the request (the redirect request)
				request()->session()->reflash();

				$uri = UrlGen::postPathBasic(hashId($postId, true), $slug);

				return redirect($uri, 301)->withHeaders(config('larapen.core.noCacheHeaders'));
			}
		}

		// Decode Hashed ID
		$postId = hashId($postId, true) ?? $postId;

		// Call API endpoint
		$endpoint = '/posts/' . $postId;

		$queryParams = [
			'detailed' => 1,
            //'detailed' => $negotiable,
		];
		if (config('plugins.reviews.installed')) {
			$queryParams['embed'] = 'userRating,countUserRatings';
		}
		$queryParams = array_merge(request()->all(), $queryParams);
		$headers = session()->has('postIsVisited') ? ['X-VISITED-BY-SAME-SESSION' => $postId] : [];
		$data = makeApiRequest('get', $endpoint, $queryParams, $headers);

		$message = $this->handleHttpError($data);
		$post = data_get($data, 'result');
		$customFields = data_get($data, 'extra.fieldsValues');

		// Listing not found
		if (empty($post)) {
			abort(404, $message ?? t('post_not_found'));
		}

		session()->put('postIsVisited', $postId);

		// Pictures Limit
		$picturesLimit = getPicturesLimit($post);
		$pictures = (array)data_get($post, 'pictures');
		if (count($pictures) > 0) {
			$pictures = collect($pictures)->take($picturesLimit)->toArray();
			data_set($post, 'pictures', $pictures);
		}

		// Get possible post's registered Author (User)
		$user = data_get($post, 'user');

		// Get Post's user decision about comments activation
		$commentsAreDisabledByUser = (data_get($user, 'disable_comments') == 1);

		// Category Breadcrumb
		$catBreadcrumb = $this->getCatBreadcrumb(data_get($post, 'category'), 1);

		// GET SIMILAR POSTS
		$widgetSimilarPosts = $this->similarPosts(data_get($post, 'id'));

		// Meta Tags
		[$title, $description, $keywords] = getMetaTag('listingDetails');
		$title = str_replace('{ad.title}', data_get($post, 'title'), $title);
        
		$customPost = Post::find(data_get($post, 'id'));
        
		// Get Provinces, Region, New_City, Neighbour in Show Post.
		$province = '';
		$region = '';
		$new_city = '';
		$neighbour = '';

		if (!empty($post['province_id'])) {
			$province = Region::find($post['province_id']);
			$province = $province->name;
		}
		if (!empty($post['region_id'])) {
			$region = Region::find($post['region_id']);
			$region = $region->name;
		}
		if (!empty($post['new_city_id'])) {
			$new_city = Region::find($post['new_city_id']);
			$new_city = $new_city->name;
		}
		if (!empty($post['neighbour_id'])) {
			$neighbour = Region::find($post['neighbour_id']);
			$neighbour = $neighbour->name;
		}

		// custom hide Location on Title Post
		// $title = str_replace('{location.name}', data_get($post, 'city.name'), $title);

		$description = str_replace('{ad.description}', str(str_strip(strip_tags(data_get($post, 'description'))))->limit(200), $description);
		// custom hide keywords
        // $keywords = str_replace('{ad.tags}', str_replace(',', ', ', @implode(',', data_get($post, 'tags'))), $keywords);

		// custom add keywords with if empty-tag else category
        $keywords = str_replace(',', ', ', @implode(',', data_get($post, 'tags')));
		if ($keywords === null || $keywords === '') {
			$categories = data_get($post, 'category');
			function getAllCategories($category, &$result = [])
			{
				$result[] = $category['name'];
				if (isset($category['parent']) && is_array($category['parent'])) {
					getAllCategories($category['parent'], $result);
				}
				return $result;
			}
			$categoryNames = getAllCategories($categories);
			$keywords = implode(', ', $categoryNames);
		}
		
		// custom Location on Title Post
		if (empty($neighbour) && empty($new_city) && empty($region) && empty($province)) {
			$title = str_replace('{location.name}', data_get($post, 'city.name'), $title);
		} else {
			if (!empty($neighbour)) {
				$title = str_replace('{location.name}', $neighbour, $title);
			} elseif (!empty($new_city)) {
				$title = str_replace('{location.name}', $new_city, $title);
			} elseif (!empty($region)) {
				$title = str_replace('{location.name}', $region, $title);
			} elseif (!empty($province)) {
				$title = str_replace('{location.name}', $province, $title);
			}
		}

		$title = removeUnmatchedPatterns($title);
		$description = removeUnmatchedPatterns($description);
		$keywords = removeUnmatchedPatterns($keywords);

		// Fallback
		// custom hide Location on Title Post
		// if (empty($title)) {
		// 	$title = data_get($post, 'title') . ', ' . data_get($post, 'city.name');
		// }
		
		if (empty($description)) {
			$description = str(str_strip(strip_tags(data_get($post, 'description'))))->limit(200);
		}

		// custom Location on Title Post
		if (empty($neighbour) && empty($new_city) && empty($region) && empty($province)) {
			if (empty($title)) {
				$title = data_get($post, 'title') . ', ' . data_get($post, 'city.name');
			}
		} else {
			if (!empty($neighbour)) {
				$title = data_get($post, 'title') . ', ' . $neighbour;
			} elseif (!empty($new_city)) {
				$title = data_get($post, 'title') . ', ' . $new_city;
			} elseif (!empty($region)) {
				$title = data_get($post, 'title') . ', ' . $region;
			} elseif (!empty($province)) {
				$title = data_get($post, 'title') . ', ' . $province;
			}
		}

		MetaTag::set('title', $title);
		MetaTag::set('description', $description);
		MetaTag::set('keywords', $keywords);

		// Open Graph
		$this->og->title($title)->description($description)->type('article');
		if (!empty($pictures)) {
			if ($this->og->has('image')) {
				$this->og->forget('image')->forget('image:width')->forget('image:height');
			}
			foreach ($pictures as $picture) {
				$this->og->image(imgUrl(data_get($picture, 'filename'), 'big'), [
					'width'  => 600,
					'height' => 600,
				]);
			}
		}
		view()->share('og', $this->og);

		// Reviews Plugin Data
		if (config('plugins.reviews.installed')) {
			$reviewsApiResult = $this->getReviews(data_get($post, 'id'));
			view()->share('reviewsApiResult', $reviewsApiResult);
		}
		
		 if ($user) {
        $usr = User::find(data_get($user, 'id'));
        if ($usr) {
            $user_detail = $usr->userDetail;
        } else {
            $user_detail = null;
        }
    } else {
        $usr = null;
        $user_detail = null;
    }
		
		return appView('post.show.index', compact(
			'picturesLimit',
			'post',
			'pictures',
			'user',
			'user_detail',
			'province',
			'region',
			'new_city',
			'neighbour',
			'customPost',
			'catBreadcrumb',
			'customFields',
			'commentsAreDisabledByUser',
			'widgetSimilarPosts'
		));
	}

	/**
	 * @param $postId
	 * @return array|null
	 */
    public function similarPosts($postId): ?array
	{
		$post = null;
		$posts = [];
		$totalPosts = 0;
		$widgetSimilarPosts = null;
		$message = null;

		// GET SIMILAR POSTS
		if (in_array(config('settings.single.similar_listings'), ['1', '2'])) {
			// Call API endpoint
			$endpoint = '/posts';
			$queryParams = [
				'op'       => 'similar',
				'postId'   => $postId,
				'distance' => 50, // km OR miles
			];
			$queryParams = array_merge(request()->all(), $queryParams);
		
			$headers = [
				'X-WEB-CONTROLLER' => class_basename(get_class($this)),
			];
			$data = makeApiRequest('get', $endpoint, $queryParams, $headers);

			$message = data_get($data, 'message');
			$posts = data_get($data, 'result.data');
			$totalPosts = data_get($data, 'extra.count.0');
			$post = data_get($data, 'extra.preSearch.post');
		}

		if (config('settings.single.similar_listings') == '1') {
			// Featured Area Data
			$widgetSimilarPosts = [
				'title'      => t('Similar Listings'),
				'link'       => UrlGen::category(data_get($post, 'category')),
				'posts'      => $posts,
				'totalPosts' => $totalPosts,
				'message'    => $message,
			];
			$widgetSimilarPosts = ($totalPosts > 0) ? $widgetSimilarPosts : null;
		} else if (config('settings.single.similar_listings') == '2') {
			$distance = 50; // km OR miles

			// Featured Area Data
			$widgetSimilarPosts = [
				'title'      => t('more_listings_at_x_distance_around_city', [
					'distance' => $distance,
				]),
				'link'       => UrlGen::city(data_get($post, 'city')),
				'posts'      => $posts,
				'totalPosts' => $totalPosts,
				'message'    => $message,
			];
			$widgetSimilarPosts = ($totalPosts > 0) ? $widgetSimilarPosts : null;
		}
		
		return $widgetSimilarPosts;
	}
}
