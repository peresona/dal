
<div id="pages_join">

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);" enctype="multipart/form-data">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="c" value="<?php echo $c?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="join" />
	<input type="hidden" name="check_id" value="0" />
	<input type="hidden" name="check_email" value="0" />
	<input type="hidden" name="comp" value="<?php echo $comp?>" />
	<input type="hidden" name="is" value="<?php echo $is?>" />

	<h2>회원정보</h2>
	<div class="join_cl">
		<font class="black">이메일</font><br>
		<input type="text" id="userid" name="id" class="d_form_underline" placeholder="이메일 주소를 입력해주세요" value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',0)?>">
		<div id="msg_id" class="cl red"></div>
	</div>
	<div class="join_cl">
		<div class="fl" style="width:48%;">
			<font class="black">패스워드</font><br>
			<input type="password" id="password" name="pw" class="d_form_underline" placeholder="패스워드를 입력해주세요" value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',0)?>">
		</div>
		<div class="fr" style="width:48%;">
			<font class="black">패스워드 확인</font><br>
			<input type="password" id="password_check" name="pw1" class="d_form_underline" placeholder="패스워드를 한 번 더 입력해주세요" value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',0)?>">
		</div>
	</div>
	<div class="join_cl">
		<font class="black">이름</font><br>
		<input type="text" name="name" value="<?php echo $regis_name?>" placeholder="이름을 입력해주세요" maxlength="10" class="d_form_underline" />
	</div>
	<div class="join_cl">
		<div class="cl"> <font class="black">전화번호</font><br> </div>
		<div class="cl">
			<input type="text" name="tel2_1" value="" maxlength="3" size="4" placeholder="" class="d_form_underline center" style="width : 20%" />-
			<input type="text" name="tel2_2" value="" maxlength="4" size="4" placeholder="" class="d_form_underline center" style="width : 20%" />-
			<input type="text" name="tel2_3" value="" maxlength="4" size="4" placeholder="" class="d_form_underline center" style="width : 20%" />
			<input type="checkbox" name="sms" value="1" checked="checked" />수신
		</div>
	</div>
	<?php if($d['member']['form_birth']):?>
	<div class="join_cl">
		<div class="cl"><font class="black">생년월일</font><br></div>
		<div id="select_birth" class="cl" style="margin-top: 10px;">
			<select name="birth_1">
			<option value="">선택</option>
			<?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
			<option value="<?php echo $i?>"<?php if(substr($i,-2)==substr($regis_jumin1,0,2)):?> selected="selected"<?php endif?>><?php echo $i?>년</option>
			<?php endfor?>
			</select>
			<select name="birth_2">
			<option value="">선택</option>
			<?php for($i = 1; $i < 13; $i++):?>
			<option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($regis_jumin1,2,2)):?> selected="selected"<?php endif?>><?php echo $i?>월</option>
			<?php endfor?>
			</select>
			<select name="birth_3">
			<option value="">선택</option>
			<?php for($i = 1; $i < 32; $i++):?>
			<option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($regis_jumin1,4,2)):?> selected="selected"<?php endif?>><?php echo $i?>일</option>
			<?php endfor?>
			</select>
			<input type="checkbox" name="birthtype" value="1" />음력
		</div>
	</div>
	<?php endif; ?>
	<div class="join_cl">
		<div class="cl"><font class="black">프로필 사진</font><br></div>
		<div data-inhtml="mypic_change">
			
		</div>
		<div id="select_pic" class="cl" style="margin-top: 10px;">

		<?php if(strpos($g['url_host'], 'app.') && strpos($_SERVER['HTTP_USER_AGENT'],'Android')):?>
			<input type="button" value=" 사진 변경 " onclick="upload_photo('mypic_change','image/*','change_photo');"><br>
			<input type="hidden" name="mypic_change" value="">
		<?php else: ?>
			<input type="file" name="upfile" class="upfile"><br>
		<?php endif; ?>
			* 가로 1024픽셀 세로 768픽셀 미만인 사진파일
		</div>
	</div>
