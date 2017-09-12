<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if ($uid)
{
	$R = getUidData('rb_dalkkum_job',$uid);
}

if($R['img']) unlink($g['path_root'].'files/_etc/job/'.$R['img']);

getDbDelete('rb_dalkkum_job','uid='.$uid);


$_jobnum = getDbArray('rb_dalkkum_job','parent='.$R['parent'],'*','uid','asc',0,'');
$_NUM = db_num_rows($_jobnum);

if(!$_NUM) db_query("update rb_dalkkum_job set isson=0 where uid=".$R['parent'],$DB_CONNECT);

getLink('reload','parent.', $alert, $history);
?>