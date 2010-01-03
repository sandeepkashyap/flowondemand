Ext.ns('Pictomobile');

Pictomobile.LoginForm = Ext.extend(Ext.form.FormPanel, {
    // defaults - can be changed from outside
    border: false,
    frame: true,
    labelWidth: 80,
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
        Pictomobile.LoginForm.superclass.constructor.call(this, config);
    },
    initComponent: function(){
    
        // hard coded - cannot be changed from outsid
        var config = {
            defaultType: 'textfield',
            defaults: {
                anchor: '-24'
            },
            monitorValid: true,
            autoScroll: true, // ,buttonAlign:'right'
            labelAlign: 'right',
			labelWidth: 90,
            items: [{
                name: 'User[username]',
                fieldLabel: 'User name',
                allowBlank: false
            }, {
                name: 'User[password]',
                fieldLabel: 'Password',
				allowBlank: false
            }, {
				xtype: 'checkbox',
                name: 'User[remember]',
                fieldLabel: 'Remember me'
			}],
			buttonAlign: 'center',
            buttons: [{
                text: 'Login',
				cls: 'x-btn-text-icon',
				iconCls: 'icon-key',
                formBind: true,
                scope: this,
                handler: this.submit
            }]
        }; // eo config object
        // apply config
        Ext.apply(this, Ext.apply(this.initialConfig, config));
        
        // call parent
        Pictomobile.LoginForm.superclass.initComponent.apply(this, arguments);
        
    } // eo function initComponent
    /**
     * Form onRender override
     */
    ,
    onRender: function(){
    
        // call parent
        Pictomobile.LoginForm.superclass.onRender.apply(this, arguments);
        
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
        this.getForm().submit({
            url: this.url,
            scope: this,
            success: this.onSuccess,
            failure: this.onFailure,
            params: {
                format: 'json'
            },
            waitMsg: 'Saving...'
        });
    } // eo function submit
    
	,onSuccess: function(form, action) {
		window.location = App.data.application_url
	}
	,onFailure: function(form, action) {
		eval('var result = ' + action.response.responseText)
		Ext.ux.Toast.msg('Login errors', result.errors);
	}
}) //eo LoginForm
// register xtype
Ext.reg('picLoginForm', Pictomobile.LoginForm);

Pictomobile.ForgotPassword = Ext.extend(Ext.form.FormPanel, {
    // defaults - can be changed from outside
    border: false,
    frame: true,
    labelWidth: 80,
    url: App.data.image_quick_add_url,
    
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
        Pictomobile.ForgotPassword.superclass.constructor.call(this, config);
    },
    initComponent: function(){
    
        // hard coded - cannot be changed from outsid
        var config = {
            defaultType: 'textfield',
            defaults: {
                anchor: '-24'
            },
            monitorValid: true,
            autoScroll: true, // ,buttonAlign:'right'
            labelAlign: 'right',
			labelWidth: 90,
            items: [{
                name: 'User[email]',
                fieldLabel: 'Email',
                allowBlank: false
            }],
			buttonAlign: 'center',
            buttons: [{
                text: 'Submit',
				cls: 'x-btn-text-icon',
				iconCls: 'icon-key',
                formBind: true,
                scope: this,
                handler: this.submit
            }]
        }; // eo config object
        // apply config
        Ext.apply(this, Ext.apply(this.initialConfig, config));
        
        // call parent
        Pictomobile.ForgotPassword.superclass.initComponent.apply(this, arguments);
        
    } // eo function initComponent
    /**
     * Form onRender override
     */
    ,
    onRender: function(){
    
        // call parent
        Pictomobile.ForgotPassword.superclass.onRender.apply(this, arguments);
        
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
		var sbar = Ext.getCmp('statusbar')
		sbar.showBusy({
			text: 'Waiting...'
		})
//        this.getForm().submit({
//            url: this.url,
//            scope: this,
//            success: this.onSuccess,
//            failure: this.onFailure,
//            params: {
//                format: 'json'
//            },
//            waitMsg: 'Saving...'
//        });
    } // eo function submit    
}) //eo ForgotPassword
// register xtype
Ext.reg('picForgotPassword', Pictomobile.ForgotPassword);