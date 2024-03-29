Ext.ns('Pictomobile');
Ext.ns('Pictomobile.Record');
Ext.ns('Pictomobile.Store');

/**
 * @class Example.Grid
 * @extends Ext.grid.GridPanel
 */
Pictomobile.Record.Image = Ext.data.Record.create([{
    name: "id",
    mapping: "id_image"
}, {
    name: "thumbnail",
    mapping: "vc_image"
}, {
    name: "image",
    mapping: "vc_image"
}, {
    name: "width",
    mapping: "int_width"
}, {
    name: "height",
    mapping: "int_height"
}, {
    name: "name",
    mapping: "vc_name"
}, {
    name: "url",
    mapping: "vc_url"
}, {
    name: "created",
    mapping: "dt_created"
}, {
    name: "indexed",
    mapping: "dt_indexed"
}]);

Pictomobile.WindowCropImage = null; 

Pictomobile.Store.ImagesGridStore = new Ext.data.JsonStore({
    id: 'imagesStore',
    root: 'images',
    totalProperty: 'totalCount',
    url: App.data.images_store,
    baseParams: {
        format: 'json',
        skip_layout: '1',
        items_per_page: 20
    },
    fields: Pictomobile.Record.Image
}); // column model
// Create RowActions Plugin
Pictomobile.action = new Ext.ux.grid.RowActions({
    header: 'Actions'    
	,autoWidth:true
	//,width: 200
	,fixed: true
    //,hideMode:'display'
    ,keepSelection: true,
    actions: [{
        qtipIndex: 'Change picture',
        iconCls: 'icon-image-edit',
        tooltip: 'Change picture'
    }, {
        iconCls: 'icon-minus',
        tooltip: 'Delete picture',
        qtipIndex: 'Delete picture'
    }, {
        qtipIndex: 'Manual index picture',
        iconCls: 'icon-manual-index',
        tooltip: 'Manual index pictureUser'
    }
	, {
        qtipIndex: 'Crop image',
        iconCls: 'icon-crop-image',
        tooltip: 'Crop image'
    }
	],
    callbacks: {
        'icon-manual-index': function(grid, record, action, row, col){
			var sbar = Ext.getCmp('statusbar')
			sbar.showBusy({
				text: 'Indexing image <b>' + record.get('name') + '</b>'
			})
			$.ajax({
				url: App.data.image_manual_index_url,
				data: ({id: record.get('id')}),
				success: function(res){
					eval('var data= ' + res)
					if (data.indicator == 'error') {
			            Ext.ux.Toast.msg('Error', data.message);
					} else {
			            Ext.ux.Toast.msg('Index image', 'The image <b>{0}</b> successful indexed', record.get('name'));
					}
					record.set('indexed', data.dt_indexed);
					record.set('name', data.vc_name);
					record.set('url', data.vc_url);
					Ext.getCmp('mainViewport').publish('pictomobile.image.index', {data: data});
					
					sbar.clearStatus({useDefaults:true});						
				},
				error: function(req, textStatus, error) {
		            Ext.ux.Toast.msg('Error', 'Something wrong when index image<br/> <b>{0}</b>', error);
					sbar.clearStatus({useDefaults:true});
				}
			});
        }
		
		,'icon-minus': function(grid, record, action, row, col){
			var delete_url = App.extendUrl(App.data.image_delete_url, {id: record.get('id')})
			//Ext.ux.Toast.msg('Callback: DELETE1212 ' + delete_url, 'You have clicked row: <b>{0}</b>, action: <b>{0}</b>', row );
			var sbar = Ext.getCmp('statusbar');
			sbar.showBusy({
				text: 'Deleting'
			});
			$.ajax({
				type: "POST",
				url: App.data.image_delete_url,
				data: ({image_id: record.get('id')}),
				success: function(res) {
					$(document.body).data('deleted-record', record.get('id'))
					Ext.ux.Toast.msg('Delete', 'The image <b>{0}</b> has been moved to the Trash. Click undo button to restore the image', record.get('name'));
					grid.getStore().remove(record)
					sbar.clearStatus({useDefaults:true});
					sbar.setStatus({
						iconCls: 'x-status-valid',
						text: 'The image ' + record.get('name') + ' has been moved to the Trash. Click undo button to restore the image'
					})
					var btnUndo = Ext.getCmp('sbar-btn-undo');
					btnUndo.setDisabled(false)					
				}
			});
		} 
		
        ,'icon-image-edit': function(grid, record, action, row, col){
            //Ext.ux.Toast.msg('Callback: OPEN', 'You have clicked row: <b>{0}</b>, action: <b>{0}</b>', row, action);
            new Ext.Window({
                id: "wndEditPicture",
                title: 'Edit picture',
                modal: true,
                layout: 'fit',
                width: 500,
                height: 350,
                items: [{
                    xtype: 'editpictureform',
                    data: {
                        grid: grid,
                        record: record,
                        row: row
                    }
                }]
            }).show();
        }
        
		,'icon-crop-image': function(grid, record, action, row, col){
			
			if (Pictomobile.WindowCropImage == null) {
				
				Pictomobile.WindowCropImage = new Ext.Window({
					header: false,
					title: '',
				    applyTo: "dialogCropImage",
				    closable: true,
				    modal: false,
				    minimizable: false,
				    maximizable: false,
				    resizable: false,
				    draggable: true,
				    shadowOffset: 8,
				    id: "wndCropImage"
					,fbar: {
						items: [{
							text: 'Crop image',
							iconCls: 'icon-crop-image',
							handler: function() {
								window.frames['if_crop_image'].document.forms['form_crop_image'].submit()
							}
						}]
					}
				})
				Pictomobile.WindowCropImage.on('beforeclose', function(w) {
					document.getElementById('if_crop_image').src = "";
					w.hide();
					return false;
				});
			}
			
			var w = $.fn.fancybox.getViewport();
	
			var r = Math.min(
							Math.min(w[0] - 36, record.get('width')) / record.get('width'), 
							Math.min(w[1] - 150, record.get('height')) / record.get('height'));

			var width = Math.round(r * record.get('width'));
			var height = Math.round(r * record.get('height'));
			
			var left	= (width + 36)	> w[0] ? w[2] : (w[2] + Math.round((w[0] - width - 36) / 2));
			var top		= (height + 100)	> w[1] ? w[3] : (w[3] + Math.round((w[1] - height - 100) / 2));
			
			Pictomobile.WindowCropImage.setWidth(width + 50);
			Pictomobile.WindowCropImage.setHeight(height + 100)
			
			document.getElementById('if_crop_image').src = App.data.image_crop_url + '/id/' + record.get('id') 
			+ '/width/' + width 
			+ '/height/' + height
			+ '/ratio/' + r
			
			Pictomobile.WindowCropImage.restore()
			Pictomobile.WindowCropImage.setPosition(left, top)
            Pictomobile.WindowCropImage.show();
        }
		
    }
});


