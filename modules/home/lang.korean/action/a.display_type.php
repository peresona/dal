<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$typeset = array('','module','widget','source');
if ($type == 'menu')
{
	getDbUpdate($table['s_menu'],'menutype='.$value,'uid='.$uid);
	getLink($g['s'].'/?r='.$r.'&iframe='.$iframe.'&system=edit.menu&_menu='.$uid.'&type='.$typeset[$value],'parent.','','');
}
else {
	getDbUpdate($table['s_page'],'pagetype='.$value,'uid='.$uid);
	getLink($g['s'].'/?r='.$r.'&iframe='.$iframe.'&system=edit.page&_page='.$uid.'&type='.$typeset[$value],'parent.','','');
}
?>