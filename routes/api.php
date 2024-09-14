<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




    // Greaz

    // Auth
    Route::post('/login' , 'Api\AuthController@login');
    Route::post('/social-login' , 'Api\AuthController@socialLogin');

    Route::post('/resend-otp' , 'Api\AuthController@resendOTP');
    Route::post('/verify-otp' , 'Api\AuthController@verifyOTP');
    Route::post('/verify-token' , 'Api\AuthController@verifyToken');
    Route::post('/reset-password' , 'Api\AuthController@resetPassword');

    Route::post('/seller-login' , 'Api\AuthController@sellerLogin');

    Route::post('/user-register' , 'Api\AuthController@userRegister');
    Route::post('/check-current-user' , 'Api\AuthController@checkCurrentUser');
    Route::get('/category/list' , 'Api\CategoryController@index');
    Route::get('/category/{id}/get-sub-categories' , 'Api\CategoryController@getSubSategories');
    Route::get('/sub-category/{id}/sub-sub-categories' , 'Api\SubSubController@index');
    Route::get('/makes' , 'Api\MakeController@index');

    // add subscribtion

    Route::post('/subscriptions/all' , 'Api\SubscriptionController@index');
    Route::post('/subscription/store' , 'Api\SubscriptionController@store');
    Route::post('/subscription/{id}/update' , 'Api\SubscriptionController@update');
    Route::post('/subscription/{id}/delete' , 'Api\SubscriptionController@destroy');




    Route::get('/mobile/{slug}' , 'Api\PagesController@getSinglePage');
    Route::get('/reportListing/{id}' , 'Api\PagesController@reportListing');

    Route::group( ['middleware' => ['auth:api']] , function () {

        Route::post('/fcm-token/{type}' , 'Api\AuthController@FCMToken');


        Route::get('/sellers/list' , 'Api\SellerController@sellersList');
        Route::get('/seller/{id}/show' , 'Api\SellerController@showSeller');
        Route::get('/seller/{id}/brands' , 'Api\SellerController@showSellerBrands');
        Route::get('/seller/{id}/categories' , 'Api\SellerController@showSellerCategories');



        Route::get('/get-searches' , 'Api\SearchQueryController@index');


        // car routes
        Route::get('/all-user-cars' , 'Api\CarController@index');
        Route::post('/register-car' , 'Api\CarController@register');
        Route::post('/update-car/{id}' , 'Api\CarController@update');
        Route::delete('/delete-car/{id}' , 'Api\CarController@destroy');


        // Show All categories main page
        // Route::get('/category/list' , 'Api\CategoryController@index');
        // Route::get('/category/{id}/get-sub-categories' , 'Api\CategoryController@getSubSategories');
        // Route::get('/sub-category/{id}/sub-sub-categories' , 'Api\SubSubController@index');

        // Makes
        Route::get('/genres' , 'Api\GenreController@index');
        // Route::get('/makes' , 'Api\MakeController@index');
        Route::get('/make/{make_id}/models' , 'Api\ModelController@index');
        Route::get('/model/{model_id}/variants' , 'Api\VariantController@index');
        Route::get('/transmissions' , 'Api\TransmissionController@index');


        //
        Route::get('/display/blocks' , 'Api\BlockController@index');
        Route::get('/blocks/{id}/listings' , 'Api\BlockController@blockListings');

        // Listings
        Route::get('/featured-listings/{slug?}' , 'Api\ListingController@getFeaturedListings');
        Route::get('/relevent-listings/{id?}' , 'Api\ListingController@getReleventListing');

         // Relevent Category Listings
        Route::get('/category-car-listing' , 'Api\ListingController@getReleventListing');

        Route::get('/relevent-listings/category/{cat_id}/{id?}' , 'Api\ListingController@getReleventCategoryListing');
        Route::get('/listing/{id}/view' , 'Api\ListingController@show');

        // Search Listings
        Route::get('/search-listings' , 'Api\ListingController@searchListings');



        // Reviews
        Route::post('/review/store' , 'Api\ReviewController@store');
        Route::get('/get-listing-reviews/{listing_id}' , 'Api\ListingController@getListingReviews');
        Route::get('/seller/{user_id}/reviews' , 'Api\ListingController@getSellerReviews');

        Route::get('/seller/{seller_id}/listings' , 'Api\ListingController@getSellerListings');



        // Get all notifications
        Route::get('/get-all-notifications' , 'Api\PushNotificationController@index');




        // Logout
        Route::post('/logout' , 'Api\AuthController@logout');
    });
















    Route::post('/search-listings' , 'Api\ListingController@searchListings');
    Route::post('/listings' , 'Api\ListingController@index');
    Route::post('/seller-listings/{id}' , 'Api\ListingController@sellerListings');
    Route::post('listing-images' , 'Api\ListingController@uploadImages' );
    Route::post('delete-listing-image' , 'Api\ListingController@deleteImages' );
    Route::post('/listing/store' , 'Api\ListingController@store');
    Route::post('/listing/{id}/show' , 'Api\ListingController@show');
    Route::post('/listing/{id}/images' , 'Api\ListingController@getListingImages');
    Route::post('/listing/{id}/update' , 'Api\ListingController@update');
    Route::post('/listing/{id}/delete' , 'Api\ListingController@destroy');
    Route::post('/update-listing-status' , 'Api\ListingController@updateListingStatus');


