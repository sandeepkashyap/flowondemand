App.image = {
	controllers : {},
	models      : {}
};

/**
 * Assignments controller behavior
 */
App.image.controllers.image = {

  /**
   * Assignments index page
   */
	admin : function() {
    	$(document).ready(function() {
			App.image.ManageImages.init('images');
			App.image.ManageImages.init_image_form('quick_image_form');
			App.image.ManageImages.init_pagination('images', App.data.image_total, 0);
			App.image.ManageImages.init_tabs('image_categories');
			App.image.ManageImages.init_switch_button();
			App.image.ManageImages.init_print_button();
			
//			$("#trigger_csv_form").click(function() {
//				App.image.ManageImages.popup_csv();
//				return false;
//			})

			$("#trigger_csv_form").fancybox({
				'frameWidth': 650,
				'frameHeight': $.browser.msie ? 343 : 335,
				'zoomSpeedIn': 300, 
				'zoomSpeedOut': 300, 
				'overlayShow': false,
				'callbackOnClose': function() {
					if (image_csv_upload_success != undefined && image_csv_upload_success > 0) {
						image_csv_upload_success = 0;
						$('#images_all').find('a').click();
					}
				} 
			}); 
		});
  	},
	
	log: function() {
		$(document).ready(function() {
			App.image.ManageLogs.init_pagination('index_log', App.data.log_total, 0); 
						
		});
	}

};

App.image.TiledImages = function(){
	
	return {
		init: function() {
			
		}
	}
}();

