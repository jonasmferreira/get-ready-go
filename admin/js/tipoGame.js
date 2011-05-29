Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var itemsPerPage = 100;   // set the number of items you want per page
	Ext.define('tipoGameModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'game_tipo_id', type: 'int'}
			,{name:'game_tipo_nome', type: 'string'}
        ]
        ,idProperty: 'game_tipo_id'
		
    });
	
	var tipoGameStore = Ext.create('Ext.data.Store', {
		id:'tipoGameStore'
		,autoLoad: false
		,remoteSort: true
		,model:'tipoGameModel'
		,pageSize: itemsPerPage // items per page
		,proxy: {
			type: 'ajax',
			url: 'controller/tipoGame.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: true
	});

	// specify segment of data you want to load using params
	tipoGameStore.load({
		params:{
			start:0,    
			limit: itemsPerPage
		}
	});
	
	var tipoGameNomeText = Ext.create('Ext.form.field.Text',{
		itemId:'tipoGameNomeText'
		,emptyText: 'Nome do Tipo de games'
		,fieldLabel:''
		,name:'game_tipo_nome'
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
				
				var game_tipo_nome = tipoGameNomeText.getValue();
				
				tipoGameGrid.getStore().load({
					params:{
						'game_tipo_nome': game_tipo_nome
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
				
				tipoGameNomeText.setValue('');
				var game_tipo_nome = tipoGameNomeText.getValue();
				
				tipoGameGrid.getStore().load({
					params:{
						'game_tipo_nome': game_tipo_nome
					}
				});
				
				
			}
		}
	});
	var novoButton = Ext.create('Ext.Button', {
		itemId:"novoButton"
		,text:'Novo Tipo de Games'
		,tooltip:'Novo Tipo de Games'
		,iconCls:'icon-add'
		,listeners:{
			scope:this
			,click:function(button){
				window.location.href = 'tipoGameEdicao.php';
			}
		}
	});
	
	var selModeltipoGameGrid = Ext.create('Ext.selection.RowModel',{
		listeners: {
			scope:this
			,select: function(smObj, record, index) {

			}
		}
	});

	
	
	//var GridView = Ext.create('Ext.grid.GridView',{});
	var tipoGameGrid = Ext.create('Ext.grid.Panel', {
		title: 'Tipo de Games'
		,id:"tipoGameGrid"
		,store: tipoGameStore
		//,resizeble:true
		,autoScroll:true
		,height: 400
		,columns: [
			{header: 'Código',  dataIndex: 'game_tipo_id',sortable: true,width:70}
			,{header: 'Nome',  dataIndex: 'game_tipo_nome',sortable: true, width:250}
			
		]
		,listeners: {
			scope:this
			,itemdblclick:function(obj, record, item, index, e) {
				window.location.href = "tipoGameEdicao.php?game_tipo_id="+record.data.game_tipo_id
			}
		}
		,layout:'fit'
		,dockedItems: [
			{
				xtype: 'pagingtoolbar',
				store: tipoGameStore,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true,
				displayMsg: "Mostrando {0} - {1} de {2}"
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [
					{xtype:'tbspacer',width:10}
					,tipoGameNomeText
					
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
    Ext.EventManager.onWindowResize(tipoGameGrid.doLayout, tipoGameGrid);

});


