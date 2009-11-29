Ext.ns('Ext.ux.grid');
Ext.ux.ActionRegistry = function(){
	var types = {};
	return {
		register: function(atype, cls){
			types[atype] = cls;
			cls.atype = atype;
		},
		create: function(config, defaultType){
			return config.isAction ? config : new types[config.atype || defaultType](config);
		}
	};
}();
Ext.ux.Action = Ext.extend(Ext.Action, {
	actionProps: [
		'atype',
		'handler',
		'scope',
		'tbar',
		'bbar',
		'buttons',
		'cmenu',
		'key',
		'def'
	],
	constructor: function(config){
		config = Ext.apply({}, config);
		var props = this.actionProps;
		for(var i = 0, len = props.length; i < len; i++){
			var prop = props[i];
			if(this[prop] === undefined){
				this[prop] = config[prop];
			}
			delete config[prop];
		}
		Ext.ux.Action.superclass.constructor.call(this, Ext.apply(config, {
			handler: this.execute,
			scope: this
		}));
	},
	setHandler: function(fn, scope){
		this.handler = fn;
		this.scope = scope;
	},
	execute: function(){
		this.update();
		if(this.isValid()){
			this.handler.apply(this.scope || this, arguments);
		}
	},
	isValid: function(){
		return !this.isDisabled();
	},
	update: function(){
		// empty
	}
});
Ext.ux.ActionRegistry.register('action', Ext.ux.Action);
Ext.ux.ActionManager = Ext.extend(Object, {
	defaultAction: 'action',
	separatorRank: {
		' ': 1,
		'-': 2,
		'separator': 2,
		'->': 3
	},
	nonMenuSeparators: {
		' ': '-',
		'->': '-'
	},
	constructor: function(config){
		Ext.apply(this, config);
		var items = this.items;
		this.items = [];
		if(items){
			this.add(items);
		}
	},
	add: function(action){
		if(arguments.length > 1 || Ext.isArray(action)){
			var args = arguments.length > 1 ? arguments : action;
			for(var i = 0, len = args.length; i < len; i++){
				this.add(args[i]);
			}
			return;
		}
		if(typeof action != 'string'){
			action = Ext.ux.ActionRegistry.create(action, this.defaultAction);
			action.manager = this;
		}
		this.items.push(action);
		return action;
	},
	callEach: function(fnName, args){
		var items = this.items;
		for(var i = 0, len = items.length; i < len; i++){
			var item = items[i], fn;
			if(typeof item != 'string' && (fn = item[fnName])){
				fn.apply(item, args);
			}
		}
	},
	setDisabled: function(){
		this.callEach('setDisabled', arguments);
	},
	setHidden: function(){
		this.callEach('setHidden', arguments);
	},
	update: function(){
		this.callEach('update', arguments);
	},
	findAction: function(target){
		var items = this.items;
		for(var i = 0, len = items.length; i < len; i++){
			var item = items[i];
			if(typeof item != 'string' && item[target]){
				return item;
			}
		}
	},
	queryActions: function(target, includeSeparators, forMenu){
		var result = [], items = this.items, rank = 0, separator;
		for(var i = 0, len = items.length; i < len; i++){
			var item = items[i];
			if(typeof item == 'string'){
				if(includeSeparators){
					var irank = this.separatorRank[item] || 0;
					if(rank < irank){
						rank = irank;
						separator = forMenu ? this.nonMenuSeparators[item] || item : item;
					}
				}
			}else if(!target || item[target]){
				if(rank > 0){
					rank = 0;
					result.push(separator);
				}
				result.push(item);
			}
		}
		return result;
	},
	executeDefault: function(){
		var action = this.findAction('def');
		if(action){
			action.execute();
		}
	}
});

Ext.ux.PanelActions = Ext.extend(Object, {
	constructor: function(config){
		this.actionMgr = new Ext.ux.ActionManager(config);
	},
	init: function(p){
		var actionMgr = this.actionMgr,
			tbar = actionMgr.queryActions('tbar', true),
			bbar = actionMgr.queryActions('bbar', true),
			btns = actionMgr.queryActions('button'),
			akeys = actionMgr.queryActions('key');
		actionMgr.panel = p;
		if(tbar.length){
			var topToolbar = p.topToolbar;
			if(!topToolbar){
				p.topToolbar = tbar;
				p.elements += ',tbar';
			}else if(Ext.isArray(topToolbar)){
				p.topToolbar = topToolbar.concat(tbar);
			}else if(topToolbar.add){
				topToolbar.add.apply(topToolbar, tbar);
			}else if(Ext.isArray(topToolbar.items)){
				topToolbar.items = topToolbar.items.concat(tbar);
			}
		}
		if(bbar.length){
			var bottomToolbar = p.bottomToolbar;
			if(!bottomToolbar){
				p.bottomToolbar = bbar;
				p.elements += ',bbar';
			}else if(Ext.isArray(bottomToolbar)){
				p.bottomToolbar = bottomToolbar.concat(bbar);
			}else if(bottomToolbar.add){
				bottomToolbar.add.apply(bottomToolbar, bbar);
			}else if(Ext.isArray(bottomToolbar.items)){
				bottomToolbar.items = bottomToolbar.items.concat(bbar);
			}
		}
		if(btns.length){
			var buttons = p.buttons;
			if(!buttons){
				p.buttons = btns;
			}else if(Ext.isArray(buttons)){
				p.buttons = buttons.concat(btns);
			}
		}
		if(akeys.length){
			var keys = p.keys;
			if(!keys){
				keys = p.keys = [];
			}
			for(var i = 0, len = akeys.length; i < len; i++){
				var action = akeys[i], key = action.key;
				if(!Ext.isObject(key) || Ext.isArray(key)){
					key = {key: key};
				}
				keys.push(Ext.apply({
					handler: action.execute,
					scope: action
				}, key));
			}
			console.log(p.keys);
		}
		p.on('render', actionMgr.update, actionMgr, {single: true});
	}
});
Ext.preg('panelactions', Ext.ux.PanelActions);

