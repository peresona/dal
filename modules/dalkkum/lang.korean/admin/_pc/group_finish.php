<?php
if(!defined('__KIMS__')) exit;
checkAdmin(0);

$_ADS = getDbArray('rb_dalkkum_group','finish="Y"','*','uid','desc',0,$p);
$NUM = db_num_rows($_ADS);


if ($uid)
{
	$R = getUidData('rb_dalkkum_group',$uid);
	$year1	= substr($R['date_start'],0,4);
	$month1	= substr($R['date_start'],4,2);
	$day1	= substr($R['date_start'],6,2);
	$hour1	= substr($R['date_start'],8,2);
	$min1	= substr($R['date_start'],10,2);
	$year2	= substr($R['date_end'],0,4);
	$month2	= substr($R['date_end'],4,2);
	$day2	= substr($R['date_end'],6,2);
	$hour2	= substr($R['date_end'],8,2);
	$min2	= substr($R['date_end'],10,2);
	$year3	= substr($R['class_date'],0,4);
	$month3	= substr($R['class_date'],4,2);
	$day3	= substr($R['class_date'],6,2);
	$hour3	= substr($R['class_date'],8,2);
	$min3	= substr($R['class_date'],10,2);

$_ABLE = getDbArray('rb_dalkkum_applyable','group_seq='.$R['uid'],'*','sc_grade,sc_class,sc_num','asc',0,$p);
$ABLE_NUM = db_num_rows($_ABLE);
unset($_ABLE);
}

for($_i=1; $_i<=$R['select_hour']; $_i++){
	${"start".$_i."_1"} = substr($R['start_'.$_i], 8,2);
	${"start".$_i."_2"} = substr($R['start_'.$_i], 10,2);
	${"end".$_i."_1"} = substr($R['end_'.$_i], 8,2);
	${"end".$_i."_2"} = substr($R['end_'.$_i], 10,2);
}
?>


<div id="catebody">
	<div id="category">
		<div class="title">
			수강신청 그룹목록
		</div>
		
		<?php if($NUM):?>
		<div class="tree">
			<ul>
			<?php while($ADS = db_fetch_array($_ADS)):?>
			<li><a href="<?=$g['adm_href']?>&amp;uid=<?=$ADS['uid']?>"><span class="name<?php if($ADS['uid']==$uid):?> on<?php endif?>"><?=$ADS['name']?></span></a></li>
			<?php endwhile?>
			</ul>
		</div>
		<?php else:?>
		<div class="none">등록된 수강신청이 없습니다.</div>
		<?php endif?>
	</div>


	<div id="catinfo">
		<div class="title">

			<div class="xleft">
				수강신청 그룹목록
			</div>
			<div class="xright">

				<a href="<?=$g['adm_href']?>&amp;newpop=Y">새 수강신청 등록</a>

			</div>
		</div>

		<div class="notice">
			수강신청이 완료된 그룹 정보입니다. 멘토별 교시별 명단을 출력할 수 있습니다.
		</div>


		<table>
			<tr>
				<td class="td1">학교</td>
				<td class="td2">
				<b><?=getSchoolName($R['sc_seq'])?></b>
				</td>
			</tr>
			<tr>
				<td class="td1">그룹명</td>
				<td class="td2">
					<b><?=$R['name']." (".$R['d_regis'].")"?></b>
				</td>
			</tr>
			<tr>
				<td class="td1">수업 일시</td>
				<td class="td2"><?=getDateView($R['class_date'],'-')?>
				</td>
			</tr>
			<tr>
				<td class="td1">수강신청 기간</td>
				<td class="td2"><?=getDateView($R['date_start'],'-')?> ~ <?=getDateView($R['date_end'],'-')?>
				</td>
			</tr>
			<tr>
				<td class="td1">진행상태</td>
				<td class="td2">
					<?php if($R['uid'] && ($R['apply_start']!="Y")):?> 대기
					<?php elseif($R['uid'] && ($R['apply_start']=="Y") && ($R['finish']!="Y")):?> <font color="green"><b>수강신청 진행중</b></font>
					<?php elseif($R['uid'] && ($R['finish']=="Y")):?><font color="blue"><b>수강신청 완료</b> 
						<a onclick="javascript:OpenWindow('<?=$g['s']?>/?r=home&amp;iframe=Y&amp;m=dalkkum&amp;a=export_group&amp;uid=<?=$R['uid']?>&mode=web');"><input type="button" class="btnblue" value="조회" /></a>
						<a href="<?=$g['s']?>/?r=home&amp;iframe=Y&amp;m=dalkkum&amp;a=export_group&amp;uid=<?=$R['uid']?>"><input type="button" class="btnblue" value="엑셀 다운로드" /></a>
					<?php endif?>
				</td>
			</tr>
			<tr>
				<td class="td1">지원 현황</td>
				<td class="td2">
