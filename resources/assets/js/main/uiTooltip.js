// Enable tooltips
$(document).ready(function(){
    $('[data-show="tooltip"]').tooltip();
});

// Hide tooltip on click
$(".uiTooltip--hide").click(function(){
    $(".uiTooltip").tooltip('hide');
});