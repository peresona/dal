<?php
	if(!defined('__KIMS__') || !$mytime) exit;
	checkAdmin(0);

	$_WHERE = ''; $_i = 0;
	foreach ($selects as $value) {$orner=""; $_i++;
		if(sizeof($selects) != $_i) $orner = " or ";
		$_WHERE .= "memberuid=".$value.$orner;
	}

	$_SCD = db_query("select * from rb_s_mbrdata where ".$_WHERE,$DB_CONNECT);
	$NUM = db_num_rows($_SCD);
?>
<div id="select_sc">
	<div class="header">
		<h1>멘토 선택</h1>
		<div class="guide">
		인증된 멘토만 검색 후 선택 할 수 있습니다. <br>
		등록 위치 : 관리자 화면 > 달꿈 > 멘토 관리
		</div>
		<div class="clear"></div>
	</div>
	<div class="line1"></div>
	<div class="line2"></div>
	<div class="line3"></div>

	<div class="content">
	<?php if($NUM>0):?>
		<div class="list">
				<table>
					<tr>
						<th width="10%">선택</th>
						<th width="25%">멘토 이름</th>
						<th width="25%">직업</th>
						<th width="20%">1차 정원</th>
						<th width="20%">2차 정원</th>
					</tr>
			<?php while($SCD = db_fetch_assoc($_SCD)):
				$SCD['job'] = getJobName($SCD['mentor_job']);
			?>
					<tr>
						
							<td><input type="checkbox" name="uids[]" id="uids_<?=$SCD['memberuid']?>" data-nums="<?=$SCD['memberuid']?>" data-mname="<?=$SCD['name']?>" data-mjob="<?=$SCD['job']?>" data-values="<?=$SCD['memberuid']?>,<?=$SCD['mentor_job']?>," value="<?=$SCD['memberuid']?>" checked="checked"></td>
							<td><?=$SCD['name']?></td>
							<td><?=$SCD['job']?></td>
							<td><input type="text" class="limit" name="limit[]" data-nums="<?=$SCD['memberuid']?>" value="0">명</td>
							<td><input type="text" class="limit2" name="limit2[]" data-nums="<?=$SCD['memberuid']?>" value="0">명</td>
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
		<input type="button" value="선택완료" class="btnblue" onclick="make_result();">
		<input type="button" value="취소(닫기)" class="btngray" onclick="top.close();">
	</div>
</div>
<script>
top.resizeTo(700,600);
window.onload = function(){
	window.document.body.scroll = "auto";
}
var last_names = "";
var last_result = "";

function cutLast(find,anychar){
	if(anychar.charAt(anychar.length - 1) == find) return anychar.slice(0,-1);
		else return anychar;
}

function make_result(){
	var counter_i = 0;
	var title_name,title_job;
	last_result ="";
	$('input[data-nums]:checked').each(function(){
		counter_i++;
		var limits = $('input.limit[data-nums="'+$(this).data('nums')+'"]').val();
		var limits2 = $('input.limit2[data-nums="'+$(this).data('nums')+'"]').val();
		// 멘토 번호,직업번호,정원
		last_result += $(this).data('values')+limits+','+limits2+"|";
		title_name = $(this).data('mname');
		title_job = $(this).data('mjob');
	});
	last_result = cutLast('|',last_result);
	if(counter_i == 0) {alert('한 명 이상 선택해주세요.'); return false;}
	else{
		opener.document.procForm.mentor_name_<?=$mytime?>.value=title_name+"("+title_job+") 등 "+counter_i+"명";
		opener.document.procForm.mentor_<?=$mytime?>.value=last_result;
		top.close();
	}
}

</script>
<?php exit; ?>