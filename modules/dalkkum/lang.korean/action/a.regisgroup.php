<?php
if(!defined('__KIMS__')) exit;
checkAdmin(0);

header("Content-Type: text/html; charset=UTF-8");

$title = trim(strip_tags($title));
$d_regis	= $date['totime'];

$date_start = $year1.$month1.$day1.$hour1.$min1.'00';
$date_end = $year2.$month2.$day2.$hour2.$min2.'00';

$date_start2 = $year1_2.$month1_2.$day1_2.$hour1_2.$min1_2.'00';
$date_end2 = $year2_2.$month2_2.$day2_2.$hour2_2.$min2_2.'00';

$class_date = $class_year.$class_month.$class_day;
for($_i=1; $_i<=$select_hour; $_i++){
	${"start".$_i."_1"} = sprintf('%02d',${"start".$_i."_1"});
	${"end".$_i."_1"} = sprintf('%02d',${"end".$_i."_1"});
	${"start".$_i."_2"} = sprintf('%02d',${"start".$_i."_2"});
	${"end".$_i."_2"} = sprintf('%02d',${"end".$_i."_2"});
	${"start_".$_i} = $class_year.$class_month.$class_day.${"start".$_i."_1"}.${"start".$_i."_2"}.'00';
	${"end_".$_i} 	= $class_year.$class_month.$class_day.${"end".$_i."_1"}.${"end".$_i."_2"}.'00';
	${"mentors_".$_i} 	= ${"mentor_name_".$_i}."%%%".${"mentor_".$_i};
}

// 이미지 첨부 관련
$tmpname	= $_FILES['img']['tmp_name'];
$realname	= $_FILES['img']['name'];
$fileExt	= strtolower(getExt($realname));
if (is_uploaded_file($tmpname))
{
	$upload		= strtolower($realname);
	$saveFile	= $g['path_root'].'files/_etc/group/'.$d_regis."_".$upload;
	if (strstr($realname,'.ph')||strstr($realname,'.ht')||strstr($realname,'.in'))
	{
		getLink('','','PHP 관련파일은 직접 등록할 수 없습니다. ','');
	}

	$img_data = getimagesize($tmpname);
	if ($img_data[0] > 800 || $img_data[1] > 800)
	{
		getLink('','','이미지 파일은 가로 800px 세로 800px을 넘을 수 없습니다.','');
	}

	if (is_file($g['path_root'].'files/_etc/group/'.$d_regis."_".$upload))
	{
		unlink($g['path_root'].'files/_etc/group/'.$d_regis."_".$upload);
	}

	move_uploaded_file($tmpname,$saveFile);
	$upload = $d_regis."_".$upload;
	@chmod($saveFile,0707);

	// 기존 파일이 있다면 삭제
	if($before_img) unlink($g['path_root'].'files/_etc/group/'.$before_img);
}
else {
	$upload	= $before_img;
}

if($apply_seq) getDbUpdate('rb_dalkkum_group','apply_seq=NULL','apply_seq='.$apply_seq);

