<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/********************* Authentication *********************/
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);


/************************ 404 Page ************************/
Route::get('404',
    function ()
    {
        return view('errors.404');
    });

/************************ 500 Page ************************/
Route::get('500',
    function ()
    {
        return view('errors.500');
    });


/******************* View All User Call *******************/
Route::get('/returnAllUser', 'HomeController@returnAllUser')->name('returnAllUser');


/************************** Home **************************/
Route::get('/', 'HomeController@index')->name('home');
Route::get('home', 'HomeController@index')->name('home');


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|----------------------------------------
| Leader Board
|----------------------------------------
*/

// get top users
Route::get('leaderboard/topusers/all',
    [
        'uses' => 'LeaderBoardController@getTopUsers',
        'as'   => 'getLeaderBoardTopUsers'
    ]);
// get top users by group type id
Route::get('leaderboard/topusers/{groupTypeId}',
    [
        'uses' => 'LeaderBoardController@getTopUsersByGroupType',
        'as'   => 'getLeaderBoardTopUsersByGroupType'
    ]);

// get top groups
Route::get('leaderboard/topgroups/all',
    [
        'uses' => 'LeaderBoardController@getTopGroups',
        'as'   => 'getLeaderBoardTopGroups'
    ]);

Route::get('leaderboard/topgroups/{groupTypeId}',
    [
        'uses' => 'LeaderBoardController@getTopGroupsByGroupType',
        'as'   => 'getLeaderBoardTopGroupsByGroupType'
    ]);


Route::get('leaderboard', 'LeaderBoardController@leaderBoardPage')->name('leaderBoardPage');


/*
|----------------------------------------
| Groups
|----------------------------------------
*/
// get group create page
Route::get('group/create',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@showCreateGroup',
        'as'         => 'singleGroupCreatePage-show'
    ]);

// Create a group
Route::post('group/create',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@createGroup',
        'as'         => 'singleGroupCreatePage-post'
    ]);

// Group search
Route::get('group/search', 'GroupsController@searchGroupsResult')->name('searchGroup-get');

// get group by group type
Route::get('group/searchbytype/{group_type_id}', 'GroupsController@searchByGroupTypeResult')->name('SearchByGroupsTypeResult-get');

// get all groups
Route::get('group/allgroups', 'GroupsController@showAllGroups')->name('showAllGroups');

// Single Group Page
Route::get('group/{group_id}',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@showGroup',
        'as'         => 'singleGroupPage'
    ]);

// Single Group Pinned Page
Route::get('group/{group_id}/pinned',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@singleGroupPinnedPage',
        'as'         => 'singleGroupPinnedPage'
    ]);

// Single Group Members Page
Route::get('group/{group_id}/members',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@singleGroupMembersPage',
        'as'         => 'singleGroupMembersPage'
    ]);

// Single Group Docking Page
Route::get('group/{group_id}/docking',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@singleGroupDockingPage',
        'as'         => 'singleGroupDockingPage'
    ]);

// Single Group Profile Page
Route::get('group/{group_id}/profile',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@singleGroupProfilePage',
        'as'         => 'singleGroupProfilePage'
    ]);

// Single Group Profile Page modify
Route::PATCH('group/{group_id}/profile/modify',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@modifyGroup',
        'as'         => 'singleGroupProfilePage-modify'
    ]);

// Update Profile route (Patch process).
Route::post('group/{group_id}/profile/avatar/upload',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@uploadGroupAvatar',
        'as'         => 'uploadGroupAvatar'
    ]);


// send join group request
Route::post('group/{group_id}/join',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@joinGroup',
        'as'         => 'joinGroup'
    ]);

// accept join group request
Route::post('group/{group_id}/accept/{user_id}',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@acceptGroupRequest',
        'as'         => 'acceptJoinGroupRequest'
    ]);

// deny join group request
Route::post('group/{group_id}/denied/{user_id}',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@deniedGroupRequest',
        'as'         => 'denyJoinGroupRequest'
    ]);

// remove user
Route::post('group/{group_id}/remove/{user_id}',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@removeUser',
        'as'         => 'removeUser-group'
    ]);

// leave group
Route::post('group/{group_id}/leave',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@leaveGroup',
        'as'         => 'leave-group'
    ]);

// promote user
Route::post('group/{group_id}/promote/{user_id}',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@promoteUser',
        'as'         => 'promoteUser-group'
    ]);

// demote group
Route::post('group/{group_id}/demote/{user_id}',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@demoteUser',
        'as'         => 'demoteUser-group'
    ]);


