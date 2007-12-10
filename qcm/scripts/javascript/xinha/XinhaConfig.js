var xinha_plugins =
[
 'ContextMenu'
];

var xinha_editors=[];

function xinha_init()
{
  // THIS BIT OF JAVASCRIPT LOADS THE PLUGINS, NO TOUCHING  :)
  if(!Xinha.loadPlugins(xinha_plugins, xinha_init)) return;
  var xinha_config = new Xinha.Config();
  xinha_config.showLoading= false;
  xinha_config.statusBar = false;
  xinha_config.toolbar =
	 [
	   ["popupeditor"],
	   ["separator","formatblock","fontname","fontsize"],
	   ["separator","undo","redo"],
	   ["separator","bold","italic","underline"],
	   ["separator","forecolor","hilitecolor"],
	   ["separator","subscript","superscript"],
	   ["separator","justifyleft","justifycenter","justifyright","justifyfull"],
	   ["separator","insertorderedlist","insertunorderedlist"],
	   ["separator","inserthorizontalrule","createlink","insertimage","inserttable"],
	   ["separator","htmlmode","showhelp","about"]
	 ];
//  var vliste_textarea = new Array('intitule_texte','solution_texte','validation_texte');
  var vliste_textarea=document.getElementsByTagName("TEXTAREA");
  var i=0;
  for (a in vliste_textarea)
  {
	  vtextarea=vliste_textarea[i];
	  if(vtextarea!=null && vtextarea!=undefined)
	  {
		  vtextarea_id=vtextarea.getAttribute("Id");
		  if(vtextarea_id!=null && vtextarea_id!=undefined && document.getElementById(vtextarea_id)!=null)
		  {
			  xinha_editors.push(vtextarea_id);
		  }
	  }
	  i++;
  }
  xinha_editors = Xinha.makeEditors(xinha_editors, xinha_config, xinha_plugins);
  Xinha.startEditors(xinha_editors);
}
window.onload = xinha_init;