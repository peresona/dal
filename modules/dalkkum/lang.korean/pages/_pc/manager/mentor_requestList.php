<?php
	if(!defined('__KIMS__') || !$group) exit;
	checkAdmin(0);
	$GD = getUidData('rb_dalkkum_group',$group);
	$_query = "select M.addr_lat,M.addr_long, SQRT(power(".$GD['grp_lat']."-M.addr_lat,2)+power(".$GD['grp_long']."-M.addr_long,2)) as distance, (

	select count(*)
from rb_dalkkum_request RR, rb_s_mbrdata RM 
where RR.mentor_seq=RM.memberuid and RR.job_seq=R.job_seq and RR.group_seq=".$group." and SQRT(power(".$GD['grp_lat']."-RM.addr_lat,2)+power(".$GD['grp_long']."-RM.addr_long,2)) < distance

)+1 as ranks, R.*,M.name, M.mentor_grade, M.mentor_score, M.email,J.name as job
from rb_s_mbrdata as M, rb_dalkkum_request as R, rb_dalkkum_job as J 
where M.memberuid=R.mentor_seq and M.mentor_job = J.uid and R.group_seq=".$group." order by field(R.agree,'Y') desc, R.job_seq asc ,distance asc";
	$_SCD = db_query($_query,$DB_CONNECT);
	$NUM = db_num_rows($_SCD);
	$many['push'] = getDbRows('rb_dalkkum_request',"group_seq=".$group." and push_go='Y'");

	$many['yes'] = getDbRows('rb_dalkkum_request',"group_seq=".$group." and agree='Y'");
	$many['no'] = getDbRows('rb_dalkkum_request',"group_seq=".$group." and agree='N'"); 
	$many['not'] = $many['push']-$many['yes']-$many['no'];

	$many['all'] = getDbRows('rb_dalkkum_request',"group_seq=".$group);
	$many['standby'] = $many['all'] - $many['push'];
	$gradeName = array('','E','D','C','B','A');
?>
	<form name="selectForm" action="<?php echo $g['s']?>/" target="actionFrame" method="post" onsubmit="return checkMax_mentor();">
		<input type="hidden" name="r" value="home" />
		<input type="hidden" name="m" value="dalkkum" />
		<input type="hidden" name="a" value="actionGroup" />
		<input type="hidden" name="act" value="request" />
		<input type="hidden" name="iframe" value="Y" />
		<input type="hidden" name="group" value="<?=$group?>" />
