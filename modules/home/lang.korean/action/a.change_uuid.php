<?php
if(!defined('__KIMS__')) exit;
$result = array('code' => 0);
if($my['memberuid'] && ($UUID || $REGID || $DEV)) {
	// 겹치는 UUID 제거
	getDbUpdate($table['s_mbrdata'],"mobile_uuid=NULL, mobile_regid=NULL, mobile_dev=NULL",'mobile_uuid="'.$UUID.'" or mobile_regid="'.$REGID.'"');
	// UUID 기입
	getDbUpdate($table['s_mbrdata'],"mobile_uuid='".$UUID."',mobile_regid='".$REGID."',mobile_dev='".$DEV."'",'memberuid='.$my['memberuid']);
	$result['code'] = 100;
}
	echo json_encode($result); exit;
?>