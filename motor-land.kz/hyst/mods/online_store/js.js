$(document).ready(function() {

	$(document).on('change','.hyst_os_category_container label input[type="checkbox"]',function() {
		var point = $(this);
		
		var data = new FormData(),own = [], pc_htm = '';
		data.append('comand','adm_get_pc');
		data.append('id',point.val());
		
		
		$('.hyst_os_category_container').find('input[type="checkbox"]').each(function(i,e){
			if ($(e).is(':checked')) {
			own.push($(e).val());
			}
		});
		
		data.append('own',JSON.stringify(own));
		
		$.ajax({
			url: 'hyst/mods/online_store/get_pc',
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			data: data,
			type: 'post',
			success: function(res) {
				
				if (res.podcategory.length > 0) {
					res.podcategory.forEach(function(e,i){
						pc_htm += `<label class="admin_label_checkbox">`+e.name+` <input type="checkbox"  value="`+e.id+`"></label>`;
						
					});
				}
				
				
				if (point.is(':checked')) {
					if (pc_htm != '') {
						var html = `<div class="admin_highlitedblock_bg" data-id="`+point.val()+`"><label style="padding: 5px 10px;">`+point.attr('data-name')+`</label>`+pc_htm+`</div>`;
						point.closest('interfaceform').find('.hyst_os_podcategory_container').append(html);
					}
				} else {
					point.closest('interfaceform').find('.hyst_os_podcategory_container').find('div[data-id="'+point.val()+'"]').detach();
				}
				
				if (res.atributs !== undefined && res.atributs.length > 0) {
					var atributs_htm = '';
					res.atributs.forEach(function(e,i){
						atributs_htm += '<div class="OS_atribute_col"><label class="admin_label_checkbox">'+e.name+' <input type="checkbox" name="atributs[]" value="'+e.id+'"></label><div class="OS_atribute_options_col">';
						e.values.forEach(function(el,ix) {
							atributs_htm += '<label class="admin_label_checkbox">'+el.name+' <input type="checkbox" name="atribut_option[]" value="'+el.id+'"></label>';
						});
						atributs_htm += '</div></div>';
					});
					
					$('.hyst_os_atributs_container').html(atributs_htm);
				} else {
					$('.hyst_os_atributs_container').html('');
				}
			}
		});
	});

});