/*
|----------------------------------------
| Feed and Comment in Group
|----------------------------------------
*/
//post feed in group
Route::post('group/{group_id}/postFeed',
    [
        'middleware' => 'auth',
        'uses'       => 'FeedAndCommentController@postFeed',
        'as'         => 'feed-post'
    ]);

//delete feed in group
Route::delete('group/{group_id}/{feed_id}/delete',
    [
        'middleware' => 'auth',
        'uses'       => 'FeedAndCommentController@deleteFeed',
        'as'         => 'feed-delete'
    ]);

//edit feed in group
Route::patch('group/{group_id}/{feed_id}/edit',
    [
        'middleware' => 'auth',
        'uses'       => 'FeedAndCommentController@editFeed',
        'as'         => 'feed-edit'
    ]);

//post comment in feed
Route::post('group/{group_id}/{feed_id}/postComment',
    [
        'middleware' => 'auth',
        'uses'       => 'FeedAndCommentController@postComment',
        'as'         => 'comment-post'
    ]);

//post childComment in comment
Route::post('group/{group_id}/{feed_id}/comment/{comment_id}/postChildComment',
    [
        'middleware' => 'auth',
        'uses'       => 'FeedAndCommentController@postChildComment',
        'as'         => 'childComment-post'
    ]);

//delete comment in group
Route::delete('group/{group_id}/{feed_id}/comment/{comment_id}/delete',
    [
        'middleware' => 'auth',
        'uses'       => 'FeedAndCommentController@deleteComment',
        'as'         => 'comment-delete'
    ]);

//delete childComment in group
Route::delete('group/{group_id}/{feed_id}/comment/{comment_id}/childComment/{childComment_id}/delete',
    [
        'middleware' => 'auth',
        'uses'       => 'FeedAndCommentController@deleteChildComment',
        'as'         => 'childComment-delete'
    ]);

//edit comment in group
Route::patch('group/{group_id}/{feed_id}/comment/{comment_id}/edit',
    [
        'middleware' => 'auth',
        'uses'       => 'FeedAndCommentController@editComment',
        'as'         => 'comment-edit'
    ]);

//edit childComment in group
Route::patch('group/{group_id}/{feed_id}/comment/{comment_id}/childComment/{childComment_id}/edit',
    [
        'middleware' => 'auth',
        'uses'       => 'FeedAndCommentController@editChildComment',
        'as'         => 'childComment-edit'
    ]);

//pin a feed
Route::post('group/{group_id}/feed/{feed_id}/pin',
    [
        'middleware' => 'auth',
        'uses'       => 'FeedAndCommentController@pinFeed',
        'as'         => 'feed-pin'
    ]);

//unpin a feed
Route::post('group/{group_id}/feed/{feed_id}/unpin',
    [
        'middleware' => 'auth',
        'uses'       => 'FeedAndCommentController@unpinFeed',
        'as'         => 'feed-unpin'
    ]);

//like a feed
Route::post('group/{group_id}/feed/{feed_id}/like',
    [
        'middleware' => 'auth',
        'uses'       => 'FeedAndCommentController@likeFeed',
        'as'         => 'feed-like'
    ]);

//like a comment
Route::post('group/{group_id}/comment/{comment_id}/like',
    [
        'middleware' => 'auth',
        'uses'       => 'FeedAndCommentController@likeComment',
        'as'         => 'comment-like'
    ]);

//unlike a feed
Route::post('group/{group_id}/feed/{feed_id}/unlike',
    [
        'middleware' => 'auth',
        'uses'       => 'FeedAndCommentController@unlikeFeed',
        'as'         => 'feed-unlike'
    ]);

//unlike a comment
Route::post('group/{group_id}/comment/{comment_id}/unlike',
    [
        'middleware' => 'auth',
        'uses'       => 'FeedAndCommentController@unlikeComment',
        'as'         => 'comment-unlike'
    ]);


/************************* Docking Requests Group *************************/
// accept docking group request
Route::post('group/docking/group1/{group1_id}/group2/{group2_id}/accept',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@acceptDockingGroupRequest',
        'as'         => 'acceptDockingGroupRequest'
    ]);
// deny docking group request
Route::post('group/docking/group1/{group1_id}/group2/{group2_id}/deny',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@denyDockingGroupRequest',
        'as'         => 'denyDockingGroupRequest'
    ]);



/*
|----------------------------------------
| Docking
|----------------------------------------
*/

