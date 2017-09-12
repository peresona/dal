<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$vfile = $type == 'menu' ? $g['path_page'].'menu/'.sprintf('%05d',$uid).'.widget.php' : $g['path_page'].$id.'.widget.php';
$fp = fopen($vfile,'w');

fwrite($fp, "<?php\r\n");
fwrite($fp, "\$d['page']['mainheight'] = \"".$mainheight."\";\r\n");
fwrite($fp, stripslashes($escapevar)."\r\n");
fwrite($fp, "?>");

fclose($fp);
@chmod($vfile,0707);
$cachefile = str_replace('.php','.cache',$vfile);
if(file_exists($cachefile)) unlink($cachefile);

if ($backgo)
{
	if ($type == 'menu')
	{
		include_once $g['path_core'].'function/menu.func.php';
		$ctarr = getMenuCodeToPath($table['s_menu'],$uid,0);
		$ctnum = count($ctarr);
		$catst = '';
		for ($i = 0; $i < $ctnum; $i++) $catst .= $ctarr[$i]['id'].'/';
		$catst = substr($catst,0,strlen($catst)-1);
		if ($iframe=='Y') getLink(RW('c='.$catst),'parent.parent.','','');
		else getLink(RW('c='.$catst),'parent.','','');
	}
	else {
		if ($iframe=='Y') getLink(RW('mod='.$id),'parent.parent.','','');
		else getLink(RW('mod='.$id),'parent.','','');
	}
}
else {
	getLink('reload','parent.','','');
}
?>