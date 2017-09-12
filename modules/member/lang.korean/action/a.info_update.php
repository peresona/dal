<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'])
{
	getLink('','','정상적인 접근이 아닙니다.','');
}
include_once $g['dir_module'].'var/var.join.php';
$memberuid	= $my['admin'] && $memberuid ? $memberuid : $my['uid'];
$infoData = getDbData('rb_s_mbrid','memberuid='.$memberuid,'*');
$infoMData = getDbData('rb_s_mbrdata','memberuid='.$memberuid,'*');
$name		= $name?trim($name):$infoMData['name'];
$nic		= $nic?trim($nic):$infoMData['nic'];
$nic		= $nic ? $nic : $name;
$mentor_grade = $mentor_grade? $mentor_grade : ($infoMData['mentor_grade']?$infoMData['mentor_grade']:'3');
$mentor_score = $mentor_score? $mentor_score : ($infoMData['mentor_score']?$infoMData['mentor_score']:'50');
$mentor_moreteach = $mentor_moreteach? $mentor_moreteach: ($infoMData['mentor_moreteach']?$infoMData['mentor_moreteach']:'0');
$email_edit	= ($my['admin'] && $email)? $email : $infoMData['email'];
if (($d['member']['form_nic'] && !$check_nic) || !$check_email || ($memberuid != $my['uid'] && $my['admin'] && !$check_email))
{
	getLink('','','정상적인 접근이 아닙니다.','');
}
if($d['member']['form_nic'])
{
	if(!$my['admin'])
	{
		if(strstr(','.$d['member']['join_cutnic'].',',','.$nic.',') || getDbRows($table['s_mbrdata'],"memberuid<>".$memberuid." and nic='".$nic."'"))
		{
			getLink('','','이미 존재하는 닉네임입니다.','');
		}
	}
}
if($new_pw && $new_pw2){
	if($new_pw != $new_pw2){
		getLink('','','변경할 비밀번호가 서로 다릅니다.','');
	}
	// 기존 암호 확인
	$new_pw_data = getDbData('rb_s_mbrid','uid='.$memberuid,'*');
	if(!(md5($now_pw) == $new_pw_data['pw'] || $my['admin']=='1')) getLink('','','현재 비밀번호가 틀렸습니다.','');
}
// 프로필 사진 검증
$tmpname	= $_FILES['upfile']['tmp_name'];
$realname	= $_FILES['upfile']['name'];
$fileExt	= strtolower(getExt($realname));
$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;
$photo		= 'pic_'.$memberuid.'.'.$fileExt;
$saveFile1	= $g['path_var'].'simbol/'.$photo;
$saveFile2	= $g['path_var'].'simbol/180.'.$photo;
if (is_uploaded_file($tmpname))
{
	if (!strstr('[gif][jpg][png]',$fileExt))
	{
		getLink('','','gif/jpg/png 파일만 등록할 수 있습니다.','');
	}
	if (is_file($saveFile1))
	{
		unlink($saveFile1);
	}
	if (is_file($saveFile2))
	{
		unlink($saveFile2);
	}

	$wh = getimagesize($tmpname);
	if ($wh[0] < 180 || $wh[1] < 180)
	{
		getLink('','','가로/세로 180픽셀 이상이어야 합니다.','');
	}

	include_once $g['path_core'].'function/thumb.func.php';

}




// 프로필 사진 업로드
if (is_uploaded_file($tmpname)){
	move_uploaded_file($tmpname,$saveFile2);
	ResizeWidth($saveFile2,$saveFile2,180);
	ResizeWidthHeight($saveFile2,$saveFile1,50,50);
	@chmod($saveFile1,0707);
	@chmod($saveFile2,0707);
	getDbUpdate($table['s_mbrdata'],"photo='".$photo."'",'memberuid='.$memberuid);
}

$home		= $home ? (strstr($home,'http://')?str_replace('http://','',$home):$home) : '';
$birth1		= $birth_1;
$birth2		= $birth_2.$birth_3;
$birthtype	= $birthtype ? $birthtype : 0;
$tel1		= $tel1_1 && $tel1_2 && $tel1_3 ? $tel1_1 .'-'. $tel1_2 .'-'. $tel1_3 : '';
$tel2		= $tel2_1 && $tel2_2 && $tel2_3 ? $tel2_1 .'-'. $tel2_2 .'-'. $tel2_3 : '';

