<?php
if(!defined('__KIMS__') || !$my['memberuid']) exit;
if($act=='cancel_mentorApply'){
	$M = getDbData('rb_s_mbrdata','memberuid='.$my['memberuid'],'*');
	if($M['mentor_apply'] && ($M['mentor_confirm'] != 'Y')){
		getDbUpdate('rb_s_mbrdata','mentor_apply=NULL','memberuid='.$my['memberuid']);
		getLink('reload','parent.','신청이 취소되었습니다.','');
	}
}elseif($act=='ivideo_delete' && $key){
		$delete_video = file_get_contents('http://uccapi.smartucc.kr/uccapi/Contents/deleteMedia/ucc_key/d43327898fa8d0c89514ec738e583bef/file_key/'.$key);
		$acting = db_query("UPDATE rb_dalkkum_mentor SET file_key_W=NULL, file_key_I=NULL, file_key_A=NULL, file_key_M=NULL, media_key=NULL WHERE  uid=".$my['memberuid'].";",$DB_CONNECT);
		getLink('reload','parent.','삭제되었습니다.','');
}elseif($act=='ivideo_success'){
	$_tmpnum = getDbRows('rb_dalkkum_mentor','uid='.$my['memberuid']);
	if($_tmpnum>0){
		$acting = db_query("UPDATE rb_dalkkum_mentor SET file_key_W='".$_POST['file_key_W']."', file_key_I='".$_POST['file_key_I']."', file_key_A='".$_POST['file_key_A']."', file_key_M='".$_POST['file_key_M']."', media_key='".$_POST['origin_file_key']."' WHERE  uid=".$my['memberuid'].";",$DB_CONNECT);

	}else{
		$acting = db_query("INSERT INTO rb_dalkkum_mentor (uid, file_key_W, file_key_I, file_key_A, file_key_M, media_key) VALUES (".$my['memberuid'].", '".$_POST['file_key_W']."', '".$_POST['file_key_I']."', '".$_POST['file_key_A']."', '".$_POST['file_key_M']."', '".$_POST['origin_file_key']."');",$DB_CONNECT);
	}
	if($acting) {
		echo "<script>
			parent.vodUploading = false;
			alert('업로드가 완료되었습니다!'); 
			parent.document.location.reload();
		</script>";	
	}
	//동영상 삭제
	if ($_POST['before_key'])
	{
		$delete_video = file_get_contents('http://uccapi.smartucc.kr/uccapi/Contents/deleteMedia/ucc_key/d43327898fa8d0c89514ec738e583bef/file_key/'.$_POST['before_key']);
	}
	exit;

}
elseif($act=='ivideo_fail'){
	echo "<script>
		parent.vodUploading = false;
		alert('동영상 업로드에 실패했습니다. 파일 용량을 확인해주세요.');
	</script>";
	exit;
}
// 멘토 My page 질문목록
elseif($act=='myroom' && $bbsids && isset($indexs) && $limits){
	$data_result = array();
	if($bbsids == 'qna'){
		$RCD = db_query("select D.uid,D.bbsid,D.subject,D.name,D.mbruid,J.name as jobName,M.name as mentorName,M.memberuid as mentorUID from rb_bbs_data as D, rb_dalkkum_job as J, rb_s_mbrdata as M where (D.gid-floor(D.gid))=0 and  D.mentor_seq=M.memberuid and M.mentor_job=J.uid and bbsid='qna' and mentor_seq='".$my['memberuid']."' and parentmbr='0' order by D.uid desc limit ".$indexs.",".$limits,$DB_CONNECT);
	}elseif($bbsids == 'kin'){
		$RCD = db_query("select D.uid,D.bbsid,D.subject,D.name,D.mbruid,J.name as jobName, M.name as mentorName, J.uid as jobUID 
from rb_bbs_data as D, rb_dalkkum_job as J, rb_s_mbrdata as M where (D.gid-floor(D.gid))=0 and  D.job_seq=M.mentor_job and M.mentor_job=J.uid and bbsid='kin' and parentmbr='0' and M.memberuid='".$my['memberuid']."' order by D.uid desc limit ".$indexs.",".$limits,$DB_CONNECT);
	}
	while ($R = db_fetch_array($RCD)) {
		if($bbsids == 'kin') $R['subject'] = getStrCut2($R['subject'],'22','');
			else $R['subject'] = getStrCut2($R['subject'],'22','');
		$R['regis_dates'] = getDateFormat($R['d_regis'],'Y.m.d H:i');
		$R['status'] = $R['is_reply']?'답변완료':'답변대기';
		array_push($data_result, $R);
	}
	echo json_encode($data_result);
	exit;
// 일반회원 My page 질문목록
}elseif($act=='myqna' && $bbsids && isset($indexs) && $limits){
	$data_result = array();
	if($bbsids == 'qna'){
		$RCD = db_query("select D.*,M.name as mentorName,M.memberuid as mentorUID from rb_bbs_data as D, rb_s_mbrdata as M where (D.gid-floor(D.gid))=0 and  D.mbruid=M.memberuid and D.mbruid='".$my['memberuid']."' and bbsid='qna' and parentmbr='0' order by D.uid desc limit ".$indexs.",".$limits,$DB_CONNECT);
	}elseif($bbsids == 'kin'){
		$RCD = db_query("select D.*,J.name as jobName, M.name as mentorName, J.uid as jobUID 
from rb_bbs_data as D, rb_dalkkum_job as J, rb_s_mbrdata as M where (D.gid-floor(D.gid))=0 and  D.mbruid=M.memberuid and D.job_seq=J.uid and bbsid='kin' and parentmbr='0' and M.memberuid='".$my['memberuid']."' order by D.uid desc limit ".$indexs.",".$limits,$DB_CONNECT);
	}
	while ($R = db_fetch_array($RCD)) {
		if($bbsids == 'kin') $R['subject'] = getStrCut2('['.$R['jobName'].'] '.$R['subject'],'22','');
			else $R['subject'] = getStrCut2($R['subject'],'22','');
		$R['regis_dates'] = getDateFormat($R['d_regis'],'Y.m.d H:i');
		$R['status'] = $R['is_reply']?'답변완료':'답변대기';
		$R['mentorName'] = getName($R['mentor_seq']);
		array_push($data_result, $R);
	}
	echo json_encode($data_result);
	exit;
}
exit;
?>