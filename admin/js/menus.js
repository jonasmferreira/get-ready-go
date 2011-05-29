Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var menuConfiguracoes = Ext.create('Ext.menu.Menu', {
		id: 'menuConfiguracoes',
        style: {
            overflow: 'visible'     // For the Combo popup
        },
        items: [
			{
                text: 'Usuários'
				,listeners:{
					scope:this
					,click:function(){
						window.location.href="usuario.php"
					}
				}	
			}
			,{
                text: 'Avatares'
				,listeners:{
					scope:this
					,click:function(){
						window.location.href="avatar.php"
					}
				}	
			}
		]
	});
	var menuPosts = Ext.create('Ext.menu.Menu', {
		id: 'menuPosts',
        style: {
            overflow: 'visible'     // For the Combo popup
        },
        items: [
			{
                text: 'Categorias'
				,listeners:{
					scope:this
					,click:function(){
						window.location.href="categoria.php"
					}
				}	
			}
			,{
                text: 'Posts'
				,listeners:{
					scope:this
					,click:function(){
						window.location.href="post.php"
					}
				}	
			}
			,{
                text: 'Comentários'
				,listeners:{
					scope:this
					,click:function(){
						alert("opa");
					}
				}	
			}
		]
	});

	var menuEnquetes = Ext.create('Ext.menu.Menu', {
		id: 'menuEnquetes',
        style: {
            overflow: 'visible'     // For the Combo popup
        },
        items: [
			{
                text: 'Enquetes'
				,listeners:{
					scope:this
					,click:function(){
						window.location.href="enquete.php"
					}
				}	
			}
			,{
                text: 'Resultados'
				,listeners:{
					scope:this
					,click:function(){
						window.location.href="resultadoEnquete.php"
					}
				}	
			}
		]
	});

	var menuPublicidade = Ext.create('Ext.menu.Menu', {
		id: 'menuPosts',
        style: {
            overflow: 'visible'     // For the Combo popup
        },
        items: [
			{
                text: 'Publicidade'
				,listeners:{
					scope:this
					,click:function(){
						window.location.href="publicidade.php"
					}
				}
			}
			,{
                text: 'Tipo de Publicidade'
				,listeners:{
					scope:this
					,click:function(){
						window.location.href="publicidadeTipo.php"
					}
				}
			}
		]
	});
	var menuGames = Ext.create('Ext.menu.Menu', {
		id: 'menuGames',
        style: {
            overflow: 'visible'     // For the Combo popup
        },
        items: [
			{
                text: 'Categoria'
				,listeners:{
					scope:this
					,click:function(){
						window.location.href="categoriaGame.php"
					}
				}
			}
			,{
                text: 'Tipo de Game'
				,listeners:{
					scope:this
					,click:function(){
						window.location.href="tipoGame.php"
					}
				}
			}
			,{
                text: 'Games'
				,listeners:{
					scope:this
					,click:function(){
						window.location.href="game.php"
					}
				}
			}
		]
	});
	
    var tb = Ext.create('Ext.toolbar.Toolbar',{
		id:'menuToolbar'
		,style: {
            overflow: 'visible'     // For the Combo popup
			,margin: '5px auto'
			,width:'99%'
			
        }
		,items:[
			{
                text:'Configurações'
				,iconCls: 'bmenu'  // <-- icon
				,menu: menuConfiguracoes  // assign menu by instance
            }
			,{
                text:'Posts'
				,iconCls: 'bmenu'  // <-- icon
				,menu: menuPosts  // assign menu by instance
            }
			,{
                text:'Games'
				,iconCls: 'bmenu'  // <-- icon
				,menu: menuGames  // assign menu by instance
            }
			,{
                text:'Galerias'
				,iconCls: 'bmenu'  // <-- icon
				,listeners:{
					scope:this
					,click:function(){
						window.location.href="galeria.php"
					}
				}
            }
			,{
                text:'Enquetes'
				,iconCls: 'bmenu'  // <-- icon
				,menu: menuEnquetes  // assign menu by instance
            }
			,{
                text:'Publicidade'
				,iconCls: 'bmenu'  // <-- icon
				,menu:menuPublicidade
            }
		]
	});
    tb.suspendLayout = true;
    tb.render('topmenu');
	tb.suspendLayout = false;
    tb.doLayout();
});
