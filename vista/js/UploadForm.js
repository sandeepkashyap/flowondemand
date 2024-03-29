Ext.ns('Pictomobile');

Pictomobile.UploadForm = Ext.extend(Ext.form.FormPanel, {
    // defaults - can be changed from outside
    fileUpload: true,
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
        Pictomobile.UploadForm.superclass.constructor.call(this, config);
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
				id: 'ufUpload',
                name: 'Image[vc_image]',
                fieldLabel: 'Image from computer',
                xtype: 'fileuploadfield',
                emptyText: 'Select an image',
				buttonText: '',
                buttonCfg: {
                    iconCls: 'icon-upload'
                },
                clearButtonCfg: {
                    iconCls: 'icon-clear'
                },
				invalidText: 'Please select an image file',
				validator: function(value) {
					if (value == "") {
						return true;
					}
					var checkimg = value.toLowerCase();
					if (!checkimg.match(/(\.jpg|\.gif|\.png|\.JPG|\.GIF|\.PNG|\.jpeg|\.JPEG)$/)) {
						return false
					}
					return true;
				},
                allowBlank: true
            }, {
				id: 'ufImage',
                name: 'Image[from_url]',
                fieldLabel: 'From Url',
				enableKeyEvents: true,
				invalidText: 'Please input valid image url, or leave blank this field and select an image to upload on field Image from computer',
				validator: function() {
					var img = $('#mainFormImage'),
						hasUploadFile = false,
						ufUpload = Ext.getCmp('ufUpload')
					hasUploadFile = ufUpload && ufUpload.getValue() != ''
					if (hasUploadFile) {
						return true
					}
					return img.data('isValid');
				},
				listeners: {
					'change': {
						fn: function(field, e) {
							var value = field.getValue();
							$('#mainFormImage').attr('src', value).data('isValid', false)
						}
						,deplay: 4000
					}
				}
            }, {
				xtype: 'box',
                anchor: '',
                isFormField: true,
                fieldLabel: 'Image',
                autoEl: {
                    tag: 'div',
                    children: [{
						id: 'mainFormImage',
                        tag: 'img',
                        qtip: '',
						width: '80px',
                        src:  Ext.BLANK_IMAGE_URL 
                    }, {
                        tag: 'div',
                        style: 'margin:0 0 4px 0'
                    }]
                }
				,listeners: {
					scope: this,
					'afterrender': {
						fn: function() {
							var self = this;
							$('#mainFormImage')
							.error(function() {
								$(this).data('isValid', false)
								var field = Ext.getCmp('ufImage')
								field.markInvalid('Please input valid image url, or leave blank this field and select an image to upload on field Image from computer')
								Ext.getCmp('ufSubmit').setDisabled(true)
								
								self.fireEvent('clientvalidation', self, false);
								})
							.load(function() {
								$(this).data('isValid', true)
								Ext.getCmp('ufImage').clearInvalid()
							})							
						}
					}
				}
			}, {
                name: 'Image[vc_name]',
                fieldLabel: 'Name'
            }, {
                name: 'Image[vc_url]',
                fieldLabel: 'Url',
                allowBlank: false
            }],
            buttons: [{
                text: 'Reset',
                scope: this,
                handler: this.onResetClick
            }, {
				id: 'ufSubmit',				
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
        Pictomobile.UploadForm.superclass.initComponent.apply(this, arguments);
        
    } // eo function initComponent
    /**
     * Form onRender override
     */
    ,
    onRender: function(){
    
        // call parent
        Pictomobile.UploadForm.superclass.onRender.apply(this, arguments);
        
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
		$('#mainFormImage').attr('src', Ext.BLANK_IMAGE_URL)
        // any additional load click processing here
    } // eo function onLoadClick
    /**
     * Submits the form. Called after Submit buttons is clicked
     * @private
     */
    ,
    submit: function(){
		if (App.data.application_id > 0) {
	        this.getForm().submit({
	            url: this.url,
	            scope: this,
	            success: this.onSuccess,
	            failure: this.onFailure,
	            params: {
	                format: 'json',
					application_id: App.data.application_id
	            },
	            waitMsg: 'Saving...'
	        });
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
		$('#mainFormImage').attr('src', Ext.BLANK_IMAGE_URL)
        var model = action.result.model
        var record = new Pictomobile.Record.Image({
            id: model.id_image,
            thumbnail: model.vc_image,
            name: model.vc_name,
            url: model.vc_url,
			width: model.int_width,
			height: model.int_height,
            created: model.dt_created,
            indexed: model.dt_indexed
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
}) //eo UploadForm
// register xtype
Ext.reg('picuploadform', Pictomobile.UploadForm);
