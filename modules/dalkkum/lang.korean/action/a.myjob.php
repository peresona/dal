<?php
if(!defined('__KIMS__')) exit;
if(!$my['memberuid']) getLink('','','로그인 후 이용 가능합니다.','');

// 선호직업 지정
if($act == 'mybest_reset' && $mode=='lib_select'){
		getDbUpdate('rb_s_mbrdata','like_job=""','memberuid='.$my['memberuid']);
		getLink('reload','parent.','선호직업 목록이 초기화되었습니다.','');
	exit;
}

// 선호직업 지정
if($act == 'mybest_regis' && $mode=='lib_select'){
	$_tmptext = "";
	$alljob = array_filter(array_merge($alljob,explode(',', $my['like_job'])));
	if(count($alljob) <= 5 && count($alljob) > 0){
		$_tmptext = implode(',',$alljob);
		getDbUpdate('rb_s_mbrdata','like_job="'.$_tmptext.'"','memberuid='.$my['memberuid']);
		getLink('reload','parent.','선호직업이 새로 등록되었습니다. (중복제외)','');
	}else{
		getLink('','parent.','선호직업은 5개 이하의 직업만 설정이 가능합니다.','');
	}
	exit;
}

if($act == 'regis' && $mode=='lib'){
	getDbInsert('rb_dalkkum_myjob','my_mbruid,job_seq,d_regis',"'{$my['memberuid']}','{$job_seq}','{$date[totime]}'");
	echo '<script type="text/javascript"> parent.lib_reload_j("'.$job_seq.'","add",""); </script>';
		
	$_tmp = getDbRows('rb_dalkkum_myjob','job_seq='.$job_seq);
	getDbUpdate('rb_dalkkum_job','follower='.$_tmp,'uid='.$job_seq);

	exit;
}
elseif($act == 'regis' && $mode=='reload'){
	getDbInsert('rb_dalkkum_myjob','my_mbruid,job_seq,d_regis',"'{$my['memberuid']}','{$job_seq}','{$date[totime]}'");
	$_tmp = getDbRows('rb_dalkkum_myjob','job_seq='.$job_seq);
	getDbUpdate('rb_dalkkum_job','follower='.$_tmp,'uid='.$job_seq);
	echo '<script type="text/javascript"> parent.location.reload(); </script>';

	exit;
}
elseif($act == 'delete' && $mode=='lib'){
	getDbDelete('rb_dalkkum_myjob','my_mbruid='.$my['memberuid'].' and job_seq='.$job_seq);
		echo '<script type="text/javascript"> parent.lib_reload_j("'.$job_seq.'","del",""); </script>';
		
	$_tmp = getDbRows('rb_dalkkum_myjob','job_seq='.$job_seq);
	getDbUpdate('rb_dalkkum_job','follower='.$_tmp,'uid='.$job_seq);
	exit;
}

elseif($act == 'delete' && $mode=='reload'){
	getDbDelete('rb_dalkkum_myjob','my_mbruid='.$my['memberuid'].' and job_seq='.$job_seq);
	$_tmp = getDbRows('rb_dalkkum_myjob','job_seq='.$job_seq);
	getDbUpdate('rb_dalkkum_job','follower='.$_tmp,'uid='.$job_seq);
	echo '<script type="text/javascript"> parent.location.reload(); </script>';

	exit;
}

if($act == 'regis' && $mode=='lib_select'){
	$sum_success = 0;
	for($i=0; $i<count($alljob); $i++){
		// 등록된 직업인지 조회 아니라면 추가
		$_isMy = getDbData('rb_dalkkum_myjob','my_mbruid='.$my['memberuid'].' and job_seq='.$alljob[$i],'uid');
		if(!$_isMy['uid']) {
			getDbInsert('rb_dalkkum_myjob','my_mbruid,job_seq,d_regis',"'{$my['memberuid']}','{$alljob[$i]}','{$date[totime]}'");
			$sum_success++;
			$_tmp = getDbRows('rb_dalkkum_myjob','job_seq='.$alljob[$i]);
			getDbUpdate('rb_dalkkum_job','follower='.$_tmp,'uid='.$alljob[$i]);
		}
	}
	if($sum_success) getLink('reload','parent.',$sum_success.'개의 직업이 추가되었습니다. (중복제외)','');
		else getLink('','parent.','처리된 요청이 없습니다. (중복제외)','');
}

elseif($act == 'delete' && $mode=='lib_select'){
	$sum_success = 0;
	for($i=0; $i<count($alljob); $i++){
		// 등록된 직업인지 조회 아니라면 추가
		$_isMy = getDbData('rb_dalkkum_myjob','my_mbruid='.$my['memberuid'].' and job_seq='.$alljob[$i],'uid');
		if($_isMy['uid']) {
			getDbDelete('rb_dalkkum_myjob','my_mbruid='.$my['memberuid'].' and job_seq='.$alljob[$i]);
			$sum_success++;
			$_tmp = getDbRows('rb_dalkkum_myjob','job_seq='.$alljob[$i]);
			getDbUpdate('rb_dalkkum_job','follower='.$_tmp,'uid='.$alljob[$i]);
		}

	}
		if($sum_success) getLink('reload','parent.',$sum_success.'개의 직업이 제외되었습니다. (중복제외)','');
			else getLink('','parent.','처리된 데이터가 없습니다.','');

}


elseif($act == 'regis'){
	getDbInsert('rb_dalkkum_myjob','my_mbruid,job_seq,d_regis',"'{$my['memberuid']}','{$job_seq}','{$date[totime]}'");
	echo '<script type="text/javascript"> parent.popup_jobs("'.$job_seq.'"); </script>';
		
	$_tmp = getDbRows('rb_dalkkum_myjob','job_seq='.$job_seq);
	getDbUpdate('rb_dalkkum_job','follower='.$_tmp,'uid='.$job_seq);
	getLink('','parent.', '해당 직업이 나의 관심 직업으로 설정되었습니다.', '');
}

elseif($act == 'delete'){
	getDbDelete('rb_dalkkum_myjob','my_mbruid='.$my['memberuid'].' and job_seq='.$job_seq);
	echo '<script type="text/javascript"> parent.popup_jobs("'.$job_seq.'"); </script>';
		
	$_tmp = getDbRows('rb_dalkkum_myjob','job_seq='.$job_seq);
	getDbUpdate('rb_dalkkum_job','follower='.$_tmp,'uid='.$job_seq);
	getLink('','parent.', '해당 직업이 나의 관심 직업에서 해제되었습니다.', '');
}
	getLink('','', '에러가 발생하였습니다.', '');

?>