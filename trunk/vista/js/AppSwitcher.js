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
    url: App.data.apps_store,
    root: 'apps',
    baseParams: {
        format: 'json',
        skip_layout: '1',
        items_per_page: 20
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
    mode: 'remote',
    forceSelection: true,
    triggerAction: 'all',
    emptyText: 'Select a application...',
    selectOnFocus: true,
    listeners: {
        'select': function(cmb, rec, idx){
			App.data.application_id = rec.get('id');
            cmb.publish('pictomobile.appswitcher.change', {record: rec, idx: idx});
        },
        
		onMessage: function(subject, message){
        } // eo function onMessage
    }
}
