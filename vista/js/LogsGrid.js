Ext.ns('Pictomobile');
Ext.ns('Pictomobile.Record');
Ext.ns('Pictomobile.Store');

/**
 * @class Example.Grid
 * @extends Ext.grid.GridPanel
 */
Pictomobile.Record.Log = Ext.data.Record.create([{
    name: "id"
}, {
    name: "thumbnail"
}, {
    name: "point"
}, {
    name: "result"
}, {
    name: "dt_created"
}]);

Pictomobile.Store.LogsGridStore = new Ext.data.JsonStore({
    id: 'logsStore',
    root: 'logs',
    totalProperty: 'totalCount',
    url: App.data.logs_store,
    baseParams: {
        format: 'json',
        skip_layout: '1',
        items_per_page: 20
    },
    fields: Pictomobile.Record.Log
}); // column model

Pictomobile.LogsGrid = Ext.extend(Ext.grid.GridPanel, {

    // configurables
    border: false // {{{
    ,initComponent: function(){
    
        // hard coded - cannot be changed from outside
        var config = {
            // store
            store: Pictomobile.Store.LogsGridStore,
            plugins: ['msgbus'],
            columns: [{
                dataIndex: 'thumbnail',
                header: 'Thumbnail',
                renderer: this.renderThumbnail.createDelegate(this),
            },  {
                dataIndex: 'point',
                header: 'Key point',
            }, {
                header: 'Message',
				dataIndex: 'result'
			}, {
                header: 'Index on',
				dataIndex: 'dt_created'
			}] // force fit
            ,viewConfig: {
                forceFit: false,
                scrollOffset: 0
            } // tooltip template
            ,tbar: new Ext.PagingToolbar({ // paging bar on the bottom
                id: 'logPaging',
                pageSize: 20,
                store: Pictomobile.Store.LogsGridStore,
                displayInfo: true,
                displayMsg: 'Displaying topics {0} - {1} of {2}',
                emptyMsg: "No topics to display"
            })// eo tbar
            ,listeners: {activate: function() {
				alert('asdfasdf')
			}}
        
        }; // eo config object
        // apply config
        Ext.apply(this, Ext.apply(this.initialConfig, config));
        
        // call parent
        Pictomobile.LogsGrid.superclass.initComponent.apply(this, arguments);
        
		
    } // eo function initComponent
    // }}}
    // {{{
    ,
	onActivate: function() {
		console.log('123');
	}
    ,onRender: function(){
        // call parent
        Pictomobile.LogsGrid.superclass.onRender.apply(this, arguments);
        
		this.store.setBaseParam('application_id', App.data.application_id);
	    this.store.load();
		
        this.subscribe("pictomobile.image.index")
        this.subscribe("pictomobile.appswitcher.change")
		
		this.getView().on('refresh', this.onViewRefresh, this)
		this.getView().on('rowsinserted', this.onRowAdded, this)
		this.getView().on('rowupdated', this.onRowUpdated, this)
    } // eo function onRender
    ,renderThumbnail: function(val, cell, record){
        return "<img src=\"" + App.data.thumnail_url + "/" + val + "\" alt=\"" + val + "\" title=\"\"/>";
    }
	,onMessage: function(message, subject){
		if (message == 'pictomobile.appswitcher.change') {
	        this.store.setBaseParam('application_id', subject.record.get('id'));
	        this.store.load();
		} else if (message == 'pictomobile.image.index') {
			var model = subject.data.log;
			var record = new Pictomobile.Record.Log({
	            id: 			model.id,
	            thumbnail: 		model.thumbnail,
	            point: 			model.point,
            	result: 		model.result,
	            dt_created: 	model.dt_created,
	        });
			this.getStore().insert(0, record)
		} 
    }
	,onRowAdded: function() {
		this.onViewRefresh()
	}
	,onRowUpdated: function() {
		this.onViewRefresh()
	}
	,onViewRefresh: function() {
			
	}
	
}); // eo extend
// register xtype
Ext.reg('LogsGrid', Pictomobile.LogsGrid);
// eof