// categories

Route::post('/filters-data' , 'Api\FilterController@index');
Route::post('/search-filters' , 'Api\FilterController@searchFilters');

Route::post('/admin-stats' , 'Api\AdminController@adminStats');
Route::post('/update-admin-password' , 'Api\AdminController@updatePassword');
Route::post('/update-admin-profile' , 'Api\AdminController@ProfileUpdate');
Route::post('/update-logo' , 'Api\AdminController@updateLogo');

Route::post('/pages/all' , 'Api\PagesController@index');
Route::post('/get-page' , 'Api\PagesController@getPage');

Route::post('/pages/{id}/update' , 'Api\PagesController@update');


Route::post('/category/all-details' , 'Api\CategoryController@allDetails');

Route::post('/admins/all' , 'Api\AdminController@index');
Route::post('/admin/store' , 'Api\AdminController@store');
Route::post('/admin/{id}/update' , 'Api\AdminController@update');
Route::post('/admin/{id}/delete' , 'Api\AdminController@destroy');

Route::post('/roles/all' , 'Api\RoleController@index');
Route::post('/role/store' , 'Api\RoleController@store');
Route::post('/role/{id}/update' , 'Api\RoleController@update');
Route::post('/role/{id}/delete' , 'Api\RoleController@destroy');

Route::get('/seed-permissions' , 'Api\PermissionController@seedPermissions');
Route::post('/permissions/all' , 'Api\PermissionController@index');
Route::post('/permission/store' , 'Api\PermissionController@store');
Route::post('/permission/{id}/delete' , 'Api\PermissionController@destroy');


Route::post('/category/store' , 'Api\CategoryController@store');
Route::post('/category/{id}/update' , 'Api\CategoryController@update');
Route::post('/category/{id}/delete' , 'Api\CategoryController@destroy');
Route::get('/category/arabic-translate' , 'Api\CategoryController@arabicTitle');



Route::post('/genres/all' , 'Api\GenreController@index');
Route::post('/genre/store' , 'Api\GenreController@store');
Route::post('/genre/{id}/update' , 'Api\GenreController@update');
Route::post('/genre/{id}/delete' , 'Api\GenreController@destroy');



Route::post('/transmissions/all' , 'Api\TransmissionController@index');
Route::post('/transmission/store' , 'Api\TransmissionController@store');
Route::post('/transmission/{id}/update' , 'Api\TransmissionController@update');
Route::post('/transmission/{id}/delete' , 'Api\TransmissionController@destroy');



Route::post('/category/all' , 'Api\CategoryController@index');



Route::post('/category/{id}/sub-categories' , 'Api\CategoryController@getSubSategories');
Route::post('/category/{id}/features' , 'Api\CategoryController@getFeatures');


Route::post('/sub-category/store' , 'Api\SubCategoryController@store');
Route::post('/sub-category/{id}/update' , 'Api\SubCategoryController@update');
Route::post('/sub-category/{id}/delete' , 'Api\SubCategoryController@destroy');



Route::post('/sub-category/{id}/sub-sub-categories' , 'Api\SubSubController@index');
Route::post('/sub-category/{id}/sub-categories' , 'Api\SubSubController@getFeatures');
Route::post('/sub-sub-category/store' , 'Api\SubSubController@store');
Route::post('/sub-sub-category/{id}/update' , 'Api\SubSubController@update');
Route::post('/sub-sub-category/{id}/delete' , 'Api\SubSubController@destroy');




Route::post('/feature/store' , 'Api\FeatureController@store');
Route::post('/feature/{id}/update' , 'Api\FeatureController@update');
Route::post('/feature/{id}/delete' , 'Api\FeatureController@destroy');
Route::get('/feature/arabic-translate' , 'Api\FeatureController@arabicTitle');


Route::post('/utilities/all' , 'Api\UtilityController@index');
Route::post('/utility/store' , 'Api\UtilityController@store');
Route::post('/utility/{id}/update' , 'Api\UtilityController@update');
Route::post('/utility/{id}/delete' , 'Api\UtilityController@destroy');
Route::get('/utility/arabic-translate' , 'Api\UtilityController@arabicTitle');

Route::post('/utility/{id}/items' , 'Api\UtilityController@getUtilityItems');

Route::post('/item/store' , 'Api\ItemController@store');
Route::post('/item/{id}/update' , 'Api\ItemController@update');
Route::post('/item/{id}/delete' , 'Api\ItemController@destroy');
Route::get('/item/arabic-translate' , 'Api\ItemController@arabicTitle');




Route::post('/makes' , 'Api\MakeController@index');
Route::post('/make/store' , 'Api\MakeController@store');
Route::post('/make/{id}/update' , 'Api\MakeController@update');
Route::post('/make/{id}/delete' , 'Api\MakeController@destroy');
Route::post('/make/excel-import' , 'Api\MakeController@excelImport');
Route::get('/makes/arabic-translate' , 'Api\MakeController@arabicTitle');


