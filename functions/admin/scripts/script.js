jQuery(document).ready(function($) {
    var custom_uploader;

    $('.delete_row').click(function(){
        return confirm("Gostaria de deletar este item?");
    })
    
    $('#zflag_form_slide #upload_image_button').click(function(e) {

        e.preventDefault();

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            console.log(custom_uploader.state().get('selection').toJSON());
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#upload_image').val(attachment.url);
        });

        //Open the uploader dialog
        custom_uploader.open();
    });


    $('#zflag_form_galeria #upload_image_button').click(function(e) {

        e.preventDefault();

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            // console.log(custom_uploader.state().get('selection').toJSON());
            var ids = '', html_img = '';
            attachment = custom_uploader.state().get('selection').toJSON();
            $.each(attachment, function( index, value ) {
                if(ids != ''){
                  ids += ', '+value.id;
                }else{
                  ids = value.id;
                }
                
                if(value.sizes.thumbnail.url != '')
                html_img += "<img width='150' height='150' src='"+value.sizes.thumbnail.url+"'>";
            });
            console.log(html_img);
            $('#upload_image').val(ids);
            $('#zflag_bloco_galeria_imagens').html(html_img);
        });

        //Open the uploader dialog
        custom_uploader.open();
    });




});