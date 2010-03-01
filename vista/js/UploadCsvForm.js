Ext.ns('Pictomobile');

Pictomobile.UploadCsvForm = Ext.extend(Ext.form.FormPanel, {
    // defaults - can be changed from outside
    fileUpload: true,
    border: false,
    frame: true,
    labelWidth: 80,
    url: '',
	popup_window: null,
    
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
        Pictomobile.UploadCsvForm.superclass.constructor.call(this, config);
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
            labelAlign: 'top',
            items: [{
                name: 'csv_file',
                fieldLabel: 'CSV file',
                xtype: 'fileuploadfield',
                emptyText: 'Select a csv file',
                buttonText: '',
                buttonCfg: {
                    iconCls: 'upload-icon'
                },
                allowBlank: false
            }, {
				xtype: 'combo',
				allowBlank: false,
				blankText: 'Please select or enter a delimiter character',
                name: 'delimiter',
                fieldLabel: 'Delimiter',
			    typeAhead: true,
			    triggerAction: 'all',
			    lazyRender:true,
			    mode: 'local',
			    store: new Ext.data.ArrayStore({
			        id: 0,
			        fields: [
			            'myId',
			            'displayText'
			        ],
			        data: [[';', ';'], [',', ','], ['|', '|'], ['tab', 'tab']]
			    }),
			    valueField: 'myId',
			    displayField: 'displayText',
				value: ';'
            }],
            buttons: [{
                text: 'Reset',
                scope: this,
                handler: this.onResetClick
            }, {
                text: 'Submit',
				cls: 'x-btn-text-icon',
				iconCls: 'icon-upload',
                formBind: true,
                scope: this,
                handler: this.submit
            }]
        }; // eo config object
        // apply config
        Ext.apply(this, Ext.apply(this.initialConfig, config));
        
        // call parent
        Pictomobile.UploadCsvForm.superclass.initComponent.apply(this, arguments);
        
    } // eo function initComponent
    /**
     * Form onRender override
     */
    ,
    onRender: function(){
    
        // call parent
        Pictomobile.UploadCsvForm.superclass.onRender.apply(this, arguments);
        
        // set wait message target
        this.getForm().waitMsgTarget = this.getEl();
        
        // loads form after initial layout
        // this.on('afterlayout', this.onLoadClick, this, {single:true});
    
    } // eo function onRender
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
		if (App.data.application_id > 0) {
			if (this.popup_window == null) {
				this.popup_window = new Ext.Window({
		            applyTo: "dialogCsvUpload",
		            closable: true,
		            modal: false,
		            width: 600,
		            height: 450,
		            minimizable: false,
		            resizable: true,
		            draggable: true,
		            shadowOffset: 8,
		            id: "dialogCsvUpload"
		        })
				
				this.popup_window.on('beforeclose', function(w) {
					document.getElementById('upload_target').src = "";
					w.hide();
					return false;
				}); 
			}
			this.popup_window.show().toFront();
			var f = this.getForm().getEl()
			var f_id = f.id
			f = document.getElementById(f_id);
			f.target = 'upload_target'
			f.action = App.data.image_csv_url + '/application/' + App.data.application_id;
			f.onsubmit = function() {
				document.getElementById(f_id).target = "upload_target";
			}
			f.submit();	
		} else {
			Ext.Msg.show({
			   title:'Error',
			   msg: 'Please choose application to upload image',
			   buttons: Ext.Msg.OK,			   
			   icon: Ext.MessageBox.ERROR
			});
		}
    } // eo function submit
    /**
     * Success handler
     * @param {Ext.form.BasicForm} form
     * @param {Ext.form.Action} action
     * @private
     */
    ,
    onSuccess: function(form, action){
        form.reset();
        var model = action.result.model
        var record = new Pictomobile.Record.Image({
            id: model.id_image,
            thumbnail: model.vc_image,
            name: model.vc_name,
            url: model.vc_url,
			width: model.int_width,
			height: model.int_height,
            created: '',
            indexed: ''
        });
		
        Pictomobile.Store.ImagesGridStore.insert(0, record);
        //        Ext.Msg.show({
        //            title: 'Success',
        //            msg: 'Form submitted successfully',
        //            modal: true,
        //            icon: Ext.Msg.INFO,
        //            buttons: Ext.Msg.OK
        //        });
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
}) //eo UploadCsvForm
// register xtype
Ext.reg('picUploadCsvForm', Pictomobile.UploadCsvForm);
