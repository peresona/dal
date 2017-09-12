<?php
if(!defined('__KIMS__')) exit;

$sql = getDbSelect('rb_dalkkum_team','','*');
while ($R = db_fetch_array($sql)) {
	$tmp_num = getDbRows('rb_dalkkum_apply','class_'.$R['class_time'].'='.$R['uid']);
	echo $R['uid'].'/'.$R['class_time'].'/'.$tmp_num.'<br>';
	getDbUpdate('rb_dalkkum_team','nows='.$tmp_num,'uid='.$R['uid']);
}
getLink('','','수강신청 인원과 현재 신청 인원이 동기화되었습니다.','');
exit;
?>