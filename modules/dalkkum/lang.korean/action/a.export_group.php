<?php
	if(!defined('__KIMS__')) exit;
	checkAdmin(0);
	header("Content-Type: text/html; charset=UTF-8");
	$_SCD = db_query("select * from rb_dalkkum_applyable as AA LEFT JOIN rb_dalkkum_apply as A on A.able_seq=AA.uid where AA.group_seq=".$uid,$DB_CONNECT);
	$_Group = getUidData('rb_dalkkum_group',$uid);
	
	if(!$mode=='web'){
		header( "Content-type: application/vnd.ms-excel; charset=euc-kr" );
		header( "Expires: 0" );
		header( "Cache-Control: must-revalidate, post-check=0,pre-check=0" );
		header( "Pragma: public" );
		header( "Content-Disposition: attachment; filename=".$date['totime']."_".$_Group['uid'].".xls" );
	}else {
		echo "<script>top.resizeTo(900,600);</script>";
	}
?>
<meta name=ProgId content=Excel.Sheet> 
<meta name=Generator content="Microsoft Excel 11">
<style type="text/css">
body {margin:10px; min-width:800px; font-family: '돋움'}
table {min-width:100%; border:1px solid black; border-collapse:collapse; text-align: center;}
th {background-color: #ddd;}
td, th { border:1px solid black;  text-align: center; font-size: 12px; height: 30px;}
</style>
<?php
$Num_Y = 0;
$Num_NY = 0;
$Num_N = 0;
?>
<table border="1">
	<tr>
		<th colspan="<?=($_Group['select_hour']+7)?>"><?=$_Group['name']?> 신청현황(<?=getDateView($date['totime'],'-')?>)<?php if($mode=='web'):?> - <a href="javascript:window.print()">인쇄</a><?php endif; ?></th>
	</tr>
	<tr>
		<td width="40">학년</td>
		<td width="40">반</td>
		<td width="40">번호</td>
		<td width="100">이름</td>
		<td width="100">전화번호</td>
		<td width="160">이메일</td>
		<td width="100">신청여부</td>
		<?php for($i=1; $i <= $_Group['select_hour']; $i++):?>
		<td width="100"><?=$i?>교시</td>
		<?php endfor; ?>
	</tr>
	<?php while ($_SC = db_fetch_array($_SCD)):?>
	<tr>
		<td><?=$_SC['sc_grade']?></td>
		<td><?=$_SC['sc_class']?></td>
		<td><?=$_SC['sc_num']?></td>
		<td><?=$_SC['name']?></td>
		<td><?=$_SC['tel']?>&nbsp;</td>
		<td><?=$_SC['email']?></td>
		<td><b>
		<?php if(!$_SC['nows'] || $_SC['nows']=='0'):$Num_N++; ?>
			<font color="red">N</font>
		<?php elseif($_Group['select_hour'] == $_SC['nows']):$Num_Y++; ?>
			<font color="blue">Y</font>
		<?php else:$Num_NY++; ?>
			<font color="green">NY</font>
		<?php endif; ?></b>
		</td>
		<?php for($i=1; $i <= $_Group['select_hour']; $i++):?>
		<td><?php
		 $TD = getUidData('rb_dalkkum_team',$_SC['class_'.$i]);
		 if($TD['mentor_seq'] && $TD['job_seq']){
		 	echo getName($TD['mentor_seq'])."(".getJobName($TD['job_seq']).")";
		 }
		?></td>
		<?php endfor; ?>
	</tr>
	<?php endwhile;?>
	<tr>
		<th colspan="<?=($_Group['select_hour']+7)?>"><?=$_Group['name']?> / <?=$date['totime']?> / 완료 : <?=$Num_Y ?> / 진행중 : <?=$Num_NY ?> / 미지원 : <?=$Num_N ?><?php if($mode=='web'):?> / <a href="javascript:window.print()">인쇄</a><?php endif; ?></th>
	</tr>
</table>
<script>
window.onload = function(){
	window.document.body.scroll = "auto";
}
</script>
<?php exit; ?>