<?php

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 40;

$sqlque = "G.sc_seq=SC.uid and find_in_set(".$my['memberuid'].",G.admins)>0 and G.finish='Y'";
$sqlque2 = "find_in_set(".$my['memberuid'].",admins)>0 and finish='Y'";

$RCD = getDbArray('rb_dalkkum_group G, rb_dalkkum_sclist SC',$sqlque,'G.*,SC.name as SCName',$sort,$orderby,$recnum,$p);

$NUM = getDbRows('rb_dalkkum_group',$sqlque2);
$TPG = getTotalPage($NUM,$recnum);
?>

<div id="applylist">
	<h2>현장 관리자</h2>

	<div class="info">

		<div class="article">
			<?php echo number_format($NUM)?>개(<?php echo $p?>/<?php echo $TPG?>페이지)
		</div>

	</form>
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
		<col width="100"> 
		<col width="100"> 
		<col width="100"> 
		<col width="100"> 
		<col width="50"> 
	</colgroup> 
	<thead>
	<tr>
		<th scope="col">번호</th>
		<th scope="col">일시</th>
		<th scope="col">학교</th>
		<th scope="col">수업명</th>
		<th scope="col">평가하기</th>
		<th scope="col" class="side2">비고</th>
	</tr>
	</thead>
	<tbody>
	<?php while($R=db_fetch_array($RCD)):	?>
	<tr>
		<td><?=$NUM-((($p-1)*$recnum)+$_rec++)?></td>
		<td><?=getDateFormat($R['date_start'],'Y.m.d') ?></td>
		<td><?=$R['SCName']?></td>
		<td><?=$R['name']?></td>
		<td><input type="button" value="평가하기" onclick="show_scorelist(<?=$R['uid']?>)"></td>
		<td></td>
	</tr> 
	<tr data-toggle="scorelist" data-listnum="<?=$R['uid']?>">
		<td colspan="6" style="padding: 0 20px 20px 20px;">
			<table style="background-color: #eee; ">
				<tr>
					<td colspan="12"><b><?=$R['SCName']?> <<?=$R['name']?>> 강의 멘토리스트</b></td>
				</tr>
				<tr>
					<th width="50">번호</td>
					<th width="100">멘토이름</td>
					<th width="100">직업</td>
					<th width="50">등급</td>
					<th width="50">점수</td>
					<th width="50">강의료</td>
					<th width="100">강의내용</td>
					<th width="100">매너</td>
					<th width="100">수업분위기</td>
					<th width="100">출결</td>
					<th width="100">관리</td>
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
					$_sql = "select M.memberuid, M.name, G.uid as groupuid, G.program_seq as program, J.name as jobName,M.mentor_grade as grade,M.mentor_score as score, G.date_start, S.* from rb_dalkkum_team as T, rb_dalkkum_group as G, rb_dalkkum_job as J, rb_s_mbrdata as M LEFT OUTER JOIN rb_dalkkum_score as S on M.memberuid=S.mentor_seq and S.group_seq=".$R['uid']." where T.mentor_seq=M.memberuid and T.group_seq=G.uid and T.job_seq=J.uid and G.uid=".$R['uid']." group by T.mentor_seq order by T.mentor_seq asc";
					$_sql = db_query($_sql, $DB_CONNECT);
					$tmpnum=0;
					while ($PL = db_fetch_array($_sql)):$tmpnum++;?>
					<tr>
						<td><?=$tmpnum?></td>
						<td><?=$PL['name']?></td>
						<td><?=$PL['jobName']?></td>
						<td><?=$gradeName[$PL['grade']]?></td>
						<td><?=$PL['score']?></td>
						<td><?=(class_price($PL['memberuid'], $PL['program'])/10000)?></td>
					<?php for ($i=1; $i <= 3 ; $i++) :?>
						<td>
							<select name="ts_<?=$PL['memberuid']?>_<?=$R['uid']?>[]" id="ts_<?=$PL['memberuid']?>_<?=$R['uid']?>_<?=$i?>">
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
							<select name="ts_<?=$PL['memberuid']?>_<?=$R['uid']?>[]" id="ts_<?=$PL['memberuid']?>_<?=$R['uid']?>_4"<?php if($PL['exact_cash']):?> disabled="disabled"<?php endif; ?>>
								<option value="">선택</option>
								<option<?php if($PL['score4']=='100'):?> selected="selected"<?php endif;?> value="100">이상무</option>
								<option<?php if($PL['score4']=='50'):?> selected="selected"<?php endif;?> value="50">지각</option>
								<option<?php if($PL['score4']=='0' && isset($PL['score4'])):?> selected="selected"<?php endif;?> value="0">결강</option>
							</select></td>
						<td>
						<?php if($PL['score1'] && $PL['score2'] && $PL['score3'] && $PL['score4']):?>
							<input type="button" value="리셋" onclick="resetScore('<?=$PL['memberuid']?>','<?=$R['uid']?>')" data-togglebtn="ts_<?=$PL['memberuid']?>_<?=$R['uid']?>">
						<?php else:?>
							<input type="button" value="적용" onclick="saveScore('<?=$PL['memberuid']?>','<?=$R['uid']?>')" data-togglebtn="ts_<?=$PL['memberuid']?>_<?=$R['uid']?>">
						<?php endif; ?>
						</td>
					</tr>
					<?php endwhile; ?>
					<?php if(!$tmpnum):?>
						<tr>
							<td colspan="11" class="center">출력할 멘토가 없습니다.</td>
						</tr>
					<?php endif; ?>
			</table>
		</td>
	</tr> 
	<?php endwhile?> 
	<?php if(!$NUM):?>
	<tr>
		<td colspan="6">요청받은 내역이 없습니다.</td>
	</tr> 
	<?php endif?>

	</tbody>
	</table>
	

	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'<?php echo $g['img_core']?>/page/default');</script>
	</div>

	

