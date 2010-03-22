Ext.ns('Pictomobile');

Pictomobile.ImageFilterForm = Ext.extend(Ext.form.FormPanel, {
    // defaults - can be changed from outside
    border: false,
    frame: true,
    labelWidth: 80,
	collapsible: true,
    url: App.data.login_url,
    
    constructor: function(config){
        config = config ||
        {};
        config.listeners = config.listeners ||
        {};
        Ext.applyIf(config.listeners, {
            actioncomplete: function(){
                if (console && console.log) {
                    console.log('actioncomplete:', arguments);
                }
            },
            actionfailed: function(){
                if (console && console.log) {
                    console.log('actionfailed:', arguments);
                }
            }
        });
        Pictomobile.ImageFilterForm.superclass.constructor.call(this, config);
    },
    initComponent: function(){
    
        // hard coded - cannot be changed from outsid
        var config = {
            defaultType: 'textfield',
            labelAlign: 'left',
			plugins: ['msgbus'],
			labelWidth: 50,
            items: [{
                name: 'image_url',
                width: 250,
                fieldLabel: 'Url'
            }, {
                name: 'image_name',
                width: 250,
                fieldLabel: 'Name'
            }],
			buttonAlign: 'left',
            buttons: [{
				xtype: 'spacer',
				width: 85
			}, {
				name: 'search',
                text: 'Search',
				iconCls: 'icon-filter',
                scope: this,
                handler: this.submit,
				plugins: 'defaultButton'
            }, {
				name: 'reset',
                text: 'Reset',
				iconCls: 'icon-reset',
                scope: this,
                handler: function() {
					
				}
            }]
        }; // eo config object
        // apply config
        Ext.apply(this, Ext.apply(this.initialConfig, config));
        
        // call parent
        Pictomobile.ImageFilterForm.superclass.initComponent.apply(this, arguments);
        
    } // eo function initComponent
    /**
     * Form onRender override
     */
    ,
    onRender: function(){
    
        // call parent
        Pictomobile.ImageFilterForm.superclass.onRender.apply(this, arguments);
        
        // set wait message target
        this.getForm().waitMsgTarget = this.getEl();
        
        // loads form after initial layout
        // this.on('afterlayout', this.onLoadClick, this, {single:true});
    
    } // eo function onRender
    
    /**
     * Submits the form. Called after Submit buttons is clicked
     * @private
     */
    ,
    submit: function(){
        var values = this.getForm().getValues();
		this.publish('pictomobile.image_filter', values)
    } // eo function submit
    
	,onSuccess: function(form, action) {
	}
	,onFailure: function(form, action) {
	}
}) //eo ImageFilterForm
// register xtype
Ext.reg('picImageFilterForm', Pictomobile.ImageFilterForm);