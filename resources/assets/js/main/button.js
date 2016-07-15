/*
 |--------------------------------------------------------------------------
 | createBtb
 |--------------------------------------------------------------------------
 */
$(function(){
    $(".createBtn").on("click", function () {
        $(".createBtn__list").toggleClass("active");
    });

    $(document).on("click", function (e) {
        if ($(e.target).is(".createBtn") == false) {
            $(".createBtn__list").removeClass("active");
        }
    });

    $(document).on("click", function (e) {
        if ($(e.target).is(".uiDropdown") == true) {
            $(".createBtn__list").removeClass("active");
        }
    });

    $('.uiDropdown').on("click", function () {
        if ($( ".createBtn__list" ).hasClass( "active" )) {
            $( ".createBtn__list" ).removeClass( "active" );
        }
    });
});