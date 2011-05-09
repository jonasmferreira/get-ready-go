Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	
	
	
	var usuarioIDHidden = Ext.create('Ext.form.field.Hidden',{
		itemId:'usuarioIDHidden'
		,emptyText: ''
		,fieldLabel:''
		,name:'usuario_id'
		,allowBlank: false
		,anchor: '100%'
	});
	var usuarioNomeText = Ext.create('Ext.form.field.Text',{
		itemId:'usuarioNomeText'
		,emptyText: 'Nome do Usuário'
		,fieldLabel:'Nome'
		,allowBlank: false
		,name:'usuario_nome'
		,anchor: '100%'
	});
	
	var usuarioLoginText = Ext.create('Ext.form.field.Text',{
		itemId:'usuarioLoginText'
		,emptyText: 'Login do Usuário'
		,fieldLabel:'Login'
		,allowBlank: false
		,name:'usuario_login'
		,anchor: '100%'
	});
	var usuarioSenhaText = Ext.create('Ext.form.field.Text',{
		itemId:'usuarioSenhaText'
		,emptyText: 'Senha do Usuário'
		,fieldLabel:'Senha'
		,inputType: 'password'
		,allowBlank: false
		,name:'usuario_senha'
		,anchor: '100%'
	});
	var usuarioEmailText = Ext.create('Ext.form.field.Text',{
		itemId:'usuarioEmailText'
		,emptyText: 'E-mail do Usuário'
		,fieldLabel:'E-mail'
		,allowBlank: false
		,name:'usuario_email'
		,anchor: '100%'
	});
	
	// The data store containing the list of states
	var usuarioStatusStore = Ext.create('Ext.data.Store', {
		fields: ['status_id', 'status_name'],
		data : [
			{"status_id":"1", "status_name":"Ativo"}
			,{"status_id":"0", "status_name":"Inativo"}
		]
	});

	// Create the combo box, attached to the states data store
	var usuarioStatusCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'usuarioStatusCombo'
		,id:'usuarioStatusCombo'
		,fieldLabel:'Status'
		,emptyText: 'Status do Usuário'
		,allowBlank: false
		,store: usuarioStatusStore
		,name:'usuario_status'
		,queryMode: 'local'
		,displayField: 'status_name'
		,valueField: 'status_id'
		,anchor: '100%'
		
	});
	
	Ext.define('usuarioNivelModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'usuario_nivel_id', type: 'int'}
			,{name:'usuario_nivel_titulo', type: 'string'}
        ]
        ,idProperty: 'usuario_nivel_id'
		
    });
	var usuarioNivelStore = Ext.create('Ext.data.Store', {
		id:'usuarioNivelStore'
		,autoLoad: true
		,allowBlank: false
		,model:'usuarioNivelModel'
		,proxy: {
			type: 'ajax',
			url: 'controller/usuario.controller.php?action=getUsuarioNivel',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,listeners:{
			scope:this
			,load:function(){
				// specify segment of data you want to load using params
				if(jQuery.trim(usuario_id)!=''){
					usuarioFormStore.load({
						params:{
							'usuario_id':usuario_id
						}
					});
				}
			}
		}
	});
	
	// Create the combo box, attached to the states data store
	var usuarioNivelCombo = Ext.create('Ext.form.ComboBox', {
		itemId:'usuarioNivelCombo'
		,id:'usuarioNivelCombo'
		,fieldLabel:'Nível'
		,emptyText: 'Nível do Usuário'
		,allowBlank: false
		,store: usuarioNivelStore
		,name:'usuario_nivel_id'
		,displayField: 'usuario_nivel_titulo'
		,valueField: 'usuario_nivel_id'
		,anchor: '100%'
		
	});
	
	var usuarioAvatarFile = Ext.create('Ext.form.field.File',{
		itemId:'usuarioAvatarFile'
		,name: 'usuario_avatar'
        ,fieldLabel: 'Avatar'
		,emptyText: 'Avatar do Usuário'
        ,anchor: '100%'
        ,buttonText: 'Selecione uma Imagem'
	});
	
	
	Ext.define('usuarioFormModel', {
        extend: 'Ext.data.Model'
        ,fields: [
			{name:'usuario_id', type: 'int'}
			,{name:'usuario_nivel_id', type: 'int'}
			,{name:'usuario_nome', type: 'string'}
			,{name:'usuario_login', type: 'string'}
			,{name:'usuario_senha', type: 'string'}
			,{name:'usuario_email', type: 'string'}
			,{name:'usuario_avatar', type: 'string'}
			,{name:'usuario_status', type: 'string'}
			,{name:'usuario_nivel_titulo', type: 'string'}
        ]
        ,idProperty: 'usuario_id'
		
    });
	var usuarioFormStore = Ext.create('Ext.data.Store', {
		id:'usuarioStore'
		,autoLoad: false
		,remoteSort: true
		,model:'usuarioFormModel'
		,proxy: {
			type: 'ajax',
			url: 'controller/usuario.controller.php?action=getOne',  // url that will load data with respect to start and limit params
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'totalCount'
			}
		}
		,simpleSortMode: true
		,listeners: {
			scope:this
			,load: function(store, options){
				var record = store.getAt(0).data;
				usuarioIDHidden.setValue(record.usuario_id);
				usuarioNomeText.setValue(record.usuario_nome);
				usuarioLoginText.setValue(record.usuario_login);
				usuarioSenhaText.setValue(record.usuario_senha);
				usuarioEmailText.setValue(record.usuario_email);
				usuarioNivelCombo.setValue(record.usuario_nivel_id);
				usuarioStatusCombo.setValue(record.usuario_status);
			}
		}
	});

	
	
	var usuarioForm = Ext.create('Ext.form.Panel', {
		title: 'Usuário'
		,id:'usuarioForm'
		// The form will submit an AJAX request to this URL when submitted
		,url: 'controller/usuario.controller.php?action=edit'

		// Fields will be arranged vertically, stretched to full width
		,layout: 'fit'
		,defaults: {
			anchor: '100%'
		}
		
		,standardSubmit:true

		// The fields
		,defaultType: 'textfield'
		,items: [
			usuarioIDHidden
			,{
					xtype: 'fieldset',
					title: 'Edição',
					border: false,
					layout: 'column',
					height: '200',
					margins:'0 0 0 0',
					bodyStyle: 'padding-left:0;padding-right:0;',
					items: [
						//Linha 1
						{
							columnWidth: 0.9
							,layout: 'anchor'
							,border: false
							,bodyStyle: 'padding-left:0;padding-right:0;'
							,items: [
								usuarioNomeText
							]
						}
						
						//Linha 2
						,{
							columnWidth: 0.45
							,layout: 'anchor'
							,border: false
							,bodyStyle: 'padding-left:0;margin-right:5px'
							,items: [
								usuarioLoginText
							]
						}
						,{
							columnWidth: 0.45
							,layout: 'anchor'
							,border: false
							,bodyStyle: 'padding-left:0;padding-right:0;'
							,items: [
								usuarioSenhaText
							]
						}
						
						//Linha 3
						,{
							columnWidth: 0.45
							,layout: 'anchor'
							,border: false
							,bodyStyle: 'padding-right:0;margin-right:5px'
							,items: [
								usuarioEmailText
							]
						}
						,{
							columnWidth: 0.45
							,layout: 'anchor'
							,border: false
							,bodyStyle: 'padding-left:0;padding-right:0;'
							,items: [
								usuarioAvatarFile
							]
						}
						
						//Linha 4
						,{
							columnWidth: 0.45
							,layout: 'anchor'
							,border: false
							,bodyStyle: 'padding-left:0;margin-right:5px'
							,items: [
								usuarioNivelCombo
							]
						}
						,{
							columnWidth: 0.45
							,layout: 'anchor'
							,border: false
							,bodyStyle: 'padding-left:0;padding-right:0;'
							,items: [
								usuarioStatusCombo
							]
						}
						
					]
				}
		]

		// Reset and Submit buttons
		,buttons: [
			{
				text: 'Voltar',
				handler: function() {
					window.location.href="usuario.php"
				}
			}
			,{
				text: 'Limpar Campos',
				handler: function() {
					this.up('form').getForm().reset();
				}
			}, 
			{
				text: 'Enviar',
				formBind: true, //only enabled once the form is valid
				disabled: true,
				handler: function() {
					var form = this.up('form').getForm();
					if (form.isValid()) {
						form.submit({
							success: function(form, action) {
								Ext.Msg.alert('Success', action.result.msg);
							},
							failure: function(form, action) {
								Ext.Msg.alert('Failed', action.result.msg);
							}
						});
					}
				}
			}
		]
		,renderTo: 'grid'
	});
	//pass along browser window resize events to the panel
    Ext.EventManager.onWindowResize(usuarioForm.doLayout, usuarioForm);

});


