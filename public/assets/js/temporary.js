$(function(){
    $('#pictureupload').change(setLogoRegistration);

    function setLogoRegistration(){

        $dst = $('#picture-preview').html("<img />");
        $dst.children('img').attr('src',$('#picture').val());
    };
    setLogoRegistration();

    $('body').delegate('#pictureupload','change', function(){
        var data = new FormData();
        data.append("image",$(this).prop('files')[0]);
        var options = {
            url: $(this).data('url'),
            method: "post",
            processData: false, // important
            contentType: false, // important
            data: data,
            dataType: "json",
            success:function(response, statusText, xhr, $form)
            {
                $('#picture').val(response.file).change();
                console.log('Upload Complete');
            },
            beforeSend: function(){
                $('body').addClass('ajaxActive');
                console.log('Uploading Image...');
            },
            complete: function(){
                $('body').removeClass('ajaxActive');
            }
        };
        $.ajax(options);
    });
});