if(!$foreign)
{
	$zip		= $zip_1.$zip_2;
	$addrx		= explode(' ',$addr1);
	$addr0		= $addr1 && $addr2 ? $addrx[0] : '';
	$addr1		= $addr1 && $addr2 ? $addr1 : '';
	$addr2		= trim($addr2);
}
else {
	$zip		= '';
	$addr0		= '해외';
	$addr1		= '';
	$addr2		= '';
}

$job		= trim($job);
$marr1		= $marr_1 && $marr_2 && $marr_3 ? $marr_1 : 0;
$marr2		= $marr_1 && $marr_2 && $marr_3 ? $marr_2.$marr_3 : 0;
$sms		= $tel2 && $sms ? 1 : 0;
$mailing	= $remail;
$pw_q		= trim($pw_q);
$pw_a		= trim($pw_a);
$addfield	= '';
$sc_parent_tel = $sc_parent_tel_1.'-'.$sc_parent_tel_2.'-'.$sc_parent_tel_3;
$_addarray	= file($g['path_module'].$m.'/var/add_field.txt');
foreach($_addarray as $_key)
{
	$_val = explode('|',trim($_key));
	if ($_val[2] == 'checkbox')
	{
		$addfield .= $_val[0].'^^^';
		if (is_array(${'add_'.$_val[0]}))
		{
			foreach(${'add_'.$_val[0]} as $_skey)
			{
				$addfield .= '['.$_skey.']';
			}
		}
		$addfield .= '|||';
	}
	else {
		$addfield .= $_val[0].'^^^'.trim(${'add_'.$_val[0]}).'|||';
	}
}

$_QVAL = "email='$email_edit',comp='$comp',name='$name',nic='$nic',home='$home',sex='$sex',birth1='$birth1',birth2='$birth2',birthtype='$birthtype',tel1='$tel1',tel2='$tel2',";
$_QVAL.= "zip='$zip',addr0='$addr0',addr1='$addr1',addr2='$addr2',addr_lat='$addr_lat',addr_long='$addr_long',address='$address',address_detail='$address_detail',job='$job',marr1='$marr1',marr2='$marr2',sms='$sms',mailing='$mailing',pw_q='$pw_q',pw_a='$pw_a',addfield='$addfield',not_crime='$not_crime',";
$_QVAL.= "sc_name='$sc_name',sc_grade='$sc_grade',sc_class='$sc_class',sc_num='$sc_num',mentor_job='$mentor_job',sc_parent_kind='$sc_parent_kind',sc_parent_name='$sc_parent_name',sc_parent_tel='$sc_parent_tel',mentor_grade='$mentor_grade',mentor_score='$mentor_score',mentor_moreteach='$mentor_moreteach'";
getDbUpdate($table['s_mbrdata'],$_QVAL,'memberuid='.$memberuid);

/* 멘토 평점이 기존과 다르면 날짜 입력 */
if($infoMData['mentor_grade'] != $mentor_grade) getDbUpdate($table['s_mbrdata'],"mentor_grade_set='".$date['totime']."'",'memberuid='.$memberuid);
if($infoMData['mentor_score'] != $mentor_score) getDbUpdate($table['s_mbrdata'],"mentor_score_set='".$date['totime']."'",'memberuid='.$memberuid);


/* 멘토 정보 */
$mbrMentorD = getDbData('rb_dalkkum_mentor','uid='.$memberuid,'*');
$mentor = array();
$mentor_kinds = array('edu','career','cert','prize','teaching');
$_forhidden = "";
foreach ($mentor_kinds as $kinds) {
	$_fortext = "";
	foreach(${"m_".$kinds} as $value) {
	  if(isset(${"m_".$kinds})) $_fortext .= $value."%%%";
	}
	if(isset(${"m_".$kinds})) $mentor[$kinds] = $_fortext;
		else $mentor[$kinds] = $mbrMentorD[$kinds];
}
for ($i=1; $i <=5 ; $i++) { 
	${"i_".$i} = isset(${"i_".$i})?${"i_".$i}:$mbrMentorD['i_'.$i];
}
	
$mentor['abletime'] = isset($m_time)?$m_time:$mbrMentorD['abletime'];
$mentor['talk'] = isset($m_talk)?$m_talk:$mbrMentorD['talk'];
$mentor['intro'] = isset($m_intro)?$m_intro:$mbrMentorD['intro'];


