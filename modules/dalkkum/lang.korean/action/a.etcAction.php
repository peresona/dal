<?php
if(!defined('__KIMS__')) exit;

// 강의요청 알림창 확인처리
if($act == 'check_msg' && $msgid){
	if($my['memberuid']) getDbUpdate('rb_dalkkum_request','is_check="Y"','mentor_seq='.$my['memberuid'].' and uid='.$msgid);
	getLink('/mypage/?page=request','parent.','','');
}
// 직업블로그 멘토 해제
elseif($act == 'reset_jblog_mentor' && $job_seq){
	checkAdmin(0);
	getDbUpdate('rb_dalkkum_job','best=NULL','uid='.$job_seq);
	getLink('reload','parent.','정상적으로 처리되었습니다.','');
}

// 직업블로그 멘토 지정
elseif($act == 'regis_jblog_mentor' && $job_seq){
	checkAdmin(0);
	$_tmptext = "";
	if(count($mentor_check) > 0 && count($mentor_check) <= 5){
		for($i=0; $i<count($mentor_check); $i++){
			$_tmptext .= $mentor_check[$i].',';
		}
		getDbUpdate('rb_dalkkum_job','best="'.substr($_tmptext, 0, -1).'"','uid='.$job_seq);
		getLink('reload','parent.','설정이 완료되었습니다.','');
	}else{
		getLink('','parent.','출력할 멘토는 5개까지만 지원가능합니다.','');
	}
	exit;
}
elseif($act == 'libin' && $option && $guid){
	// 결과 배열 초기화
	$result = array('code'=>'0');
	// 로그인 검사
	if(!$my['memberuid']){
		echo urldecode(json_encode(array('code' => '0', 'result' => '', 'msg' => '로그인이 필요합니다.'))); exit;
	}
	if($option == 'job_in'){
		getDbInsert('rb_dalkkum_myjob','my_mbruid,job_seq,d_regis',"'{$my['memberuid']}','{$guid}','{$date[totime]}'");
		$result['code'] = 101;
		$_tmp = getDbRows('rb_dalkkum_myjob','job_seq='.$guid);
		getDbUpdate('rb_dalkkum_job','follower='.$_tmp,'uid='.$guid);
	}elseif ($option == 'job_out') {
		getDbDelete('rb_dalkkum_myjob','my_mbruid='.$my['memberuid'].' and job_seq='.$guid);
		$result['code'] = 102;
		$_tmp = getDbRows('rb_dalkkum_myjob','job_seq='.$guid);
		getDbUpdate('rb_dalkkum_job','follower='.$_tmp,'uid='.$guid);
	}elseif ($option == 'mentor_in') {
		getDbInsert($table['s_friend'],'rel,my_mbruid,by_mbruid,category,d_regis',"'1','".$my['uid']."','".$guid."','','".$date['totime']."'");
		getDbUpdate($table['s_friend'],'rel=1','uid='.$R['uid']);
		$_tmp = getDbRows('rb_s_friend','by_mbruid='.$guid);
		getDbUpdate('rb_s_mbrdata','follower='.$_tmp,'memberuid='.$guid);
		$result['code'] = 101;
	}elseif ($option == 'mentor_out') {
		getDbDelete($table['s_friend'],'by_mbruid='.$guid.' and my_mbruid='.$my['uid']);
		$_tmp = getDbRows('rb_s_friend','by_mbruid='.$guid);
		getDbUpdate('rb_s_mbrdata','follower='.$_tmp,'memberuid='.$guid);
		$result['code'] = 102;
	}
	echo urldecode(json_encode(array('code' => $result['code'], 'msg' => $result['msg']))); exit;

}
elseif($act == 'del_video' && $file_key_W && $andfuc){
		$file_key_W = str_replace('*', '', $file_key_W);
		$delete_video = file_get_contents('http://uccapi.smartucc.kr/uccapi/Contents/deleteMedia/ucc_key/d43327898fa8d0c89514ec738e583bef/file_key/'.$file_key_W);

	echo "<script>parent.".$andfuc."();</script>";
	exit;
}

getLink('','','에러가 발생하였습니다.','');

?>