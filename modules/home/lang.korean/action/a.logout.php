<?php
if(!defined('__KIMS__')) exit;

if ($my['uid'])
{
	getDbUpdate($table['s_mbrdata'],'now_log=0','memberuid='.$my['uid']);
	$_SESSION['mbr_uid'] = '';
	$_SESSION['mbr_logout'] = '1';
}
if($g['mobile']&&$_SESSION['pcmode']!='Y'&&$_HS['m_layout']){
	getLink('/','top.','','');
}else{
	getLink($referer ? urldecode($referer) : $_SERVER['HTTP_REFERER'],'','','');
}
?>