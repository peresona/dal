<?php 
include_once $g['dir_module_skin'].'_menu.php';
?>
<div id="pages_join">

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);" enctype="multipart/form-data">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="apply_mentor" />
	<input type="hidden" name="check_nic" value="1" />
	<input type="hidden" name="check_email" value="1" />
	<div class="join_cl">
		<font color="blue">* 실제 멘토로 활동하실 분만 신청해주시기 바랍니다. 운영팀의 검토 및 연락 후 멘토회원으로 임명되며, 최대 2주 정도까지 소요 될 수 있습니다. <br>또 신청 직후 관리자가 확인 전 까지 정보 변경이 불가능하므로, 신중하게 신청 부탁드립니다.</font>
	</div>
	<div class="join_cl">
		<font class="black">이메일 아이디</font><br>
		<?php echo $my['id']?>
		<div id="msg_id" class="cl red"></div>
	</div>
	<div class="join_cl">
		<font class="black">이름</font><br>
		<input type="text" name="name" value="<?php echo $my['name']?>" placeholder="이름을 입력해주세요" maxlength="10" class="d_form_underline"  readonly />
	</div>
	<div class="join_cl">
		<div class="cl"> <font class="black">전화번호</font><br> </div>
		<div class="cl"><?php $tel2=explode('-',$my['tel2'])?>
			<input type="text" name="tel2_1" value="<?php echo $tel2[0]?>" maxlength="3" size="4" placeholder="" class="d_form_underline center" style="width : 20%" />-
			<input type="text" name="tel2_2" value="<?php echo $tel2[1]?>" maxlength="4" size="4" placeholder="" class="d_form_underline center" style="width : 20%" />-
			<input type="text" name="tel2_3" value="<?php echo $tel2[2]?>" maxlength="4" size="4" placeholder="" class="d_form_underline center" style="width : 20%" />
		</div>
	</div>
