Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var itemsPerPage = 2;   // set the number of items you want per page

	var usuarioStore = Ext.create('Ext.data.Store', {
		id:'usuarioStore',
		autoLoad: false,
		fields:[	'usuario_id'
					,'usuario_nivel_id'
					,'usuario_nome'
					,'usuario_login'
					,'usuario_senha'
					,'usuario_email'
					,'usuario_avatar'
					,'usuario_status'
					,'usuario_nivel_titulo'],
		pageSize: itemsPerPage, // items per page
		proxy: {
			type: 'ajax',
			url: 'controller/usuario.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
				
			}
		}
	});

	// specify segment of data you want to load using params
	usuarioStore.load({
		params:{
			start:0,    
			limit: itemsPerPage
		}
	});

	Ext.create('Ext.grid.Panel', {
		title: 'Usuário',
		store: usuarioStore,
		columns: [
			{header: 'Código',  dataIndex: 'usuario_id'}
			,{header: 'Usuário',  dataIndex: 'usuario_id'}
		],
		width: 800,
		height: 600,
		dockedItems: [{
			xtype: 'pagingtoolbar',
			store: usuarioStore,   // same store GridPanel is using
			dock: 'bottom',
			displayInfo: true
		}],
		renderTo: 'grid'
	}); 
});


