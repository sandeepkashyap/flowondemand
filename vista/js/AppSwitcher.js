Ext.ns('Pictomobile');
Ext.ns('Pictomobile.Record');

Pictomobile.Record.Application = Ext.data.Record.create([{
    name: "id"
}, {
    name: "id_client"
}, {
    name: "int_nbanwsers",
	defaultValue: 1
}, {
    name: "int_tokens",
	defaultValue: 0
}, {
    name: "int_size",
	defaultValue: 50000
}, {
    name: "float_scoremin",
	defaultValue: 0.25
}, {
    name: "int_teches",
	defaultValue: 0
}, {
    name: "vc_name"
}, {
    name: "vc_repository"
}, {
    name: "vc_description"
}, {
    name: "nm_sens",
	defaultValue: 0
}]);

var appsStore = new Ext.data.JsonStore({
	autoLoad: false,
    url: App.data.apps_store,
	totalProperty: 'totalCount',
    root: 'apps',
    baseParams: {
        format: 'json',
        skip_layout: '1',
        items_per_page: 10
    },
    fields: Pictomobile.Record.Application
});



Pictomobile.AppSwitcher = {
	id: 'appSwitcher',
    xtype: 'combo',
    store: appsStore,
    plugins: ['msgbus'],
    displayField: 'vc_name',
    valueField: 'id',
    editable: false,
	pageSize: 10,
	width: 200,
    mode: 'local',
    forceSelection: true,
    triggerAction: 'all',
    emptyText: 'Select a application...',
    selectOnFocus: true,
    listeners: {
        'select': function(cmb, rec, idx){
			App.data.application_id = rec.get('id');
            cmb.publish('pictomobile.appswitcher.change', {record: rec, idx: idx});
        }
		,'render': function() {
			this.subscribe("pictomobile.applicaiton.added")
			this.subscribe("pictomobile.applicaiton.updated")
			
			this.getStore().load()
			this.getStore().on('load', function(store) {
				var count = store.getTotalCount()
				if (count == 1) {
					var rec = store.getAt(0)
					var cmb = Ext.getCmp('appSwitcher')
					cmb.setValue(rec.get('id'));
					cmb.fireEvent('select', cmb, rec, 0)
				}
			})
		}
    }
	,onMessage: function(subject, message){
		if (subject == 'pictomobile.applicaiton.updated') {
			var record = this.getStore().getById(message.recordId)
			for(var i in record.fields.keys) {
				var key = record.fields.keys[i]
				
				if (Ext.isPrimitive(key)) {
					record.set(key, message.model[key]);					
				}
			}
			this.getStore().commitChanges();
			this.setValue(record.get('id'));
		} else if (subject == 'pictomobile.applicaiton.added') {
			var record = new Pictomobile.Record.Application({
	            id: message.model.id
	        });
			record.id = message.model.id;
			for(var i in record.fields.keys) {
				var key = record.fields.keys[i]
				
				if (Ext.isPrimitive(key)) {
					record.set(key, message.model[key]);					
				}
			}
			this.getStore().insert(0, record)
			this.setValue(record.get('id'))
			this.fireEvent('select', this, record, 0)
		}
    } // eo function onMessage
	
}