<br>
	<br>
	<h2>강사정보</h2>
	<?php 
		$myMantor = array();
		$_myMantor = getDbData('rb_dalkkum_mentor',"uid='".$my['memberuid']."'",'*');	
		$hidden_array = explode('|', $_myMantor['hiddens']);
		$_list = array('edu','career','cert','prize','teaching');
		if($_myMantor){
			foreach ($_list as $value) {
				if(substr($_myMantor[$value], -3) == "%%%") $_myMantor[$value] = substr($_myMantor[$value], 0, -3);
				$myMantor[$value] = explode("%%%", $_myMantor[$value]);
			}
		}
		else{
			foreach ($_list as $value) {
				$myMantor[$value] = array('');
			}
		}
	?>
	<div id="mentor_job" class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">직업</font></div>
		</div>
		<div class="cl">
			<input type="text" name="m_jobview" placeholder="우측 검색하기 버튼을 눌러 선택해주세요." class="d_form_underline center" readonly="" value="<?=getJobName($my['mentor_job'])?>" style="width:60%" />
			<input type="hidden" name="mentor_job" readonly="" value="<?=$my['mentor_job']?>"  />
			<input onclick="window.open('<?php echo $g['s']?>/?r=home&iframe=Y&m=dalkkum&front=search&go_form=procForm&go_title=m_jobview&go_num=mentor_job', 'myWindow', 'width=200, height=100'); " type="button" class="btnblue" value="변경하기">
		</div>
	</div>
	<div id="plus_edu" class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">학력사항</font></div>
				<div class="fr"><span data-addcell="edu" class="btn addcell">추가하기</span></div>
		</div>
		<?php foreach ($myMantor['edu'] as $key=>$value):?>
		<div class="cl pr">
				<div class="pa" style="top:0px; right: 40px;"><input type="checkbox" name="m_edu_hidden[]" value="<?=$key+1?>"<?php if(!empty($hidden_array[0]) && (substr($hidden_array[0], $key,1)=='1')):?> checked="checked"<?php endif; ?>> 숨김</div>
				<?php if($key!=0):?><span onclick="cell_del(this)" class="icon cell_del cp"></span><?php endif; ?>
				<input type="text" name="m_edu[]" placeholder="재학기간 | 학교명 및 전공 | 구분" class="d_form_underline" value="<?=$value?>" />
		</div>
		<?php endforeach; ?>
	</div>
	<div id="plus_career" class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">경력사항</font></div>
				<div class="fr"><span data-addcell="career" class="btn addcell">추가하기</span></div>
		</div>
		<?php foreach ($myMantor['career'] as $key=>$value):?>
		<div class="cl pr">
				<div class="pa" style="top:0px; right: 40px;"><input type="checkbox" name="m_career_hidden[]" value="<?=$key+1?>"<?php if(!empty($hidden_array[0]) && ($hidden_array[1][$key]=='1')):?> checked="checked"<?php endif; ?>> 숨김 </div>
				<?php if($key!=0):?><span onclick="cell_del(this)" class="icon cell_del cp"></span><?php endif; ?>
				<input type="text" name="m_career[]" placeholder="근무기간 ㅣ 회사명 및 부서 ㅣ 직위 ㅣ 담당업무(대표경력으로 노출)" class="d_form_underline" value="<?=$value?>" />
		</div>
		<?php endforeach; ?>
	</div>
	<div id="plus_cert" class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">자격증</font></div>
				<div class="fr"><span data-addcell="cert" class="btn addcell">추가하기</span>
				</div>
		</div>
		<?php foreach ($myMantor['cert'] as $key=>$value):?>
		<div class="cl pr">
				<div class="pa" style="top:0px; right: 40px;"><input type="checkbox" name="m_cert_hidden[]" value="<?=$key+1?>"<?php if(!empty($hidden_array[0]) && ($hidden_array[2][$key]=='1')):?> checked="checked"<?php endif; ?>> 숨김 </div>
				<?php if($key!=0):?><span onclick="cell_del(this)" class="icon cell_del cp"></span><?php endif; ?>
				<input type="text" name="m_cert[]" placeholder="발급일 ㅣ 자격증명 ㅣ 발급기관" class="d_form_underline" value="<?=$value?>" />
		</div>
		<?php endforeach; ?>
	</div>
	<div id="plus_prize" class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">수상경력</font></div>
				<div class="fr"><span data-addcell="prize" class="btn addcell">추가하기</span></div>
		</div>
		<?php foreach ($myMantor['prize'] as $key=>$value):?>
		<div class="cl pr">
				<div class="pa" style="top:0px; right: 40px;"><input type="checkbox" name="m_prize_hidden[]" value="<?=$key+1?>"<?php if(!empty($hidden_array[0]) && ($hidden_array[3][$key]=='1')):?> checked="checked"<?php endif; ?>> 숨김 </div>
				<?php if($key!=0):?><span onclick="cell_del(this)" class="icon cell_del cp"></span><?php endif; ?>
				<input type="text" name="m_prize[]" placeholder="수상일 ㅣ 수상 내용 ㅣ 수상기관" class="d_form_underline" value="<?=$value?>" />
		</div>
		<?php endforeach; ?>
	</div>
	<div id="plus_teaching" class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">강의경력</font></div>
				<div class="fr"><span data-addcell="teaching" class="btn addcell">추가하기</span></div>
		</div>
		<?php foreach ($myMantor['teaching'] as $key=>$value):?>
		<div class="cl pr">
				<div class="pa" style="top:0px; right: 40px;"><input type="checkbox" name="m_teaching_hidden[]" value="<?=$key+1?>"<?php if(!empty($hidden_array[0]) && ($hidden_array[4][$key]=='1')):?> checked="checked"<?php endif; ?>> 숨김 </div>
				<?php if($key!=0):?><span onclick="cell_del(this)" class="icon cell_del cp"></span><?php endif; ?>
				<input type="text" name="m_teaching[]" placeholder="강의명 ㅣ 날짜 ㅣ 기관" class="d_form_underline" value="<?=$value?>" />
		</div>
		<?php endforeach; ?>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">강의 가능 일시</font></div>
		</div>
		<div class="cl">
				<input type="text" name="m_time" placeholder="요일, 가능시간 등으로 기록" class="d_form_underline" value="<?=$_myMantor['abletime']?>" />
		</div>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">멘토의 한마디</font></div>
		</div>
		<div class="cl">
				<input type="text" name="m_talk" placeholder="한마디를 남겨주세요." class="d_form_underline" value="<?=$_myMantor['talk']?>" />
		</div>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">자기소개(멘토 등록 이유)</font></div>
		</div>
		<div class="cl">
				<input type="text" name="m_intro" placeholder="자기 소개를 남겨주세요." class="d_form_underline" value="<?=$_myMantor['intro']?>" />
		</div>
	</div>	<br>
	<h2>인터뷰</h2>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">1) 학창시절 가장 고민했던 것은 무엇인가?</font></div>
		</div>
		<div class="cl">
				<textarea name="i_1" id="interview_1" rows="10" class="d_form_area" maxlength="300"><?=$_myMantor['i_1']?></textarea>
		</div>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">2) 학창 시절로 돌아간다면 나는 반드시 이것을 꼭 해보고 싶다?
