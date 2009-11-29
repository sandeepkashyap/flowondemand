Ext.ns('Pictomobile');

Pictomobile.EditPictureForm = Ext.extend(Ext.form.FormPanel, {
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
            items: [
			{
                name: 'Image[vc_image]',
                fieldLabel: 'Image from computer',
                xtype: 'fileuploadfield',
                emptyText: 'Select an image',
                buttonText: '',
                buttonCfg: {
                    iconCls: 'upload-icon'
                },
                allowBlank: false
            }, {
                xtype: 'box',
                anchor: '',
                isFormField: true,
                fieldLabel: 'Image',
                autoEl: {
                    tag: 'div',
                    children: [{
                        tag: 'img',
                        qtip: 'You can also have a tooltip on the image',
                        src: '/vista/index.php/site/thumbnail/image/' + this.data.record.data.thumbnail 
                    }, {
                        tag: 'div',
                        style: 'margin:0 0 4px 0',
                        html: 'Image Caption'
                    }]
                }
            }, {
                name: 'Image[from_url]',
                fieldLabel: 'From Url'
            }],
            buttons: [{
                text: 'Reset',
                scope: this,
                handler: this.onResetClick
            }, {
                text: 'Submit',
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
        // any additional load click processing here
    } // eo function onLoadClick
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
            created: '',
            indexed: ''
        });
        
        Pictomobile.Store.ImagesGridStore.add(record);
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
Ext.reg('editpictureform', Pictomobile.EditPictureForm);
