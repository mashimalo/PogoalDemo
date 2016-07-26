<?php

use App\Models\GroupType;
use App\Models\Profile;
use \App\Models\GroupUser;
use \App\Models\GroupUserRole;
use \App\Models\Group;
use \App\Models\Comment;
use \App\Models\Feed;
use \App\Models\DockingGroup;


/************************* profile *************************/
// profile section for target profile page.
function url_link_to_target_profile( $target_nickname ) {
	return URL::route( 'profile', $target_nickname );
}

// profile section for current logged in user itself only!!!!!
function url_link_to_profile() {
	return URL::route( 'profile', Auth::user()->profile->nickname );
}

function url_link_to_editProfile() {
	return URL::route( 'profile.edit', Auth::user()->profile->nickname );
}

function getUserFirstName() {

	$firstname = Auth::user()->profile->first_name;

	if ( $firstname == null ) {
		$firstname = Auth::user()->profile->nickname;
	}

	return $firstname;
}

function getUserLastName() {
	$lastname = Auth::user()->profile->last_name;

	if ( $lastname == null ) {
		$lastname = null;
	}

	return $lastname;
}


/************************* photo albums *************************/
//works for everyone.
function url_link_to_show_album( $target_nickname, $photoalbum_folder_id ) {
	return URL::route( 'photoAlbum.show', [ $target_nickname, $photoalbum_folder_id ] );
}

function url_link_to_show_target_allAlbums( $target_nickname ) {
	return URL::route( 'photoAlbum.showall', $target_nickname );
}

//photo albums for for current logged in user itself only!!!!!
function url_link_to_create_new_album() {
	return URL::route( 'photoAlbum.create', Auth::user()->profile->nickname );
}

function url_link_to_create_new_album_post() {
	return URL::route( 'photoAlbum.postCreate', Auth::user()->profile->nickname );
}

function url_link_to_show_allAlbums() {
	return URL::route( 'photoAlbum.showall', Auth::user()->profile->nickname );
}


/************************* group *************************/
function url_link_to_group( $group_id ) {
	return URL::route( 'singleGroupPage', $group_id );
}

/************************* group *************************/
function url_link_to_groupProfilePage( $group_id ) {
	return URL::route( 'singleGroupProfilePage', $group_id );
}

/************************* group pinned*************************/
function url_link_to_group_pinned( $group_id ) {
	return URL::route( 'singleGroupPinnedPage', $group_id );
}


/************************* group profile*************************/
function url_link_to_group_profile( $group_id ) {
	return URL::route( 'singleGroupProfilePage', $group_id );
}

/************************* group member *************************/
function url_link_to_group_members( $group_id ) {
	return URL::route( 'singleGroupMembersPage', $group_id );
}

/************************* group docking *************************/
function url_link_to_group_docked_group( $group_id ) {
	return URL::route( 'singleGroupDockingPage', $group_id );
}

// get group type name not sure why group->groupType->groupTypeName not working
function getGroupTypeName( $group ) {
	$group_type_id = $group->group_type_id;
	/*$GroupTypeName = GroupType::whereid($group_type_id)->firstOrFail()->group_type_name;*/
	$GroupTypeName = getGroupTypeByGroupTypeID( $group_type_id );

	return $GroupTypeName;
}

// get groupType by groupTypeID
function getGroupTypeByGroupTypeID( $group_type_id ) {
	$GroupTypeName = GroupType::whereid( $group_type_id )->firstOrFail()->group_type_name;

	return $GroupTypeName;
}

// get the url for search by group type result base on group type id
function url_link_to_show_search_by_groups_type_result( $group_type_id ) {
	return URL::route( 'SearchByGroupsTypeResult-get', $group_type_id );
}

// get user role in group
function getUserRoleInGroup( $group, $user ) {
	$userRoleInGroupId = $group->users()->where( 'user_id', $user->id )->first()->pivot->group_user_role_id;
	$userRoleInGroup   = GroupUserRole::whereid( $userRoleInGroupId )->first()->title;

	return $userRoleInGroup;
}