<div id="select_sc">
	<div class="header">
		<h1>멘토 모집 요청 목록</h1>
		<div class="guide">
		요청된 멘토 모집 리스트입니다.
		</div>
		<div class="clear"></div>
	</div>
	<div class="line1"></div>
	<div class="line2"></div>
	<div class="line3"></div>

	<div class="content">
	<?php if($NUM>0):?>
		<div class="list">
		<div class="cl" style="text-align: center; margin-bottom: 10px;">이 그룹은 현재 <b><?=$many['push']?>명</b>의 멘토에게 요청이 전송되었습니다. (푸시대기 : <b><?=$many['standby']?>명</b> / 수락 : <b><?=$many['yes']?>명</b> / 미응답 : <b><?=$many['not']?>명</b> / 거절 : <b><?=$many['no']?>명</b>)</div>
				<table>
					<tr data-open="">
						<th width="20%">이름(등급) / 직업</th>
						<th width="15%">강의료 / 전화번호</th>
						<th width="15%">등급 / 이메일</th>
						<th width="10%">우선순위</th>
						<th>상태 / 이메일</th>
						<th width="15%">관리 / 주소</th>
					</tr>
			<?php while($SCD = db_fetch_assoc($_SCD)):
			?>
					<tr>
						<td data-open="<?=$SCD['uid']?>" style="cursor: pointer;"><b><?=($SCD['name']?$SCD['name']:'-')?><?=($SCD['job']?'('.$SCD['job'].')':'')?></td>
						<td><?=($SCD['cash']?$SCD['cash']:'0')?>원</td>
						<td>	<?=$gradeName[$SCD['mentor_grade']].' / '.$SCD['mentor_score']?></td>
						<td><?=$SCD['ranks']?></td>
						<td><?php if($SCD['agree']=='Y') echo "<font color='blue'><b>수락</b></font>";
						else if($SCD['agree']=='N') echo "<font color='red'>거절</font>";
						else if($SCD['agree']=='D' && $SCD['push_go']=='Y') echo "<font color='green'>푸시 발송 (답변 대기)</font>";
						else if($SCD['agree']=='D' && $SCD['push_go']=='E') echo "<font color='green'>연결 기기 없음 (답변 대기)</font>";
						else if($SCD['agree']=='M') echo "마감";
						else if($SCD['agree']=='D') echo "푸시 대기";
						//else if(getDateCal('YmdHis',$SCD['d_regis'],1) <= $date['totime']) echo "마감";
						//else if(getDateCal('YmdHis',$SCD['d_regis'],1) > $date['totime'] && $SCD['push_date'] && $SCD['push_token']) echo "진행중";
						?></td>
							<td>
							<?php if($SCD['agree']=='Y'): ?>
							<input type="button" class="btnblue" value="삭제" onclick="if(confirm('해당 멘토의 답변을 초기화하고, 요청 목록에서 삭제하시겠습니까?')) document.getElementById('actionFrame').src = '/?r=home&m=dalkkum&a=actionGroup&group=<?=$group?>&act=delete_request&uid=<?=$SCD['uid']?>'; ">
							<?php else: ?>
							<input type="button" class="btnblue" value="요청취소" onclick="if(confirm('해당 멘토에게 전송된 요청 질의를 취소하고, 목록에서 삭제하시겠습니까?')) document.getElementById('actionFrame').src = '/?r=home&m=dalkkum&a=actionGroup&group=<?=$group?>&act=delete_request&uid=<?=$SCD['uid']?>';">
							<?php endif; ?>
							</td>
					</tr>
					<tr data-detail="<?=$SCD['uid']?>">
						<td></b></td>
						<td><?=($SCD['tel2']?$SCD['tel2']:'-')?></td>
						<td></td>
						<td><?=getDistance($SCD['addr_lat'],$SCD['addr_long'],$GD['grp_lat'],$GD['grp_long'],2)?></td>
						<td><?=($SCD['email']?$SCD['email']:'-')?></td>
						<td>-</td>
					</tr>
					<tr data-detail="<?=$SCD['uid']?>">
						
							<td colspan="6">
							일시 : <?=getDateFormat($SCD['date_start'],'Y-m-d')?>/ 모집신청 : <?=getDateFormat($SCD['d_regis'],'Y-m-d H:i')?> 
							</td>
					</tr>
					<tr data-detail="<?=$SCD['uid']?>">
						<td colspan="6">
							기타사항 : <?=$SCD['memo']?>
						</td>
					</tr>
			<?php endwhile ?>
				</table>
		</div>
	<?php else : ?>
		<div class="none">
			<img src="/_core/image/_public/ico_notice.gif" alt="">
			선택된 멘토가 없습니다.
		</div>
	<?php endif ?>
	</div>
	<div class="footer">
		<input type="hidden" id="mentor_names" value="">
		<input type="hidden" id="mentor_result" value="">
		자동 푸쉬 상태 : 
		<?php if($GD['push_now']=="Y"): ?>작동중 
		<input type="button" value=" - 자동 푸쉬 정지" class="btnblue" onclick="document.getElementById('actionFrame').src = '/?r=home&m=dalkkum&a=actionGroup&group=<?=$group?>&act=push_status&mode=stop';">
		<?php else: ?>정지
		<input type="button" value=" + 자동 푸쉬 시작" class="btnblue" onclick="document.getElementById('actionFrame').src = '/?r=home&m=dalkkum&a=actionGroup&group=<?=$group?>&act=push_status&mode=play';">
		<?php endif; ?>
		<?php if($GD['recruit']):?>
		<input type="button" value="추가 요청" class="btnblue" onclick="location.href='/?r=home&iframe=Y&m=dalkkum&front=manager&page=select_jobs&group=<?=$group?>'";></a>
		<?php else: ?>
		<a onclick="alert('창 하단에서 모집중인 멘토수를 입력하여 주세요.');"><input type="button" value="추가 요청" class="btnblue"></a>
		<?php endif; ?>
		<input type="button" value="취소(닫기)" class="btngray" onclick="top.close();">
	</div>
</div>
</form>
<div class="cl center">
	<form name="selectForm" action="<?php echo $g['s']?>/" target="actionFrame" method="post">
		<input type="hidden" name="r" value="home" />
		<input type="hidden" name="m" value="dalkkum" />
		<input type="hidden" name="a" value="actionGroup" />
		<input type="hidden" name="act" value="editMaxMentor" />
		<input type="hidden" name="group" value="<?=$group?>" />
				현재 이 그룹에서 모집중인 멘토 수 : <input type="text" id="max_mentor" name="max_mentor" value="<?=$GD['recruit']?>">명 
				<input type="submit" class="btnblue" value="수정하기">
	</form>
</div>
<iframe id="actionFrame" name="actionFrame" frameborder="0" width="0" height="0"></iframe>
<script>
top.resizeTo(900,670);
window.onload = function(){
	window.document.body.scroll = "auto";
}
var last_names = "";
var last_result = "";

function cutLast(find,anychar){
	if(anychar.charAt(anychar.length - 1) == find) return anychar.slice(0,-1);
		else return anychar;
}
function checkMax_mentor(){
	if($('#max_mentor').val() == '0' || !$('#max_mentor').val()){
		alert('아래쪽에 모집중인 멘토 수를 변경해주세요.');
		return false;
	}
}
$(document).ready(function(){
	$('[data-open]').on('click', function(){
		var openNum = $(this).data('open');
		$('[data-detail]').hide();
		if(openNum)	$('[data-detail="'+openNum+'"]').show();
	});
	$('[data-detail]').on('click',function(){
		var closeNum = $(this).data('detail');
		if(closeNum) $('[data-detail="'+closeNum+'"]').hide();
	});
});
</script>
<?php exit; ?>