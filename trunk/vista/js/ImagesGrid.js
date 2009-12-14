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
    mapping: "date_indexed"
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
    header: 'Actions'    //,autoWidth:false
    //,hideMode:'display'
    ,
    keepSelection: true,
    actions: [{
        qtipIndex: 'qtip1',
        iconCls: 'icon-open',
        tooltip: 'Open'
    }, {
        iconCls: 'icon-p',
        tooltip: 'Configure',
        qtipIndex: 'qtip2'
        //,text:'Open'
    }, {
        iconIndex: 'action3',
        qtipIndex: 'qtip3',
        iconCls: 'icon-user',
        tooltip: 'User',
        style: 'background-image:url(../images/silk/icons/application_go.png) ! important;'
    }],
    callbacks: {
        'icon-plus': function(grid, record, action, row, col){
            Ext.ux.Toast.msg('Callback: icon-plus', 'You have clicked row: <b>{0}</b>, action: <b>{0}</b>', row, action);
        },
        'icon-open': function(grid, record, action, row, col){
            Ext.ux.Toast.msg('Callback: OPEN', 'You have clicked row: <b>{0}</b>, action: <b>{0}</b>', row, action);
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
        Ext.ux.Toast.msg('Event: action', 'You have clicked row: <b>{0}</b>, action: <b>{1}</b>', row, action);
    },
    beforeaction: function(){
        Ext.ux.Toast.msg('Event: beforeaction', 'You can cancel the action by returning false from this event handler.');
    },
    beforegroupaction: function(){
        Ext.ux.Toast.msg('Event: beforegroupaction', 'You can cancel the action by returning false from this event handler.');
    },
    groupaction: function(grid, records, action, groupId){
        Ext.ux.Toast.msg('Event: groupaction', 'Group: <b>{0}</b>, action: <b>{1}</b>, records: <b>{2}</b>', groupId, action, records.length);
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
            plugins: [new Ext.ux.grid.RowEditor({
                saveText: 'Update'
            }), Pictomobile.action, 'msgbus'],
            columns: [{
                dataIndex: 'thumbnail',
                header: 'Thumbnail',
                width: 110,
                renderer: this.renderThumbnail.createDelegate(this),
                editable: false
            }, {
                dataIndex: 'url',
                header: 'Url/Name',
                renderer: this.renderUrlAndName.createDelegate(this),
                width: 250,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'name',
                header: 'Name',
                hidden: true,
                menuDisabled: true,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'received',
                header: 'Created/Indexed',
                width: 100,
                renderer: this.renderReceived.createDelegate(this)
            }, Pictomobile.action] // force fit
            ,viewConfig: {
                forceFit: true,
                scrollOffset: 0
            } // tooltip template
            ,bbar: new Ext.PagingToolbar({ // paging bar on the bottom
                id: 'imagePaging',
                pageSize: 20,
                store: Pictomobile.Store.ImagesGridStore,
                displayInfo: true,
                displayMsg: 'Displaying topics {0} - {1} of {2}',
                emptyMsg: "No topics to display",
                items: ['-', {
					pressed: true,
					text: 'Switch to tile',
					scope: this,
					cls: 'x-btn-text-icon icon-grid',
					handler: function(){
						Ext.ux.Toast.msg('Show preview', 'You have clicked row: <b>{0}</b>, action: <b>{0}</b>', 1, 2);
						this.publish('pictomobile.image.viewmode.change', 1);
					}
				}, '-']
            })
        
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
    } // eo function onRender
    ,renderThumbnail: function(val, cell, record){
        return "<img src=\"" + App.data.thumnail_url + "/" + val + "\" alt=\"" + val + "\" title=\"\"/>";
    }
	,renderUrlAndName: function(val, cell, record){
        return "<span>" + record.get('url') + "</span><br/>" + "<span>" + record.get('name') + "</span>";
    }
	,renderReceived: function(val, cell, record){
        return "<span>" + record.get('created') + "</span><br/>" + "<span>" + record.get('indexed') + "</span>";
    }
	,onMessage: function(message, subject){
        this.store.setBaseParam('application_id', subject.record.get('id'));
        this.store.load();
        
    }
}); // eo extend
// register xtype
Ext.reg('imagesgrid', Pictomobile.ImagesGrid);



