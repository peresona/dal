<?php
if(!defined('__KIMS__')) exit;



include_once $g['dir_module'].'var/var.join.php';

$id			= trim($_POST['id']);
$name		= trim($_POST['name']);
$nic		= trim($nic);
$nic		= $nic ? $nic : $name;
//$email		= trim($email);
$email		= $id; // 이메일을 아이디로 사용합니다.

if (!$id || !$name) getLink('', '', '정상적인 접속이 아닙니다.', '');
/*
if (!$check_id || ($d['member']['form_nic'] && !$check_nic) || !$check_email)
{
	getLink('','','정상적인 접근이 아닙니다.','');
}
*/
if(strstr(','.$d['member']['join_cutid'].',',','.$id.',') || getDbRows($table['s_mbrid'],"id='".$id."'"))
{
	getLink('','','사용할 수 없는 아이디입니다.','');
}
if(!$d['member']['join_rejoin'])
{
	if(is_file($g['path_tmp'].'out/'.$id.'.txt'))
	{
		getLink('','','사용할 수 없는 아이디입니다.','');
	}
}

if(getDbRows($table['s_mbrdata'],"email='".$email."'"))
{
	getLink('','','이미 존재하는 이메일입니다.','');
}
if($d['member']['form_nic'])
{
	if(strstr(','.$d['member']['join_cutnic'].',',','.$nic.',') || getDbRows($table['s_mbrdata'],"nic='".$nic."'"))
	{
		getLink('','','사용할 수 없는 닉네임입니다.','');
	}
}

getDbInsert($table['s_mbrid'],'site,id,pw',"'$s','$id','".md5($pw1)."'");
$memberuid  = getDbCnt($table['s_mbrid'],'max(uid)','');
$auth		= $d['member']['join_auth'];
$sosok		= $d['member']['join_group'];
$level		= $d['member']['join_level'];
$comp		= $d['member']['form_comp'] && $comp ? 1 : 0;
$admin		= 0;
$name		= trim($name);
$photo		= '';
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
$smail		= 0;
$point		= $d['member']['join_point'];
$usepoint	= 0;
$money		= 0;
$cash		= 0;
$num_login	= 1;
$pw_q		= trim($pw_q);
$pw_a		= trim($pw_a);
$now_log	= 1;
$last_log	= $date['totime'];
$last_pw	= $date['totime'];
$is_paper	= 0;
$d_regis	= $date['totime'];


/* 학교 정보 */
$sc_name		= trim($sc_name);
$sc_grade		= trim($sc_grade);
$sc_class		= trim($sc_class);
$sc_num		= trim($sc_num);
$sc_parent_kind		= trim($sc_parent_kind);
$sc_parent_name		= trim($sc_parent_name);
$sc_parent_tel		= $sc_parent_tel_1 && $sc_parent_tel_2 && $sc_parent_tel_3 ? $sc_parent_tel_1 .'-'. $sc_parent_tel_2 .'-'. $sc_parent_tel_3 : '';

/* 멘토 정보 */
$is		= trim($is);
if($is == "mentor"){
	$mentor = array();
	$mentor_kinds = array('edu','career','cert','prize','teaching');
	foreach ($mentor_kinds as $kinds) {
		global $_forhidden;
		$_fortext = "";
		foreach(${"m_".$kinds} as $value) {
		  $_fortext .= $value."%%%";
		}
		 $mentor[$kinds] = $_fortext;
	}

	$mentor['abletime'] = $m_time;
	$mentor['talk'] = $m_talk;
	$mentor['intro'] = $m_intro;


	if (!trim($i_1) || !trim($i_2) || !trim($i_3) || !trim($i_4) || !trim($i_5)) getLink('','','인터뷰를 모두 기입해주세요.','');

	if (!$mentor['abletime']) getLink('','','가능 시간을 기입해주셔야합니다.','');
	if (!$mentor['talk']) getLink('','','멘토의 한마디를 기입해주셔야합니다.','');
	if (!$mentor['intro']) getLink('','','자기소개를 기입해주셔야합니다.','');

	$mentor_apply = $d_regis;
}