/************************* Docking *************************/

// Request docking group setup page
Route::get('/docking/targetGroup/{target_group_id}/setup',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingController@dockingGroupSetup',
        'as'         => 'dockingGroupSetupPage'
    ]);

// send docking group request
Route::post('/docking/setup',
    [
        'middleware' => 'auth',
        'uses'       => 'GroupsController@sendDockingGroupRequest',
        'as'         => 'sendDockingGroupRequest'
    ]);
// docking group page
Route::get('docking/{dockingGroup_id}',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingController@showDockingGroup',
        'as'         => 'dockingGroupPage'
    ]);

// docking group pinned page
Route::get('docking/{dockingGroup_id}/pinned',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingController@showDockingGroupPinnedPage',
        'as'         => 'dockingGroupPinnedPage'
    ]);

// disband the docking group
Route::post('docking/{dockingGroup_id}/disband',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingController@disbandDockingGroup',
        'as'         => 'dockingGroup-disband'
    ]);

// show edit the docking group
Route::get('docking/{dockingGroup_id}/edit',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingController@showEditDockingGroup',
        'as'         => 'dockingGroupEditPage-show'
    ]);

// edit the docking group
Route::patch('docking/{dockingGroup_id}/edit/action',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingController@EditDockingGroup',
        'as'         => 'dockingGroup-edit'
    ]);


/*
|----------------------------------------
| Feed and Comment in Docking Group
|----------------------------------------
*/
//post feed in docking group
Route::post('docking/{dockingGroup_id}/postFeed',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingFeedAndCommentController@postFeed',
        'as'         => 'feed-post-dockingGroup'
    ]);

//delete feed in docking group
Route::delete('docking/{dockingGroup_id}/{feed_id}/delete',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingFeedAndCommentController@deleteFeed',
        'as'         => 'feed-delete-dockingGroup'
    ]);

//edit feed in docking group
Route::patch('docking/{dockingGroup_id}/{feed_id}/edit',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingFeedAndCommentController@editFeed',
        'as'         => 'feed-edit-dockingGroup'
    ]);

//post comment in feed in docking group
Route::post('docking/{dockingGroup_id}/{feed_id}/postComment',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingFeedAndCommentController@postComment',
        'as'         => 'comment-post-dockingGroup'
    ]);

//post childComment in comment in docking group
Route::post('docking/{dockingGroup_id}/{feed_id}/comment/{comment_id}/postChildComment',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingFeedAndCommentController@postChildComment',
        'as'         => 'childComment-post-dockingGroup'
    ]);

//delete comment in docking group
Route::delete('docking/{dockingGroup_id}/{feed_id}/comment/{comment_id}/delete',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingFeedAndCommentController@deleteComment',
        'as'         => 'comment-delete-dockingGroup'
    ]);

//delete childComment in docking group
Route::delete('docking/{dockingGroup_id}/{feed_id}/comment/{comment_id}/childComment/{childComment_id}/delete',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingFeedAndCommentController@deleteChildComment',
        'as'         => 'childComment-delete-dockingGroup'
    ]);

//edit comment in docking group
Route::patch('docking/{dockingGroup_id}/{feed_id}/comment/{comment_id}/edit',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingFeedAndCommentController@editComment',
        'as'         => 'comment-edit-dockingGroup'
    ]);

//edit childComment in docking group
Route::patch('docking/{dockingGroup_id}/{feed_id}/comment/{comment_id}/childComment/{childComment_id}/edit',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingFeedAndCommentController@editChildComment',
        'as'         => 'childComment-edit-dockingGroup'
    ]);

//pin a feed in docking group
Route::post('docking/{dockingGroup_id}/feed/{feed_id}/pin',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingFeedAndCommentController@pinFeed',
        'as'         => 'feed-pin-dockingGroup'
    ]);

//unpin a feed in docking group
Route::post('docking/{dockingGroup_id}/feed/{feed_id}/unpin',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingFeedAndCommentController@unpinFeed',
        'as'         => 'feed-unpin-dockingGroup'
    ]);

//like a feed in docking group
Route::post('docking/{dockingGroup_id}/feed/{feed_id}/like',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingFeedAndCommentController@likeFeed',
        'as'         => 'feed-like-dockingGroup'
    ]);

//like a comment in docking group
Route::post('docking/{dockingGroup_id}/comment/{comment_id}/like',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingFeedAndCommentController@likeComment',
        'as'         => 'comment-like-dockingGroup'
    ]);

