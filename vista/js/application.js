/*global Ext, Application */

Ext.BLANK_IMAGE_URL = App.data.homepage_url + '/ext/resources/images/default/s.gif';

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
        //        application.imagesStore = new Ext.data.JsonStore({
        //            url: 'mock/images.js',
        //            root: 'images',
        //            id: 'vc_name',
        //            fields: application.imageRecord,
        //            listeners: {
        //                "add": {
        //                    fn: function(inStore, inRecords, inIndex){
        //                    }
        //                },
        //                "remove": {
        //                    fn: function(inStore, inRecord, inIndex){
        //                    }
        //                }
        //            }
        //        });
        //        
        //        application.imagesStore.load();
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
                title: '    ',
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
                items: [{
                    title: "Upload",
                    id: "uploadImage",
                    xtype: "picuploadform"
                }, {
                    title: "Upload CSV",
                    id: "uploadCsv",
                    xtype: "picuploadform"
                }]
            }, {
                id: "toolbarArea",
                autoHeight: true,
                border: false,
                region: "north",
                items: [{
                    xtype: "toolbar",
                    items: [{
                        text: "Switch to: "
                    }, {
                        xtype: "tbspacer"
                    }, Pictomobile.AppSwitcher, {
                        xtype: 'splitbutton',
                        text: 'Edit application',
                        iconCls: 'icon-form-edit',
                        plugins: ['msgbus'],
                        handler: function(){
                            //this.publish('pictomobile.application.edit', {p: 'khanh'})
                            var rec = Ext.getCmp('appSwitcher').getStore().getById(Ext.getCmp('appSwitcher').getValue())
                            new Ext.Window({
                                id: "wndEditApplication",
                                title: 'Edit application',
                                modal: true,
                                layout: 'fit',
                                width: 500,
                                height: 350,
                                items: [{
                                    xtype: 'picapplicationform',
                                    data: {
                                        record: rec
                                    }
                                }]
                            }).show();
                        },
                        menu: [{
                            text: 'New application',
                            iconCls: 'icon-form-add',
                            handler: function(){
                            
                                new Ext.Window({
                                    id: "wndEditApplication",
                                    title: 'New application',
                                    modal: true,
                                    layout: 'fit',
                                    width: 500,
                                    height: 350,
                                    items: [{
                                        xtype: 'picapplicationform',
                                        data: {
                                            record: new Pictomobile.Record.Application({
                                                int_nbanwsers: 1,
                                                int_tokens: 0,
                                                int_size: 50000,
                                                float_scoremin: 0.25,
                                                int_teches: 0,
                                                nm_sens: 0
                                            })
                                        }
                                    }]
                                }).show();
                            }
                        }]
                    }]
                
                }]
            }, {
                region: "center",
                id: "mainArea",
                title: "Pictures",
                layout: 'card',
                layoutConfig: {
                    deferredRender: true
                },
                border: false,
                closable: false,
                activeItem: 0,
                plain: true,
				plugins : ['msgbus'],               
                items: [{
                    // Contacts icon view.
                    xtype: "imagesgrid",
                    id: "imagesGrid"
                }, {
                    xtype: 'ImagesTile',
					id: 'imagesTile'
                }],
				bbar: new Ext.ux.StatusBar({
					id: 'statusbar',
					plugins: ['msgbus']
					// defaults to use when the status is cleared:
		            ,defaultText: 'Ready'
		            ,defaultIconCls: 'x-status-valid',
		        
		            // values to set initially:
		            text: 'Ready',
		            iconCls: 'x-status-valid',
		
		            // any standard Toolbar items:
		            items: [{
						id: 'sbar-btn-undo',
	                    text: 'Undo delete',
						iconCls: 'icon-undo',						
						disabled: true,
	                    handler: function (){
							this.setDisabled(true)
	                        var rel = $('a.undo_link').attr('rel')
							var undo_url = App.extendUrl(App.data.image_undo_trash_url, {id: rel, format: 'json'});
							$.ajax({
							url: undo_url,
							success: function(responseText) {
								var json = $(document.body).data('deleted-record')
								var record = new Pictomobile.Record.Image({
									id: json.id_image,
									name: json.vc_name,
									url: json.vc_url,
									thumbnail: json.vc_image,
									created: json.dt_created,
									indexed: json.dt_indexed,
									height: json.int_height,
									width: json.int_width
								});
								Ext.getCmp('imagesGrid').getStore().insert(0, record);
								Ext.getCmp('imagesGrid').getView().scrollToTop();
								
								Ext.getCmp('statusbar').clearStatus({useDefaults:true});
								Ext.ux.Toast.msg('Undo', 'The image <b>{0}</b> has been restore from Trash', record.get('name'));
							},
							error: function(res) {

							},
							complete: function(res) {

							}
						});
	                    }
					}] //oe item status bar
				})//eo bbar 
				,listeners: {
					'render': {
						fn: function() {
							this.subscribe("pictomobile.image.viewmode.change")
						}
					}
				},
				onMessage: function(message, subject) {
					Ext.getCmp('mainArea').getLayout().setActiveItem(subject)
				}
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
    
//	Ext.ux.Lightbox.register('a[rel^=lightbox]');
//	Ext.ux.Lightbox.register('a.lb-flower', true); // true to show them as a set

    // code here

}); // eo function onReady
// eof
