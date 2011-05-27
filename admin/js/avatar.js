Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var itemsPerPage = 100;   // set the number of items you want per page
	Ext.define('avatarModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'avatar_id', type: 'int'}
			,{name:'avatar_titulo', type: 'string'}
			
        ]
        ,idProperty: 'avatar_id'
		
    });
	
	var avatarStore = Ext.create('Ext.data.Store', {
		id:'avatarStore'
		,autoLoad: false
		,remoteSort: true
		,model:'avatarModel'
		,pageSize: itemsPerPage // items per page
		,proxy: {
			type: 'ajax',
			url: 'controller/avatar.controller.php',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: true
	});

	// specify segment of data you want to load using params
	avatarStore.load({
		params:{
			start:0,    
			limit: itemsPerPage
		}
	});
	
	var avatarTituloText = Ext.create('Ext.form.field.Text',{
		itemId:'avatarTituloText'
		,emptyText: 'Título do Avatar'
		,fieldLabel:''
		,name:'avatar_titulo'
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
				var avatar_titulo = avatarTituloText.getValue();
				avatarGrid.getStore().load({
					params:{
						'avatar_titulo': avatar_titulo
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
				avatarTituloText.setValue('');
				var avatar_titulo = avatarTituloText.getValue();
				avatarGrid.getStore().load({
					params:{
						'avatar_titulo': avatar_titulo
					}
				});
				
			}
		}
	});
	var novoButton = Ext.create('Ext.Button', {
		itemId:"novoButton"
		,text:'Novo Avatar'
		,tooltip:'Novo Avatar'
		,iconCls:'icon-add'
		,listeners:{
			scope:this
			,click:function(button){
				window.location.href = 'avatarEdicao.php';
			}
		}
	});
	
	
	//var GridView = Ext.create('Ext.grid.GridView',{});
	var avatarGrid = Ext.create('Ext.grid.Panel', {
		title: 'Avatars'
		,id:"avatarGrid"
		,store: avatarStore
		//,resizeble:true
		,autoScroll:true
		,height: 400
		,border:false
		,columns: [
			{header: 'Código',  dataIndex: 'avatar_id',sortable: true}
			,{header: 'Título',  dataIndex: 'avatar_titulo',sortable: true}
		]
		,listeners: {
			scope:this
			,itemdblclick:function(obj, record, item, index, e) {
				window.location.href = "avatarEdicao.php?avatar_id="+record.data.avatar_id
			}
		}
		,layout:'fit'
		,dockedItems: [
			{
				xtype: 'pagingtoolbar',
				store: avatarStore,   // same store GridPanel is using
				dock: 'bottom',
				displayInfo: true,
				displayMsg: "Mostrando {0} - {1} de {2}"
			}
			,{
				xtype: 'toolbar',
				dock: 'top',
				items: [
					
					{xtype:'tbspacer',width:10}
					,avatarTituloText
					
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
    Ext.EventManager.onWindowResize(avatarGrid.doLayout, avatarGrid);

});


