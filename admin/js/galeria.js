Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var itemsPerPage = 100;   // set the number of items you want per page
	Ext.define('galeriaModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'galeria_id', type: 'int'}
			,{name:'galeria_titulo', type: 'string'}
			,{name:'galeria_dt_criacao', type: 'datetime'}
			,{name:'galeria_dtcomp_criacao', type: 'datetime'}
			,{name:'galeria_dt_alteracao', type: 'datetime'}
			,{name:'galeria_dtcomp_alteracao', type: 'datetime'}
			,{name:'galeria_status', type: 'string'}
			,{name:'qtde_imagens', type: 'string'}
			
        ]
        ,idProperty: 'galeria_id'
		
    });
	
	var galeriaStore = Ext.create('Ext.data.Store', {
		id:'galeriaStore'
		,autoLoad: false
		,remoteSort: true
		,model:'galeriaModel'
		,pageSize: itemsPerPage // items per page
		,proxy: {
			type: 'ajax',
			url: 'controller/galeria.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: true
	});

	// specify segment of data you want to load using params
	galeriaStore.load({
		params:{
			start:0,    
			limit: itemsPerPage
		}
	});
	
	var galeriaTituloText = Ext.create('Ext.form.field.Text',{
		itemId:'galeriaTituloText'
		,emptyText: 'Título do Galeria'
		,fieldLabel:''
		,name:'galeria_titulo'
		,anchor: '100%'
	});
	
	// The data store containing the list of states
	var galeriaStatusStore = Ext.create('Ext.data.Store', {
		fields: ['status_id', 'status_name'],
		data : [
			{"status_id":"1", "status_name":"Ativo"}
			,{"status_id":"0", "status_name":"Inativo"}
		]
	});

	// Create the combo box, attached to the states data store
	var galeriaStatusCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'galeriaStatusCombo'
		,id:'galeriaStatusCombo'
		,emptyText: 'Status'
		,store: galeriaStatusStore
		,name:'galeria_status'
		,queryMode: 'local'
		,displayField: 'status_name'
		,valueField: 'status_id'
		
	});

	var filterButton = Ext.create('Ext.Button', {
		itemId:"filterButton"
		,text:''
		,tooltip:'Filtrar'
		,iconCls:'icon-search'
		,listeners:{
			scope:this
			,click:function(button){
				var titulo_nome = galeriaTituloText.getValue();
				var galeria_status = galeriaStatusCombo.getValue();
				//console.log(usuarioGrid.getStore());
				galeriaGrid.getStore().load({
					params:{
						'titulo_nome': titulo_nome
						,'galeria_status': galeria_status
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
				galeriaTituloText.setValue('');
				galeriaStatusCombo.setValue('');
				var titulo_nome = galeriaTituloText.getValue();
				var galeria_status = galeriaStatusCombo.getValue();
				galeriaGrid.getStore().load({
					params:{
						'titulo_nome': titulo_nome
						,'galeria_status': galeria_status
					}
				});
				
			}
		}
	});
	var novoButton = Ext.create('Ext.Button', {
		itemId:"novoButton"
		,text:'Nova Galeria'
		,tooltip:'Nova Galeria'
		,iconCls:'icon-add'
		,listeners:{
			scope:this
			,click:function(button){
				window.location.href = 'galeriaEdicao.php';
			}
		}
	});
	
	
	//var GridView = Ext.create('Ext.grid.GridView',{});
	var galeriaGrid = Ext.create('Ext.grid.Panel', {
		title: 'Galerias'
		,id:"galeriaGrid"
		,store: galeriaStore
		,resizeble:true
		,border:false
		,columns: [
			{header: 'Código',  dataIndex: 'galeria_id',sortable: true}
			,{header: 'Título',  dataIndex: 'galeria_titulo',sortable: true}
			,{header: 'Dt. Criação',  dataIndex: 'galeria_dt_criacao',sortable: true}
			,{header: 'Dt/Hr Criação ',  dataIndex: 'galeria_dtcomp_criacao',sortable: true}
			,{header: 'Dt. Alteração',  dataIndex: 'galeria_dt_alteracao',sortable: true}
			,{header: 'Dt/Hr Alteração ',  dataIndex: 'galeria_dtcomp_alteracao',sortable: true}
			,{
				header: 'Status',  
				dataIndex: 'galeria_status',
				sortable: true,
				renderer:function(val){
					if(val > 0){
						return 'Ativo'
					}else{
						return 'Inativo'
					}
				}
			}
		]
		,listeners: {
			scope:this
			,itemdblclick:function(obj, record, item, index, e) {
				window.location.href = "galeriaEdicao.php?galeria_id="+record.data.galeria_id
			}
		}
		,layout:'fit'
		,dockedItems: [
			{
				xtype: 'pagingtoolbar',
				store: galeriaStore,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true,
				displayMsg: "Mostrando {0} - {1} de {2}"
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [
					
					{xtype:'tbspacer',width:10}
					,galeriaTituloText
					
					,{xtype:'tbspacer',width:10}
					,galeriaStatusCombo
					
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
    Ext.EventManager.onWindowResize(galeriaGrid.doLayout, galeriaGrid);

});