//this function is called on server response script, see method actionCrop on ImagesController 
Pictomobile.addCropImageToStore = function(data) {
	var model = data.model
    var record = new Pictomobile.Record.Image({
        id: model.id_image,
        thumbnail: model.vc_image,
        name: model.vc_name,
        url: model.vc_url,
		width: model.int_width,
		height: model.int_height,
        created: model.dt_created,
        indexed: model.dt_indexed
    });
    Pictomobile.Store.ImagesGridStore.insert(0, record);
	Ext.getCmp('mainViewport').publish('pictomobile.image.index', {'data': {log: data.log}});
	Pictomobile.WindowCropImage.close();
	Ext.ux.Toast.msg('Image crop', 'Image has been crop and save as new image');
}

// dummy action event handler - just outputs some arguments to console
Pictomobile.action.on({
    action: function(grid, record, action, row, col){
        //Ext.ux.Toast.msg('Event: action', 'You have clicked row: <b>{0}</b>, action: <b>{1}</b>', row, action);
    },
    beforeaction: function(){
        //Ext.ux.Toast.msg('Event: beforeaction', 'You can cancel the action by returning false from this event handler.');
    },
    beforegroupaction: function(){
        //Ext.ux.Toast.msg('Event: beforegroupaction', 'You can cancel the action by returning false from this event handler.');
    },
    groupaction: function(grid, records, action, groupId){
        //Ext.ux.Toast.msg('Event: groupaction', 'Group: <b>{0}</b>, action: <b>{1}</b>, records: <b>{2}</b>', groupId, action, records.length);
    }
});



