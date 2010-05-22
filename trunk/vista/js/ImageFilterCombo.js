Ext.ns('Pictomobile');

Pictomobile.ImageFilterCombo = Ext.extend(Ext.form.ComboBox, {
    // defaults - can be changed from outside
    paramName : 'query',
	pageSize:10,
	
    initComponent: function(){
		
	    // Custom rendering Template
	    var resultTpl = new Ext.XTemplate(
	        '<tpl for="."><div class="search-item">',
				'<div class="detail"><span>{url}</span><br/><span>{name}</span></div>',
				'<div style="clear: both"></div>',
	        '</div></tpl>'
	    );
	    /*var resultTpl = new Ext.XTemplate(
	        '<tpl for="."><div class="search-item">',
	            '<div class="thumbnail"><img src="' + App.data.thumnail_url + '/{vc_image}" /></div>',
				'<div class="detail"><span>{vc_url}</span><br/><span>{vc_name}</span></div>',
				'<div style="clear: both"></div>',
	        '</div></tpl>'
	    );*/
	    
        // hard coded - cannot be changed from outsid
        var config = {
            fieldLabel: 'Search',
	        displayField:'name',
	        valueField:'name',
	        typeAhead: false,
	        loadingText: 'Searching...',
	        hideTrigger: true,
	        tpl: resultTpl,
	        minChars: 3,
			listeners: {
				'beforequery': function() {
					this.store.setBaseParam('application_id', App.data.application_id);
				},
				'select': function(combo, record, index) {
					var strTagStrippedText = record.get('name').replace(/<\/?[^>]+(>|$)/g, "");
					this.setValue(strTagStrippedText)
				},
				scope: this
			},
	        itemSelector: 'div.search-item',
		
        }; // eo config object
        // apply config
        Ext.apply(this, Ext.apply(this.initialConfig, config));
        
        // call parent
        Pictomobile.ImageFilterCombo.superclass.initComponent.apply(this, arguments);
        
    } // eo function initComponent
    /**
     * Form onRender override
     */
    ,
    onRender: function(){
    
        // call parent
        Pictomobile.ImageFilterCombo.superclass.onRender.apply(this, arguments);
        
    
    } // eo function onRender
    
}) //eo ImageFilterCombo
// register xtype
Ext.reg('picImageFilterCombo', Pictomobile.ImageFilterCombo);