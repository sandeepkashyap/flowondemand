Ext.ns('Pictomobile');
Ext.ns('Pictomobile.Record');
Ext.ns('Pictomobile.Store');
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
        items_per_page: 5
    },
    fields: Pictomobile.Record.Image
}); // column model
// Create RowActions Plugin
Pictomobile.action = new Ext.ux.grid.RowActions({
    header: 'Actions'    			
	//,autoWidth:false
    //,hideMode:'display'
    ,keepSelection: true,
    actions: [{
        qtipIndex: 'qtip1',
        iconCls: 'icon-open',
        tooltip: 'Open'
    }, {
        iconCls: 'icon-p',
        tooltip: 'Configure',
        qtipIndex: 'qtip2',
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
				title: 'Edit picture',
				modal: true,
				layout: 'fit',
				width: 500,
				height: 350,
				items: [
					{
						xtype: 'editpictureform',
						data: {
							grid: grid,
							record: record,
							row: row							
						}
					}
				
				]
			}).show();
        },
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
    ,
    initComponent: function(){
    
        // hard coded - cannot be changed from outside
        var config = {
            // store
            store: Pictomobile.Store.ImagesGridStore,
            plugins: [new Ext.ux.grid.RowEditor({
                saveText: 'Update'
            }), Pictomobile.action],
            columns: [{
                dataIndex: 'thumbnail',
                header: 'Thumbnail',
                width: 200,
                renderer: this.renderThumbnail.createDelegate(this)
            }, {
                dataIndex: 'name',
                header: 'Name',
                width: 40,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'url',
                header: 'Url',
                width: 80,
                editor: {
                    xtype: 'textfield',
                    allowBlank: false
                }
            }, {
                dataIndex: 'received',
                header: 'created',
                width: 200
            }, {
                dataIndex: 'indexed',
                header: 'Indexed',
                width: 200
            }, Pictomobile.action] // force fit
            ,
            viewConfig: {
                forceFit: true,
                scrollOffset: 0
            } // tooltip template
            ,
            // paging bar on the bottom
            bbar: new Ext.PagingToolbar({
                pageSize: 5,
                store: Pictomobile.Store.ImagesGridStore,
                displayInfo: true,
                displayMsg: 'Displaying topics {0} - {1} of {2}',
                emptyMsg: "No topics to display",
                items: ['-', {
                    pressed: true,
                    enableToggle: true,
                    text: 'Show Preview',
                    cls: 'x-btn-text-icon details'
                }]
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
        
    } // eo function onRender
    ,
    renderThumbnail: function(val, cell, record){
        return "<img src=\"/vista/index.php/site/thumbnail/image/" + val + "\" alt=\"" + val + "\" title=\"\"/>";
    }
}); // eo extend
// register xtype
Ext.reg('imagesgrid', Pictomobile.ImagesGrid);
// eof
