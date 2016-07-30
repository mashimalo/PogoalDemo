// Ajax Notification
function ajaxNotification($content, $status) {
    // Icon Cache
    var $icon = "info";
    if ($status === "success") {
        $icon = "smile"
    }
    if ($status === "error") {
        $icon = "warn"
    }

    // Notification Template Cache
    var $notificationTemplate = "<div id='ajax-notification' class='uiAlert--ajax text-center'>" +
        "<div class='uiAlert--ajax__container bg-" + $status + "'>" +
        "<span class='icon icon-" + $icon + "'></span>" +
        "<div>" + $content + "</div>" +
        "</div></div>";

    // Prepend notification
    $($notificationTemplate).appendTo("body").hide().slideDown();

    // Remove notification after X seconds
    setTimeout(function () {
        $("#ajax-notification").slideToggle(200, function () {
            $(this).remove();
        });
    }, 1500);
}

// Remove Ajax Notification
function removeAjaxNotification() {
    $("#ajax-notification").remove();
}

// AJAX
$(function () {

    // DIV Cache
    var $body = $("body");
    var $feedUnpinnedList = $("#feeds-unpinned");
    // var $feedPinnedList = $("#feeds-pinned");
    var $feedUnpinnedCount = $("#feed-unpinned-count");
    var $feedPinnedCount = $("#feed-pinned-count");
    var $feedTotalCount = $("#feed-total-count");

    // *** Action Button Cache
    // Post
    var $postFeedButton = "button[data-action='post-feed']";
    var $postFeedReplyButton = "button[data-action='post-feed-reply']";
    var $postFeedChildReplyButton = "button[data-action='post-feed-childReply']";
    // Edit
    var $editFeedButton = "button[data-action='edit-feed']";
    var $editFeedReplyButton = "button[data-action='edit-feed-reply']";
    var $editFeedChildReplyButton = "button[data-action='edit-feed-childReply']";
    // Insert
    var $insertFeedReplyFormButton = "button[data-action='insert-feed-reply-form']";
    // Delete
    var $deleteFeedButton = "button[data-action='delete-feed']";
    var $deleteFeedReplyButton = "button[data-action='delete-feed-reply']";
    var $deleteFeedChildReplyButton = "button[data-action='delete-feed-childReply']";
    // Like
    var $feedLikeButton = "button[data-action='feed-like']";
    var $feedReplyLikeButton = "button[data-action='feed-reply-like']"; // Work for both feed reply and feed childReply
    // Unlike
    var $feedUnlikeButton = "button[data-action='feed-unlike']";
    var $feedReplyUnlikeButton = "button[data-action='feed-reply-unlike']"; // Work for both feed reply and feed childReply

    // Confirm Button Cache
    var $editFeedConfirmedButton = "button[data-action='edit-feed-confirmed']";
    var $editFeedChildReplyConfirmedButton = "button[data-action='edit-feed-childReply-confirmed']";
    var $editFeedReplyConfirmedButton = "button[data-action='edit-feed-reply-confirmed']";
    var $deleteFeedConfirmedButton = "button[data-action='delete-feed-confirmed']";
    var $deleteFeedReplyConfirmedButton = "button[data-action='delete-feed-reply-confirmed']";
    var $deleteFeedChildReplyConfirmedButton = "button[data-action='delete-feed-childReply-confirmed']";


    // Attributes Cache
    var $csrf_token = $("meta[name=_token]").attr("content");
    var $my_firstName = $('meta[name="my_firstName"]').attr("content");
    var $my_avatar = $('meta[name="my_avatar"]').attr("content");
    // var $user_lastName = $('meta[name="user_lastName"]').attr("content");


    /*--------------------------------------------------------------------------
     | Post Feed
     --------------------------------------------------------------------------*/
    $body.on("click", $postFeedButton, function () {

        // Cache
        var $this = $(this);
        var $richForm = $this.closest(".rich-form");
        var $richFormBody = $richForm.find(".rich-form-body");
        var $textarea = $richForm.find("textarea");
        var $textarea_content = $textarea.val();
        var $group_id = $this.attr("data-group-id");
        var $data_action_for = $this.attr("data-action-for");

        // Disable inputs to prevent multiple submit
        $this.attr('disabled', 'disabled');
        $textarea.attr('disabled', 'disabled');

        // Add loading animation
        $this.addClass("loading");

        // Remove previous ajax notification
        removeAjaxNotification();

        // AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/" + $data_action_for + "/" + $group_id + "/postFeed",
            type: "POST",
            dataType: "json",
            data: {
                'feed': $textarea_content
            },
            success: function (data) {

                // Data Cache
                var $data = {
                    data_action_for: $data_action_for,
                    feed_id: data.json.id,
                    post_time: data.json.post_time,
                    user_name: data.json.user_name,
                    user_profile_link: data.json.user_profile_link,
                    feed_content: data.json.content.nl2br(),
                    csrf_token: $csrf_token,
                    my_firstName: $my_firstName
                };

                // Dynamic data key cache - group
                if($data_action_for == "group"){
                    var $data_group_id = data.json.group_id;
                } else if($data_action_for == "docking"){
                    var $data_group_id = data.json.docking_group_id;
                }
                $data["group_id"] = $data_group_id;

                // Dynamic data key cache - avatar
                var $user_avatar = $baseURL + '/images/userAvatar/' + data.json.user_avatar_small;
                $data["user_avatar"] = $user_avatar;

                // Dynamic data key cache - initial avatar
                if (data.json.user_avatar_small == null) {
                    var $user_initialAvatar = "initialAvatar";
                }
                $data["user_initialAvatar"] = $user_initialAvatar;

                // Dynamic data key cache - my avatar
                var $my_avatar_src= $baseURL + '/images/userAvatar/' + $my_avatar;
                $data["my_avatar_src"] = $my_avatar_src;

                // Dynamic data key cache - my initial avatar
                if (!$my_avatar) {
                    var $my_initialAvatar = "initialAvatar";
                }
                $data["my_initialAvatar"] = $my_initialAvatar;

                // Get Feed template
                $.get('/api/feed-v000011.template', function (template) {
                    var $feedTemplate = Mustache.render(template, $data);

                    // prepend it to #feeds-unpinned
                    $feedUnpinnedList.prepend($feedTemplate);

                    // Execute external functions
                    initialAvatar();

                }).done(function () {

                    // Slide out the new feed
                    $feedUnpinnedList.find(".uiFeed:first-child").slideToggle(500);

                });

                // Update unpinned feed count
                $feedUnpinnedCount.text(data.json.feed_unpinned_count);

                // Update feed total count
                $feedTotalCount.text(data.json.feed_unpinned_count + data.json.feed_pinned_count);

                // Remove disabled attribute
                $this.removeAttr("disabled");
                $textarea.removeAttr("disabled");

                // Remove loading animation
                $this.removeClass("loading");

                // Remove textarea value
                $textarea.val("");

                // Close rich form
                $richFormBody.removeClass("active");
                $textarea.css({height: "36px"});

                // Run ajax notification
                ajaxNotification("Your have successfully posted a feed.", "success");

                // Remove #pageEmptyMsg
                $('#pageEmptyMsg').remove();

            },
            error: function (data) {
                // Remove disabled attribute
                $this.removeAttr("disabled");
                $textarea.removeAttr("disabled");

                // Remove loading animation
                $this.removeClass("loading");

                // Run ajax notification
                ajaxNotification("Oops! Something went wrong.", "error");
            }
        });
    });


    /*--------------------------------------------------------------------------
     | Post Feed Reply
     --------------------------------------------------------------------------*/
    $body.on("click", $postFeedReplyButton, function () {

        // Cache
        var $this = $(this);
        var $footerToggleCount = $this.closest(".uiFeed__footer").find(".uiFeed__footer__toggle .btn-sns__count");
        var $feedReplyList = $this.closest('.uiFeed__footer__toggle').siblings(".uiFeed__footer__mask").children(".uiFeed__reply");
        var $feedReplyFrom = $this.closest(".uiFeed__reply__form");
        var $textarea = $feedReplyFrom.find("textarea");
        var $textarea_content = $textarea.val();
        var $group_id = $this.attr("data-group-id");
        var $feed_id = $this.attr("data-feed-id");
        var $data_action_for = $this.attr("data-action-for");

        // Disable inputs to prevent multiple submit
        $this.attr('disabled', 'disabled');
        $textarea.attr('disabled', 'disabled');

        // Add loading animation
        $this.addClass("loading");

        // Remove previous ajax notification
        removeAjaxNotification();

        // Dynamic data key cache
        var $data = {};
        var $reply_feed_id = "reply-" + $feed_id;
        $data[$reply_feed_id] = $textarea_content;

        // AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/" + $data_action_for + "/" + $group_id + "/" + $feed_id + "/postComment",
            type: "POST",
            dataType: "json",
            data: $data,
            success: function (data) {
                console.log(data);

                // Response data cache
                var $data = {
                    data_action_for: $data_action_for,
                    feed_id: data.json.feed_id,
                    reply_id: data.json.id,
                    post_time: data.json.post_time,
                    user_name: data.json.user_name,
                    user_profile_link: data.json.user_profile_link,
                    content: data.json.content.nl2br(),
                    all_reply_count: data.json.all_reply_count,
                    csrf_token: $csrf_token,
                    user_avatar_small: data.json.user_avatar_small
                };

                // Dynamic data key cache - group
                if ($data_action_for == "group") {
                    var $data_group_id = data.json.group_id;
                } else if ($data_action_for == "docking") {
                    var $data_group_id = data.json.docking_group_id;
                }
                $data["group_id"] = $data_group_id;

                // Dynamic data key cache - avatar
                var $user_avatar = $baseURL + '/images/userAvatar/' + data.json.user_avatar_small;
                $data["user_avatar"] = $user_avatar;

                // Dynamic data key cache - initial avatar
                if (data.json.user_avatar_small == null) {
                    var $user_initialAvatar = "initialAvatar";
                }
                $data["user_initialAvatar"] = $user_initialAvatar;

                // Get Feed Reply template
                $.get('/api/feed-reply-v000007.template', function (template) {
                    var $feedReplyTemplate = Mustache.render(template, $data);

                    // Display .uiFeed__footer__mask
                    $this.closest('.uiFeed__footer__toggle').siblings(".uiFeed__footer__mask").slideToggle("fast");

                    // Prepend it to .uiFeed__reply
                    $feedReplyList.prepend($feedReplyTemplate);

                    // Execute external functions
                    initialAvatar();

                }).done(function () {

                    // Slide out the new feed
                    $feedReplyList.children(".uiFeed__reply__item:first-child").slideToggle(500);

                });

                // Update total reply count
                $footerToggleCount.text(data.json.all_reply_count);

                // Remove disabled attribute
                $this.removeAttr("disabled");
                $textarea.removeAttr("disabled");

                // Remove loading animation
                $this.removeClass("loading");

                // Remove textarea value
                $textarea.val("");

                // Show the .close button
                $this.closest(".uiFeed__footer__mask").find(".close").show();

                // Run ajax notification
                ajaxNotification("Your have successfully posted a reply.", "success");

            },
            error: function (data) {
                console.log(data);

                // Remove disabled attribute
                $this.removeAttr("disabled");
                $textarea.removeAttr("disabled");

                // Remove loading animation
                $this.removeClass("loading");

                // Run ajax notification
                ajaxNotification("Oops! Something went wrong.", "error");
            }
        });
    });


    /*--------------------------------------------------------------------------
     | Insert Feed Reply Form
     --------------------------------------------------------------------------*/
    $body.on("click", $insertFeedReplyFormButton, function () {

        // Cache
        var $this = $(this);
        var $parent = $this.closest(".uiFeed__misc");
        var $group_id = $this.attr("data-group-id");
        var $feed_id = $this.attr("data-feed-id");
        var $reply_id = $this.attr("data-reply-id");
        var $data_action_for = $this.attr("data-action-for");

        // Data Cache
        var $data = {
            data_action_for: $data_action_for,
            group_id: $group_id,
            feed_id: $feed_id,
            reply_id: $reply_id,
            csrf_token: $csrf_token,
            my_firstName: $my_firstName
        };

        // Dynamic data key cache - my avatar
        var $my_avatar_src= $baseURL + '/images/userAvatar/' + $my_avatar;
        $data["my_avatar_src"] = $my_avatar_src;

        // Dynamic data key cache - my initial avatar
        if (!$my_avatar) {
            var $my_initialAvatar = "initialAvatar";
        }
        $data["my_initialAvatar"] = $my_initialAvatar;

        // If selector does not have .clicked class, run the event.
        if (!$this.hasClass("clicked")) {

            // insert .uiFeed__reply__form after .uiFeed__misc
            $parent.after("<div class='uiFeed__reply__form'></div>");

            // Get Feed Reply Form template
            $.get('/api/feed-reply-form-v000006.template', function (template) {
                var $replyFormTemplate = Mustache.render(template, $data);

                // Append id to .uiFeed__reply__form
                $parent.siblings(".uiFeed__reply__form").append($replyFormTemplate).hide().fadeIn("slow");

                // Execute external functions
                initialAvatar();
            });

            // Add .clicked class to prevent event.
            $this.addClass("clicked");

        } else if ($this.hasClass("clicked")) {

            // remove form
            $parent.siblings(".uiFeed__reply__form").remove();

            // Add .clicked class to prevent event.
            $this.removeClass("clicked");

        }
    });


    /*--------------------------------------------------------------------------
     | Post Feed Child Reply
     --------------------------------------------------------------------------*/
    $body.on("click", $postFeedChildReplyButton, function () {
        // Cache
        var $this = $(this);
        var $footerToggleCount = $this.closest(".uiFeed__footer").find(".uiFeed__footer__toggle .btn-sns__count");
        var $feedChildReplyList = $this.closest(".uiFeed__reply__item").children(".uiFeed__reply__secondLevel");
        var $feedChildReplyFrom = $this.closest(".uiFeed__reply__form");
        var $textarea = $feedChildReplyFrom.find("textarea");
        var $textarea_content = $textarea.val();
        var $group_id = $this.attr("data-group-id");
        var $feed_id = $this.attr("data-feed-id");
        var $reply_id = $this.attr("data-reply-id");
        var $data_action_for = $this.attr("data-action-for");

        // Disable inputs to prevent multiple submit
        $this.attr('disabled', 'disabled');
        $textarea.attr('disabled', 'disabled');

        // Add loading animation 
        $this.addClass("loading");

        // Remove previous ajax notification
        removeAjaxNotification();

        // Dynamic data key cache
        var $data = {};
        var $childReply_feed_id = "2ndReply-" + $reply_id;
        $data[$childReply_feed_id] = $textarea_content;

        // AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "/" + $data_action_for + "/" + $group_id + "/" + $feed_id + "/comment/" + $reply_id + "/postChildComment",
            type: "POST",
            dataType: "json",
            data: $data,
            success: function (data) {
                console.log(data);

                // Response data cache
                var $data = {
                    data_action_for: $data_action_for,
                    feed_id: data.json.feed_id,
                    reply_id: data.json.parent_id,
                    childReply_id: data.json.id,
                    post_time: data.json.post_time,
                    user_name: data.json.user_name,
                    user_profile_link: data.json.user_profile_link,
                    content: data.json.content.nl2br(),
                    all_reply_count: data.json.all_reply_count
                };

                // Dynamic data key cache - group
                if ($data_action_for == "group") {
                    var $data_group_id = data.json.group_id;
                } else if ($data_action_for == "docking") {
                    var $data_group_id = data.json.docking_group_id;
                }
                $data["group_id"] = $data_group_id;

                // Dynamic data key cache - avatar
                var $user_avatar = $baseURL + '/images/userAvatar/' + data.json.user_avatar_small;
                $data["user_avatar"] = $user_avatar;

                // Dynamic data key cache - initial avatar
                if (data.json.user_avatar_small == null) {
                    var $user_initialAvatar = "initialAvatar";
                }
                $data["user_initialAvatar"] = $user_initialAvatar;

                // Get Feed Child Reply template
                $.get('/api/feed-childReply-v000006.template', function (template) {
                    var $feedChildReplyTemplate = Mustache.render(template, $data);

                    // Prepend it to .uiFeed__reply__secondLvl
                    $feedChildReplyList.prepend($feedChildReplyTemplate);

                    // Execute external functions
                    initialAvatar();

                }).done(function () {

                    // Slide out the new reply
                    $feedChildReplyList.children(".uiFeed__reply__item:first-child").slideToggle(500);

                });

                // Update total reply count
                $footerToggleCount.text(data.json.all_reply_count);

                // Remove disabled attribute
                $this.removeAttr("disabled");
                $textarea.removeAttr("disabled");

                // Remove loading animation
                $this.removeClass("loading");

                // Remove textarea value
                $textarea.val("");

                // Run ajax notification
                ajaxNotification("Your have successfully posted a reply.", "success");

            },
            error: function (data) {
                console.log(data);

                // Remove disabled attribute
                $this.removeAttr("disabled");
                $textarea.removeAttr("disabled");

                // Remove loading animation
                $this.removeClass("loading");

                // Run ajax notification
                ajaxNotification("Oops! Something went wrong.", "error");
            }
        });
    });


    /*--------------------------------------------------------------------------
     | Edit Feed
     --------------------------------------------------------------------------*/
    $body.on("click", $editFeedButton, function () {

        // Cache
        var $this = $(this);
        var $feed = $this.closest(".uiFeed");
        var $feedContent = $feed.find(".uiFeed__main .uiFeed__article__text");
        var $feed_original_content = $feedContent.text();
        var $group_id = $this.attr("data-group-id");
        var $feed_id = $this.attr("data-feed-id");
        var $data_action_for = $this.attr("data-action-for");

        // Data cache
        var $data = {
            data_action_for: $data_action_for,
            group_id: $group_id,
            feed_id: $feed_id,
            feed_original_content: $feed_original_content
        };

        // Remove previous ajax notification
        removeAjaxNotification();

        // If selector does not have .clicked class, run the event
        if (!$this.hasClass("clicked")) {

            // Get Edit Feed Modal template
            $.get('/api/edit-feed-modal-v000004.template', function (template) {
                    var $editFeedModal = Mustache.render(template, $data);

                    // Append it to .uiFeed
                    $feed.append($editFeedModal);

                    // add modal attribute to the delete button
                    $this.attr("data-toggle", "modal");
                    $this.attr("data-target", "#edit-feed-" + $group_id + $feed_id);
                })
                .done(function () {
                    // Run the modal
                    $this.click();
                });

            // Confirm to run the ajax
            $feed.on("click", $editFeedConfirmedButton, function () {

                // Feed edited content cache
                var $feed_modal_content = "#edit-feed-" + $group_id + $feed_id + " textarea";
                var $feed_edited_content = $feed.find($feed_modal_content).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "PATCH",
                    dataType: "json",
                    url: "/" + $data_action_for + "/" + $group_id + "/" + $feed_id + "/edit",
                    data: {
                        'feed': $feed_edited_content
                    },
                    success: function (data) {

                        // Update the content
                        $feedContent.html(data.json.content.nl2br());

                        // Run ajax notification
                        ajaxNotification("Your have successfully edited a feed", "success");

                    },
                    error: function (data) {
                        console.log(data);
                        // Run ajax notification
                        ajaxNotification("Oops! Something went wrong.", "error");
                    }
                });
            });

            // Add .clicked class to prevent event
            $this.addClass("clicked");
        }

        // If selector has .clicked class, run the event
        if ($this.hasClass("clicked")) {

            // Fetch feed content to modal again
            var $feed_modal_content = "#edit-feed-" + $group_id + $feed_id + " textarea";
            $feed.find($feed_modal_content).val($feed_original_content);
        }
    });


    /*--------------------------------------------------------------------------
     | Edit Feed Reply
     --------------------------------------------------------------------------*/
    $body.on("click", $editFeedReplyButton, function () {

        // Cache
        var $this = $(this);
        var $feedReplyItem = $this.closest(".uiFeed__reply__item");
        var $feedReplyContent = $feedReplyItem.children(".uiFeed__article").find(".uiFeed__article__text");
        var $feed_reply_original_content = $feedReplyContent.text();
        var $group_id = $this.attr("data-group-id");
        var $feed_id = $this.attr("data-feed-id");
        var $reply_id = $this.attr("data-reply-id");
        var $data_action_for = $this.attr("data-action-for");

        // Data Cache
        var $data = {
            data_action_for: $data_action_for,
            group_id: $group_id,
            feed_id: $feed_id,
            reply_id: $reply_id,
            feed_reply_original_content: $feed_reply_original_content
        };

        // Remove previous ajax notification
        removeAjaxNotification();

        // If selector does not have .clicked class, run the event.
        if (!$this.hasClass("clicked")) {

            // Get Edit Feed Modal template
            $.get('/api/edit-feed-reply-modal-v000004.template', function (template) {
                    var $editFeedReplyModal = Mustache.render(template, $data);

                    // Append it to .uiFeed__reply__item
                    $feedReplyItem.append($editFeedReplyModal);

                    // add modal attribute to the delete button
                    $this.attr("data-toggle", "modal");
                    $this.attr("data-target", "#edit-feed-reply-" + $group_id + $feed_id + $reply_id);
                })
                .done(function () {
                    // Run the modal
                    $this.click();
                });

            // click modal delete button to fire the ajax
            $feedReplyItem.on("click", $editFeedReplyConfirmedButton, function () {

                // Feed reply edited content cache
                var $feed_reply_modal_content = "#edit-feed-reply-" + $group_id + $feed_id + $reply_id + " textarea";
                var $feed_reply_edited_content = $feedReplyItem.find($feed_reply_modal_content).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "PATCH",
                    dataType: "json",
                    url: "/" + $data_action_for + "/" + $group_id + "/" + $feed_id + "/comment/" + $reply_id + "/edit",
                    data: {
                        'editComment': $feed_reply_edited_content
                    },
                    success: function (data) {

                        // Update the content
                        $feedReplyContent.html(data.json.content.nl2br());

                        // Run ajax notification
                        ajaxNotification("Your have successfully edited a feed.", "success");

                    },
                    error: function (data) {
                        console.log(data);

                        // Run ajax notification
                        ajaxNotification("Oops! Something went wrong.", "error");
                    }
                });
            });

            // Add .clicked class to prevent event.
            $this.addClass("clicked");
        }

        // If selector has .clicked class, run the event.
        if ($this.hasClass("clicked")) {

            // Fetch feed reply content to modal again.
            var $feed_reply_modal_content = "#edit-feed-reply-" + $group_id + $feed_id + $reply_id + " textarea";
            $feedReplyItem.find($feed_reply_modal_content).val($feed_reply_original_content);
        }
    });


    /*--------------------------------------------------------------------------
     | Edit Feed childReply
     --------------------------------------------------------------------------*/
    $body.on("click", $editFeedChildReplyButton, function () {

        // Cache
        var $this = $(this);
        var $feedChildReplyItem = $this.closest(".uiFeed__reply__item");
        var $feedChildReplyContent = $feedChildReplyItem.children(".uiFeed__article").find(".uiFeed__article__text");
        var $feed_childReply_original_content = $feedChildReplyContent.text();
        var $group_id = $this.attr("data-group-id");
        var $feed_id = $this.attr("data-feed-id");
        var $reply_id = $this.attr("data-reply-id");
        var $childReply_id = $this.attr("data-childReply-id");
        var $data_action_for = $this.attr("data-action-for");

        // Data Cache
        var $data = {
            data_action_for: $data_action_for,
            group_id: $group_id,
            feed_id: $feed_id,
            reply_id: $reply_id,
            childReply_id: $childReply_id,
            feed_childReply_original_content: $feed_childReply_original_content
        };

        // Remove previous ajax notification
        removeAjaxNotification();

        // If selector does not have .clicked class, run the event.
        if (!$this.hasClass("clicked")) {

            // Get Edit Feed Modal template
            $.get('/api/edit-feed-childReply-modal-v000004.template', function (template) {
                    var $editFeedChildReplyModal = Mustache.render(template, $data);

                    // Append it to .uiFeed__reply__item
                    $feedChildReplyItem.append($editFeedChildReplyModal);

                    // add modal attribute to the delete button
                    $this.attr("data-toggle", "modal");
                    $this.attr("data-target", "#edit-feed-childReply-" + $group_id + $feed_id + $reply_id + $childReply_id);
                })
                .done(function () {
                    // Run the modal
                    $this.click();
                });

            // Confirm to run the ajax event
            $feedChildReplyItem.on("click", $editFeedChildReplyConfirmedButton, function () {

                // Feed childReply edited content cache
                var $feed_childReply_modal_content = "#edit-feed-childReply-" + $group_id + $feed_id + $reply_id + $childReply_id + " textarea";
                var $feed_childReply_edited_content = $feedChildReplyItem.find($feed_childReply_modal_content).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "PATCH",
                    dataType: "json",
                    url: "/" + $data_action_for + "/" + $group_id + "/" + $feed_id + "/comment/" + $reply_id + "/childComment/" + $childReply_id + "/edit",
                    data: {
                        'editComment': $feed_childReply_edited_content
                    },
                    success: function (data) {

                        // Update the content
                        $feedChildReplyContent.html(data.json.content.nl2br());

                        // Run ajax notification
                        ajaxNotification("Your have successfully edited a reply.", "success");

                    },
                    error: function (data) {
                        console.log(data);

                        // Run ajax notification
                        ajaxNotification("Oops! Something went wrong.", "error");
                    }
                });
            });

            // Add .clicked class to prevent event
            $this.addClass("clicked");
        }

        // If selector has .clicked class, run the event
        if ($this.hasClass("clicked")) {

            // Fetch feed childReply to modal again
            var $feed_childReply_modal_content = "#edit-feed-childReply-" + $group_id + $feed_id + $reply_id + $childReply_id + " textarea";
            $feedChildReplyItem.find($feed_childReply_modal_content).val($feed_childReply_original_content);
        }
    });


    /*--------------------------------------------------------------------------
     | Delete Feed
     --------------------------------------------------------------------------*/
    $body.on("click", $deleteFeedButton, function () {

        // Cache
        var $this = $(this);
        var $feed = $this.closest(".uiFeed");
        var $group_id = $this.attr("data-group-id");
        var $feed_id = $this.attr("data-feed-id");
        var $data_action_for = $this.attr("data-action-for");

        // Data Cache
        var $data = {
            data_action_for: $data_action_for,
            group_id: $group_id,
            feed_id: $feed_id
        };

        // Remove previous ajax notification
        removeAjaxNotification();

        // If selector does not have .clicked class, run the event
        if (!$this.hasClass("clicked")) {

            // Get Delete Feed Modal template
            $.get('/api/delete-feed-modal.template', function (template) {
                    var $deleteFeedModal = Mustache.render(template, $data);

                    // Append it to .uiFeed
                    $feed.append($deleteFeedModal);

                    // Add modal attribute to the delete button
                    $this.attr("data-toggle", "modal");
                    $this.attr("data-target", "#delete-confirmation-" + $group_id + $feed_id);
                })
                .done(function () {
                    // Run the modal
                    $this.click();
                });

            // Confirm to run the ajax event
            $feed.one("click", $deleteFeedConfirmedButton, function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "DELETE",
                    dataType: "json",
                    url: "/" + $data_action_for + "/" + $group_id + "/" + $feed_id + "/delete",
                    success: function (data) {

                        $feed.find(".pinned-badge").remove();

                        // Remove this feed
                        $feed.slideToggle(500, function () {
                            $(this).remove();
                        });

                        // Update pinned feed & unpinned feed count
                        $feedPinnedCount.text(data.json.feed_pinned_count);
                        $feedUnpinnedCount.text(data.json.feed_unpinned_count);

                        // Update feed total count
                        $feedTotalCount.text(data.json.feed_unpinned_count + data.json.feed_pinned_count);

                        // Run ajax notification
                        ajaxNotification("Your have successfully deleted a feed.", "success");

                    },
                    error: function (data) {
                        console.log(data);

                        // Run ajax notification
                        ajaxNotification("Oops! Something went wrong.", "error");
                    }
                });
            });

            // Add .clicked class to prevent event.
            $this.addClass("clicked");
        }
    });


    /*--------------------------------------------------------------------------
     | Delete Feed Reply
     --------------------------------------------------------------------------*/
    $body.on("click", $deleteFeedReplyButton, function () {

        // Cache
        var $this = $(this);
        var $footerToggleCount = $this.closest(".uiFeed__footer").find(".uiFeed__footer__toggle .btn-sns__count");
        var $feedReplyItem = $this.closest(".uiFeed__reply__item");
        var $group_id = $this.attr("data-group-id");
        var $feed_id = $this.attr("data-feed-id");
        var $reply_id = $this.attr("data-reply-id");
        var $data_action_for = $this.attr("data-action-for");

        // Data Cache
        var $data = {
            data_action_for: $data_action_for,
            group_id: $group_id,
            feed_id: $feed_id,
            reply_id: $reply_id
        };

        // Remove previous ajax notification
        removeAjaxNotification();

        // If selector does not have .clicked class, run the event.
        if (!$this.hasClass("clicked")) {

            // Get Delete Feed Modal template
            $.get('/api/delete-feed-reply-modal-v000001.template', function (template) {
                    var $deleteFeedReplyModal = Mustache.render(template, $data);

                    // Append it to .uiFeed__reply__item
                    $feedReplyItem.append($deleteFeedReplyModal);

                    // Add modal attribute to the delete button
                    $this.attr("data-toggle", "modal");
                    $this.attr("data-target", "#delete-confirmation-" + $group_id + $feed_id + $reply_id);
                })
                .done(function () {
                    // Run the modal
                    $this.click();
                });

            // click modal delete button to fire the ajax
            $feedReplyItem.one("click", $deleteFeedReplyConfirmedButton, function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "DELETE",
                    dataType: "json",
                    url: "/" + $data_action_for + "/" + $group_id + "/" + $feed_id + "/comment/" + $reply_id + "/delete",
                    success: function (data) {

                        // Remove this reply
                        $feedReplyItem.slideToggle(500, function () {
                            $(this).remove();
                        });

                        // Update total reply count
                        $footerToggleCount.text(data.json);

                        // If this feed does not have reply, hide the close button
                        if (data.json === 0) {
                            $this.closest(".uiFeed__footer__mask").find(".close").hide();
                        }

                        // Run ajax notification
                        ajaxNotification("Your have successfully deleted a reply.", "success");

                    },
                    error: function (data) {
                        console.log(data);

                        // Run ajax notification
                        ajaxNotification("Oops! Something went wrong", "error");
                    }
                });
            });

            // Add .clicked class to prevent event.
            $this.addClass("clicked");
        }
    });


    /*--------------------------------------------------------------------------
     | Delete Feed Child Reply
     --------------------------------------------------------------------------*/
    $body.on("click", $deleteFeedChildReplyButton, function () {

        // Cache
        var $this = $(this);
        var $footerToggleCount = $this.closest(".uiFeed__footer").find(".uiFeed__footer__toggle .btn-sns__count");
        var $feedChildReplyItem = $this.closest(".uiFeed__reply__item");
        var $group_id = $this.attr("data-group-id");
        var $feed_id = $this.attr("data-feed-id");
        var $reply_id = $this.attr("data-reply-id");
        var $childReply_id = $this.attr("data-childreply-id");
        var $data_action_for = $this.attr("data-action-for");

        // Data Cache
        var $data = {
            data_action_for: $data_action_for,
            group_id: $group_id,
            feed_id: $feed_id,
            reply_id: $reply_id,
            childReply_id: $childReply_id
        };

        // Remove previous ajax notification
        $("#ajax-notification").remove();

        // If selector does not have .clicked class, run the event.
        if (!$this.hasClass("clicked")) {

            // Get Delete Feed Modal template
            $.get('/api/delete-feed-childReply-modal-v000002.template', function (template) {
                    var $deleteFeedChildReplyModal = Mustache.render(template, $data);

                    // Append it to .uiFeed__reply__item
                    $feedChildReplyItem.append($deleteFeedChildReplyModal);

                    // Add modal attribute to the delete button
                    $this.attr("data-toggle", "modal");
                    $this.attr("data-target", "#delete-confirmation-" + $group_id + $feed_id + $reply_id + $childReply_id);
                })
                .done(function () {
                    // Run the modal
                    $this.click();
                });

            // click modal delete button to fire the ajax
            $feedChildReplyItem.one("click", $deleteFeedChildReplyConfirmedButton, function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "DELETE",
                    dataType: "json",
                    url: "/" + $data_action_for + "/" + $group_id + "/" + $feed_id + "/comment/" + $reply_id + "/childComment/" + $childReply_id + "/delete",
                    success: function (data) {

                        // Remove this reply
                        $feedChildReplyItem.slideToggle(500, function () {
                            $(this).remove();
                        });

                        // Update total reply count
                        $footerToggleCount.text(data.json);

                        // If this feed does not have reply, remove the close button
                        if (data.json === 0) {
                            $(".uiFeed__reply").siblings(".close").hide();
                        }

                        // Run ajax notification
                        ajaxNotification("Your have successfully deleted a reply.", "success");

                    },
                    error: function (data) {
                        console.log(data);

                        // Run ajax notification
                        ajaxNotification("Oops! Something went wrong.", "error");
                    }
                });
            });

            // Add .clicked class to prevent event.
            $this.addClass("clicked");
        }

    });


    /*--------------------------------------------------------------------------
     | Like Feed
     --------------------------------------------------------------------------*/
    $body.on("click", $feedLikeButton, function () {

        // Cache
        var $this = $(this);
        var $group_id = $this.attr("data-group-id");
        var $feedLikeCount = $this.children(".btn-sns__count");
        var $feedUnlike = $this.siblings(".unlike-submit");
        var $feedUnlikeCount = $feedUnlike.children(".btn-sns__count");
        var $feed_id = $this.attr("data-feed-id");
        var $data_action_for = $this.attr("data-action-for");

        // Disable inputs to prevent multiple submit
        $this.attr('disabled', 'disabled');
        $feedUnlike.attr('disabled', 'disabled');

        // Add loading animation
        $this.addClass("loading");

        // AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/" + $data_action_for + "/" + $group_id + "/feed/" + $feed_id + "/like",
            success: function (data) {

                console.log(data.json.feed_like_count, data.json.feed_unlike_count);

                // Update feed like count
                $feedLikeCount.text(data.json.feed_like_count);

                // Update feed unlike count
                $feedUnlikeCount.text(data.json.feed_unlike_count);

                // Remove disabled attribute
                $this.removeAttr("disabled");
                $feedUnlike.removeAttr("disabled");

                // Remove loading animation
                $this.removeClass("loading");
            },
            error: function (data) {
                console.log(data);

                // Remove disabled attribute
                $this.removeAttr("disabled");
                $feedUnlike.removeAttr("disabled");

                // Remove loading animation
                $this.removeClass("loading");
            }
        });

    });


    /*--------------------------------------------------------------------------
     | Unlike Feed
     --------------------------------------------------------------------------*/
    $body.on("click", $feedUnlikeButton, function () {

        // Cache
        var $this = $(this);
        var $feedUnlikeCount = $this.children(".btn-sns__count");
        var $feedLike = $this.siblings(".like-submit");
        var $feedLikeCount = $feedLike.children(".btn-sns__count");
        var $group_id = $this.attr("data-group-id");
        var $feed_id = $this.attr("data-feed-id");
        var $data_action_for = $this.attr("data-action-for");

        // Disable inputs to prevent multiple submit
        $this.attr('disabled', 'disabled');
        $feedLike.attr('disabled', 'disabled');

        // Add loading animation
        $this.addClass("loading");

        // AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/" + $data_action_for + "/" + $group_id + "/feed/" + $feed_id + "/unlike",
            success: function (data) {

                console.log(data.json.feed_like_count, data.json.feed_unlike_count);

                // Update feed unlike count
                $feedUnlikeCount.text(data.json.feed_unlike_count);

                // Update feed like count
                $feedLikeCount.text(data.json.feed_like_count);

                // Remove disabled attribute
                $this.removeAttr("disabled");
                $feedLike.removeAttr("disabled");

                // Remove loading animation
                $this.removeClass("loading");
            },
            error: function (data) {
                console.log(data);

                // Remove disabled attribute
                $this.removeAttr("disabled");
                $feedLike.removeAttr("disabled");

                // Remove loading animation
                $this.removeClass("loading");
            }
        });

    });


    /*--------------------------------------------------------------------------
     | Like Feed Reply
     --------------------------------------------------------------------------*/
    $body.on("click", $feedReplyLikeButton, function () {

        // Cache
        var $this = $(this);
        var $group_id = $this.attr("data-group-id");
        var $feedReplyLikeCount = $this.children(".btn-sns__count");
        var $feedReplyUnlike = $this.siblings(".unlike-submit");
        var $feedReplyUnlikeCount = $feedReplyUnlike.children(".btn-sns__count");
        var $reply_id = $this.attr("data-reply-id");
        var $data_action_for = $this.attr("data-action-for");

        // Disable inputs to prevent multiple submit
        $this.attr('disabled', 'disabled');
        $feedReplyUnlike.attr('disabled', 'disabled');

        // Add loading animation
        $this.addClass("loading");

        // AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/" + $data_action_for + "/" + $group_id + "/comment/" + $reply_id + "/like",
            success: function (data) {

                console.log(data.json.feed_reply_like_count, data.json.feed_reply_unlike_count);

                // Update feed reply like count
                $feedReplyLikeCount.text(data.json.feed_reply_like_count);

                // Update feed reply unlike count
                $feedReplyUnlikeCount.text(data.json.feed_reply_unlike_count);

                // Remove disabled attribute
                $this.removeAttr("disabled");
                $feedReplyUnlike.removeAttr("disabled");

                // Remove loading animation
                $this.removeClass("loading");
            },
            error: function (data) {
                console.log(data);

                // Remove disabled attribute
                $this.removeAttr("disabled");
                $feedReplyUnlike.removeAttr("disabled");

                // Remove loading animation
                $this.removeClass("loading");
            }
        });

    });


    /*--------------------------------------------------------------------------
     | Unlike Feed Reply
     --------------------------------------------------------------------------*/
    $body.on("click", $feedReplyUnlikeButton, function () {

        // Cache
        var $this = $(this);
        var $group_id = $this.attr("data-group-id");
        var $feedReplyUnlikeCount = $this.children(".btn-sns__count");
        var $feedReplyLike = $this.siblings(".like-submit");
        var $feedReplyLikeCount = $feedReplyLike.children(".btn-sns__count");
        var $reply_id = $this.attr("data-reply-id");
        var $data_action_for = $this.attr("data-action-for");

        // Disable inputs to prevent multiple submit
        $this.attr('disabled', 'disabled');
        $feedReplyLike.attr('disabled', 'disabled');

        // Add loading animation
        $this.addClass("loading");

        // AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/" + $data_action_for + "/" + $group_id + "/comment/" + $reply_id + "/unlike",
            success: function (data) {

                console.log(data.json.feed_reply_like_count, data.json.feed_reply_unlike_count);

                // Update feed reply unlike count
                $feedReplyUnlikeCount.text(data.json.feed_reply_unlike_count);

                // Update feed reply like count
                $feedReplyLikeCount.text(data.json.feed_reply_like_count);

                // Remove disabled attribute
                $this.removeAttr("disabled");
                $feedReplyLike.removeAttr("disabled");

                // Remove loading animation
                $this.removeClass("loading");
            },
            error: function (data) {
                console.log(data);

                // Remove disabled attribute
                $this.removeAttr("disabled");
                $feedReplyLike.removeAttr("disabled");

                // Remove loading animation
                $this.removeClass("loading");
            }
        });

    });


});