//unlike a feed in docking group
Route::post('docking/{dockingGroup_id}/feed/{feed_id}/unlike',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingFeedAndCommentController@unlikeFeed',
        'as'         => 'feed-unlike-dockingGroup'
    ]);

//unlike a comment in docking group
Route::post('docking/{dockingGroup_id}/comment/{comment_id}/unlike',
    [
        'middleware' => 'auth',
        'uses'       => 'DockingFeedAndCommentController@unlikeComment',
        'as'         => 'comment-unlike-dockingGroup'
    ]);


/*
|----------------------------------------
| Notifications
|----------------------------------------
*/

// get notifications
Route::get('notifications',
    [
        'middleware' => 'auth',
        'uses' => 'NotificationController@getNotifications',
        'as'   => 'notifications'
    ]);

// read notification
Route::patch('notifications/{notification_id}/read',
    [
        'middleware' => 'auth',
        'uses' => 'NotificationController@readNotification',
        'as'   => 'readNotification'
    ]);

// read all notification
Route::patch('notifications/readall',
    [
        'middleware' => 'auth',
        'uses' => 'NotificationController@readAllNotifications',
        'as'   => 'readAllNotifications'
    ]);

// unread notification
Route::patch('notifications/{notification_id}/unread',
    [
        'middleware' => 'auth',
        'uses' => 'NotificationController@unreadNotification',
        'as'   => 'unreadNotification'
    ]);

// delete notification
Route::patch('notifications/{notification_id}/delete',
    [
        'middleware' => 'auth',
        'uses' => 'NotificationController@deleteNotification',
        'as'   => 'deleteNotification'
    ]);


/*
|----------------------------------------
| Profile & Glance
|----------------------------------------
*/
// if you do guest to see other people's profile take the "'middleware' => 'auth'," off.
Route::get('{target_nickname}/profile',
    [
        'uses' => 'ProfileController@show',
        'as'   => 'profile'
    ]);

// Edit Profile route.
Route::get('{target_nickname}/profile/edit',
    [
        'middleware' => 'auth',
        'uses'       => 'ProfileController@edit',
        'as'         => 'profile.edit'
    ]);

// Update Profile route (Patch process).
Route::patch('profile/{target_nickname}/profile/update',
    [
        'middleware' => 'auth',
        'uses'       => 'ProfileController@update',
        'as'         => 'profile.update'
    ]);

// Update Profile route (Patch process).
Route::post('profile/{target_nickname}/profile/avatar/upload',
    [
        'middleware' => 'auth',
        'uses'       => 'ProfileController@uploadProfileAvatar',
        'as'         => 'uploadProfileAvatar'
    ]);

// User Glance page
Route::get('{target_nickname}',
    [
        'uses' => 'GlanceController@getGlance',
        'as'   => 'glance'
    ]);



//# Photo Album
//Route::get('{target_nickname}/album', ['uses' => 'Photo\PhotoAlbumController@showall', 'as' => 'photoAlbum.showall']);
//Route::get('{target_nickname}/album/create',
//    [
//        'middleware' => 'auth',
//        'uses'       => 'Photo\PhotoAlbumController@create',
//        'as'         => 'photoAlbum.create'
//    ]);
//Route::post('{target_nickname}/album/create',
//    [
//        'middleware' => 'auth',
//        'uses'       => 'Photo\PhotoAlbumController@postCreate',
//        'as'         => 'photoAlbum.postCreate'
//    ]);
//Route::get('{target_nickname}/album/{photoalbum_folder_id}',
//    [
//        'uses' => 'Photo\PhotoAlbumController@show',
//        'as'   => 'photoAlbum.show'
//    ]);
//Route::post('{target_nickname}/album/{photoalbum_folder_id}',
//    [
//        'middleware' => 'auth',
//        'uses'       => 'Photo\PhotoAlbumController@uploadPhoto',
//        'as'         => 'photoAlbum.uploadPhoto'
//    ]);
//Route::update( '{target_nickname}/album/{photoalbum_folder_id}/edit', [
//	'middleware' => 'auth',
//	'uses'       => 'Photo\PhotoAlbumController@edit',
//	'as'         => 'photoAlbum.edit'
//] );
//Route::update( '{target_nickname}/album/{photoalbum_folder_id}/delete', [
//	'middleware' => 'auth',
//	'uses'       => 'Photo\PhotoAlbumController@delete',
//	'as'         => 'photoAlbum.delete'
//] );

