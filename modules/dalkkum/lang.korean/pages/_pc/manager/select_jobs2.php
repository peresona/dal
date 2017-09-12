<?php 
	if(!defined('__KIMS__') || !$group) exit;	checkAdmin(0);

	$tomember = array(); // 멘토리스트 담을 곳
	$GD = getUidData('rb_dalkkum_group',$group);
	$_where = '';
	if($mentor_grade) $_where .= " and (M.mentor_grade>=".$mentor_grade.")";
	if($mentor_score) $_where .= " and (M.mentor_score>=".$mentor_score.")";
foreach ($selects as $value) {
	global $tomember;
	// 받은 직업군 직업으로 전환 후 멘토 배열만들기
	$howson = getDbSelect('rb_dalkkum_job','hidden=0 and uid='.$value,'uid');
	$temp['group_sum'] = 0;
	while ($HWS = db_fetch_array($howson)) {
		global $temp; $temp['group_sum']++;
		$tm = db_query('select 0 as ranks,M.memberuid,M.name,M.address,M.address_detail,M.mentor_job,M.mentor_grade,M.mentor_score,J.name as jobName,0 as order_score, (pow('.$GD['grp_lat'].' - M.addr_lat,2)+pow('.$GD['grp_long'].'-M.addr_long,2)) as dist
			from rb_s_mbrdata as M, rb_dalkkum_job as J where M.mentor_job = J.uid and M.auth=1 and M.mentor_confirm="Y" and M.mentor_job='.$HWS['uid'].$_where.' order by dist asc, M.follower desc',$DB_CONNECT);
		$tmp_i = 0;
		while ($_R = db_fetch_array($tm)) { $tmp_i++;
			$_R['ranks'] = $tmp_i;
			array_push($tomember, $_R);
		}
	}
}
$tomember = array_sort($tomember, "ranks");
$gradeName = array('','E','D','C','B','A');
 ?>
 <form name="selectForm" action="<?php echo $g['s']?>/?r=home&iframe=Y&m=dalkkum&front=manager" target="_action_frame_admin" method="post" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="dalkkum" />
	<input type="hidden" name="a" value="actionGroup" />
	<input type="hidden" name="act" value="request_many" />
	<input type="hidden" name="group" value="<?=$group?>" />
	 <div id="select_sc">
		<div class="header">
			<h1>모집 멘토 선택</h1>
			<div class="guide">
			제외할 멘토는 체크를 해제해 주시면 됩니다. <br>
			기존 목록에 추가되 있는 인원은 중복제외되어 추가됩니다.
			</div>
			<div class="clear"></div>
		</div>
		<div class="line1"></div>
		<div class="line2"></div>
		<div class="line3"></div>

		<div class="content">
		<!--
			<div class="cl fr">
				<select name="orderby" id="orderby">
					<option value="">우선순위</option>
					<option value="distance">가까운순</option>
					<option value="grade">등급A순</option>
					<option value="score">등급B순</option>
				</select>
			</div>
		-->
		<?php if(count($tomember)>0):?>
			<div class="list">
					<table id="mentorTable" class="tablesorter">
						<thead>
							<tr>
								<th width="50">UID</th>
								<th width="110">멘토 이름</th>
								<th>주소</th>
								<th width="70">우선순위</th>
								<th width="110">직업</th>
								<th width="50">등급A</th>
								<th width="50">등급B</th>
								<th width="50"><input type="checkbox" id="allCheck" checked="checked" onchange="all_checking();">선택</th>
								<th width="110">비고</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($tomember as $R):?>
								<tr>
									<td><?=$R['memberuid']?></td>
									<td><?=$R['name']?></td>
									<td><?=$R['address']?></td>
									<td><?=$R['ranks']?></td>
									<td><?=$R['jobName']?></td>
									<td><?=$gradeName[$R['mentor_grade']]?></td>
									<td><?=$R['mentor_score']?></td>
									<td><input type="checkbox" name="regis[]" value="<?=$R['memberuid']?>-<?=$R['ranks']?>-<?=$R['mentor_job']?>" checked="checked"></td>
									<td></td>
								</tr>
							<?php endforeach ?>
						</tbody>
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
		<!--
				<div class="cl">
					<select name="class_year">
						<?php for($i=$date['year'];$i<$date['year']+3;$i++):?><option value="<?php echo $i?>"<?php if($year3==$i):?> selected="selected"<?php endif?>><?php echo $i?>년</option><?php endfor?>
						</select>
						<select name="class_month">
						<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($month3==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>월</option><?php endfor?>
						</select>
						<select name="class_day">
						<?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($day3==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>일</option><?php endfor?>
					</select>
					<select name="class_start_hour" style="width: 50px;">
						<?php for($i=0; $i<=23; $i++):?>
							<option value="<?=$i?>"<?php if(substr($R['start_'.$e],8,2)==sprintf('%02d',$i)):?> selected="selected"<?php endif;?>><?=sprintf('%02d',$i)?></option>
						<?php endfor;?>
					</select> : 
					<select name="class_start_min" style="width: 50px;">
						<?php for($i=0; $i<=59; $i++):?>
							<option value="<?=$i?>"<?php if(substr($R['start_'.$e],10,2)==sprintf('%02d',$i)):?> selected="selected"<?php endif;?>><?=sprintf('%02d',$i)?></option>
						<?php endfor;?>
					</select> ~ 
					<select name="class_end_hour" style="width: 50px;">
						<?php for($i=0; $i<=23; $i++):?>
							<option value="<?=$i?>"<?php if(substr($R['end_'.$e],8,2)==sprintf('%02d',$i)):?> selected="selected"<?php endif;?>><?=sprintf('%02d',$i)?></option>
						<?php endfor;?>
					</select> : 
					<select name="class_end_min" style="width: 50px;">
						<?php for($i=0; $i<=59; $i++):?>
							<option value="<?=$i?>"<?php if(substr($R['end_'.$e],10,2)==sprintf('%02d',$i)):?> selected="selected"<?php endif;?>><?=sprintf('%02d',$i)?></option>
						<?php endfor;?>
					</select>
				</div>-->
				<div class="cl" style="margin: 10px 0;">
				<input type="text" name="memo"  placeholder="추가 안내사항을 입력해주세요." maxlength="100" style="width: 510px; margin-bottom: 10px; height: 30px; line-height: 30px;"><br>
					<input type="text" class="long" id="select_count" name="select_count" value="<?=$select_count?>" style="width: 50px; text-align: center;" readonly> 직업군 중 <input type="text" id="many_count" name="many_count" value="<?=$many_count?>" class="long" value="<?=$GD['recruit']?>" style="width: 50px; text-align: center;" readonly> 명을 모집중입니다.
				</div>
			<div class="cl">
				<input type="hidden" id="mentor_names" value="">
				<input type="hidden" id="mentor_result" value="">
				<input type="submit" value="선택 인원 예약" class="btnblue">
				<input type="button" value="취소(닫기)" class="btngray" onclick="top.close();">
			</div>
		</div>
	</div>
</form>
<iframe name="_action_frame_admin" width="0" height="0" frameborder="0"></iframe>
<script type="text/javascript" src="/static/jquery.tablesorter.min.js"></script> 
<script>
	top.resizeTo(900,720);

	window.onload = function(){
		window.document.body.scroll = "auto";
	}
	function saveCheck(f)
	{
		if (f.many_count.value == '' || f.many_count.value == '0')
		{
			alert('모집 인원을 기입해주세요.');
			return false;
		}
		if (f.program.value == '')
		{
			alert('프로그램을 선택해주세요.');
			return false;
		}
		return confirm('정말로 실행하시겠습니까?         ');
	}
	function all_checking(){
		if($("#allCheck").prop("checked")) { 
			$("input[type=checkbox]").prop("checked",true);
		} else { 
			$("input[type=checkbox]").prop("checked",false); 
		}
	}
	$(document).ready(function() { 
	    $("#mentorTable").tablesorter({ 
	        headers: { 
	            7: { 
	                sorter: false 
	            }
	        } 
	    }); 
	});
</script>
<?php exit; ?>