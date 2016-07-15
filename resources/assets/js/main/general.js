// $(function(){
//     var $pogoal = "" +
//         "----------------------------------------> Join us? <----------------------------------------" + "\n" +
//         "\n" +
//         "         ///////////    //////////    ///////////   //////////    /////////    ////" + "\n" +
//         "        ////    ////  ////    ////  ////////////  ////    ////  ////    ////  ////" + "\n" +
//         "       ///////////   ////    ////  ////          ////    ////  ////////////  ////" + "\n" +
//         "      ////          ////    ////  ////    ////  ////    ////  ////    ////  ////" + "\n" +
//         "     ////          ////    ////  ////////////  ////    ////  ////    ////  ////////////" + "\n" +
//         "    ////           //////////    //////////    //////////   ////    ////   //////////" + "\n" +
//         "\n" +
//         "----------------------------------------> Join us? <----------------------------------------";
//     console.log($pogoal);
// });


/*
 |--------------------------------------------------------------------------
 | Page Loader
 |--------------------------------------------------------------------------
 */
$(function () {
    $(window).load(function () {
        $("#preloader").remove();
    });
});


/*
 |--------------------------------------------------------------------------
 | Initial Avatar
 |--------------------------------------------------------------------------
 */
function initialAvatar() {
    $('.initialAvatar.avatar--sm').initial({
        charCount: 1,
        fontSize: 10,
        fontWeight: 200,
        width: 30,
        height: 30
    });
    $('.initialAvatar.avatar--md').initial({
        charCount: 1,
        fontSize: 16,
        fontWeight: 200,
        width: 36,
        height: 36
    });
    $('.initialAvatar.avatar--lg').initial({
        charCount: 1,
        fontSize: 35,
        fontWeight: 200,
        width: 80,
        height: 80
    });
    $('.initialAvatar.avatar--xlg').initial({
        charCount: 1,
        fontSize: 45,
        fontWeight: 200,
        width: 96,
        height: 96
    });
    $('.initialAvatar.avatar--xxlg').initial({
        charCount: 1,
        fontSize: 50,
        fontWeight: 200,
        width: 135,
        height: 135
    });
    $('.initialAvatar.avatar--block ').initial({
        charCount: 1,
        fontSize: 20,
        fontWeight: 200,
        width: 60,
        height: 60
    });
}
$(function () {
    initialAvatar();
});


/*
 |--------------------------------------------------------------------------
 | nl2br
 |--------------------------------------------------------------------------
 */
$(function () {
    String.prototype.nl2br = function () {
        return this.replace(/\n/g, "<br />" + "\n");
    };
    String.prototype.br2nl = function () {
        return this.replace("<br>\n", "\n", "g");
    };
});


/*
 |--------------------------------------------------------------------------
 | Email Regex
 |--------------------------------------------------------------------------
 */
function isValidEmailAddress($email) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test($email);
};


/*
 |--------------------------------------------------------------------------
 | Not Available
 |--------------------------------------------------------------------------
 */
$(function () {
    $("body").off("click").on("click", "[data-action='not-available']", function () {

        // Cache
        var $notAvailableModal = $("body #not-available");
        var $this = $(this);

        // Add modal attribute to the button
        $this.attr("data-toggle", "modal");
        $this.attr("data-target", "#not-available");

        if ($notAvailableModal.length === 0 && !$this.hasClass("clicked")) {

            // Get Delete Feed Modal template, then append it to .uiFeed
            $.get('/api/not-available-modal-v000003.template', function (template) {
                    var $notAvailableModalTemplate = Mustache.render(template);
                    $("body").append($notAvailableModalTemplate);
                })
                .done(function () {
                    // Run the modal
                    $this.click();
                });
            // Add .clicked class to prevent event.
            $this.addClass("clicked");

        }

    });
});


/*
 |--------------------------------------------------------------------------
 | Toggle
 |--------------------------------------------------------------------------
 */
$(function () {
    $("body").on("click", "[data-action='toggle']", function () {
        var $this = $(this);
        var $target = $this.attr("data-target");

        $this.toggleClass("toggled");

        $($target).slideToggle();

    });
});


/*
 |--------------------------------------------------------------------------
 | Scroll to target
 |--------------------------------------------------------------------------
 */
$(function () {
    $("body").on("click", "[data-scroll='scroll']", function () {
        var $this = $(this);
        var $target = $this.attr("data-target");

        if(!$this.attr("data-scroll-offset")) {
            $('html, body').animate({
                scrollTop: $($target).offset().top - 60
            }, 1000);
        } else {
            $('html, body').animate({
                scrollTop: $($target).offset().top - 60 - $this.attr("data-scroll-offset")
            }, 1000);
        }

    });
});



/*
 |--------------------------------------------------------------------------
 | Toggle Cover
 |--------------------------------------------------------------------------
 */
$(function () {
    $("body").on("click", "[data-toggle='toggle-cover']", function () {

        // Cache
        var $this = $(this);
        var $coverSection = $("#sgp-cover-section");
        var $coverStatic = $coverSection.find(".cover__static");
        var $lastActivitySection = $("#sgp-last-activity-section");
        var $infoSection = $("#sgp-info-section");
        var $leftInfo = $(".sgp-left__info");

        if ($this.hasClass("toggled")) {
            $coverSection.animate({"height": "51px"});
            $coverStatic.hide();
            $infoSection.slideToggle();
            $lastActivitySection.slideToggle();
            $leftInfo.slideToggle();
            $this.removeClass("toggled");
        } else {
            $coverSection.animate({"height": "250px"});
            $coverStatic.show();
            $infoSection.slideToggle();
            $lastActivitySection.slideToggle();
            $leftInfo.slideToggle();
            $this.addClass("toggled");
        }
    });

});


/*
 |--------------------------------------------------------------------------
 | Single Group Create Page - Insert selected category to form from modal
 |--------------------------------------------------------------------------
 */
$(function () {

    var $body = $("body");
    var $groupCategoryButton = "#singleGroup-group-category-button";
    var $groupCategoryChangeButton = "#singleGroup-group-category-change-button";
    var $groupCategoryModal = "#singleGroup-group-category-modal";
    var $groupCategoryModalRadios = $($groupCategoryModal).find("input[type='radio']");

    $body.on("click", $groupCategoryButton, function () {
        $groupCategoryModalRadios.on("click",function () {
           $("#singleGroup-group-category-selected").text($("input[name=group_type_id]:checked").parent().text().trim());
            $($groupCategoryChangeButton).show();
            $($groupCategoryButton).hide();
        });
    });

});


/*
 |--------------------------------------------------------------------------
 | uiAlert Timeout
 |--------------------------------------------------------------------------
 */

$(function(){
    setTimeout(function () {
        $(".uiAlert").slideToggle(500, function () {
            $(this).hide();
        });
    }, 3000);
});