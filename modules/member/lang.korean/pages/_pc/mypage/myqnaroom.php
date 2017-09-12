<?php 
	$RCD = db_query("select D.*,J.name as jobName,M.name as mentorName,M.memberuid as mentorUID from rb_bbs_data as D, rb_dalkkum_job as J, rb_s_mbrdata as M where (D.gid-floor(D.gid))=0 and  D.mentor_seq=M.memberuid and M.mentor_job=J.uid and bbsid='qna' and mentor_seq='".$my['memberuid']."' and parentmbr='0' order by D.uid desc limit 0,20",$DB_CONNECT);
	$RCD2 = db_query("select D.*,J.name as jobName, M.name as mentorName, J.uid as jobUID 
from rb_bbs_data as D, rb_dalkkum_job as J, rb_s_mbrdata as M where (D.gid-floor(D.gid))=0 and  D.job_seq=M.mentor_job and M.mentor_job=J.uid and bbsid='kin' and parentmbr='0' and M.memberuid='".$my['memberuid']."' order by D.uid desc limit 0,20",$DB_CONNECT);
?>
<div class="myqna" style="margin-right: 1%;">
	<h2>나의 Q&amp;A 게시판</h2>
	<form name="procForm" action="<?=$g['s']?>/" method="post" target="_action_frame_<?=$m?>" onsubmit="return submitCheck(this);">
	<input type="hidden" name="r" value="<?=$r?>" />
	<input type="hidden" name="m" value="<?=$m?>" />
	<input type="hidden" name="front" value="<?=$front?>" />
	<input type="hidden" name="a" value="" />

	<table summary="나의 Q&amp;A 게시판 질문 리스트입니다." data-inhtml="qna">
	<caption>나의 Q&amp;A 게시판 질문들</caption> 
	<colgroup> 
	<col> 
	<col width="70"> 
	<col width="70"> 
	<col width="100"> 
	</colgroup> 
	<thead>
	<tr>
	<th scope="col" class="side1">제목</th>
	<th scope="col">작성자</th>
	<th scope="col">상태</th>
	<th scope="col" class="side2">날짜</th>
	</tr>
	</thead>
	<tbody>

	<?php $NUM=0; while($R=db_fetch_array($RCD)):$NUM++;?>
	<tr>
	<td class="sbj">
		<a href="/mblog/qna/?mentor=<?=$R['mentorUID']?>&uid=<?=$R['uid']?>"><?php echo getStrCut2($R['subject'],'20','')?></a>
		<a href="/mblog/qna/?mentor=<?=$R['mentorUID']?>&uid=<?=$R['uid']?>" target="_blank" style="margin-left:6px;"><img src="<?=$g['img_core']?>/_public/ico_blank.gif" alt="" title="새창으로보기" /></a>
		<?php if(getNew($R['d_regis'],24)):?><span class="new">new</span><?php endif?>
	</td>
	<td><?=$R['name']?></td>
	<td><?=$R['is_reply']?'답변완료':'답변대기'?></td>
	<td><?=getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
	</tr> 
	<?php endwhile?> 
	<?php if(!$NUM):?>
	<tr>
	<td class="sbj1" colspan="4" align="center">내가 한 질문이 없습니다.</td>
	</tr> 
	<?php elseif($NUM>20):?>
	<tr class="cp" onclick="myQnaMoreList(this, 'qna', 20, 20);"><td colspan="4" class="center">더보기</td></tr>
	<?php endif?>
	</tbody>
	</table>


	<input type="text" name="category" id="iCategory" value="" class="input none" />

	</form>
	

</div>

<div class="myqna" style="margin-left: 1%;">

	<h2><?=getJobName($my['mentor_job'])?> 진로 Q&amp;A</h2>

	<form name="procForm" action="<?=$g['s']?>/" method="post" target="_action_frame_<?=$m?>" onsubmit="return submitCheck(this);">
	<input type="hidden" name="r" value="<?=$r?>" />
	<input type="hidden" name="m" value="<?=$m?>" />
	<input type="hidden" name="front" value="<?=$front?>" />
	<input type="hidden" name="a" value="" />
	<table summary="나의 Q&amp;A 게시판 질문 리스트입니다." data-inhtml="kin">
	<caption>나의 Q&amp;A 게시판 질문들</caption> 
	<colgroup> 
	<col> 
	<col width="70"> 
	<col width="100"> 
	</colgroup> 
	<thead>
	<tr>
	<th scope="col" class="side1">제목</th>
	<th scope="col">상태</th>
	<th scope="col" class="side2">날짜</th>
	</tr>
	</thead>
	<tbody>

	<?php $NUM=0; while($R=db_fetch_array($RCD2)):$NUM++;?>
	<tr>
	<td class="sbj">
		<a href="/jblog/kin/?job=<?=$R['jobUID']?>&uid=<?=$R['uid']?>"><?php echo getStrCut2($R['subject'],'20','')?></a>
		<a href="/jblog/kin/?job=<?=$R['jobUID']?>&uid=<?=$R['uid']?>" target="_blank" style="margin-left:6px;"><img src="<?=$g['img_core']?>/_public/ico_blank.gif" alt="" title="새창으로보기" /></a>
		<?php if(getNew($R['d_regis'],24)):?><span class="orange">new</span><?php endif?>
	</td>
	<td><?=$R['is_reply']?'답변완료':'답변대기'?></td>
	<td><?=getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
	</tr> 
	<?php endwhile?> 
	<?php if(!$NUM):?>
	<tr>
	<td class="sbj1" colspan="3" align="center">내가 한 질문이 없습니다.</td>
	</tr> 
	<?php elseif($NUM>20):?>
	<tr class="cp" onclick="myQnaMoreList(this, 'kin', 20, 20);"><td colspan="3" class="center">더보기</td></tr>
	<?php endif?>
	</tbody>
	</table>
	

	<input type="text" name="category" id="iCategory" value="" class="input none" />

	</form>
	

</div>


<script type="text/javascript">
//<![CDATA[

// 게시물 불러오기
function myQnaMoreList(obj, bbsids, indexs, limits){

	var form_data = {
		act: 'myroom',
		bbsids: bbsids,
		indexs: indexs,
		limits: limits
	};
	$.ajax({
		type: "POST",
		url: "/?r=home&m=member&a=action",
		data: form_data,
		success: function(response) {
			$(obj).remove();
			results = JSON.parse(response);
			for (var i = 0; i < results.length; i++) {
				var datas = results[i];
				if(bbsids == 'qna'){
					console.log('qna');
					var inhtmls = '<tr><td class="sbj"><a href="/mblog/qna/?mentor='+(datas.mentor_seq)+'&amp;uid='+(datas.uid)+'">'+(datas.subject)+'</a><a href="/mblog/qna/?mentor=1&amp;uid='+(datas.uid)+'" target="_blank" style="margin-left:6px;"><img src="/_core/image/_public/ico_blank.gif" alt="" title="새창으로보기"></a></td><td>'+(datas.mentorName)+'</td>	<td>'+(datas.status)+'</td><td>'+(datas.regis_dates)+'</td></tr>';
					if(limits == results.length){
						inhtmls += '<tr class="cp" onclick="myQnaMoreList(this, \'qna\', \''+(indexs+limits)+'\', \'20\');"><td colspan="4" class="center">더보기</td></tr>';
					}
				}else if(bbsids == 'kin'){
					var inhtmls = '<tr><td class="sbj"><a href="/jblog/kin/?job='+(datas.uid)+'&amp;uid='+(datas.uid)+'">'+(datas.subject)+'</a><a href="/jblog/kin/?job='+(datas.uid)+'&amp;uid='+(datas.uid)+'" target="_blank" style="margin-left:6px;"><img src="/_core/image/_public/ico_blank.gif" alt="" title="새창으로보기"></a></td><td>'+(datas.status)+'</td><td>'+(datas.regis_dates)+'</td></tr>';
					if(limits == results.length){
						inhtmls += '<tr class="cp" onclick="myQnaMoreList(this, \'kin\', \''+(indexs+limits)+'\', \'20\');"><td colspan="3" class="center">더보기</td></tr>';
					}
				}
					console.log(inhtmls);
				$('table[data-inhtml="'+bbsids+'"] tbody').append(inhtmls);
			}
		}
	});
}
//]]>
</script>


