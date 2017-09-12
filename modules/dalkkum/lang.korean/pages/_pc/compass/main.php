<?php

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;

$sqlque = 'parentmbr=0 and R.job_seq=J.uid and R.bbsid=\'kin\'';

if ($job) {
	$sqlque .= ' and job_seq='.trim($job);
	$_nowjob = getDbData('rb_dalkkum_job as J','J.uid='.$job,'J.uid,J.name,(select name from rb_dalkkum_job where not(J.parent=0) and uid=J.parent) as pname,J.hidden, J.parent');
}

if ($status=='finish') $sqlque .= ' and (is_reply>0)';
elseif ($status=='before') $sqlque .= ' and (is_reply=0)';

if ($where && $keyword)	$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');

$RCD = getDbArray('rb_bbs_data as R, rb_dalkkum_job as J',$sqlque,'R.*, J.name as jobName, J.uid as jobUID',$sort,$orderby,$recnum,$p);
$NUM = getDbRows('rb_bbs_data as R, rb_dalkkum_job as J',$sqlque);
$TPG = getTotalPage($NUM,$recnum);

?>		
<div class="cl" id="page_main">
	<div id="kin_search" class="cl" style=" overflow: visible;">
		<div id="kin_search_btn1" class="btn findTitle center active" onmouseover="search_box('find');">질문찾기</div>
		<div id="kin_search_btn2" class="btn findTitle center" onmouseover="search_box('write');">질문하기</div>
		<div id="kin_select_job" class="fr pr" style="margin: 15px 15px 0 0; height: 32px;">
			<input type="text" id="kin_select_job_keword" name="jkwd" style="box-sizing: border-box; width: 200px; height: 30px;"  placeholder="<?=$job?'직업검색 (현재 : '.getJobName($job).')':'직업 키워드 검색'?>" onfocus="job_autosearch('active');" onkeyup="job_autosearching(this.value);">
			<a href="/compass"><input type="button" id="m_job_cateCancel" class="btn" value="초기화"></a>
			<div id="job_search" class="pa">
				<ul data-inhtml="job_search_list">
					<li class="nothing">키워드를 입력해주세요.</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="kin_search" id="kin_search2_1">
		<form name="searchbox" action="/compass/<?=($job?'?job='.$job:'')?>" method="post">
			<input type="hidden" name="r" value="<?=$r?>" />
			<input type="hidden" name="c" value="<?=$c?>" />
			<input type="hidden" name="m" value="<?=$m?>" />
			<input type="hidden" name="bid" value="<?=$bid?>" />
			<input type="hidden" name="cat" value="<?=$cat?>" />
			<input type="hidden" name="sort" value="<?=$sort?>" />
			<input type="hidden" name="orderby" value="<?=$orderby?>" />
			<input type="hidden" name="recnum" value="<?=$recnum?>" />
			<input type="hidden" name="type" value="<?=$type?>" />
			<input type="hidden" name="iframe" value="<?=$iframe?>" />
			<input type="hidden" name="skin" value="<?=$skin?>" />
			<input type="hidden" name="job" value="<?=$job?>" />
			<input type="hidden" name="mentor" value="<?=$mentor?>" />
			<input type="hidden" name="where" value="subject|tag" />
			<input class="fl" type="text" name="keyword" value="<?=$keyword?>" placeholder="원하시는 키워드로 본문 및 태그를 검색 해보세요!">
			<input class="fr" type="image" value=" 질문하기 " src="<?=$g['img_layout']?>/board/find.gif">
		</form>
	</div>
	<div class="kin_search" id="kin_search2_2">
		<form name="searchbox" action="/jblog/kin/?mod=write" method="post">
			<input type="hidden" name="job" value="<?=$job?>" />
			<input type="hidden" name="mentor" value="<?=$mentor?>" />
			<input class="fl" type="text" name="subject" value="" placeholder="이 직업에 대해 궁금한 점을 물어보세요!">
			<input class="fr" type="image" value=" 질문하기 " src="<?=$g['img_layout']?>/board/write.gif">
		</form>
	</div>

	<div class="cl">
		<span class="fl" style="font-size: 12px; margin-top: 15px; line-height: 32px;"><?php if($job):?><?=$_nowjob['pname']?> > <?=$_nowjob['name']?><?php endif; ?></span>
		<ul id="kin_kind_list" class="fr">
			<li<?php if(!$status || !in_array($status, array('before','finish','end'))):?> class="active"<?php endif;?> onclick="location.href='/compass/?job=<?=$job?>'">전체</li>
			<li<?php if($status=='before'):?> class="active"<?php endif;?> onclick="location.href='/compass/?job=<?=$job?>&status=before'">답변대기</li>
			<li<?php if($status=='finish' || $step=='end'):?> class="active"<?php endif;?> onclick="location.href='/compass/?job=<?=$job?>&status=finish'">답변완료</li>
		</ul>
	</div>

	<div id="compass">
		<form name="procForm" action="<?=$g['s']?>/" method="post" target="_action_frame_<?=$m?>" onsubmit="return submitCheck(this);">
		<input type="hidden" name="r" value="<?=$r?>" />
		<input type="hidden" name="m" value="<?=$m?>" />
		<input type="hidden" name="front" value="<?=$front?>" />
		<input type="hidden" name="a" value="" />

		<table summary="진로 Q&amp;A 질문 리스트 입니다.">
		<caption><?=$B['name']?$B['name']:'전체게시물'?></caption> 
		<colgroup> 
		<col width="50"> 
		<col width="130"> 
		<col> 
		<col width="80"> 
		<col width="70"> 
		<col width="70"> 
		<col width="110"> 
		</colgroup> 
		<thead>
		<tr>
		<th scope="col" class="side1">번호</th>
		<th scope="col">직업분류</th>
		<th scope="col">제목</th>
		<th scope="col">글쓴이</th>
		<th scope="col">조회</th>
		<th scope="col">상태</th>
		<th scope="col" class="side2">날짜</th>
		</tr>
		</thead>
		<tbody>

		<?php while($R=db_fetch_array($RCD)):?>
		<tr>
		<td><?=$NUM-((($p-1)*$recnum)+$_rec++)?></td>
		<td><a style="color: #333;" href="/compass/?job=<?=$R['jobUID']?>"><?=$R['jobName']?></a></td>
		<td class="sbj">
			<a href="/jblog/kin/?job=<?=$R['job_seq']?>&uid=<?=$R['uid']?>&mode=back" target="_blank"><img src="<?=$g['img_core']?>/_public/ico_blank.gif" alt="" title="새창으로보기" /></a>
			<a href="/jblog/kin/?job=<?=$R['job_seq']?>&uid=<?=$R['uid']?>&mode=back"><?=$R['subject']?></a> <span class="comment"><?=($R['is_reply']?$R['is_reply']:'')?></span>
			<?php if(getNew($R['d_regis'],24)):?> <span class="new">new</span><?php endif?>
		</td>
		<td><?=$R['name']?></td>
		<td><?=$R['hit']?></td>
		<td><?php
		if($R['is_reply']>0) echo "답변완료";
		else echo "답변대기";
		?></td>
		<td><?=getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
		</tr> 
		<?php endwhile?> 

		<?php if(!$NUM):?>
			<td colspan="7">결과 리스트가 없습니다.</td>
		<?php endif?>

		</tbody>
		</table>
		

		<div class="pagebox01">
		<script type="text/javascript">getPageLink(10,<?=$p?>,<?=$TPG?>,'<?=$g['img_core']?>/page/default');</script>
		</div>

		</form>
		

	</div>
</div>