<br>
<?php if($is != 'mentor'):?>
	<h2>추가 정보</h2>
	<?php if($d['member']['form_addr']):?>
	<div class="join_cl">
		<div class="cl"><font class="black">주소</font><br></div>
				<div id="addrbox">
		<div>
		<input type="text" name="zip_1" id="zip1" value="" maxlength="3" size="3" readonly="readonly" class="d_form_underline" style="width:20%" />-
		<input type="text" name="zip_2" id="zip2" value="" maxlength="3" size="3" readonly="readonly" class="d_form_underline" style="width:20%" /> 
		<input type="button" value="우편번호" class="btngray btn" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&m=zipsearch&zip1=zip1&zip2=zip2&addr1=addr1&focusfield=addr2');" />
		</div>
		<div><input type="text" name="addr1" id="addr1" value="" size="55" readonly="readonly" class="d_form_underline" placeholder="우편번호를 검색해주세요." /></div>
		<div><input type="text" name="addr2" id="addr2" value="" size="55" class="d_form_underline" placeholder="상세주소를 입력해주세요." /></div>
		</div>
		<?php if($d['member']['form_foreign']):?>
		<div class="remail shift" style="font-size: 12px;">
		<input type="checkbox" id="is_foreign" name="foreign" value="1" onclick="foreignChk(this);" /><label for="is_foreign"><span id="foreign_ment">해외거주자일 경우 체크해 주세요.</span></label>
		</div>
		<?php endif?>
	</div>
	<?php endif; ?>
