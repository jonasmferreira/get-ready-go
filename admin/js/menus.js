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
						alert("opa");
					}
				}	
			}
			,{
                text: 'Posts'
				,listeners:{
					scope:this
					,click:function(){
						alert("opa");
					}
				}	
			}
			,{
                text: 'Galerias do Post'
				,listeners:{
					scope:this
					,click:function(){
						alert("opa");
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
						alert("opa");
					}
				}	
			}
			,{
                text: 'Resultados'
				,listeners:{
					scope:this
					,click:function(){
						alert("opa");
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
                text:'Galerias'
				,iconCls: 'bmenu'  // <-- icon
				,listeners:{
					scope:this
					,click:function(){
						alert("opa");
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
				,listeners:{
					scope:this
					,click:function(){
						alert("opa");
					}
				}
            }
		]
	});
    tb.suspendLayout = true;
    tb.render('topmenu');
	tb.suspendLayout = false;
    tb.doLayout();
});
