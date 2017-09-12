<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$R = getUidData($table['s_site'],$account);
if ($R['uid'])
{
	getDbDelete($table['s_start'],'site='.$R['uid']);
	getDbDelete($table['s_site'],'uid='.$R['uid']);

	$_MENUS = getDbSelect($table['s_menu'],'site='.$R['uid'].' order by gid asc','*');
	while($_M = db_fetch_array($_MENUS))
	{
		$_xfile = $g['path_page'].'menu/'.sprintf('%05d',$_M['uid']);

		unlink($_xfile.'.php');
		unlink($_xfile.'.widget.php');
		@unlink($_xfile.'.mobile.php');
		@unlink($_xfile.'.css');
		@unlink($_xfile.'.js');
		@unlink($_xfile.'.header.php');
		@unlink($_xfile.'.footer.php');

		@unlink($_xfile.'.txt');
		@unlink($_xfile.'.cache');
		@unlink($_xfile.'.widget.cache');
		@unlink($_xfile.'.mobile.cache');

		@unlink($g['path_var'].'menu/'.$_M['imghead']);
		@unlink($g['path_var'].'menu/'.$_M['imgfoot']);	
		
		getDbDelete($table['s_seo'],'rel=1 and parent='.$_M['uid']);
	}

	getDbDelete($table['s_menu'],'site='.$R['uid']);

	db_query("OPTIMIZE TABLE ".$table['s_site'],$DB_CONNECT); 
	db_query("OPTIMIZE TABLE ".$table['s_menu'],$DB_CONNECT); 

	unlink($g['path_var'].'sitephp/'.$account.'.php');
}

getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m,'parent.','','');
?>