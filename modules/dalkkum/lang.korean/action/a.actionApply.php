<?php
if(!defined('__KIMS__')) exit;

// 세션 정보
$std_uid = getSqlFilter($_SESSION['stdinfo']['uid']);
$apply_group = getSqlFilter($_SESSION['stdinfo']['group']);
$apply_time = getSqlFilter($_POST['apply_time']);
$apply_team = getSqlFilter($_POST['apply_team']);
${"class_".$apply_time} = $apply_team;

// 그룹정보 가져오기
$_Group = getUidData('rb_dalkkum_group',$apply_group);

if($my['admin'] && $mode=='super_modify'){
	$std_uid = getSqlFilter($applier);
	$apply_group = getSqlFilter($group);
}

$_Team = getUidData('rb_dalkkum_team',$apply_team);
if(!$std_uid || !$apply_group) {
	echo urldecode(json_encode(array('code' => '0','nows' => $_Team['nows'],'msg' => '입력 된 정보에 문제가 있습니다.')));
	exit; 
}
function echo_error(){
	$_Team = getUidData('rb_dalkkum_team',$apply_team);
	echo urldecode(json_encode(array('code' => '1','nows' => $_Team['nows'],'msg' => '오류가 발생하였습니다.'))); exit;
}

// 지원시
if($act=='apply' && $std_uid && $apply_team) {

	// 학생 정보 조회
	$R = db_fetch_array(getDbSelect('rb_dalkkum_apply','group_seq='.$apply_group.' and able_seq='.$std_uid,'*'));

	// 수강신청기간 확인 !(1차기간 이거나 2차기간)
	if(!((($_Group['date_start']<=$date['totime']) && ($date['totime'] <= $_Group['date_end'])) ||
	(($_Group['use_second']=='Y') && ($_Group['date_start2']<=$date['totime']) && ($date['totime'] <= $_Group['date_end2'])))){
		echo urldecode(json_encode(array('code' => '3','nows' => $_Team['nows'],'msg' => '수강신청 기간이 아닙니다.'))); exit;
	}

	// 같은 직업이 지원되었었는지 조회
	$_myApplyJobs = array();
	for($si=1; $si<=10; $si++){
		$_sameTeam = getUidData('rb_dalkkum_team',$R['class_'.$si]);
		array_push($_myApplyJobs, $_sameTeam['job_seq']);
	}
	
	$_myApplyJobs = array_filter($_myApplyJobs);
	if(in_array($_Team['job_seq'], $_myApplyJobs)){ echo urldecode(json_encode(array('code' => '5','nows' => $_Team['nows'],'msg' => '이미 해당 직업군의 멘토 수업에 신청한 이력이 있습니다.'))); exit;
	}

	// 인원 제한 체크
	$_TTT = getUidData('rb_dalkkum_team',$apply_team);
	$_check_nows = getDbRows('rb_dalkkum_apply','group_seq='.$apply_group.' and class_'.$apply_time.'='.$apply_team);


	if(($_Group['use_second']=='Y') && ($_Group['date_start2']<=$date['totime']) && ($date['totime'] <= $_Group['date_end2'])) $_max_limits = $_TTT['limits'] + $_TTT['limits2'];
		else $_max_limits = $_TTT['limits']; 
		
	if($_check_nows >= $_max_limits) {
		echo urldecode(json_encode(array('code' => '2','nows' => $_Team['nows'],'msg' => '수강신청 인원이 초과하여 지원에 실패하였습니다.'))); exit;
	}

	if($R['uid']){ 
		if($R['class_'.$apply_time]) {echo urldecode(json_encode(array('code' => '6','msg' => '해당 교시에 이미 지원하였습니다.'))); exit;}
		else{
			$r1 = getDbUpdate('rb_dalkkum_team',"nows=nows+1",'uid='.$apply_team);	
			$r2 = getDbUpdate('rb_dalkkum_apply',"class_".$apply_time."='".$apply_team."'",'uid='.$R['uid']);
			$_Team = db_fetch_array(db_query("select T.*,J.name as jobName, M.name as mentorName from rb_dalkkum_team as T, rb_dalkkum_job as J, rb_s_mbrdata as M where T.job_seq=J.uid and T.mentor_seq = M.memberuid and T.uid=".$apply_team,$DB_CONNECT));
			// 현재 수 구하기
			$_check_nows = getDbRows('rb_dalkkum_apply','group_seq='.$apply_group.' and class_'.$apply_time.'='.$apply_team);

			$R = db_fetch_array(getDbSelect('rb_dalkkum_apply','group_seq='.$apply_group.' and able_seq='.$std_uid,'*'));
			$hasclass = 0; 
			for($hi=1; $hi <= 10; $hi++){
				if($R['class_'.$hi]) $hasclass++;
			}
			$r3 = getDbUpdate('rb_dalkkum_apply',"nows='".$hasclass."'",'uid='.$R['uid']);
			$r4 = getDbUpdate('rb_dalkkum_team',"lastmbr_seq='".$std_uid."'",'uid='.$apply_team);	

			echo urldecode(json_encode(array('code' => '100','hasClass'=>$hasclass,'class'=>$_Team['class_time'],'job'=>$_Team['jobName'],'mentor'=>$_Team['mentorName'],'nows' => $_check_nows,'msg' => '해당과목의 수강신청이 성공적으로 처리되었습니다.'))); exit;
		}
	}
	else{
		// 없으면 생성
		$_QKEY = "group_seq,able_seq,nows,class_1,class_2,class_3,class_4,class_5,class_6,class_7,class_8,class_9,class_10";
		$_QVAL = "'$apply_group','$std_uid','1','$class_1','$class_2','$class_3','$class_4','$class_5','$class_6','$class_7','$class_8','$class_9','$class_10'";

		$r1 = getDbUpdate('rb_dalkkum_team',"nows=nows+1",'uid='.$apply_team);
		$r2 = getDbInsert('rb_dalkkum_apply',$_QKEY,$_QVAL);	
		$_Team = db_fetch_array(db_query("select T.*,J.name as jobName, M.name as mentorName from rb_dalkkum_team as T, rb_dalkkum_job as J, rb_s_mbrdata as M where T.job_seq=J.uid and T.mentor_seq = M.memberuid and T.uid=".$apply_team,$DB_CONNECT));
		$R = db_fetch_array(getDbSelect('rb_dalkkum_apply','group_seq='.$apply_group.' and able_seq='.$std_uid,'*'));
		$r4 = getDbUpdate('rb_dalkkum_team',"lastmbr_seq='".$std_uid."'",'uid='.$apply_team);	

		// 현재 수 구하기
		$_check_nows = getDbRows('rb_dalkkum_apply','group_seq='.$apply_group.' and class_'.$apply_time.'='.$apply_team);

		// 내보내기
		$hasclass = 0;
		for($hi=1; $hi <= 10; $hi++){
			if($R['class_'.$hi]) $hasclass++;
		}
			echo urldecode(json_encode(array('code' => '100','hasClass'=>$hasclass,'class'=>$_Team['class_time'],'job'=>$_Team['jobName'],'mentor'=>$_Team['mentorName'],'nows' => $_check_nows,'msg' => '해당과목의 수강신청이 성공적으로 처리되었습니다.'))); exit; 
	}
}