<?php endif; ?>
	<?php if($is!='mentor'):?>
	<div class="join_cl">
		<font class="black">학교</font><br>
		<input type="text" name="sc_name" value="<?php echo $regis_name?>" placeholder="이름을 입력해주세요" maxlength="15" class="d_form_underline" />
	</div>
	<div class="join_cl">
		<div class="fl" style="width: 32%; margin-right:2%;"><font class="black">학년</font><br> <input type="text" name="sc_grade" maxlength="3" size="4" class="d_form_underline" placeholder="학년을 입력해주세요." /></div>
		<div class="fl" style="width: 32%; margin-right:2%;"><font class="black">반</font><br> <input type="text" name="sc_class" maxlength="3" size="4" class="d_form_underline" placeholder="반을 입력해주세요." /></div>
		<div class="fl" style="width: 32%;"><font class="black">번호</font><br> <input type="text" name="sc_num" maxlength="3" size="4" class="d_form_underline" placeholder="번호를 입력해주세요." /></div>
	</div>
	<h2>학부모 정보</h2>
	<div class="join_cl">
		<div class="fl" style="width: 48%; margin-right:2%;"><font class="black">관계</font><br> 
		<select name="sc_parent_kind" id="sc_parent_kind">
			<option value="M">어머니</option>
			<option value="F">아버지</option>
			<option value="E">그 외</option>
		</select></div>
		<div class="fl" style="width: 48%; margin-left:2%;"><font class="black">성함</font><br> <input type="text" name="sc_parent_name" maxlength="3" size="4" class="d_form_underline" placeholder="학부모 성함을 입력해주세요." /></div>
	</div>
	<div class="join_cl">
		<div class="cl"> <font class="black">학부모 전화번호</font><br> </div>
		<div class="cl">
			<input type="text" name="sc_parent_tel_1" value="" maxlength="3" size="4" placeholder="" class="d_form_underline center" style="width : 20%" />-
			<input type="text" name="sc_parent_tel_2" value="" maxlength="4" size="4" placeholder="" class="d_form_underline center" style="width : 20%" />-
			<input type="text" name="sc_parent_tel_3" value="" maxlength="4" size="4" placeholder="" class="d_form_underline center" style="width : 20%" />
		</div>
	</div>
	<br>
	<?php else:?>
	<br>
	<h2>강사정보</h2>
	<!--
	<div id="mentor_job" class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">직업</font></div>
		</div>
		<div class="cl">
				<select name="m_job_category" id="m_job_category" class="m_job_select" onchange="select_job(this.value);">
						<option value="">선택</option>
					<?php
						$db_c = getDbSelect('rb_dalkkum_job','depth=1','uid,name');
						while($_C = db_fetch_array($db_c)):
					?>
						<option value="<?=$_C['uid']?>"><?=$_C['name']?></option>
					<?php endwhile;?>
				</select>
				<select name="mentor_job" id="m_job_category2" class="m_job_select" style="display: none;">
						<option value="">선택</option>
				</select>
		</div>
	</div>-->	<div id="mentor_address" class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">멘토 위치</font></div>
		</div>
		<div class="cl">
			<script type="text/javascript" src='http://maps.google.com/maps/api/js?key=AIzaSyCrnWttsGI8pPdETvOA1DBiPNueaEa6cIc&sensor=false&libraries=places'></script>
			<script src="/static/locationpicker.jquery.min.js"></script>
			<input type="hidden" id="addr_lat" name="addr_lat">
			<input type="hidden" id="addr_long" name="addr_long">
			<input type="text" id="address" class="d_form_underline" name="address" style="width: 100%;" value="<?=$addr_address?>"><br>
			<input type="text" id="address_detail" class="d_form_underline" name="address_detail" style="width: 100%;" placeholder="상세주소"
			 value="<?=$my['address_detail']?>">
			<div id="grp_map" style="width: 100%; height: 400px;"></div>
			<script>
			    $('#grp_map').locationpicker({
					location: {
					latitude: <?=($my['addr_lat']?$my['addr_lat']:'37.49789009883285')?>,
					longitude: <?=($my['addr_long']?$my['addr_long']:'127.02757669561147')?>
					},
					radius: 0,
					<?php if($my['addr_lat']) echo "zoom: 18," ?>
					inputBinding: {
					latitudeInput: $('#addr_lat'),
					longitudeInput: $('#addr_long'),
					locationNameInput: $('#address')
					},
					enableAutocomplete: true
				});
			</script>
		</div>
	</div>
	<div id="mentor_job" class="join_cl" style="overflow-y: visible;">
		<div class="cl">
				<div class="fl"><font class="black">직업</font></div>
		</div>
		<div class="cl" style="overflow: visible;">
		<?php getWidget('search_job',array('inputName'=>'mentor_job','job'=>$my['mentor_job']))?>
		</div>
	</div>
	<div id="plus_edu" class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">학력사항</font></div>
				<div class="fr"><span data-addcell="edu" class="btn addcell">추가하기</span></div>
		</div>
		<div class="cl pr">
				<div class="pa" style="top:0px; right: 30px;"><input type="checkbox" name="m_edu_hidden[]" value="1"> 숨김 </div>
				<input type="text" name="m_edu[]" placeholder="재학기간 | 학교명 및 전공 | 구분" class="d_form_underline"  autocomplete="off" /></div>
	</div>
	<div id="plus_career" class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">경력사항</font></div>
				<div class="fr"><span data-addcell="career" class="btn addcell">추가하기</span></div>
		</div>
		<div class="cl pr">
				<div class="pa" style="top:0px; right: 30px;"><input type="checkbox" name="m_career_hidden[]" value="1"> 숨김 </div>
				<input type="text" name="m_career[]" placeholder="근무기간 ㅣ 회사명 및 부서 ㅣ 직위 ㅣ 담당업무" class="d_form_underline"  autocomplete="off" />
		</div>
	</div>
	<div id="plus_cert" class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">자격증</font></div>
				<div class="fr"><span data-addcell="cert" class="btn addcell">추가하기</span></div>
		</div>
		<div class="cl pr">
				<div class="pa" style="top:0px; right: 30px;"><input type="checkbox" name="m_cert_hidden[]" value="1"> 숨김 </div>
				<input type="text" name="m_cert[]" placeholder="발급일 ㅣ 자격증명 ㅣ 발급기관" class="d_form_underline"  autocomplete="off" />
		</div>
	</div>
	<div id="plus_prize" class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">수상경력</font></div>
				<div class="fr"><span data-addcell="prize" class="btn addcell">추가하기</span></div>
		</div>
		<div class="cl pr">
				<div class="pa" style="top:0px; right: 30px;"><input type="checkbox" name="m_prize_hidden[]" value="1"> 숨김 </div>
				<input type="text" name="m_prize[]" placeholder="발급일 ㅣ 자격증명 ㅣ 발급기관" class="d_form_underline"  autocomplete="off" />
		</div>
	</div>
	<div id="plus_teaching" class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">강의경력</font></div>
				<div class="fr"><span data-addcell="teaching" class="btn addcell">추가하기</span></div>
		</div>
		<div class="cl pr">
				<div class="pa" style="top:0px; right: 30px;"><input type="checkbox" name="m_teaching_hidden[]" value="1"> 숨김 </div>
				<input type="text" name="m_teaching[]" placeholder="강의명 ㅣ 날짜 ㅣ 기관" class="d_form_underline"  autocomplete="off" />
		</div>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">강의 가능 일시</font></div>
		</div>
		<div class="cl">
				<input type="text" name="m_time" placeholder="요일, 가능시간 등으로 기록" class="d_form_underline"  required="required" autocomplete="off" />
		</div>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">멘토의 한마디</font></div>
		</div>
		<div class="cl">
				<input type="text" name="m_talk" placeholder="한마디를 남겨주세요." class="d_form_underline"  required="required" autocomplete="off" />
		</div>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">자기소개(멘토 등록 이유)</font></div>
		</div>
		<div class="cl">
				<input type="text" name="m_intro" placeholder="자기 소개를 남겨주세요." class="d_form_underline"  required="required" autocomplete="off" />
		</div>
	</div>
	<br>
	<h2>인터뷰</h2>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">1) 학창시절 가장 고민했던 것은 무엇인가?</font></div>
		</div>
		<div class="cl">
				<textarea name="i_1" id="interview_1" rows="10" class="d_form_area" maxlength="300" autocomplete="off" required="required"></textarea>
		</div>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">2) 학창 시절로 돌아가면 반드시 이것을 꼭 해보고 싶다?
