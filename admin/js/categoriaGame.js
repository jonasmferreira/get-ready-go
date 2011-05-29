Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var itemsPerPage = 100;   // set the number of items you want per page
	Ext.define('categoriaGameModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'game_categoria_id', type: 'int'}
			,{name:'game_categoria_nome', type: 'string'}
        ]
        ,idProperty: 'game_categoria_id'
		
    });
	
	var categoriaGameStore = Ext.create('Ext.data.Store', {
		id:'categoriaGameStore'
		,autoLoad: false
		,remoteSort: true
		,model:'categoriaGameModel'
		,pageSize: itemsPerPage // items per page
		,proxy: {
			type: 'ajax',
			url: 'controller/categoriaGame.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: true
	});

	// specify segment of data you want to load using params
	categoriaGameStore.load({
		params:{
			start:0,    
			limit: itemsPerPage
		}
	});
	
	var categoriaGameNomeText = Ext.create('Ext.form.field.Text',{
		itemId:'categoriaGameNomeText'
		,emptyText: 'Nome da categoria de games'
		,fieldLabel:''
		,name:'game_categoria_nome'
		,anchor: '100%'
	});
	
	
	
	var filterButton = Ext.create('Ext.Button', {
		itemId:"filterButton"
		,text:''
		,tooltip:'Filtrar'
		,iconCls:'icon-search'
		,listeners:{
			scope:this
			,click:function(button){
				
				var game_categoria_nome = categoriaGameNomeText.getValue();
				var game_categoria_galeria = categoriaGameGaleriaCombo.getValue();
				
				categoriaGameGrid.getStore().load({
					params:{
						'game_categoria_nome': game_categoria_nome
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
				
				categoriaGameNomeText.setValue('');
				var game_categoria_nome = categoriaGameNomeText.getValue();
				
				categoriaGameGrid.getStore().load({
					params:{
						'game_categoria_nome': game_categoria_nome
					}
				});
				
				
			}
		}
	});
	var novoButton = Ext.create('Ext.Button', {
		itemId:"novoButton"
		,text:'Nova Categoria de Games'
		,tooltip:'Nova Categoria de Games'
		,iconCls:'icon-add'
		,listeners:{
			scope:this
			,click:function(button){
				window.location.href = 'categoriaGameEdicao.php';
			}
		}
	});
	
	var selModelcategoriaGameGrid = Ext.create('Ext.selection.RowModel',{
		listeners: {
			scope:this
			,select: function(smObj, record, index) {

			}
		}
	});

	
	
	//var GridView = Ext.create('Ext.grid.GridView',{});
	var categoriaGameGrid = Ext.create('Ext.grid.Panel', {
		title: 'Categoria de Games'
		,id:"categoriaGameGrid"
		,store: categoriaGameStore
		//,resizeble:true
		,autoScroll:true
		,height: 400
		,columns: [
			{header: 'Código',  dataIndex: 'game_categoria_id',sortable: true,width:70}
			,{header: 'Nome',  dataIndex: 'game_categoria_nome',sortable: true, width:250}
			
		]
		,listeners: {
			scope:this
			,itemdblclick:function(obj, record, item, index, e) {
				window.location.href = "categoriaGameEdicao.php?game_categoria_id="+record.data.game_categoria_id
			}
		}
		,layout:'fit'
		,dockedItems: [
			{
				xtype: 'pagingtoolbar',
				store: categoriaGameStore,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true,
				displayMsg: "Mostrando {0} - {1} de {2}"
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [
					{xtype:'tbspacer',width:10}
					,categoriaGameNomeText
					
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
    Ext.EventManager.onWindowResize(categoriaGameGrid.doLayout, categoriaGameGrid);

});


