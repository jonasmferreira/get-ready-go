Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var itemsPerPage = 100;   // set the number of items you want per page
	Ext.define('postModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'post_id', type: 'int'}
			,{name:'categoria_id', type: 'int'}
			,{name:'categoria_nome', type: 'string'}
			,{name:'usuario_id', type: 'int'}
			,{name:'post_titulo', type: 'string'}
			,{name:'post_thumb_home', type: 'string'}
			,{name:'post_imagem', type: 'string'}
			,{name:'post_palavra_chave', type: 'string'}
			,{name:'post_conteudo', type: 'string'}
			,{name:'post_dt_criacao', type: 'datetime'}
			,{name:'post_dtcomp_criacao', type: 'datetime'}
			,{name:'post_dt_alteracao', type: 'datetime'}
			,{name:'post_dtcomp_alteracao', type: 'datetime'}
			,{name:'post_status', type: 'int'}
        ]
        ,idProperty: 'post_id'
		
    });
	
	var postStore = Ext.create('Ext.data.Store', {
		id:'postStore'
		,autoLoad: false
		,remoteSort: true
		,model:'postModel'
		,pageSize: itemsPerPage // items per page
		,proxy: {
			type: 'ajax',
			url: 'controller/post.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: true
/*		,sorters: [
        {
            property : 'post_dtcomp_criacao',
            direction: 'DESC'
        }
    ]
*/
	});

	// specify segment of data you want to load using params
	postStore.load({
		params:{
			start:0,    
			limit: itemsPerPage
		}
	});
	
	var postTituloText = Ext.create('Ext.form.field.Text',{
		itemId:'postTituloText'
		,emptyText: 'Título do Post'
		,fieldLabel:''
		,name:'post_titulo'
		,anchor: '100%'
	});
	
	// The data store containing the list of states
	var postStatusStore = Ext.create('Ext.data.Store', {
		fields: ['status_id', 'status_name'],
		data : [
			{"status_id":"1", "status_name":"Ativo"}
			,{"status_id":"0", "status_name":"Inativo"}
		]
	});

	// Create the combo box, attached to the states data store
	var postStatusCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'postStatusCombo'
		,id:'postStatusCombo'
		,emptyText: 'Status'
		,store: postStatusStore
		,name:'post_status'
		,queryMode: 'local'
		,displayField: 'status_name'
		,valueField: 'status_id'
		
	});
	
	Ext.define('postCategoriaModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'categoria_id', type: 'int'}
			,{name:'categoria_nome', type: 'string'}
        ]
        ,idProperty: 'categoria_id'
		
    });
	var postCategoriaStore = Ext.create('Ext.data.Store', {
		id:'postCategoriaStore'
		,autoLoad: true
		,model:'postCategoriaModel'
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
	var postCategoriaCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'postCategoriaCombo'
		,id:'postCategoriaCombo'
		,emptyText: 'Categoria'
		,store: postCategoriaStore
		,name:'categoria_id'
		,displayField: 'categoria_nome'
		,valueField: 'categoria_id'
		
	});
	

	Ext.define('postUsuarioModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'usuario_id', type: 'int'}
			,{name:'usuario_nome_nivel', type: 'string'}
        ]
        ,idProperty: 'usuario_id'
		
    });
	var postUsuarioStore = Ext.create('Ext.data.Store', {
		id:'postUsuarioStore'
		,autoLoad: true
		,model:'postUsuarioModel'
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
	var postUsuarioCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'postUsuarioCombo'
		,id:'postUsuarioCombo'
		,emptyText: 'Usuário'
		,store: postUsuarioStore
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
				var categoria_id = postCategoriaCombo.getValue();
				var usuario_id = postUsuarioCombo.getValue();
				var titulo_nome = postTituloText.getValue();
				var post_status = postStatusCombo.getValue();
				//console.log(usuarioGrid.getStore());
				postGrid.getStore().load({
					params:{
						'categoria_id': categoria_id
						,'titulo_nome': titulo_nome
						,'usuario_id': usuario_id
						,'post_status': post_status
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
				postCategoriaCombo.setValue('');
				postUsuarioCombo.setValue('');
				postTituloText.setValue('');
				postStatusCombo.setValue('');
				
				var categoria_id = postCategoriaCombo.getValue();
				var titulo_nome = postTituloText.getValue();
				var usuario_id = postUsuarioCombo.getValue();
				var post_status = postStatusCombo.getValue();
				//console.log(usuarioGrid.getStore());
				postGrid.getStore().load({
					params:{
						'categoria_id': categoria_id
						,'titulo_nome': titulo_nome
						,'usuario_id': usuario_id
						,'post_status': post_status
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
				window.location.href = 'postEdicao.php';
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
	var postGrid = Ext.create('Ext.grid.Panel', {
		title: 'Posts'
		,id:"postGrid"
		,store: postStore
		//,resizeble:true
		,autoScroll:true
		,height: 400
		,border:false
		,columns: [
			{header: 'Código',  dataIndex: 'post_id',sortable: true, width:70}
			,{header: 'Categoria ID',  dataIndex: 'categoria_id',sortable: true,hidden:true, hideable:false}
			,{header: 'Categoria',  dataIndex: 'categoria_nome',sortable: true, width:150}
			,{header: 'Título',  dataIndex: 'post_titulo',sortable: true,width:250}
			/*,{
				header: 'Thumb Home',  
				dataIndex: 'post_thumb_home', 
				sortable: true,
				renderer:function(val){
					return '<img width="30%" height="30%" alt="thumb home" src="../posts/'+val+'" />';
				}
			}
			,{
				header: 'Imagem',  
				dataIndex: 'post_imagem', 
				sortable: true,
				renderer:function(val){
					return '<img width="30%" height="30%" alt="thumb home" src="../posts/'+val+'" />';
				}
			}*/
			,{header: 'Keywords',  dataIndex: 'post_palavra_chave',sortable: true,width:150}
			//,{header: 'Conteúdo',  dataIndex: 'post_conteudo',sortable: false, hidden:true, hideable:false}
			,{header: 'Dt. Criação',  dataIndex: 'post_dt_criacao',sortable: true,hidden:true,hideable:false}
			,{header: 'Dt/Hr Criação ',  dataIndex: 'post_dtcomp_criacao',sortable: true,width:120}
			,{header: 'Dt. Alteração',  dataIndex: 'post_dt_alteracao',sortable: true,hidden:true,hideable:false}
			,{header: 'Dt/Hr Alteração ',  dataIndex: 'post_dtcomp_alteracao',sortable: true,width:120}
			,{
				header: 'Status',  
				dataIndex: 'post_status',
				sortable: true,
				width:70,
				renderer:function(val){
					if(val==0){
						return 'Inativo'
					}else{
						return 'Ativo'
					}
				}
			}
		]
		,listeners: {
			scope:this
			,itemdblclick:function(obj, record, item, index, e) {
				window.location.href = "postEdicao.php?post_id="+record.data.post_id
			}
		}
		,layout:'fit'
		,dockedItems: [
			{
				xtype: 'pagingtoolbar',
				store: postStore,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true,
				displayMsg: "Mostrando {0} - {1} de {2}"
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [
					
					{xtype:'tbspacer',width:10}
					,postTituloText
					
					,{xtype:'tbspacer',width:10}
					,postCategoriaCombo
					
					,{xtype:'tbspacer',width:10}
					,postStatusCombo
					
					,{xtype:'tbspacer',width:10}
					,postUsuarioCombo
					
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
    Ext.EventManager.onWindowResize(postGrid.doLayout, postGrid);

});


