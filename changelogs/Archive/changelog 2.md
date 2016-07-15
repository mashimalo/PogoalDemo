---------------------------

Date: Apr 27, 2016
Author: Hui Lin

---------------------------

# Modified Files:

1. toolbarMinor.blade.php                       -> replaced (Account Setting) to (Edit My Profile)
2. profilePage-edit.blade.php                   -> commented out (Edit Profile List)
3. FeedAndCommentController.php                 -> add ajax response to (postFeed) [return response(['status' => 'success','json'=>$feed]);]
4. ajax.js                                      -> add (post feed ajax)
5. singleGroupPage-top.blade.php                -> replaced (Form::model) to (ajax post feed)
6. singleGroupPage-feed.blade.php               -> separated (Pinned Feed) to a new .uiFeeds, and added id for ajax

# Removed Files:

1. 



# Added Files:

1. 