<?php
Route::group(['prefix' => 'api', 'after' => 'allowOrigin'], function() {
    Route::pattern('id', '[0-9]+');
    Route::pattern('id2', '[0-9]+');
    
    #Gamify
    #i: GA Categories
    Route::post('gacategories/load', 'Api\CategoriesController@load');
    Route::post('gacategories/proc', 'Api\CategoriesController@proc');
    Route::post('gacategories/getinfo', 'Api\CategoriesController@getinfo');
    Route::post('gacategories/remove', 'Api\CategoriesController@remove');
    
    #i: GA Badges
    Route::post('gabadges/load', 'Api\BadgesController@load');
    Route::post('gabadges/proc', 'Api\BadgesController@proc');
    Route::post('gabadges/getinfo', 'Api\BadgesController@getinfo');
    Route::post('gabadges/remove', 'Api\BadgesController@remove');
    Route::post('gabadges/updatethumb', 'Api\BadgesController@updatethumb');
    Route::post('gabadges/removethumb', 'Api\BadgesController@removethumb');
    Route::post('gabadges/upload', 'Api\BadgesController@upload');
    Route::post('gabadges/getmax', 'Api\BadgesController@getmax');
    
    #i: GA Badge Events
    Route::post('gabadgeevents/proc', 'Api\BadgeEventsController@proc');
    
    #i: GA Events
    Route::post('gaevents/load', 'Api\EventsController@load');
    Route::post('gaevents/proc', 'Api\EventsController@proc');
    Route::post('gaevents/getinfo', 'Api\EventsController@getinfo');
    Route::post('gaevents/remove', 'Api\EventsController@remove');
    
    #i: GA Level Associate
    Route::post('galevelassociate/load', 'Api\LevelAssociateController@load');
    Route::post('galevelassociate/proc', 'Api\LevelAssociateController@proc');
    Route::post('galevelassociate/getinfo', 'Api\LevelAssociateController@getinfo');
    
      #i: GA User Badges
    Route::post('gauserbadges/load', 'Api\UserBadgesController@load');
    Route::post('gauserbadges/proc', 'Api\UserBadgesController@proc');
    Route::post('gauserbadges/getinfo', 'Api\UserBadgesController@getinfo');
    #i: GA Core BLL
    Route::post('gacore/award', 'Api\CoreController@award');
    Route::post('gacore/loaduserlevels', 'Api\CoreController@loaduserlevels');
    Route::post('gacore/loaduserinfo', 'Api\CoreController@loaduserinfo');
    Route::post('gacore/loadachievements', 'Api\CoreController@loadachievements');
    
    
});