App.image.ManageImages = function() {

	var init_row = function(row) {
		var table = row.parent().parent();

		row.find('td a[href$=#manualIndex]').click(function() {
			var image_id = $(this).attr('rel');
			var self = $(this);
			var old_html = self.html();
			self.html("<img src='" + App.data.indicator_url + "' alt='deleting'/>");
			var colIndex = self.parent().parent().find('td').eq(4);
			colIndex.html("<img src='" + App.data.indicator_url + "' alt='deleting'/>");
			$.ajax({
				url: App.data.image_manual_index_url,
				data: ({id: image_id}),
				success: function(res){
					eval("var arr="+res);					
					var iconUrl = App.data.assets_url + "/images/" + arr['indicator'] + "_indicator.gif"
					colIndex.html("<img src='" + iconUrl + "' alt='"+arr['indicator']+"' title='"+arr['message']+"'/>" + arr['dt_indexed']);
					self.html(old_html);
				},
				error: function(req, textStatus, error) {
					self.html(old_html);					
				}
			});
		});
		//setup delete row
		row.find('td a[href$=#delete]').click(function() {
			var image_id = $(this).attr('rel');
			var self = $(this);
			var old_html = self.html();
			self.html("<img src='" + App.data.indicator_url + "' alt='deleting'/>");
			$.ajax({
				type: "POST",
				url: App.data.image_delete_url,
				data: ({image_id: image_id}),
				success: function(res) {
//					var row = self.parent().parent();
					row.fadeOut();
					row.remove();
					$('.flash').each(function() {
						$(this).hide();
					});
					$('#page_content').before(res);
					$('.flash').click(function() {
						$(this).hide('fast');
					});
					$('.undo_link').click(function(e) {
						var undo_link = $(this);
						var flash_message = undo_link.parent().parent();
						var undo_url = App.extendUrl(App.data.image_undo_trash_url, {id: undo_link.attr('rel')});
						undo_link.replaceWith('<img src="' + App.data.indicator_url + '" alt="" /> ' + App.lang('Undoing...'));
						$.ajax({
							url: undo_url,
							success: function(responseText) {
								var temp_table = $(responseText);
								var row = temp_table.find('tr');
								row.hide();
								$('#temp_row').hide();
								row.insertBefore('#temp_row');
								init_row(row);
								temp_table.remove();
								row.fadeIn();
								flash_message.hide();
								flash_message.remove();
							},
							error: function(res) {

							},
							complete: function(res) {

							}
						});
						return false;
					});
				},
				error: function(req, textStatus, error) {
					self.html(old_html);
					$('#page_content').before(req.responseText);
					$('.flash').click(function() {
						$(this).hide('fast');
					});
				}
			});

			return false;
		});//end click row td a delete

//		row.find('td a.fancy_group').click(function() {
//			console.log('hello')
//			var self = $(this)
//			var img_url = self.attr('href')
//			console.log(img_url);
//			App.ModalDialog.show('popup_upload', 'Upload CSV file', $('<img>').attr('src', img_url), {
//				width: 600,
//				height: 500,
//				button: false
//			});
//			return false;
//		});

		row.find('td a.fancy_group').fancybox({
			'zoomSpeedIn': 300, 
			'zoomSpeedOut': 300,
			'hideOnContentClick': true, 
			'overlayShow': false,
			'ignorePreload': true,
			'width':	1024,
			'height':	768,
			callbackOnStart: function(elem, $opts) {
				//find title
				var self = $(elem)
				$opts.width = self.attr('int_width');
				$opts.height = self.attr('int_height');
				var title = self.parent().parent().find('td.name div').html();
				self.attr('title', title);
				return true;
			} 
		});
//		row.find('td a[href$=#full_view]').click(function() {
//			App.image.ManageImages.popup_full_view($(this));
//		});
		
		row.find('.editableFile').click(function() {
			App.image.ManageImages.popup_upload($(this));
		});

		row.find('.editableInput').editable(App.data.image_quick_update_url, {
			placeholder: '<span class="edit_placeholder">Click to edit...</span>',
			tooltip   : "Click to edit. Press <Ente>r to save or <Escapse> to cancel",
			event : 'click',
			submit: null,
			cancel: null,
			heigth: 70

		});	
		
//		row.find('.editableSelect').editable(App.data.image_quick_update_url, {
//			'type'	: 'select',
//			'data'	: App.data.application_combobox_data,
//
//			'event' : 'click',
//			'submit': 'Ok',
//			'cancel': 'Cancel',
//			'select': true
//		});
	}
	
	return {
		init: function(wrapper_id) {
			var wrapper = $('#' + wrapper_id);
			wrapper.find('table tr').each(function() {
				init_row($(this));
			});		
		},

		init_tabs : function(wrapper_id) {
			var wrapper = $('#' + wrapper_id);
			wrapper.find('li').click(function() {
				var self = $(this);
				self.siblings().removeClass('selected');
				self.addClass('selected');

				var url = App.extendUrl(App.data.image_ajax_page, {page: 1, filter: self.attr('rel')});
				$('table.common_table').block({
					message: 'Loading...',
				    overlayCSS:  {
				        backgroundColor: '#353a41',
				        opacity:        '0.2'
				    }
				});
				$.ajax({
					url: url,
					success: function(responseText) {
						$('#body_list_images').html(responseText);
						App.image.ManageImages.init('images');
					},
					complete: function() {
						$('table.common_table').unblock();
					}
				})
				return false;
			});
		},

		init_image_form : function(wrapper_id) {
			var wrapper = $('#' + wrapper_id);
			var form = wrapper.find('form');

			$(':button[name=reset]').click(function() {
//				$('#Image_vc_image').val('');
				form.clearForm();
				return false;
			});

			form.submit(function() {
				var form = $(this);
				if (form.find(':file').val() == '' && $('#image_from_url').val() == '') {
					alert('Please select file to upload or input url');
					return false;
				}
				if(!UniForm.is_valid(form)) {
					return false;
				}
				$('#temp_row').show();
				try {
					form.block({
						message: 'Uploading...',
						overlayCSS:  {
					        backgroundColor: '#353a41',
					        opacity:        '0.2'
					    }
					})
					form.ajaxSubmit({
						success : function(responseText) {
							form.clearForm();							
							var temp_table = $(responseText);							
							var row = temp_table.find('tr');
							row.hide();
							$('#temp_row').hide();
							row.insertBefore('#temp_row');
							init_row(row);
							temp_table.remove();
							row.fadeIn();
							if (temp_table.length == 0) {
								alert(responseText)
							}
						},
						error : function (response) {
							$('#temp_row').hide();
							alert(response.responseText);
						},
						complete: function() {
							form.unblock();
						}
					});
		//			$.post(form.attr('action'), {}, function(data) {
	//				alert(data);
	//			});
				} catch(err) {
					alert(err);
				}
				return false;
			});
		},
		
		init_csv_form : function(form_id, wrapper_id) {
			var wrapper = $('#' + wrapper_id);
			var form = $('#' + form_id);

			form.find(':button[name=reset]').click(function() {
				form.clearForm();
				return false;
			});

			form.submit(function() {
				var form = $(this);
				if (form.find(':file').val() == '' && $('#image_from_url').val() == '') {
					alert('Please select file to upload or input url');
					return false;
				}
				if(!UniForm.is_valid(form)) {
					return false;
				}
				try {
					form.block({
						message: 'Uploading...',
						overlayCSS:  {
					        backgroundColor: '#353a41',
					        opacity:        '0.2'
					    }
					})

					form.ajaxSubmit({
						success : function(responseText) {
							form.clearForm();
							
						},
						error : function (response) {
							alert(response.responseText);
						},
						complete: function() {
							form.unblock();
						}
					});
				} catch(err) {
					alert(err);
				}
				return false;
			});
		},

		init_pagination: function(wrapper_id, image_total, current_page) {
			var wrapper = $('#' + wrapper_id);
			wrapper.find('.pagination').pagination(image_total, {
				items_per_page: 10,
				num_display_entries: 10,
				num_edge_entries: 3,
				current_page: current_page,
				callback: function(page_id, panel) {
					var is_swap = $('#switch_thumb').hasClass('swap');
					var url = App.extendUrl(is_swap ? App.data.image_tiled_url : App.data.image_ajax_page, {page: page_id + 1});
					wrapper.find('table.common_table').block({
						message: 'Loading...',
					    overlayCSS:  {
					        backgroundColor: '#353a41',
					        opacity:        '0.2'
					    }
					});
					$.ajax({
						url: url,
						data: {skip_layout: 1},
						success: function(responseText) {
							if (is_swap) {
								$('#images_wrapper ul.tiled-images').remove();
								$('#images_wrapper').append(responseText);
							} else {
								wrapper.find('#body_list_images').html(responseText);
								App.image.ManageImages.init(wrapper_id);								
							}
						},
						complete: function() {
							wrapper.find('table.common_table').unblock();
						}
					})
					return true;
				}
			});
		},

		popup_csv: function(trigger) {
			// Show and initialize popup
			var widget_popup = false;
			var widget_id = 'widget_popup'
			var popup_url = App.extendUrl(App.data.image_csv_url);
//	        App.ModalDialog.show('popup_upload', 'Upload CSV file', $('<p><img src="' + App.data.indicator_url + '" alt="" /> ' + App.lang('Loading...') + '</p>').load(popup_url, function() {
	        App.ModalDialog.show('popup_upload', 'Upload CSV file', $('<iframe style="width:95%;height:100%;">').attr('src', popup_url), {
				width: 600,
				height: 500,
				button: false
			});
		},
		
		popup_upload: function(trigger) {
			// Show and initialize popup
			var widget_popup = false;
			var widget_id = 'widget_popup'
			var popup_url = App.extendUrl(App.data.image_change_url, {id: trigger.attr('id')});
	        App.ModalDialog.show('popup_upload', 'Replace upload', $('<p><img src="' + App.data.indicator_url + '" alt="" /> ' + App.lang('Loading...') + '</p>').load(popup_url, function() {
	        	widget_popup = $('#replace_upload_container')
				App.image.ManageImages.init_change_upload_form(widget_popup, trigger);
			}), {
				width: 500,
				buttons: false
			});
		},
		
		popup_full_view: function(trigger) {
			// Show and initialize popup
			var widget_popup = false;
			var widget_id = 'widget_popup'
			var popup_url = App.extendUrl(App.data.image_full_url, {id: trigger.attr('rel')});
	        App.ModalDialog.show('popup_full_view', 'View image', $('<p><img src="' + popup_url + '" alt="" /> '), {
				buttons: false
			});
		},

		init_change_upload_form: function(widget_popup, trigger) {
			widget_popup.find(':button[name=reset]').click(function() {
//				widget_popup.find(':file').val('');
				widget_popup.find('form').clearForm();
				return false;
			});
			widget_popup.find('form').submit(function() {
				var form = $(this);
				if (form.find(':file').val() == '' && $('#quick_from_url').val() == '') {
					alert('Please select file to upload or input url');
					return false;
				}
				try {
					form.block({
						message: 'Uploading...',
						overlayCSS:  {
					        backgroundColor: '#353a41',
					        opacity:        '0.2'
					    }
					})
					form.ajaxSubmit({
						success : function(responseText) {
							try {
								eval("var arr="+responseText);
								trigger.parent().siblings('td.action').find('a.fancy_group')
									.attr('int_width', arr.width)
									.attr('int_height', arr.height)
									.attr('href', arr.full_url);
								trigger.find('img').attr('src', arr.src)
								if (App.ModalDialog.isOpen()) {
									App.ModalDialog.close();
								}
							} catch (e) {
								alert(responseText);								
							}
						},
						error : function (response) {
							alert(response.responseText);
						},
						complete: function() {
							form.unblock();
						}
					});
				} catch(err) {
					alert(err);
				}
				return false;
			});

		},

		resize_images: function(event, ui) {
			$('#images ul.tiled-images img').css('width', 100 + ui.value + "px");
		},
	
		init_print_button : function() {
			$("#print_button").click(function() {
				var url = App.extendUrl(App.data.image_print_url, {width: $('#images ul.tiled-images img').eq(0).css('width')}) 
				window.open(url)
				return false;
			});
		},
		
		init_switch_button : function() {
			$("a.switch_thumb").toggle(function(){
				var url = App.data.image_tiled_url
				var pages = $('.pagination .current')
				var page = 1
//				if (pages.length > 0) {
//					page = pages.eq(0).text();
//				}
				$.ajax({
					url: url,
					data: {skip_layout: 1, page: page},
					success: function(responseText) {
						$('#images_wrapper table.common_table').hide();
						$('#images_wrapper').append(responseText);
						
						//App.image.ManageImages.init('images');
					},
					complete: function() {
						//$('table.common_table').unblock();
					}
				})
				$(this).addClass("swap");
				
				$('#slider').slider({
					max: 285,
					slide: App.image.ManageImages.resize_images,
					change: App.image.ManageImages.resize_images
				});
				$('#print_button').show();
			}, function() {
				var url = App.data.image_admin_url
				var pages = $('.pagination .current')
				var page = 1
//				if (pages.length > 0) {
//					page = pages.eq(0).text();
//				}
				$.ajax({
					url: url,
					data: {skip_layout: 1, page: page},
					success: function(responseText) {
						$('#images_wrapper ul.tiled-images').remove();
						$('#body_list_logs').html(responseText);
						$('#images_wrapper table.common_table').show();
						
						//App.image.ManageImages.init('images');
					},
					complete: function() {
						//$('table.common_table').unblock();
					}
				})
				
				$(this).removeClass("swap");
				$('#slider').slider('destroy');
				$('#print_button').hide();
//				$('#images_wrapper ul.tiled-images').remove();
//				$('#images_wrapper table.common_table').show();
			});			
			
		}
	}
}();

App.image.ManageLogs = function(){
	return {
		init_pagination: function(wrapper_id, image_total, current_page){
			var wrapper = $('#' + wrapper_id);
			wrapper.find('.pagination').pagination(App.data.log_total, {
				items_per_page: 10,
				num_display_entries: 10,
				num_edge_entries: 3,
				current_page: current_page,
				callback: function(page_id, panel){
					var url = App.extendUrl(App.data.log_ajax_page, {
						page: page_id + 1,
						skip_layout: 1
					});
					wrapper.find('table.common_table').block({
						message: 'Loading...',
						overlayCSS: {
							backgroundColor: '#353a41',
							opacity: '0.2'
						}
					});
					$.ajax({
						url: url,
						success: function(responseText){
							wrapper.find('#body_list_logs').html(responseText);
							App.image.ManageImages.init(wrapper_id);
						},
						complete: function(){
							wrapper.find('table.common_table').unblock();
						}
					})
					return true;
				}
			});
		}
	}
}();