// 인터뷰사진 관련 추가부분 (이윤규)
$i_tmpname	= $_FILES['i_pic']['tmp_name'];
$i_realname	= $_FILES['i_pic']['name'];
$i_fileExt	= strtolower(getExt($i_realname));
$i_fileExt	= $i_fileExt == 'jpeg' ? 'jpg' : $i_fileExt;
$i_photo	= $memberuid.'.'.$i_fileExt;
$i_saveFile1	= $g['path_var'].'iphoto/'.$i_photo;
$i_saveFile2	= $g['path_var'].'iphoto/360.'.$i_photo;
if (is_uploaded_file($i_tmpname))
{
	if (!strstr('[gif][jpg][png]',$i_fileExt))
	{
		getLink('','','gif/jpg/png 파일만 등록할 수 있습니다.','');
	}
	if (is_file($i_saveFile1))
	{
		unlink($i_saveFile1);
	}
	if (is_file($i_saveFile2))
	{
		unlink($i_saveFile2);
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

}
// 만약 앱으로 받았을 경우 이걸로 대체
if($iphoto_change && $iphoto_change != 'undefined') $i_photo = $iphoto_change;

// 앱으로 인터뷰 영상 업로드시
if($ivideo_change && $ivideo_change != 'undefined') {
	$_ivtmp = explode('#*%*#', $ivideo_change);
	if($_ivtmp[3]){
		$mentor['file_key_W'] = str_replace('*', '', $_ivtmp[3]);
		$mentor['file_key_I'] = str_replace('*', '', $_ivtmp[4]);
		$mentor['file_key_A'] = str_replace('*', '', $_ivtmp[5]);
		$mentor['file_key_M'] = str_replace('*', '', $_ivtmp[6]);
		$mentor['media_key'] = str_replace('*', '', $_ivtmp[7]);
	}
}


// 끝

$sns		= '';
$addfield	= '';

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

$_QKEY = "memberuid,site,auth,sosok,level,comp,admin,adm_view,";
$_QKEY.= "email,name,nic,grade,photo,home,sex,birth1,birth2,birthtype,tel1,tel2,zip,";
$_QKEY.= "addr0,addr1,addr2,addr_lat,addr_long,address,address_detail,job,marr1,marr2,sms,mailing,smail,point,usepoint,money,cash,num_login,pw_q,pw_a,now_log,last_log,last_pw,is_paper,d_regis,sc_name,sc_grade,sc_class,sc_num,mentor_job,mentor_apply,sc_parent_kind,sc_parent_name,sc_parent_tel,tmpcode,sns,addfield,not_crime";

$_QVAL = "'$memberuid','$s','$auth','$sosok','$level','$comp','$admin','',";
$_QVAL.= "'$email','$name','$nic','','$photo','$home','$sex','$birth1','$birth2','$birthtype','$tel1','$tel2','$zip',";
$_QVAL.= "'$addr0','$addr1','$addr2','$addr_lat','$addr_long','$address','$address_detail','$job','$marr1','$marr2','$sms','$mailing','$smail','$point','$usepoint','$money','$cash','$num_login','$pw_q','$pw_a','$now_log','$last_log','$last_pw','$is_paper','$d_regis','$sc_name','$sc_grade','$sc_class','$sc_num','$mentor_job','$mentor_apply','$sc_parent_kind','$sc_parent_name','$sc_parent_tel','','$sns','$addfield','$not_crime'";
getDbInsert($table['s_mbrdata'],$_QKEY,$_QVAL);

// 멘토 정보 등록
$_QKEY = "uid,edu,career,cert,prize,teaching,abletime,talk,intro,hiddens,i_1,i_2,i_3,i_4,i_5,i_pic,file_key_W,file_key_I,file_key_A,file_key_M,media_key";
$_QVAL = "'$memberuid','$mentor[edu]','$mentor[career]','$mentor[cert]','$mentor[prize]','$mentor[teaching]','$mentor[abletime]','$mentor[talk]','$mentor[intro]','$hiddens','$i_1','$i_2','$i_3','$i_4','$i_5','$i_photo','$mentor[file_key_W]','$mentor[file_key_I]','$mentor[file_key_A]','$mentor[file_key_M]','$mentor[media_key]'";
getDbInsert('rb_dalkkum_mentor',$_QKEY,$_QVAL);

getDbUpdate($table['s_mbrlevel'],'num=num+1','uid='.$level);
getDbUpdate($table['s_mbrgroup'],'num=num+1','uid='.$sosok);
getDbUpdate($table['s_numinfo'],'login=login+1,mbrjoin=mbrjoin+1',"date='".$date['today']."' and site=".$s);


// 사진 관련 추가부분 (이윤규)
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

	move_uploaded_file($tmpname,$saveFile2);
	ResizeWidth($saveFile2,$saveFile2,180);
	ResizeWidthHeight($saveFile2,$saveFile1,50,50);
	@chmod($saveFile1,0707);
	@chmod($saveFile2,0707);

	getDbUpdate($table['s_mbrdata'],"photo='".$photo."'",'memberuid='.$memberuid);
}