// 기존 글이면 업데이트 / 아니면 새로 insert
if ($uid)
{
	$QVAL = "sc_seq='".$sc_seq."',apply_seq='".$apply_seq."',program_seq='".$program_seq."',name='".$name."',img='".$upload."',class_date='".$class_date."',select_hour='".$select_hour."',date_start='".$date_start."',date_end='".$date_end."',use_second='".$use_second."',date_start2='".$date_start2."',date_end2='".$date_end2."',start_1='".$start_1."',end_1='".$end_1."',start_2='".$start_2."',end_2='".$end_2."',start_3='".$start_3."',end_3='".$end_3."',start_4='".$start_4."',end_4='".$end_4."',start_5='".$start_5."',end_5='".$end_5."',start_6='".$start_6."',end_6='".$end_6."',start_7='".$start_7."',end_7='".$end_7."',start_8='".$start_8."',end_8='".$end_8."',start_9='".$start_9."',end_9='".$end_9."',start_10='".$start_10."',end_10='".$end_10."',mentor_1='".$mentors_1."',mentor_2='".$mentors_2."',mentor_3='".$mentors_3."',mentor_4='".$mentors_4."',mentor_5='".$mentors_5."',mentor_6='".$mentors_6."',mentor_7='".$mentors_7."',mentor_8='".$mentors_8."',mentor_9='".$mentors_9."',mentor_10='".$mentors_10."',address='".$address."',address_detail='".$address_detail."',grp_lat='".$grp_lat."',grp_long='".$grp_long."'";
	getDbUpdate('rb_dalkkum_group',$QVAL,'uid='.$uid);

	for($_li = 1; $_li < 11; $_li++){
		$_delwhere = "";
		$_is_class_array = array();
		unset($_temp);
		$_temp = explode('%%%', ${"mentors_".$_li});
		$_temp = explode('|', $_temp[1]);
		for($_li2 = 0; $_li2 < sizeof($_temp); $_li2++){
			$temp = explode(',', $_temp[$_li2]);
			if($temp[0] && $temp[1] && $temp[2]) {
				unset($_is_class,$is_class,$_QKEY,$_QVAL);
				$_is_class = db_query("select uid from rb_dalkkum_team where group_seq=".$uid." and class_time=".$_li." and mentor_seq=".$temp[0], $DB_CONNECT);
				if($_is_class) {$is_class = db_fetch_assoc($_is_class); array_push($_is_class_array, $is_class['uid']); }
				if($is_class['uid']){
					$_QVAL = "group_seq='".$uid."',job_seq='".$temp[1]."',class_time='".$_li."',mentor_seq='".$temp[0]."',limits='".$temp[2]."',limits2='".$temp[3]."'";
					getDbUpdate('rb_dalkkum_team',$_QVAL,'uid='.$is_class['uid']);
				}
				else{
					// 없으면 생성
					$_QKEY = "group_seq,job_seq,class_time,mentor_seq,limits";
					$_QVAL = "'$uid','".$temp[1]."',".$_li.",'".$temp[0]."','".$temp[2]."'";
					getDbInsert('rb_dalkkum_team',$_QKEY,$_QVAL);	
				}
				$_delwhere .= " or (mentor_seq=".$temp[0].")";

			}
			unset($temp);
		}
			if(!${"mentors_".$_li}) {
				db_query("delete from rb_dalkkum_team where group_seq=".$uid." and class_time=".$_li,$DB_CONNECT);
			}
		db_query("delete from rb_dalkkum_team where group_seq=".$uid." and class_time=".$_li." and not(".substr($_delwhere, 4).")",$DB_CONNECT);
	}

	// apply_seq 있다면 연동된 정보도 수정
	if($apply_seq){ 
		$a_times = array();
		for ($_i=1; $_i <= $select_hour; $_i++) { 
			array_push($a_times, ${'start'.$_i.'_1'}.${'start'.$_i.'_2'}.${'end'.$_i.'_1'}.${'end'.$_i.'_2'});
		}
		$a_times = implode('|', $a_times);
		$_update = "group_seq=".$uid.",a_group='".$sc_name."',address='".$address."',address_detail='".$address_detail."',a_lat='".$grp_lat."', program='".$program_seq."', a_long='".$grp_long."', start_date='".substr($date_start,0,8).$start1_1.$start1_2."',end_date='".substr($date_start,0,8).${'end'.$select_hour.'_1'}.${'end'.$select_hour.'_2'}."', many_times='".$select_hour."', times='".$a_times."'";
		getDbUpdate('rb_dalkkum_eventapply',$_update,'uid='.$apply_seq);
	}
}
else {
	$QKEY = "sc_seq,apply_seq,program_seq,name,img,class_date,select_hour,date_start,date_end,date_start2,date_end2,use_second,start_1,end_1,start_2,end_2,start_3,end_3,start_4,end_4,start_5,end_5,start_6,end_6,start_7,end_7,start_8,end_8,start_9,end_9,start_10,end_10,mentor_1,mentor_2,mentor_3,mentor_4,mentor_5,mentor_6,mentor_7,mentor_8,mentor_9,mentor_10,grp_lat,grp_long,address,address_detail";
	$QVAL = "'$sc_seq','$apply_seq','$program_seq','$name','$upload','$class_date','$select_hour','$date_start','$date_end','$date_start2','$date_end2','$use_second','$start_1','$end_1','$start_2','$end_2','$start_3','$end_3','$start_4','$end_4','$start_5','$end_5','$start_6','$end_6','$start_7','$end_7','$start_8','$end_8','$start_9','$end_9','$start_10','$end_10','$mentors_1','$mentors_2','$mentors_3','$mentors_4','$mentors_5','$mentors_6','$mentors_7','$mentors_8','$mentors_9','$mentors_10','$grp_lat','$grp_long','$address','$address_detail'";

	getDbInsert('rb_dalkkum_group',$QKEY,$QVAL);
	
	// 멘토 입력정보 team insert를 위한 정리
	$makeuid = db_insert_id($DB_CONNECT);
	for($_li = 1; $_li < 11; $_li++){
		$_temp = explode('|', ${"mentor_".$_li});
		for($_li2 = 0; $_li2 < 3; $_li2++){
			$temp = explode(',', $_temp[$_li2]);
			if($temp[0] && $temp[1] && $temp[2] && $temp[3]) {
				$_QKEY = "group_seq,job_seq,class_time,mentor_seq,limits,limits2";
				$_QVAL = "'$makeuid','".$temp[1]."',".$_li.",'".$temp[0]."','".$temp[2]."','".$temp[3]."'";
				getDbInsert('rb_dalkkum_team',$_QKEY,$_QVAL);	
			}
			unset($temp);
		}
	}

	// apply_seq 있다면 연동된 정보도 수정
	if($apply_seq) getDbUpdate('rb_dalkkum_eventapply','group_seq='.$makeuid,'uid='.$apply_seq);

}

// 새로고침
getLink('reload','parent.', '완료되었습니다.' , $history);
?>