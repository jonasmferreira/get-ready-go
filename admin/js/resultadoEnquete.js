Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var itemsPerPage = 100;   // set the number of items you want per page
	Ext.define('resultadoEnqueteModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'enquete_opcao_id', type: 'int'}
			,{name:'enquete_id', type: 'int'}
			,{name:'enquete_opcao_titulo', type: 'string'}
			,{name:'resultado', type: 'string'}
			,{name:'percentual', type: 'string'}
			
        ]
        ,idProperty: 'enquete_opcao_id'

    });
	
	Ext.define('enqueteModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'enquete_id', type: 'int'}
			,{name:'enquete_titulo', type: 'string'}

        ]
        ,idProperty: 'enquete_id'

    });
	
	var enqueteStore = Ext.create('Ext.data.Store', {
		id:'resultadoEnqueteTipoStore'
		,autoLoad: true
		,remoteSort: false
		,model:'enqueteModel'
		,proxy: {
			type: 'ajax',
			url: 'controller/enquete.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: false
	});

	var resultadoEnqueteStore = Ext.create('Ext.data.Store', {
		id:'resultadoEnqueteStore'
		,autoLoad: false
		,remoteSort: true
		,model:'resultadoEnqueteModel'
		,pageSize: itemsPerPage // items per page
		,proxy: {
			type: 'ajax',
			url: 'controller/resultadoEnquete.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: true
	});

	// specify segment of data you want to load using params
	resultadoEnqueteStore.load({
		params:{
			start:0,
			limit: itemsPerPage
		}
	});
	
	// Create the combo box, attached to the states data store
	var enqueteCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'enqueteCombo'
		,id:'enqueteCombo'
		,emptyText: 'Enquete'
		,store: enqueteStore
		,name:'enquete_id'
		,queryMode: 'local'
		,displayField: 'enquete_titulo'
		,valueField: 'enquete_id'

	});



	var filterButton = Ext.create('Ext.Button', {
		itemId:"filterButton"
		,text:''
		,tooltip:'Filtrar'
		,iconCls:'icon-search'
		,listeners:{
			scope:this
			,click:function(button){
				var enquete_id = enqueteCombo.getValue();
				if(enquete_id==''){
					Ext.Msg.alert('Resultados',"Selecione uma Enquete");
					return false;
				}
				resultadoEnqueteGrid.getStore().load({
					params:{
						'enquete_id': enquete_id
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
				enqueteCombo.setValue('');
				
			}
		}
	});
	var resultadoEnqueteGrid = Ext.create('Ext.grid.Panel', {
		title: 'Resultado das Enquetes'
		,id:"resultadoEnqueteGrid"
		,store: resultadoEnqueteStore
		//,resizeble:true
		,autoScroll:true
		,height: 400
		,border:false
		,columns: [
			{header: 'Código',  dataIndex: 'enquete_opcao_id',sortable: true,width:30}
			,{
				header: 'Opção'
				,dataIndex: 'enquete_opcao_titulo'
				,sortable: true
				,width:250
				
			}
			,{
				header: 'Resultado'
				,dataIndex: 'resultado'
				,sortable: true
				,width:30
			}
			,{header: '%',  dataIndex: 'percentual',sortable: true,width:30}
		]
		,listeners: {
			scope:this
			,itemdblclick:function(obj, record, item, index, e) {
				
			}
		}
		,layout:'fit'
		,dockedItems: [
			{
				xtype: 'pagingtoolbar',
				store: resultadoEnqueteStore,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true,
				displayMsg: "Mostrando {0} - {1} de {2}"
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [
					enqueteCombo

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
					
				]
			}
		]
		,renderTo: 'grid'

		,viewConfig: {
            trackOver: false
        }
	});
	//pass along browser window resize events to the panel
    Ext.EventManager.onWindowResize(resultadoEnqueteGrid.doLayout, resultadoEnqueteGrid);

});


