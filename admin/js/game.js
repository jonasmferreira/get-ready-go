Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var itemsPerPage = 100;   // set the number of items you want per page
	Ext.define('gameModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'game_id', type: 'int'}
			,{name:'game_titulo', type: 'string'}
			,{name:'game_descricao', type: 'string'}
			,{name:'game_tipo_id', type: 'int'}
			,{name:'game_categoria_game_id', type: 'int'}
			,{name:'game_link', type: 'string'}
			,{name:'game_qtd_download', type: 'string'}
			,{name:'game_qtd_jogado', type: 'string'}
			,{name:'game_criador_is_user', type: 'string'}
			,{name:'game_criador_nome', type: 'string'}
			,{name:'game_thumb', type: 'string'}
			,{name:'game_imagem_destaque', type: 'string'}
        ]
        ,idProperty: 'game_id'
		
    });
	
	var gameStore = Ext.create('Ext.data.Store', {
		id:'gameStore'
		,autoLoad: false
		,remoteSort: true
		,model:'gameModel'
		,pageSize: itemsPerPage // items per page
		,proxy: {
			type: 'ajax',
			url: 'controller/game.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: true
	});

	// specify segment of data you want to load using params
	gameStore.load({
		params:{
			start:0,    
			limit: itemsPerPage
		}
	});
	
	var gameTituloText = Ext.create('Ext.form.field.Text',{
		itemId:'gameTituloText'
		,emptyText: 'Título do Game'
		,fieldLabel:''
		,name:'game_titulo'
		,anchor: '100%'
	});
	
	Ext.define('gameTipoModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'game_tipo_id', type: 'int'}
			,{name:'game_tipo_nome', type: 'string'}
        ]
        ,idProperty: 'game_tipo_id'
		
    });
	// The data store containing the list of states
	var gameTipoStore = Ext.create('Ext.data.Store', {
		id:'gameTipoStore'
		,autoLoad: true
		,remoteSort: false
		,model:'gameTipoModel'
		,proxy: {
			type: 'ajax',
			url: 'controller/game.controller.php?action=getTipoCombo',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
	});

	// Create the combo box, attached to the states data store
	var gameTipoCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'gameTipoCombo'
		,id:'gameTipoCombo'
		,emptyText: 'Tipo'
		,store: gameTipoStore
		,name:'game_tipo_id'
		,displayField: 'game_tipo_nome'
		,valueField: 'game_tipo_id'
		
	});
	
	Ext.define('gameCategoriaModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'game_categoria_id', type: 'int'}
			,{name:'game_categoria_nome', type: 'string'}
        ]
        ,idProperty: 'game_categoria_id'
		
    });
	// The data store containing the list of states
	var gameCategoriaStore = Ext.create('Ext.data.Store', {
		id:'gameCategoriaStore'
		,autoLoad: true
		,remoteSort: false
		,model:'gameCategoriaModel'
		,proxy: {
			type: 'ajax',
			url: 'controller/game.controller.php?action=getCategoriaCombo',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
	});

	// Create the combo box, attached to the states data store
	var gameCategoriaCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'gameCategoriaCombo'
		,id:'gameCategoriaCombo'
		,emptyText: 'Categoria'
		,store: gameCategoriaStore
		,name:'game_categoria_id'
		,displayField: 'game_categoria_nome'
		,valueField: 'game_categoria_id'
		
	});
	

	
	var filterButton = Ext.create('Ext.Button', {
		itemId:"filterButton"
		,text:''
		,tooltip:'Filtrar'
		,iconCls:'icon-search'
		,listeners:{
			scope:this
			,click:function(button){
				var categoria_game_id = gameCategoriaCombo.getValue();
				var game_titulo = gameTituloText.getValue();
				var game_tipo_id = gameTipoCombo.getValue();
				//console.log(usuarioGrid.getStore());
				gameGrid.getStore().load({
					params:{
						'categoria_game_id': categoria_game_id
						,'game_titulo': game_titulo
						,'game_tipo_id': game_tipo_id
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
				gameCategoriaCombo.setValue('');
				gameTituloText.setValue('');
				gameTipoCombo.setValue('');
				
				var categoria_game_id = gameCategoriaCombo.getValue();
				var game_titulo = gameTituloText.getValue();
				var game_tipo_id = gameTipoCombo.getValue();
				//console.log(usuarioGrid.getStore());
				gameGrid.getStore().load({
					params:{
						'categoria_game_id': categoria_game_id
						,'game_titulo': game_titulo
						,'game_tipo_id': game_tipo_id
					}
				});
				
			}
		}
	});
	var novoButton = Ext.create('Ext.Button', {
		itemId:"novoButton"
		,text:'Novo Game'
		,tooltip:'Novo Game'
		,iconCls:'icon-add'
		,listeners:{
			scope:this
			,click:function(button){
				window.location.href = 'gameEdicao.php';
			}
		}
	});
	
	var selModelGameGrid = Ext.create('Ext.selection.RowModel',{
			
			listeners: {
				scope:this
				,select: function(smObj, record, index) {
					//console.log(record.data.game_id)
				}
			}
	});

	
	
	//var GridView = Ext.create('Ext.grid.GridView',{});
	var gameGrid = Ext.create('Ext.grid.Panel', {
		title: 'Games'
		,id:"gameGrid"
		,store: gameStore
		//,resizeble:true
		,autoScroll:true
		,height: 400
		,border:false
		,columns: [
			{header: 'Código',  dataIndex: 'game_id',sortable: true, width:70}
			,{header: 'Categoria ID',  dataIndex: 'categoria_game_id',sortable: true,hidden:true, hideable:false}
			,{header: 'Categoria',  dataIndex: 'categoria_game_nome',sortable: true, width:150}
			,{header: 'Tipo ID',  dataIndex: 'categoria_tipo_id',sortable: true,hidden:true, hideable:false}
			,{header: 'Tipo',  dataIndex: 'categoria_tipo_nome',sortable: true, width:150}
			,{header: 'Url',  dataIndex: 'game_link',sortable: true, width:150}
			,{header: 'Criador',  dataIndex: 'game_criador_nome',sortable: true, width:150}
			
		]
		,listeners: {
			scope:this
			,itemdblclick:function(obj, record, item, index, e) {
				window.location.href = "gameEdicao.php?game_id="+record.data.game_id
			}
		}
		,layout:'fit'
		,dockedItems: [
			{
				xtype: 'pagingtoolbar',
				store: gameStore,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true,
				displayMsg: "Mostrando {0} - {1} de {2}"
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [
					
					{xtype:'tbspacer',width:10}
					,gameTituloText
					
					,{xtype:'tbspacer',width:10}
					,gameCategoriaCombo
					
					,{xtype:'tbspacer',width:10}
					,gameTipoCombo
					
					,{xtype:'tbspacer',width:10}
					,filterButton
					
					,{xtype:'tbspacer',width:10}
					,resetButton
					
				]
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [
					novoButton
					,{xtype:'tbspacer', width:20}
					,{xtype:'tbseparator'}
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
    Ext.EventManager.onWindowResize(gameGrid.doLayout, gameGrid);

});


