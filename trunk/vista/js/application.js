/*global Ext, Application */

Ext.BLANK_IMAGE_URL = 'ext/resources/images/default/s.gif';

Ext.ns('Pictomobile');

Pictomobile.ROOT_URL = 'test.php';

function Application(){

    this.imagesStore = null;
    this.imageRecord = null;
    
    this.init = function(){
    
        // Show please wait dialog.
        new Ext.Window({
            applyTo: "dialogPleaseWait",
            closable: false,
            modal: true,
            width: 200,
            height: 100,
            minimizable: false,
            resizable: false,
            draggable: false,
            shadowOffset: 8,
            id: "dialogPleaseWait"
        }).show(Ext.getDom("divSource"));
        // Timeout to give the dialog time to show.
        setTimeout("application.initMain()", 500);
        
    } // End init().
    /**
     * The main initialization tasks, kicked off by init().
     */
    this.initMain = function(){
    
        // Create record descriptors for each of the four categories.
        createRecordDescriptors();
        
        // Create the data stores for each of the four categories.
        createDataStores();
        
        
        // Build the main UI itself.
        buildUI();
        
        // All done, hide please wait, set flag to indicate initialization has
        // completed, and we're ready to go.
        Ext.getCmp("dialogPleaseWait").destroy();
        
    } // End initMain().
    var createDataStores = function(){
        application.imagesStore = new Ext.data.JsonStore({
            url: 'mock/images.js',
            root: 'images',
            id: 'vc_name',
            fields: application.imageRecord,
            listeners: {
                "add": {
                    fn: function(inStore, inRecords, inIndex){
                    }
                },
                "remove": {
                    fn: function(inStore, inRecord, inIndex){
                    }
                }
            }
        });
        
        application.imagesStore.load();
    } //eo createDataStores
    var createRecordDescriptors = function(){
        // Create record descriptor for note.
        application.imageRecord = Ext.data.Record.create([{
            name: "id",
            mapping: "id"
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
    }//eo createRecordDescriptors
    var buildUI = function(){
        var vp = new Ext.Viewport({
            layout: 'border',
            items: [{
                // Categories accordion on left side of screen.
                region: "west",
                id: "categoriesArea",
                title: "Categories",
                split: true,
                width: 260,
                minSize: 10,
                maxSize: 260,
                collapsible: true,
                layout: "accordion",
                // Applied to each contained panel.
                defaults: {
                    bodyStyle: "overflow:auto;padding:10px;"
                },
                layoutConfig: {
                    animate: true
                },
                items: []
            }, {
                id: "toolbarArea",
                autoHeight: true,
                border: false,
                region: "north",
                items: [{
                    xtype: "toolbar",
                    items: [{
                        text: "New Note",
                        icon: "images/toolbarNote.gif",
                        cls: "x-btn-text-icon"
                    }, {
                        xtype: "tbspacer"
                    }, {
                        xtype: "tbspacer"
                    }]
                
                }]
            }, {
                region: "south",
                id: "formArea",
                split: true,
                collapsible: true,
                height: 330,
                minSize: 10,
                maxSize: 400,
                title: "Upload",
                layout: 'hbox',
                layoutConfig: {
                    padding: '5 10 5 10',
                    align: 'stretch',
                    pack: 'start',
                },
                items: [{
                    title: "Upload",
                    flex: 1,
                    id: "uploadImage",
                    xtype: "picuploadform"
                }, {
                    xtype: 'spacer',
                    width: 10
                }, {
                    title: "Upload CSV",
                    flex: 1,
                    id: "uploadCsv",
                    xtype: "picuploadform"
                }]
            }, {
                region: "center",
                id: "mainArea",
                title: "Pictures",
                layout: 'fit',
                items: [{
                    // Contacts icon view.
                    xtype: "imagesgrid",
                    id: "imagesGrid"                    
                }]
            }]
        });
        
        vp.doLayout();
    } //eo buildUI
} //eo Application function  
var application = new Application()

// application main entry point
Ext.onReady(function(){

    Ext.QuickTips.init();
    Ext.form.Field.prototype.msgTarget = "side";
    
    application.init();
    
    // code here

}); // eo function onReady
// eof
