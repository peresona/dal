<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);


if($act=='all_delete') {
	// 가능 인원에서 제거
	getDbDelete('rb_dalkkum_applyable','group_seq='.$group);
	// 수강 신청했던 것들 삭제
	getDbDelete('rb_dalkkum_apply','group_seq='.$group);
	// 이 그룹 과목 전부 현재 지원자수 0명으로 변경
	getDbUpdate('rb_dalkkum_team','nows=0','group_seq='.$group);
	echo "전체 삭제 되었습니다."; exit;
}

if ($uid)
{
	$R = getUidData('rb_dalkkum_applyable',$uid);
}
else exit;

if($act=='modify') {
	$QVAL = "sc_grade='".$grade."',sc_class='".$class."',sc_num='".$num."'";
	$QVAL .= ",name='".$name."',tel='".$tel."'";
	getDbUpdate('rb_dalkkum_applyable',$QVAL,'uid='.$uid);
	echo "수정이 완료되었습니다."; exit;
}
if($act=='delete') {
	// 수강신청 내역을 가져와서 해당 과목들 지원 인원 삭제전 -1 해주기
	$apply_info = getDbData('rb_dalkkum_apply','able_seq='.$uid,'*');
	for($i=1; $i <= $apply_info['nows']; $i++){
		getDbUpdate('rb_dalkkum_team','nows=nows-1','uid='.$apply_info['class_'.$i]);
	}
	// 가능 인원에서 제거
	getDbDelete('rb_dalkkum_applyable','uid='.$uid);
	// 수강 신청했던 것들 삭제
	getDbDelete('rb_dalkkum_apply','group_seq='.$group.' and able_seq='.$uid);
	echo "삭제 되었습니다."; exit;
}

echo "에러가 발생하였습니다.";
exit;
?>