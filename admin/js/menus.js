Ext.require(['*']);
Ext.onReady(function(){
    Ext.QuickTips.init();
	var menu = Ext.create('Ext.menu.Menu', {
		id: 'mainMenu',
        style: {
            overflow: 'visible'     // For the Combo popup
        },
        items: [
			{
                text: 'I like Ext'
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
                text:'Testes',
				iconCls: 'bmenu',  // <-- icon
				menu: menu  // assign menu by instance
            }
		]
	});
    tb.suspendLayout = true;
    tb.render('topmenu');
	tb.suspendLayout = false;
    tb.doLayout();
});