Pictomobile.ImagesGrid = Ext.extend(Ext.grid.GridPanel, {

    // configurables
	title: 'Images grid',
    border: true // {{{
    ,initComponent: function(){
    
        // hard coded - cannot be changed from outside
        var config = {
            // store
            store: Pictomobile.Store.ImagesGridStore,
            plugins: ['msgbus', Pictomobile.action],
            columns: [{
                dataIndex: 'thumbnail',
                header: 'Thumbnail',
                width: 120,
				fixed: true,
                renderer: this.renderThumbnail.createDelegate(this),
                editable: false
            }, {
                dataIndex: 'url',
                header: 'Url/Name',
				width: 550,
                renderer: this.renderUrlAndName.createDelegate(this),
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'received',
                header: 'Created/Indexed',
                width: 120,
				fixed: true,
                renderer: this.renderReceived.createDelegate(this)
            }, Pictomobile.action] // force fit
            ,viewConfig: {
                forceFit: false,
                scrollOffset: 0
            } // tooltip template
            ,tbar: new Ext.PagingToolbar({ // paging bar on the bottom
                id: 'imagePaging',
                pageSize: 20,
                store: Pictomobile.Store.ImagesGridStore,
                displayInfo: true,
                displayMsg: 'Displaying topics {0} - {1} of {2}',
                emptyMsg: "No topics to display",
                items: ['-', {
					enableToggle: false,
					//pressed: true,
					text: 'View tile',
					scope: this,
					cls: 'x-btn-text-icon',
					iconCls: 'icon-view-tile',
					handler: function(){
						//Ext.ux.Toast.msg('Show preview', 'You have clicked row: <b>{0}</b>, action: <b>{0}</b>', 1, 2);
						this.publish('pictomobile.image.viewmode.change', 1);
					}
				}, '-']
            })// eo tbar
        
        }; // eo config object
        // apply config
        Ext.apply(this, Ext.apply(this.initialConfig, config));
        
        // call parent
        Pictomobile.ImagesGrid.superclass.initComponent.apply(this, arguments);
        
		
    } // eo function initComponent
    // }}}
    // {{{
    ,
    onRender: function(){
    
        // call parent
        Pictomobile.ImagesGrid.superclass.onRender.apply(this, arguments);
        
        this.subscribe("pictomobile.appswitcher.change")
        this.subscribe("pictomobile.image.change")
        this.subscribe("pictomobile.image_filter")
		
		this.getView().on('refresh', this.onViewRefresh, this)
		this.getView().on('rowsinserted', this.onRowAdded, this)
		this.getView().on('rowupdated', this.onRowUpdated, this)
		
	 	var cfg = {
                shadow: false,
                completeOnEnter: true,
                cancelOnEsc: true,
                updateEl: true,
                ignoreNoChange: true
            };

        var labelEditor = new Ext.Editor(Ext.apply({
            alignment: 'l-l',
            listeners: {
                complete: function(ed, value, oldValue){
					$.ajax({
						type: "POST",
						url: App.data.image_quick_update_url,
						data: ({id: ed.targetId, value: value}),
						success: function(res){
							if (res == value) {
								if (value.trim() == '') {
									$('span[id=' + ed.targetId + ']').addClass('edit_placeholder').html('Click to edit')
								} else {
									$('span[id=' + ed.targetId + ']').removeClass('edit_placeholder')
								}
					            Ext.ux.Toast.msg('Successful', 'Update is completed');
							} else {
								eval('var result = ' + res);
								Ext.Msg.show({
								   title:'Error',
								   msg: result.error,
								   buttons: Ext.Msg.OK,			   
								   icon: Ext.MessageBox.ERROR
								});
								$('span[id=' + ed.targetId + ']').html(oldValue)
							}
						},
						error: function(req, textStatus, error) {
				            Ext.Msg.show({
								   title:'Error',
								   msg: error,
								   buttons: Ext.Msg.OK,			   
								   icon: Ext.MessageBox.ERROR
								});
						}
					});
                }
            },
            field: {
                allowBlank: true,
                xtype: 'textfield',
                width: 400,
                selectOnFocus: true
            }
        }, cfg));
		this.on('click', function(e) {
			var target = $(e.getTarget());
			if (target.hasClass('editableInput')) {
				e.stopPropagation();
				labelEditor.targetId = target.attr('id')
				labelEditor.startEdit(e.getTarget())
			}
		})
    } // eo function onRender
    ,renderThumbnail: function(val, cell, record){
		if (record.get('rand')) {
			var rand = new Date().format('U');
	        return "<a rel=\"lightbox\" class=\"fancy-group\" href=\"" + App.data.image_full_url + "/id/" + record.get('id') + ".jpg?rand="+rand+"\" int_width='"+record.get('width')+"' int_height='"+record.get('height')+"' title='" +record.get('name') +  "'><img src=\"" + App.data.thumnail_url + "/" + val + "?rand="+ rand + " \" alt=\"" + val + "\" title=\"\"/></a>";			
		}
        return "<a rel=\"lightbox\" class=\"fancy-group\" href=\"" + App.data.image_full_url + "/id/" + record.get('id') + ".jpg\" int_width='"+record.get('width')+"' int_height='"+record.get('height')+"' title='" +record.get('name') +  "'><img src=\"" + App.data.thumnail_url + "/" + val + "\" alt=\"" + val + "\" title=\"\"/></a>";
    }
	,renderUrlAndName: function(val, cell, record){
		var name = record.get('name'),
			name_editHolder = '';
		
		if (name.trim() == '') {
			name = 'Click to edit'
			name_editHolder = 'edit_placeholder'
		}
		var url = record.get('url'),
			url_editHolder = '';
		if (url.trim() == '') {
			url = 'Click to edit';
			url_editHolder = 'edit_placeholder'
		}
        return "<span id='vc_url:"+record.get('id')+"' title='Click to edit' class='editableInput "+ url_editHolder +"'>" + url + "</span><br/><br/>" + "<span id='vc_name:"+record.get('id')+"' class='editableInput " + name_editHolder + "'>" + name + "</span>";
    }
	,renderReceived: function(val, cell, record){		
        return "<span class='fuzzyDate' title='"+ record.get('created') +"'>"+record.get('created')+"</span><br/><br/>" + "<span class='fuzzyDate' title='"+record.get('indexed')+"'>"+record.get('indexed')+"</span>";
    }
	,onMessage: function(message, subject){
		if (message == 'pictomobile.image.change') {
			var store = this.getStore();
			var record = store.getById(subject.old.id)
			record.set('thumbnail', subject.model.thumbnail);
			record.set('width', subject.model.width);
			record.set('height', subject.model.height);
			record.set('indexed', subject.model.dt_indexed);
			record.set('rand', true);
			store.commitChanges();
			Ext.ux.Toast.msg('Image changed', 'Image change successful');
			this.publish('pictomobile.image.commitchange', subject);
		}
		else 
			if (message == 'pictomobile.appswitcher.change') {
				this.store.setBaseParam('application_id', subject.record.get('id'));
				this.store.load();
			}
			else 
				if (message == 'pictomobile.image_filter') {
					this.getStore().load({params: subject})
				}
    }
	,onRowAdded: function() {
		this.onViewRefresh()
	}
	,onRowUpdated: function() {
		this.onViewRefresh()
	}
	,onViewRefresh: function() {
		$('a.fancy-group').fancybox({
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
				var title = self.attr('title')
				self.attr('title', title);
				return true;
			} 
		});
		
		/*$('span.editableInput').editable(App.data.image_quick_update_url, {
			placeholder: '<span class="edit_placeholder">Click to edit...</span>',
			tooltip   : "Click to edit. Press <Ente>r to save or <Escapse> to cancel",
			event : 'click',
			submit: null,
			cancel: null,
			width: '100%',
			height: 'none',			
			onerror: function(form, target, xhr) {
			}

		});*/
		this.getView().scrollToTop();
		//new Ext.fc.fuzzyDate().init();	
	}
	
}); // eo extend
// register xtype
Ext.reg('imagesgrid', Pictomobile.ImagesGrid);

