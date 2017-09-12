<?php
if(!defined('__KIMS__')) exit;
elseif($need=='check_id'){
	$_result = getDbRows('rb_s_mbrid',"id='".trim($id)."'");
	$check_result = "0";
	if($_result=='0') {
		$code = "100";
		$msg = "<font color='blue'>사용 가능한 아이디입니다.</font>";
		$check_result = "1";
	}
	else {
		$code = "1";
		$msg = "<font color='red'>사용할 수 없는 이메일입니다.</font>";
	}
	echo urldecode(json_encode(array('code' => $code, 'msg' => $msg, 'check' => $check_result)));
	exit;
}
elseif($need=='search_job_kwd'){
	$func = $func?$func:'jobNum';
	$_que = "select J.uid,J.name,(select name from rb_dalkkum_job where not(J.parent=0) and uid=J.parent) as pname,J.hidden, J.parent from rb_dalkkum_job as J where J.isson=0 and (replace(J.name,' ','') like '%".trim($jobkwd)."%') order by J.parent asc ,J.name desc";
	$_result = db_query($_que,$DB_CONNECT);
	$_num = getDbRows('rb_dalkkum_job as J',"J.isson=0 and (replace(J.name,' ','') like '%".trim($jobkwd)."%')");
	$_inhtml_result = "";
	if($_num > 0 && $jobkwd) {
		while ($JR = db_fetch_array($_result)) {
			$_inhtml_result .= '<li onclick="'.$func.'('.$JR["uid"].',\''.$JR["name"].'\');">'.$JR["pname"].' > '.$JR["name"].'</li>';
		}
	}
	else {
			$_inhtml_result = '<li class="nothing">키워드를 입력해주세요.</li>';
	}
	echo urldecode(json_encode(array('code' => '100', 'num' => $_num, 'inhtml' => $_inhtml_result)));
	exit;
}

elseif($need=='job_memo' && $uid) {
	$J = getUidData('rb_dalkkum_job',$uid);

	// 같은 직업군 직업 리스트
	$_temp = getDbSelect('rb_dalkkum_job',"parent=".$J['parent'],"*");
	$assoc_job = array();
	while ($AS = db_fetch_array($_temp)) {
		array_push($assoc_job, $AS['name']);
	}
	// 해당 멘토 리스트
	$_temp = getDbSelect('rb_s_mbrdata',"mentor_confirm='Y' and mentor_job=".$J['uid'],"*");
	$mentors = array();
	while ($MT = db_fetch_array($_temp)) {
		array_push($mentors, $MT['memeberuid']);
	}

	$result = array('code' => '100','intro' => $J['name'] ,'assoc_job' => $assoc_job ,'mentor' => $mentors);
	echo urldecode(json_encode(array('code' => '100', 'result' => $result)));
	exit;
}


elseif($need=='share_applyevent' && $auid) {
	checkAdmin(0);
	$EA = getUidData('rb_dalkkum_eventapply',$auid);
	$share_input = array();
	$share_input['uid'] = $EA['uid'];
	$share_input['a_lat'] = $EA['a_lat'];
	$share_input['a_long'] = $EA['a_long'];
	$share_input['address'] = $EA['address'];
	$share_input['address_detail'] = $EA['address_detail'];
	$share_input['program'] = $EA['program'];
	$share_input['start_date_y'] = substr($EA['start_date'], 0,4);
	$share_input['start_date_m'] = substr($EA['start_date'], 4,2);
	$share_input['start_date_d'] = substr($EA['start_date'], 6,2);
	$share_input['many_times'] = $EA['many_times'];
	$tmp = explode('|', $EA['times']);
	foreach ($tmp as &$value) {
		$_temp = array();
	 	array_push($_temp, substr($value, 0,2));
	 	array_push($_temp, substr($value, 2,2));
	 	array_push($_temp, substr($value, 4,2));
	 	array_push($_temp, substr($value, 6,2));
	 	$value = $_temp; unset($_temp);
	}
	$share_input['a_times'] = $tmp;
	echo urldecode(json_encode(array('code' => '100', 'result' => $share_input)));
	exit;
}

