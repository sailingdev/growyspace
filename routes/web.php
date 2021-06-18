<?php

if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    //error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear_cache', function () {

    \Artisan::call('schedule:run');

    dd("Cache is cleared");

});
Route::get('/', 'HomeController@index');
Route::get('/category/{name}/{id}.htm', 'CategoryController@index');
Route::get('/send_remind_new_message_emails', 'MessageController@send_remind_new_message_emails');


Route::get('/cars', 'CategoryController@cars');
Route::get('/tires', 'CategoryController@tires');
Route::get('/cars/{name}/{id}.htm', 'CategoryController@view_car');
Route::get('/tires/{name}/{id}.htm', 'CategoryController@view_tire');

Route::get('/advanced_search', 'CategoryController@advanced_search');
Route::get('/return_coupon', 'PdfController@return_coupon');


Route::get('/product/{title}/{id}.htm', 'ProductController@index');
Route::get('/search', 'SearchController@index');
Route::get('/findmatch/{id?}', 'SearchController@findmatch');
Route::get('/messages/{id?}', 'MessageController@index');

Route::get('/cards/{id}', 'Opportunity_cardController@get');
Route::get('/cards', 'Opportunity_cardController@create');
Route::get('/cards/{id}/edit', 'Opportunity_cardController@update');
Route::get('/cards/{id}/refer', 'Opportunity_cardController@referCreate');

Route::get('/carts', 'CheckoutController@carts');
Route::get('/checkout', 'CheckoutController@checkout');

//Page
Route::get('/page/{title}/{id}.htm', 'PageController@index');
Route::post('/contact_us', 'PageController@contact_us_post');

//open-to-work

Route::get('/opentowork/{id}', 'OpentoworkController@get');
Route::get('/opentowork', 'OpentoworkController@create');
Route::get('/opentowork/{id}/edit', 'OpentoworkController@update');
Route::get('/opentowork/{id}/refer', 'OpentoworkController@referCreate');
//User

Route::post('/user/registration', 'UserController@registration_post');
Route::post('/user/loggin', 'UserController@login_post');
Route::get('/user/logout', 'UserController@logout');
Route::post('/user/change_password', 'UserController@change_password_post');
Route::post('/user/change_contact_info', 'UserController@change_contact_info_post');
Route::get('/user/register', 'UserController@register');
Route::get('/user/login', 'UserController@login');
Route::get('/email_test', 'UserController@email_test');





Route::get('/user/my_account', 'UserController@my_account');
Route::get('/user/my_account/settings', 'UserController@settings');
Route::get('user/my_account/change_password', 'UserController@change_password');
Route::get('user/my_account/change_contact_info', 'UserController@change_contact_info');
Route::get('user/my_account/orders', 'UserController@orders');
Route::get('user/my_account/orders/{id}/view', 'UserController@view_order');
Route::get('/user/my_account/edit', 'UserController@my_account');

Route::get('user/my-collection', 'CollectionController@index');
Route::get('user/collection/', 'CollectionController@create');
Route::get('user/collection/{id}', 'CollectionController@update');
Route::get('collections/{id}', 'CollectionController@get');

Route::get('user/{id}/view', 'UserController@view_user');
Route::get('user/{id}/unsubscribe', 'UserController@unsubscribe');
Route::get('/user/{id}/edit', 'UserController@updateAccount');
Route::get('/user/recover_password/{token}', 'UserController@recover_password');
Route::get('/user/activate_account/{token}/{email}', 'UserController@activate_account');
Route::post('/user/recover_password_post/{token}', 'UserController@recover_password_post');


