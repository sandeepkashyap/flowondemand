Ext.ns('Pictomobile');

var appsStore = new Ext.data.JsonStore({
    url: 'http://localhost/vista/mock/apps.js',
    root: 'apps',
    baseParams: {
        action: 'categories'
    },
    fields: ['id', 'vc_name']
});

Pictomobile.AppSwitcher = {
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
            cmb.publish('pictomobile.appswitcher.change', {record: rec, idx: idx});
        },
        
		onMessage: function(subject, message){
        } // eo function onMessage
    }
}