Route::post('/make/{make_id}/models' , 'Api\ModelController@index');
Route::post('/model/store' , 'Api\ModelController@store');
Route::post('/model/{id}/update' , 'Api\ModelController@update');
Route::post('/model/{id}/delete' , 'Api\ModelController@destroy');
Route::post('/model/excel-import' , 'Api\ModelController@excelImport');
Route::get('/models/arabic-translate' , 'Api\ModelController@arabicTitle');


Route::post('/model/{model_id}/variants' , 'Api\VariantController@index');
Route::post('/variant/store' , 'Api\VariantController@store');
Route::post('/variant/{id}/update' , 'Api\VariantController@update');
Route::post('/variant/{id}/delete' , 'Api\VariantController@destroy');
Route::get('/variant/arabic-translate' , 'Api\VariantController@arabicTitle');




Route::post('/seller-stats' , 'Api\SellerController@stats');

Route::post('/get-all-listings' , 'Api\ListingController@allLostings');

Route::post('/listing_details' , 'Api\ListingController@getListingDetails');



Route::post('/listing/like' , 'Api\ListingController@likeListing');



Route::get('/get-sellers-list' , 'Api\SellerController@getSellerList');
Route::post('/get-sellers' , 'Api\SellerController@getAllSellers');
Route::post('/specific-sellers' , 'Api\SellerController@getSpecificSellers');
Route::post('/search-sellers' , 'Api\SellerController@searchSellers');
Route::post('/create-seller' , 'Api\SellerController@store');
Route::post('/update-seller/{id?}' , 'Api\SellerController@userSellerUpdate');



Route::post('/user/{id}/delete' , 'Api\UserController@destroy');
Route::post('/all-users' , 'Api\UserController@index');
Route::post('/create-user' , 'Api\UserController@store');
Route::post('/update-user/{id}' , 'Api\UserController@update');
Route::post('/search-users' , 'Api\UserController@search');

Route::post('/seller/{id}/delete' , 'Api\SellerController@destroy');
Route::post('/update-seller-status' , 'Api\SellerController@updateSellerStatus');

Route::get('/download-seller-file/{file}' , 'Api\SellerController@downloadSellerFile');



Route::post('/profile' , 'Api\SellerController@getProfile');
Route::post('/user-update' , 'Api\SellerController@userUpdate');
Route::post('/seller-update' , 'Api\SellerController@userSellerUpdate');



Route::post('/reviews/all' , 'Api\ReviewController@index');
Route::post('/review/update-status' , 'Api\ReviewController@updateStatus');
Route::post('/review/{id}/delete' , 'Api\ReviewController@destroy');



Route::post('main/display-blocks/get' , 'Api\BlockController@getAllBlocks');

Route::post('/display-blocks/all' , 'Api\BlockController@index');
Route::post('/display-blocks/get' , 'Api\BlockController@get');
Route::post('/display-blocks/store' , 'Api\BlockController@store');
Route::post('/display-blocks/update-status' , 'Api\BlockController@updateStatus');
Route::post('/display-blocks/{id}/delete' , 'Api\BlockController@destroy');
Route::post('/display-blocks/{id}/update' , 'Api\BlockController@update');
Route::post('/listing-block-update' , 'Api\BlockController@listingBlockUpdate');
Route::post('/blocks/update-sort-index' , 'Api\BlockController@updateSortIndex');
Route::get('/blocks/arabic-translate' , 'Api\BlockController@arabicTitle');




Route::post('/mobile/{slug}' , 'Api\PagesController@updatePage');
Route::post('/mobile/multiple/{slug}/{action}/{image?}' , 'Api\PagesController@updateMultiPage');

Route::post('/page-data' , 'Api\PagesController@show');
Route::post('/update-contact-details' , 'Api\PagesController@updateContactDetails');
Route::post('/update-terms-details' , 'Api\PagesController@updateTermsDetails');



Route::post('/main/category-listings' , 'Api\ListingController@categoryListings');
Route::post('/main/listing-category' , 'Api\ListingController@listingsCategories');


Route::post('/main/send-query' , 'Api\QueryController@store');
Route::post('/get/all-queries' , 'Api\QueryController@index');
Route::post('/query/update-status' , 'Api\QueryController@updateStatus');
Route::post('/query/{id}/delete' , 'Api\QueryController@destroy');
Route::post('/query/{id}/delete' , 'Api\QueryController@destroy');




Route::post('/reports/all' , 'Api\ReportController@index');
Route::post('/main/report/store' , 'Api\ReportController@store');
Route::post('/report/update-status' , 'Api\ReportController@updateStatus');
Route::post('/report/{id}/delete' , 'Api\ReportController@destroy');



Route::get('/push-notifications' , 'Api\PushNotificationController@index');
Route::post('/push-notification/create' , 'Api\PushNotificationController@store');
Route::post('/push-notification/resend' , 'Api\PushNotificationController@resend');



Route::post('/banner/all' , 'Api\BannerController@index');
Route::post('/banner/store' , 'Api\BannerController@store');
Route::post('/banner/delete' , 'Api\BannerController@destroy');


