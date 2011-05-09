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
	
	var usuarioNomeText = Ext.create('Ext.form.field.Text',{
		itemId:'usuarioNomeText'
		,emptyText: 'Nome do Usuário'
		,fieldLabel:''
		,name:'usuario_nome'
		,anchor: '100%'
	});
	
	var usuarioLoginText = Ext.create('Ext.form.field.Text',{
		itemId:'usuarioLoginText'
		,emptyText: 'Login do Usuário'
		,fieldLabel:''
		,name:'usuario_login'
		,anchor: '100%'
	});
	var usuarioEmailText = Ext.create('Ext.form.field.Text',{
		itemId:'usuarioEmailText'
		,emptyText: 'E-mail do Usuário'
		,fieldLabel:''
		,name:'usuario_email'
		,anchor: '100%'
	});
	
	// The data store containing the list of states
	var usuarioStatusStore = Ext.create('Ext.data.Store', {
		fields: ['status_id', 'status_name'],
		data : [
			{"status_id":"1", "status_name":"Ativo"}
			,{"status_id":"0", "status_name":"Inativo"}
		]
	});

	// Create the combo box, attached to the states data store
	var usuarioStatusCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'usuarioStatusCombo'
		,id:'usuarioStatusCombo'
		,emptyText: 'Status'
		,store: usuarioStatusStore
		,name:'usuario_status'
		,queryMode: 'local'
		,displayField: 'status_name'
		,valueField: 'status_id'
		
	});
	
	Ext.define('usuarioNivelModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'usuario_nivel_id', type: 'int'}
			,{name:'usuario_nivel_titulo', type: 'string'}
        ]
        ,idProperty: 'usuario_nivel_id'
		
    });
	var usuarioNivelStore = Ext.create('Ext.data.Store', {
		id:'usuarioNivelStore'
		,autoLoad: true
		,model:'usuarioNivelModel'
		,proxy: {
			type: 'ajax',
			url: 'controller/usuario.controller.php?action=getUsuarioNivel',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
	});
	
	// Create the combo box, attached to the states data store
	var usuarioNivelCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'usuarioNivelCombo'
		,id:'usuarioNivelCombo'
		,emptyText: 'Nivel'
		,store: usuarioNivelStore
		,name:'usuario_nivel_id'
		,displayField: 'usuario_nivel_titulo'
		,valueField: 'usuario_nivel_id'
		
	});
	
	var filterButton = Ext.create('Ext.Button', {
		itemId:"filterButton"
		,text:''
		,tooltip:'Filtrar'
		,iconCls:'icon-search'
		,listeners:{
			scope:this
			,click:function(button){
				var usuario_nivel_id = usuarioNivelCombo.getValue();
				var usuario_nome = usuarioNomeText.getValue();
				var usuario_login = usuarioLoginText.getValue();
				var usuario_email = usuarioEmailText.getValue();
				var usuario_status = usuarioStatusCombo.getValue();
				//console.log(usuarioGrid.getStore());
				usuarioGrid.getStore().load({
					params:{
						'usuario_nivel_id': usuario_nivel_id
						,'usuario_nome': usuario_nome
						,'usuario_login': usuario_login
						,'usuario_email': usuario_email
						,'usuario_status': usuario_status
					}
				});
			}
		}
	});
	var resetButton = Ext.create('Ext.Button', {
		itemId:"resetButton"
		,text:''
		,tooltip:'Limpar Filtros'
		,iconCls:'icon-cross'
		,listeners:{
			scope:this
			,click:function(button){
				usuarioNivelCombo.setValue('');
				usuarioNomeText.setValue('');
				usuarioLoginText.setValue('');
				usuarioEmailText.setValue('');
				usuarioStatusCombo.setValue('');
			}
		}
	});
	var novoButton = Ext.create('Ext.Button', {
		itemId:"novoButton"
		,text:''
		,tooltip:'Novo Usuário'
		,iconCls:'icon-add'
		,listeners:{
			scope:this
			,click:function(button){
				window.location.href = 'usuarioEdicao.php';
			}
		}
	});
	
	var selModelUsuarioGrid = Ext.create('Ext.selection.RowModel',{
			
			listeners: {
				scope:this
				,select: function(smObj, record, index) {
					console.log(record.data.usuario_id)
				}
			}
	});

	
	
	//var GridView = Ext.create('Ext.grid.GridView',{});
	var usuarioGrid = Ext.create('Ext.grid.Panel', {
		title: 'Usuário'
		,id:"usuarioGrid"
		,store: usuarioStore
		,resizeble:true
		,columns: [
			{header: 'Código',  dataIndex: 'usuario_id',sortable: true}
			,{header: 'Usuário',  dataIndex: 'usuario_nome',sortable: true}
			,{header: 'Login',  dataIndex: 'usuario_login',sortable: true}
			,{header: 'E-mail',  dataIndex: 'usuario_email',sortable: true}
			,{header: 'Avatar',  dataIndex: 'usuario_avatar',sortable: true}
			,{
				header: 'Status',  
				dataIndex: 'usuario_status',
				sortable: true,
				renderer:function(val){
					if(val > 0){
						return 'Ativo'
					}else{
						return 'Inativo'
					}
				}
			}
			,{header: 'Nível',  dataIndex: 'usuario_nivel_titulo',sortable: true}
		]
		,listeners: {
			scope:this
			,itemdblclick:function(obj, record, item, index, e) {
				window.location.href = "usuarioEdicao.php?usuario_id="+record.data.usuario_id
			}
		}
		,layout:'fit'
		,dockedItems: [
			{
				xtype: 'pagingtoolbar',
				store: usuarioStore,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true,
				displayMsg: "Mostrando {0} - {1} de {2}"
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [
					{xtype:'tbspacer',width:10}
					,usuarioNomeText
					
					,{xtype:'tbspacer',width:10}
					,usuarioLoginText
					
					,{xtype:'tbspacer',width:10}
					,usuarioEmailText
					
					,{xtype:'tbspacer',width:10}
					,usuarioNivelCombo
					
					,{xtype:'tbspacer',width:10}
					,usuarioStatusCombo
					
					,{xtype:'tbspacer',width:10}
					,filterButton
					
					,{xtype:'tbspacer',width:10}
					,resetButton
					
					,'->'
					,novoButton
					
					
				]
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [
					'->'
					,{xtype:'label',html:'<b>Para editar, double-click no registro!</b>'}
				]
			}
		]	
		,renderTo: 'grid'
		
		,viewConfig: {
            trackOver: false
        }
	}); 
	//pass along browser window resize events to the panel
    Ext.EventManager.onWindowResize(usuarioGrid.doLayout, usuarioGrid);

});