function YoutubeID( $url ) {
	if ( strlen( $url ) > 11 ) {
		if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
			$url,
			$match ) ) {
			return $match[1];
		} else {
			return false;
		}
	}

	return $url;
}

/**
 * verify if the target user is founder of group
 *
 * @param $group_id
 * @param $targetUser_id
 *
 * @return mixed
 */
function validate_targetUser_founder_of_group( $group_id, $targetUser_id ) {
	$validate_targetUser_founder_of_group = GroupUser::wheregroup_id( $group_id )
	                                                 ->whereuser_id( $targetUser_id )
	                                                 ->whereaccepted( true )
	                                                 ->wheregroup_user_role_id( 1 )
	                                                 ->first();

	return $validate_targetUser_founder_of_group;
}

/**
 * verify if the target user is coordinator of group
 *
 * @param $group_id
 * @param $targetUser_id
 *
 * @return mixed
 */
function validate_targetUser_coordinator_of_group( $group_id, $targetUser_id ) {
	$validate_targetUser_coordinator_of_group = GroupUser::wheregroup_id( $group_id )
	                                                     ->whereuser_id( $targetUser_id )
	                                                     ->whereaccepted( true )
	                                                     ->wheregroup_user_role_id( 2 )
	                                                     ->first();

	return $validate_targetUser_coordinator_of_group;
}

/**
 * verify if the target user is member of group
 *
 * @param $group_id
 * @param $targetUser_id
 *
 * @return mixed
 */
function validate_targetUser_member_of_group( $group_id, $targetUser_id ) {
	$validate_targetUser_coordinator_of_group = GroupUser::wheregroup_id( $group_id )
	                                                     ->whereuser_id( $targetUser_id )
	                                                     ->whereaccepted( true )
	                                                     ->wheregroup_user_role_id( 3 )
	                                                     ->first();

	return $validate_targetUser_coordinator_of_group;
}

/**
 * verify if the current user is coordinator of group
 *
 * @param $group_id
 *
 * @return mixed
 */
function validate_currentUser_has_permission( $group_id ) {
	$validate_currentUser_in_group = Group::whereid( $group_id )->first()->validate_currentUser_in_group( $group_id );
	if ( ! $validate_currentUser_in_group ) {
		return false;
	}
	$current_user_id = Auth::User()->id;
	$userRoleId      = GroupUser::wheregroup_id( $group_id )
	                            ->whereuser_id( $current_user_id )
	                            ->whereaccepted( true )->first()
		->group_user_role_id;
	if ( $userRoleId < 3 ) {
		return true;
	} else {
		return false;
	}
}

/**
 * verify if current user role has permission to execute the operation for the target user
 *
 * @param $group_id
 * @param $targetUser_id
 *
 * @return bool
 */
function validate_currentUser_has_higher_permission_than_targetUser( $group_id, $targetUser_id ) {
	$validate_currentUser_in_group = Group::whereid( $group_id )->first()->validate_currentUser_in_group( $group_id );
	if ( ! $validate_currentUser_in_group ) {
		return false;
	}

	$current_user_id = Auth::User()->id;

	$currentUserRoleId = GroupUser::wheregroup_id( $group_id )
	                              ->whereuser_id( $current_user_id )
	                              ->whereaccepted( true )->first()
		->group_user_role_id;

	$targetUserRoleId = GroupUser::wheregroup_id( $group_id )
	                             ->whereuser_id( $targetUser_id )
	                             ->whereaccepted( true )->first()
		->group_user_role_id;

	if ( $currentUserRoleId < $targetUserRoleId ) {
		return true;
	} else {
		return false;
	}
}

/**
 * verify if current user is comment owner
 *
 * @param $comment_id
 *
 * @return bool
 */
function validate_currentUser_is_comment_owner( $comment_id ) {
	$commentUserId = Comment::whereid( $comment_id )->firstOrFail()->user_id;
	$currentUserId = Auth::user()->id;
	if ( $commentUserId == $currentUserId ) {
		return true;
	} else {
		return false;
	}
}

