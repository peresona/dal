<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if ($uid)
{
	$R = getUidData('rb_dalkkum_group',$uid);
}

if($R['img']) unlink($g['path_root'].'files/_etc/group/'.$R['img']);

getDbDelete('rb_dalkkum_group','uid='.$uid);

getLink('reload','parent.', $alert , $history);
?>