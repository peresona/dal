<?php
	if(!defined('__KIMS__') || !$group) exit;
	checkAdmin(0);
	$_SCD = db_query("select M.*, R.uid as RUID, R.agree, R.push_date, if(R.group_seq=".$group.",1,0) as firsts from rb_s_mbrdata as M left join rb_dalkkum_request as R on R.mentor_seq=M.memberuid and R.group_seq=".$group." where M.mentor_confirm='Y' order by  field(R.agree,'Y','N') desc ,firsts desc, R.uid asc ",$DB_CONNECT);
	print_r($FLArray);
	$NUM = db_num_rows($_SCD);
?>
	<div id="select_sc">
		<div class="header">
			<h1>멘토 선택</h1>
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
<form name="selectForm" action="<?php echo $g['s']?>/?r=home&iframe=Y&m=dalkkum&front=manager" method="post" onsubmit="return saveCheck(this);" enctype="multipart/form-data">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="dalkkum" />
		<input type="hidden" name="front" value="manager" />
		<input type="hidden" name="page" value="<?=($topage?$topage:'select_mentor2')?>" />
		<input type="hidden" name="mytime" value="<?=$_GET['mytime']?>" />
		<input type="hidden" name="iframe" value="Y" />
		<input type="hidden" name="group" value="<?=$group?>" />
		<div class="cl">
			<div class="content">
					<table id="mentor_list" border="1">
						<tr>
							<th colspan="5">전체 멘토 리스트</th>
						</tr>
						<tr>
							<th width="60">UID</th>
							<th>멘토이름</th>
							<th>직업</th>
							<th width="60">선택</th>
							<th width="60">비고</th>
						</tr>
					<?php while($SCD = db_fetch_assoc($_SCD)):
						$SCD['job'] = getJobName($SCD['mentor_job']);
					?>
						<tr id="trl_<?=$SCD['memberuid']?>" data-value="<?=$SCD['memberuid'].'%%'.$SCD['name'].'%%'.$SCD['job']?>" class="m">
							<td id="muid_<?=$SCD['memberuid']?>"><?=$SCD['memberuid']?></td>
							<td id="mname_<?=$SCD['memberuid']?>"><?=$SCD['name']?></td>
							<td id="mjjob_<?=$SCD['memberuid']?>"><?=$SCD['job']?></td>
							<td><input type="checkbox" name="selects[]" id="chk_<?=$SCD['memberuid']?>" onchange="check_mentor('<?=$SCD['memberuid']?>');" value="<?=$SCD['memberuid']?>"></td>
							<td>
							<?php if($SCD['firsts']>0 && $SCD['agree']=="Y"):?><font style="color:blue; font-weight:bold;">수락</font>
							<?php elseif($SCD['firsts']>0 && $SCD['agree']=="N"):?><font style="color:red; font-weight:bold;">거절</font>
							<?php elseif($SCD['firsts']>0 && $SCD['agree']=="M"):?><font style="color:red; font-weight:bold;">무응답</font>
							<?php elseif($SCD['firsts']>0):?><font style="color:green; font-weight:bold;">요청중</font><?php endif; ?></td>
						</tr>
					<?php endwhile; ?>
					</table>
			</div>
			<div class="contentside">
				<table id="show_select" width="100%" border="1">
						<colgroup>
							<col width="40">
							<col>
							<col width="30">
						</colgroup>
							<tr><th colspan="3" class="pr">
								선택된 멘토
							</th></tr>
				</table>
			</div>
		</div>
		<div class="footer">
			<input type="hidden" id="mentor_names" value="" style="width: 200px;">
			<input type="hidden" id="mentor_result" value="">
			<?php if($topage == "mentor_request"):?><a href="/?r=home&iframe=Y&m=dalkkum&front=manager&mytime=&page=mentor_requestList&group=<?=$group?>"><input type="button" value="현재 요청 목록" class="btnblue"></a><?php endif; ?>
			<input type="submit" value="선택완료" class="btnblue">
			<input type="button" id="keywordcnt" value="취소(닫기)" class="btngray" onclick="top.close();">
		</div>
		</form>
	</div>

	<script>
	top.resizeTo(700,580);

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

	function check_mentor(num){
		var is_check = $('#chk_'+num);
		var m_value = $('tr#trl_'+num).data('value');
			m_value = m_value.split("%%");
		var m_name = m_value[1]; // 이름
		var m_job = m_value[2]; // 직업
		var i = 1;
		$('table#show_select [data-cell="nowtr"]').remove();

		if(is_check.prop('checked') == true) {
			tempArr.push(num);
			tempList.push(m_name+"("+m_job+")");
		} else{
			tempArr.splice($.inArray(num, tempArr),1);
			tempList.splice($.inArray(m_name+"("+m_job+")", tempArr),1);
		}
			tempArr = tempArr.sort(function(a,b){return a - b;}).reduce(function(a,b){if (a.slice(-1)[0] !== b) a.push(b);return a;},[]);
			tempList = tempList.sort(function(a,b){return a - b;}).reduce(function(a,b){if (a.slice(-1)[0] !== b) a.push(b);return a;},[]);

		$.each(tempArr,function(index,value){
			var ms_value = $('tr#trl_'+value).data('value');
				ms_value = ms_value.split("%%");
			var ms_name = ms_value[1]; // 이름
			var ms_job = ms_value[2]; // 직업
			$('table#show_select>tbody').append('<tr data-cell="nowtr" data-no="'+value+'"><td>'+i+'</td><td><b>'+ms_name+'</b><br>'+ms_job+'</td><td onclick="del_list(\''+value+'\');">X</td></tr>');
			i++;
		});
		$('#mentor_names').val(tempList.join(','));
		$('#mentor_result').val(tempArr.join(','));
	}
	function del_list(num){
		var is_check = $('input#chk_'+num);
		if(is_check.prop('checked') == true) {
			is_check.prop('checked',false);
		} else{
			is_check.prop('checked',true);		
		}
		check_mentor(num);
	}

	function saveCheck(f)
	{
		if (f.mentor_result.value == '')
		{
			alert('멘토를 선택해주세요.');
			return false;
		}
		return confirm('정말로 실행하시겠습니까?         ');
	}


	</script>