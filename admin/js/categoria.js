Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var itemsPerPage = 100;   // set the number of items you want per page
	Ext.define('categoriaModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'categoria_id', type: 'int'}
			,{name:'categoria_nome', type: 'string'}
			,{name:'categoria_destaque_home', type: 'string'}
			,{name:'categoria_galeria', type: 'string'}
        ]
        ,idProperty: 'categoria_id'
		
    });
	
	var categoriaStore = Ext.create('Ext.data.Store', {
		id:'categoriaStore'
		,autoLoad: false
		,remoteSort: true
		,model:'categoriaModel'
		,pageSize: itemsPerPage // items per page
		,proxy: {
			type: 'ajax',
			url: 'controller/categoria.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: true
	});

	// specify segment of data you want to load using params
	categoriaStore.load({
		params:{
			start:0,    
			limit: itemsPerPage
		}
	});
	
	var categoriaNomeText = Ext.create('Ext.form.field.Text',{
		itemId:'categoriaNomeText'
		,emptyText: 'Nome da Categoria'
		,fieldLabel:''
		,name:'categoria_nome'
		,anchor: '100%'
	});
	
	// The data store containing the list of states
	var categoriaDestaqueHomeStore = Ext.create('Ext.data.Store', {
		fields: ['destaque_home_id', 'destaque_home_name'],
		data : [
			{"destaque_home_id":"1", "destaque_home_name":"Sim"}
			,{"destaque_home_id":"0", "destaque_home_name":"Não"}
		]
	});

	// Create the combo box, attached to the states data store
	var categoriaDestaqueHomeCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'categoriaDestaqueHomeCombo'
		,id:'categoriaDestaqueHomeCombo'
		,emptyText: 'Destaque na Home?'
		,store: categoriaDestaqueHomeStore
		,name:'categoria_destaque_home'
		,queryMode: 'local'
		,displayField: 'destaque_home_name'
		,valueField: 'destaque_home_id'
		
	});
	// The data store containing the list of states
	var categoriaGaleriaStore = Ext.create('Ext.data.Store', {
		fields: ['categoria_galeria_id', 'categoria_galeria_name'],
		data : [
			{"categoria_galeria_id":"1", "categoria_galeria_name":"Sim"}
			,{"categoria_galeria_id":"0", "categoria_galeria_name":"Não"}
		]
	});

	// Create the combo box, attached to the states data store
	var categoriaGaleriaCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'categoriaGaleriaCombo'
		,id:'categoriaGaleriaCombo'
		,emptyText: 'Galeria?'
		,store: categoriaGaleriaStore
		,name:'categoria_galeria'
		,queryMode: 'local'
		,displayField: 'categoria_galeria_name'
		,valueField: 'categoria_galeria_id'
		
	});
	
	
	
	var filterButton = Ext.create('Ext.Button', {
		itemId:"filterButton"
		,text:''
		,tooltip:'Filtrar'
		,iconCls:'icon-search'
		,listeners:{
			scope:this
			,click:function(button){
				
				var categoria_nome = categoriaNomeText.getValue();
				var categoria_galeria = categoriaGaleriaCombo.getValue();
				var categoria_destaque_home = categoriaDestaqueHomeCombo.getValue();
				
				categoriaGrid.getStore().load({
					params:{
						'categoria_nome': categoria_nome
						,'categoria_galeria': categoria_galeria
						,'categoria_destaque_home': categoria_destaque_home
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
				
				categoriaNomeText.setValue('');
				categoriaGaleriaCombo.setValue('');
				categoriaDestaqueHomeCombo.setValue('');
				var categoria_nome = categoriaNomeText.getValue();
				var categoria_galeria = categoriaGaleriaCombo.getValue();
				var categoria_destaque_home = categoriaDestaqueHomeCombo.getValue();
				
				categoriaGrid.getStore().load({
					params:{
						'categoria_nome': categoria_nome
						,'categoria_galeria': categoria_galeria
						,'categoria_destaque_home': categoria_destaque_home
					}
				});
				
				
			}
		}
	});
	var novoButton = Ext.create('Ext.Button', {
		itemId:"novoButton"
		,text:'Nova Categoria'
		,tooltip:'Nova Categoria'
		,iconCls:'icon-add'
		,listeners:{
			scope:this
			,click:function(button){
				window.location.href = 'categoriaEdicao.php';
			}
		}
	});
	
	var selModelcategoriaGrid = Ext.create('Ext.selection.RowModel',{
		listeners: {
			scope:this
			,select: function(smObj, record, index) {

			}
		}
	});

	
	
	//var GridView = Ext.create('Ext.grid.GridView',{});
	var categoriaGrid = Ext.create('Ext.grid.Panel', {
		title: 'Categoria'
		,id:"categoriaGrid"
		,store: categoriaStore
		,resizeble:true
		,columns: [
			{header: 'Código',  dataIndex: 'categoria_id',sortable: true}
			,{header: 'Categoria',  dataIndex: 'categoria_nome',sortable: true}
			,{
				header: 'Destaque na Home',  
				dataIndex: 'categoria_destaque_home',
				sortable: true,
				renderer:function(val){
					if(val > 0){
						return 'Sim'
					}else{
						return 'Não'
					}
				}
			}
			,{
				header: 'Galeria',  
				dataIndex: 'categoria_galeria',
				sortable: true,
				renderer:function(val){
					if(val > 0){
						return 'Sim'
					}else{
						return 'Não'
					}
				}
			}
		]
		,listeners: {
			scope:this
			,itemdblclick:function(obj, record, item, index, e) {
				window.location.href = "categoriaEdicao.php?categoria_id="+record.data.categoria_id
			}
		}
		,layout:'fit'
		,dockedItems: [
			{
				xtype: 'pagingtoolbar',
				store: categoriaStore,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true,
				displayMsg: "Mostrando {0} - {1} de {2}"
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [
					{xtype:'tbspacer',width:10}
					,categoriaNomeText
					
					,{xtype:'tbspacer',width:10}
					,categoriaDestaqueHomeCombo
					
					,{xtype:'tbspacer',width:10}
					,categoriaGaleriaCombo
					
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
    Ext.EventManager.onWindowResize(categoriaGrid.doLayout, categoriaGrid);

});


