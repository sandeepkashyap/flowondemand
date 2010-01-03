/*global Ext, Application */

Ext.BLANK_IMAGE_URL = App.data.homepage_url + '/ext/resources/images/default/s.gif';

Ext.ns('Pictomobile');

Pictomobile.ROOT_URL = 'test.php';

var navHandler = function(direction){
    // This routine could contain business logic required to manage the navigation steps.

    // It would call setActiveItem as needed, manage navigation button state, handle any

    // branching logic that might be required, handle alternate actions like cancellation

    // or finalization, etc.  A complete wizard implementation could get pretty

    // sophisticated depending on the complexity required, and should probably be

    // done as a subclass of CardLayout in a real-world implementation.

};

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
        // Build the main UI itself.
        buildUI();
        // completed, and we're ready to go.
        Ext.getCmp("dialogPleaseWait").destroy();
        
    } // End initMain().
    var buildUI = function(){
        // Show please wait dialog.
        new Ext.Window({
            closable: false,
            modal: true,
            width: 400,
            height: 250,
            minimizable: false,
            resizable: false,
            draggable: false,
            shadowOffset: 8,
			layout: 'fit',
            items: [{
                layout: 'accordion',
                activeItem: 0, // make sure the active item is set on the container config!
                defaults: {
                    // applied to each contained panel
                    border: false
                },
                
                // the panels (or "cards") within the layout
                items: [{
                    id: 'cardLoginForm',
					title: 'Login',
                    xtype: 'picLoginForm'
                }, {
                    id: 'cardForgotPassword',
					title: 'Forgot password',
                    xtype: 'picForgotPassword'
                }]
				
            }]
        }).show();
        
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
