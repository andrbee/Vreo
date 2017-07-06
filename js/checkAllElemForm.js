function checkAllElemForm(form, event) {
    var countSlides = $('.preview.done').length;
    var picAdver=$('#pic-number-campaign');
    var videoAdver=$('#video-number-campaign');
    if (!countSlides) {
        $('#dropbox').css("border", "2px solid red");
        var destination = $("#dropbox").offset().top;
        scroll(destination);
        return false;
    } else if(Number(picAdver.val())==0 && Number(videoAdver.val())==0){
        picAdver.css("border", "2px solid red");
        videoAdver.css("border", "2px solid red");
        var offset = picAdver.offset().top;
        console.log(offset);
        scroll(offset);
        return false;
    } else {
        return;

    }

    function scroll(offset) {
        var navbar=$(".navbar-fixed-top").outerHeight();
        $('body').animate({scrollTop: offset-(navbar*2)}, 800);
    }


}