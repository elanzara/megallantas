//para insertar flash
function pongoflash(pelicula,ancho,alto){
		document.write("<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0' width='"+ancho+"' height='"+alto+"'>");
		document.write("<param name='movie' value='"+pelicula+"' />");
		document.write("<param name='quality' value='high' />");
		document.write("<param name='allowScriptAccess' value='always' />");
		document.write("<embed src='"+pelicula+"' quality='high' pluginspage='http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash' width='"+ancho+"' height='"+alto+"'></embed>");
		document.write("</object>");
}

//para insertar flash transparente
function flash(pelicula,ancho,alto){
		document.write("<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0' width='"+ancho+"' height='"+alto+"'>");
		document.write("<param name='movie' value='"+pelicula+"' />");
		document.write("<param name='quality' value='high' />");
		document.write("<param name='wmode' value='transparent' />");
		document.write("<embed src='"+pelicula+"' quality='high' pluginspage='http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash' wmode='transparent' width='"+ancho+"' height='"+alto+"'></embed>");
		document.write("</object>");
}

//para insertar pop-up centrados
function popup(pag,alto,ancho){

resx = screen.width;
resy = screen.height;
posx = (resx-ancho)/2
posy = (resy-alto)/2



propiedades="width="+ancho+", height="+alto+",top="+posy+",left="+posx+",scrollbars=yes, toolbar=no";
window.open(pag,"x",propiedades)

}

//Roll Over menu
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}