// 멘토 정보 변경
if($memberuid == $my['uid'] && getDbRows('rb_dalkkum_mentor','uid='.$memberuid)){
	$_QVAL = "uid='$memberuid',edu='$mentor[edu]',career='$mentor[career]',cert='$mentor[cert]',prize='$mentor[prize]',teaching='$mentor[teaching]',abletime='$mentor[abletime]',talk='$mentor[talk]',intro='$mentor[intro]',hiddens='$hiddens',i_1='$i_1',i_2='$i_2',i_3='$i_3',i_4='$i_4',i_5='$i_5',last_modify='$date[totime]',place_modify='info_update'";
	getDbUpdate('rb_dalkkum_mentor',$_QVAL,'uid='.$memberuid);
}elseif($memberuid == $my['uid']){	
	$_QKEY = "uid,edu,career,cert,prize,teaching,abletime,talk,intro,hiddens,i_1,i_2,i_3,i_4,i_5";
	$_QVAL = "'$memberuid','$mentor[edu]','$mentor[career]','$mentor[cert]','$mentor[prize]','$mentor[teaching]','$mentor[abletime]','$mentor[talk]','$mentor[intro]','$hiddens','$i_1','$i_2','$i_3','$i_4','$i_5'";
	getDbInsert('rb_dalkkum_mentor',$_QKEY,$_QVAL);
}

getDbUpdate($table['s_mbrdata'],$_QVAL,'memberuid='.$memberuid);

if($check_id && $id){
		$_QVAL = "id='$id'";
		getDbUpdate('rb_s_mbrid',$_QVAL,'uid='.$memberuid);
}

// 새 암호 변경
if($new_pw && $new_pw2 && $new_pw == $new_pw2){
	$_QVAL = "pw='".md5($new_pw)."'";
	getDbUpdate('rb_s_mbrid',$_QVAL,'uid='.$memberuid);
	if($memberuid == $my['memberuid']) $_SESSION['mbr_pw']  = md5($new_pw);
}


// 가비아로 영상 전송 && 기존 영상이 있다면 
if($_FILES['i_video']['tmp_name']){
		$headers = array("Content-Type:multipart/form-data");
		$data = array('file_name' => '@'.$_FILES['i_video']['tmp_name'].';filename='.$_FILES['i_video']['name'].';type='.$_FILES['i_video']['type'], 'company_id' => 'dalkkum1110', 'client_key' => 'd43327898fa8d0c89514ec738e583bef', 'url_success1' => 'http://app.dalkkum.net/?m=dalkkum&a=app_upload_video2&act=success', 'url_error1' => 'http://app.dalkkum.net/?m=dalkkum&a=app_upload_video2&act=fail', 'charset' => 'utf-8', 'class_code' => '48421', 'encoding_screen' => '800|600');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_INFILESIZE, $file['size']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, 'http://play.smartucc.kr/upload/ucc_upload.php');
		$_results = curl_exec($ch);
		preg_match_all("/<input[^>]*name=[\"']?([^>\"']+)[\"']?[^>]*value=[\"']?([^>\"']+)[\"']?[^>]*>/i",$_results,$results);
		$gabia_video = array_combine($results[1], $results[2]);

		// 변수에 담기
		$file_key_W = $gabia_video['file_key_W'];
		$file_key_I = $gabia_video['file_key_I'];
		$file_key_A = $gabia_video['file_key_A'];
		$file_key_M = $gabia_video['file_key_M'];
		$media_key = $gabia_video['origin_file_key'];
		$_tmpdb = getDbData('rb_dalkkum_mentor','uid='.$memberuid,'file_key_W');
		if($_tmpdb['file_key_W']){
			db_query("UPDATE rb_dalkkum_mentor SET file_key_W=NULL, file_key_I=NULL, file_key_A=NULL, file_key_M=NULL, media_key=NULL WHERE uid=".$memberuid.";",$DB_CONNECT);
			$delete_video = file_get_contents('http://uccapi.smartucc.kr/uccapi/Contents/deleteMedia/ucc_key/d43327898fa8d0c89514ec738e583bef/file_key/'.$_tmpdb['file_key_W']);
		}
		db_query("UPDATE rb_dalkkum_mentor SET file_key_W='".$file_key_W."', file_key_I='".$file_key_I."', file_key_A='".$file_key_A."', file_key_M='".$file_key_M."', media_key='".$media_key."' WHERE uid=".$memberuid.";",$DB_CONNECT);
}



