$(function () {
    // DIV Cache
    var $body = $("body");
    var $toolbarNotificationButton = "#toolbar-notification-button";
    var $toolbarNotificationList = "#toolbar-notification-list";
    // var $seeAllNotificationList = "#see-all-notification-list";
    var $toolbarNotificationListChild = "#toolbar-notification-list li";
    var $seeAllNotificationListChild = "#see-all-notification-list li";
    var $toolbarNotificationListChildReadButton = "#toolbar-notification-list .notification__list__markReadBtn";
    var $seeAllNotificationListChildReadButton = "#see-all-notification-list .notification__list__markReadBtn";
    var $toolbarNotificationCounter = "#toolbar-notification-counter";
    var $toolbarNotificationListLoader = "#toolbar-notification-list-loader";

    // Action Cache
    var $notificationMarkAllReadButton = "[data-action='notification-mark-all-read-button']";
    var $notificationMarkRead = "[data-action='notification-mark-read']";

    // Attributes Cache
    var $csrf_token = $("meta[name=_token]").attr("content");

    /*--------------------------------------------------------------------------
     | Toolbar Notification List
     --------------------------------------------------------------------------*/
    $body.on("click", $toolbarNotificationButton, function () {

        // Run Ajax if Parent is Closed
        if (!$($toolbarNotificationButton).parent().hasClass("open")) {

            // Empty Notification List
            $($toolbarNotificationList).empty();

            // Add Loading to Notification List
            $($toolbarNotificationList).append(
                '<li id="toolbar-notification-list-loader"><div class="notification__list__content loading">' +
                '&nbsp;<div class="hidden-text">Loading</div>' +
                '</div></li>'
            );

            // AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $csrf_token
                }
            });
            $.ajax({
                url: "/notifications",
                type: "GET",
                dataType: "json",
                success: function (data) {

                    // Empty Notification List
                    $($toolbarNotificationList).empty();

                    // Update Notification Counter
                    if (data.newNotifications > 0) {
                        $($toolbarNotificationCounter).removeClass("hidden");
                    } else if (data.newNotifications < 1) {
                        $($toolbarNotificationCounter).addClass("hidden");
                    }
                    $($toolbarNotificationCounter).html(data.newNotifications);

                    // Notification List Loop
                    $.each(data.json, function (index, item) {

                        // Data Cache
                        var $data = {
                            id: item.id,
                            user_id: item.user_id,
                            message_data: item.message_data,
                            notification_link: item.notification_link,
                            read: item.read,
                            created_at: item.created_at,
                            updated_at: item.updated_at,
                        };

                        // Notification Status Statement
                        if (item.read == 0) {
                            $data["new_notification"] = "notification--new";
                            $data["toolbar_notification_status"] = "new";
                            $data["toolbar_notification_button_title"] = "Mark Read";
                            $data["toolbar_notification_button_icon"] = "circle";
                        } else if (item.read == 1) {
                            $data["toolbar_notification_status"] = "read";
                            $data["toolbar_notification_button_title"] = "Read";
                            $data["toolbar_notification_button_icon"] = "dot-fill";
                        }

                        // Get Toolbar Notification template
                        $.get('/api/toolbar-notification-list-v000011.template', function (template) {
                            var $toolbarNotificationTemplate = Mustache.render(template, $data);

                            // prepend it to #toolbar-notification-list
                            $($toolbarNotificationList).append($toolbarNotificationTemplate);

                        });

                    });

                    // Remove Loader
                    $($toolbarNotificationListLoader).remove();
                }
            });

        }
    });

    /*--------------------------------------------------------------------------
     | Toolbar Notification Mark Read
     --------------------------------------------------------------------------*/
    $body.on("click", $notificationMarkRead, function (event) {

        // Cache
        var $this = $(this);
        var $data_notification_id = $this.parent().attr("data-notification-id");
        var $data_notification_status = $this.parent().attr("data-notification-status");

        // Prevent Dropdown Closed
        event.stopPropagation();

        // Check Notification Status
        if ($data_notification_status === "new") {

            // Disable inputs to prevent multiple submit
            $this.attr('disabled', 'disabled');

            // AJAX - Mark Read
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $csrf_token
                }
            });
            $.ajax({
                url: "/notifications/" + $data_notification_id + "/read",
                type: "PATCH",
                success: function () {

                    // Remove .Notification--new Class
                    $this.parent().removeClass("notification--new");

                    // Change Notification Status
                    $this.parent().attr("data-notification-status", "read");

                    // Change Read Button Title
                    $this.prop('title', 'Read');

                    // Change Read Button Icon
                    $this.find(".icon").removeClass("icon-circle");
                    $this.find(".icon").addClass("icon-dot-fill");

                    // Update Toolbar Notification Counter
                    var $currentTotal = $($toolbarNotificationCounter).html();
                    var $newTotal = $currentTotal - 1;
                    $($toolbarNotificationCounter).html($newTotal);
                    if ($newTotal < 1) {
                        $($toolbarNotificationCounter).addClass("hidden");
                    }

                    // Remove disabled attribute
                    $this.removeAttr("disabled");

                },
                error: function () {
                    // Remove disabled attribute
                    $this.removeAttr("disabled");
                }
            });

        }

    });

    /*--------------------------------------------------------------------------
     | Toolbar Notification Mark All Read
     --------------------------------------------------------------------------*/
    $body.on("click", $notificationMarkAllReadButton, function (event) {

        // Cache
        var $this = $(this);

        // Add loading animation
        $this.addClass("loading loading--medium loading--white");

        // Prevent Dropdown Closed
        event.stopPropagation();

        // Disable inputs to prevent multiple submit
        $this.attr('disabled', 'disabled');

        // AJAX - Mark Read
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $csrf_token
            }
        });
        $.ajax({
            url: "/notifications/readall",
            type: "PATCH",
            success: function () {

                // Update Notification Counter
                $($toolbarNotificationCounter).addClass("hidden");
                $($toolbarNotificationCounter).html("0");

                // Remove .Notification--new Class
                $($toolbarNotificationListChild).removeClass("notification--new");
                $($seeAllNotificationListChild).removeClass("notification--new");

                // Change Notification Status
                $($toolbarNotificationListChild).attr("data-notification-status", "read");
                $($seeAllNotificationListChild).attr("data-notification-status", "read");

                // Change Read Button Title
                $($toolbarNotificationListChildReadButton).prop('title', 'Read');
                $($seeAllNotificationListChildReadButton).prop('title', 'Read');

                // Change Read Button Icon
                $($toolbarNotificationListChildReadButton).find(".icon").removeClass("icon-circle");
                $($toolbarNotificationListChildReadButton).find(".icon").addClass("icon-dot-fill");
                $($seeAllNotificationListChildReadButton).find(".icon").removeClass("icon-circle");
                $($seeAllNotificationListChildReadButton).find(".icon").addClass("icon-dot-fill");

                // Remove loading animation
                $this.removeClass("loading loading--medium loading--white");

                // Remove disabled attribute
                $this.removeAttr("disabled");

            },
            error: function () {

                // Remove disabled attribute
                $this.removeAttr("disabled");

            }
        });

    });

    /*--------------------------------------------------------------------------
     | Toolbar Notification Counter Auto Update
     --------------------------------------------------------------------------*/
    $(window).load(function () {

        setInterval(function () {

            // AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $csrf_token
                }
            });
            $.ajax({
                url: "/notifications",
                type: "GET",
                dataType: "json",
                success: function (data) {

                    // Update Notification Counter
                    if (data.newNotifications > 0) {
                        $($toolbarNotificationCounter).removeClass("hidden");
                    }

                    $($toolbarNotificationCounter).html(data.newNotifications);
                }
            });

        }, 300000);

    });

});