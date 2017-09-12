<?php
	if(!defined('__KIMS__')) exit;
	checkAdmin(0);
	// 정보 가져오기
	$_Group = getUidData('rb_dalkkum_group',trim($group));
	$_STU = getUidData('rb_dalkkum_applyable',trim($applier));
	$_A = getDbData('rb_dalkkum_apply','group_seq='.$group.' and able_seq='.trim($applier),'*');
	$_T = getUidData('rb_dalkkum_team',trim($_A['class_'.$classtime]));

	// 명단 가져오기
	$_sql = "select T.uid,T.nows,T.limits,M.name,J.name as jobName,M.photo from rb_dalkkum_team as T, rb_s_mbrdata as M, rb_dalkkum_job as J where T.mentor_seq = M.memberuid and T.job_seq = J.uid and T.group_seq=".trim($group)." and T.class_time=".trim($classtime)." and T.nows<T.limits";
	if($_A)$_sql .= " and not(T.uid=".$_A['class_'.$classtime].")";
	$listData = db_query($_sql,$DB_CONNECT);

?>
	<div id="select_sc">
		<div class="header">
			<h1>과목 수정</h1>
			<div class="guide">
			선택한 학생의 과목을 수정 할 수 있습니다.
			</div>
			<div class="clear"></div>
		</div>
		<div class="line1"></div>
		<div class="line2"></div>
		<div class="line3"></div>
<div class="cl">
	<div style="margin:20px 20px 0 0; float: right;">
<font size="2"><?=$_STU['sc_grade']?>학년 <?=$_STU['sc_class']?>반 <?=$_STU['sc_num']?>번 <?=$_STU['name']?> <b><?=$classtime?>교시 멘토 수정</b> <br>
<?=$classtime?>교시 기존 멘토 : <b><?php if($_T['mentor_seq'] && $_T['job_seq']) echo getName($_T[mentor_seq])."(".getJobName($_T[job_seq]).")";
 else echo '없음'; ?> </b>

</font>
	</div>
</div>
<div class="cl" style="padding-left: 20px;"><b>변경 가능한 멘토 목록</b></div>
<form name="selectForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);" enctype="multipart/form-data">
		<div class="content">
			<div class="list">
			<?php while ($SCD = db_fetch_array($listData)):?>
					<div class="mentors">
						<a class="mentors_blink" onclick="change_mentor('<?=$SCD[uid]?>')"></a>
						<input type="checkbox" name="selects[]" value="<?=$SCD['uid']?>" data-names="<?=$SCD['name']?>" data-jobs="<?=$SCD['job']?>">
						<span class="pic" style="background:url('<?php if($SCD['photo']):?>/_var/simbol/180.<?=$SCD['photo']?><?php else:?>/_var/simbol/180.default.jpg<?php endif?>') center center no-repeat; background-size: 130%; "></span><?=$SCD['name']?> 멘토<br><font color="#666"><?=$SCD['jobName']?></font>
					</div>
			<?php endwhile;?>
			</div>
			<div class="none">
				<img src="/_core/image/_public/ico_notice.gif" alt="">
				등록된 멘토가 없습니다.
			</div>
		</div>
		<div class="footer">
			<input type="hidden" id="mentor_names" value="">
			<input type="hidden" id="mentor_result" value="">
			<input type="button" value="취소(닫기)" class="btngray" onclick="top.close();">
		</div>
	</div>
<script>
top.resizeTo(700,700);
window.onload = function(){
	window.document.body.scroll = "auto";
}
var last_names = document.getElementById("mentor_names");
var last_result = document.getElementById("mentor_result");

function reset_search(){
	document.searchbox.keyword.value="";
	document.searchbox.search.value="";
	document.searchbox.submit();
}

function change_mentor(team){
	if(confirm('선택한 멘토로 변경하시겠습니까?')){
		var form_data = {
			act: '<?=(($_T['mentor_seq'] && $_T['job_seq'])?'modify':'apply')?>',
			mode: 'super_modify',
			apply_time: '<?=$classtime?>',
			group: '<?=$group?>',
			applier: '<?=$applier?>',
			apply_team: team,
		};
		$.ajax({
			type: "POST",
			url: "/?r=home&m=dalkkum&a=actionApply",
			data: form_data,
			success: function(response) {
					var results = $.parseJSON(response);
					alert(results.msg);
					if(results.code=='100') {
						location.reload();
						opener.location.reload();
						opener.opener.location.reload();
						opener.opener.opener.location.reload();
					}
			}
		});

	}
}


// 파라미터 : 교시, 
function select_mentor(target_mytime){
	opener.document.procForm.mentor_name_<?=$_GET['mytime']?>.value=last_names.value;
	opener.document.procForm.mentor_<?=$_GET['mytime']?>.value=last_result.value;
	top.close();
}


</script>
<?php exit; ?>