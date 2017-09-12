<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if ($uid)
{
	$R = getUidData('rb_dalkkum_banner',$uid);
}

if($R['img']) unlink($g['path_root'].'files/_etc/foot_banner/'.$R['file']);

getDbDelete('rb_dalkkum_banner','uid='.$uid);

getLink('reload','parent.', $alert , $history);
?>