Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var itemsPerPage = 100;   // set the number of items you want per page
	Ext.define('usuarioModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'usuario_id', type: 'int'}
			,{name:'usuario_nivel_id', type: 'int'}
			,{name:'usuario_nome', type: 'string'}
			,{name:'usuario_login', type: 'string'}
			,{name:'usuario_senha', type: 'string'}
			,{name:'usuario_email', type: 'string'}
			,{name:'usuario_avatar', type: 'string'}
			,{name:'usuario_status', type: 'string'}
			,{name:'usuario_nivel_titulo', type: 'string'}
        ]
        ,idProperty: 'usuario_id'
		
    });
	var usuarioStore = Ext.create('Ext.data.Store', {
		id:'usuarioStore'
		,autoLoad: false
		,remoteSort: true
		,model:'usuarioModel'
		,pageSize: itemsPerPage // items per page
		,proxy: {
			type: 'ajax',
			url: 'controller/usuario.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: true
	});

	// specify segment of data you want to load using params
	usuarioStore.load({
		params:{
			start:0,    
			limit: itemsPerPage
		}
	});

	//var GridView = Ext.create('Ext.grid.GridView',{});
	var usuarioGrid = Ext.create('Ext.grid.Panel', {
		title: 'Usuário'
		,id:"usuarioGrid"
		,store: usuarioStore
		,columns: [
			{header: 'Código',  dataIndex: 'usuario_id',sortable: true}
			,{header: 'Usuário',  dataIndex: 'usuario_nome',sortable: true}
			,{header: 'Login',  dataIndex: 'usuario_login',sortable: true}
			,{header: 'E-mail',  dataIndex: 'usuario_email',sortable: true}
			,{header: 'Avatar',  dataIndex: 'usuario_avatar',sortable: true}
			,{header: 'Status',  dataIndex: 'usuario_status',sortable: true}
			,{header: 'Nível',  dataIndex: 'usuario_nivel_titulo',sortable: true}
		]
		//,view: GridView
		/*width: 800,
		height: 600,*/
		,layout:'fit'
		,dockedItems: [
			{
				xtype: 'pagingtoolbar',
				store: usuarioStore,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true,
				displayMsg: "Mostrando {0} - {1} de {2}"
			},
			{
				xtype: 'label',
				text: 'opa',   // same store GridPanel is using
				dock: 'top'
			}
		]
		,renderTo: 'grid'
		
		,viewConfig: {
            trackOver: false
			,stripeRows: false
        }
		,disableSelection: true
	}); 
});


