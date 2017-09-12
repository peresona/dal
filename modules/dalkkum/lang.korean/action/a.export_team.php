<style type="text/css">
body {margin:10px; min-width:800px; font-family: '돋움'}
table {min-width:100%; border:1px solid black; border-collapse:collapse; text-align: center;}
th {background-color: #ddd;}
td, th { border:1px solid black;  text-align: center; font-size: 12px; height: 30px; padding: 3px 5px;}

.left {text-align: left;}
.right {text-align: right;}
.center {text-align: center;}
</style>
<?php
	if(!defined('__KIMS__')) exit;
	
	$_Group = db_fetch_array(db_query("select T.*,G.name as title,G.use_second,G.date_start2,G.date_end2,G.uid as groupUid,G.class_date as classDate, SC.name as schoolName, M.name as mentorName, J.name as jobName from rb_dalkkum_team as T, rb_dalkkum_group as G, rb_dalkkum_sclist as SC, rb_s_mbrdata as M, rb_dalkkum_job as J
where M.memberuid=T.mentor_seq and G.sc_seq=SC.uid and G.uid=T.group_seq and T.job_seq = J.uid and T.uid=".trim($uid), $DB_CONNECT));

	if($my['admin']!="1" && $_Group['mentor_seq'] != $my['memberuid']) getLink('','','권한이 없습니다.','-1');

	if(!$mode=='web'){
		header("Content-type: application/vnd.ms-excel; charset=euc-kr");
		header("Content-Description: PHP4 Generated Data");
		header("Content-Disposition: attachment; filename=".$date['totime']."_".$_Group['uid'].".xls");
		print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");
		
	}else {
		header("Content-Type: text/html; charset=UTF-8");
		echo "<script>top.resizeTo(900,600);</script>";
	}
	
	if(($_Group['use_second']=='Y') && ($_Group['date_start2']<=$date['totime']) && ($date['totime'] <= $_Group['date_end2'])) $_max_limits = $_Group['limits'] + $_Group['limits2'];
		else $_max_limits = $_Group['limits']; 


	// 현재 수 구하기
	$_check_nows = getDbRows('rb_dalkkum_apply','group_seq='.$_Group['groupUid'].' and class_'.$_Group['class_time'].'='.$uid);
?>
<table border="1">
<?php if($mode=="web"):?>
		<th class="center" colspan="6"><a href="javascript:window.print()">인쇄</a></th>
<?php endif; ?>
	<tr>
		<th class="left" colspan="6">학교명 : <?=$_Group['schoolName']?></th>
	</tr>
	<tr>
		<th class="left" colspan="6">그룹명 : <?=$_Group['title']?></th>
	</tr>
	<tr>
		<th class="left" colspan="6">강사명 : <?=$_Group['mentorName']?> 멘토 (<?=$_Group['jobName']?>)<?php if($my['admin']=='1'):?> <input type="button" value="멘토 교체" onclick='change_mentor();'><?php endif; ?></th>
	</tr>
	<tr>
		<th class="left" colspan="6">신청 수 : <?=(($_check_nows>$_Group['limits'])?'<font color="red">'.$_check_nows.'명</font>':$_check_nows.'명')?> / <?=$_max_limits?>명</th>
	</tr>
	<tr>
		<th class="left" colspan="6">수업일시 : <?=getDateView($_Group['classDate'],'-')." (".$_Group['class_time']?>교시)</th>
	</tr>
	<tr>
		<th class="center" colspan="6">학생 정보</th>
	</tr>
	<tr>
		<th width="30">순번</th>
		<th width="60">학년</th>
		<th width="60">반</th>
		<th width="60">번호</th>
		<th>이름</th>
		<th>이메일</th>
	</tr>
	<?php
	$_sql = "select AA.* from rb_dalkkum_apply as A, rb_dalkkum_applyable as AA where AA.uid=A.able_seq and A.class_".$_Group['class_time']."=".trim($uid)." order by AA.sc_grade, AA.sc_class, AA.sc_num asc";
	$_sql = db_query($_sql, $DB_CONNECT);
	$i = 0;
	 while($_STDL = db_fetch_array($_sql)): $i++; ?>
	<tr>
		<td><?=$i?></td>
		<td><?=$_STDL['sc_grade']?></td>
		<td><?=$_STDL['sc_class']?></td>
		<td><?=$_STDL['sc_num']?></td>
		<td><?=$_STDL['name']?></td>
		<td><?=$_STDL['email']?></td>
	</tr>
	<?php endwhile;
	if($i == 0): ?>
	<tr>
		<td colspan="6">이 과목의 수강 신청자가 없습니다.</td>
	</tr>
	<?php endif; ?>
</table>

<script>
window.onload = function(){
	window.document.body.scroll = "auto";
}

function change_mentor(){
	window.open("/?r=home&iframe=Y&m=dalkkum&front=manager&page=select_mentor_mini&tid=<?=$uid?>", "myWindow", "width=600,height=500"); 
}
</script>
<?php exit; ?>