<?php
					$num_apply = array();
					$num_apply['all'] = getDbRows('rb_dalkkum_applyable','group_seq='.$R['uid']);	// 총원
					$num_apply['end'] = getDbRows('rb_dalkkum_apply','group_seq='.$R['uid'].' and nows='.$R['select_hour']);	// 완료
					$num_apply['not'] = $num_apply['all'] - $num_apply['end'];	// 미완료
				?>
					총 <?=$num_apply['all']?>명 ( 완료 : <?=$num_apply['end']?>명 / 미완료 : <?=$num_apply['not']?>명)
				</td>
			</tr>

			<tr style="text-align: center;">
				<td colspan="2">
				<table style="background-color: #eee">
				<tr>
					<td colspan="12" style="font-size: 16px; height: 30px; font-weight: bold; line-height: 30px;">멘토 리스트</td>
				</tr>
					<tr>
						<td width="50"><b>번호</b></td>
						<td width="100"><b>멘토이름</b></td>
						<td width="100"><b>직업</b></td>
						<td width="50"><b>등급</b></td>
						<td width="50"><b>점수</b></td>
						<td width="80"><b>강의료</b></td>
						<td width="90"><b>강의내용</b></td>
						<td width="90"><b>매너</b></td>
						<td width="90"><b>수업분위기</b></td>
						<td width="90"><b>출결</b></td>
						<td width="90"><b>정산액</b></td>
						<td width="200"><b>관리</b></td>
					</tr>
					<?php 
					// 프로그램 기재
						$_PGD = getDbSelect('rb_dalkkum_program','','*');
						$programs = array('');
						$programs[0] = '프로그램 선택';
						while ($_tmp = db_fetch_array($_PGD)) {
							$programs[$_tmp['uid']] = $_tmp['name'];
						}
					// 단가표
					$price_list = getUidData('rb_dalkkum_program',$R['program_seq']);
					$gradeName = array('','E','D','C','B','A');
					$_sql = "select M.memberuid, M.name, G.uid as groupuid, J.name as jobName,M.mentor_grade as grade,M.mentor_score as score, G.date_start, S.* from rb_dalkkum_team as T, rb_dalkkum_group as G, rb_dalkkum_job as J, rb_s_mbrdata as M LEFT OUTER JOIN rb_dalkkum_score as S on M.memberuid=S.mentor_seq and S.group_seq=".$R['uid']." where T.mentor_seq=M.memberuid and T.group_seq=G.uid and T.job_seq=J.uid and G.uid=".$R['uid']." group by T.mentor_seq order by T.mentor_seq asc";
					$_sql = db_query($_sql, $DB_CONNECT);
					$tmpnum=0;
					while ($PL = db_fetch_array($_sql)):$tmpnum++;?>
					<tr>
						<td><?=$tmpnum?></td>
						<td><?=$PL['name']?></td>
						<td><?=$PL['jobName']?></td>
						<td><?=$gradeName[$PL['grade']]?></td>
						<td><?=$PL['score']?></td>
						<td><?=$price_list['price'.$gradeName[$PL['grade']]].'원'?></td>
					<?php for ($i=1; $i <= 3 ; $i++) :?>
						<td>
							<select name="ts_<?=$PL['memberuid']?>[]" id="ts_<?=$PL['memberuid']?>_<?=$i?>">
								<option value="">선택</option>
								<option<?php if($PL['score'.$i]=='100'):?> selected="selected"<?php endif;?> value="100">매우좋음</option>
								<option<?php if($PL['score'.$i]=='75'):?> selected="selected"<?php endif;?> value="75">좋음</option>
								<option<?php if($PL['score'.$i]=='50'):?> selected="selected"<?php endif;?> value="50">보통</option>
								<option<?php if($PL['score'.$i]=='25'):?> selected="selected"<?php endif;?> value="25">나쁨</option>
								<option<?php if($PL['score'.$i]=='0' && isset($PL['score'.$i])):?> selected="selected"<?php endif;?> value="0">매우나쁨</option>
							</select>
						</td>
					<?php endfor; ?>
						<td>
							<select name="ts_<?=$PL['memberuid']?>[]" id="ts_<?=$PL['memberuid']?>_4"<?php if($PL['exact_cash']):?> disabled="disabled"<?php endif; ?>>
								<option value="">선택</option>
								<option<?php if($PL['score4']=='100'):?> selected="selected"<?php endif;?> value="100">이상무</option>
								<option<?php if($PL['score4']=='50'):?> selected="selected"<?php endif;?> value="50">지각</option>
								<option<?php if($PL['score4']=='0' && isset($PL['score4'])):?> selected="selected"<?php endif;?> value="0">결강</option>
							</select></td>
						<td><?=isset($PL['exact_cash'])?$PL['exact_cash'].'원':'미정산'?></td>
						<td>
							<input type="button" value="적용" onclick="saveScore('<?=$PL['memberuid']?>')" title="점수를 적용합니다.">
							<input type="button" value="리셋" onclick="resetScore('<?=$PL['memberuid']?>')" title="점수를 초기화합니다.">
							<?php if($PL['exact_cash']):?>
								<input type="button" value="정산취소" onclick="exactCancel('<?=$PL['memberuid']?>')" title="정산을 취소 합니다.">
							<?php else:?>
								<input type="button" value="정산하기" onclick="exactCash('<?=$PL['memberuid']?>')" title="정산처리합니다.">
							<?php endif; ?>
						</td>
					</tr>
					<?php endwhile; ?>
					</table>
				</td>
			</tr>


			<tr>
				<td class="td1">교시</td>
				<td class="td2">
			<?php if($R['apply_start']!="Y"):?>
					<select name="select_hour" onchange="show_times(this.value);">
						<option value="0">미정</option>
						<?php for($i=1;$i<11;$i++):?><option value="<?=$i?>"<?php if($R['select_hour']==$i):?> selected="selected"<?php endif?>><?=$i ?></option><?php endfor?>
					</select>
			<?php else: ?>
				<?=$R['select_hour']?> 교시
			<?php endif; ?>
				</td>
			</tr><?php if($R['img']) :?>
			<tr>
				<td class="td1">이미지</td>
				<td class="td2">
					<img src="<?=$g['path_root'].'files/_etc/group/'.$R['img']; ?>" alt="">
				</td>
			</tr><?php endif ?>
			
			<?php 
			if($R['uid']):	for($e=1; $e<=10; $e++):
				$_ment = explode("%%%",$R['mentor_'.$e]); 
			?>


			<tr class="times_hide_<?=$e?>">
				<td class="td1"><?=$e?>교시 수업</td>
				<td class="td2">
				<table class="intable">
					<tr>
						<td width="150"><b>멘토</b></td>
						<td width="150"><b>직업</b></td>
						<td width="100"><b>지원</b></td>
						<td width="100"><b>제한</b></td>
						<td width="100"><b>비고</b></td>
					</tr>
					<?php $_sql = "select T.*,M.name as mentorName, J.name as jobName from rb_dalkkum_team as T, rb_dalkkum_job as J, rb_s_mbrdata as M where M.memberuid=T.mentor_seq and T.job_seq=J.uid and T.group_seq=".$R['uid']." and T.class_time=".$e; $_sql = db_query($_sql, $DB_CONNECT);
					while ($teamList = db_fetch_array($_sql)):?>

					<tr style="<?=(($teamList['nows'] == $teamList['limits'])?'color : blue':'')?>" onclick="javascript:OpenWindow('/?r=home&iframe=Y&m=dalkkum&a=export_team&uid=<?=$teamList['uid']?>&mode=web');">
						<td><?=$teamList['mentorName']?></td>
						<td><?=$teamList['jobName']?></td>
						<td><?=$teamList['nows']?></td>
						<td><?=$teamList['limits']?></td>
						<td><?=(($teamList['nows'] == $teamList['limits'])?'마감':'')?></td>
					</tr>
					<?php endwhile; ?>
					</table>
				</td>
			</tr>


			<?php unset($_ment); endfor; endif; ?>
		</table>

		</form>  
		

	</div>
	<div class="clear"></div>