</font></div>
		</div>
		<div class="cl">
				<textarea name="i_2" id="interview_2" rows="10" class="d_form_area" maxlength="300" autocomplete="off" required="required"></textarea>
		</div>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">3) 나는 지금 하는 일을 왜 하게되었는가?
</font></div>
		</div>
		<div class="cl">
				<textarea name="i_3" id="interview_3" rows="10" class="d_form_area" maxlength="300" autocomplete="off" required="required"></textarea>
		</div>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">4) 현재 가장 만족하고 있는 부분과 불만족스러운 부분은?
</font></div>
		</div>
		<div class="cl">
				<textarea name="i_4" id="interview_4" rows="10" class="d_form_area" maxlength="300" autocomplete="off" required="required"></textarea>
		</div>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">5) 나를 롤모델로 삼은 멘티에게 꼭 해주고 싶은 말은?
</font></div>
		</div>
		<div class="cl">
				<textarea name="i_5" id="interview_5" rows="10" class="d_form_area" maxlength="300" autocomplete="off" required="required"></textarea>
		</div>
	</div>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">6) 인터뷰에 들어갈 이미지를 첨부해주세요.<br>(없을 경우 기본이미지로 대체됩니다.)
</font></div>
		</div>
		<div class="cl" data-inhtml="iphoto_change">
			
		</div>
		<div class="cl">
		<?php if(strpos($g['url_host'], 'app.') && strpos($_SERVER['HTTP_USER_AGENT'],'Android')):?>
				<input type="button" value=" 사진 변경 " onclick="upload_photo('iphoto_change','image/*','change_photo');">
				<input type="hidden" name="iphoto_change" >
		<?php else: ?>
				<input type="file" name="i_pic" class="d_form_underline" />
		<?php endif; ?>
		</div>
	</div>
	<br>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">7) 인터뷰에 들어갈 영상을 첨부해주세요. </font></div>
		</div>
		<div class="cl" data-inhtml="ivideo_change">
			
		</div>
		<div class="cl">
			<center>
			<?php if(strpos($g['url_host'], 'app.') && strpos($_SERVER['HTTP_USER_AGENT'],'Android')):?>
				<br><input type="button" value=" 인터뷰 영상 첨부 " onclick="upload_photo('ivideo_change','video/*','video_change');"></center>
				<input type="hidden" name="ivideo_change" value="">
			<?php else: ?>
				<input type="file" name="i_video" accept="video/*"><br>
				(50M 미만의 wmv, mp4, avi 파일)
			<?php endif; ?>
			</center>
		</div>
	</div>
	<br>
	<div class="join_cl">
		<input type="checkbox" id="not_crime" name="not_crime" value="Y"><label for="not_crime">성범죄조회 동의진행 및 인터뷰요청에 동의합니다. (선택) <br><font class="red">* 학교 강사 활동 시 필수 사항이며, 동의 하지 않을 경우 활동이 제한됩니다</font></label>
	</div>
	<?php endif; ?>
	<br>
	<h2>이용약관</h2>
	<div class="join_cl">
		<textarea name="agree" id="agreebox" class="agreebox" readonly ><?php readfile($g['dir_module'].'var/agree1.txt')?></textarea>
		<br>
		<input type="checkbox" id="agree_1" name="agree_1" value="Y"><label for="agree_1">위의 이용약관에 동의합니다.</label>
	</div>
	<br>
	<h2>개인정보 취급방침</h2>
	<div class="join_cl">
		<textarea name="agree2" id="agreebox2" class="agreebox" readonly><?php readfile($g['dir_module'].'var/agree2.txt')?></textarea>
		<br>
		<input type="checkbox" id="agree_2" name="agree_2" value="Y"><label for="agree_2">위의 개인정보 취급방침에 동의합니다.</label>
	</div>
	<div class="submitbox">
		<input type="hidden" name="hiddens" id="hiddens">
		<input type="button" value="가입취소" class="btngray" onclick="goHref('<?php echo $g['r']?>/');" />
		<input type="submit" value="회원가입" class="btnblue" />
	</div>

	</form>

