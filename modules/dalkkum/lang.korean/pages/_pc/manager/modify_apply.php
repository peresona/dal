<?php
	if(!defined('__KIMS__') || !$group) exit;
	checkAdmin(0);
	$_Group = getUidData('rb_dalkkum_group',$group);
	$_STU = getUidData('rb_dalkkum_applyable',trim($applier));
	$_STU2 = db_query("select A.*,AA.sc_grade,AA.sc_class,AA.sc_num,AA.name,AA.tel,AA.email from rb_dalkkum_apply as A, rb_dalkkum_applyable as AA where A.able_seq=AA.uid and A.group_seq=".trim($group)." and A.able_seq=".trim($applier),$DB_CONNECT);
	$NUM = db_num_rows($_STU2);
	$DATA2 = db_fetch_array($_STU2);
?>
<div id="select_sc">
	<div class="header">
		<h1>신청 내역 조회</h1>
		<div class="guide">
		학생이 신청한 과목들을 조회 할 수 있습니다.
		</div>
		<div class="clear"></div>
	</div>
	<div class="line1"></div>
	<div class="line2"></div>
	<div class="line3"></div>

	<div class="content">
		<div class="list">
			<table width="100%">
				<tr>
					<th colspan="4" style="line-height: 30px; height: 30px;"><font size="3"><?=$_STU['sc_grade']?>학년 <?=$_STU['sc_class']?>반 <?=$_STU['sc_num']?>번 <?=$_STU['name']?> (수강신청 진행률 : <?=sprintf("%2.0f",($DATA2['nows']/$_Group['select_hour'])*100);?>%)</font></th>
				</tr>
				<tr>
					<th width="10%">교시</th>
					<th width="35%">멘토</th>
					<th width="35%">직업</th>
					<th width="20%">관리</th>
				</tr>
				<?php for($listi=1; $listi <= 10; $listi++ ):
				$_query = "select T.uid, T.class_time,T.nows, M.name, J.name as jobName from rb_dalkkum_team as T, rb_s_mbrdata as M, rb_dalkkum_job as J where T.job_seq=J.uid and T.mentor_seq=M.memberuid and T.uid=".$DATA2['class_'.$listi];
				$_temp = db_fetch_array(db_query($_query,$DB_CONNECT));
				
				?>
				<tr>
					<td><?=$_temp['class_time']?></td>
					<td><?=$_temp['name']?></td>
					<td><?=$_temp['jobName']?></td>
					<td>
						<?php if($_Group['select_hour']>=$listi):?>
							<?php if($_temp['uid']):?><a href="#" onclick="javascript:OpenWindow('/?r=home&iframe=Y&m=dalkkum&front=manager&page=modify_apply2&group=<?=$_Group[uid]?>&applier=<?=trim($applier)?>&classtime=<?=$listi?>');"><span class="btnblue">수정</span></a>
							<?php else:?>
							<a href="#" onclick="javascript:OpenWindow('/?r=home&iframe=Y&m=dalkkum&front=manager&page=modify_apply2&act=apply&group=<?=$_Group[uid]?>&applier=<?=trim($applier)?>&classtime=<?=$listi?>');"><span class="btnblue">등록</span></a>
							<?php endif;?>
						<?php endif; ?>
						<?if($_temp['uid']):?>
							<a href="#" onclick="delete_mentor('<?=$_temp['uid']?>','<?=$_temp['class_time']?>');"><span class="btnblue">삭제</span></a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endfor;?>
			</table>

		</div>
	</div>
	<div class="footer">
		<input type="button" value="닫기" class="btngray" onclick="top.close();">
	</div>
</div>
<script>
top.resizeTo(700,600);

window.onload = function(){
	window.document.body.scroll = "auto";
}

function delete_mentor(apply_team,apply_time){
	if(confirm('삭제하시겠습니까?')){
			var form_data = {
				act: 'cancel',
				mode: 'super_modify',
				apply_time: apply_time,
				apply_team: apply_team,
				group: '<?=$group?>',
				applier: '<?=$applier?>',
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
						}
				}
			});
		}
	}
</script>


<?php exit; ?>