Pictomobile.ImagesDataView = Ext.extend(Ext.DataView, {
	initComponent: function(){
		var config = {
			store: Pictomobile.Store.ImagesGridStore,
			tpl: new Ext.XTemplate('<tpl for=".">', 
				'<div class="tile-image" id="tile_item_{id}">', 
					'<table cellspacing="0" cellpadding="0"><tbody><tr><td class="td-thumb" >', 
						'<a rel=\"lightbox\" class="fancy-group" href="' + App.data.image_full_url + '/id/{id}.jpg" int_width="{width}" int_height="{height}" title="{name}">',
							'<img alt="{name}" title="{name}" src="' + App.data.thumnail_url + "/" + '{thumbnail}"/>', 
						'</a></td></tr></tbody></table>', 
				'</div>', 
			'</tpl>', 
			'<div class="x-clear"></div>'),
			autoHeight: true,
			multiSelect: false,
			overClass: 'x-view-over',
			itemSelector: 'div.tile-image',
			emptyText: 'No images to display',
			
			listeners: {
				click: {
					fn: function(dataView, index, elem, e){
						$(elem).find('a.fancy-group').click();
					}
				}
			}
		}
		
		Ext.apply(this, Ext.apply(this.initialConfig, config));
        
        Pictomobile.ImagesDataView.superclass.initComponent.apply(this, arguments);
	}
	,refresh: function() {
		Pictomobile.ImagesDataView.superclass.refresh.apply(this, arguments);
		$('td.td-thumb img').load(function() {
			var self = $(this);
			var img = new Image();
			if (self.data('isLoaded')) {
				return;
			}
			var old_height = this.height,
				old_width = this.width;
			self.attr('ori_width', old_width)
			self.attr('ori_height', old_height)
			img.onload = function() {
				var slideValue = Ext.getCmp('imageSlider').getValue() / 100;
				self.data('isLoaded', true)
				var new_width = parseInt(old_width * slideValue),
					new_height = parseInt(old_height * slideValue)
				
				
				self
				.attr('src', this.src)
				.css('width', new_width)
				.css('height', new_height)
				
				var ratio = slideValue;
								
				self.parent().parent().css('width', 110 * ratio).css('height', 115 * ratio)
				.parent().parent().parent().parent().css('width', 110 * ratio).css('height', 115 * ratio)
			}
			img.src = self.parent().attr('href');
		});
		
		$('a.fancy-group').fancybox({
			'zoomSpeedIn': 300,
			'zoomSpeedOut': 300,
			'hideOnContentClick': true,
			'overlayShow': false,
			'ignorePreload': true,
			'width': 1024,
			'height': 768,
			callbackOnStart: function(elem, $opts){
				//find title
				var self = $(elem)
				$opts.width = self.attr('int_width');
				$opts.height = self.attr('int_height');
				var title = self.attr('title')
				self.attr('title', title);
				return true;
			}
		});
	}
	,onAdd: function(ds, records, index) {
		Pictomobile.ImagesDataView.superclass.onAdd.apply(this, arguments);
		
		$('a.fancy-group').fancybox({
			'zoomSpeedIn': 300,
			'zoomSpeedOut': 300,
			'hideOnContentClick': true,
			'overlayShow': false,
			'ignorePreload': true,
			'width': 1024,
			'height': 768,
			callbackOnStart: function(elem, $opts){
				//find title
				var self = $(elem)
				$opts.width = self.attr('int_width');
				$opts.height = self.attr('int_height');
				var title = self.attr('title')
				self.attr('title', title);
				return true;
			}
		});
		
		var imageSlider = Ext.getCmp('imageSlider');
		var slideValue = imageSlider.getValue() / 100;
		if (records.length == 0) {
			return;
		}
		var id = records[0].get('id')
		
		var self = $('#tile_item_' + id + ' img').eq(0)
		$('#tile_item_' + id + ' img').load(function() {
			var self = $(this);
			var img = new Image();
			if (self.data('isLoaded')) {
				return;
			}
			var old_height = this.height,
				old_width = this.width;
			self.attr('ori_width', old_width)
			self.attr('ori_height', old_height)
			img.onload = function() {
				self.data('isLoaded', true)
				var new_width = parseInt(old_width * slideValue),
					new_height = parseInt(old_height * slideValue)
				
				
				self
				.attr('src', this.src)
				.css('width', new_width)
				.css('height', new_height)
				
			}
			img.src = self.parent().attr('href');
			
			var ratio = slideValue ;
								
			$('#tile_item_' + id).css('width', 110 * ratio).css('height', 115 * ratio)							 
			.find('td.td-thumb').css('width', 110 * ratio).css('height', 115 * ratio)
		});
	}
});

