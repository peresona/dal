<div id="pages_join">

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);" enctype="multipart/form-data">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="info_update" />
	<input type="hidden" name="check_nic" value="1" />
	<input type="hidden" name="check_email" value="1" />
	<?php if($my['mentor_confirm']=='Y') $level_ment = '<font color="blue">* 회원님은 현재 멘토 회원 입니다.</font>';
	else if($my['mentor_apply']) $level_ment = '<font color="blue">* 현재 멘토 신청이 접수되었으며 운영팀이 확인 중 입니다.</font><br><a href="/?r=home&m=member&a=action&act=cancel_mentorApply" target=
		"_action_frame_'.$m.'"><input type="button" class="btnblue right" value=" - 신청 취소"></a>';
	else $level_ment = '<input type="button" class="btnblue fr" value=" + 신규멘토등록" onclick="location.href=\'/mypage/?page=apply_mentor\'"><br><font color="blue">* 회원님은 현재 일반 회원입니다.</font>';
	?>
	<h2>회원정보</h2>
	<div class="join_cl pr" style="overflow-y: visible;">
		<div class="pa center" style="right: 40px; top: 0px; width: 210px;"><?=$level_ment?><br><div class="cl" style="margin-top : 10px; border:solid 3px #FEC55A; width: 200px; height: 200px; border-radius: 100px; background: url(/_var/simbol/180.<?=($my['photo']?$my['photo']:'default.jpg')?>) center center; background-size: cover;" data-inhtml="mypic_change"<?php if($my['photo']):?> onclick="del_pic('mypic_change','mypic', '해당 이미지를 삭제하시겠습니까?');"<?php endif; ?>></div><br><center><input type="file" name="upfile" class="upfile" accept="image/*"></center></div>
		<font class="black">이름</font><br>
		<?php echo $my['name']?>(<?php echo $my['id']?>)
		<div id="msg_id" class="cl red"></div>
	</div>
	<div class="join_cl">
		<div class="cl"> <font class="black">암호변경</font> <font style="color: #999; font-size: 10px;">(암호 변경을 원하시면 입력하세요.)</font><br> </div>
		<div class="cl"><?php $tel2=explode('-',$my['tel2'])?>
			<input type="password" name="now_pw" value="" maxlength="50" placeholder="현재 암호 입력" class="d_form_underline center" style="width : 20%" /> 
			<input type="password" name="new_pw" value="" maxlength="50" placeholder="새 암호 입력" class="d_form_underline center" style="width : 20%" /> 
			<input type="password" name="new_pw2" value="" maxlength="50" placeholder="새 암호 확인" class="d_form_underline center" style="width : 20%" />
		</div>
	</div>
	<div class="join_cl">
		<div class="cl"> <font class="black">전화번호</font><br> </div>
		<div class="cl"><?php $tel2=explode('-',$my['tel2'])?>
			<input type="text" name="tel2_1" value="<?php echo $tel2[0]?>" maxlength="4" size="4" placeholder="" class="d_form_underline center" style="width : 20%" />-
			<input type="text" name="tel2_2" value="<?php echo $tel2[1]?>" maxlength="4" size="4" placeholder="" class="d_form_underline center" style="width : 20%" />-
			<input type="text" name="tel2_3" value="<?php echo $tel2[2]?>" maxlength="4" size="4" placeholder="" class="d_form_underline center" style="width : 20%" />
			<input type="checkbox" name="sms" value="1"<?php if($my['sms']=='1'):?> checked="checked"<?php endif; ?> />SMS 수신
		</div>
	</div>
	<?php if($d['member']['form_birth']):?>
	<div class="join_cl">
		<div class="cl"><font class="black">생년월일</font><br></div>
		<div id="select_birth" class="cl" style="margin-top: 10px;">
			<select name="birth_1">
			<option value="">선택</option>
			<?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
			<option value="<?php echo $i?>"<?php if($my['birth1']==$i):?> selected="selected"<?php endif?>><?php echo $i?>년</option>
			<?php endfor?>
			</select>
			<select name="birth_2">
			<?php $birth_2=substr($my['birth2'],0,2)?>
			<option value="">선택</option>
			<?php for($i = 1; $i < 13; $i++):?>
			<option value="<?php echo sprintf('%02d',$i)?>"<?php if($birth_2==$i):?> selected="selected"<?php endif?>><?php echo $i?>월</option>
			<?php endfor?>
			</select>
			<select name="birth_3">
			<?php $birth_3=substr($my['birth2'],2,2)?>
			<option value="">선택</option>
			<?php for($i = 1; $i < 32; $i++):?>
			<option value="<?php echo sprintf('%02d',$i)?>"<?php if($birth_3==$i):?> selected="selected"<?php endif?>><?php echo $i?>일</option>
			<?php endfor?>
			</select>
			<input type="checkbox" name="birthtype" value="1"<?php if($my['birthtype']=='1'):?> checked="checked"<?php endif; ?> />음력
		</div>
	</div>
	<?php endif; ?>
