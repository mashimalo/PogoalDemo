// Portal Modal
// $( "#toolbar-login" ).click(function() {
//     $( "#login-modal" ).addClass( "active" );
// });
//
// $( "#toolbar-signup" ).click(function() {
//     $( "#signup-modal" ).addClass( "active" );
// });
//
// $( "#switch-to-login" ).click(function() {
//     $( "#login-modal" ).toggleClass( "active" );
//     $( "#signup-modal" ).toggleClass( "active" );
// });
//
// $( "#switch-to-signup" ).click(function() {
//     $( "#login-modal" ).toggleClass( "active" );
//     $( "#signup-modal" ).toggleClass( "active" );
// });
//
// $('#portal-modal').on('hidden.bs.modal', function () {
//     if ($( "#login-modal" ).hasClass( "active" )) {
//         $( "#login-modal" ).removeClass( "active" );
//     }
//
//     if ($( "#signup-modal" ).hasClass( "active" )) {
//         $( "#signup-modal" ).removeClass( "active" );
//     }
// });

/*
|--------------------------------------------------------------------------
| Keep Modal Center of Screen
|--------------------------------------------------------------------------
*/

// $("button[data-toggle='modal']").on("click", function () {
//
//     var thisAttribute = $(this).attr("data-target");
//     // var objectHeight = $(thisAttribute).height();
//     var screenHeight = $(window).height();
//
//     var marginTop = screenHeight * 0.2;
//
//     $(thisAttribute).find(".uiModal__dialog").css("margin-top", marginTop);
//
// });