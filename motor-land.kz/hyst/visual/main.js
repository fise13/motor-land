function interfaceform_validate(e) {
	var reg = false, t = $(e).attr('check'); 
	if (e.nodeName.toLowerCase() == 'wysiwygarea') {
	v = $(e).html();
	} else {
	v = $(e).val();
	}
	if ($(e).attr('mandatory') !== undefined || $(e).val() != '') {
		if (t == 'name') { 
			var r = /^[\p{L}\p{N}\s\.,\-_]+$/u;
			if (r.test(v)) { reg = true;  } else { reg = false; }
		} else if (t == 'email') {
			var r = /^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/;
			if (r.test(v)) { reg = true;  } else { reg = false; }
		} else if (t == 'title') {
			var r = /^[\p{L}\p{N}\s\.,\-_'"()\[\]{}%№]+$/u;
			if (r.test(v)) { reg = true;  } else { reg = false; }
		} else if (t == 'password') {
			var r = /^[A-Za-z0-9\.\-_#@$\%^&*]{6,}$/;
			if (r.test(v)) { reg = true;  } else { reg = false; }
		} else if (t == 'nick_tag') {
			var r = /^[A-Za-z0-9\.\-_]+$/;
			if (r.test(v)) { reg = true;  } else { reg = false; }
		} else if (t == 'number') {
			var r = /^[0-9]+$/;
			if (r.test(v)) { reg = true;  } else { reg = false; }
		} else if (t == 'mirror') {
			if (v == $(e).closest('interfaceform').find('*[name="'+$(e).attr('mirror')+'"]').val()) { reg = true;  } else { reg = false; }
		} else if (t == 'none') {
			reg = true;
		} else if (t == 'file') {
			if (v != '') {
				var file = e.files[0];
				var fileExtension = file.name.split('.').pop().toLowerCase();
				var valid_typesArray = $(e).closest('.admin_image_label').attr('data-allowed').split(',').map(function(extension) {
					return extension.trim();
				}); 
				if ($.inArray(fileExtension, valid_typesArray) < 0) {
				
				} else {
					reg = true;
				}
			}
		}
		
		if (reg) {
			if ($(e).attr('length') !== undefined) {
				if (Array.from($(e).attr('length'))[0] == '>') {
					if ($(e).val().length > parseInt($(e).attr('length').substring(1))) { return '1'; } else { return '21';}
				} else if (Array.from($(e).attr('length'))[0] == '<') {
					if ($(e).val().length < parseInt($(e).attr('length').substring(1))) { return '1'; } else { return '22';}
				} else {
					if ($(e).val().length == parseInt($(e).attr('length').substring(1))) { return '1'; } else { return '23';}
				}
			} else {
				return '1';
			}
		} else {
		return '3';
		}
	}
}

function show_modal(content,width_class=false) {
	$('modalwindow').html(content);
	if (width_class) {
	$('modalwindow').addClass(width_class);
	}
	$('modalbg, modalwindow').fadeIn(100);
}

function get_cooke_val(name) {
    var cookies = document.cookie.split(';'); 
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim();    
        if (cookie.indexOf(name + '=') === 0) {
            return cookie.substring(name.length + 1);
        }
    }
    return false;
}

function get_mediafiles_modal (unic){
	var data = new FormData();
	data.append('comand','get_mediafiles_modal');
	data.append('unic',unic);
	$.ajax({
		url: '/hyst/core/admin_profile',
		dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data: data,
		type: 'post',
		success: function(res) {
			
			var htm = `<div class="hyst_imageselect_modal"><div class="hyst_all_zoomerrel"><div class="hyst_all_zoomclose"></div>
			<div class="hyst_all_zoomcontainer">`+res+`</div></div></div>`;
			$('.hyst_modal_generatorcontainer').html(htm);
			$('.hyst_modal_generatorcontainer').show();
			
		}
	});
}

function hyst_setup_image(url,unic) {
	if ($('*[unic-return="'+unic+'"]').attr('multiple') !== undefined) {
		$('.hyst_modal_generatorcontainer').hide();
		$('.hyst_modal_generatorcontainer').html('');
		var inp = $('*[unic-return="'+unic+'"]').closest('.admin_file_label_wraper').find('input');
		inp.val((inp.val()==''?'':inp.val()+',')+url);
		$('*[unic-return="'+unic+'"]').closest('.admin_file_label_wraper').find('.admin_img_field_sortable').append('<div style="background-image: url('+url+');" class="admin_multiple_image_select"><div data-delet="'+url+'" class="admin_file_cross_multiple"></div></div>');
	} else {
		$('.hyst_modal_generatorcontainer').hide();
		$('.hyst_modal_generatorcontainer').html('');
		$('*[unic-return="'+unic+'"]').closest('.admin_file_label_wraper').find('input').val(url);
		$('*[unic-return="'+unic+'"]').closest('.admin_file_label_wraper').append('<div class="admin_file_cross"></div>');
		$('*[unic-return="'+unic+'"]').closest('.admin_select_img_field').find('.admin_select_img_input').css('background-image', 'url(' + url + ')');
		$('*[unic-return="'+unic+'"]').closest('.admin_select_img_field').find('.admin_addimage_tip').html('');
	}
}

function include_tag(act,target_area) {
	var tag;
	if (act.attr('action') == 'strike' || act.attr('action') == 'underline' || act.attr('action') == 'italic' || act.attr('action') == 'bold') {
		
		if (act.attr('action') == 'strike') { tag = 's';}
		else if (act.attr('action') == 'underline') { tag = 'u';}
		else if (act.attr('action') == 'italic') { tag = 'i';}
		else if (act.attr('action') == 'bold') { tag = 'b';}
		var tag = document.createElement(tag);
		
	} else if (act.attr('action') == 'align-left' || act.attr('action') == 'align-center' || act.attr('action') == 'align-right') {
		tag = document.createElement('p');
		if (act.attr('action') == 'align-left') { tag.style.textAlign = 'left'; } 
		else if (act.attr('action') == 'align-center') { tag.style.textAlign = 'center'; }
		else if (act.attr('action') == 'align-right') { tag.style.textAlign = 'right'; }
	} else if (act.attr('action') == 'link') {
		tag = document.createElement('a');
		tag.href = prompt('Введите ссылку');
	} else if (act.attr('action') == 'img') {
		tag = document.createElement('img');
		tag.src = prompt('Введите ссылку на изображение');
		tag.width = prompt('Введите ширину (px) целым числом');
	} 
	
	tag.innerHTML = '&#8203;';
	target_area.append(tag);
	var range = document.createRange();
	range.setStart(tag.firstChild, 0);
	range.setEnd(tag.firstChild, 0);
	var selection = window.getSelection();
	selection.removeAllRanges();
	selection.addRange(range);
	target_area.focus();
}

function hyst_setup_woosywog (e) {
	var htm = `<hystwysiwyg>
	<redactorbar>
		<button action="bold">B</button>
		<button action="italic"><i>i</i></button>
		<button action="underline"><u>U</u></button>
		<button action="strike"><s>S</s></button>
		<select action="font-size">
			<option>6px</option>
			<option>7px</option>
			<option>8px</option>
			<option>9px</option>
			<option>10px</option>
			<option>11px</option>
			<option>12px</option>
			<option selected>14px</option>
			<option>16px</option>
			<option>18px</option>
			<option>20px</option>
			<option>22px</option>
			<option>24px</option>
			<option>26px</option>
			<option>28px</option>
			<option>30px</option>
			<option>34px</option>
			<option>38px</option>
			<option>42px</option>
			<option>46px</option>
			<option>50px</option>
			<option>56px</option>
			<option>62px</option>
			<option>68px</option>
			<option>74px</option>
			<option>80px</option>
			<option>88px</option>
			<option>96px</option>
			<option>104px</option>
			<option>112px</option>
			<option>120px</option>
		</select>
		<button action="align-left"></button>
		<button action="align-center"></button>
		<button action="align-right"></button>
		<button action="link"></button>
		
		<button action="img"></button>
	</redactorbar>
	`+e.outerHTML.replace(/^<wysiwygarea/, '<wysiwygarea contenteditable="true"');+`
	</hystwysiwyg>`;
	
	return htm;
}

setInterval(function() {
    var currentTime = Date.now();
    $('report').each(function() {
        var dieTime = parseInt($(this).attr('die'), 10);
        if (dieTime < currentTime - 4000) {
            $(this).fadeOut();
        }
		
		if ($(this).css('display') == 'none') {
		$(this).detach();
		}
    });
}, 1000);




$(document).ready(function () {
	
$( ".admin_img_field_sortable" ).sortable({
	
	update: function(event, ui) {
        var images = '';
        $(".admin_img_field_sortable .admin_multiple_image_select").each(function(index,elm) {
            if (images == '') {
			images += $(elm).attr('style').match(/url\(["']?(.*?)["']?\)/)[1];
			} else {
			images += ','+$(elm).attr('style').match(/url\(["']?(.*?)["']?\)/)[1];
			}
        });
		$(this).closest('.admin_file_label_wraper').find('input[type="hidden"]').val(images);
    }

});	
	
	
$('wysiwygarea').each(function() {
	$(this).replaceWith(hyst_setup_woosywog(this)); 
});


$(document).on('input','input[type="password"]', function() {
	if ($(this).attr('savewrong') !== undefined && $(this).val() != '') {
		
		var r = /^[A-Za-z0-9\.\-_#@$\%^&*]*$/;
		if (!r.test($(this).val())) { $(this).val($(this).val().slice(0, -1)); }
	}
});

$('#sidebarbutton').on('change', function() {
	if ($(this).is(':checked')) { document.cookie = "sidebarbutton=true"; } else { document.cookie = "sidebarbutton=false"; }
});

$(document).on('change','input[data-rms="primary"]', function () {
	if ($(this).is(':checked')) {
	$(this).closest('.hust_general_user_roles').find('input[data-rms="secondary"]').prop('checked', false);
	$(this).closest('.hust_general_user_roles').find('input[data-rms="secondary"]').prop('disabled', true);
	$(this).closest('.hust_general_user_roles').find('input[data-rms="secondary"]').parent('.admin_label_checkbox').css({'opacity':'0.3'});
	} else {
	$(this).closest('.hust_general_user_roles').find('input[data-rms="secondary"]').prop('disabled', false);
	$(this).closest('.hust_general_user_roles').find('input[data-rms="secondary"]').parent('.admin_label_checkbox').css({'opacity':'1'});
	}
});


$(document).on('blur','interfaceform input[check]',function() {
	if ($(this).attr('check') !== undefined && $(this).attr('type') != 'file') {
	var res = interfaceform_validate(this);
	$(this).closest('iw').find('iv').detach(); 
		if (Array.from(res)[0] == 3) {
			$(this).closest('iw').append('<iv error><message>'+($(this).attr('error') !== undefined?$(this).attr('error'):'Не допустимые символы!')+'</message></iv>');
		} else if (Array.from(res)[0] == 2) {
			switch(res) {
				case '21': var mes = 'Должно быть длиннее чем '+$(this).attr('length').substring(1)+' символов!'; break;
				case '22': var mes = 'Должно быть короче чем '+$(this).attr('length').substring(1)+' символов!'; break;
				default: var mes = 'Длина должна быть ровна '+$(this).attr('length').substring(1)+' символам!'; break;
			}
			$(this).closest('iw').append('<iv error><message>'+mes+'</message></iv>');
		} else {
			$(this).closest('iw').append('<iv right></iv>');
		}
	}
});
 
$(document).on('click', 'interfaceform input[role="submit"]',function() { 
	var confirmed = true;
	if ($(this).attr('confirm-prompt') !== undefined) {
		if (prompt($(this).attr('confirm-prompt'))!= $(this).attr('confirm-prompt').match(/'(.*?)'/)[1]) {
		confirmed = false;
		}
	}
	
	if ($(this).attr('confirm-yesno') !== undefined) {
		if (!confirm($(this).attr('confirm-yesno'))) {
		confirmed = false;
		}
	}

	if (confirmed) {
		var validate = true, data = new FormData();
		$(this).closest('interfaceform').find('input, select, textarea, wysiwygarea').each(function() {
		
			if ($(this).closest('*[data-select-show]').length == 0 || ($(this).closest('*[data-select-show]').length != 0 && $(this).closest('*[data-select-show]').css('display') != 'none')) {
				if ($(this).attr('mandatory') !== undefined || $(this).val() != '') {
					if ($(this).attr('type') != 'button' && $(this).attr('type') != 'checkbox' && $(this).attr('type') != 'radio') {
						
						if ($(this).is('input') || $(this).is('textarea')) { 
						$(this).closest('iw').find('iv').detach();
							if ($(this).attr('check') !== undefined) {
							var res = interfaceform_validate(this);
							 
								if (Array.from(res)[0] == 3) {
									$(this).closest('iw').append('<iv error><message>'+($(this).attr('error') !== undefined?$(this).attr('error'):'Не допустимые символы!')+'</message></iv>');
									validate = false;
								} else if (Array.from(res)[0] == 2) {
									switch(res) {
										case '21': var mes = 'Должно быть длиннее чем '+$(this).attr('length').substring(1)+' символов!'; break;
										case '22': var mes = 'Должно быть короче чем '+$(this).attr('length').substring(1)+' символов!'; break;
										default: var mes = 'Длина должна быть ровна '+$(this).attr('length').substring(1)+' символам!'; break;
									}
									$(this).closest('iw').append('<iv error><message>'+mes+'</message></iv>');
									validate = false;
								} else {
									$(this).closest('iw').append('<iv right></iv>');
								}
							}
							
							if ($(this).attr('mandatory') !== undefined && $(this).val() == '') {
								validate = false;
								$(this).closest('iw').append('<iv error><message>Обязательное поле!</message></iv>');
							}
						}
					}
				}
			}
			
		});
		
		$(this).closest('interfaceform').find('.admin_group_checkboxes').each(function() {
			if ($(this).attr('mandatory') !== undefined && $(this).val() == '') {
				$(this).closest('.admin_group_checkboxes').find('iv').detach();
				if ($(this).find('input[type="checkbox"]:checked').length == 0) {
					$(this).closest('.admin_group_checkboxes').find('.admin_group_checkboxes_title').append('<iv class="left" error><message>Обядательно нужно выбрать хотя бы один параметр!</message></iv>');
					validate = false;
				} else {
					$(this).closest('.admin_group_checkboxes').find('.admin_group_checkboxes_title').append('<iv class="left" right></iv>');
				}
			}
		});
		
		if (validate) {
			data.append('comand', $(this).attr('name'));
			
			var massive_data = {};
			
			$(this).closest('interfaceform').find('input, select, textarea, wysiwygarea').each(function() {
				if ($(this).closest('repeater').length == 0) {
					
					if ($(this).attr('name') !== undefined && $(this).attr('name').endsWith("[]")) {
						
						if ($(this).is('wysiwygarea')) {
							var mval = $(this).html();
						} else {
							if ($(this).attr('type') != 'file' && $(this).attr('type') != 'button' && $(this).attr('type') != 'checkbox' && $(this).attr('type') != 'radio' && $(this).attr('name') !== undefined) {
							var mval = $(this).val(); 
							} else if ($(this).attr('type') == 'file') {
							var mval = $(this).prop("files")[0]; 
							}	
						}
						if (mval !== undefined) {
							var name = $(this).attr('name').slice(0, -2);
							if (name in massive_data) {
								massive_data[name].push(mval);
							} else {
								massive_data[name] = [];
								massive_data[name].push(mval);
							}
						}
					} else {
						if ($(this).is('wysiwygarea')) {
							data.append($(this).attr('name'), $(this).html());
						} else {
							if ($(this).attr('type') != 'file' && $(this).attr('type') != 'button' && $(this).attr('type') != 'checkbox' && $(this).attr('type') != 'radio' && $(this).attr('name') !== undefined) {
							data.append($(this).attr('name'), $(this).val());
							} else if ($(this).attr('type') == 'file') {
							data.append($(this).attr('name'), $(this).prop("files")[0]);
							} else if ($(this).attr('type') == 'radio') { 
								if ($(this).is(':checked')) { 
									data.append($(this).attr('name'), $(this).val());	
								}
							}
						}
					}
				}
			});
			
			$(this).closest('interfaceform').find('input[type="checkbox"]').each(function() {
				if ($(this).closest('.admin_group_checkboxes').length == 0 && $(this).closest('repeater').length == 0) {
					
					if ($(this).attr('name') !== undefined && $(this).attr('name').endsWith("[]")) {	
						if ($(this).is(':checked')) {
							if ($(this).val() !== undefined) {
							var mval = $(this).val();
							} else {
							var mval = 'true';
							}
							
							var name = $(this).attr('name').slice(0, -2);
							if (name in massive_data) {
								massive_data[name].push(mval);
							} else {
								massive_data[name] = [];
								massive_data[name].push(mval);
							}
						} 
						
					} else {
						if ($(this).is(':checked')) {
							if ($(this).val() !== undefined) {
							data.append($(this).attr('name'), $(this).val());
							} else {
							data.append($(this).attr('name'), 'true');
							}
						} 
					}
				}
			});
			
			$(this).closest('interfaceform').find('.admin_group_checkboxes').each(function(i,e) {
				var curent_box = [];
				$(e).find('input[type="checkbox"]').each(function() {
					if ($(this).is(':checked')) {
					curent_box.push($(this).val());
					} 
				});
				data.append($(this).attr('name'), curent_box);
			});
			
			
			$(this).closest('interfaceform').find('repeater').each(function(i,e) {
				var repeater_name = $(e).attr('name'), repeater_data = []; curent = {};
				$(e).find('repeats').find('.admin_repeat_items_flex').each(function(ix,el){
					curent = {};
					$(el).find('input').each(function(inx,elm){	
						curent[$(elm).attr('name')] = $(elm).val();
					});
					repeater_data.push(curent); 
				});
				data.append(repeater_name, JSON.stringify(repeater_data));
				
			});
			

			if (Object.keys(massive_data).length > 0) {
				for (var key in massive_data) {
					if (massive_data.hasOwnProperty(key)) {
						data.append(key, massive_data[key].join(','));
					}
				}
			}
			
			
			var interf = $(this);
			$.ajax({
				url: $(this).closest('interfaceform').attr('target'),
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
					} else if (res.error == '1') {
						location.href='';
					} else if (res.error == '3') {
						$('messagelog').append('<report die="'+Date.now()+'" right>'+res.message+'</report>');
						if (res.visual_changes != undefined) {
							for (var element in res.visual_changes) {
								$(element).html(res.visual_changes[element]);
							}
						}
						if (res.inserted_html != undefined) {
							for (var element in res.inserted_html) {
								$(element).prepend(res.inserted_html[element]);
							}
						}
						if (res.delete_item != undefined) {
							$(res.delete_item).detach();
						}
						if (res.clear != undefined) {
							interf.closest('interfaceform').find('input, select, textarea, wysiwygarea').each(function() {
								if ($(this).attr('type') != 'button' &&  $(this).attr('unclear') === undefined) {
									if ($(this).attr('type') == 'checkbox') {
										$(this).attr('checkbox',false);
									} else {
										if (this.nodeName.toLowerCase() == 'wysiwygarea') {
										$(this).html('');
										} else {
										$(this).val('');
										}
										
										if ($(this).attr('type') == 'file' || $(this).closest('.admin_select_img_field').length) {
											$(this).closest('.admin_file_label_wraper').find('.admin_select_img_input').css('background-image', 'none');
											$(this).closest('.admin_file_label_wraper').find('.admin_image_label').css('background-image', 'none');
											$(this).closest('.admin_file_label_wraper').find('.admin_select_img_input').find('.admin_addimage_tip').html('+<span>'+$(this).closest('.admin_file_label_wraper').find('.admin_select_img_input').attr('data-tip')+'</span>');
											$(this).closest('.admin_file_label_wraper').find('.admin_image_label').find('.admin_addimage_tip').html('+<span>'+$(this).closest('.admin_file_label_wraper').find('.admin_image_label').attr('data-tip')+'</span>');
											$(this).closest('.admin_file_label_wraper').find('.admin_file_cross').detach();
										}
									}
								}
							});
						}
						if (res.close_modal != undefined) {
							$('modalbg, modalwindow').fadeOut(100);
							$('modalwindow').html('');
							$('modalwindow').removeClass();
						}
						if (res.css_changes != undefined) {
							for (var element in res.$item_pct) {
								for (var i = 0; i < res.$item_pct[element].length; i += 2) {
									var property = res.$item_pct[element][i];
									var value = res.$item_pct[element][i + 1];
									$(element).css(property, value);
								}
							}
						}
					} else {
					alert(res);
					}
				}
			});
		}
	}
});

$('select[name="orederby"]').on('change', function() {
	var url = window.location.href;
    if (url.indexOf('sort_by=') !== -1) {
        url = url.replace(/sort_by=[^&]+/, 'sort_by='+$(this).find('option:selected').val());
    } else {
        url += (url.indexOf('?') !== -1 ? '&' : '?') + 'sort_by='+$(this).find('option:selected').val();
    }
    window.location.href = url;
});


$('.image_select_interctiv input[type="file"]').on('change', function() {

	var data = new FormData();
	data.append('image', $(this).prop("files")[0]);
	data.append('comand', $(this).attr('comand'));
	$.ajax({
		url: $(this).attr('target'),
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
			} else if (res.error == '1') {
				location.href='';
			} else if (res.error == '3') {
				$('messagelog').append('<report die="'+Date.now()+'" right>'+res.message+'</report>');
				if (res.visual_changes != undefined) {
					for (var element in res.visual_changes) {
						$(element).html(res.visual_changes[element]);
					}
				}
				if (res.inserted_html != undefined) {
					for (var element in res.inserted_html) {
						$(element).prepend(res.inserted_html[element]);
					}
				}
				if (res.delete_item != undefined) {
					$(res.delete_item).detach();
				}
				
			} else {
			alert(res);
			}
		}
	});	
});

$(document).on('click','modalbg, modalbg cross',function () {
	$('modalbg, modalwindow').fadeOut(100);
	$('modalwindow').html('');
	$('modalwindow').removeClass();
});

$(document).on('keypress', 'interfaceform input',function() { 
	if (event.which == 13) {
	$(this).closest('interfaceform').find('input[role="submit"]').click();
	}
});


$(document).on('change', '.admin_image_label input',function() { 
	var input = this;
	
	if (input.files && input.files[0]) {
		var file = input.files[0];
		var fileType = file.type;
		var fileExtension = file.name.split('.').pop().toLowerCase();
		var valid_types = $(input).closest('.admin_image_label').attr('data-allowed');
		var valid_typesArray = valid_types.split(',').map(function(extension) {
			return extension.trim();
		});
		
		if ($.inArray(fileExtension, valid_typesArray) < 0) {
			$('messagelog').append('<report die="'+Date.now()+'" error>Не допустимый формат файла, нужно выбрать: '+valid_types+'</report>');
			input.value = '';
		} else {
			
		$(input).closest('.admin_image_label').css('background-image', 'none');
		$(input).closest('.admin_image_label').find('.admin_addimage_tip').html('');
			
			$(input).closest('.admin_file_label_wraper').append('<div class="admin_file_cross"></div>');
		
			var validImageTypes = ['image/svg+xml', 'image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
			 
			if ($.inArray(fileType, validImageTypes) < 0) {

				$(input).closest('.admin_image_label').find('.admin_addimage_tip').html('.'+fileExtension+'<span>'+file.name+'</span>');
			} else {
			
				var reader = new FileReader();
				reader.onload = function(e) {
					$(input).closest('.admin_image_label').css('background-image', 'url(' + e.target.result + ')');
					$(input).closest('.admin_image_label').find('.admin_addimage_tip').html('');
				};
				reader.readAsDataURL(input.files[0]);
			}
		}
	}
});

$(document).on('click', '.admin_file_cross',function() { 
	$(this).closest('.admin_file_label_wraper').find('.admin_image_label').css('background-image', 'none');
	$(this).closest('.admin_file_label_wraper').find('.admin_select_img_input').css('background-image', 'none');
	$(this).closest('.admin_file_label_wraper').find('.admin_select_img_input').find('.admin_addimage_tip').html('+<span>'+$(this).closest('.admin_file_label_wraper').find('.admin_select_img_input').attr('data-tip')+'</span>');
	$(this).closest('.admin_file_label_wraper').find('.admin_image_label').find('.admin_addimage_tip').html('+<span>'+$(this).closest('.admin_file_label_wraper').find('.admin_image_label').attr('data-tip')+'</span>');
	$(this).closest('.admin_file_label_wraper').find('input').val('');
	$(this).detach();
});

$(document).on('click', '.admin_file_cross_multiple',function() { 
	var val = $(this).closest('.admin_file_label_wraper').find('input').val(), new_val = '', data_delet = $(this).attr('data-delet'); 
	val = val.split(','); 
	val.forEach(function(e,i){ console.log(e+' != '+$(this).attr('data-delet'));
		if (e != data_delet) {
		new_val += (new_val==''?e:','+e);
		}
	});
	$(this).closest('.admin_file_label_wraper').find('input').val(new_val);
	
	$(this).parent('.admin_multiple_image_select').detach();
});



$(document).on('click','.hyst_zoom_img',function() {
	var vid = $(this).attr('data-zoom');
	var iw = parseInt($(this).attr('data-width'));
	var ih = parseInt($(this).attr('data-height'));
	var cw = document.documentElement.clientWidth;
	var ch = document.documentElement.clientHeight;
	if (iw > ih) { var gro = 1; } else { var gro = 2; }
	if (cw > ch) { var ore = 1; } else { var ore = 2; }
	
	var soe = cw/ch;
	var soi = iw/ih;
	
	if (gro == 2 && ore == 1) {
	var st='style="height: 100%;"';
	} else if (gro == 1 && ore == 1) {
		if (soi > soe) {
	var st='style="width: 100%;"';
		} else {
	var st='style="height: 100%;"';
		}
	} else if (gro == 2 && ore == 2) {
	var st='style="height: 100%;"';
	} else {
		if (soi > soe) {
	var st='style="width: 100%;"';
		} else {
	var st='style="height: 100%;"';
		}
	}
	
	var htm = '<div class="hyst_all_zoomer"><div class="hyst_all_zoomerrel"><div class="hyst_all_zoomclose"></div><div class="hyst_all_zoomcontainer"><img src="'+vid+'" '+st+'></div></div></div>';
	$('.hyst_modal_generatorcontainer').html(htm);
	$('.hyst_modal_generatorcontainer').show();
});

$(document).on('click','.hyst_crossmodal, .hyst_all_zoomclose', function () {
	$('.hyst_modal_generatorcontainer').hide();
	$('.hyst_modal_generatorcontainer').html('');
});

$(document).on('click','.admin_select_img_input', function () {
	get_mediafiles_modal($(this).attr('unic-return'));
});


$(document).on('click','redactorbar > button', function (e) {
	e.preventDefault();
	
	var target_area = $(this).closest('hystwysiwyg').find('wysiwygarea');
	var act = $(this);
	
	var selectedText = window.getSelection();
	var selection = selectedText.toString();
	if (selection.length > 0) {
		
		var range = selectedText.getRangeAt(0);
		var commonAncestor = range.commonAncestorContainer;
		if ($(commonAncestor).closest('wysiwygarea').length > 0) {
			if (!range.collapsed) {
			
				var tag;
				if (act.attr('action') == 'strike' || act.attr('action') == 'underline' || act.attr('action') == 'italic' || act.attr('action') == 'bold') {
					
					if (act.attr('action') == 'strike') { tag = 's';}
					else if (act.attr('action') == 'underline') { tag = 'u';}
					else if (act.attr('action') == 'italic') { tag = 'i';}
					else if (act.attr('action') == 'bold') { tag = 'b';}
					var tag = document.createElement(tag);
					
				} else if (act.attr('action') == 'align-left' || act.attr('action') == 'align-center' || act.attr('action') == 'align-right') {
					tag = document.createElement('p');
					if (act.attr('action') == 'align-left') { tag.style.textAlign = 'left'; } 
					else if (act.attr('action') == 'align-center') { tag.style.textAlign = 'center'; }
					else if (act.attr('action') == 'align-right') { tag.style.textAlign = 'right'; }
				} else if (act.attr('action') == 'link') {
					tag = document.createElement('a');
					tag.href = prompt('Введите ссылку');
				} else if (act.attr('action') == 'img') {
					tag = document.createElement('img');
					tag.src = prompt('Введите ссылку на изображение');
					tag.width = prompt('Введите ширину (px) целым числом');
				}
				
				tag.appendChild(range.extractContents());
				range.insertNode(tag);
				selection.removeAllRanges();
				var newRange = document.createRange();
				newRange.selectNodeContents(boldTag);
				selection.addRange(newRange);
			}
		} else {
			include_tag(act,target_area);
		}
	} else {
		include_tag(act,target_area);
	}	
});


$(document).on('change','redactorbar select', function () {
	var target_area = $(this).closest('hystwysiwyg').find('wysiwygarea');
	var act = $(this);
	
	var size = act.val().replace('px','');
	
	var selectedText = window.getSelection();
	var selection = selectedText.toString();
	if (selection.length > 0) {
		var range = selectedText.getRangeAt(0);
		var commonAncestor = range.commonAncestorContainer;
		if ($(commonAncestor).closest('wysiwygarea').length > 0) {
			if (!range.collapsed) {
				var tag = document.createElement('p');
				tag.style.fontSize = size+'px';
				tag.appendChild(range.extractContents());
				range.insertNode(tag);
				selection.removeAllRanges();
				var newRange = document.createRange();
				newRange.selectNodeContents(boldTag);
				selection.addRange(newRange);
			}
		} else {
			var tag = document.createElement('p');
			tag.style.fontSize = size+'px';
			tag.innerHTML = '&#8203;';
			target_area.append(tag);
			var range = document.createRange();
			range.setStart(tag.firstChild, 0);
			range.setEnd(tag.firstChild, 0);
			var selection = window.getSelection();
			selection.removeAllRanges();
			selection.addRange(range);
			target_area.focus();
		}
	} else {
		var tag = document.createElement('p');
		tag.style.fontSize = size+'px';
		tag.innerHTML = '&#8203;';
		target_area.append(tag);
		var range = document.createRange();
		range.setStart(tag.firstChild, 0);
		range.setEnd(tag.firstChild, 0);
		var selection = window.getSelection();
		selection.removeAllRanges();
		selection.addRange(range);
		target_area.focus();
	}
});


$(document).on('click','wysiwygarea img', function () {
	$(this).attr('_moz_resizing',true);
});

$(document).on('click','repeater .admin_form_repeater_label > div',function() {
	var pattern = $(this).attr('data-duble').slice(1, -1).split(']['), items = '';
	items += `<div class="admin_highlitedblock_bg admin_repeat_items_flex">`;
	pattern.forEach(function(e,i){
		var item = e.split(',');
		
		if (item[2] == 'text') {
		items += `<div class="admin_content_widht300">
						<label>`+item[0]+` <br><iw><input class="width100" type="text" name="`+item[1]+`" check="none"></iw></label>
					</div>`;
		} else {
		items += `<div class="admin_content_widht300">
						<label>`+item[0]+` <br><iw><input class="width100" type="text" name="`+item[1]+`" check="none"></iw></label>
					</div>`;	
		}
	});
	items += `<div class="admin_repeater_cros"></div></div>`;
	
	$(this).closest('repeater').find('repeats').append(items);
});

$(document).on('click','repeater .admin_repeater_cros',function() {
	$(this).closest('.admin_repeat_items_flex').detach();
});
	

});