</div>

<script type="text/javascript">
//<![CDATA[

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

	<?php if($d['member']['form_birth']&&$d['member']['form_birth_p']):?>
	if (f.birth_1.value == '')
	{
		alert('생년월일을 지정해 주세요.');
		f.birth_1.focus();
		return false;
	}
	if (f.birth_2.value == '')
	{
		alert('생년월일을 지정해 주세요.');
		f.birth_2.focus();
		return false;
	}
	if (f.birth_3.value == '')
	{
		alert('생년월일을 지정해 주세요.');
		f.birth_3.focus();
		return false;
	}
	<?php endif?>

	if (f.check_id.value == '0')
	{
		alert('아이디를 확인해 주세요.');
		f.id.focus();
		return false;
	}

	if (f.pw1.value == '')
	{
		alert('패스워드를 입력해 주세요.');
		f.pw1.focus();
		return false;
	}
	if (f.pw2.value == '')
	{
		alert('패스워드를 한번더 입력해 주세요.');
		f.pw2.focus();
		return false;
	}
	if (f.pw1.value != f.pw2.value)
	{
		alert('패스워드가 일치하지 않습니다.');
		f.pw1.focus();
		return false;
	}


<?php if($is=='mentor'):?>
	if (f.mentor_job.value == '')
	{
		alert('멘토 직업을 선택하세요.');
		f.mentor_job.focus();
		return false;
	}
	if (f.m_time.value == '')
	{
		alert('강의 가능 시간을 입력해주세요.');
		f.m_time.focus();
		return false;
	}
	if (f.m_intro.value == '')
	{
		alert('멘토 등록 이유를 입력해주세요.');
		f.m_intro.focus();
		return false;
	}

<?php endif; ?>

	if(!$('#agree_1').is(":checked")){
		alert('약관에 동의해주세요.');
		$('#agree_1').focus();
		return false;
	}
	if(!$('#agree_2').is(":checked")){
		alert('약관에 동의해주세요.');
		$('#agree_2').focus();
		return false;
	}


	<?php if($d['member']['form_addr'] && $is != 'mentor' &&$d['member']['form_addr_p']):?>
	if (!f.foreign || f.foreign.checked == false)
	{
		if (f.addr1.value == ''||f.addr2.value == '')
		{
			alert('주소를 입력해 주세요.');
			f.addr2.focus();
			return false;
		}
	}
	<?php endif?>

	
	var radioarray;
	var checkarray;
	var i;
	var j = 0;
	return confirm('정말로 가입하시겠습니까?       ');
}
function cell_del(what){
	$(what).parent().remove();
}