Pictomobile.ImagesTile = Ext.extend(Ext.Panel, {

    // configurables    
    border: false // {{{
    ,initComponent: function(){
    
        // hard coded - cannot be changed from outside
        var config = {
			plugins: ['msgbus'],
			layout: 'fit',
			items: new Ext.DataView({
			store: Pictomobile.Store.ImagesGridStore,
            tpl: new Ext.XTemplate(
				'<tpl for=".">', 
//					'<div class="thumb-wrap" id="{name}">', 
//					'<div class="thumb"><img src="' + App.data.thumnail_url + "/" +  '{thumbnail}" title="{name}"></div>', 
//					'<span class="x-editable">{name}</span></div>', 
					'<div class="tile-image">',
						'<table cellspacing="0" cellpadding="0"><tbody><tr><td width="160px" valign="middle" height="165px" align="center" style="padding: 0px;">',	
                        '<a href=""><img alt="{name}" title="" src="' + App.data.thumnail_url + "/" +  '{thumbnail}"/></a></td></tr></tbody></table>',
                    '</div>',
				'</tpl>', '<div class="x-clear"></div>'),
            autoHeight: true,
            multiSelect: true,
            overClass: 'x-view-over',
            itemSelector: 'div.thumb-wrap',
            emptyText: 'No images to display',
            
            prepareData: function(data){
//                data.shortName = Ext.util.Format.ellipsis(data.name, 15);
//                data.sizeString = Ext.util.Format.fileSize(data.size);
//                data.dateString = data.lastmod.format("m/d/Y g:i a");
                return data;
            },
            
            listeners: {
                selectionchange: {
                    fn: function(dv, nodes){
                        var l = nodes.length;
                        var s = l != 1 ? 's' : '';
                        panel.setTitle('Simple DataView (' + l + ' item' + s + ' selected)');
                    }
                }
            }	
			}),
            
			tbar: new Ext.Toolbar({            
        	items: [
        		new Ext.ux.SliderButton({
        			showText: true,
				    prependText: 'Icons size: ',
				    items: [{
				        text:'Large',
				        iconCls:'icon-large',
				        checked:true,
						value: 2
				    },{
				        text:'Big',
				        iconCls:'icon-big',
						value: 1.5
				    },{
				        text:'Medium',
				        iconCls:'icon-medium',
						value: 1
				    },{
				        text:'Small',
				        iconCls:'icon-small',
						value: 0.5
				    }],
				    imageBaseSize: {
				    	width: 80,
				    	height: 60
				    },
					listeners: {
						sliderchange: function(c, item){
							if(Ext.get('dataViewExample')){
								var items = Ext.get('dataViewExample').query("div.thumb-wrap .thumb img");
								changeSize(c, items, item);
							}
						}
					}
        		})
        	]}) //eo tbar
        	// paging bar on the bottom
            ,bbar: new Ext.PagingToolbar({
                id: 'tilePaging',
                pageSize: 20,
                store: Pictomobile.Store.ImagesGridStore,
                displayInfo: true,
                displayMsg: 'Displaying topics {0} - {1} of {2}',
                emptyMsg: "No topics to display",
                items: ['-', {
                    pressed: true,
					text: 'Switch to grid',
                    cls: 'x-btn-text-icon details',
					scope: this,
                    handler: function(){
                        Ext.ux.Toast.msg('Show preview', 'You have clicked row: <b>{0}</b>, action: <b>{0}</b>', 1, 2);
						this.publish('pictomobile.image.viewmode.change', 0);
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
        
//        this.subscribe("pictomobile.appswitcher.change")
    } // eo function onRender
    ,
    onMessage: function(message, subject){
//        this.store.setBaseParam('application_id', subject.record.get('id'));
//        this.store.load();
        
    }
}); // eo extend
// register xtype
Ext.reg('ImagesTile', Pictomobile.ImagesTile);
// eof
