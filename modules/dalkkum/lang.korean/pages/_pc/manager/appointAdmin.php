<?php
	if(!defined('__KIMS__') || !$group) exit;
	checkAdmin(0);
	$GD = getUidData('rb_dalkkum_group',$group);
	$_where = "";
	if($mentor_grade) $_where .= " and (mentor_grade>=".$mentor_grade.")";
	if($mentor_score) $_where .= " and (mentor_score>=".$mentor_score.")";
	$_JD = db_query("select M.memberuid, M.name, M.mentor_confirm, M.name, M.email, M.tel2, J.name as jobName from rb_s_mbrdata M left outer join rb_dalkkum_job J on M.mentor_job=J.uid",$DB_CONNECT);
	print_r($FLArray);
	$NUM = db_num_rows($_JD);
?>
	<div id="select_sc">
		<div class="header">
			<h1>담당자 추가</h1>
			<div class="guide">
			추가할 담당자를 선택해주세요.
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
<form name="selectForm" target="actionFrame" action="<?php echo $g['s']?>/?r=home&iframe=Y&m=dalkkum&front=manager" method="post" onsubmit="return confirm('선택한 회원(들)을 담당자로 추가하시겠습니까?');">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="dalkkum" />
		<input type="hidden" name="a" value="actionGroup" />
		<input type="hidden" name="act" value="addAdmin" />
		<input type="hidden" name="uid" value="<?=$group?>" />
		<style>
		input.long[type="text"], select.long{height: 35px; line-height: 35px; margin-left: 10px; box-sizing: border-box;}
		select.long{width: 120px; }
			#table_cate {margin:0 10px 10px 0;}
		}
		</style>
		<div class="cl">
			<div class="content">
				<table id="mentor_list" border="1">
					<tr>
						<th colspan="6">전체 회원 리스트</th>
					</tr>
					<tr>
						<th width="30">MUID</th>
						<th width="60">이름</th>
						<th width="60">직업</th>
						<th width="120">이메일</th>
						<th width="60">연락처</th>
						<th width="30">선택</th>
					</tr>
				<?php while($JD = db_fetch_assoc($_JD)):
					$JD['job'] = getJobName($JD['memberuid']);
				?>
					<tr id="trl_<?=$JD['memberuid']?>" data-value="<?=$JD['memberuid'].'%%'.$JD['name'].'%%'.$JD['jobName'].'%%'.$JD['email'].'%%'.$JD['tel2']?>" class="m">
						<td><?=$JD['memberuid']?></td>
						<td><?=$JD['name']?></td>
						<td><?=$JD['jobName']?></td>
						<td><?=$JD['email']?></td>
						<td><?=$JD['tel2']?></td>
						<td><input type="checkbox" name="selects[]" id="chk_<?=$JD['memberuid']?>" onchange="check_jobs('<?=$JD['memberuid']?>');" value="<?=$JD['memberuid']?>"></td>
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
								선택된 회원
							</th></tr>
				</table>
			</div>
		</div>
		<div class="footer">
			<div class="cl" style="margin: 10px 0;">
				<input type="hidden" id="mentor_names" value="" style="width: 200px;">
				<input type="hidden" id="mentor_result" value="">
				<input type="text" class="long" id="select_count" name="select_count" value="0" style="width: 50px; text-align: center;" readonly> 명을 추가합니다.
				<?php if($topage == "mentor_request"):?><a href="/?r=home&iframe=Y&m=dalkkum&front=manager&mytime=&page=mentor_requestList&group=<?=$group?>"><input type="button" value="현재 요청 목록" class="btnblue"></a><?php endif; ?>
				<input type="submit" value="선택완료" class="btnblue">
				<input type="button" id="keywordcnt" value="취소(닫기)" class="btngray" onclick="top.close();">
			</div>
		</div>
		</form>
	</div>
<iframe name="actionFrame" width="0" height="0" frameborder="0"></iframe>
	<script>
	top.resizeTo(900,670);

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

	function check_jobs(num){
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
		$('#select_count').val($('[name="selects[]"]:checked').length);
	}
	function del_list(num){
		var is_check = $('input#chk_'+num);
		if(is_check.prop('checked') == true) {
			is_check.prop('checked',false);
		} else{
			is_check.prop('checked',true);		
		}
		check_jobs(num);
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