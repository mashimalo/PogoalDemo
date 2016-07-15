/*
 |--------------------------------------------------------------------------
 | Normalized
 |--------------------------------------------------------------------------
 */
// Uncheck checkbox default
$(function () {
    
    $('.checkbox-uncheck').find('input[type=checkbox]').prop('checked', false);
    $('input[type=checkbox].uncheck').prop('checked', false);
    $('input[type=checkbox].checked').prop('checked', true);

});


/*
 |--------------------------------------------------------------------------
 | Single Group Create Page Multiple Input
 |--------------------------------------------------------------------------
 */
(function ($) {

    $.fn.singleGroupCreatePage_multipleInput = function () {

        return this.each(function () {

            var $toolTipTitle = $(this).attr("title");

            // list of email addresses as unordered list
            $list = $('<ul />');

            // input
            var $input = $(
                // '<input id="group_email" class="form-control" type="email" name="group_email" placeholder="Email" data-show="tooltip" data-trigger="hover" data-placement="left" title="' + $toolTipTitle + '">' +
                '<input id="group_email" class="form-control" type="email" name="group_email" placeholder="Email" title="' + $toolTipTitle + '">' +
                '<span class="form-prepend-item icon icon-envelope"></span>'
            ).keyup(function (event) {

                if (event.which == 188) {
                    // key press is space or comma
                    var val = $(this).val().slice(0, -1); // remove space/comma from value

                    // validate email
                    if(isValidEmailAddress(val)){
                        // append to list of emails with remove button
                        $list.append($('<li class="multipleInput-email"><span>' + val + '</span></li>')
                            .append($('<a href="#" class="multipleInput-close" title="Remove"><span class="icon icon-cross"></span></a> ')
                                .click(function (e) {
                                    $(this).parent().remove();
                                    e.preventDefault();
                                })
                            )
                        );
                        $(this).attr('placeholder', 'Invite members');
                        // empty input
                        $(this).val('');
                    }
                }

            });

            // container div
            var $container = $('<div class="multipleInput" />').click(function () {
                $input.focus();
            });

            // insert elements into DOM
            $container.append($list).append($input).insertAfter($(this));

            // add onsubmit handler to parent form to copy emails into original input as csv before submitting
            var $orig = $(this);
            $(this).closest('form').submit(function (e) {

                var emails = new Array();
                $('.multipleInput-email span').each(function () {
                    emails.push($(this).html());
                });
                emails.push($input.val());

                $orig.val(emails.join());

            });

            return $(this).hide();

        });

    };
})(jQuery);

$('#group_email').singleGroupCreatePage_multipleInput();


/*
 |--------------------------------------------------------------------------
 | Rich Form
 |--------------------------------------------------------------------------
 */
$(function () {

    var $body = $("body");
    var $richFormInput = "textarea[data-elastic='rich-form']";
    var $hiddenDiv = $(document.createElement("div"));
    var $content = null;

    $hiddenDiv.addClass("textarea-fake");

    $body.on("click", $richFormInput, function () {

        $(this).parent(".rich-form-body").append($hiddenDiv);

    });

    $body.on("keyup", $richFormInput, function () {

        $content = $(this).val();
        $content = $content.replace(/\n/g, "<br>");
        $hiddenDiv.html($content + '<br>');

        $(this).css("height", $hiddenDiv.height() + 16);

    });

    $body.on("click", ".rich-form", function (e) {

        var $this = $(this);

        $this.find(".rich-form-body").addClass("active");

        $(document).on('click', function (e) {
            if (e.target !== $this && !$.trim($this.find($richFormInput).val())) {
                $this.find(".rich-form-body").removeClass('active');
            }
        });

        e.stopPropagation();

    });
});


/*
 |--------------------------------------------------------------------------
 | Elastic Textarea Form
 |--------------------------------------------------------------------------
 */
$(function () {

    var $body = $("body");
    var $elasticTextarea = "textarea[data-elastic='textarea']";
    var $hiddenDiv = $(document.createElement("div"));
    var $content = null;

    $hiddenDiv.addClass("textarea-fake");

    $body.on("click", $elasticTextarea, function () {

        $(this).closest('.elastic-textarea').append($hiddenDiv);

    });

    $body.on("keyup", $elasticTextarea, function () {

        $content = $(this).val();
        $content = $content.replace(/\n/g, "<br>");
        $hiddenDiv.html($content + '<br>');

        $(this).css("height", $hiddenDiv.height() + 16);

    });
});