$isCOMP = getDbData($table['s_mbrcomp'],'memberuid='.$memberuid,'*');

if ($comp)
{
	$comp_num	= $comp_num_1 && $comp_num_2 && $comp_num_3 ? $comp_num_1.$comp_num_2.$comp_num_3 : 0;
	//$comp_type	= $comp_type;
	$comp_name	= trim($comp_name);
	$comp_ceo	= trim($comp_ceo);
	$comp_upte	= trim($comp_upte);
	$comp_jongmok = trim($comp_jongmok);
	$comp_tel	= $comp_tel_1 && $comp_tel_2 ? $comp_tel_1 .'-'. $comp_tel_2 .($comp_tel_3 ? '-'.$comp_tel_3 : '') : '';
	$comp_fax	= $comp_fax_1 && $comp_fax_2 && $comp_fax_3 ? $comp_fax_1 .'-'. $comp_fax_2 .'-'. $comp_fax_3 : '';
	$comp_zip	= $comp_zip_1.$comp_zip_2;
	$comp_addr0	= $comp_addr1 && $comp_addr2 ? substr($comp_addr1,0,6) : '';
	$comp_addr1	= $comp_addr1 && $comp_addr2 ? $comp_addr1 : '';
	$comp_addr2	= trim($comp_addr2);
	$comp_part	= trim($comp_part); 
	$comp_level	= trim($comp_level);

	if ($isCOMP['memberuid'])
	{
		$_QVAL = "comp_num='$comp_num',comp_type='$comp_type',comp_name='$comp_name',comp_ceo='$comp_ceo',comp_upte='$comp_upte',comp_jongmok='$comp_jongmok',";
		$_QVAL.= "comp_tel='$comp_tel',comp_fax='$comp_fax',comp_zip='$comp_zip',comp_addr0='$comp_addr0',comp_addr1='$comp_addr1',comp_addr2='$comp_addr2',comp_part='$comp_part',comp_level='$comp_level'";
		getDbUpdate($table['s_mbrcomp'],$_QVAL,'memberuid='.$isCOMP['memberuid']);
	}
	else {

		$_QKEY = "memberuid,comp_num,comp_type,comp_name,comp_ceo,comp_upte,comp_jongmok,";
		$_QKEY.= "comp_tel,comp_fax,comp_zip,comp_addr0,comp_addr1,comp_addr2,comp_part,comp_level";
		$_QVAL = "'$memberuid','$comp_num','$comp_type','$comp_name','$comp_ceo','$comp_upte','$comp_jongmok',";
		$_QVAL.= "'$comp_tel','$comp_fax','$comp_zip','$comp_addr0','$comp_addr1','$comp_addr2','$comp_part','$comp_level'";
		getDbInsert($table['s_mbrcomp'],$_QKEY,$_QVAL);
	}
}

// 인터뷰사진 관련 추가부분 (이윤규)
$i_tmpname	= $_FILES['i_pic']['tmp_name'];
$i_realname	= $_FILES['i_pic']['name'];
$i_fileExt	= strtolower(getExt($i_realname));
$i_fileExt	= $i_fileExt == 'jpeg' ? 'jpg' : $i_fileExt;
$i_photo	= $memberuid.'.'.$i_fileExt;
$i_saveFile1	= $g['path_var'].'iphoto/'.$i_photo;
$i_saveFile2	= $g['path_var'].'iphoto/'.'360.'.$i_photo;
if (is_uploaded_file($i_tmpname) && $i_fileExt)
{
	if (!strstr('[gif][jpg][png]',$i_fileExt))
	{
		getLink('','','gif/jpg/png 파일만 등록할 수 있습니다.','');
	}
	if (is_file($i_saveFile1))
	{
		unlink($i_saveFile1);
	}
	$wh = getimagesize($i_tmpname);
	if ($wh[0] > 1024 || $wh[1] > 768)
	{
		getLink('','','가로 1024픽셀 세로 768픽셀 미만이어야 합니다.','');
	}

	include_once $g['path_core'].'function/thumb.func.php';
	move_uploaded_file($i_tmpname,$i_saveFile1);
	ResizeWidth($i_saveFile1,$i_saveFile2,360);
	@chmod($i_saveFile1,0707);
	@chmod($i_saveFile2,0707);

	getDbUpdate('rb_dalkkum_mentor',"i_pic='".$i_photo."'",'uid='.$memberuid);

}

// 끝
getLink('reload','parent.','변경되었습니다.','');
?>