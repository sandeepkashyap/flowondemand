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
    }],
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
		
    }
});

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
    border: false // {{{
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
						Ext.ux.Toast.msg('Show preview', 'You have clicked row: <b>{0}</b>, action: <b>{0}</b>', 1, 2);
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
        
        // load store
        this.store.load();
        
        this.subscribe("pictomobile.appswitcher.change")
        this.subscribe("pictomobile.image.change")
		
		this.getView().on('refresh', this.onViewRefresh, this)
		this.getView().on('rowsinserted', this.onRowAdded, this)
		this.getView().on('rowupdated', this.onRowUpdated, this)
    } // eo function onRender
    ,renderThumbnail: function(val, cell, record){
		if (record.get('rand')) {
			var rand = new Date().format('U');
	        return "<a rel=\"lightbox\" class=\"fancy-group\" href=\"" + App.data.image_full_url + "/id/" + record.get('id') + ".jpg?rand="+rand+"\" int_width='"+record.get('width')+"' int_height='"+record.get('height')+"' title='" +record.get('name') +  "'><img src=\"" + App.data.thumnail_url + "/" + val + "?rand="+ rand + " \" alt=\"" + val + "\" title=\"\"/></a>";			
		}
        return "<a rel=\"lightbox\" class=\"fancy-group\" href=\"" + App.data.image_full_url + "/id/" + record.get('id') + ".jpg\" int_width='"+record.get('width')+"' int_height='"+record.get('height')+"' title='" +record.get('name') +  "'><img src=\"" + App.data.thumnail_url + "/" + val + "\" alt=\"" + val + "\" title=\"\"/></a>";
    }
	,renderUrlAndName: function(val, cell, record){
        return "<span id='vc_url:"+record.get('id')+"' title='Click to edit' class='editableInput'>" + record.get('url') + "</span><br/>" + "<span id='vc_name:"+record.get('id')+"' class='editableInput'>" + record.get('name') + "</span>";
    }
	,renderReceived: function(val, cell, record){		
        return "<span class='fuzzyDate' title='"+ record.get('created') +"'>"+record.get('created')+"</span><br/>" + "<span class='fuzzyDate' title='"+record.get('indexed')+"'>"+record.get('indexed')+"</span>";
    }
	,onMessage: function(message, subject){
		if (message == 'pictomobile.image.change') {
			var store = this.getStore();
			var record = store.getById(subject.old.id)
			record.set('thumbnail', subject.model.thumbnail);
			record.set('width', subject.model.width);
			record.set('height', subject.model.height);
			record.set('rand', true);
			store.commitChanges();
			Ext.ux.Toast.msg('Image changed', 'Image change successful');
		} else if (message == 'pictomobile.appswitcher.change') {
	        this.store.setBaseParam('application_id', subject.record.get('id'));
	        this.store.load();			
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
		
		$('span.editableInput').editable(App.data.image_quick_update_url, {
			placeholder: '<span class="edit_placeholder">Click to edit...</span>',
			tooltip   : "Click to edit. Press <Ente>r to save or <Escapse> to cancel",
			event : 'click',
			submit: null,
			cancel: null,
			width: '100%',
			height: 'none',			
			onerror: function(form, target, xhr) {
			}

		});
		
		//new Ext.fc.fuzzyDate().init();	
	}
	
}); // eo extend
// register xtype
Ext.reg('imagesgrid', Pictomobile.ImagesGrid);

Pictomobile.ImagesDataView = Ext.extend(Ext.DataView, {
	initComponent: function(){
		var config = {
			store: Pictomobile.Store.ImagesGridStore,
			tpl: new Ext.XTemplate('<tpl for=".">', '<div class="tile-image">', '<table cellspacing="0" cellpadding="0"><tbody><tr><td class="td-thumb" >', '<a title="{title}" class="fancy-group" href="' + App.data.image_full_url + '/id/{id}.jpg" int_width="{width}" int_height="{height}" title="{name}"><img alt="{name}" title="" src="' + App.data.thumnail_url + "/" + '{thumbnail}"/></a></td></tr></tbody></table>', '</div>', '</tpl>', '<div class="x-clear"></div>'),
			autoHeight: true,
			multiSelect: false,
			overClass: 'x-view-over',
			itemSelector: 'td.td-thumb',
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
			img.onload = function() {
				var slideValue = Ext.getCmp('imageSlider').getValue();
				self.data('isLoaded', true)
				self
				.attr('src', this.src).css('width', slideValue - 10)
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
});

Ext.reg('imagesdataview', Pictomobile.ImagesDataView);

Pictomobile.ImagesTile = Ext.extend(Ext.Panel, {
	
    // configurables    
    border: false // {{{
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
                        Ext.ux.Toast.msg('Show preview', 'You have clicked row: <b>{0}</b>, action: <b>{0}</b>', 1, 2);
						this.publish('pictomobile.image.viewmode.change', 0);
                    }
                }, {xtype: 'tbseparator'}, 'Resize images: ', new Ext.Slider({
					id: 'imageSlider',
					width: 300,
					minValue: 110,
					maxValue: 440,
					plugins: [new Ext.ux.SliderTip({
		                getText : function(s){
		                    return String.format('{0}px', s.value);
		                }
		            }), Ext.ux.FillSlider],
					listeners: {
						change: function(slider, value){
							if(Ext.get('imagesTile')){
								var rw = 1.6
								var rh = 2.3
								
								var items = Ext.get('imagesTile').select("div.tile-image");
								items.setWidth(value).setHeight((value + 5))
								
								var tds = Ext.get('imagesTile').select("td.td-thumb");
								tds.setWidth(value).setHeight(value + 5)
								
								var imgs = Ext.get('imagesTile').select("img");
								imgs.setWidth(value - 10)
							}
						}
					}
				})]
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
    } // eo function onRender
    ,
    onMessage: function(message, subject){
		if (message == 'pictomobile.appswitcher.change') {
			Ext.getCmp('imageSlider').setValue(110)
		}
//        this.store.setBaseParam('application_id', subject.record.get('id'));
//        this.store.load();
        
    }
}); // eo extend
// register xtype
Ext.reg('ImagesTile', Pictomobile.ImagesTile);
// eof
