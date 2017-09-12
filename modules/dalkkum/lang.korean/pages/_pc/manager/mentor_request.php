<?php
	if(!defined('__KIMS__')) exit;
	checkAdmin(0);

	$_WHERE = ''; $_i = 0;
	foreach ($selects as $value) {$orner=""; $_i++;
		if(sizeof($selects) != $_i) $orner = " or ";
		$_WHERE .= "memberuid=".$value.$orner;
	}
	$_SCD = db_query("select * from rb_s_mbrdata where ".$_WHERE,$DB_CONNECT);
	$NUM = db_num_rows($_SCD);
?>
	<form name="selectForm" action="<?php echo $g['s']?>/" target="actionFrame" method="post" enctype="multipart/form-data">
		<input type="hidden" name="r" value="home" />
		<input type="hidden" name="m" value="dalkkum" />
		<input type="hidden" name="a" value="actionGroup" />
		<input type="hidden" name="act" value="request" />
		<input type="hidden" name="iframe" value="Y" />
		<input type="hidden" name="group" value="<?=$group?>" />
<div id="select_sc">
	<div class="header">
		<h1>멘토 선택</h1>
		<div class="guide">
		요청 기록이 있는 멘토는 새 요청으로 변경됩니다.
		</div>
		<div class="clear"></div>
	</div>
	<div class="line1"></div>
	<div class="line2"></div>
	<div class="line3"></div>

	<div class="content">
	<?php if($NUM>0):?>
		<div class="list">
		<div class="cl" style="text-align: center; margin-bottom: 10px;">이 그룹은 현재 <b>0명</b>의 멘토에게 요청이 전송되었습니다. (푸시대기 : <b>0명</b> / 수락 : <b>0명</b> / 진행중 : <b>0명</b> / 무응답 : <b>0명</b>)</div>
				<table>
					<tr>
						<th width="20%">이름 / 직업</th>
						<th width="20%">전화번호 / 비용</th>
						<th width="30%">이메일</th>
						<th width="20%">주소</th>
					</tr>
			<?php while($SCD = db_fetch_assoc($_SCD)):
				$SCD['job'] = getJobName($SCD['mentor_job']);
			?>
					<tr>
						
							<td><b><?=$SCD['name']?></b></td>
							<td><?=$SCD['tel2']?></td>
							<td><?=$SCD['email']?></td>
							<td>-</td>
					</tr>
					<tr>
						<td><?=$SCD['job']?></td>
						<td><input type="number" name="money[]" maxlength="10">원</td>
						<td></td>
						<td>
							
						</td>
					</tr>
					<tr>
						
							<td colspan="4">
							일시 : 
								<select name="date_start_1[]">
									<?php for($i=$date['year'];$i<$date['year']+3;$i++):?><option value="<?php echo $i?>"><?php echo $i?>년</option><?php endfor?>
								</select>
								<select name="date_start_2[]">
									<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"><?php echo sprintf('%02d',$i)?>월</option><?php endfor?>
								</select>
								<select name="date_start_3[]"><?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($day1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>일</option><?php endfor?></select>
								<select name="date_start_4[]"><?php for($i=0;$i<24;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"><?php echo sprintf('%02d',$i)?>시</option><?php endfor?></select>
								<select name="date_start_5[]"><?php for($i=0;$i<60;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($min1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>분</option><?php endfor?></select>
								~
								<select name="date_end_1[]">
									<?php for($i=$date['year'];$i<$date['year']+3;$i++):?><option value="<?php echo $i?>"><?php echo $i?>년</option><?php endfor?>
								</select>
								<select name="date_end_2[]">
									<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"><?php echo sprintf('%02d',$i)?>월</option><?php endfor?>
								</select>
								<select name="date_end_3[]"><?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($day1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>일</option><?php endfor?></select>
								<select name="date_end_4[]"><?php for($i=0;$i<24;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"><?php echo sprintf('%02d',$i)?>시</option><?php endfor?></select>
								<select name="date_end_5[]"><?php for($i=0;$i<60;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($min1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>분</option><?php endfor?></select>
							</td>
					</tr>
					<tr>
						<td colspan="4">
							<input type="text" name="memo[]" class="full" placeholder="전하고 싶은 말 및 강사에게 요청사항">
							<input type="hidden" name="mentorNo[]" value="<?=$SCD['memberuid']?>">
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
		<input type="submit" value="요청하기" class="btnblue">
		<input type="button" value="취소(닫기)" class="btngray" onclick="top.close();">
	</div>
</div>
</form>
<iframe name="actionFrame" frameborder="0" width="0" height="0"></iframe>
<script>
top.resizeTo(700,640);
window.onload = function(){
	window.document.body.scroll = "auto";
}
var last_names = "";
var last_result = "";

function cutLast(find,anychar){
	if(anychar.charAt(anychar.length - 1) == find) return anychar.slice(0,-1);
		else return anychar;
}

</script>
<?php exit; ?>