<?php
	if(!defined('__KIMS__')) exit;
	checkAdmin(0);
	$_SCD = db_query("select * from rb_dalkkum_eventapply where group_seq is null order by uid desc",$DB_CONNECT);
	print_r($FLArray);
	$NUM = db_num_rows($_SCD);
?>
	<div id="select_ae">
		<div class="header">
			<h1>행사 요청서</h1>
			<div class="guide">
			인증된 멘토만 검색 후 선택 할 수 있습니다. <br>
			등록 위치 : 관리자 화면 > 달꿈 > 멘토 관리
			</div>
			<div class="fr">
				<div style="margin:10px 20px 0 0; float: right;">
					<input type="text" name="keyword" id="keyword" class="btngray" value="<?=$keyword?>" placeholder="키워드 입력" onkeyup='{filter();return false}' onkeypress='javascript:if(event.keyCode==13){ filter(); return false;}'>
					<input type="button" class="btngray" value="취소" onclick="reset_search();">
				</div>
			</div>
		</div>
		<div class="line1"></div>
		<div class="line2"></div>
		<div class="line3"></div>
<form name="selectForm" action="<?php echo $g['s']?>/?r=home&iframe=Y&m=dalkkum&front=manager" method="post" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="dalkkum" />
		<input type="hidden" name="front" value="manager" />
		<input type="hidden" name="page" value="<?=($topage?$topage:'select_mentor2')?>" />
		<input type="hidden" name="mytime" value="<?=$_GET['mytime']?>" />
		<input type="hidden" name="iframe" value="Y" />
		<input type="hidden" name="group" value="<?=$group?>" />
		<div class="cl content">
			<table id="mentor_list" border="1">
				<tr>
					<th colspan="8">전체 교육 리스트</th>
				</tr>
				<tr>
					<th width="50">APID</th>
					<th width="120">학교명</th>
					<th>주소</th>
					<th width="100">프로그램</th>
					<th width="120">교육일정</th>
					<th width="80">학생수<br>(반별)</th>
					<th width="90">학생<br>변경여부</th>
					<th width="60">선택</th>
				</tr>
			<?php while($SCD = db_fetch_assoc($_SCD)):
				$SCD['job'] = getJobName($SCD['mentor_job']);
				$SCD['fulldate_start'] = $SCD['start_date'].substr($SCD['times'], 0,4);
				$SCD['fulldate_end'] = $SCD['end_date'].substr($SCD['times'], -4,4);
			?>
				<tr id="trl_<?=$SCD['uid']?>" data-value="<?=$SCD['uid'].'%%'.$SCD['a_group']?>" class="m">
					<td><?=$SCD['uid']?></td>
					<td><?=$SCD['a_group']?></td>
					<td><?=$SCD['address']?></td>
					<td><?=getProgramName($SCD['program'])?></td>
					<td><?=getDateFormat($SCD['fulldate_start'],'Y.m.d H:i')?><br> ~ <br><?=getDateFormat($SCD['fulldate_end'],'Y.m.d H:i')?></td>
					<td><?=str_replace('명','',$SCD['std_num'])?></td>
					<td><?=$SCD['a_change']?></td>
					<td><input type="button" value="선택" onclick="select_apply('<?=$SCD[uid]?>')"></td>
				</tr>
			<?php endwhile; ?>
			</table>
		</div>
		<div class="footer">
			<input type="button" id="keywordcnt" value="취소(닫기)" class="btngray" onclick="top.close();">
		</div>
		</form>
	</div>

	<script>
	top.resizeTo(900,560);

	window.onload = function(){
		window.document.body.scroll = "auto";
	}

	var tempArr = new Array();
	var tempList = new Array();
	function filter(){
		if($('#keyword').val()=="")
			$("#mentor_list tr.m").css('display','');			
		else{
			$("#mentor_list tr.m").css('display','none');
			$("#mentor_list tr[data-value*='"+$('#keyword').val()+"']").css('display','');
		}
		return false;
	}
	function reset_search(){
		$('#keyword').val('');
		filter();	
	}

	function select_apply(applyUID){
		opener.open_apply(applyUID);
		top.close();
	}


	</script>