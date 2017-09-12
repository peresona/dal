<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'])
{
	getLink('','','정상적인 접근이 아닙니다.','');
}

if (!is_array($members)) $members = $fuid ? array($fuid) : array();

foreach($members as $val)
{
	$R = getUidData($table['s_friend'],$val);
	if ($R['uid'] && !$R['rel'])
	{
		getDbInsert($table['s_friend'],'rel,my_mbruid,by_mbruid,category,d_regis',"'1','".$my['uid']."','".$R['my_mbruid']."','','".$date['totime']."'");
		getDbUpdate($table['s_friend'],'rel=1','uid='.$R['uid']);
		$_tmp = getDbRows('rb_s_friend','by_mbruid='.$R['my_mbruid']);
		getDbUpdate('rb_s_mbrdata','follower='.$_tmp,'memberuid='.$R['my_mbruid']);
	}
}

if ($mbruid)
{
	if (!$fuid)
	{
		$M = getUidData($table['s_mbrid'],$mbruid);
		if (!$M['uid']) getLink('','','존재하지 않는 회원입니다.','');
		getDbInsert($table['s_friend'],'rel,my_mbruid,by_mbruid,category,d_regis',"'0','".$my['uid']."','".$M['uid']."','','".$date['totime']."'");
	}
	if($mode=='mblog'){
		echo '<script type="text/javascript">';
		echo 'parent.fanReload("follow");';
		echo '</script>';
	}
	if($mode=='lib'){
		$_tmpd = getDbData($table['s_friend'],'my_mbruid='.$my['memberuid'].' and by_mbruid='.$mbruid,'uid');
		echo '<script type="text/javascript"> parent.lib_reload_m("'.$mbruid.'","add","'.$_tmpd['uid'].'"); </script>';
	}
	if($mode=='reload'){
		echo '<script type="text/javascript"> parent.location.reload(); </script>';
	}
	else{
		echo '<script type="text/javascript">';
		echo 'parent.getMemberLayerLoad('.$mbruid.');';
		echo '</script>';
	}
	$_tmp = getDbRows('rb_s_friend','by_mbruid='.$M['uid']);
	getDbUpdate('rb_s_mbrdata','follower='.$_tmp,'memberuid='.$M['uid']);
	getLink('','','','');
}
else {
	getLink('reload','parent.','','');
}
?>