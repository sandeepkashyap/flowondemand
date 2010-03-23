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
		
		var ds = new Ext.data.Store({
	        url: App.data.images_store,
			baseParams: {
				format: 'json'
			},
	        reader: new Ext.data.JsonReader({
	            root: 'images',
	            totalProperty: 'totalCount',
	            id: 'id_image'
	        }, [
	            {name: 'dt_creted'},
	            {name: 'vc_url'},
	            {name: 'vc_name'},
	            {name: 'vc_image'},
	            {name: 'id_image'}
	        ])
	    });
	
	    // Custom rendering Template
	    var resultTpl = new Ext.XTemplate(
	        '<tpl for="."><div class="search-item">',
	            '<div class="thumbnail"><img src="' + App.data.thumnail_url + '/{vc_image}" /></div>',
				'<div class="detail"><span>{vc_url}</span><br/><span>{vc_name}</span></div>',
				'<div style="clear: both"></div>',
	        '</div></tpl>'
	    );
	    
        // hard coded - cannot be changed from outsid
        var config = {
            defaultType: 'textfield',
            labelAlign: 'left',
			plugins: ['msgbus'],
			labelWidth: 80,
            items: [{
				name: 'query',
                xtype: 'combo',
                fieldLabel: 'Search',
				store: ds,
				pageSize:10,
		        displayField:'vc_url',
		        valueField:'vc_url',
		        typeAhead: false,
		        loadingText: 'Searching...',
		        width: 300,
		        hideTrigger: false,
		        tpl: resultTpl,
		        minChars: 3,
				listeners: {
					'beforequery': function() {
						this.store.setBaseParam('application_id', App.data.application_id);
						this.store.setBaseParam('url_name', Ext.getCmp('url_name_combo').getValue());
					}
				},
		        itemSelector: 'div.search-item'
            }, {
				id: 'url_name_combo',
                name: 'url_name',
                xtype: 'combo',
				displayField:'value',
				valueField: 'key',
				value: 'all',
		        typeAhead: true,
		        mode: 'local',
		        forceSelection: true,
		        triggerAction: 'all',
		        selectOnFocus:true,
				store: new Ext.data.ArrayStore({
			        fields: ['key', 'value'],
			        data : [['all', 'All'],['url', 'Url'], ['name', 'Name']] 
			    }),
                width: 100,
                fieldLabel: 'Url/Name'
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
				iconCls: 'icon-clear',
                scope: this,
                handler: function() {
					this.getForm().reset();
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