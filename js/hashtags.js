/**
 * Created by Andrey on 09.02.2017.
 */
$(document).ready(function () {

    $('input.hashtags').keypress(function(eventObject){
        var bool=false;

        // console.log(String.fromCharCode(event.charCode));
        // console.log(eventObject.key);
        if (eventObject.key === 'Enter') {
            var calHash = $(".hashtag__item").length;
            if (calHash <= 5){
            var input = $(this);
            var value = input.val();
            if(!$('*').is('.hashtag__item')){
                $("li.hashtag__input").before(
                    "<li class='hashtag__item'>"+
                    "<input type='hidden' class='hashtag-text' name='campaign-hash[]' value='#"+value+"'>"+value+" "+
                    "<span class='hashtag-close'>˟</span>"+"</li>"
                );
                $(this).val("");
                $(this).removeAttr('required');

            } else {
                $('.hashtag__item').each(function(indx, el) {
                    console.log($(el).children().val());
                    if($(el).children().val()===("#"+value)){
                        bool=false;
                        return false;
                    } else {
                        bool=true;
                    }
                });
                if(bool) {
                    $("li.hashtag__input").before(

                        "<li class='hashtag__item'>"+
                        "<input type='hidden' class='hashtag-text' name='campaign-hash[]' value='#"+value+"'>"+value+" "+
                        "<span class='hashtag-close'>˟</span>"+"</li>"
                    );
                    $(this).val("");
                    $(this).removeAttr('required');
                }
            }


            $('li.hashtag__item span.hashtag-close').on('click',function(){
                $(this).parent().remove();
                if(!$('.hashtag__list').is('.hashtag__item')){
                    $('input.hashtags').prop('required',true);
                }
            });
        }
        }

    });
    $(".input__hashtags").keypress(function(e){
        if(e.key==='Enter') return false;
    });
    $('li.hashtag__item span.hashtag-close').on('click',function(){
        $(this).parent().remove();
        if(!$('.hashtag__list').is('.hashtag__item')){
            $('input.hashtags').prop('required',true);
        }
    });
    
});