</div>




<script type="text/javascript">
//<![CDATA[

function saveScore(MUID){
	var score1 = $('#ts_'+MUID+'_1').val();
	var score2 = $('#ts_'+MUID+'_2').val();
	var score3 = $('#ts_'+MUID+'_3').val();
	var score4 = $('#ts_'+MUID+'_4').val();
	console.log("/?r=<?=$r?>&m=dalkkum&a=actionGroup&act=saveScore&group=<?=$uid?>&uid="+MUID+"&score1="+score1+"&score2="+score2+"&score3="+score3+"&score4="+score4);
	if(score1 && score2 && score3 && score4 && MUID){
		frames._action_frame_admin.location.href = "/?r=<?=$r?>&m=dalkkum&a=actionGroup&act=saveScore&group=<?=$uid?>&uid="+MUID+"&score1="+score1+"&score2="+score2+"&score3="+score3+"&score4="+score4;
	}else{
		alert('점수를 모두 선택해주세요.');
	}
}
function resetScore(MUID){
	if(MUID){
		frames._action_frame_admin.location.href = "/?r=<?=$r?>&m=dalkkum&a=actionGroup&act=resetScore&group=<?=$uid?>&uid="+MUID;
	}else{
		alert('에러가 발생하였습니다.');
	}
}
function exactCash(MUID){
	console.log("/?r=<?=$r?>&m=dalkkum&a=actionGroup&act=exactCash&group=<?=$uid?>&uid="+MUID);
	if(MUID){
		frames._action_frame_admin.location.href = "/?r=<?=$r?>&m=dalkkum&a=actionGroup&act=exactCash&group=<?=$uid?>&uid="+MUID;
	}else{
		alert('에러가 발생하였습니다.');
	}
}
function exactCancel(MUID){
	console.log("/?r=<?=$r?>&m=dalkkum&a=actionGroup&act=exactCancel&group=<?=$uid?>&uid="+MUID);
	if(MUID){
		frames._action_frame_admin.location.href = "/?r=<?=$r?>&m=dalkkum&a=actionGroup&act=exactCancel&group=<?=$uid?>&uid="+MUID;
	}else{
		alert('에러가 발생하였습니다.');
	}
}

function show_times(num=0){
		$('tr[class^="times_hide"]').hide();
	for(var i=1; i<=num; i++){
		$('tr[class="times_hide_'+i+'"]').show();
	}
}
function ToolCheck(compo)
{
	frames.editFrame.showCompo();
	frames.editFrame.EditBox(compo);
}
function saveCheck(f)
{
	if (f.name.value == '')
	{
		alert('수강신청 그룹이름을 입력해 주세요.      ');
		f.name.focus();
		return false;
	}

	return confirm('정말로 실행하시겠습니까?         ');
}
$(document).ready(function(){
	show_times(<?=$R['select_hour'] ?>);
});
//]]>
</script>