// 만약 앱으로 받았을 경우 이걸로 대체
if($mypic_change && $mypic_change != 'undefined'){
	getDbUpdate($table['s_mbrdata'],"photo='".$mypic_change."'",'memberuid='.$memberuid);
} 

// 끝

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

	$_QKEY = "memberuid,comp_num,comp_type,comp_name,comp_ceo,comp_upte,comp_jongmok,";
	$_QKEY.= "comp_tel,comp_fax,comp_zip,comp_addr0,comp_addr1,comp_addr2,comp_part,comp_level";
	$_QVAL = "'$memberuid','$comp_num','$comp_type','$comp_name','$comp_ceo','$comp_upte','$comp_jongmok',";
	$_QVAL.= "'$comp_tel','$comp_fax','$comp_zip','$comp_addr0','$comp_addr1','$comp_addr2','$comp_part','$comp_level'";
	getDbInsert($table['s_mbrcomp'],$_QKEY,$_QVAL);
}
if ($point)
{
	getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'$memberuid','0','$point','".$d['member']['join_pointmsg']."','$d_regis'");	
}


//이메일인증
if ($auth == 3 && $d['member']['join_email'])
{
	include_once $g['path_core'].'function/email.func.php';
	
	$content = implode('',file($g['dir_module'].'doc/_auth.txt'));
	$content = str_replace('{NAME}',$name,$content);
	$content = str_replace('{NICK}',$nic,$content);
	$content = str_replace('{ID}',$id,$content);
	$content = str_replace('{EMAIL}',$email,$content);
	$content.= '<a href="'.$g['url_root'].'/?r='.$r.'&m=member&a=email_auth&tmpuid='.$memberuid.'&tmpcode='.$d_regis.'" style="font-weight:bold;font-size:20px;">[인증요청]</a>';

	getSendMail($email.'|'.$name, $d['member']['join_email'].'|'.$_HS['name'], '['.$_HS['name'].']회원가입 인증요청 메일입니다.', $content, 'HTML');
}

if ($auth == 1)
{
	include_once $g['path_core'].'function/email.func.php';

	if ($d['member']['join_email_send']&&$d['member']['join_email'])
	{
		$content = implode('',file($g['dir_module'].'doc/_join.txt'));
		$content = str_replace('{NAME}',$name,$content);
		$content = str_replace('{NICK}',$nic,$content);
		$content = str_replace('{ID}',$id,$content);
		$content = str_replace('{EMAIL}',$email,$content);
		getSendMail($email.'|'.$name, $d['member']['join_email'].'|'.$_HS['name'], '['.$_HS['name'].']회원가입을 축하드립니다.', $content, 'HTML');
	}

	$_SESSION['mbr_uid'] = $memberuid;
	$_SESSION['mbr_pw']  = md5($pw1);
	getLink(RW(0),'parent.','축하합니다. 회원가입 승인되었습니다.','');
}
if ($auth == 2)
{
	getLink(RW(0),'parent.','회원가입 신청서가 접수되었습니다. 관리자 승인후 이용하실 수 있습니다.','');
}
if ($auth == 3)
{
	getLink(RW(0),'parent.','회원가입 인증메일이 발송되었습니다. 이메일('.$email.')확인 후 인증해 주세요.','');
}
?>