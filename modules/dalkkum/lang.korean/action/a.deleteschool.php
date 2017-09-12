<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if ($uid)
{
	$R = getUidData('rb_dalkkum_sclist',$uid);
}


getDbDelete('rb_dalkkum_sclist','uid='.$uid);

getLink('reload','parent.', $alert , $history);
?>