elseif($need=='job_select'){
	$db_c = getDbSelect('rb_dalkkum_job','depth=2 and parent='.$cate,'uid,name');
		$_results = '<option value="">선택</option>';
	while($_C = db_fetch_array($db_c)){
		$_results .= '<option value="'.$_C['uid'].'">'.$_C['name'].'</option>';
	}
	echo urldecode(json_encode(array('code' => '100', 'options' => $_results))); exit;
}
elseif($need=='mentor_select'){
	$db_c = getDbSelect('rb_s_mbrdata','mentor_confirm="Y" and mentor_job='.$job_seq,'memberuid,name');
		$_results = '<option value="">선택</option>';
	while($_C = db_fetch_array($db_c)){
		$_results .= '<option value="'.$_C['memberuid'].'">'.$_C['name'].'</option>';
	}
	echo urldecode(json_encode(array('code' => '100', 'options' => $_results))); exit;
}

elseif($need=='apply_lists'){
			$_results = "";
			$_num = 0;
			$d_regis = $date['totime'];
			$index = $index?$index:'0';
			$limits = $limits?$limits:'6';
			if($search && $keyword){
				if($search == "school") $_where = " and (replace(SC.name,' ','') like '%".trim($keyword)."%')";
					elseif ($search == "group") $_where = " and (replace(G.name,' ','') like '%".trim($keyword)."%')";
			} 
			else if($keyword) $_where = " and (replace(G.name,' ','') like '%".trim($keyword)."%' or replace(SC.name,' ','') like '%".trim($keyword)."%')";

			if($sort){
				$sort = explode('|', $sort);
				$sorts = " order by ".$sort[0].' '.$sort[1];
			}
			else $sorts = " order by uid desc";
			
		 	$_appling_group = db_query("select G.* from rb_dalkkum_sclist as SC, rb_dalkkum_group as G where SC.uid = G.sc_seq and (G.apply_start='Y') and not(G.finish='Y') and ((G.date_start<".$d_regis." and G.date_end>".$d_regis.") or (G.use_second='Y' and G.date_start2<".$d_regis." and G.date_end2>".$d_regis."))".$_where.$sorts." limit ".$index.",".$limits,$DB_CONNECT);

					 while($GRD=db_fetch_array($_appling_group)){ $_num++;
					 	if($GRD[img]) $bgimg = '/files/_etc/group/'.$GRD[img];	else $bgimg = '/layouts/dalkkum_pc/image/temp/Untitled-6.jpg';
			$_results .= '<li class="d_apply_box fl center" style="background: url('.$bgimg.') center center no-repeat #000;">
							<div class="link_unblock">
							<font class="apply_bold">'.$GRD[name].'</font><br>
							<div class="line"></div> <br>
							'.getSchoolName($GRD[sc_seq]).' <br>
							'.getDateView($GRD[date_start]).'~'.getDateView($GRD[date_end]).'
							<br>
							<span class="icon d_apply_plus"></span>
							</div>
							<a class="link_space cp" onclick="apply_group(\''.$GRD[uid].'\',\''.getSchoolName($GRD[sc_seq]).'\');"></a>
							</li>';
			}
			if($_num==0) { echo urldecode(json_encode(array('code' => '100', 'num' => '0', 'msg' => '원하시는 검색 결과 목록이 없거나, 현재 진행중인 수강신청이 없습니다.'))); exit; }
			else {
				echo urldecode(json_encode(array('code' => '100', 'inhtml' => $_results, 'num' => $_num)));	exit;
			}
}

