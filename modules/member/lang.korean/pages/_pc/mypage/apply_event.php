<?php

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;

$sqlque = 'member_seq='.$my['uid'];
if ($step) $sqlque .= " and step='".$step."'";
if ($where && $keyword)
{
	$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray('rb_dalkkum_eventapply',$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows('rb_dalkkum_eventapply',$sqlque);
$TPG = getTotalPage($NUM,$recnum);
$stepM = array('ALL','접수','확인중','거절','진행중','완료');
$stepM2 = array('제출','접수','확인중','거절','진행중','완료');
$eventName = array('','<font color="green">예정</font>','<font color="blue">진행중</font>','완료','취소');
?>

<div id="applylist">
	<h2>교육진행현황</h2>

	<div class="info">

		<div class="article">
			<?php echo number_format($NUM)?>개(<?php echo $p?>/<?php echo $TPG?>페이지)
		</div>
		<div class="category">
			<ul id="kin_kind_list" class="fr">
			<?php foreach (array(0,1,2,3,4,5) as $ii): ?>
				<li<?php if($_GET['step']==$ii && isset($step)):?> class="active"<?php endif;?> onclick="location.href='<?=$g['url_page']?>&step=<?=$ii?>'"><?=$stepM[$ii]?></li>
			<?php endforeach; ?>
			</ul>

		</div>
		<div class="clear"></div>
	</div>

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return submitCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="" />

	<table summary="스크랩 리스트입니다.">
	<caption>스크랩</caption> 
	<colgroup> 
	<col width="50"> 
	<col> 
	<col width="90"> 
	<col width="90"> 
	<col width="90"> 
	<col width="90"> 
	</colgroup> 
	<thead>
	<tr>
	<th scope="col" class="side1">번호</th>
	<th scope="col">제목</th>
	<th scope="col">학생규모</th>
	<th scope="col">상태</th>
	<th scope="col">일정</th>
	<th scope="col" class="side2">날짜</th>
	</tr>
	</thead>
	<tbody>

	<?php while($R=db_fetch_array($RCD)):?>
	<tr>
		<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
		<td class="sbj">
			<a href="/?mod=apply_event&uid=<?=$R['uid']?>"><?=$R['name']?> / <?=$R['email']?> / <?=$R['a_group']?></a>
			<?php if(getNew($R['d_regis'],24)):?><span class="new">new</span><?php endif?>
		</td>
		<td class="cat"><?=$R['std_num']?></td>
		<td class="cat"><?php echo $stepM2[$R['step']]?></td>
		<td class="cat"><input type="button" value="보기" onclick="show_datelist(<?=$R['uid']?>)"></td>
		<td><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
	</tr> 
	<style>
		#applylist table.intable {width: 96%; margin:5px auto; box-sizing: border-box; background-color: #eee;}
		#applylist table.intable th {color:#000;}
		#applylist table.intable td {color:#666;}
		#applylist [data-toggle="applylist"] {display: none;}
	</style>
	<tr data-toggle="applylist" data-listnum="<?=$R['uid']?>">
		<td colspan="8">
			<table class="intable">
				<tr>
					<th>접수</th>
					<th>선호도조사</th>
					<th>멘토섭외</th>
					<th>수강신청</th>
					<th>서류전달</th>
					<th>교육진행</th>
					<th>행정처리</th>
				</tr>
				<tr>
					<?php
						$eventdates1 = explode('|', $R['eventdate1']);
						$eventdates2 = explode('|', $R['eventdate2']);
						$eventnow = explode('|', $R['eventnow']);
					 for ($i=1; $i <= 7 ; $i++):?>
					<td><?=$eventdates1[$i-1]?getDateFormat($eventdates1[$i-1],'Y-m-d'):'미정'?></td>
					<?php endfor;?>
				</tr>
				<tr>
					<?php for ($i=1; $i <= 7 ; $i++):?>
					<td><?=$eventdates2[$i-1]?getDateFormat($eventdates2[$i-1],'Y-m-d'):'미정'?></td>
					<?php endfor;?>
				</tr>
				<tr>
					<?php for ($i=1; $i <= 7 ; $i++):?>
					<td><?=$eventName[$eventnow[$i-1]]?$eventName[$eventnow[$i-1]]:'-'?></td>
					<?php endfor;?>
				</tr>
				<?php if(!in_array($R['step'], array('3','5'))): ?>
				<tr>
					<?php for ($i=1; $i <= 7 ; $i++):?>
					<td><?=$eventdates1[$i-1]?('D'.sprintf('%+d',-getRemainDate($eventdates1[$i-1]))):''?></td>
					<?php endfor;?>
				</tr>
				<?php endif; ?>
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
	<input type="button" value=" + 교육신청" class="btnblue fr"  onclick="if(confirm('교육 요청은 학교(진로부장님)나 기관 담당자 분께서 직접 작성해 주셔야 하며, 개인적으로 교육을 요청할 경우에는 학생수와 시간에 따라 교육료는 변경될 수 있습니다.')) location.href = '/?mod=apply_event'; "/>

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


