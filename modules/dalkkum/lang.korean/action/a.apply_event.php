<?php
	if(!defined('__KIMS__')) exit;
	if($act == 'apply'){
		$tel = $a_tel1.'-'.$a_tel2.'-'.$a_tel3;
		$start_date = $a_startdate1.$a_startdate2.$a_startdate3;
		$end_date = $a_enddate1.$a_enddate2.$a_enddate3;

		$_temp = "";
		for($i=1; $i <= $many_times; $i++){
			$_temp .= ${'a_times'.$i.'_1'}.${'a_times'.$i.'_2'}.${'a_times'.$i.'_3'}.${'a_times'.$i.'_4'}."|";
		}
		$times = substr($_temp , 0, -1);

		$eventdate1 = str_replace('-', '', $eventstart1.'|'.$eventstart2.'|'.$eventstart3.'|'.$eventstart4.'|'.$eventstart5.'|'.$eventstart6.'|'.$eventstart7);
		$eventdate2 = str_replace('-', '', $eventend1.'|'.$eventend2.'|'.$eventend3.'|'.$eventend4.'|'.$eventend5.'|'.$eventend6.'|'.$eventend7);
		$eventnow = $eventnow1.'|'.$eventnow2.'|'.$eventnow3.'|'.$eventnow4.'|'.$eventnow5.'|'.$eventnow6.'|'.$eventnow7;

		if($uid){
			// 자기 글인지 체크
			$EAD= getUidData('rb_dalkkum_eventapply',$uid);
				if($my['admin']!='1' && ($EAD['member_seq'] != $uid)){
					getLink('','','본인 신청 내용만 수정 가능합니다.','');
				}
				// 서류 확인중 이후에는 수정이 불가능함
				$EAD= getUidData('rb_dalkkum_eventapply',$uid);
				if($my['admin']!='1' && ($EAD['step'] > 0)){
					getLink('','','달꿈 운영팀에서 서류를 확인 이후 정보수정은 전화로만 가능합니다.','');
				}
				// uid가 있을때는 수정
				$QVAL = "name='$a_name',step='$step',a_group='$a_group',tel='$tel',email='$a_email',address='$a_address',address_detail='$a_address_detail',eventdate1='$eventdate1',eventdate2='$eventdate2',eventnow='$eventnow',a_lat='$a_lat',a_long='$a_long',program='$a_program',event_num='$a_event_num',mentor_num='$a_mentor_num',mentor_jobs='$a_mentor_jobs',start_date='$start_date',end_date='$end_date',many_times='$many_times',times='$times',money='$a_money',std_num='$a_stdNum',class_num='$a_classNum',grade='$a_target',a_change='$a_change',grade_sum='$a_grade_sum',rental_pc='$a_rental',memo='$a_memo',modify_regis='$date[totime]'";
				//print_r($QVAL); exit;
				getDbUpdate('rb_dalkkum_eventapply',$QVAL,'uid='.$uid);
				if($ver == 'manager') getLink('reload','top.opener.','정상적으로 수정 되었습니다.','');
			else getLink('','','정상적으로 수정 되었습니다.','');
		}else{
			$QKEY = "member_seq,name,a_group,tel,email,address,address_detail,a_lat,a_long,program,event_num,mentor_num,mentor_jobs,start_date,end_date,many_times,times,money,std_num,class_num,grade,a_change,grade_sum,rental_pc,memo,d_regis,eventdate1,eventdate2,eventnow";
			$QVAL = "'$my[memberuid]','$a_name','$a_group','$tel','$a_email','$a_address','$a_address_detail','$a_lat','$a_long','$a_program','$a_event_num','$a_mentor_num','$a_mentor_jobs','$start_date','$end_date','$many_times','$times','$a_money','$a_stdNum','$a_classNum','$a_target','$a_change','$a_grade_sum','$a_rental','$a_memo','$date[totime]','$eventdate1','$eventdate2','$eventnow'
	";
			getDbInsert('rb_dalkkum_eventapply',$QKEY,$QVAL);
			getLink('/mypage/?page=apply_event','parent.','정상적으로 등록되었습니다.','');
		}
	}
?>