elseif($need=='popup_job'){
	$_results = array();
	// 소개말 가져오기
	if($my['memberuid']) $_where = ' and my_mbruid='.$my['memberuid'];
	$_data = getDbData('rb_dalkkum_job as J',"J.uid=".$uid." and not(J.hidden='1')",'(select count(*) from rb_dalkkum_myjob where job_seq=J.uid'.$_where.') as is_my, J.*');
	$_results['name'] = $_data['name'];
	$_results['intro'] = $_data['content'];
	$_results['is_my'] = $my['memberuid']?$_data['is_my']:'not'; // 비로그인시 not 전달
	
	// 연관 직업
	$_data2 = getDbSelect('rb_dalkkum_job',"parent=".$_data['parent']." and not(hidden='1') and not(uid='".$uid."')",'uid,name');
	$_text = "";
	while($AJ=db_fetch_array($_data2)){
		$_text .= "<span class='btn menti_box' onclick='popup_jobs(".$AJ['uid'].")'>".$AJ['name']."</span> ";
	}
	$_text = substr($_text , 0, -2);
	if($_text=="") $_text="해당하는 연관 직업이 없습니다.";
	$_results['assoc'] = $_text;

	// 멘토 목록
	$_data3 = getDbSelect('rb_s_mbrdata',"mentor_job=".$uid." and mentor_confirm='Y'",'memberuid,name,photo');
	$_text = "";
	while($ML=db_fetch_array($_data3)){
		if($ML['photo']) $_photobg = " style='background: url(\"/_var/simbol/180.".$ML['photo']."\") center center no-repeat; background-size:cover;'";
		$_text .= "<li onclick='popup_mentor(\"".$ML['memberuid']."\")' class='btn people'".$_photobg.">".$ML['name']."<br>멘토</li>";
		unset($_photobg);
	}
	if($_text=="") $_text="이 직업에는 아직 멘토가 없습니다.";
	$_results['mentor'] = $_text;

	echo urldecode(json_encode(array('code' => '100', 'result' => $_results)));
exit;
}

elseif($need=='popup_classDayDetail'){
	$_results = array();
	$_results['day_list'] = '';
	$_sql = db_query("select T.uid, T.class_time, T.nows, G.name, G.date_start, G.date_end, G.program_seq, SC.name as scName, SC.place, T.class_time from rb_dalkkum_team as T, rb_dalkkum_group as G, rb_dalkkum_sclist as SC where T.group_seq = G.uid and G.sc_seq = SC.uid and T.mentor_seq=".$my['memberuid']." and G.date_start like '".$selectDay."%' order by G.date_start asc",$DB_CONNECT);
	while ($RD = db_fetch_array($_sql)) {
		$_tmpd = getDbData('rb_dalkkum_program',"uid=".$RD['program_seq'],'*');
		$_results['day_list'] .= '<li onclick="OpenWindow(\'/?r=home&iframe=Y&m=dalkkum&a=export_team&uid='.$RD['uid'].'&mode=web\')"><b>'.getDateFormat($RD['date_start'],'Y년 m월 d일').'</b>'.'('.$RD['class_time'].'교시)<br>'.$_tmpd['name'].'<br>'.$RD['scName'].'<br>'.$RD['place'].'</li>';
	}
	if(!$_results['day_list']) $_results['day_list'] = '<li>표시할 목록이 없습니다.</li>';

	echo urldecode(json_encode(array('code' => '100', 'result' => $_results)));
exit;
}

// 팝업 멘토
elseif($need=='popup_mentor'){
	$_results = array();
	// 소개말 가져오기
	$_data = getDbData('rb_s_mbrdata',"memberuid=".$uid,'*');
	$_data2 = getDbData('rb_dalkkum_mentor',"uid=".$uid,'*');
	$menti_num = getDbRows('rb_s_friend',"by_mbruid=".$uid);
	$mentoring_num = getDbRows('rb_dalkkum_team',"mentor_seq=".$uid);
	$mentoring_num2 = $_data['mentor_moreteach'];
	$relative = getDbRows('rb_s_friend',"my_mbruid=".$my['memberuid']." and by_mbruid=".$uid);
	if($_data2['media_key']) $_results['i_video'] = $_data2['media_key'];
	$_results['nameline'] = "팬 : ".$menti_num."명 | 멘토링 : ".($mentoring_num + $mentoring_num2)."회<br><h1>".$_data['name']." 멘토 <br><span onclick=\"popup_jobs('".$_data['mentor_job']."'); $('#modal_mentor').hide();\" class=\"orange\">".getJobName($_data['mentor_job'])."</span onclick=\"\"></h1>";

	// 버튼 나타낼 것
	if($my['memberuid'] == $uid) $_results['fanmode'] = "me";
	 else if($relative) $_results['fanmode'] = "Y";
	 else $_results['fanmode'] = "N";

	// 인트로 준비
	
	$_results['intro'] = $_data2['intro']?$_data2['intro']:'입력된 정보가 없습니다.';
	
	$md_hiddens = array('edu' => $_hidden[0],'career' => $_hidden[1],'cert' => $_hidden[2],'prize' => $_hidden[3],'teaching' => $_hidden[4]);
	// 숨김 내역 가져오기
	$_hidden = explode('|', $_data2['hiddens']);
	$md_hiddens = array('edu' => $_hidden[0],'career' => $_hidden[1],'cert' => $_hidden[2],'prize' => $_hidden[3],'teaching' => $_hidden[4]);
	if($_data2['uid']){
		foreach ($_hidden as $key => &$value) {
			$value = explode('%', $value);
		}
		foreach ($_data2 as $key => &$value) {
			$value = explode('%%%', $value);
			for($i=0; $i < sizeof($value); $i++){
				if(substr($md_hiddens[$key],$i,1)=="1") $value[$i] = "";
			}
			$value = array_filter($value);
		}
		$md_datas = array('edu' => $_data2['edu'],
			'career' => $_data2['career'],
			'cert' => $_data2['cert'],
			'prize' => $_data2['prize'],
			'teaching' => $_data2['teaching']);
		$md_datas_text = "";
		foreach ($md_datas as $key => $value) {
			foreach ($value as $key2 => $value2) {
				$md_datas_text .= $value2."<br>";
			}
		}
	} else{
		$md_datas_text = "";		
	}

	$ISF = getDbData($table['s_friend'],'my_mbruid='.$my['uid'].' and by_mbruid='.$uid,'uid');
	$_results['fuid'] = $ISF['uid'];
	$_results['pic'] = $_data['photo']?'180.'.$_data['photo']:'';

	unset($_data2);
	$_results['career'] = $md_datas_text;
	echo urldecode(json_encode(array('code' => '100', 'result' => $_results)));
exit;
}

