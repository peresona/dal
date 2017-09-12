<?php
if($my['mentor_confirm']!="Y") getLink('','','멘토회원만 이용 가능한 페이지 입니다.','-1');
include_once $g['dir_module_skin'].'_menu.php';
$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;

$sqlque = 'mentor_seq='.$my['uid'];

$RCD = db_query("select T.uid as teamUid,T.class_time, G.*,SC.name as SCName from rb_dalkkum_team as T, rb_dalkkum_group as G, rb_dalkkum_sclist as SC where T.group_seq = G.uid and G.sc_seq=SC.uid and T.mentor_seq=".$my['memberuid'].' order by '.$sort.' '.$orderby.($recnum?' limit '.(($p-1)*$recnum).', '.$recnum:''),$DB_CONNECT);

$NUM = getDbRows('rb_dalkkum_team',$sqlque);
$TPG = getTotalPage($NUM,$recnum);
?>

<div id="applylist">

	<div class="info">
		<div class="article">
			<?php echo number_format($NUM)?>개(<?php echo $p?>/<?php echo $TPG?>페이지)
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
	<col width="50"> 
	<col width="100"> 
	<col> 
	<col width="130"> 
	<col width="60"> 
	<col width="120"> 
	</colgroup> 
	<thead>
	<tr>
	<th scope="col" class="side1">번호</th>
	<th scope="col">학교</th>
	<th scope="col">제목</th>
	<th scope="col">날짜</th>
	<th scope="col">교시</th>
	<th scope="col" class="side2">출석부</th>
	</tr>
	</thead>
	<tbody>

	<?php while($R=db_fetch_array($RCD)):?>
	<tr>
	<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
	<td>
		<?=$R['SCName']?>
	</td>
	<td class="sbj">
		<a><?=$R['name']?></a>
	</td>
	<td><?=getDateFormat($R['start_'.$R['class_time']],'Y.m.d H:i')?> ~ <?=getDateFormat($R['end_'.$R['class_time']],'H:i')?></td>
	<td><?=$R['class_time']?>교시</td>
	<td><?if($R['finish']=='Y'):?>
	<a onclick="javascript:OpenWindow('/?r=home&amp;iframe=Y&amp;m=dalkkum&amp;a=export_team&amp;uid=<?=$R['teamUid']?>&amp;mode=web');"><input type="button" class="btnblue" value="보기"></a>
	<a href="/?r=home&amp;iframe=Y&amp;m=dalkkum&amp;a=export_team&amp;uid=<?=$R['teamUid']?>" target="_action_frame_admin" onclick="return confirm('현재까지 신청된 정보를 다운로드 하시겠습니까?')"><input type="button" class="btnblue" value="엑셀"></a>
	<?php else : ?><font class="bold green">수강신청 완료 전</font>
	<?php endif; ?>
	</td>
	</tr> 
	<?php endwhile?> 

	<?php if(!$NUM):?>
	<tr>
	<td><input type="checkbox" disabled="disabled" /></td>
	<td>1</td>
	<td class="sbj1">교육진행현황이 없습니다.</td>
	<td class="cat"></td>
	<td></td>
	</tr> 
	<?php endif?>

	</tbody>
	</table>
	

	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'<?php echo $g['img_core']?>/page/default');</script>
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