/**
 * get date of user join group.
 *
 * @param $user
 * @param $group
 *
 * @return mixed
 */
function get_user_join_group_date( $user, $group ) {
	return $group->users()->where( 'user_id', $user->id )->first()->pivot->updated_at;
}

/**
 * get all reply count for a feed
 *
 * @param $feed
 *
 * @return int
 */
function getAllReplyCount( $feed ) {

	$countComments          = $feed->comments->count();
	$totalCountChildComment = 0;
	foreach ( $feed->comments as $comment ) {
		$countChildComment      = $comment->childComments->count();
		$totalCountChildComment = $totalCountChildComment + $countChildComment;
	}
	$countComments = $totalCountChildComment + $countComments;

	return $countComments;
}

/**
 * get pinned feed counts
 *
 * @param $group_id
 *
 * @return mixed
 */
function getPinnedFeedsCount( $group_id ) {
	return Feed::where( 'group_id', $group_id )->where( 'pinned', true )->get()->count();
}

/**
 * get unpinned feed count
 *
 * @param $group_id
 *
 * @return mixed
 */
function getUnpinnedFeedsCount( $group_id ) {
	return Feed::where( 'group_id', $group_id )->where( 'pinned', false )->get()->count();
}


function validate_if_targetGroup_is_private( $group_id ) {
	$group              = Group::whereid( $group_id )->firstOrFail();
	$groupPrivacyRuleId = $group->privacy_rule_id;
	if ( $groupPrivacyRuleId === 2 ) {
		return true;
	} else {
		return false;
	}
}


/************************* docking *************************/
function url_link_to_dockingGroup( $dockingGroup_id ) {
	return URL::route( 'dockingGroupPage', $dockingGroup_id );
}

function url_link_to_dockingGroup_pinned( $dockingGroup_id ) {
	return URL::route( 'dockingGroupPinnedPage', $dockingGroup_id );
}

function validate_if_target_dockingGroup_is_private( $dockingGroup_id ) {
	$dockingGroup       = DockingGroup::whereid( $dockingGroup_id )->firstOrFail();
	$groupPrivacyRuleId = $dockingGroup->privacy_rule_id;
	if ( $groupPrivacyRuleId === 2 ) {
		return true;
	} else {
		return false;
	}
}

function url_link_to_dockingGroup_source_target_group( $sourceGroup_id, $targetGroup_id ) {
	$dockingGroup_id = DockingGroup::where( 'group_1_id', $sourceGroup_id )->where( 'group_2_id', $targetGroup_id )
	                               ->get()->merge( DockingGroup::where( 'group_1_id', $targetGroup_id )->where( 'group_2_id', $sourceGroup_id )->get() )->first()->id;

	return URL::route( 'dockingGroupPage', $dockingGroup_id );
}

function dockingGroup_name_source_target_group( $sourceGroup_id, $targetGroup_id ) {
	$dockingGroup_name = DockingGroup::where( 'group_1_id', $sourceGroup_id )->where( 'group_2_id', $targetGroup_id )
	                                 ->get()->merge( DockingGroup::where( 'group_1_id', $targetGroup_id )->where( 'group_2_id', $sourceGroup_id )->get() )->first()->docking_group_name;

	return $dockingGroup_name;
}


/**
 * get pinned feed counts
 *
 * @param $group_id
 *
 * @return mixed
 */
function getPinnedDockingGroupFeedsCount( $dockingGroup_id ) {
	return Feed::where( 'docking_group_id', $dockingGroup_id )->where( 'pinned', true )->get()->count();
}

/**
 * get unpinned feed count
 *
 * @param $group_id
 *
 * @return mixed
 */
function getUnpinnedDockingGroupFeedsCount( $dockingGroup_id ) {
	return Feed::where( 'docking_group_id', $dockingGroup_id )->where( 'pinned', false )->get()->count();
}


/************************* Created by Lin *************************/
function url_link_to_glance() {
	return URL::route( 'glance', Auth::user()->profile->nickname );
}

