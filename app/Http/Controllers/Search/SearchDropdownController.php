<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Region;
use App\Models\Post;
use App\Models\Picture;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SearchDropdownController extends Controller
{
    // Selected Pictures Delete
    public function customDeletePostPictures(Request $request)
    {
        if (Auth::Check() && $request->postId) {
            $selectedPictures = $request->input('selectedPictures');
            if (!is_array($selectedPictures)) {
                return response()->json(['success' => false, 'message' => 'Invalid data received']);
            }
            foreach ($selectedPictures as $pictureData) {
                $dataKey = $pictureData['dataKey'];

                $postPictures = Picture::where('id', $dataKey)->get();

                foreach ($postPictures as $picture) {
                    $picture->delete();
                }
            }
            return response()->json(['message' => 'Pictures deleted successfully']);
        }
    }

    // CATEGORIES
    public function getCategories()
    {
        $data = '';
        $html = '';
        $header_categories = Category::all();

        // Categories Header
        if ($header_categories) {
            // Main Category
            foreach ($header_categories->sortBy('name') as $header_category) {
                if ($header_category->parent_id == null && $header_category->active == 1) {
                    $html .= '<li class="list-item">
                <a style="background-color: transparent!important;" href="' . \App\Helpers\UrlGen::category($header_category) . '"
                    class="menu-link mega-menu-link" aria-haspopup="true">
                    <i class="' . $header_category->icon_class . '"></i> ' . $header_category->name . '
                </a>';
                    if (count($header_category->children)) {
                        $html .= '
                <div class="bi-icons">
                    <span class="bi bi-chevron-right"></span>
                </div>';
                    }
                    $html .= '<ul class="menu menu-list mega-menu--multiLevel2 transparent mega-sub-menu-ul"
                    
                    >';
                    if (count($header_category->children)) {
                        $html .= '
                        <li>
                            <a style="background-color: transparent!important; color:#369!important;"
                                href="' . \App\Helpers\UrlGen::category($header_category) . '"
                                class="menu-link mega-menu-link">
                                <b><i class="fas fa-th-list"></i> SUB CATEGORY</b>
                            </a>
                        </li>';
                    }
                    if (count($header_category->children)) {
                        // Sub Category
                        foreach ($header_category->children as $subCatKey => $subCat) {
                            $html .= '<li>';
                            $html .= '
                        <a 
                            href="' . \App\Helpers\UrlGen::category($subCat) . '"
                            class="menu-link menu-list-link" aria-haspopup="true">
                            <i class="' . $subCat->icon_class . '"></i> ' . $subCat->name . '
                        </a>';
                            if (count($subCat->children)) {
                                $html .= '
                        <div class="bi-icons">
                            <span class="bi bi-chevron-right"></span>
                        </div>';
                            }
                            $html .= '<ul class="menu menu-list mega-menu--multiLevel2 transparent" >';
                            if (count($subCat->children)) {
                                $html .= '
                                <li>
                                    <a style="background-color: transparent!important; color:#369!important;"
                                        href="' . \App\Helpers\UrlGen::category($subCat) . '"
                                        class="menu-link mega-menu-link">
                                        <b><i class="fas fa-th-list"></i> SUB SUB-CATEGORY</b>
                                    </a>
                                </li>';
                            }
                            if (count($subCat->children)) {
                                // Sub Sub Category
                                foreach ($subCat->children as $subSubCatKey => $subSubCat) {
                                    $html .= '<li>';
                                    $html .= '
                                <a style="background-color: transparent!important;"
                                    href="' . \App\Helpers\UrlGen::category($subSubCat) . '"
                                    class="menu-link menu-list-link" aria-haspopup="true">
                                    <i class="' . $subSubCat->icon_class . '"></i> ' . $subSubCat->name . '
                                </a>';
                                    $html .= '</li>';
                                }
                            }
                            $html .= '</ul>';
                            $html .= '</li>';
                        }
                    }
                    $html .= '</ul>';
                    $html .= '</li>';
                }
            }
        }

        // Categories Section
        // $parentCategoriesHtml = '';
        // $parent_categories = Category::where('parent_id', null)->get();
        // if (!empty($parent_categories)) {
        //     $sortedCategories = $parent_categories->sortBy('name');
        //     foreach ($sortedCategories as $cat) {
        //         $parentCategoriesHtml .= '<li class="px-3 py-3 border-bottom">';
        //         $parentCategoriesHtml .= '<a href="' . \App\Helpers\UrlGen::category($cat) . '">';
        //         $parentCategoriesHtml .= data_get($cat, 'name');
        //         $parentCategoriesHtml .= '</a></li>';
        //     }
        // }

        $data = [
            'all_categories' => $html,
            // 'parentCategoriesHtml' => $parentCategoriesHtml,
        ];
        return $data;
    }

    // PROVINCE / STATE
    public function getProvinces(Request $request)
    {
        $options = [];
        $loggedInSelectedID = '';

        if ($request->postId) {
            $createProvinceAuth = Post::where('id', $request->postId)->first();
            $countryCode = $createProvinceAuth->country_code;
            if ($request->requestFrom && $request->requestFrom == 'general') {
                $countryCode = $request->code;
            }
            if ($createProvinceAuth->province_id) {
                $loggedInSelectedID = $createProvinceAuth->province_id;
            }
        } else {
            if (Auth::check()) {
                $createProvinceAuth = Auth::user()->UserDetail;
                $countryCode = $createProvinceAuth->country_code;
                if ($request->requestFrom && $request->requestFrom == 'general') {
                    $countryCode = $request->code;
                }
                if ($createProvinceAuth->province_id) {
                    $loggedInSelectedID = $createProvinceAuth->province_id;
                }
            } else {
                $countryCode = $request->code;
            }
        }

        $province = Region::where('code', $countryCode)->first();

        if ($province != null) {
            $sortedChilds = $province->childs->sortBy('name'); // Sort the provinces by name
            $options[] = ['value' => '', 'text' => 'Select Provinces / State', 'selected' => false];
            foreach ($sortedChilds as $key => $value) {
                $selected = false;
                if ($loggedInSelectedID && $value->id === (int)$loggedInSelectedID) {
                    $selected = true;
                }
                $options[] = ['value' => $value->id, 'text' => $value->name, 'selected' => $selected];
            }
        }

        if ($request->is('api/*')) {
            return response()->json($options);
        } else {
            $selectOptions = '';
            foreach ($options as $option) {
                $selectOptions .= '<option value="' . $option['value'] . '" ' . ($option['selected'] ? 'selected' : '') . '>' . $option['text'] . '</option>';
            }
            return $selectOptions;
        }
    }
    // REGION
    public function getRegions(Request $request)
    {
        $options = [];
        $loggedInSelectedID = '';

        if ($request->postId) {
            $createProvinceAuth = Post::where('id', $request->postId)->first();
            $getByID = $createProvinceAuth->province_id;
            if ($request->requestFrom && in_array($request->requestFrom, ['general', 'post'])) {
                $getByID = $request->id;
            }
            if ($createProvinceAuth->region_id) {
                $loggedInSelectedID = $createProvinceAuth->region_id;
            }
        } else {
            if (Auth::check()) {
                $createProvinceAuth = Auth::user()->UserDetail;
                $getByID = $createProvinceAuth->province_id;
                if ($request->requestFrom && in_array($request->requestFrom, ['general', 'post'])) {
                    $getByID = $request->id;
                }
                if ($createProvinceAuth->region_id) {
                    $loggedInSelectedID = $createProvinceAuth->region_id;
                }
            } else {
                $getByID = $request->id;
            }
        }

        $regions = Region::where('id', $getByID)->first();

        if ($regions != null) {
            $options[] = ['value' => '', 'text' => 'Select Region', 'selected' => false];
            foreach ($regions->childs as $key => $value) {
                $selected = false;
                if ($loggedInSelectedID && $value->id === (int)$loggedInSelectedID) {
                    $selected = true;
                }
                $options[] = ['value' => $value->id, 'text' => $value->name, 'selected' => $selected];
            }
        }

        if ($request->is('api/*')) {
            return response()->json($options);
        } else {
            // For web routes, return the HTML select options
            $selectOptions = '';
            foreach ($options as $option) {
                $selectOptions .= '<option value="' . $option['value'] . '" ' . ($option['selected'] ? 'selected' : '') . '>' . $option['text'] . '</option>';
            }
            return $selectOptions;
        }
    }
    // CITY
    public function getCities(Request $request)
    {
        $options = [];
        $loggedInSelectedID = '';

        if ($request->postId) {
            $createProvinceAuth = Post::where('id', $request->postId)->first();
            $getByID = $createProvinceAuth->region_id;
            if ($request->requestFrom && in_array($request->requestFrom, ['general', 'post'])) {
                $getByID = $request->id;
            }
            if ($createProvinceAuth->new_city_id) {
                $loggedInSelectedID = $createProvinceAuth->new_city_id;
            }
        } else {
            if (Auth::check()) {
                $createProvinceAuth = Auth::user()->UserDetail;
                $getByID = $createProvinceAuth->region_id;
                if ($request->requestFrom && in_array($request->requestFrom, ['general', 'post'])) {
                    $getByID = $request->id;
                }
                if ($createProvinceAuth->new_city_id) {
                    $loggedInSelectedID = $createProvinceAuth->new_city_id;
                }
            } else {
                $getByID = $request->id;
            }
        }

        $cities = Region::where('id', $getByID)->first();

        if ($cities != null) {
            $options[] = ['value' => '', 'text' => 'Select City', 'selected' => false];
            foreach ($cities->childs as $key => $value) {
                $selected = false;
                if ($loggedInSelectedID && $value->id === (int)$loggedInSelectedID) {
                    $selected = true;
                }
                $options[] = ['value' => $value->id, 'text' => $value->name, 'selected' => $selected];
            }
        }

        if ($request->is('api/*')) {
            return response()->json($options);
        } else {
            // For web routes, return the HTML select options
            $selectOptions = '';
            foreach ($options as $option) {
                $selectOptions .= '<option value="' . $option['value'] . '" ' . ($option['selected'] ? 'selected' : '') . '>' . $option['text'] . '</option>';
            }
            return $selectOptions;
        }
    }

    // NEIGHBOURS
    public function getNeighbours(Request $request)
    {
        $options = [];
        $loggedInSelectedID = '';

        if ($request->postId) {
            $createProvinceAuth = Post::where('id', $request->postId)->first();
            $getByID = $createProvinceAuth->new_city_id;
            if ($request->requestFrom && in_array($request->requestFrom, ['general', 'post'])) {
                $getByID = $request->id;
            }
            if ($createProvinceAuth->neighbour_id) {
                $loggedInSelectedID = $createProvinceAuth->neighbour_id;
            }
        } else {
            if (Auth::check()) {
                $createProvinceAuth = Auth::user()->UserDetail;
                $getByID = $createProvinceAuth->new_city_id;
                if ($request->requestFrom && in_array($request->requestFrom, ['general', 'post'])) {
                    $getByID = $request->id;
                }
                if ($createProvinceAuth->neighbour_id) {
                    $loggedInSelectedID = $createProvinceAuth->neighbour_id;
                }
            } else {
                $getByID = $request->id;
            }
        }

        $neighbours = Region::where('id', $getByID)->first();

        if ($neighbours != null) {
            $options[] = ['value' => '', 'text' => 'Select Neighbour', 'selected' => false];
            foreach ($neighbours->childs as $key => $value) {
                $selected = false;
                if ($loggedInSelectedID && $value->id === (int)$loggedInSelectedID) {
                    $selected = true;
                }
                $options[] = ['value' => $value->id, 'text' => $value->name, 'selected' => $selected];
            }
        }

        if ($request->is('api/*')) {
            return response()->json($options);
        } else {
            // For web routes, return the HTML select options
            $selectOptions = '';
            foreach ($options as $option) {
                $selectOptions .= '<option value="' . $option['value'] . '" ' . ($option['selected'] ? 'selected' : '') . '>' . $option['text'] . '</option>';
            }
            return $selectOptions;
        }
    }
    // SESSION SAVE LOCATION
    public function saveLocation(Request $request)
    {
        // COUNTRY
        if ($request->country === 'LP') {
            $request->session()->forget('country');
            $request->session()->forget('province');
            $request->session()->forget('region');
            $request->session()->forget('city');
            $request->session()->forget('neighbour');
        } elseif ($request->country) {
            // $country = Country::where('code', $request->country)->first();
            $country = Region::where('code', $request->country)->first();
            session(['country' =>  $country]);
        } else {
            $request->session()->forget('country');
        }
        // PROVINCE / STATE
        if ($request->province) {
            $province = Region::find($request->province);
            session(['province' =>  $province]);
        } else {
            $request->session()->forget('province');
        }
        // REION
        if ($request->region) {
            $region = Region::find($request->region);
            session(['region' =>  $region]);
        } else {
            $request->session()->forget('region');
        }
        // CITY
        if ($request->city) {
            $city = Region::find($request->city);
            session(['city' =>  $city]);
        } else {
            $request->session()->forget('city');
        }
        // NEIGHBOUR
        if ($request->neighbour) {
            $neighbour = Region::find($request->neighbour);
            session(['neighbour' =>  $neighbour]);
        } else {
            $request->session()->forget('neighbour');
        }
        return response()->json([
            'success' => true,
            'message' => 'Location saved successfully.'
        ]);
    }

    // CLEAR SESSION
    public function clearSection(Request $request)
    {
        $request->session()->forget('country');
        $request->session()->forget('province');
        $request->session()->forget('region');
        $request->session()->forget('city');
        $request->session()->forget('neighbour');
        // return back();
        return redirect()->away(url('/?country=LP'));
    }

    // CLEAR SESSION
    public function clearSectionSearch(Request $request)
    {
        $request->session()->forget('country');
        $request->session()->forget('province');
        $request->session()->forget('region');
        $request->session()->forget('city');
        $request->session()->forget('neighbour');
        // return back();
        return redirect()->away(url('/lp/search'));
    }

    // CLEAR SESSION
    // public function clearSection(Request $request)
    // {
    //     // Get the previous URL
    //     $previousUrl = url()->previous();

    //     // Parse the URL to get its components
    //     $urlComponents = parse_url($previousUrl);

    //     // Extract the path and split it into segments
    //     $pathSegments = explode('/', $urlComponents['path']);

    //     // Assuming the country code is the first segment
    //     if (isset($pathSegments[1])) {
    //         $pathSegments[1] = 'LP';
    //     }

    //     // Clear the session data
    //     $request->session()->forget('country');
    //     $request->session()->forget('province');
    //     $request->session()->forget('region');
    //     $request->session()->forget('city');
    //     $request->session()->forget('neighbour');

    //     // Rebuild the path
    //     $newPath = implode('/', $pathSegments);

    //     // Redirect to the new URL
    //     if ($previousUrl == url('/') . '/' && $previousUrl != url('/?country=LP')) {
    //         return redirect()->away(url('/?country=LP'));
    //     } elseif ($previousUrl != url('/LP/search')) {
    //         return redirect(url('/') . $newPath);
    //     }

    //     // if ($previousUrl == url('/') . '/') {
    //     //     dd('1', $previousUrl);
    //     //     return redirect()->away(url('/?country=LP'));
    //     // } else {
    //     //     dd('2', $previousUrl);
    //     // }
    //     // dd('3', $previousUrl);
    //     // return redirect(url('/') . $newPath);
    // }

    // SEND MAIL
    public function postSendMail(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'authName' => 'required',
            'authEmail' => 'required|email',
            'email' => 'required|email',
            'message' => 'required',
            'url' => 'required|url',
        ]);

        // Prepare the email details
        $emailDetails = [
            'title' => 'Invitation',
            'body' => $validatedData['message'],
            'fromName' => $validatedData['authName'],
            'from' => $validatedData['authEmail'],
            'url' => $validatedData['url'],
        ];

        // Send the email
        try {
            Mail::to($validatedData['email'])->send(new MyTestMail($emailDetails));

            // Return a success response
            return response()->json(['message' => 'Email sent successfully'], 200);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json(['message' => 'Error sending email'], 400);
        }
    }

    // DELETE USER PROFILE PHOTO
    // public function deleteuserProfilePhoto(Request $request)
    // {
    //     $user_id = Auth::User()->id;
    //     $userdetail = UserDetail::where('user_id', $user_id)->first();
    //     if ($userdetail->profile_photo) {
    //         Storage::delete('public/assets/images/' . $userdetail->profile_photo);
    //         $userdetail->profile_photo = null;
    //         $userdetail->save();
    //     }
    //     return back();
    // }


    public function deleteuserProfilePhoto(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
        $user_id = Auth::User()->id;
        $userdetail = UserDetail::where('user_id', $user_id)->first();
        if ($userdetail->profile_photo) {
            Storage::delete('public/assets/images/' . $userdetail->profile_photo);
            $userdetail->profile_photo = null;
            $userdetail->save();
        }
            return response()->json(['message' => 'image deleted successfullu']);
        // if ($request->is('api/*')) {
        // } else {
        //     return back();
        // }
    }


    // GET SUB CATEORIES (Advance Search) 
    public function getAdvanceSearchCategories(Request $request)
    {
        $search_advance_categories_html = '';
        $Custom_html_empty = 'Custom Extra Data Fetch Empty';
        $search_advance_categories = Category::where('id', $request->catID)->first();
        if ($search_advance_categories->children) {
            foreach ($search_advance_categories->children as $item) {
                $search_advance_categories_html .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            }
        }
        $data_html = [
            'search_advance_categories_html' => $search_advance_categories_html,
            'header_categories_search_html' => $Custom_html_empty
        ];
        return $data_html;
    }

    // GET SUB SUB CATEORIES (Advance Search)
    public function getAdvanceSearchSubCategories(Request $request)
    {
        $search_advance_sub_categories_html = '';
        $Custom_html_empty = 'Custom Extra Data Fetch Empty';
        $search_advance_sub_categories = Category::where('id', $request->subCatID)->first();

        if ($search_advance_sub_categories->children) {
            foreach ($search_advance_sub_categories->children as $item) {
                $search_advance_sub_categories_html .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            }
        }
        $data_html = [
            'search_advance_sub_categories_html' => $search_advance_sub_categories_html,
            'header_categories_search_html' => $Custom_html_empty
        ];
        return $data_html;
    }

    // PROVINCE, REGION, CITY, NEIGHBOUR (Advance Search) 
    public function getAdvanceSearchLocation(Request $request)
    {
        $provinces = '';
        $regions = '';
        $cities = '';
        $neighbours = '';
        // PROVINCE
        $search_provinces = Region::where('code', $request->countryCode)->first();
        if ($search_provinces != null) {
            foreach ($search_provinces->childs as $key => $value) {
                $provinces .= '<option value="' . $value->id . '">' . $value->name . '</option>';
            }
        }
        // REGION
        $search_regions = Region::where('id', $request->provinceID)->first();
        if ($search_regions != null) {
            foreach ($search_regions->childs as $key => $value) {
                $regions .= '<option value="' . $value->id . '">' . $value->name . '</option>';
            }
        }
        // CITY
        $search_cities = Region::where('id', $request->regionID)->first();
        if ($search_cities != null) {
            foreach ($search_cities->childs as $key => $value) {
                $cities .= '<option value="' . $value->id . '">' . $value->name . '</option>';
            }
        }
        // NEIGHBOUR
        $search_neighbours = Region::where('id', $request->cityID)->first();
        if ($search_neighbours != null) {
            foreach ($search_neighbours->childs as $key => $value) {
                $neighbours .= '<option value="' . $value->id . '">' . $value->name . '</option>';
            }
        }
        $data_html = [
            'provinces' => $provinces,
            'regions' => $regions,
            'cities' => $cities,
            'neighbours' => $neighbours,
        ];
        return $data_html;
    }

    public function updateActiveStatus(Request $request)
    {
        $code = $request->input('id');
        $currentValue = $request->input('value');
        $newValue = $currentValue === '1' ? '0' : '1';
        $country = DB::table('countries')
            ->where('code', $code)
            ->first();
        if ($country) {
            DB::table('countries')
                ->where('code', $code)
                ->update(['active' => $newValue]);

            return response()->json([
                'success'    => true,
                'new_value'  => $newValue,
            ]);
        } else {
            return response()->json([
                'success'    => false,
                'message'    => 'Country not found for the provided code.',
            ]);
        }
    }

    public function gettimezone()
    {
        $data = \App\Helpers\Date::getTimeZones();
        return response()->json($data);
    }
}