</div>


<script type="text/javascript">
//<![CDATA[

function show_scorelist(listnum){
	var nowshow = $('[data-toggle="scorelist"][data-listnum="'+listnum+'"]').css('display');
	if(nowshow=='none'){
		$('[data-toggle="scorelist"]').hide();
		$('[data-toggle="scorelist"][data-listnum="'+listnum+'"]').show();
	} else{
		$('[data-toggle="scorelist"]').hide();
	}
}
function saveScore(MUID,GUID){
	var score1 = $('#ts_'+MUID+'_'+GUID+'_1');
	var score2 = $('#ts_'+MUID+'_'+GUID+'_2');
	var score3 = $('#ts_'+MUID+'_'+GUID+'_3');
	var score4 = $('#ts_'+MUID+'_'+GUID+'_4');
	if(score1 && score2 && score3 && score4 && MUID && GUID){
	    var form_data = {
	        act: 'saveScore',
	        group: GUID,
	        uid: MUID,
	        score1: score1.val(),
	        score2: score2.val(),
	        score3: score3.val(),
	        score4: score4.val(),
	        end: 'not'
	    };
	    $.ajax({
	        type: "POST",
	        url: "/?r=home&m=dalkkum&a=actionGroup",
	        data: form_data,
	        success: function(response) {
	            results = JSON.parse(response);
	            if(results.code == '100') {
	            	var change_onclick = "resetScore('"+MUID+"','"+GUID+"');";
	            	$('[data-togglebtn="ts_'+MUID+'_'+GUID+'"]').val('리셋');
	            	$('[data-togglebtn="ts_'+MUID+'_'+GUID+'"]').attr('onclick', change_onclick);
	            }
	            if(results.msg) alert(results.msg);
	        }
	    });
	}else{
		alert('점수를 모두 선택해주세요.');
	}
}

function resetScore(MUID,GUID){
	var score1 = $('#ts_'+MUID+'_'+GUID+'_1');
	var score2 = $('#ts_'+MUID+'_'+GUID+'_2');
	var score3 = $('#ts_'+MUID+'_'+GUID+'_3');
	var score4 = $('#ts_'+MUID+'_'+GUID+'_4');
	if(MUID){
	    var form_data = {
	        act: 'resetScore',
	        group: GUID,
	        uid: MUID,
	        end: 'not'
	    };
	    $.ajax({
	        type: "POST",
	        url: "/?r=home&m=dalkkum&a=actionGroup",
	        data: form_data,
	        success: function(response) {
	            results = JSON.parse(response);
	            if(results.code == '100'){
	            	var change_onclick = "saveScore('"+MUID+"','"+GUID+"');";
	            	$('[data-togglebtn="ts_'+MUID+'_'+GUID+'"]').val('적용');
	            	$('[data-togglebtn="ts_'+MUID+'_'+GUID+'"]').attr('onclick', change_onclick);
					score1.val('');
					score2.val('');
					score3.val('');
					score4.val('');

	            }
	            if(results.msg) alert(results.msg);
	        }
	    });
	}else{
		alert('에러가 발생하였습니다.');
	}
}
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


