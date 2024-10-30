jQuery(function($){


	// tabs realted 
	$("#rem-settings-form .panel-default").hide().first().show();
	$(".wcp-tabs-menu a:first").addClass("active");
	$(".wcp-tabs-menu a").on('click', function (e) {
	   e.preventDefault();
	   $(this).addClass("active").siblings().removeClass("active");
	   $($(this).attr('href')).show().siblings('.panel-default').hide();
	});
	var hash = $.trim( window.location.hash );
	if (hash) $('.wcp-tabs-menu a[href$="'+hash+'"]').trigger('click');

	$('.colorpicker').wpColorPicker();

	$("#rem-color-settings-form").submit(function(event){
		event.preventDefault();
		
		var form_data = $(this).serialize();
		console.log(form_data);
		$.post(ajaxurl, form_data, function(resp){
			
			swal("Enjoy!", resp, "success");
		});
	});
});