</font></div>
		</div>
		<div class="cl">
				<textarea name="i_2" id="interview_2" rows="10" class="d_form_area" maxlength="300"><?=$_myMantor['i_2']?></textarea>
		</div>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">3) 나는 지금 하는 일을 왜 하게되었는가?
</font></div>
		</div>
		<div class="cl">
				<textarea name="i_3" id="interview_3" rows="10" class="d_form_area" maxlength="300"><?=$_myMantor['i_3']?></textarea>
		</div>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">4) 현재 삶에서 가장 만족하고 있는 부분과 불만족스러운 부분은?
</font></div>
		</div>
		<div class="cl">
				<textarea name="i_4" id="interview_4" rows="10" class="d_form_area" maxlength="300"><?=$_myMantor['i_4']?></textarea>
		</div>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">5) 마지막으로 나를 롤모델로 삼은 멘티에게 꼭 해주고 싶은 말은?
</font></div>
		</div>
		<div class="cl">
				<textarea name="i_5" id="interview_5" rows="10" class="d_form_area" maxlength="300"><?=$_myMantor['i_5']?></textarea>
		</div>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">6) 인터뷰에 들어갈 영상 또는 이미지를 첨부해주세요.<br>(없을 경우 기본이미지로 대체됩니다.)
</font></div>
		</div>
		<div class="cl">
				<?php if($_myMantor['i_pic']):?><img src="/_var/iphoto/<?=$_myMantor['i_pic']?>" style="max-height: 300px;"><?php endif;?>
				<input type="file" name="i_pic" class="d_form_underline" />
		</div>
	</div>
	<br>
	<div class="join_cl">
		<input type="checkbox" id="not_crime" name="not_crime" value="Y"<?php if($my['not_crime']=='Y'):?> checked="checked"<?php endif; ?>><label for="not_crime">성범죄조회 동의진행 및 인터뷰요청에 동의합니다. (선택) <br><font class="red">* 학교 강사 활동 시 필수 사항이며, 동의 하지 않을 경우 활동이 제한됩니다</font></label>
	</div>
	<div class="submitbox">
		<input type="hidden" name="hiddens" id="hiddens">
		<input type="submit" value="신청하기" class="btnblue" />
	</div>

	</form>

