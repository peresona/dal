<?php
if(!defined('__KIMS__')) exit;

if ($uid)
{
	$R = getUidData('rb_dalkkum_group',$uid);
}
switch ($act) {
	// 멘토 모집에서 명단 삭제
	case 'delete_request':
		if($group && $uid){
			getDbDelete('rb_dalkkum_request','uid='.$uid.' and group_seq='.$group);
			getLink('reload','parent.','정상적으로 취소 및 삭제되었습니다.','');
		}else getLink('','','에러가 발생하였습니다.','');
	break;
	// 팀 점수 저장
	case 'saveScore':
		$admins = explode(',', $R['admins']);
		if($uid && isset($score1) && isset($score2) && isset($score3) && isset($score4) && ($my['admin']=='1' || in_array($my['memberuid'], $admins))){
			// score 테이블에 행이 없으면 추가 있으면 수정
			$Written = getDbData('rb_dalkkum_score',"group_seq=".$group." and mentor_seq=".$uid,"*");
			if($Written['uid']){
				$a = db_query("UPDATE rb_dalkkum_score SET score1=".$score1.",score2=".$score2.",score3=".$score3.",score4=".$score4." WHERE group_seq=".$group." and mentor_seq=".$uid,$DB_CONNECT);
			}else{
				$GD = getUidData('rb_dalkkum_group',$group);
				$a = db_query("INSERT INTO rb_dalkkum_score (mentor_seq, group_seq, sc_seq, job_seq, score1, score2, score3, score4)
				 VALUES (".$uid.", ".$group.", ".$GD['sc_seq'].", 0, ".$score1.", ".$score2.", ".$score3.", ".$score4.");",$DB_CONNECT);
			}

			if($a){
				$_code = "100";
				$_msg = "점수를 반영하였습니다.";
			} else{ 
				$_code = "1";
				$_msg = "점수를 모두 선택해주세요. "; 
			}
			echo json_encode(array('code' => $_code, 'msg' => $_msg));
		} else echo json_encode(array('code' => '0', 'msg' => '점수를 모두 선택해주세요.')); 
		exit;
	break;

	// 팀 점수 리셋
	case 'resetScore':
		if($uid && $group && ($my['admin']=='1' || in_array($my['memberuid'], $admins))){
			$a = db_query("UPDATE rb_dalkkum_score SET score1=NULL,score2=NULL,score3=NULL,score4=NULL WHERE group_seq=".$group." and mentor_seq=".$uid,$DB_CONNECT);
			if($a){
				$_code = "100";
				$_msg = "점수를 초기화하였습니다.";
			} else{ 
				$_code = "1";
				$_msg = "에러가 발생하였습니다."; 
			}
			echo json_encode(array('code' => $_code, 'msg' => $_msg)); 
		} else{
			echo json_encode(array('code' => '0', 'msg' => '에러가 발생하였습니다.'));
		} 
		exit;
	break;
	case 'request_agree':
		// 받는 값 $uid
		if(getDbRows('rb_dalkkum_request','mentor_seq='.$my['memberuid'].' and group_seq='.$R['uid'].' and (agree="M" or agree="Y" or agree="N")')>0){
			$code = "1";
			$msg = "이미 요청에 답하셨습니다."; 
		}
		if(getDbRows('rb_dalkkum_request','mentor_seq='.$my['memberuid'].' and group_seq='.$R['uid'].' and agreeable="N"')>0){
			$code = "2";
			$msg = "현재 해당 수업에 동의 하실 수 없는 상태입니다."; 
		}
		if(getDbRows('rb_dalkkum_request','job_seq='.$my['mentor_job'].' and group_seq='.$R['uid'].' and agree="Y"')>0){
			$code = "3";
			$msg = "해당 그룹에 같은 직업이 이미 모집 완료되었습니다."; 
			getDbUpdate('rb_dalkkum_request','agree="M",agreeable="N"','mentor_seq='.$my['memberuid'].' and group_seq='.$R['uid']);
		}

		if($mode == 'agree'){
			getDbUpdate('rb_dalkkum_request',"agree='Y',agreeable='N'",'mentor_seq='.$my['memberuid'].' and group_seq='.$R['uid'].' and agreeable="Y"');
			$code = "100";
			$msg = "해당 수업을 동의를 정상적으로 처리하였습니다.";
		} else if($mode == 'reject'){
			getDbUpdate('rb_dalkkum_request',"agree='N',agreeable='N'",'mentor_seq='.$my['memberuid'].' and group_seq='.$R['uid'].' and agreeable="Y"');
			$code = "100";
			$msg = "해당 수업을 거절을 정상적으로 처리하였습니다.";
		}
		else { $msg = "에러가 발생했습니다.";
			$code = "100"; }
			echo json_encode(array('code' => $code, 'msg' => $msg)); 
			exit;
		break;
	// case 'request_agree':
	// 	// 받는 값 $uid
	// 	if(getDbRows('rb_dalkkum_request','mentor_seq='.$my['memberuid'].' and group_seq='.$R['uid'].' and (agree="M" or agree="Y" or agree="N")')>0){
	// 		$alert = "이미 요청에 답하셨습니다."; 
	// 		getLink('/mypage/?page=request','parent.', $alert , ''); 
	// 	}
	// 	if(getDbRows('rb_dalkkum_request','mentor_seq='.$my['memberuid'].' and group_seq='.$R['uid'].' and agreeable="N"')>0){
	// 		$alert = "현재 해당 수업에 동의 하실 수 없는 상태입니다."; 
	// 		getLink('/mypage/?page=request','parent.', $alert , ''); 
	// 	}
	// 	if(getDbRows('rb_dalkkum_request','job_seq='.$my['mentor_job'].' and group_seq='.$R['uid'].' and agree="Y"')>0){
	// 		$alert = "해당 그룹에 같은 직업이 이미 모집 완료되었습니다."; 
	// 		getDbUpdate('rb_dalkkum_request','agree="M",agreeable="N"','mentor_seq='.$my['memberuid'].' and group_seq='.$R['uid']);
	// 		getLink('/mypage/?page=request','parent.', $alert , ''); 
	// 	}

	// 	if($mode == 'agree'){
	// 		getDbUpdate('rb_dalkkum_request',"agree='Y',agreeable='N'",'mentor_seq='.$my['memberuid'].' and group_seq='.$R['uid'].' and agreeable="Y"');
	// 		echo "agree='Y',agreeable='N'",'mentor_seq='.$my['memberuid'].' and group_seq='.$R['uid'].' and agreeable="Y"';
	// 		$alert = "해당 수업을 동의를 정상적으로 처리하였습니다.";
	// 		getLink('reload','parent.', $alert , ''); 
	// 	} else if($mode == 'reject'){
	// 		getDbUpdate('rb_dalkkum_request',"agree='N',agreeable='N'",'mentor_seq='.$my['memberuid'].' and group_seq='.$R['uid'].' and agreeable="Y"');
	// 		echo "agree='Y',agreeable='N'",'mentor_seq='.$my['memberuid'].' and group_seq='.$R['uid'].' and agreeable="Y"';
	// 		$alert = "해당 수업을 거절을 정상적으로 처리하였습니다.";
	// 		getLink('reload','parent.', $alert , ''); 
	// 	}
	// 	else $alert = "에러가 발생했습니다.";
	// 		getLink('','', $alert , ''); 
	// 	break;

}

checkAdmin(0);


switch ($act) {
	case 'start':
		$QVAL= "apply_start='Y'";
		getDbUpdate('rb_dalkkum_group',$QVAL,'uid='.$uid);
		$alert = "수강신청이 정상적으로 시작되었습니다.";
		break;
	
	case 'finish':
		$QVAL= "finish='Y'";
		getDbUpdate('rb_dalkkum_group',$QVAL,'uid='.$uid);
		$alert = "수강신청이 정상적으로 종료되었습니다.";
		getLink('/?r=home&m=admin&module=dalkkum&front=group_finish&uid='.$uid,'parent.', $alert , $history);
	
	case 'delete':
		if($R['img']) unlink($g['path_root'].'files/_etc/group/'.$R['img']);
		getDbDelete('rb_dalkkum_group','uid='.$uid);
		$alert = "수강신청이 정상적으로 삭제되었습니다.";
		break;

	case 'reset':
		$QVAL= "nows='0'";
		getDbUpdate('rb_dalkkum_team',$QVAL,'group_seq='.$uid);
		$QVAL= "apply_start='N'";
		getDbUpdate('rb_dalkkum_group',$QVAL,'uid='.$uid);
		getDbDelete('rb_dalkkum_apply','group_seq='.$uid);
		$alert = "수강신청 지원자가 정상적으로 초기화 되었습니다.";
		break;
/*
	case 'request':
		$GD = getUidData('rb_dalkkum_group',$group);
		// 시간 정리
		$_starttemp = array();
		$_endtemp = array();
		for($i=0; $i < sizeof($date_start_1); $i++){
			array_push($_starttemp, $date_start_1[$i].$date_start_2[$i].$date_start_3[$i].$date_start_4[$i].$date_start_5[$i]);
			array_push($_endtemp, $date_end_1[$i].$date_end_2[$i].$date_end_3[$i].$date_end_4[$i].$date_end_5[$i]);
		}
		$_starttemp = array_filter($_starttemp);
		$_endtemp = array_filter($_endtemp);

		for ($i=0; $i < sizeof($_starttemp) ; $i++) { 
			//$money[$i] = $money[$i]?$money[$i]:'0';
			if(getDbRows('rb_dalkkum_request','group_seq='.$group.' and mentor_seq='.$mentorNo[$i])){
				$QVAL= "group_seq='$group',mentor_seq='$mentorNo[$i]',date_start='$_starttemp[$i]',date_end='$_endtemp[$i]',memo='$memo[$i]',d_regis='$date[totime]'";
					getDbUpdate('rb_dalkkum_request',$QVAL,'group_seq='.$group.' and mentor_seq="'.$mentorNo[$i].'"');
					print_r($QVAL);echo "<br>";
			}
				else{
					$QKEY = "group_seq,mentor_seq,date_start,date_end,memo,d_regis";
					$QVAL = "'$group','$mentorNo[$i]','$_starttemp[$i]','$_endtemp[$i]','$memo[$i]','$date[totime]'";
					getDbInsert('rb_dalkkum_request',$QKEY,$QVAL);			
					print_r($QVAL);echo "<br>";
				}

		}
		getLink('/?r=home&iframe=Y&m=dalkkum&front=manager&page=mentor_requestList&group='.$group,'parent.', "명에게 수업 요청이 전송되었습니다.",'');
		break;
*/
	case 'request_many':
		// 시간 정리
		$price_list = getUidData('rb_dalkkum_program',$program); // 프로그램 가격표
		$GD = getUidData('rb_dalkkum_group',$group);
		$temp['group'] = $group;
		$temp['memo'] = $memo;/*
		$temp['date_start'] = sprintf('%04d%02d%02d%02d%02d',$class_year,$class_month,$class_day,$class_start_hour,$class_start_min);
		$temp['date_end'] = sprintf('%04d%02d%02d%02d%02d',$class_year,$class_month,$class_day,$class_end_hour,$class_end_min);*/
		$tmp_i = 0;
		foreach ($regis as $value) {
			global $temp;
			global $tmp_i;
			$_tmp = explode('-',$value);
			$_query = "INSERT INTO rb_dalkkum_request (group_seq, mentor_seq, job_seq, date_start, date_end, memo, d_regis) 
			VALUES (".$temp['group'].", ".$_tmp[0].",".$_tmp[2].", '".$GD['class_date']."', '".$GD['class_date']."', '".$temp['memo']."', '".$date['totime']."');";
			//echo $_query; exit;
			$a = db_query($_query,$DB_CONNECT);
			if($a) $tmp_i++; 
		}
		// 한 명 이상 추가되었다면 푸쉬를 마감이 아닌 정지 상태로 변경
		if($tmp_i>0) db_query("UPDATE rb_dalkkum_group SET push_now='N' WHERE uid=".$group,$DB_CONNECT);
		getLink('/?r=home&iframe=Y&m=dalkkum&front=manager&page=mentor_requestList&group='.$group,'parent.', $tmp_i."명에게 수업 요청이 전송되었습니다.".$MBRD['memberuid'], '');
		break;

		
	case 'editMaxMentor':
		$_isMax = getDbData('rb_dalkkum_group',"uid=".$group,'recruit');
		if($_isMax['recruit'] < $max_mentor){
			$a = db_query("UPDATE rb_dalkkum_group SET recruit=".$max_mentor." WHERE  uid=".$group,$DB_CONNECT);
			if($a) {
				db_query("UPDATE rb_dalkkum_group SET push_now='N' WHERE push_now='M' and uid=".$group,$DB_CONNECT);
				db_query("UPDATE rb_dalkkum_request SET agree='D', agreeable='Y' WHERE agree='M' and group_seq=".$group,$DB_CONNECT);
				getLink('reload','parent.', '수정되었습니다.', '');
			} else getLink('','', '오류가 발생하였습니다.', '');
		}
		else getLink('','', '기존 인원보다 크게만 설정 가능합니다.', '');
		break;
		
	case 'push_status':
		if($mode=='play'){
			db_query("UPDATE rb_dalkkum_group SET push_now='Y' WHERE push_now='N' and uid=".$group,$DB_CONNECT);
			getLink('reload','parent.', '자동 푸쉬가 시작되었습니다.', '');
		} 
		else if($mode=='stop'){
			db_query("UPDATE rb_dalkkum_group SET push_now='N' WHERE uid=".$group,$DB_CONNECT);
			getLink('reload','parent.', '자동 푸쉬가 정지되었습니다.', '');
		} 
	break;

	case 'reset_applyevent':
		if($group){
			db_query("UPDATE rb_dalkkum_eventapply SET group_seq=NULL WHERE group_seq=".$group,$DB_CONNECT);
			db_query("UPDATE rb_dalkkum_group SET apply_seq=NULL WHERE uid=".$group,$DB_CONNECT);
			getLink('reload','parent.', '연동을 해제하였습니다.', '');
		} else{
			getLink('','', '그룹 정보가 없어 실패하였습니다.', '');
		}
	break;



	// 팀 정산 취소
	case 'exactCancel':
		if($uid && $group){
			$a = db_query("UPDATE rb_dalkkum_score SET exact_cash=NULL WHERE group_seq=".$group." and mentor_seq=".$uid,$DB_CONNECT);
			if($a) getLink('reload','parent.', '정산금액을 취소 후 초기화하였습니다.', '');
				else getLink('','', '에러가 발생하였습니다.', '');
		} else{
			getLink('','', '에러가 발생하였습니다.', '');
		}
	break;

	// 정산
	case 'exactCash':
		if($uid && $group){

			$Written = getDbData('rb_dalkkum_score',"group_seq=".$group." and mentor_seq=".$uid,"*");
			if($Written['uid'] && isset($Written['score1']) && isset($Written['score2']) && isset($Written['score3']) && isset($Written['score4'])){
				// 정보가져오기
				$GD = getUidData('rb_dalkkum_group',$group);
				$MD = getDbData('rb_s_mbrdata','memberuid='.$uid,'*');
				$price_list = getUidData('rb_dalkkum_program',$GD['program_seq']);
				$gradeName = array('','E','D','C','B','A');
				$a = db_query("UPDATE rb_dalkkum_score SET exact_cash=(".$price_list['price'.$gradeName[$MD['mentor_grade']]].")*(score4/100) WHERE group_seq=".$group." and mentor_seq=".$uid,$DB_CONNECT);
				if($a) getLink('reload','parent.', '정산 처리 하였습니다.', ''); else getLink('','', '정산 처리중 오류가 발생하였습니다.', '');
			}else{
				getLink('','', '정산을 하기위해서는 점수를 필수로 입력하셔야합니다.', '');
			}
		} else{
			getLink('','', '요소가 부족합니다.', '');
		}
	break;
	
	// 관리자 추가
	case 'addAdmin':
		if($uid){
			$admins = explode(',', $R['admins']);
			$admins = array_filter(array_merge($admins, $selects));
			$admins = implode(',', $admins);
			getDbUpdate('rb_dalkkum_group',"admins='".$admins."'",'uid='.$R['uid']);
			echo "<script>alert('정상적으로 처리되었습니다.'); parent.opener.location.reload(); parent.close();</script>"; exit;
		} else{
			getLink('','', '에러가 발생하였습니다.', '');
		}
	break;
	// 관리자 해제
	case 'delAdmin':
		if($uid && $adminuid){
			$admins = explode(',', $R['admins']);
			foreach ($admins as $key => &$value) {
				if($value == $adminuid){
					unset($admins[$key]);
				}
			}
			$admins = array_filter($admins);
			$admins = implode(',', $admins);
			getDbUpdate('rb_dalkkum_group',"admins='".$admins."'",'uid='.$R['uid']);
			getLink('reload','parent.', '정상적으로 처리되었습니다.', '');
		} else{
			getLink('','', '에러가 발생하였습니다.', '');
		}
	break;

	default:
		$alert = "에러가 발생했습니다.";
		break;
}
getLink('reload','parent.', $alert , $history);
?>