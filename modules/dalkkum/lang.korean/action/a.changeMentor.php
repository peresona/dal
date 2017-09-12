<?php
if(!defined('__KIMS__')) exit;
checkAdmin(0);
// 멘토 변경 
if($act=='changeMentor'){
	if (!$tid || !$mid)
	{
		getLink('','', '잘못된 접근입니다.', '');
	}
		$jobD = getDbData('rb_s_mbrdata','memberuid='.$mid,'mentor_job');
		$QVAL = "mentor_seq='".$mid."',job_seq='".$jobD['mentor_job']."'";
		getDbUpdate('rb_dalkkum_team',$QVAL,'uid='.$tid);
		echo "<script>top.okfunc();</script>";
		exit;
}
// 팀 정원 변경
if($act == 'modifyLimits'){
	// 팀 uid, 변경값 , 1차 2차 여부
	if (!$tid || !$change || !$order)
	{
		getLink('','', '잘못된 접근입니다.', '');
	}
	$jobD = getDbData('rb_dalkkum_team','uid='.$tid,'limits,limits2');
	if($order=='1')	$thisLimits = $jobD['limits'];
	else if($order=='2') $thisLimits = $jobD['limits2'];

	// 만약 limit이 change 값보다 작으면 에러
	if ($change<=$thisLimits)
	{
	getLink('reload','parent.', '증원만 가능합니다.', '');
	}
	if($order == '1') $QVAL = "limits='".$change."'";
		elseif($order == '2') $QVAL = "limits2='".$change."'";
	getDbUpdate('rb_dalkkum_team',$QVAL,'uid='.$tid);
	getLink('reload','parent.', '완료되었습니다.', '');
}

?>