Ext.ux.grid.GridActions = Ext.extend(Ext.ux.PanelActions, {
	init: function(p){
		Ext.ux.grid.GridActions.superclass.init.call(this, p);
		var actionMgr = this.actionMgr,
			cmenu = this.actionMgr.queryActions('cmenu', true, true);
		p.on('rowdblclick', actionMgr.executeDefault, actionMgr);
		p.getSelectionModel().on('selectionchange', actionMgr.update, actionMgr, {buffer: 50});
		if(cmenu.length){
			this.cmenu = new Ext.menu.Menu({
				items: cmenu
			});
			p.on('rowcontextmenu', this.onRowContextMenu, this);
		}
	},
	onRowContextMenu: function(grid, rowIndex, e){
		e.stopEvent();
		var selModel = grid.getSelectionModel();
		if(!selModel.isSelected(rowIndex)){
			selModel.selectRow(rowIndex);
		}
		this.cmenu.showAt(e.getXY());
	}
});
Ext.preg('gridactions', Ext.ux.grid.GridActions);

Ext.ux.grid.SingleRowAction = Ext.extend(Ext.ux.Action, {
	update: function(){
		var sm = this.manager.panel.getSelectionModel();
		this.setDisabled(sm.getCount() != 1);
	},
	getSelected: function(){
		return this.manager.panel.getSelectionModel().getSelected();
	}
});
Ext.ux.ActionRegistry.register('singlerow', Ext.ux.grid.SingleRowAction);
Ext.ux.grid.MultiRowAction = Ext.extend(Ext.ux.Action, {
	update: function(){
		var sm = this.manager.panel.getSelectionModel();
		this.setDisabled(sm.getCount() < 1);
	},
	getSelections: function(){
		return this.manager.panel.getSelectionModel().getSelections();
	}
});
Ext.ux.ActionRegistry.register('multirow', Ext.ux.grid.MultiRowAction);
Ext.ux.grid.SelectAllAction = Ext.extend(Ext.ux.Action, {
	constructor: function(config){
		Ext.ux.grid.SelectAllAction.superclass.constructor.call(this, Ext.apply({
			handler: this.selectAll
		}, config));
	},
	update: function(){
		var grid = this.manager.panel;
		this.setDisabled(grid.getSelectionModel().getCount() >= grid.getStore().getCount());
	},
	selectAll: function(){
		this.manager.panel.getSelectionModel().selectAll();
	}
});
Ext.ux.ActionRegistry.register('selectall', Ext.ux.grid.SelectAllAction);

Ext.onReady(function() {
	Ext.QuickTips.init();
	var fields = [], data = [], columns = [];
	for(var i = 0; i < 10; i++){
		fields.push({name: 'field' + i});
		var row = [];
		for(var j = 0; j < 10; j++){
			row.push(i * j);
		}
		data.push(row);		
		columns.push({dataIndex: 'field' + i, header: 'Field ' + i, align: 'right'});
	}
	var win = new Ext.Window({
		title: 'ActionManager test',
		width: 500,
		height: 300,
		layout: 'fit',
		items: {
			xtype: 'grid',
			store: new Ext.data.SimpleStore({
				fields: fields,
				data: data
			}),
			columns: columns,
			plugins: [{
				ptype: 'gridactions',
				items: [{
					text: 'Close',
					handler: function(){
						var win = this.manager.panel.ownerCt;
						win[win.closeAction]();
					},
					button: true
				},{
					atype: 'singlerow',
					text: 'Details',
					tooltip: 'Show row details (Ctrl-Space)',
					handler: function(){
						alert('Show details of record #' + this.getSelected().id);
					},
					tbar: true,
					cmenu: true,
					key: {key: ' '}
				},'-',{
					text: 'Insert',
					tooltip: 'Insert row (Insert)',
					handler: function(){
						alert('Insert record');
					},
					tbar: true,
					cmenu: true,
					key: Ext.EventObject.INSERT
				},{
					atype: 'singlerow',
					text: 'Edit',
					tooltip: 'Edit current row (Enter)',
					handler: function(){
						alert('Edit record #' + this.getSelected().id);
					},
					def: true,
					tbar: true,
					cmenu: true,
					key: Ext.EventObject.ENTER
				},{
					atype: 'multirow',
					text: 'Delete',
					tooltip: 'Delete selected rows (Delete)',
					handler: function(){
						alert('Delete ' + this.getSelections().length + ' records');
					},
					tbar: true,
					cmenu: true,
					key: Ext.EventObject.DELETE
				},'->',{
					atype: 'selectall',
					text: 'Select all',
					tooltip: 'Select all rows (Ctrl+A)',
					tbar: true,
					cmenu: true,
					key: {key: 'A', ctrl: true}
				}]
			}]
		}
	}).show();
});