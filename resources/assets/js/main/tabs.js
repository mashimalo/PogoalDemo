// Tabs :: requires Bootstrap JS
$(function(){
    $('a[data-toggle="tab"]').click(function (e) {
        e.preventDefault();
        $(this).tab('show')
    });
});