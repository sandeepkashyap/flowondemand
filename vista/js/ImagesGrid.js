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
    }]
);

Pictomobile.Store.ImagesGridStore = new Ext.data.JsonStore({
    id: 'imagesStore',
    root: 'images',
    totalProperty: 'totalCount',
    url: 'http://localhost/vista/index.php/image/image/getPage/application/4',
    baseParams: {
        format: 'json',
        skip_layout: '1',
		items_per_page: 5
    },
    fields: Pictomobile.Record.Image
}); // column model

Pictomobile.ImagesGrid = Ext.extend(Ext.grid.GridPanel, {

    // configurables
    border: false // {{{
    ,
    initComponent: function(){
    
        // hard coded - cannot be changed from outside
        var config = {
            // store
            store: Pictomobile.Store.ImagesGridStore,
            columns: [{
                dataIndex: 'thumbnail',
                header: 'Thumbnail',
                width: 200,
                renderer: this.renderThumbnail.createDelegate(this)
            }, {
                dataIndex: 'name',
                header: 'Name',
                width: 40
            }, {
                dataIndex: 'url',
                header: 'Url',
                width: 80
            }, {
                dataIndex: 'received',
                header: 'created',
                width: 200
            }, {
                dataIndex: 'indexed',
                header: 'Indexed',
                width: 200
            }] // force fit
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