// My page 나의 관심사 직업
elseif($need=='lib_jobs'){
	$_results = "";
	$_num = 0;
	// index : 시작 번호 , limits : 몇 개
	if($keyword) $_where = " and replace(J.name,' ','') like '%".trim($keyword)."%'";
	if($category) $_where = " and J.parent=".trim($category);
	if($my['memberuid']) $_wherelogin = " (select count(*) from rb_dalkkum_myjob as MJ where MJ.my_mbruid=".$my['memberuid']." and MJ.job_seq=J.uid) as is_my,";

	if($mode=='my')	$_jobs_icon = db_query("select".$_wherelogin." J.* from rb_dalkkum_myjob as MJ, rb_dalkkum_job as J where MJ.job_seq=J.uid and J.depth=2".$_where." and not(J.hidden='1') and MJ.my_mbruid=".$my['memberuid']." order by J.follower desc".($limits?" limit ".$index.",".$limits:''),$DB_CONNECT);

		else $_jobs_icon = db_query("select".$_wherelogin." J.* from rb_dalkkum_job as J where (J.depth=2) and not(J.hidden='1')".$_where.($limits?" limit ".$index.",".$limits:''),$DB_CONNECT);

	while($JI=db_fetch_array($_jobs_icon)){
	$_num++;
	if(!$JI['img']) $JI['img'] = "default.png";
		$_results .= '<li class="'.$obj.'" data-allJob="'.$JI['uid'].'">
				<div class="cl icon jobIconBg cp" style="background-image: url(\'/files/_etc/job/'.$JI['img'].'\');" onclick="popup_jobs('.$JI['uid'].')"></div>
				<div class="cl cp ellipsis center" onclick="popup_jobs('.$JI['uid'].')">'.$JI['name'].'</div>';
		if($selecter=='Y'){
			$_results .= '<input class="all_check" name="alljob[]" type="checkbox" value="'.$JI['uid'].'">';
			if($JI['is_my']>0) { $_results .= '<input type="button" class="cl btn except" value="제외" data-fjbtn="'.$JI['uid'].'" onclick="inMyLib(\'job\',\'out\',\''.$JI['uid'].'\',\'fjbtn\');">';
			} else {$_results .= '<input type="button" class="cl btn adder" value="추가" data-fjbtn="'.$JI['uid'].'" onclick="inMyLib(\'job\',\'in\',\''.$JI['uid'].'\',\'fjbtn\');">';}

			$_results .= '</li>';
		}
	}
	if($mode=='my') $_results .= '<li class="'.$obj.' more">
				<div class="cl icon jobIconBgMore cp" style="background-image: url(\'/layouts/dalkkum_pc/image/myplus.png\');" onclick="$(\'#modal_favoriteJob\').css(\'display\',\'block\');"></div>
			</li>';
	echo urldecode(json_encode(array('code' => '100', 'inhtml' => $_results, 'num' => $_num)));
exit;
}
// My page 나의 관심사 직업
elseif($need=='lib_mentors'){
	$_results = "";
	$_num = 0;
	// index : 시작 번호 , limits : 몇 개
	if($keyword) $_where = " and (replace(M.name,' ','') like '%".trim($keyword)."%' or replace(J.name,' ','') like '%".trim($keyword)."%')";
	if($category) $_where = " and J.parent=".trim($category);
	if($my['memberuid']) $_wherelogin = " (select count(*) from rb_s_friend where my_mbruid=".$my['memberuid']." and by_mbruid=M.memberuid) as is_my,";
	if($mode=='my') $_jobs_icon = db_query("select".$_wherelogin." M.memberuid as mentorUID,M.name as mentorName, J.name as jobName, M.photo from rb_s_friend as F, rb_s_mbrdata as M, rb_dalkkum_job as J where F.by_mbruid=M.memberuid".$_where." and M.mentor_job=J.uid and F.my_mbruid=".$my['memberuid']." order by M.follower desc ".($limits?" limit ".$index.",".$limits:''),$DB_CONNECT);
	
	else $_jobs_icon = db_query("select".$_wherelogin." M.memberuid as mentorUID,M.name as mentorName, J.name as jobName, M.photo from rb_s_mbrdata as M, rb_dalkkum_job as J where M.mentor_job=J.uid and M.mentor_confirm='Y'".$_where." order by M.follower desc ".($limits?" limit ".$index.",".$limits:''),$DB_CONNECT);

	while($JI=db_fetch_array($_jobs_icon)){
	$_num++;
	if($JI['photo']) $JI['photo'] = "180.".$JI['photo']; else $JI['photo'] = "default.jpg";
		$_results .= '<li class="'.$obj.'" data-allMentor="'.$JI['mentorUID'].'">
				<div class="cl icon mentorIconBg cp" style="
				background-image: url(\'/_var/simbol/'.$JI['photo'].'\');" onclick="popup_mentor(\''.$JI['mentorUID'].'\')"></div>
				<div class="cl cp ellipsis center" onclick="popup_mentor(\''.$JI['mentorUID'].'\')">'.$JI['mentorName'].'</div>
				<div class="cl cp ellipsis center"><font class="orange">'.$JI['jobName'].'</font></div>';
		$_tmpd = getDbData('rb_s_friend',"my_mbruid=".$my['memberuid']." and by_mbruid=".$JI['mentorUID'],'uid');
		if($JI['is_my']>0 && $selecter=='Y') {

		 $_results .= '<input class="all_check" name="allMentor[]" type="checkbox" value="'.$JI['mentorUID'].'"><input type="button" class="cl btn except" value="제외" data-fmbtn="'.$JI['mentorUID'].'" onclick="inMyLib(\'mentor\',\'out\',\''.$JI['mentorUID'].'\',\'fmbtn\');">';} 
			elseif($selecter=='Y'){ $_results .= '<input class="all_check" name="allMentor[]" type="checkbox" value="'.$JI['mentorUID'].'"><input type="button" class="cl btn adder" value="추가" data-fmbtn="'.$JI['mentorUID'].'" onclick="inMyLib(\'mentor\',\'in\',\''.$JI['mentorUID'].'\',\'fmbtn\');">';
	}

		$_results .= '</li>';
	}
	if($mode=='my')	$_results .= '<li class="'.$obj.' more" style="height: 110px; margin-bottom: 90px;" onclick="$(\'#modal_favoriteMentor\').css(\'display\',\'block\');">
				<div class="cl icon jobIconBgMore cp" style="background-image: url(\'/layouts/dalkkum_pc/image/myplus.png\');"></div>
			</li>';
	echo urldecode(json_encode(array('code' => '100', 'inhtml' => $_results, 'num' => $_num)));
exit;
}


echo urldecode(json_encode(array('code' => '1', 'msg' => '에러가 발생하였습니다.' )));
exit;
?>