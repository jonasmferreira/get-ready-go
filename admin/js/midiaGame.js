Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var itemsPerPage = 100;   // set the number of items you want per page
	Ext.define('midiaGameModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'game_midia_id', type: 'int'}
			,{name:'game_midia_nome', type: 'string'}
        ]
        ,idProperty: 'game_midia_id'
		
    });
	
	var midiaGameStore = Ext.create('Ext.data.Store', {
		id:'midiaGameStore'
		,autoLoad: false
		,remoteSort: true
		,model:'midiaGameModel'
		,pageSize: itemsPerPage // items per page
		,proxy: {
			type: 'ajax',
			url: 'controller/midiaGame.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: true
	});

	// specify segment of data you want to load using params
	midiaGameStore.load({
		params:{
			start:0,    
			limit: itemsPerPage
		}
	});
	
	var midiaGameNomeText = Ext.create('Ext.form.field.Text',{
		itemId:'midiaGameNomeText'
		,emptyText: 'Nome da Mídia de games'
		,fieldLabel:''
		,name:'game_midia_nome'
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
				
				var game_midia_nome = midiaGameNomeText.getValue();
				
				midiaGameGrid.getStore().load({
					params:{
						'game_midia_nome': game_midia_nome
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
				
				midiaGameNomeText.setValue('');
				var game_midia_nome = midiaGameNomeText.getValue();
				
				midiaGameGrid.getStore().load({
					params:{
						'game_midia_nome': game_midia_nome
					}
				});
				
				
			}
		}
	});
	var novoButton = Ext.create('Ext.Button', {
		itemId:"novoButton"
		,text:'Nova Mídia de Games'
		,tooltip:'Nova Mídia de Games'
		,iconCls:'icon-add'
		,listeners:{
			scope:this
			,click:function(button){
				window.location.href = 'midiaGameEdicao.php';
			}
		}
	});
	
	var selModelmidiaGameGrid = Ext.create('Ext.selection.RowModel',{
		listeners: {
			scope:this
			,select: function(smObj, record, index) {

			}
		}
	});

	
	
	//var GridView = Ext.create('Ext.grid.GridView',{});
	var midiaGameGrid = Ext.create('Ext.grid.Panel', {
		title: 'Mídia de Games'
		,id:"midiaGameGrid"
		,store: midiaGameStore
		//,resizeble:true
		,autoScroll:true
		,height: 400
		,columns: [
			{header: 'Código',  dataIndex: 'game_midia_id',sortable: true,width:70}
			,{header: 'Nome',  dataIndex: 'game_midia_nome',sortable: true, width:250}
			
		]
		,listeners: {
			scope:this
			,itemdblclick:function(obj, record, item, index, e) {
				window.location.href = "midiaGameEdicao.php?game_midia_id="+record.data.game_midia_id
			}
		}
		,layout:'fit'
		,dockedItems: [
			{
				xtype: 'pagingtoolbar',
				store: midiaGameStore,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true,
				displayMsg: "Mostrando {0} - {1} de {2}"
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [
					{xtype:'tbspacer',width:10}
					,midiaGameNomeText
					
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
    Ext.EventManager.onWindowResize(midiaGameGrid.doLayout, midiaGameGrid);

});


