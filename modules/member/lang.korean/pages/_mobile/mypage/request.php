<?php
include_once $g['dir_module_skin'].'_menu.php';
$year1	= $year1  ? $year1  : substr($date['today'],0,4);
$month1	= $month1 ? $month1 : substr($date['today'],4,2);
$day1	= $day1   ? $day1   : 1;//substr($date['today'],6,2);
$year2	= $year2  ? $year2  : substr($date['today'],0,4)+1;
$month2	= $month2 ? $month2 : substr($date['today'],4,2);
$day2	= $day2   ? $day2   : substr($date['today'],6,2);

$sort	= $sort ? $sort : 'RUID';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 40;

$sqlque = 'RQ.mentor_seq='.$my['uid'];
$sqlque2 = 'mentor_seq='.$my['uid'];
if($_GET['year1']){
	$sqlque .= ' and RQ.date_start > '.$year1.sprintf('%02d',$month1).sprintf('%02d',$day1).' and RQ.date_start < '.$year2.sprintf('%02d',$month2).sprintf('%02d',$day2);
	$sqlque2 .= ' and date_start > '.$year1.sprintf('%02d',$month1).sprintf('%02d',$day1).' and date_start < '.$year2.sprintf('%02d',$month2).sprintf('%02d',$day2);
}
switch ($agree) {
	// 동의
	case 'agree':
		$sqlque .= " and RQ.agree='Y'";
		$sqlque2 .= " and agree='Y'";
		break;
	// 거절
	case 'no':
		$sqlque .= " and RQ.agree='N'";
		$sqlque2 .= " and agree='N'";
		break;
	// 마감
	case 'not':
		$sqlque .= " and RQ.agree='M'";
		$sqlque2 .= " and agree='M'";
		break;
	
	// 응답대기
	case 'before':
		$sqlque .= " and RQ.agree='D'";
		$sqlque2 .= " and agree='D'";
		break;
	
	default:
		break;
}
if ($where && $keyword)
{
	$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray('rb_dalkkum_request RQ left join rb_dalkkum_score S on RQ.group_seq=S.group_seq and RQ.mentor_seq=S.mentor_seq
left join rb_dalkkum_group G on RQ.group_seq=G.uid left join rb_dalkkum_sclist SC on G.sc_seq=SC.uid',$sqlque,'RQ.uid as RUID, S.uid as SUID, RQ.*,S.*,RQ.group_seq as GUID, G.name as groupName,G.program_seq as program, SC.name as SCName, RQ.mentor_seq as mentor_seq',$sort,$orderby,$recnum,$p);

$NUM = getDbRows('rb_dalkkum_request',$sqlque2);
$TPG = getTotalPage($NUM,$recnum);
$agreeName = array('Y' => '<font color="blue">승락</font>', 'N' => '<font color="red">거절</font>', 'M' => '<font color="orange">마감</font>', 'D' => '<font color="gray">대기</font>');
$agreeArray = array('before' => '응답대기', 'agree' => '승락', 'no' => '거절', 'not' => '마감');
$resultArray = array('100' => '<font color="blue">강의완료</font>', '50' => '<font color="red">지각</font>', '0' => '<font color="red">결강</font>');
?>

<div id="applylist">
	<div class="info">

	<form name="requestsearchf" method="get" action="<?=$g['s']?>/mypage/">
		<input type="hidden" name="page" value="request">
		<div class="category center">
			<select name="agree" onchange="this.form.submit();">
			<option value="">&nbsp;+ 전체</option>
			<?php foreach ($agreeArray as $key => $value):?>
				<option value="<?=$key?>"<?php if($agree==$key):?> selected="selected"<?php endif?>>ㆍ<?=$agreeArray[$key]?></option>
			<?php endforeach; ?>
			</select>

			<select name="year1">
			<?php for($i=$date['year'];$i>2009;$i--):?><option value="<?=$i?>"<?php if($year1==$i):?> selected="selected"<?php endif?>><?=$i?>년</option><?php endfor?>
			</select>
			<select name="month1">
			<?php for($i=1;$i<13;$i++):?><option value="<?=sprintf('%02d',$i)?>"<?php if($month1==$i):?> selected="selected"<?php endif?>><?=sprintf('%02d',$i)?>월</option><?php endfor?>
			</select>
			<select name="day1">
			<?php for($i=1;$i<32;$i++):?><option value="<?=sprintf('%02d',$i)?>"<?php if($day1==$i):?> selected="selected"<?php endif?>><?=sprintf('%02d',$i)?>일(<?=getWeekday(date('w',mktime(0,0,0,$month1,$i,$year1)))?>)</option><?php endfor?>
			</select> ~<br>
			<select name="year2">
			<?php for($i=$date['year']+2;$i>2009;$i--):?><option value="<?=$i?>"<?php if($year2==$i):?> selected="selected"<?php endif?>><?=$i?>년</option><?php endfor?>
			</select>
			<select name="month2">
			<?php for($i=1;$i<13;$i++):?><option value="<?=sprintf('%02d',$i)?>"<?php if($month2==$i):?> selected="selected"<?php endif?>><?=sprintf('%02d',$i)?>월</option><?php endfor?>
			</select>
			<select name="day2">
			<?php for($i=1;$i<32;$i++):?><option value="<?=sprintf('%02d',$i)?>"<?php if($day2==$i):?> selected="selected"<?php endif?>><?=sprintf('%02d',$i)?>일(<?=getWeekday(date('w',mktime(0,0,0,$month2,$i,$year2)))?>)</option><?php endfor?>
			</select>

			<input type="button" class="btngray" value="기간적용" onclick="this.form.submit();" />
			<?php if($_GET['year1']):?><input type="button" class="btngray" value="취소" onclick="location.href='/mypage/?page=request'" /><?php endif; ?>

		</div>
	</form>
		<div class="clear"></div>
	</div>

	<form name="procForm" action="<?=$g['s']?>/" method="post" target="_action_frame_<?=$m?>" onsubmit="return submitCheck(this);">
	<input type="hidden" name="r" value="<?=$r?>" />
	<input type="hidden" name="m" value="<?=$m?>" />
	<input type="hidden" name="front" value="<?=$front?>" />
	<input type="hidden" name="a" value="" />

	<table summary="수업 요청 리스트입니다.">
	<caption>수업 요청</caption> 

	<thead>
		<tr>
			<th scope="col" class="side1">번호</th>
			<th scope="col">일시</th>
			<th scope="col">학교 / 수업명</th>
			<th scope="col">강의<br>비용</th>
			<th scope="col">정산<br>금액</th>
			<th scope="col">서류<br>상태</th>
			<th scope="col" class="side2">비고</th>
		</tr>
	</thead>
	<tbody>

	<?php $sum_myprice=0; while($R=db_fetch_array($RCD)):
		// 가격 책정
		$temp = array();
		$MBRD = getDbData('rb_s_mbrdata','memberuid='.$R['mentor_seq'],'mentor_grade');
		$gradeName = array('','E','D','C','B','A');
		$price_list = getUidData('rb_dalkkum_program',$R['program']);
		$temp['price'] = $MBRD['mentor_grade']?$price_list['price'.$gradeName[$MBRD['mentor_grade']]]:0;
	?>
	<tr>
		<td><?=$NUM-((($p-1)*$recnum)+$_rec++)?></td>
		<td><?=getDateFormat($R['date_start'],'Y.m.d')?><br><?=getDateFormat($R['date_start'],'H시')?></td>
		<td><?=$R['SCName']?><br><?=$R['groupName']?></td>
		<td><?=($temp['price']/10000)?></td>
		<td><?=$R['exact_cash']?number_format($R['exact_cash'])."원":'-'?><?php $sum_myprice+=$R['exact_cash']; ?></td>
		<td>
			<?php if($R['agree']=='D' && $R['agreeable']=='Y'){?>
				<input type="button" class="btnblue center" value="수락/거절" onclick="class_request(<?=$R['GUID']?>);">
			<?php } else echo $agreeName[$R['agree']]; ?>
		</td>
	<td><?=$resultArray[$R['score4']]?></td>
	</tr> 
	<tr>
		<td class="sbj" colspan="7" style="height: 20px; line-height: 20px; text-align: center;">기타사항 : <?=$R['memo']?></td>
	</tr>
	<?php endwhile?> 
	<?php if(!$NUM):?>
	<tr>
	<td colspan="7">요청받은 내역이 없습니다.</td>
	</tr> 
	<?php else: ?>
	<tr>
		<td class="sbj" colspan="7" style="height: 20px; line-height: 20px;">강의료 정산 합계 : <?=number_format($sum_myprice)?>원</td>
	</tr>
	<?php endif?>

	</tbody>
	</table>
	

	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,<?=$p?>,<?=$TPG?>,'<?=$g['img_core']?>/page/default');</script>
	</div>

	</form>
	

</div>


<script type="text/javascript">
//<![CDATA[
function submitCheck(f)
{
	if (f.a.value == '')
	{
		return false;
	}
}
function actCheck(act)
{
	var f = document.procForm;
    var l = document.getElementsByName('members[]');
    var n = l.length;
	var j = 0;
    var i;

    for (i = 0; i < n; i++)
	{
		if(l[i].checked == true)
		{
			j++;	
		}
	}
	if (!j)
	{
		alert('선택된 항목이 없습니다.      ');
		return false;
	}
	
	if(confirm('정말로 실행하시겠습니까?    '))
	{
		f.a.value = act;
		f.submit();
	}
}
//]]>
</script>


