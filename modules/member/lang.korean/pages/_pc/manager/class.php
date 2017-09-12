<?php
include_once $g['dir_module_skin'].'_menu.php';

$year1	= $year1  ? $year1  : substr($date['today'],0,4);
$month1	= $month1 ? $month1 : substr($date['today'],4,2);
$day1	= $day1   ? $day1   : 1;//substr($date['today'],6,2);
$year2	= $year2  ? $year2  : substr($date['today'],0,4);
$month2	= $month2 ? $month2 : substr($date['today'],4,2);
$day2	= $day2   ? $day2   : substr($date['today'],6,2);

$sort	= $sort ? $sort : 'RUID';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 15;

$sqlque = 'RQ.mentor_seq='.$M['memberuid'];

$sqlque .= ' and RQ.date_start > '.$year1.sprintf('%02d',$month1).sprintf('%02d',$day1).'0000 and RQ.date_start < '.$year2.sprintf('%02d',$month2).sprintf('%02d',$day2).'2400';
$RCD = getDbArray('rb_dalkkum_request RQ 
left join rb_dalkkum_score S on RQ.group_seq=S.group_seq and RQ.mentor_seq=S.mentor_seq 
left join rb_dalkkum_group G on RQ.group_seq=G.uid 
left join rb_dalkkum_sclist SC on G.sc_seq=SC.uid
left join rb_dalkkum_program P on P.uid=G.program_seq
',$sqlque,'RQ.uid as RUID, S.uid as SUID, RQ.*,S.*, G.name as groupName,P.uid as program,P.name as programName, SC.name as SCName ',$sort,$orderby,$recnum,$p);

$NUM = getDbRows('rb_dalkkum_request RQ 
left join rb_dalkkum_score S on RQ.group_seq=S.group_seq and RQ.mentor_seq=S.mentor_seq 
left join rb_dalkkum_group G on RQ.group_seq=G.uid 
left join rb_dalkkum_sclist SC on G.sc_seq=SC.uid
',$sqlque);
$TPG = getTotalPage($NUM,$recnum);
$scoreName = array('100' => '매우 좋음','75' => '좋음','50' => '보통','25' => '나쁨','0' => '매우나쁨');
$attendName = array('100' => '정상수업','50' => '지각', '0' => '결강');
?>



<div id="loglist">

	<form name="bbssearchf" action="<?php echo $g['s']?>/">
	<input type="hidden" name="r" value="<?php echo $r?>" />

	<div class="info">

		<div class="article">
			<?php echo number_format($NUM)?>건(<?php echo $p?>/<?php echo $TPG?>페이지)
		</div>
		<div class="category">


			<select name="year1">
			<?php for($i=$date['year'];$i>2009;$i--):?><option value="<?php echo $i?>"<?php if($year1==$i):?> selected="selected"<?php endif?>><?php echo $i?>년</option><?php endfor?>
			</select>
			<select name="month1">
			<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($month1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>월</option><?php endfor?>
			</select>
			<select name="day1">
			<?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($day1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>일(<?php echo getWeekday(date('w',mktime(0,0,0,$month1,$i,$year1)))?>)</option><?php endfor?>
			</select> ~
			<select name="year2">
			<?php for($i=$date['year'];$i>2009;$i--):?><option value="<?php echo $i?>"<?php if($year2==$i):?> selected="selected"<?php endif?>><?php echo $i?>년</option><?php endfor?>
			</select>
			<select name="month2">
			<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($month2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>월</option><?php endfor?>
			</select>
			<select name="day2">
			<?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($day2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>일(<?php echo getWeekday(date('w',mktime(0,0,0,$month2,$i,$year2)))?>)</option><?php endfor?>
			</select>

			<input type="button" class="btngray" value="기간적용" onclick="this.form.submit();" />


		</div>
		<div class="clear"></div>
	</div>

	<table summary="강의내역 리스트입니다.">
	<caption>강의내역</caption> 
	<colgroup> 
		<col width="50"> 
		<col width="100"> 
		<col width="100"> 
		<col width="100"> 
		<col width="80"> 
		<col width="60"> 
		<col width="60"> 
		<col width="60"> 
		<col width="70"> 
		<col width="80"> 
	</colgroup> 
	<thead>
	<tr>
	<th scope="col" class="side1">번호</th>
	<th scope="col">학교</th>
	<th scope="col">일시</th>
	<th scope="col">프로그램</th>
	<th scope="col">강의료</th>
	<th scope="col">강의내용</th>
	<th scope="col">매너</th>
	<th scope="col">수업분위기</th>
	<th scope="col">출결</th>
	<th scope="col" class="side2">정산액</th>
	</tr>
	</thead>
	<tbody>

	<?php while($R=db_fetch_array($RCD)):?>
	<?php $_browse = getBrowzer($R['agent'])?>
	<tr>
		<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
		<td><?=$R['SCName']?></td>
		<td><?=getDateFormat($R['date_start'],'Y.m.d H:i')?></td>
		<td><?=$R['programName']?></td>
		<td><?=number_format(class_price($M['memberuid'],$R['program']))?>원</td>
		<td><?=$R['score1']?$scoreName[$R['score1']]:'-'?></td>
		<td><?=$R['score2']?$scoreName[$R['score2']]:'-'?></td>
		<td><?=$R['score3']?$scoreName[$R['score3']]:'-'?></td>
		<td><?=$R['score4']?$attendName[$R['score4']]:'-'?></td>
		<td><?=number_format($R['exact_cash'])?>원</td>
	</tr> 
	<?php endwhile?> 

	<?php if(!$NUM):?>
	<tr>
		<td class="sbj1" colspan="10" style="text-align: center;">강의내역이 없습니다.</td>
	</tr> 
	<?php endif?>

	</tbody>
	</table>
	

	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'<?php echo $g['img_core']?>/page/default');</script>
	</div>

	<div class="searchform">
		<input type="hidden" name="mbruid" value="<?php echo $mbruid?>" />
		<input type="hidden" name="m" value="<?php echo $m?>" />
		<input type="hidden" name="front" value="<?php echo $front?>" />
		<input type="hidden" name="page" value="<?php echo $page?>" />
		<input type="hidden" name="sort" value="<?php echo $sort?>" />
		<input type="hidden" name="orderby" value="<?php echo $orderby?>" />
		<input type="hidden" name="recnum" value="<?php echo $recnum?>" />
		<input type="hidden" name="type" value="<?php echo $type?>" />
		<input type="hidden" name="iframe" value="<?php echo $iframe?>" />
		<input type="hidden" name="skin" value="<?php echo $skin?>" />
	</div>
	
	</form>
	<form name="whois_search_form">
	<input type="hidden" name="domain_name" value="" />
	</form>
</div>





<script type="text/javascript">
//<![CDATA[
function dropDate(date1,date2)
{
	var f = document.procForm;
	f.year1.value = date1.substring(0,4);
	f.month1.value = date1.substring(4,6);
	f.day1.value = date1.substring(6,8);
	
	f.year2.value = date2.substring(0,4);
	f.month2.value = date2.substring(4,6);
	f.day2.value = date2.substring(6,8);

	f.submit();
}
function whoisSearch(ip)
{
	var f = document.whois_search_form;

		f.domain_name.value = ip;
		f.target	= "_blank";
		f.method	= "post";
		f.action	= "http://whois.kisa.or.kr/result.php";
		f.submit();
}


document.title = "<?php echo $M[$_HS['nametype']]?>님의 강의내역";
self.resizeTo(800,750);

//]]>
</script>