Ext.reg('imagesdataview', Pictomobile.ImagesDataView);

Pictomobile.ImagesTile = Ext.extend(Ext.Panel, {
	
    // configurables
	title: 'Tile of images',    
    border: true // {{{
    ,initComponent: function(){
    
        // hard coded - cannot be changed from outside
        var config = {
			autoScroll: true,
			plugins: ['msgbus'],
			layout: 'fit',
			items: {xtype: 'imagesdataview'}
        	// paging bar on the bottom
            ,tbar: new Ext.PagingToolbar({
                id: 'tilePaging',
                pageSize: 20,
                store: Pictomobile.Store.ImagesGridStore,
                displayInfo: true,
                displayMsg: 'Displaying topics {0} - {1} of {2}',
                emptyMsg: "No topics to display",
                items: ['-', {
                    pressed: false,
					text: 'View grid',
                    cls: 'x-btn-text-icon',
					iconCls: 'icon-grid',
					scope: this,
                    handler: function(){
                        //Ext.ux.Toast.msg('Show preview', 'You have clicked row: <b>{0}</b>, action: <b>{0}</b>', 1, 2);
						this.publish('pictomobile.image.viewmode.change', 0);
                    }
                }, {xtype: 'tbseparator'}, 'Resize images: ', new Ext.Slider({
					id: 'imageSlider',
					width: 300,
					minValue: 100,
					maxValue: 400,
					plugins: [new Ext.ux.SliderTip({
		                getText : function(s){
		                    return String.format('{0}px', s.value);
		                }
		            }), Ext.ux.FillSlider],
					listeners: {
						change: function(slider, value){
							if(Ext.get('imagesTile')){
								var ratio = value / 100;
								
								var items = Ext.get('imagesTile').select("div.tile-image");								 
								items.setWidth(110 * ratio).setHeight((115 * ratio))
								
								var tds = Ext.get('imagesTile').select("td.td-thumb");
								tds.setWidth(110 * ratio).setHeight((115 * ratio))
								
								var imgs = Ext.get('imagesTile').select("img");
								imgs.each(function(el, c, idx) {
									var new_width = parseInt(el.getAttribute('ori_width')) * ratio,									
										new_height = parseInt(el.getAttribute('ori_height')) * ratio									
									el.setWidth(new_width);
									el.setHeight(new_height);
								})
							}
						}
					}
				}), {
                	text: 'Print',
                	iconCls: 'x-btn-text icon-print',
                	handler: function() {
                		var pager = Ext.getCmp('tilePaging');
                		var slider = Ext.getCmp('imageSlider');
                		
	                	var url = App.extendUrl(App.data.image_print_url, {
	    					ratio: slider.getValue() / 100,
	    					page: Math.ceil((pager.cursor + pager.pageSize) / pager.pageSize), 
	    					items_per_page: pager.pageSize,
	    					application: App.data.application_id
	    				}) 
	    				window.open(url)
                	}
				}]
            })//eo bbar
        
        }; // eo config object
        // apply config
        Ext.apply(this, Ext.apply(this.initialConfig, config));
        
        // call parent
        Pictomobile.ImagesTile.superclass.initComponent.apply(this, arguments);
        
    } // eo function initComponent
    // }}}
    // {{{
    ,
    onRender: function(){
    
        // call parent
        Pictomobile.ImagesTile.superclass.onRender.apply(this, arguments);
        
        // load store
//        this.store.load();
        
        this.subscribe("pictomobile.appswitcher.change")
        this.subscribe("pictomobile.image.commitchange")
    } // eo function onRender
    ,
    onMessage: function(message, subject){
		if (message == 'pictomobile.appswitcher.change') {
			Ext.getCmp('imageSlider').setValue(110)
		}
		else if (message == 'pictomobile.image.commitchange') {
			var id = subject.model.id;
			var self = $('#tile_item_' + id + ' img').eq(0)
			self.data('isLoaded', false)
			self.parent().attr('href', subject.model.full_url);
			
			$('a.fancy-group').fancybox({
				'zoomSpeedIn': 300,
				'zoomSpeedOut': 300,
				'hideOnContentClick': true,
				'overlayShow': false,
				'ignorePreload': true,
				'width': 1024,
				'height': 768,
				callbackOnStart: function(elem, $opts){
					//find title
					var self = $(elem)
					$opts.width = self.attr('int_width');
					$opts.height = self.attr('int_height');
					var title = self.attr('title')
					self.attr('title', title);
					return true;
				}
			});
			
			$('#tile_item_' + id + ' img').load(function() {
				var slideValue = Ext.getCmp('imageSlider').getValue() / 100;
				var self = $(this);
				var img = new Image();
				if (self.data('isLoaded')) {
					return;
				}
				var old_height = this.height,
					old_width = this.width;
				self.attr('ori_width', old_width)
				self.attr('ori_height', old_height)
				img.onload = function() {
					self.data('isLoaded', true)
					var new_width = parseInt(old_width * slideValue),
						new_height = parseInt(old_height * slideValue)
					
					
					self
					.attr('src', subject.model.full_url)
					.css('width', new_width)
					.css('height', new_height)
					
				}
				img.src = subject.model.src;
				
				var ratio = slideValue ;
									
				$('#tile_item_' + id).css('width', 110 * ratio).css('height', 115 * ratio)							 
				.find('td.td-thumb').css('width', 110 * ratio).css('height', 115 * ratio)
			});
		}
//        this.store.setBaseParam('application_id', subject.record.get('id'));
//        this.store.load();
        
    }
}); // eo extend
// register xtype
Ext.reg('ImagesTile', Pictomobile.ImagesTile);
// eof
