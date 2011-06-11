Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var itemsPerPage = 100;   // set the number of items you want per page
	Ext.define('comentarioModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'comentario_id', type: 'int'}
			,{name:'usuario_id', type: 'int'}
			,{name:'post_titulo', type: 'string'}
			,{name:'comentario_autor', type: 'string'}
			,{name:'comentario_email', type: 'string'}
			,{name:'comentario_conteudo', type: 'string'}
			,{name:'comentario_dt_criacao', type: 'datetime'}
			,{name:'comentario_dtcomp_criacao', type: 'datetime'}
			,{name:'comentario_dt_alteracao', type: 'datetime'}
			,{name:'comentario_dtcomp_alteracao', type: 'datetime'}
			,{name:'comentario_status', type: 'int'}
			,{name:'categoria_id', type: 'int'}
			,{name:'categoria_nome', type: 'string'}
			
        ]
        ,idProperty: 'comentario_id'

    });

	var comentarioStore = Ext.create('Ext.data.Store', {
		id:'comentarioStore'
		,autoLoad: false
		,remoteSort: true
		,model:'comentarioModel'
		,pageSize: itemsPerPage // items per page
		,proxy: {
			type: 'ajax',
			url: 'controller/comentario.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: true
/*		,sorters: [
        {
            property : 'comentario_dtcomp_criacao',
            direction: 'DESC'
        }
    ]
*/
	});

	// specify segment of data you want to load using params
	comentarioStore.load({
		params:{
			start:0,
			limit: itemsPerPage
		}
	});

	Ext.define('comentarioCategoriaModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'categoria_id', type: 'int'}
			,{name:'categoria_nome', type: 'string'}
        ]
        ,idProperty: 'categoria_id'

    });
	var comentarioCategoriaStore = Ext.create('Ext.data.Store', {
		id:'comentarioCategoriaStore'
		,autoLoad: true
		,model:'comentarioCategoriaModel'
		,proxy: {
			type: 'ajax',
			url: 'controller/post.controller.php?action=getCategoria',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
	});

	// Create the combo box, attached to the states data store
	var comentarioCategoriaCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'postCategoriaCombo'
		,id:'postCategoriaCombo'
		,emptyText: 'Categoria do Post'
		,store: comentarioCategoriaStore
		,name:'categoria_id'
		,displayField: 'categoria_nome'
		,valueField: 'categoria_id'
	});






	var postTituloText = Ext.create('Ext.form.field.Text',{
		itemId:'postTituloText'
		,emptyText: 'Título do Post'
		,fieldLabel:''
		,name:'post_titulo'
		,anchor: '100%'
	});

	// The data store containing the list of states
	var comentarioStatusStore = Ext.create('Ext.data.Store', {
		fields: ['status_id', 'status_name'],
		data : [
			{"status_id":"1", "status_name":"Liberado"}
			,{"status_id":"0", "status_name":"Não Liberado"}
			,{"status_id":"2", "status_name":"Cancelado"}
		]
	});

	// Create the combo box, attached to the states data store
	var comentarioStatusCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'comentarioStatusCombo'
		,id:'comentarioStatusCombo'
		,emptyText: 'Status do Comentário'
		,store: comentarioStatusStore
		,name:'comentario_status'
		,queryMode: 'local'
		,displayField: 'status_name'
		,valueField: 'status_id'

	});


	Ext.define('comentarioUsuarioModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'usuario_id', type: 'int'}
			,{name:'usuario_nome_nivel', type: 'string'}
        ]
        ,idProperty: 'usuario_id'

    });
	var comentarioUsuarioStore = Ext.create('Ext.data.Store', {
		id:'comentarioUsuarioStore'
		,autoLoad: true
		,model:'comentarioUsuarioModel'
		,proxy: {
			type: 'ajax',
			url: 'controller/post.controller.php?action=getUsuario',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
	});

	// Create the combo box, attached to the states data store
	var comentarioUsuarioCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'postUsuarioCombo'
		,id:'postUsuarioCombo'
		,emptyText: 'Usuário'
		,store: comentarioUsuarioStore
		,name:'usuario_id'
		,displayField: 'usuario_nome_nivel'
		,valueField: 'usuario_id'
	});



	var filterButton = Ext.create('Ext.Button', {
		itemId:"filterButton"
		,text:''
		,tooltip:'Filtrar'
		,iconCls:'icon-search'
		,listeners:{
			scope:this
			,click:function(button){
				var usuario_id = comentarioUsuarioCombo.getValue();
				var titulo_nome = postTituloText.getValue();
				var comentario_status = comentarioStatusCombo.getValue();
				var categoria_id = comentarioCategoriaCombo.getValue();
				//console.log(usuarioGrid.getStore());
				comentarioGrid.getStore().load({
					params:{
						'titulo_nome': titulo_nome
						,'usuario_id': usuario_id
						,'comentario_status': comentario_status
						,'categoria_id': categoria_id
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
				comentarioUsuarioCombo.setValue('');
				postTituloText.setValue('');
				comentarioStatusCombo.setValue('');
				comentarioCategoriaCombo.setValue('');
				
				var titulo_nome = postTituloText.getValue();
				var usuario_id = comentarioUsuarioCombo.getValue();
				var comentario_status = comentarioStatusCombo.getValue();
				var categoria_id = comentarioCategoriaCombo.getValue();

				//console.log(usuarioGrid.getStore());
				comentarioGrid.getStore().load({
					params:{
						'titulo_nome': titulo_nome
						,'usuario_id': usuario_id
						,'comentario_status': comentario_status
						,'categoria_id': categoria_id
					}
				});

			}
		}
	});
	var novoButton = Ext.create('Ext.Button', {
		itemId:"novoButton"
		,text:'Novo Post'
		,tooltip:'Novo Post'
		,iconCls:'icon-add'
		,listeners:{
			scope:this
			,click:function(button){
				window.location.href = 'comentarioView.php';
			}
		}
	});

	var selModelPostGrid = Ext.create('Ext.selection.RowModel',{

			listeners: {
				scope:this
				,select: function(smObj, record, index) {
					//console.log(record.data.post_id)
				}
			}
	});



	//var GridView = Ext.create('Ext.grid.GridView',{});
	var comentarioGrid = Ext.create('Ext.grid.Panel', {
		title: 'Posts'
		,id:"postGrid"
		,store: comentarioStore
		//,resizeble:true
		,autoScroll:true
		,height: 400
		,border:false
		,columns: [
			{header: 'Código',  dataIndex: 'comentario_id',sortable: true, width:70}
			,{header: 'Categoria',  dataIndex: 'categoria_nome',sortable: true,width:120}
			,{header: 'Título',  dataIndex: 'post_titulo',sortable: true,width:250}
			,{header: 'Autor',  dataIndex: 'comentario_autor',sortable: true,width:250}
			//,{header: 'Email',  dataIndex: 'comentario_email',sortable: true,width:250}
			,{header: 'Conteúdo',  dataIndex: 'comentario_conteudo',sortable: true,width:250}
			//,{header: 'Dt. Criação',  dataIndex: 'comentario_dt_criacao',sortable: true,hidden:true,hideable:false}
			,{header: 'Dt/Hr Criação ',  dataIndex: 'comentario_dtcomp_criacao',sortable: true,width:120}
			//,{header: 'Dt. Alteração',  dataIndex: 'comentario_dt_alteracao',sortable: true,hidden:true,hideable:false}
			,{header: 'Dt/Hr Alteração ',  dataIndex: 'comentario_dtcomp_alteracao',sortable: true,width:120}
			,{
				header: 'Status',
				dataIndex: 'comentario_status',
				sortable: true,
				width:70,
				renderer:function(val){
					if(val == 1){
						return '<span style="color:blue">Liberado</span>'
					}else if(val == 0){
						return '<span style="color:silver">Não Liberado</span>'
					}else{
						return '<span style="color:red">Cancelado</span>'
					}
				}
			}
		]
		,listeners: {
			scope:this
			,itemdblclick:function(obj, record, item, index, e) {
				window.location.href = "comentarioView.php?comentario_id="+record.data.comentario_id
			}
		}
		,layout:'fit'
		,dockedItems: [
			{
				xtype: 'pagingtoolbar',
				store: comentarioStore,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true,
				displayMsg: "Mostrando {0} - {1} de {2}"
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [

					{xtype:'tbspacer',width:10}
					,comentarioCategoriaCombo

					,{xtype:'tbspacer',width:10}
					,postTituloText

					,{xtype:'tbspacer',width:10}
					,comentarioStatusCombo

					,{xtype:'tbspacer',width:10}
					,comentarioUsuarioCombo

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
					,{xtype:'label',html:'<b>Para visualizar, double-click no registro!</b>'}
				]
			}
		]
		,renderTo: 'grid'

		,viewConfig: {
            trackOver: false
        }
	});
	//pass along browser window resize events to the panel
    Ext.EventManager.onWindowResize(comentarioGrid.doLayout, comentarioGrid);

});


