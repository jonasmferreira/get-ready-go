Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var itemsPerPage = 100;   // set the number of items you want per page
	Ext.define('publicidadeTipoModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'publicidade_tipo_id', type: 'int'}
			,{name:'publicidade_tipo_titulo', type: 'string'}
			,{name:'publicidade_tipo_dt_criacao', type: 'datetime'}
			,{name:'publicidade_tipo_dtcomp_criacao', type: 'datetime'}
			,{name:'publicidade_tipo_dt_alteracao', type: 'datetime'}
			,{name:'publicidade_tipo_dtcomp_alteracao', type: 'datetime'}
			,{name:'publicidade_tipo_status', type: 'string'}

        ]
        ,idProperty: 'publicidade_tipo_id'

    });

	var publicidadeTipoStore = Ext.create('Ext.data.Store', {
		id:'publicidadeTipoStore'
		,autoLoad: false
		,remoteSort: true
		,model:'publicidadeTipoModel'
		,pageSize: itemsPerPage // items per page
		,proxy: {
			type: 'ajax',
			url: 'controller/publicidadeTipo.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: true
	});

	// specify segment of data you want to load using params
	publicidadeTipoStore.load({
		params:{
			start:0,
			limit: itemsPerPage
		}
	});

	var publicidadeTipoTituloText = Ext.create('Ext.form.field.Text',{
		itemId:'publicidadeTipoTituloText'
		,emptyText: 'Título do Tipo de publicidade'
		,fieldLabel:''
		,name:'publicidadeTipo_titulo'
		,anchor: '100%'
	});

	// The data store containing the list of states
	var publicidadeTipoStatusStore = Ext.create('Ext.data.Store', {
		fields: ['status_id', 'status_name'],
		data : [
			{"status_id":"1", "status_name":"Ativo"}
			,{"status_id":"0", "status_name":"Inativo"}
		]
	});

	// Create the combo box, attached to the states data store
	var publicidadeTipoStatusCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'publicidadeTipoStatusCombo'
		,id:'publicidadeTipoStatusCombo'
		,emptyText: 'Status'
		,store: publicidadeTipoStatusStore
		,name:'publicidadeTipo_status'
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
				var publicidadeTipo_titulo = publicidadeTipoTituloText.getValue();
				//console.log(usuarioGrid.getStore());
				publicidadeTipoGrid.getStore().load({
					params:{
						'publicidade_tipo_titulo': publicidadeTipo_titulo
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
				publicidadeTipoTituloText.setValue('');
				var publicidadeTipo_titulo = publicidadeTipoTituloText.getValue();
				publicidadeTipoGrid.getStore().load({
					params:{
						'publicidade_tipo_titulo': publicidadeTipo_titulo
					}
				});

			}
		}
	});
	var novoButton = Ext.create('Ext.Button', {
		itemId:"novoButton"
		,text:'Novo Tipo de publicidade'
		,tooltip:'Nova Tipo de publicidade'
		,iconCls:'icon-add'
		,listeners:{
			scope:this
			,click:function(button){
				window.location.href = 'publicidadeTipoEdicao.php';
			}
		}
	});


	//var GridView = Ext.create('Ext.grid.GridView',{});
	var publicidadeTipoGrid = Ext.create('Ext.grid.Panel', {
		title: 'Tipo de publicidade'
		,id:"publicidadeTipoGrid"
		,store: publicidadeTipoStore
		//,resizeble:true
		,autoScroll:true
		,height: 400
		,border:false
		,columns: [
			{header: 'Código',  dataIndex: 'publicidade_tipo_id',sortable: true, width:60}
			,{header: 'Título',  dataIndex: 'publicidade_tipo_titulo',sortable: true,width:200}
			,{header: 'Dt. Criação',  dataIndex: 'publicidade_tipo_dt_criacao',sortable: true,hidden:true, hideable:false}
			,{header: 'Dt/Hr Criação ',  dataIndex: 'publicidade_tipo_dtcomp_criacao',sortable: true,width:120}
			,{header: 'Dt. Alteração',  dataIndex: 'publicidade_tipo_dt_alteracao',sortable: true,hidden:true, hideable:false}
			,{header: 'Dt/Hr Alteração ',  dataIndex: 'publicidade_tipo_dtcomp_alteracao',sortable: true,width:120}
		]
		,listeners: {
			scope:this
			,itemdblclick:function(obj, record, item, index, e) {
				window.location.href = "publicidadeTipoEdicao.php?publicidade_tipo_id="+record.data.publicidade_tipo_id
			}
		}
		,layout:'fit'
		,dockedItems: [
			{
				xtype: 'pagingtoolbar',
				store: publicidadeTipoStore,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true,
				displayMsg: "Mostrando {0} - {1} de {2}"
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [

					{xtype:'tbspacer',width:10}
					,publicidadeTipoTituloText

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
    Ext.EventManager.onWindowResize(publicidadeTipoGrid.doLayout, publicidadeTipoGrid);

});