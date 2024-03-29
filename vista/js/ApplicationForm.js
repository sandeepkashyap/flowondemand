Ext.ns('Pictomobile');

Pictomobile.ApplicationForm = Ext.extend(Ext.form.FormPanel, {
    // defaults - can be changed from outside
    border: false,
    frame: true,
    labelWidth: 80,
    
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
        Pictomobile.ApplicationForm.superclass.constructor.call(this, config);
    },
    initComponent: function(){
    
        // hard coded - cannot be changed from outsid
        var config = {
            defaultType: 'textfield',
            defaults: {
                anchor: '-24'
            },
			plugins: ['msgbus'],
            monitorValid: true,
            autoScroll: true, // ,buttonAlign:'right'
            labelAlign: 'top',
            items: [{
                name: 'application[vc_name]',
				dataIndex: 'vc_name',
                fieldLabel: '* Name',
                allowBlank: false
            }, {
                name: 'application[vc_repository]',
				dataIndex: 'vc_repository',
                fieldLabel: '* Repository',
				allowBlank: false
            }, {
                name: 'application[vc_description]',
				dataIndex: 'vc_description',
                fieldLabel: '* Description'
            }, {
                name: 'application[int_size]',
				dataIndex: 'int_size',
                fieldLabel: '* Image size',
                allowBlank: false
            }, {
                name: 'application[int_nbanwsers]',
				dataIndex: 'int_nbanwsers',
                fieldLabel: '* Anwsers',
                allowBlank: false
            }, {
                name: 'application[float_scoremin]',
				dataIndex: 'float_scoremin',
                fieldLabel: '* Score min',
                allowBlank: false
            }, {
                name: 'application[int_tokens]',
				dataIndex: 'int_tokens',
                fieldLabel: 'Tokens',
                allowBlank: true
            }, {
                name: 'application[int_teches]',
				dataIndex: 'int_teches',
                fieldLabel: 'Technes',
                allowBlank: true
            }, {
                name: 'application[nm_sens]',
				dataIndex: 'nm_sens',
                fieldLabel: 'Sens',
                allowBlank: true
            }],
            buttons: [{
				type: 'reset',
                text: 'Reset',
                scope: this,
                handler: this.onResetClick
            }, {
				type: 'submit',
                text: 'Submit',
                formBind: true,
                scope: this,
                handler: this.submit
            }]
        }; // eo config object
        // apply config
        Ext.apply(this, Ext.apply(this.initialConfig, config));
        
        // call parent
        Pictomobile.ApplicationForm.superclass.initComponent.apply(this, arguments);
        
    } // eo function initComponent
    /**
     * Form onRender override
     */
    ,
    onRender: function(){
    
        // call parent
        Pictomobile.ApplicationForm.superclass.onRender.apply(this, arguments);
        
        // set wait message target
        this.getForm().waitMsgTarget = this.getEl();
        
        // loads form after initial layout
        // this.on('afterlayout', this.onLoadClick, this, {single:true});
		
		this.subscribe('pictomobile.application.edit')
		this.subscribe('pictomobile.application.add')
		
		this.getForm().loadRecord(this.data.record);
    
    } // eo function onRender
    
	,onMessage: function(message, subject) {
	}
	
	/**
     * Load button click handler
     */   
	,
    onResetClick: function(){
        this.form.reset();
        // any additional load click processing here
    } // eo function onLoadClick
    /**
     * Submits the form. Called after Submit buttons is clicked
     * @private
     */
    ,
    submit: function(){
		var url = null;
		if (this.data.record.get('id') > 0) {
			url = App.extendUrl(App.data.apps_update_url, {id: this.data.record.get('id')});
		} else {
			url = App.data.apps_create_url;
		}
		
        this.getForm().submit({
            url: url,
            scope: this,
            success: this.onSuccess,
            failure: this.onFailure,
            params: {
                format: 'json'
            },
            waitMsg: 'Saving...'
        });
    } // eo function submit
    /**
     * Success handler
     * @param {Ext.form.BasicForm} form
     * @param {Ext.form.Action} action
     * @private
     */
    ,
    onSuccess: function(form, action){
        var model = action.result.model
		
		if (action.result.isNew) {
	        this.publish('pictomobile.applicaiton.added', {model: model});
		} else {
	        this.publish('pictomobile.applicaiton.updated', {recordId: this.data.record.id, model: model});
		}
        Ext.getCmp('wndEditApplication').close();
        
    } // eo function onSuccess
    /**
     * Failure handler
     * @param {Ext.form.BasicForm} form
     * @param {Ext.form.Action} action
     * @private
     */
    ,
    onFailure: function(form, action){
        this.showError(action.result.error || action.response.responseText);
    } // eo function onFailure
    /**
     * Shows Message Box with error
     * @param {String} msg Message to show
     * @param {String} title Optional. Title for message box (defaults to Error)
     * @private
     */
    ,
    showError: function(msg, title){
        title = title || 'Error';
        Ext.Msg.show({
            title: title,
            msg: msg,
            modal: true,
            icon: Ext.Msg.ERROR,
            buttons: Ext.Msg.OK
        });
    } // eo function showError
}) //eo ApplicationForm
// register xtype
Ext.reg('picapplicationform', Pictomobile.ApplicationForm);
