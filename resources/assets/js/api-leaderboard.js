$(function(){
    // DIV Cache
    var $body = $("body");

    // Filter Cache
    var $leaderboardFilterTopUsers = "#leaderboard-filter-topUsers";
    var $leaderboardFilterTopGroups = "#leaderboard-filter-topGroups";
    var $leaderboardFilterTopUsersList = "#leaderboard-filter-topUsers ul";
    var $leaderboardFilterTopGroupsList = "#leaderboard-filter-topGroups ul";
    var $leaderboardFilterTopUsersChild = "#leaderboard-filter-topUsers ul li";
    var $leaderboardFilterTopGroupsChild = "#leaderboard-filter-topGroups ul li";

    // Result Cache
    var $leaderboardTopUsers = "#leaderboard-topUsers";
    var $leaderboardTopGroups = "#leaderboard-topGroups";
    var $leaderboardTopUsersList = "#leaderboard-result-topUsers";
    var $leaderboardTopGroupsList = "#leaderboard-result-topGroups";
    var $leaderboardTopUsersChild = "#leaderboard-result-topUsers li";
    var $leaderboardTopGroupsChild = "#leaderboard-result-topGroups li";

    // Action Cache
    var $leaderboardFilterTopUsersButton = "[data-action='leaderboard-filter-topUsers']";
    var $leaderboardFilterTopGroupsButton = "[data-action='leaderboard-filter-topGroups']";

    // Attributes Cache
    var $csrf_token = $("meta[name=_token]").attr("content");

    /*--------------------------------------------------------------------------
     | Top Users Filter
     --------------------------------------------------------------------------*/
    $body.on("click", $leaderboardFilterTopUsersButton, function () {

        // Cache
        var $this = $(this);
        var $filterName = $this.html();
        var $group_type_id = $this.attr("data-group-type-id");

        // Empty List
        $($leaderboardTopUsersList).empty();

        // Add Loading
        $($leaderboardTopUsersList).append(
            '<li class="pH--md lk-block"><div class="pV--md loading">' +
            '&nbsp;<div class="hidden-text">Loading</div>' +
            '</div></li>'
        );

        // Close Filter List
        $($leaderboardFilterTopUsers).slideToggle();
        $this.closest(".leaderboard__column").find(".leaderboard__filter__container").removeClass("toggled");

        // AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $csrf_token
            }
        });
        $.ajax({
            url: "leaderboard/topusers/" + $group_type_id,
            type: "GET",
            dataType: "json",
            success: function (data) {

                // Empty List
                $($leaderboardTopUsersList).empty();

                // Loop
                $.each(jQuery.parseJSON(data.json), function (index, item) {

                    // Data Cache
                    var $data = {
                        user_name: "Test",
                        user_link: "http://test.com",
                        user_id: item.user_id,
                        amount: item.amount
                    };

                    // Dynamic data key cache - avatar
                    if(item.user_avatar == null){
                        var $profileAvatar = '<img data-name="' + item.user_name + '" class="initialAvatar avatar avatar--md rounded"/>';
                    } else {
                        var $profileAvatar = '<img scr="' + item.user_avatar + '" class="initialAvatar avatar avatar--md rounded"/>';
                    }
                    $data["user_avatar"] = $profileAvatar;

                    // Get template
                    $.get('/api/leaderboard-topUsers-list-v000006.template', function (template) {
                        var $leaderboardTopUsersTemplate = Mustache.render(template, $data);
                        
                        // prepend it to list
                        $($leaderboardTopUsersList).append($leaderboardTopUsersTemplate);

                        // Execute external functions
                        initialAvatar();
                    });

                });

                // Replace .leaderboard__filter__current content
                $this.closest(".leaderboard__column").find(".leaderboard__filter__current").html($filterName);

            }
        });

    });

    /*--------------------------------------------------------------------------
     | Top Groups Filter
     --------------------------------------------------------------------------*/
    $body.on("click", $leaderboardFilterTopGroupsButton, function () {

        // Cache
        var $this = $(this);
        var $filterName = $this.html();
        var $group_type_id = $this.attr("data-group-type-id");

        // Empty List
        $($leaderboardTopGroupsList).empty();

        // Add Loading
        $($leaderboardTopGroupsList).append(
            '<li class="pH--md lk-block"><div class="pV--md loading">' +
            '&nbsp;<div class="hidden-text">Loading</div>' +
            '</div></li>'
        );

        // Close Filter List
        $($leaderboardFilterTopGroups).slideToggle();
        $this.closest(".leaderboard__column").find(".leaderboard__filter__container").removeClass("toggled");

        // AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $csrf_token
            }
        });
        $.ajax({
            url: "leaderboard/topgroups/" + $group_type_id,
            type: "GET",
            dataType: "json",
            success: function (data) {

                // Empty List
                $($leaderboardTopGroupsList).empty();

                // Loop
                $.each(jQuery.parseJSON(data.json), function (index, item) {

                    // Data Cache
                    var $data = {
                        group_name: "Test",
                        group_link: "http://test.com",
                        group_type: "Test",
                        group_id: item.group_id,
                        amount: item.amount
                    };

                    // Dynamic data key cache - avatar
                    if(item.group_avatar == null){
                        var $groupAvatar = '<img class="avatar avatar--md rounded" src="/assets/images/avatar.jpg">';
                    } else {
                        var $groupAvatar = '<img class="initialAvatar avatar avatar--md rounded" scr="' + item.group_avatar + '">';
                    }
                    $data["group_avatar"] = $groupAvatar;

                    // Get template
                    $.get('/api/leaderboard-topGroups-list-v000001.template', function (template) {
                        var $leaderboardTopGroupsTemplate = Mustache.render(template, $data);

                        // prepend it to list
                        $($leaderboardTopGroupsList).append($leaderboardTopGroupsTemplate);
                    });

                });

                // Replace .leaderboard__filter__current content
                $this.closest(".leaderboard__column").find(".leaderboard__filter__current").html($filterName);

            }
        });

    });
});