<?php 
include_once $g['dir_module_skin'].'_menu.php';

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;

$sqlque = 'member_seq='.$my['uid'];
if ($step) $sqlque .= " and step='".($step)."'";
if ($where && $keyword)
{
	$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray('rb_dalkkum_eventapply',$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows('rb_dalkkum_eventapply',$sqlque);
$TPG = getTotalPage($NUM,$recnum);
$stepM = array('ALL','접수','확인중','거절','진행중','완료');
$stepM2 = array('제출','접수','확인중','거절','진행중','완료');
$eventTitle = array('','접수','선호도조사','멘토섭외','수강신청','서류전달','교육진행','행정처리');
$eventName = array('','<font color="green">예정</font>','<font color="blue">진행중</font>','완료','취소');
?>

<div id="applylist">
	<div class="center">
			<div class="category">
			<ul id="kin_kind_list">
			<?php foreach (array(0,1,2,3,4,5) as $ii): ?>
				<li<?php if($_GET['step']==$ii && isset($step)):?> class="active"<?php endif;?> onclick="location.href='<?=$g['url_page']?>&step=<?=$ii?>'"><?=$stepM[$ii]?></li>
			<?php endforeach; ?>
			</ul>

		</div>
	</div>

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return submitCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="" />

	<table summary="스크랩 리스트입니다.">
	<caption>스크랩</caption> 
	<colgroup> 
	<col width="30"> 
	<col> 
	<col width="40"> 
	<col width="40"> 
	<col width="70"> 
	</colgroup> 
	<thead>
	<tr>
	<th scope="col" class="side1">번호</th>
	<th scope="col">학교 및 규모</th>
	<th scope="col">상태</th>
	<th scope="col">일정</th>
	<th scope="col" class="side2">날짜</th>
	</tr>
	</thead>
	<tbody>

	<?php while($R=db_fetch_array($RCD)):?>
	<tr>
		<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
		<td class="sbj"><?=$R['a_group']?><br>규모 : <?=$R['std_num']?></td>
		<td class="cat"><?php echo $stepM2[$R['step']]?></td>
		<td class="cat"><input type="button" value="상세" onclick="show_datelist(<?=$R['uid']?>)"></td>
		<td><?php echo getDateFormat($R['d_regis'],'Y.m.d')?></td>
	</tr> 
	<style>
		#applylist table.intable {width: 96%; margin:5px auto; box-sizing: border-box; background-color: #eee;}
		#applylist table.intable th {color:#000;}
		#applylist table.intable td {color:#666;}
		#applylist [data-toggle="applylist"] {display: none;}
	</style>
	<tr data-toggle="applylist" data-listnum="<?=$R['uid']?>">
		<td colspan="5">
			<?php 
				$eventdates1 = explode('|', $R['eventdate1']);
				$eventdates2 = explode('|', $R['eventdate2']);
				$eventnow = explode('|', $R['eventnow']);
			?>
			<table class="intable">
				<tr>
					<th></th>
					<th>시작일</th>
					<th>종료일</th>
					<th>D-day</th>
				</tr>
				<?php for ($i=1; $i <= 7 ; $i++):?>
				<tr>
					<td style="font-weight: bold; color:#000;"><?=$eventTitle[$i]?></td>
					<td><?=$eventdates1[$i-1]?getDateFormat($eventdates1[$i-1],'Y-m-d'):'미정'?></td>
					<td><?=$eventdates2[$i-1]?getDateFormat($eventdates2[$i-1],'Y-m-d'):'미정'?></td>
					<td><?=($eventdates1[$i-1] && $eventdates1[$i-1]<0)?('D'.sprintf('%+d',-getRemainDate($eventdates1[$i-1]))):''?></td>
				</tr>
				<?php endfor; ?>
			</table>
		</td>
	</tr>
	<?php endwhile?> 

	<?php if(!$NUM):?>
	<tr>
		<td colspan="6">교육진행현황이 없습니다.</td>
	</tr> 
	<?php endif?>

	</tbody>
	</table>
	

	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'<?php echo $g['img_core']?>/page/default');</script>
	</div>

	<input type="text" name="category" id="iCategory" value="" class="input none" />
	<input type="button" value=" + 교육신청" class="btnblue fr" onclick="if(confirm('교육 요청은 학교(진로부장님)나 기관 담당자 분께서 직접 작성해 주셔야 하며, 개인적으로 교육을 요청할 경우에는 학생수와 시간에 따라 교육료는 변경될 수 있습니다.')) location.href = '/?mod=apply_event'; "/>

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
function show_datelist(listnum){
	var nowshow = $('[data-toggle="applylist"][data-listnum="'+listnum+'"]').css('display');
	if(nowshow=='none'){
		$('[data-toggle="applylist"]').hide();
		$('[data-toggle="applylist"][data-listnum="'+listnum+'"]').show();
	} else{
		$('[data-toggle="applylist"]').hide();
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