<?php if(strpos($g['url_host'], 'app.') && strpos($_SERVER['HTTP_USER_AGENT'],'Android')):?>
function video_change(arg){
		var str = arg.split("#*%*#");
		if(str[0]) var change_obj = $('[data-inhtml="'+str[0]+'"]'); // 바꿀 이미지 대상 inhtml 값
		if($('input[name="'+str[0]+'"]')) $('input[name="'+str[0]+'"]').val(arg); // 문구 그대로 전송

		if(str[1] && change_obj) change_obj.html('<iframe width="100%" height="275" src="'+str[1]+'" frameborder="0" allowfullscreen></iframe><br>'); // 영상 대상 inhtml 값
		if(str[2]) alert(str[2]); // 메시지 알림
}
function change_photo(arg){
		var str = arg.split("|");
		if(str[0]) var change_obj = $('[data-inhtml="'+str[0]+'"]'); // 바꿀 이미지 대상 inhtml 값
		if(str[0] == 'mypic_change'){
			var moresrc = rooturl + '/_var/simbol/180.';
		}else if(str[0] == 'iphoto_change'){
			var moresrc = rooturl + '/_var/iphoto/360.';
		}
		if($('input[name="'+str[0]+'"]')) $('input[name="'+str[0]+'"]').val(str[1]);
		if(str[1] && change_obj) change_obj.html('<img src="'+moresrc + str[1]+'" width="180" alt="" />'); // 바꿀 이미지 대상 inhtml 값
		if(str[2]) alert(str[2]);
}

function upload_photo(objName,type,succFn){
	var param = {
		desUrl : rooturl + "/?r=home&m=member&a=uptemp_mphoto&objName="+objName, // 파일 전송될 주소
		type : type,
		succFn : succFn // 성공 전달 함수 이름
	};
	if(type == 'video/*') param['desUrl'] = rooturl + "/?r=home&m=member&a=uptemp_mvideo&objName="+objName; // 파일 전송될 주소
	Hybrid.exe('HybridIf.openFileChooser', param);
}

<?php endif; ?>


$(document).ready(function(){
	$("#userid").on('keyup',function() {
		var regex=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;   
		var id_checks = regex.test($(this).val());
		if (id_checks == true){
			var form_data = {
				need: 'check_id',
				iframe:'Y',
				id:$(this).val(),
				is_ajax: 1
			};
			$.ajax({
				type: "POST",
				url: "/?r=home&m=dalkkum&a=getData",
				data: form_data,
				success: function(response) {
					results = JSON.parse(response);
					$('#msg_id').html(results.msg);
					$('[name="check_id"]').val(results.check);
					$('[name="check_email"]').val(results.check);
				}
			});
		} else{
					$('#msg_id').html('<font color="red">이메일 형식이 올바르지 않습니다.</font>');
		}
	});

	$('[data-addcell]').on('click',function(){
		var mode = $(this).data('addcell');
		var inwhat, placeholder;
		if(mode == "edu") {
			placeholder = "재학기간 | 학교명 및 전공 | 구분";
		}
		else if(mode == "career") {
			placeholder = "근무기간 ㅣ 회사명 및 부서 ㅣ 직위 ㅣ 담당업무";
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
			inwhat = '<div class="cl pr"><div class="pa" style="top:0px; right: 30px;"><input type="checkbox" name="m_'+mode+'_hidden[]" value="1"> 숨김 </div><span onclick="cell_del(this)" class="icon cell_del cp"></span><input type="text" name="m_'+mode+'[]" placeholder="'+ placeholder +'" class="d_form_underline" /></div>';
			$('#plus_'+mode).append(inwhat);
	});
});

//]]>
</script>

