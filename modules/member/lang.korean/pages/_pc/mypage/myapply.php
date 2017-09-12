<?php
		if(!$my['sc_grade'] || !$my['sc_class'] || !$my['sc_num'] ) getLink('','', '정보수정에서 학생정보를 기입 후 다시 조회해주세요.' , '-1');
		$gid = trim($gid);
		$is_my_group = getDbRows('rb_dalkkum_applyable','group_seq='.$gid.' and sc_grade='.$my['sc_grade'].' and sc_class='.$my['sc_class'].' and sc_num='.$my['sc_num'].' and name="'.$my['name'].'"');
		// 권한 검사
		if(!$is_my_group && $gid) getLink('','', '해당 그룹에 수강신청 권한이 없습니다.' , '-1');

		// 정보들 담기
		$_Group = getUidData('rb_dalkkum_group',$gid);


		// 취소 버튼을 위한 현재 수강신청 기간 여부
		$_nowapplyable = ($_Group['apply_start']=='Y' && $_Group['finish'] == 'N' && ($_Group['date_start'] < $date['totime']) && ($_Group['date_end'] > $date['totime']));
		// 수강신청 리스트
		$myStdUid = db_query("select G.uid,G.name as group_name,SC.name as sc_name,AA.name as std_name
from rb_dalkkum_applyable as AA, rb_dalkkum_apply as A, rb_dalkkum_sclist as SC, rb_dalkkum_group as G
where AA.group_seq = G.uid and AA.group_seq = A.group_seq and SC.uid = G.sc_seq and A.able_seq = AA.uid and AA.name = '".$my['name']."' and SC.name = '".$my['sc_name']."' and AA.sc_grade=".$my['sc_grade']." and AA.sc_class=".$my['sc_class']." and AA.sc_num=".$my['sc_num'],$DB_CONNECT);
	?>
<?php if($gid):
		$_ALIST = db_fetch_array(db_query('select A.* from rb_dalkkum_applyable as AA, rb_dalkkum_apply as A where AA.uid = A.able_seq and AA.group_seq='.$gid.' and AA.sc_grade='.$my['sc_grade'].' and AA.sc_class='.$my['sc_class'].' and AA.sc_num='.$my['sc_num'].' and AA.name="'.$my['name'].'"',$DB_CONNECT));
		
		// 수강신청 취소 이용을 위한 세션 생성
		$_SESSION['stdinfo']['uid'] = $_ALIST['able_seq'];
		$_SESSION['stdinfo']['group'] = $gid;
?>
<div id="pages_join">
	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="pw_update" />
	</form>
	<div class="cl">
		<h2 class="apply fl">수강신청내역 (<?=$_Group['name']?> <?=$my['sc_grade']?>학년 <?=$my['sc_class']?>반 <?=$my['sc_num']?>번 <?=$my['name']?>)</h2>
		<div class="fr">
		<select name="view_group" id="view_group" data-act="select_group">
			<option value="">나의 수강신청</option>
			<?php
			 while ($_MAL = db_fetch_array($myStdUid)) :
			 ?>
			<option value="<?=$_MAL['uid']?>"<?php if($_MAL['uid']==$gid):?> selected="selected"<?php endif ?>><?=$_MAL['sc_name']." ".$_MAL['group_name']?></option>
			<?php endwhile;?>
		</select>
		</div>
	</div>
	<div class="cl orangebox">
		<div class="fl">신청기간<span class="inline-text"><?=getDateView($_Group['date_start'], '-')?> ~ <?=getDateView($_Group['date_end'], '-')?></span></div>
		<div class="fr red bold">※ 수강신청 기간이 아닐 때에는 수강신청 변경/취소가 불가합니다.</div>
	</div>
	<div class="cl boxing">
		<table id="myapply" width="100%" border="1">
				<tbody>
					<tr>
						<th class="bold" width="30%">수강</th>
						<th class="bold" width="30%">직업</th>
						<th class="bold" width="30%">멘토</th>
						<th class="bold" width="10%"></th>
					</tr>
					<?php for($ai=1, $ai_count=1; $ai <= $_Group['select_hour']; $ai++):
						$_TDB = db_fetch_array(db_query('select * from rb_dalkkum_team where uid='.$_ALIST['class_'.$ai],$DB_CONNECT));
						if($_TDB):$ai_count++;
					?>
					<tr data-myapply_line="<?=$ai?>-<?=$_TDB['uid']?>">
						<td><?=$ai?>교시</td>
						<td><?=getJobName($_TDB['job_seq'])?></td>
						<td><?=getName($_TDB['mentor_seq'])?></td>
						<td><?php if($_nowapplyable):?><input type="button" class="black_cancel cp" value="취소" data-cancelteam="<?=$_TDB['uid']?>" data-canceltime="<?=$ai?>"><?php endif; ?></td>
					</tr>
					<?php endif; endfor; if($ai_count=='1'):?>
					<tr>
						<td colspan="4">신청한 목록이 없습니다.</td>
					</tr>
					<?php endif;?>
			</tbody>
		</table>
	</div>
</div>
<?php else: ?>
<div id="pages_join">
	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="pw_update" />
	</form>
	<div class="cl">
		<h2 class="apply fl">수강신청내역</h2>
		<div class="fr">
		<select name="view_group" data-act="select_group" id="view_group">
			<option value="">나의 수강신청</option>
			<?php
			 while ($_MAL = db_fetch_array($myStdUid)) :
			 ?>
			<option value="<?=$_MAL['uid']?>"><?=$_MAL['sc_name']." ".$_MAL['group_name']?></option>
			<?php endwhile;?>
		</select>
		</div>
	</div>
	<div class="cl orangebox center bold" style=" line-height: 300px; height:300px; font-size: 20px;">
		조회할 수강신청을 선택해주세요.
	</div>
</div>
<?php endif?>

<script type="text/javascript">
//<![CDATA[

function cancel_apply(apply_time,apply_team){
		var form_data = {
			act: 'cancel',
			apply_time: apply_time,
			apply_team: apply_team,
		};
		$.ajax({
			type: "POST",
			url: "/?r=home&m=dalkkum&a=actionApply",
			data: form_data,
			success: function(response) {
				var results = $.parseJSON(response);
					alert(results.msg);
					if(results.code=='100') {
						$('tr[data-myapply_line="'+apply_time+'-'+apply_team+'"]').remove();
					}
			}
		});
}
function saveCheck(f)
{
	if (f.pw.value == '')
	{
		alert('현재 패스워드를 입력해 주세요.');
		f.pw.focus();
		return false;
	}

	if (f.pw1.value == '')
	{
		alert('변경할 패스워드를 입력해 주세요.');
		f.pw1.focus();
		return false;
	}
	if (f.pw2.value == '')
	{
		alert('변경할 패스워드를 한번더 입력해 주세요.');
		f.pw2.focus();
		return false;
	}
	if (f.pw1.value != f.pw2.value)
	{
		alert('변경할 패스워드가 일치하지 않습니다.');
		f.pw1.focus();
		return false;
	}

	if (f.pw.value == f.pw1.value)
	{
		alert('현재 패스워드와 변경할 패스워드가 같습니다.');
		f.pw1.value = '';
		f.pw2.value = '';
		f.pw1.focus();
		return false;
	}

	return confirm('정말로 수정하시겠습니까?       ');
}
$(document).ready(function(){
	// 취소하기 버튼
	$('[data-cancelteam][data-canceltime]').on('click',function(){
		apply_time = $(this).data('canceltime');
		apply_team = $(this).data('cancelteam');
		if(confirm('해당 과목을 취소하시겠습니까?')){
			cancel_apply(apply_time,apply_team);
		}
	});
	$('[data-act="select_group"]').on('change',function(){
		select_group = $(this).val();
		location.href = "/?mod=mypage&page=myapply&gid="+select_group;
	});
});

//]]>
</script>




