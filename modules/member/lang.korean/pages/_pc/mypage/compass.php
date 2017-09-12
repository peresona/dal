<?php

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;

if($my['mentor_confirm']=='Y' && $my['mentor_job']){
	$sqlque = "D.job_seq=J.uid and bbsid='kin' and job_seq='".$my['mentor_job']."' and parentmbr='0'";
	$sqlque2 = "bbsid='kin' and job_seq='".$my['mentor_job']."' and parentmbr='0'";
}else{
	$sqlque = "D.job_seq=J.uid and bbsid='kin' and mbruid='".$my['memberuid']."' and parentmbr='0'";
	$sqlque2 = "bbsid='kin' and mbruid='".$my['memberuid']."' and parentmbr='0'";
}

if ($step == 'reply') {
	$_tmp = " and not(endkin='Y') and (is_reply>0)";
	$sqlque .= $_tmp;	$sqlque2 .= $_tmp;
	}
else if ($step == 'before'){
	$_tmp = " and not(endkin='Y') and (is_reply=0)";
	$sqlque .= $_tmp;	$sqlque2 .= $_tmp;
} 

if ($where && $keyword)
{
	$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray('rb_bbs_data as D, rb_dalkkum_job as J',$sqlque,'D.*, J.name as jobName',$sort,$orderby,$recnum,$p);
$NUM = getDbRows('rb_bbs_data',$sqlque2);
$TPG = getTotalPage($NUM,$recnum);

?>



<div id="compass">

	<h2><?php if($my['mentor_confirm']=='Y' && $my['mentor_job']):?>멘토 진로 Q&amp;A(<?=getJobName($my['mentor_job'])?>)<?php else:?>나의 진로 Q&amp;A<?php endif;?></h2>
	<div class="info">

		<div class="article">
			<?=number_format($NUM)?>개(<?=$p?>/<?=$TPG?>페이지)
		</div>
	<div class="fr">
		<ul id="kin_kind_list" class="fr">
			<li<?php if(!$step || !in_array($step, array('before','reply','end'))):?> class="active"<?php endif;?> onclick="location.href='/mypage/?page=compass'">전체</li>
			<li<?php if($step=='before'):?> class="active"<?php endif;?> onclick="location.href='/mypage/?page=compass&step=before'">답변대기</li>
			<li<?php if($step=='reply' || $step=='end'):?> class="active"<?php endif;?> onclick="location.href='/mypage/?page=compass&step=reply'">답변완료</li>
		</ul>
	</div>
		<div class="clear"></div>
	</div>

	<form name="procForm" action="<?=$g['s']?>/" method="post" target="_action_frame_<?=$m?>" onsubmit="return submitCheck(this);">
	<input type="hidden" name="r" value="<?=$r?>" />
	<input type="hidden" name="m" value="<?=$m?>" />
	<input type="hidden" name="front" value="<?=$front?>" />
	<input type="hidden" name="a" value="" />

	<table summary="나의 진로 Q&amp;A 리스트입니다.">
	<caption>나의 진로 Q&amp;A</caption> 
	<colgroup> 
	<col width="50"> 
	<col width="100"> 
	<col> 
	<col width="100"> 
	<col width="100"> 
	<col width="130"> 
	</colgroup> 
	<thead>
	<tr>
	<th scope="col" class="side1">번호</th>
	<th scope="col">분류</th>
	<th scope="col">제목</th>
	<th scope="col">작성자</th>
	<th scope="col">진행상황</th>
	<th scope="col" class="side2">날짜</th>
	</tr>
	</thead>
	<tbody>

	<?php while($R=db_fetch_array($RCD)):?>
	<tr>
	<td><?=$NUM-((($p-1)*$recnum)+$_rec++)?></td>
	<td class="cat"><?=$R['jobName']?></td>
	<td class="sbj">
		<a href="/jblog/kin/?job=<?=$R['job_seq']?>&uid=<?=$R['uid']?>"><?=$R['subject']?></a>
		<a href="/jblog/kin/?job=<?=$R['job_seq']?>&uid=<?=$R['uid']?>" target="_blank" style="margin-left:6px;"><img src="<?=$g['img_core']?>/_public/ico_blank.gif" alt="" title="새창으로보기" /></a>
		<?php if(getNew($R['d_regis'],24)):?><span class="new">new</span><?php endif?>
	</td>
	<td><?=$R['name']?></td>
	<td><?=($R['is_reply']?'답변완료':'답변대기')?></td>
	<td><?=getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
	</tr> 
	<?php endwhile?> 

	<?php if(!$NUM):?>
	<tr>
	<td>1</td>
	<td class="cat">알림</td>
	<td class="sbj1">출력할 질문이 없습니다.</td>
	<td></td>
	<td></td>
	<td><?=getDateFormat($date['totime'],'Y.m.d H:i')?></td>
	</tr> 
	<?php endif?>

	</tbody>
	</table>
	

	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,<?=$p?>,<?=$TPG?>,'<?=$g['img_core']?>/page/default');</script>
	</div>

	<input type="text" name="category" id="iCategory" value="" class="input none" />

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

	if (act == 'scrap_category')
	{
		if (getId('iCategory').style.display == 'inline')
		{
			if (f.category.value == '')
			{
				alert('지정하려는 분류명을 입력해 주세요.   ');
				f.category.focus();
				return false;
			}
		}
		else {
			getId('iCategory').style.display = 'inline';
			f.category.focus();
			return false;
		}
	}
	
	if(confirm('정말로 실행하시겠습니까?    '))
	{
		f.a.value = act;
		f.submit();
	}
}
//]]>
</script>