Route::post('/ajax/dynamic_mark_model_motorization_power' ,'AjaxController@dynamic_mark_model_motorization_power');
Route::post('/ajax/add_to_cart' ,'AjaxController@add_to_cart');
Route::post('/ajax/update_cart' ,'AjaxController@update_cart');
Route::post('/ajax/update_shipping_method' ,'AjaxController@update_shipping_method');
Route::post('/ajax/update_cart_aditional_text' ,'AjaxController@update_cart_aditional_text');
Route::post('/ajax/apply_coupon' ,'AjaxController@apply_coupon');
Route::post('/ajax/remove_cart_coupon' ,'AjaxController@remove_cart_coupon');
Route::post('/ajax/update_cart_row_ref' ,'AjaxController@update_cart_row_ref');
Route::post('/ajax/complete_cash_order' ,'AjaxController@complete_cash_order');
Route::post('/ajax/get_colissimo_widget' ,'AjaxController@get_colissimo_widget');
Route::post('/ajax/forgot_password_request' ,'AjaxController@forgot_password_request');
Route::post('/ajax/update_colissimo_address' ,'AjaxController@update_colissimo_address');
Route::post('/ajax/add_edit_opportunity_card' ,'AjaxController@add_edit_opportunity_card');
Route::post('/ajax/get_opc_data' ,'AjaxController@get_opc_data');
Route::post('/ajax/delete_opc' ,'AjaxController@delete_opc');
Route::post('/ajax/delete_opentowork' ,'AjaxController@delete_opentowork');
Route::post('/ajax/get_opc_all_fields' ,'AjaxController@get_opc_all_fields');
Route::post('/ajax/manage_skills' ,'AjaxController@manage_skills');
Route::post('/ajax/update_skills' ,'AjaxController@update_skills');
Route::post('/ajax/add_edit_education' ,'AjaxController@add_edit_education');
Route::post('/ajax/get_edu_data' ,'AjaxController@get_edu_data');
Route::post('/ajax/delete_edu' ,'AjaxController@delete_edu');
Route::post('/ajax/delete_user_skill' ,'AjaxController@delete_user_skill');
Route::post('/ajax/add_edit_experience' ,'AjaxController@add_edit_experience');
Route::post('/ajax/update_profile' ,'AjaxController@update_profile');
Route::post('/ajax/get_experience_data' ,'AjaxController@get_experience_data');
Route::post('/ajax/delete_experience' ,'AjaxController@delete_experience');
Route::post('/ajax/update_profession' ,'AjaxController@update_profession');
Route::post('/ajax/get_user_data' ,'AjaxController@get_user_data');
Route::post('/ajax/add_to_my_collection' ,'AjaxController@add_to_my_collection');
Route::post('/ajax/delete_my_individual_collection' ,'AjaxController@delete_my_individual_collection');
Route::post('/ajax/add_to_my_opportunity_collection' ,'AjaxController@add_to_my_opportunity_collection');
Route::post('/ajax/add_to_my_opentowork_collection' ,'AjaxController@add_to_my_opentowork_collection');
Route::post('/ajax/add_to_my_user_collection' ,'AjaxController@add_to_my_user_collection');
Route::post('/ajax/add_collection' ,'AjaxController@add_collection');
Route::post('/ajax/delete_collection' ,'AjaxController@delete_collection');
Route::post('/ajax/get_collection_items' ,'AjaxController@get_collection_items');
Route::post('/ajax/update_availability' ,'AjaxController@update_availability');
Route::post('/ajax/search_user' ,'AjaxController@search_user');
Route::post('/ajax/send_message' ,'AjaxController@send_message');
Route::post('/ajax/load_messages' ,'AjaxController@load_messages');
Route::post('/ajax/update_my_pitch' ,'AjaxController@update_my_pitch');
Route::post('/ajax/upload_profile_image' ,'AjaxController@upload_profile_image');
Route::post('/ajax/save_croped_image' ,'AjaxController@save_croped_image');
Route::post('/ajax/get_unread_mesages_info' ,'AjaxController@get_unread_mesages_info');
Route::post('/ajax/get_user_collections' ,'AjaxController@get_user_collections');
Route::post('/ajax/get_opc_collections' ,'AjaxController@get_opc_collections');
Route::get('/ajax/get_opc_collection_list/{opc_id}' ,'AjaxController@get_opc_collection_list');
Route::get('/ajax/get_opentowork_collection_list/{opc_id}' ,'AjaxController@get_opentowork_collection_list');
Route::get('/ajax/get_user_collection_list/{id}' ,'AjaxController@get_user_collection_list');
Route::get('/ajax/get_endorse_list/{opc_id}/{skill}' ,'AjaxController@get_endorse_list');
Route::post('/ajax/hide_account' ,'AjaxController@hide_account');
Route::post('/ajax/hide_opentowork' ,'AjaxController@hide_opentowork');
Route::post('/ajax/delete_account' ,'AjaxController@delete_account');
Route::post('/ajax/activeNotificationEmail' ,'AjaxController@activeNotificationEmail');
Route::post('/ajax/add_edit_opentowork_card' ,'AjaxController@add_edit_opentowork_card');
Route::post('/ajax/endorse_opentowork' ,'AjaxController@endorse_opentowork');
Route::post('/ajax/send_reminder' ,'AjaxController@send_reminder');
Route::post('/ajax/findmatchResult' ,'AjaxController@findmatchResult');
Route::post('/ajax/Send_to_all_matches' ,'AjaxController@Send_to_all_matches');
Route::post('/ajax/export_PDF' ,'AjaxController@export_PDF');
Route::get('/about' ,'InfoController@about');
Route::get('/contact' ,'InfoController@contact');
Route::get('/terms' ,'InfoController@terms');
Route::get('/privacy' ,'InfoController@privacy');
Route::get('/oportunity_guide' ,'InfoController@oportunity_guide');
Route::get('/opentowork_guide' ,'InfoController@opentowork_guide');
Route::get('/news' ,'NewsController@index');
Route::get('/news/{id}' ,'NewsController@get');



Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
Route::get('/callback/{provider}', 'SocialController@callback');
Route::post('/ajax/upload_attachment' ,'AjaxController@upload_attachment');
Route::get('/download/{file}' ,'AjaxController@download_attachment');
Route::get('/exportOPW/{id}' ,'AjaxController@exportOPW');
Route::get('/exportOPP/{id}' ,'AjaxController@exportOPP');