// 취소시
else if($act=='cancel' && $std_uid && $apply_team) {
	$_Team = getUidData('rb_dalkkum_team',$apply_team);

	// 수강신청기간 확인 !(1차기간 이거나 2차기간)
	if(!((($_Group['date_start']<=$date['totime']) && ($date['totime'] <= $_Group['date_end'])) ||
	(($_Group['use_second']=='Y') && ($_Group['date_start2']<=$date['totime']) && ($date['totime'] <= $_Group['date_end2'])))){
		echo urldecode(json_encode(array('code' => '3','nows' => $_Team['nows'],'msg' => '수강신청 기간이 아닙니다.'))); exit;
	}


	// 학생 정보 조회
	$r1 = getDbUpdate('rb_dalkkum_apply',"class_".$apply_time."='0'",'group_seq='.$apply_group.' and able_seq='.$std_uid);
	$r2 = getDbUpdate('rb_dalkkum_team',"nows=nows-1",'uid='.$apply_team);	
	
	$R = db_fetch_array(getDbSelect('rb_dalkkum_apply','group_seq='.$apply_group.' and able_seq='.$std_uid,'*'));
	$hasclass = 0;
	for($hi=1; $hi <= 10; $hi++){
		if($R['class_'.$hi]) $hasclass++;
	}
	$r3 = getDbUpdate('rb_dalkkum_apply',"nows='".$hasclass."'",'uid='.$R['uid']);
		echo urldecode(json_encode(array('code' => '100','hasClass'=>$hasclass,'nows' => $_Team['nows'],'msg' => '해당과목의 수강신청이 취소되었습니다.'))); exit;
}

// 수정시
else if($act=='modify' && $std_uid && $apply_time && $apply_group && $apply_team) {

	$_Team = getUidData('rb_dalkkum_team',$apply_team);

	// 학생 정보 조회
	$R = db_fetch_array(getDbSelect('rb_dalkkum_apply','group_seq='.$apply_group.' and able_seq='.$std_uid,'*'));

	// 같은 직업이 지원되었었는지 조회
	$_myApplyJobs = array();
	for($si=1; $si<=10; $si++){
		$_sameTeam = getUidData('rb_dalkkum_team',$R['class_'.$si]);
		array_push($_myApplyJobs, $_sameTeam['job_seq']);
	}
	$_Team = getUidData('rb_dalkkum_team',$apply_team);
	$_myApplyJobs = array_filter($_myApplyJobs);
	if(in_array($_Team['job_seq'], $_myApplyJobs)){ echo urldecode(json_encode(array('code' => '5','msg' => '이미 해당 직업군의 멘토 수업에 신청한 이력이 있습니다.'))); exit;
	}


	// 인원 교체 
	$_sql = array('');
	$_sql[0] = "update rb_dalkkum_team set nows=nows-1 where uid=".$R['class_'.$apply_time];
	$r1 = db_query($_sql[0], $DB_CONNECT);
	$_sql[1] = "update rb_dalkkum_team set nows=nows+1 where uid=".$apply_team;
	$r2 = db_query($_sql[1], $DB_CONNECT);
	// 팀정보 변경
	$_sql[2] = "update rb_dalkkum_apply set class_".$apply_time."='".$apply_team."' where uid=".$R['uid'];
	$r3 = db_query($_sql[2], $DB_CONNECT);
	if($r1 && $r2 && $r3) {echo urldecode(json_encode(array('code' => '100','msg' => '해당 교시의 수강과목 변경이 완료 되었습니다.'))); exit; }
	else echo_error();
}

		
exit;
?>