<?php if(!$my['mentor_apply'] && $my['mentor_confirm'] != 'Y'):?>
<br>
	<h2>추가 정보</h2>
	<?php if($d['member']['form_addr']):?>
	<div class="join_cl">
		<div class="cl"><font class="black">주소</font><br></div>
				<div id="addrbox">
		<div>
		<input type="text" name="zip_1" id="zip1" value="<?php echo substr($my['zip'],0,3)?>" maxlength="3" size="3" readonly="readonly" class="d_form_underline" style="width:20%" />-
		<input type="text" name="zip_2" id="zip2" value="<?php echo substr($my['zip'],3,3)?>" maxlength="3" size="3" readonly="readonly" class="d_form_underline" style="width:20%" /> 
		<input type="button" value="우편번호" class="btngray btn" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&m=zipsearch&zip1=zip1&zip2=zip2&addr1=addr1&focusfield=addr2');" />
		</div>
		<div><input type="text" name="addr1" id="addr1" value="<?php echo $my['addr1']?>" size="55" readonly="readonly" class="d_form_underline" placeholder="우편번호를 검색해주세요." /></div>
		<div><input type="text" name="addr2" id="addr2" value="<?php echo $my['addr2']?>" size="55" class="d_form_underline" placeholder="상세주소를 입력해주세요." /></div>
		</div>
		<?php if($d['member']['form_foreign']):?>
		<div class="remail shift" style="font-size: 12px;">
		<input type="checkbox" id="is_foreign" name="foreign" value="1" onclick="foreignChk(this);" /><label for="is_foreign"><span id="foreign_ment">해외거주자일 경우 체크해 주세요.</span></label>
		</div>
		<?php endif?>
	</div>
	<?php endif; ?>
