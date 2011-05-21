Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var itemsPerPage = 100;   // set the number of items you want per page
	Ext.define('enqueteModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'enquete_id', type: 'int'}
			,{name:'enquete_titulo', type: 'string'}
			,{name:'enquete_dt_criacao', type: 'datetime'}
			,{name:'enquete_dtcomp_criacao', type: 'datetime'}
			,{name:'enquete_dt_alteracao', type: 'datetime'}
			,{name:'enquete_dtcomp_alteracao', type: 'datetime'}
			,{name:'enquete_status', type: 'string'}
			,{name:'qtde_opcoes', type: 'string'}
			
        ]
        ,idProperty: 'enquete_id'
		
    });
	
	var enqueteStore = Ext.create('Ext.data.Store', {
		id:'enqueteStore'
		,autoLoad: false
		,remoteSort: true
		,model:'enqueteModel'
		,pageSize: itemsPerPage // items per page
		,proxy: {
			type: 'ajax',
			url: 'controller/enquete.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: true
	});

	// specify segment of data you want to load using params
	enqueteStore.load({
		params:{
			start:0,    
			limit: itemsPerPage
		}
	});
	
	var enqueteTituloText = Ext.create('Ext.form.field.Text',{
		itemId:'enqueteTituloText'
		,emptyText: 'Título da Enquete'
		,fieldLabel:''
		,name:'enquete_titulo'
		,anchor: '100%'
	});
	
	// The data store containing the list of states
	var enqueteStatusStore = Ext.create('Ext.data.Store', {
		fields: ['status_id', 'status_name'],
		data : [
			{"status_id":"1", "status_name":"Ativo"}
			,{"status_id":"0", "status_name":"Inativo"}
		]
	});

	// Create the combo box, attached to the states data store
	var enqueteStatusCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'enqueteStatusCombo'
		,id:'enqueteStatusCombo'
		,emptyText: 'Status'
		,store: enqueteStatusStore
		,name:'enquete_status'
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
				var enquete_titulo = enqueteTituloText.getValue();
				var enquete_status = enqueteStatusCombo.getValue();
				//console.log(usuarioGrid.getStore());
				enqueteGrid.getStore().load({
					params:{
						'enquete_titulo': enquete_titulo
						,'enquete_status': enquete_status
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
				enqueteTituloText.setValue('');
				enqueteStatusCombo.setValue('');
				var enquete_titulo = enqueteTituloText.getValue();
				var enquete_status = enqueteStatusCombo.getValue();
				enqueteGrid.getStore().load({
					params:{
						'enquete_titulo': enquete_titulo
						,'enquete_status': enquete_status
					}
				});
				
			}
		}
	});
	var novoButton = Ext.create('Ext.Button', {
		itemId:"novoButton"
		,text:'Nova Enquete'
		,tooltip:'Nova Enquete'
		,iconCls:'icon-add'
		,listeners:{
			scope:this
			,click:function(button){
				window.location.href = 'enqueteEdicao.php';
			}
		}
	});
	
	
	//var GridView = Ext.create('Ext.grid.GridView',{});
	var enqueteGrid = Ext.create('Ext.grid.Panel', {
		title: 'Enquetes'
		,id:"enqueteGrid"
		,store: enqueteStore
		,resizeble:true
		,border:false
		,columns: [
			{header: 'Código',  dataIndex: 'enquete_id',sortable: true}
			,{header: 'Título',  dataIndex: 'enquete_titulo',sortable: true}
			,{header: 'QTD. Opções',  dataIndex: 'qtde_opcoes',sortable: true}
			,{header: 'Dt. Criação',  dataIndex: 'enquete_dt_criacao',sortable: true}
			,{header: 'Dt/Hr Criação ',  dataIndex: 'enquete_dtcomp_criacao',sortable: true}
			,{header: 'Dt. Alteração',  dataIndex: 'enquete_dt_alteracao',sortable: true}
			,{header: 'Dt/Hr Alteração ',  dataIndex: 'enquete_dtcomp_alteracao',sortable: true}
			,{
				header: 'Status',  
				dataIndex: 'enquete_status',
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
				window.location.href = "enqueteEdicao.php?enquete_id="+record.data.enquete_id
			}
		}
		,layout:'fit'
		,dockedItems: [
			{
				xtype: 'pagingtoolbar',
				store: enqueteStore,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true,
				displayMsg: "Mostrando {0} - {1} de {2}"
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [
					
					{xtype:'tbspacer',width:10}
					,enqueteTituloText
					
					,{xtype:'tbspacer',width:10}
					,enqueteStatusCombo
					
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
    Ext.EventManager.onWindowResize(enqueteGrid.doLayout, enqueteGrid);

});


