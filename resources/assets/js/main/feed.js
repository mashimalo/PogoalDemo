$(function () {

    // Cache
    var $body = $("body");

    $body.on("click", ".uiFeed__footer__toggle", function () {

        $(this).siblings(".uiFeed__footer__mask").slideToggle("fast");

    });

    $body.on("click", ".uiFeed__footer .close", function () {

        $(this).parents(".uiFeed__footer__mask").slideToggle("fast");

    });
});


/*
 |--------------------------------------------------------------------------
 | Pinned
 |--------------------------------------------------------------------------
 */
// $(function () {
//     $(".uiFeed--pinned").on("click", function() {
//         $(this).removeClass("inactive");
//     });
// });