<?php endif; ?>
	<?php if($my['mentor_confirm']!='Y' && !$my['mentor_apply']):?>
	<div class="join_cl">
		<font class="black">학교</font><br>
		<input type="text" name="sc_name" placeholder="학교이름을 입력해주세요" maxlength="15" class="d_form_underline" value="<?php echo $my['sc_name']?>" />
	</div>
	<div class="join_cl">
		<div class="fl" style="width: 32%; margin-right:2%;"><font class="black">학년</font><br> <input type="text" name="sc_grade" maxlength="3" size="4" class="d_form_underline" placeholder="학년을 입력해주세요." value="<?php echo $my['sc_grade']?>" /></div>
		<div class="fl" style="width: 32%; margin-right:2%;"><font class="black">반</font><br> <input type="text" name="sc_class" maxlength="4" size="4" class="d_form_underline" placeholder="반을 입력해주세요." value="<?php echo $my['sc_class']?>" /></div>
		<div class="fl" style="width: 32%;"><font class="black">번호</font><br> <input type="text" name="sc_num" maxlength="4" size="4" class="d_form_underline" placeholder="번호를 입력해주세요." value="<?php echo $my['sc_num']?>" /></div>
	</div>
	<h2>학부모 정보</h2>
	<div class="join_cl">
		<div class="fl" style="width: 48%; margin-right:2%;"><font class="black">관계</font><br> 
		<select name="sc_parent_kind" id="sc_parent_kind">
			<option value="M"<?php if($my['sc_parent_kind']=='M'):?> selected="selected"<? endif; ?>>어머니</option>
			<option value="F"<?php if($my['sc_parent_kind']=='F'):?> selected="selected"<? endif; ?>>아버지</option>
			<option value="E"<?php if($my['sc_parent_kind']=='E'):?> selected="selected"<? endif; ?>>그 외</option>
		</select></div>
		<div class="fl" style="width: 48%; margin-left:2%;"><font class="black">성함</font><br> <input type="text" name="sc_parent_name" maxlength="5" class="d_form_underline" placeholder="학부모 성함을 입력해주세요." value="<?=$my['sc_parent_name']?>" /></div>
	</div>
	<div class="join_cl">
		<div class="cl"> <font class="black">학부모 전화번호</font><br> </div>
		<div class="cl">
			<?php $parent_tel=explode('-',$my['sc_parent_tel']);?>
			<input type="text" name="sc_parent_tel_1" maxlength="3" size="4" value="<?php echo $parent_tel[0]?>" placeholder="" class="d_form_underline center" style="width : 20%" />-
			<input type="text" name="sc_parent_tel_2" maxlength="4" size="4" value="<?php echo $parent_tel[1]?>" placeholder="" class="d_form_underline center" style="width : 20%" />-
			<input type="text" name="sc_parent_tel_3" maxlength="4" size="4" value="<?php echo $parent_tel[2]?>" placeholder="" class="d_form_underline center" style="width : 20%" />
		</div>
	</div>
	<br>
	<?php else:?>
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
	<div id="mentor_address" class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">멘토 위치</font></div>
		</div>
		<div class="cl">
			<script type="text/javascript" src='http://maps.google.com/maps/api/js?key=AIzaSyCrnWttsGI8pPdETvOA1DBiPNueaEa6cIc&sensor=false&libraries=places'></script>
			<script src="/static/locationpicker.jquery.min.js"></script>
			<input type="hidden" id="addr_lat" name="addr_lat">
			<input type="hidden" id="addr_long" name="addr_long">
			<input type="text" id="address" class="d_form_underline" name="address" style="width: 550px;" value="<?=$addr_address?>"><br>
			<input type="text" id="address_detail" class="d_form_underline" name="address_detail" style="width: 550px;" placeholder="상세주소"
			 value="<?=$my['address_detail']?>">
			<div id="grp_map" style="width: 907px; height: 400px;"></div>
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
	<div id="mentor_job" class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">직업</font></div>
		</div>
		<div class="cl">
			<input type="text" name="m_jobview" placeholder="우측 검색하기 버튼을 눌러 선택해주세요." class="d_form_underline" readonly="" value="<?=getJobName($my['mentor_job'])?>" style="width:40%" />
			<input type="hidden" name="mentor_job" readonly="" value="<?=$my['mentor_job']?>"  />
			<input onclick="window.open('<?php echo $g['s']?>/?r=home&iframe=Y&m=dalkkum&front=search', 'myWindow', 'width=200, height=100'); " type="button" class="btnblue" value="변경하기">
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
				<div class="fl"><font class="black">6) 인터뷰에 들어갈 이미지를 첨부해주세요. (없을 경우 기본이미지로 대체됩니다.)</font></div>
		</div>
		<div class="cl">
		<center>
				<?php if($_myMantor['i_pic']):?><img src="/_var/iphoto/<?=$_myMantor['i_pic']?>" style="max-height: 300px;" data-inhtml="iphoto_change" onclick="del_pic('iphoto_change','i_pic', '해당 이미지를 삭제하시겠습니까?');"><?php endif;?>
				<br><input type="file" name="i_pic" />
		</center>
		</div>
	</div>
	<br>
	<div class="join_cl">
		<div class="cl">
				<div class="fl"><font class="black">7) 인터뷰에 들어갈 영상을 첨부해주세요. (50M 미만의 wmv, mp4, avi 파일만 허용되며, 멘토 조회시 공개됩니다.)</font></div>
		</div>
		<div class="cl">
			<center>
			<?php if($_myMantor['file_key_I']):?>
			<iframe width="500" height="375" src="http://play.smartucc.kr/player.php?origin=<?=$_myMantor['media_key']?>&g=tag" frameborder="0" allowfullscreen data-inhtml="ivideo_change"></iframe><br><input type="button" class="btn" value="인터뷰 동영상 삭제 하기" style="width: 250px; height: 40px; line-height: 40px;" onclick="del_pic('ivideo_change','i_video', '해당 영상을 삭제하시겠습니까?');"><br>
			<?php endif; ?>
				<input type="file" name="i_video" accept="video/*">
			</center>
		</div>
	</div>
	<br>
	<div class="join_cl">
		<input type="checkbox" id="not_crime" name="not_crime" value="Y"<?php if($my['not_crime']=='Y'):?> checked="checked"<?php endif; ?>><label for="not_crime">성범죄조회 동의진행 및 인터뷰요청에 동의합니다. (선택) <br><font class="red">* 학교 강사 활동 시 필수 사항이며, 동의 하지 않을 경우 활동이 제한됩니다</font></label>
	</div>
	<?php endif; ?>
	<div class="submitbox">
		<input type="hidden" name="hiddens" id="hiddens">
		<input type="submit" value="수정하기" class="btnblue" />
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

	if (f.name.value == '')
	{
		alert('이름을 입력해 주세요.');
		f.name.focus();
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


	<?php if($d['member']['form_qa']&&$d['member']['form_qa_p']):?>
	if (f.pw_q.value == '')
	{
		alert('비밀번호 찾기 질문을 입력해 주세요.');
		f.pw_q.focus();
		return false;
	}
	if (f.pw_a.value == '')
	{
		alert('비밀번호 찾기 답변을 입력해 주세요.');
		f.pw_a.focus();
		return false;
	}
	<?php endif?>



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
	if (f.new_pw.value != f.new_pw.value && f.new_pw.value.length > 0 && f.new_pw2.value.length > 0)
	{
		alert('변경할 비밀번호가 다릅니다.');
		f.new_pw.focus();
		return false;
	}

	<?php if($d['member']['form_addr']&&$d['member']['form_addr_p']):?>
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


	<?php if($d['member']['form_job']&&$d['member']['form_job_p']):?>
	if (f.job.value == '')
	{
		alert('직업을 선택해 주세요.');
		f.job.focus();
		return false;
	}
	<?php endif?>

	<?php if($my['mentor_confirm']=="Y"):?>
	if (f.mentor_job.value == '')
	{
		alert('직업을 선택해 주세요.');
		f.mentor_job.focus();
		return false;
	}
	<?php endif?>
	
	var radioarray;
	var checkarray;
	var i;
	var j = 0;
	return confirm('수정하시겠습니까?');
}
function cell_del(what){
	$(what).parent().remove();
}
// 프로필 및 인터뷰 사진 삭제
function del_pic(obj, what, msg){
	var form_data = {
		what: what
	};
	if(confirm(msg)){	
		$.ajax({
			type: "POST",
			url: "/?r=home&m=dalkkum&a=app_delete",
			data: form_data,
			success: function(response) {
				results = JSON.parse(response);
				if(results.code == '100'){
					var ctarget = $('[data-inhtml="'+obj+'"]');
					if(obj == 'mypic_change'){
						ctarget.css('background','url(/_var/simbol/180.default.jpg) center center');
						ctarget.css('background-size','cover');
					}else if(obj == 'iphoto_change'){
						//ctarget.attr('src','');
						ctarget.remove();
					}else if(obj == 'ivideo_change'){
						ctarget.remove();
					}
				}
				if(results.msg) alert(results.msg);
			}
		});
	}
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





