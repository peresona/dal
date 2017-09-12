<?php
	if(!defined('__KIMS__') || !$group) exit;
	checkAdmin(0);
	$GD = getUidData('rb_dalkkum_group',$group);
	$_where = "";
	if($mentor_grade) $_where .= " and (mentor_grade>=".$mentor_grade.")";
	if($mentor_score) $_where .= " and (mentor_score>=".$mentor_score.")";
	$_JD = db_query("select J.*, (select count(*) from rb_s_mbrdata where mentor_job = J.uid".$_where.") as mbr_count from rb_dalkkum_job J where parent and hidden=0",$DB_CONNECT);
	print_r($FLArray);
	$NUM = db_num_rows($_JD);
?>
	<div id="select_sc">
		<div class="header">
			<h1>멘토모집 직업군 추가</h1>
			<div class="guide">
			푸시 및 모집 할 직업군을 선택해주세요.
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
		<input type="hidden" name="page" value="<?=($topage?$topage:'select_jobs2')?>" />
		<input type="hidden" name="iframe" value="Y" />
		<input type="hidden" name="group" value="<?=$group?>" />
		<style>
		input.long[type="text"], select.long{height: 35px; line-height: 35px; margin-left: 10px; box-sizing: border-box;}
		select.long{width: 120px; }
			#table_cate {margin:0 10px 10px 0;}
		}
		</style>
		<div class="cl">
			<div class="content">
				<div id="table_cate">
						<select class="long" name="mentor_grade" id="mentor_grade" onchange="location.href='/?r=home&iframe=Y&m=dalkkum&front=manager&page=select_jobs&group=<?=$group?>&mentor_grade='+this.value+'&mentor_score=<?=$mentor_score?>'">
							<option value="">등급</option>
							<option<?php if($mentor_grade=='5'):?> selected="selected"<?php endif;?> value="5">A</option>
							<option<?php if($mentor_grade=='4'):?> selected="selected"<?php endif;?> value="4">B</option>
							<option<?php if($mentor_grade=='3'):?> selected="selected"<?php endif;?> value="3">C</option>
							<option<?php if($mentor_grade=='2'):?> selected="selected"<?php endif;?> value="2">D</option>
							<option<?php if($mentor_grade=='1'):?> selected="selected"<?php endif;?> value="1">E</option>
						</select> 
						<select class="long" name="mentor_score" id="mentor_score" onchange="location.href='/?r=home&iframe=Y&m=dalkkum&front=manager&page=select_jobs&group=<?=$group?>&mentor_grade=<?=$mentor_grade?>&mentor_score='+this.value">
							<option value="">점수</option>
							<?php for ($i=10; $i <= 100; $i=$i+10) :?>
								<option<?php if($i==$mentor_score):?> selected="selected"<?php endif;?> value="<?=$i?>"><?=$i?></option>
							<?php endfor; ?>
						</select> 
				</div>
					<table id="mentor_list" border="1">
						<tr>
							<th colspan="5">전체 멘토 리스트</th>
						</tr>
						<tr>
							<th width="60">JUID</th>
							<th>직업군</th>
							<th width="60">인원</th>
							<th width="60">선택</th>
							<th width="60">비고</th>
						</tr>
					<?php while($JD = db_fetch_assoc($_JD)):
						$JD['job'] = getJobName($JD['uid']);
					?>
						<tr id="trl_<?=$JD['uid']?>" data-value="<?=$JD['uid'].'%%'.$JD['name'].'%%'.$JD['job']?>" class="m">
							<td><?=$JD['uid']?></td>
							<td><?=$JD['name']?></td>
							<td><?=$JD['mbr_count']?></td>
							<td><input type="checkbox" name="selects[]" id="chk_<?=$JD['uid']?>" onchange="check_jobs('<?=$JD['uid']?>');" value="<?=$JD['uid']?>" data-many="<?=$JD['mbr_count']?>"></td>
							<td>
							<?php if($JD['firsts']>0 && $JD['agree']=="Y"):?><font style="color:blue; font-weight:bold;">수락</font>
							<?php elseif($JD['firsts']>0 && $JD['agree']=="N"):?><font style="color:red; font-weight:bold;">거절</font>
							<?php elseif($JD['firsts']>0 && $JD['agree']=="M"):?><font style="color:red; font-weight:bold;">무응답</font>
							<?php elseif($JD['firsts']>0):?><font style="color:green; font-weight:bold;">요청중</font><?php endif; ?></td>
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
			<div class="cl" style="margin: 10px 0;">
				<input type="hidden" id="mentor_names" value="" style="width: 200px;">
				<input type="hidden" id="mentor_result" value="">
				<input type="text" class="long" id="select_count" name="select_count" value="0" style="width: 50px; text-align: center;" readonly> 직업군 중 <input type="text" id="many_count" name="many_count" class="long" value="<?=$GD['recruit']?>" style="width: 50px; text-align: center;" readonly> 명을 모집중입니다.
				<?php if($topage == "mentor_request"):?><a href="/?r=home&iframe=Y&m=dalkkum&front=manager&mytime=&page=mentor_requestList&group=<?=$group?>"><input type="button" value="현재 요청 목록" class="btnblue"></a><?php endif; ?>
				<input type="submit" value="선택완료" class="btnblue">
				<input type="button" id="keywordcnt" value="취소(닫기)" class="btngray" onclick="top.close();">
			</div>
		</div>
		</form>
	</div>

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