<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$vfile = $type == 'menu' ? $g['path_page'].'menu/'.sprintf('%05d',$uid) : $g['path_page'].$id;

$fp = fopen($vfile.'.php','w');
fwrite($fp, trim(stripslashes($source)));
fclose($fp);
@chmod($vfile.'.php',0707);

if (trim($mobile))
{
	$fp = fopen($vfile.'.mobile.php','w');
	fwrite($fp, trim(stripslashes($mobile)));
	fclose($fp);
	@chmod($vfile.'.mobile.php',0707);
}
else {
	if(is_file($vfile.'.mobile.php'))
	{
		unlink($vfile.'.mobile.php');
	}
}

if (trim($css))
{
	$fp = fopen($vfile.'.css','w');
	fwrite($fp, trim(stripslashes($css)));
	fclose($fp);
	@chmod($vfile.'.css',0707);
}
else {
	if(is_file($vfile.'.css'))
	{
		unlink($vfile.'.css');
	}
}

if (trim($js))
{
	$fp = fopen($vfile.'.js','w');
	fwrite($fp, trim(stripslashes($js)));
	fclose($fp);
	@chmod($vfile.'.js',0707);
}
else {
	if(is_file($vfile.'.js'))
	{
		unlink($vfile.'.js');
	}
}

$cachefile_pc = str_replace('.php','.cache',$vfile);
$cachefile_mobile = str_replace('.php','.cache',$vfile.'.mobile');
if(file_exists($cachefile_pc)) unlink($cachefile_pc);
if(file_exists($cachefile_mobile)) unlink($cachefile_mobile);

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