</div>
<script type="text/javascript">
//<![CDATA[
function numberic_hidden(){
	var text = "";
	$('input[name="m_edu_hidden[]"]').each(function(index){
	 	text += (Number(this.checked));
	});
	 	text += "|";
	$('input[name="m_career_hidden[]"]').each(function(index){
	 	text += (Number(this.checked));
	});
	 	text += "|";
	$('input[name="m_cert_hidden[]"]').each(function(index){
	 	text += (Number(this.checked));
	});
	 	text += "|";
	$('input[name="m_prize_hidden[]"]').each(function(index){
	 	text += (Number(this.checked));
	});
	 	text += "|";
	$('input[name="m_teaching_hidden[]"]').each(function(index){
	 	text += (Number(this.checked));
	});
		text = text.replace('%|','|');
		$('#hiddens').val(text);
}

function foreignChk(obj)
{
	if (obj.checked == true)
	{
		getId('addrbox').style.display = 'none';
		getId('foreign_ment').innerHTML= '해외거주자 입니다.';
	}
	else {
		getId('addrbox').style.display = 'block';
		getId('foreign_ment').innerHTML= '해외거주자일 경우 체크해 주세요.';
	}
}
function saveCheck(f)
{
	numberic_hidden();
	if (f.id.value == '')
	{
		alert('이메일을 입력해 주세요.');
		f.id.focus();
		return false;
	}
	if (f.name.value == '')
	{
		alert('이름을 입력해 주세요.');
		f.name.focus();
		return false;
	}

	if (f.mentor_job.value == '')
	{
		alert('직업을 선택해주세요.');
		f.mentor_job.focus();
		return false;
	}



	if (f.tel2_1.value == '')
	{
		alert('휴대폰번호를 입력해 주세요.');
		f.tel2_1.focus();
		return false;
	}
	if (f.tel2_2.value == '')
	{
		alert('휴대폰번호를 입력해 주세요.');
		f.tel2_2.focus();
		return false;
	}
	if (f.tel2_3.value == '')
	{
		alert('휴대폰번호를 입력해 주세요.');
		f.tel2_3.focus();
		return false;
	}


	
	var radioarray;
	var checkarray;
	var i;
	var j = 0;
	return confirm('신청 직후 운영팀의 확인전까지 멘토 신청정보 수정이 불가능하므로, 신중하게 신청 부탁드립니다. 정말 멘토회원을 신청하시겠습니까?');
}
function cell_del(what){
	$(what).parent().remove();
}
function select_job(num){
	var form_data = {
		need: 'job_select',
		cate: num
	};
	$.ajax({
		type: "POST",
		url: "/?r=home&m=dalkkum&a=getData",
		data: form_data,
		success: function(response) {
			results = JSON.parse(response);
			$('#m_job_category2').show();
			$('#m_job_category2').html(results.options);
		}
	});
}

$(document).ready(function(){

	$('[data-addcell]').on('click',function(){
		var mode = $(this).data('addcell');
		var inwhat, placeholder;
		if(mode == "edu") {
			placeholder = "재학기간 | 학교명 및 전공 | 구분";
		}
		else if(mode == "career") {
			placeholder = "근무기간 ㅣ 회사명 및 부서 ㅣ 직위 ㅣ 담당업무(대표경력으로 노출)";
		}
		else if(mode == "cert") {
			placeholder = "발급일 ㅣ 자격증명 ㅣ 발급기관";
		}
		else if(mode == "prize") {
			placeholder = "발급일 ㅣ 자격증명 ㅣ 발급기관";
		}
		else if(mode == "teaching") {
			placeholder = "강의명 ㅣ 날짜 ㅣ 기관";
		}
			inwhat = '<div class="cl pr"><div class="pa" style="top:0px; right: 40px;"><input type="checkbox" name="m_'+mode+'_hidden[]" value="1"> 숨김 </div><span onclick="cell_del(this)" class="icon cell_del cp"></span><input type="text" name="m_'+mode+'[]" placeholder="'+ placeholder +'" class="d_form_underline" /></div>';
			$('#plus_'+mode).append(inwhat);
	});
});

//]]>
</script>





