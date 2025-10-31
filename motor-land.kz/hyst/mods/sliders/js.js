function slider_slide_redact(id,ids) {
	var data = new FormData();
	data.append('comand', 'get_slide_data');
	data.append('id', id);
	$.ajax({
		url: 'hyst/mods/sliders/proces',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data: data,
		type: 'post',
		success: function(res) {
			var res = JSON.parse(res);
			if (res.error == '2') {
				$('messagelog').append('<report die="'+Date.now()+'" error>'+res.message+'</report>');
			} else if (res.error == '3') {
				var rcon = $('#slider_slide_redact_con'+ids);
				rcon.find('input[name="id"]').val(id);
				rcon.find('input[name="sliders_href"]').val(res.data.href);
				rcon.find('input[name="sliders_name"]').val(res.data.buton);
				rcon.find('*[name="sliders_text"]').html(res.data.text);
				rcon.find('.admin_select_img_input').css({'background-image':'url('+res.data.image+')'});
				rcon.find('input[name="sliders_image"]').val(res.data.image);
				rcon.find('.admin_select_img_input').find('.admin_addimage_tip').html('');
				rcon.find('.admin_select_img_field').append('<div class="admin_file_cross"></div>');
				rcon.show();
				$(window).scrollTop(rcon.offset().top);
			}
		}
	});
}