function is_profile_owner( $target_user_id ) {
	return Auth::check() && Auth::user()->id == $target_user_id;
}

// Add class to current page base on ROUTE::CURRENT
function set_active( $routeName, $class ) {
	return Route::current()->getName() == $routeName ? $class : null;
}

// Add class to current page base on REQUEST::IS
function set_active_request( $path, $class ) {
	return Request::is( $path ) ? $class : null;
}

function currentRoute( $routeName ) {
	return Route::current()->getName() == $routeName;
}

function yield_has_content( $__env, $yieldName, $class ) {
	return ! empty( $__env->yieldContent( $yieldName ) ) ? $class : null;
}

// If first name is empty, display nickname
function empty_firstName_displayNickname( $user ) {
	$userProfile = Profile::where( 'user_id', $user->id )->first();
	$userFirstName = $userProfile->first_name;
	$userNickName = $userProfile->nickname;
	if ( empty( $userFirstName ) ) {
		return $userNickName;
	} else {
		return $userFirstName;
	}
}

// If first OR last name is empty, display nickname
function empty_eitherName_displayNickname( $user ) {
	$userProfile = Profile::where( 'user_id', $user->id )->first();
	$userFirstName = $userProfile->first_name;
	$userLastName = $userProfile->last_name;
	$userNickName = $userProfile->nickname;
	if ( empty( $userFirstName ) ||
	     empty( $userLastName )
	) {
		return $userNickName;
	} else {
		return $userFirstName .
		       '&nbsp;' .
		$userLastName;
	}
}

// If first OR last name is empty, display nickname
function empty_eitherName_displayNickname_by_userId( $user_id ) {
	$userProfile = Profile::where( 'user_id', $user_id)->first();
	$userFirstName = $userProfile->first_name;
	$userLastName = $userProfile->last_name;
	$userNickName = $userProfile->nickname;

	if ( empty( $userFirstName ) ||
		empty( $userLastName )
	) {
		return $userNickName;
	} else {
		return $userFirstName .
		'&nbsp;' .
		$userLastName;
	}
}

function user_profile_completeness( $user ) {
	if ( $user->profile->first_name != null ) {
		$a = "20";
	} else {
		$a = "0";
	}
	if ( $user->profile->last_name != null ) {
		$b = "20";
	} else {
		$b = "0";
	}
	if ( $user->profile->gender_id != null ) {
		$c = "15";
	} else {
		$c = "0";
	}
	if ( $user->profile->date_of_birth != null ) {
		$d = "15";
	} else {
		$d = "0";
	}
	if ( $user->profile->bio != null ) {
		$e = "15";
	} else {
		$e = "0";
	}
	if ( $user->profile->avatar_photo_id != null ) {
		$f = "15";
	} else {
		$f = "0";
	}

	return $a + $b + $c + $d + $e + $f;
}

function numberForHumans( $num ) {
	$x               = round( $num );
	$x_number_format = number_format( $x );
	$x_array         = explode( ',', $x_number_format );
	$x_parts         = array( 'K', 'M', 'B', 'T' );
	$x_count_parts   = count( $x_array ) - 1;
	$x_display       = $x;
	$x_display       = $x_array[0] . ( (int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '' );
	$x_display .= $x_parts[ $x_count_parts - 1 ];

	return $x_display;
}

function singularOrPlural( $num, $singular, $plural, $noResault ) {
	if ( $num >= 1000 ) {
		return numberForHumans( $num ) . " " . $plural;
	} elseif ( $num > 1 && $num < 1000 ) {
		return $num . " " . $plural;
	} elseif ( $num == 1 ) {
		return "1" . " " . $singular;
	} else {
		return $noResault;
	}
}

function get_group_name_by_id( $group_id ) {
	return Group::whereid( $group_id )->firstOrFail()->name;
}

function url_link_to_profileAvatarPage() {
	return URL::route( 'profileAvatarPage', Auth::user()->profile->nickname );
}