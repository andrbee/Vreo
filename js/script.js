$(function () {
	var campaignName = $('#numberIdPost').val();
	var protocol = location.protocol;
	var slashes = protocol.concat("//");
	var host = slashes.concat(window.location.hostname);
	var dropbox = $('#dropbox'),
		message = $('.message', dropbox);

	dropbox.filedrop({
		// The name of the $_FILES entry:
		paramname:'pic',

		maxfiles: 5,
    	maxfilesize: 3,
		url: host+'/wp-content/themes/metronic/inc/post_file.php?number='+ campaignName,
		
		uploadFinished:function(i,file,response){
			$.data(file).addClass('done');
			// response is the JSON object that post_file.php returns
		},
		
    	error: function(err, file) {
			switch(err) {
				case 'BrowserNotSupported':
					showMessage('Your browser does not support HTML5 file uploads!');
					break;
				case 'TooManyFiles':
					alert('Too many files! Please select 5 at most! (configurable)');
					break;
				case 'FileTooLarge':
					alert(file.name+' is too large! Please upload files up to 3mb (configurable).');
					break;
				default:
					break;
			}
		},
		
		// Called before each upload is started
		beforeEach: function(file){
			if(!file.type.match(/^image\//)){
				alert('Only images are allowed!');
				
				// Returning false will cause the
				// file to be rejected
				return false;
			}
		},
		
		uploadStarted:function(i, file, len){
			createImage(file);
		},
		
		progressUpdated: function(i, file, progress) {
			$.data(file).find('.progress').width(progress);
		}
    	 
	});
	
	var template = '<div class="preview">'+
						            '<span class="imageHolder">'+
							'<img />'+
							'<span class="uploaded"></span>'+
						'</span>'+
						'<div class="progressHolder">'+
							'<div class="progress"></div>'+
						'</div>'+'<input type="hidden" class="slideName" name="" value="">'+'<input type="hidden" class="slideSize" name="" value="">'+
						'<button class="btn delete" name="slider[]" value="">Delete</button>'+
						 '</div>';




	function createImage(file){
		var preview = $(template),
			image = $('img', preview),
			button = $('button', preview),
			slideName = $('input.slideName', preview),
			slideSize = $('input.slideSize', preview);

		var reader = new FileReader();
		
		image.width = 100;
		image.height = 100;
		
		reader.onload = function(e){
			
			// e.target.result holds the DataURL which
			// can be used as a source of the image:
			image.attr('src',e.target.result);
			button.attr('value', file.name);
			slideName.attr('name', "slider["+file.name+"][name]");
			slideName.attr('value', file.name);
			slideSize.attr('name', "slider["+file.name+"][size]");
			slideSize.attr('value', file.size);

		};
		
		// Reading the file as a DataURL. When finished,
		// this will trigger the onload function above:
		console.log(reader.readAsDataURL(file));

		
		message.hide();
		preview.appendTo(dropbox);
		
		// Associating a preview container
		// with the file, using jQuery's $.data():
		
		$.data(file,preview);
	}

	function showMessage(msg){
		message.html(msg);
	}

});
$(document).ready(function() {

	var protocol = location.protocol;
	var slashes = protocol.concat("//");
	var host = slashes.concat(window.location.hostname);

	var campaignName2 = $('#numberIdPost').val();


	$('body').on('click','#dropbox .delete',function(){
		event.preventDefault();
		var parent = $(this).parent();
		parent.addClass('pulse');
		var campaignNameFile = $(this).val();
		$.get(host+'/wp-content/themes/metronic/inc/delfile.php?number='+campaignName2+'&namefile='+campaignNameFile,function (response) {
			if(response==true){
				parent.remove();
			} else {
				parent.removeClass('pulse');
			}
		});
	});
	$('body').on('click','#dropbox .deleteEdit',function(){
		event.preventDefault();
		var parent = $(this).parent();
		parent.addClass('pulse');
		var idPost=$(this).siblings('.idPost').val();
		var Key = $(this).val();
		$.get(host+'/wp-content/themes/metronic/inc/deleteSlideCampaign.php?Key='+Key+'&idPost='+idPost,function (response) {
			if(response==true){
				parent.remove();
			} else {
				parent.removeClass('pulse');
			}
		});
	});


});