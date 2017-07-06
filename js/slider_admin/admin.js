jQuery(function($){
    /*
     * действие при нажатии на кнопку загрузки изображения
     * вы также можете привязать это действие к клику по самому изображению
     */
    $('body').on('click','.upload_image_button',function(){
        event.preventDefault();
        var button = $(this);
        var custom_uploader = wp.media({
            title: 'Select multiple files',
            button: {
                text: 'Insert'
            },
            multiple: true  // Тут и нужно установить true для мультизагрузки
        }).on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $(button).parent().prev().attr('src', attachment.url);
            var prev = $(button).prev();
            var attachments =custom_uploader.state().get('selection');
            // console.log();
            // $(button).prev().val(attachment.id);
            attachments.each(function (value) {
                var idImage = value.toJSON().id;
                button.prepend('<input type="hidden" name="uploader_custom[]" value="'+idImage+'">');
            })
        }).open();
    });
    /*
     * удаляем значение произвольного поля
     * если быть точным, то мы просто удаляем value у input type="hidden"
     */
    $('.remove_image_button').click(function(){
        var r = confirm("Confirm?");
        if (r == true) {
            var src = $(this).parent().prev().attr('data-src');
            $(this).parent().prev().attr('src', src);
            $(this).prev().prev().val('');
        }
        return false;
    });
});