Route::prefix('growyspace-admin')->group(function() {

  //------------ ADMIN LOGIN SECTION ------------

  Route::get('/login', 'Admin\LoginController@showLoginForm')->name('admin.login');
  Route::get('/logout', 'Admin\LoginController@logout');
  Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
  Route::resource('/tires', 'Admin\TireController');
  Route::resource('/pages', 'Admin\PageController');
  Route::resource('/opportunity_cards', 'Admin\Opportunity_cardController');
  Route::resource('/opentowork_cards', 'Admin\Opentowork_cardController');
  Route::resource('/news', 'Admin\newsController');

  Route::post('ckeditor/upload', 'Admin\newsController@upload')->name('ckeditor.upload');

  Route::resource('/clients','Admin\ClientController'); 
  Route::post('/activate_client/{id}','Admin\ClientController@activate_client');
  Route::get('/settings','Admin\SettingController@index');
  
  Route::resource('/users', 'Admin\UserController');

  Route::post('/ajax/add_edit_mark_model' ,'Admin\AjaxController@add_edit_mark_model');
  Route::post('/ajax/dynamic_mark_model_motorization_power' ,'Admin\AjaxController@dynamic_mark_model_motorization_power');
  Route::get('/ajax/get_opportunity_cards' ,'Admin\AjaxController@get_opportunity_cards');
  Route::post('/ajax/get_opportunity_cards' ,'Admin\AjaxController@get_opportunity_cards');

  Route::get('/ajax/get_opentowork_cards' ,'Admin\AjaxController@get_opentowork_cards');
  Route::post('/ajax/get_opentowork_cards' ,'Admin\AjaxController@get_opentowork_cards');
  Route::post('/ajax/upgrade_user_license' ,'Admin\AjaxController@upgrade_user_license');
  Route::post('/ajax/upgrade_user_matchmaking' ,'Admin\AjaxController@upgrade_user_matchmaking');

  Route::post('/ajax/get_tires' ,'Admin\AjaxController@get_tires');
  Route::get('/ajax/get_tires' ,'Admin\AjaxController@get_tires');

  Route::get('/ajax/get_product_groups' ,'Admin\AjaxController@get_product_groups');
  Route::post('/ajax/get_product_groups' ,'Admin\AjaxController@get_product_groups');
  Route::post('/ajax/get_product_group_data' ,'Admin\AjaxController@get_product_group_data');
  Route::post('/ajax/get_mark_model_tree' ,'Admin\AjaxController@get_mark_model_tree');
  Route::post('/ajax/add_motorization' ,'Admin\AjaxController@add_motorization');
  Route::post('/ajax/delete_motorization' ,'Admin\AjaxController@delete_motorization');
  Route::post('/ajax/add_power' ,'Admin\AjaxController@add_power');
  Route::post('/ajax/delete_power' ,'Admin\AjaxController@delete_power');
  Route::post('/ajax/generate_excel_products' ,'Admin\AjaxController@generate_excel_products');
  Route::post('/ajax/get_user_coupons' ,'Admin\AjaxController@get_user_coupons');
  Route::post('/ajax/save_user_coupons' ,'Admin\AjaxController@save_user_coupons');
  Route::post('/ajax/update_ref' ,'Admin\AjaxController@update_ref');
  Route::post('/ajax/add_facture_item' ,'Admin\AjaxController@add_facture_item');
  Route::post('/ajax/delete_factura_item' ,'Admin\AjaxController@delete_factura_item');
  Route::post('/ajax/update_facture' ,'Admin\AjaxController@update_facture');
  Route::post('/ajax/send_chat_opentowork_holder' ,'Admin\AjaxController@send_chat_opentowork_holder');
  Route::post('/ajax/revertUnsubscribe' ,'Admin\AjaxController@revertUnsubscribe');

  Route::post('/login', 'Admin\LoginController@login')->name('admin.login.submit');

});