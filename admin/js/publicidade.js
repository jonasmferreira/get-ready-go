Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var itemsPerPage = 100;   // set the number of items you want per page
	Ext.define('publicidadeModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'publicidade_id', type: 'int'}
			,{name:'publicidade_tipomedia', type: 'int'}
			,{name:'publicidade_arquivo', type: 'string'}
			,{name:'publicidade_numclique', type: 'int'}
			,{name:'publicidade_dt_ativacao', type: 'datetime'}
			,{name:'publicidade_dt_desativacao', type: 'datetime'}
			,{name:'publicidade_dt_criacao', type: 'datetime'}
			,{name:'publicidade_dtcomp_criacao', type: 'datetime'}
			,{name:'publicidade_status', type: 'int'}
			,{name:'publicidade_tipo_titulo', type: 'string'}
			
        ]
        ,idProperty: 'publicidade_id'

    });
	
	Ext.define('publicidadeTipoModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'publicidade_tipo_id', type: 'int'}
			,{name:'publicidade_tipo_titulo', type: 'string'}

        ]
        ,idProperty: 'publicidade_tipo_id'

    });
	
	var publicidadeTipoStore = Ext.create('Ext.data.Store', {
		id:'publicidadeTipoStore'
		,autoLoad: true
		,remoteSort: false
		,model:'publicidadeTipoModel'
		
		,proxy: {
			type: 'ajax',
			url: 'controller/publicidade.controller.php?action=getPublicidadeTipoCombo',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: false
	});

	var publicidadeStore = Ext.create('Ext.data.Store', {
		id:'publicidadeStore'
		,autoLoad: false
		,remoteSort: true
		,model:'publicidadeModel'
		,pageSize: itemsPerPage // items per page
		,proxy: {
			type: 'ajax',
			url: 'controller/publicidade.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: true
	});

	// specify segment of data you want to load using params
	publicidadeStore.load({
		params:{
			start:0,
			limit: itemsPerPage
		}
	});

	var publicidadeTituloText = Ext.create('Ext.form.field.Text',{
		itemId:'publicidadeTituloText'
		,emptyText: 'Título do publicidade'
		,fieldLabel:''
		,name:'publicidade_titulo'
		,anchor: '100%'
	});

	// The data store containing the list of states
	var publicidadeStatusStore = Ext.create('Ext.data.Store', {
		fields: ['status_id', 'status_name'],
		data : [
			{"status_id":"1", "status_name":"Flash"}
			,{"status_id":"0", "status_name":"Imagem"}
		]
	});

	// Create the combo box, attached to the states data store
	var publicidadeTipoMedia = Ext.create('Ext.form.ComboBox', {
		itemId:'publicidadeTipoMedia'
		,id:'publicidadeTipoMedia'
		,emptyText: 'Tipo de Midia'
		,store: publicidadeStatusStore
		,name:'publicidade_status'
		,queryMode: 'local'
		,displayField: 'status_name'
		,valueField: 'status_id'

	});
	
	// Create the combo box, attached to the states data store
	var publicidadeTipo = Ext.create('Ext.form.ComboBox', {
		itemId:'publicidadeTipo'
		,id:'publicidadeTipo'
		,emptyText: 'Tipo de Publicidade'
		,store: publicidadeTipoStore
		,name:'publicidade_tipo_id'
		,queryMode: 'local'
		,displayField: 'publicidade_tipo_titulo'
		,valueField: 'publicidade_tipo_id'

	});



	var filterButton = Ext.create('Ext.Button', {
		itemId:"filterButton"
		,text:''
		,tooltip:'Filtrar'
		,iconCls:'icon-search'
		,listeners:{
			scope:this
			,click:function(button){
				var publicidadetipomedia = publicidadeTipoMedia.getValue();
				var publicidade_tipo_id = publicidadeTipo.getValue();
				//console.log(usuarioGrid.getStore());
				publicidadeGrid.getStore().load({
					params:{
						'publicidade_tipomedia': publicidadetipomedia
						,'publicidade_tipo_id':publicidade_tipo_id
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
				publicidadeTipoMedia.setValue('');
				var publicidadetipomedia = publicidadeTipoMedia.getValue();
				//console.log(usuarioGrid.getStore());
				var publicidade_tipo_id = publicidadeTipo.getValue();
				publicidadeGrid.getStore().load({
					params:{
						'publicidade_tipomedia': publicidadetipomedia
						,'publicidade_tipo_id':publicidade_tipo_id
					}
				});

			}
		}
	});
	var novoButton = Ext.create('Ext.Button', {
		itemId:"novoButton"
		,text:'Novo publicidade'
		,tooltip:'Novo publicidade'
		,iconCls:'icon-add'
		,listeners:{
			scope:this
			,click:function(button){
				window.location.href = 'publicidadeEdicao.php';
			}
		}
	});

	var selModelpublicidadeGrid = Ext.create('Ext.selection.RowModel',{

			listeners: {
				scope:this
				,select: function(smObj, record, index) {
					//console.log(record.data.publicidade_id)
				}
			}
	});



	//var GridView = Ext.create('Ext.grid.GridView',{});
	var publicidadeGrid = Ext.create('Ext.grid.Panel', {
		title: 'publicidades'
		,id:"publicidadeGrid"
		,store: publicidadeStore
		//,resizeble:true
		,autoScroll:true
		,height: 400
		,border:false
		,columns: [
			{header: 'Código',  dataIndex: 'publicidade_id',sortable: true, width:60}
			,{
				header: 'Tipo de publicidade',
				dataIndex: 'publicidade_tipo_titulo',
				sortable: true, 
				width:200
				
			}
			,{
				header: 'Tipo de Midia',
				dataIndex: 'publicidade_tipomedia',
				sortable: true,
				width:120,
				renderer:function(val){
					if(val == 0){
						return 'Imagem'
					}else{
						return 'Flash'
					}
				}
			}
			,{header: 'Dt. Criação',  dataIndex: 'publicidade_dt_criacao',sortable: true,hidden:true,hideable:false}
			,{header: 'Dt/Hr Criação ',  dataIndex: 'publicidade_dtcomp_criacao',sortable: true, width:120}
			,{header: 'Dt. Ativação',  dataIndex: 'publicidade_dt_ativacao',sortable: true, width:120}
			,{header: 'Dt. Desativação',  dataIndex: 'publicidade_dt_desativacao',sortable: true, width:120}
		]
		,listeners: {
			scope:this
			,itemdblclick:function(obj, record, item, index, e) {
				window.location.href = "publicidadeEdicao.php?publicidade_id="+record.data.publicidade_id
			}
		}
		,layout:'fit'
		,dockedItems: [
			{
				xtype: 'pagingtoolbar',
				store: publicidadeStore,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true,
				displayMsg: "Mostrando {0} - {1} de {2}"
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [
					publicidadeTipoMedia
					
					,{xtype:'tbspacer',width:10}
					,publicidadeTipo

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
    Ext.EventManager.onWindowResize(publicidadeGrid.doLayout, publicidadeGrid);

});


