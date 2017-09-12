<?php 

	if(!$my['memberuid']) getLink($g['r'].'/','','로그인 후 이용해주세요.','');

	$a_name = $my['name'];
	$a_tel = $my['tel2'];
	$a_email = $my['email'];

	if($uid) {
		$EAD= getUidData('rb_dalkkum_eventapply',$uid);
		$a_group = 	$EAD['a_group'];
		$a_tel	 = 	$EAD['tel'];
		$a_email =	 $EAD['email'];
		$a_address = $EAD['address'];
		$a_address_detail = $EAD['address_detail'];
		$a_lat = $EAD['a_lat'];
		$a_long = $EAD['a_long'];
		$a_event_num = $EAD['event_num'];
		$a_startdate1 = substr($EAD['start_date'], 0,4);
		$a_startdate2 = substr($EAD['start_date'], 4,2);
		$a_startdate3 = substr($EAD['start_date'], 6,2);
		$a_enddate1 = substr($EAD['end_date'], 0,4);
		$a_enddate2 = substr($EAD['end_date'], 4,2);
		$a_enddate3 = substr($EAD['end_date'], 6,2);
		$manyTimes = $EAD['many_times'];
		$_temp = explode('|', $EAD['times']);
		for($i=0; $i < 10; $i++){
			${'a_times'.($i+1).'_1'} = substr($_temp[$i], 0,2);
			${'a_times'.($i+1).'_2'} = substr($_temp[$i], 2,2);
			${'a_times'.($i+1).'_3'} = substr($_temp[$i], 4,2);
			${'a_times'.($i+1).'_4'} = substr($_temp[$i], 6,2);
		}
		$a_money = $EAD['money'];
		$a_stdNum = $EAD['std_num'];
		$a_classNum = $EAD['class_num'];
		$a_target = $EAD['grade'];
		$a_change = $EAD['a_change'];
		$a_grade_sum = $EAD['grade_sum'];
		$a_rental = $EAD['rental_pc'];
		$a_memo = $EAD['memo'];
		$a_program = $EAD['program'];
		$a_mentor_num = $EAD['mentor_num'];
		$a_mentor_jobs = explode($EAD['mentor_jobs'], ',');
	}
	// 프로그램 기재
	$_PGD = getDbSelect('rb_dalkkum_program','','*');
	$programs = array('');
	$programs[0] = '프로그램 선택';
	while ($_tmp = db_fetch_array($_PGD)) {
		$programs[$_tmp['uid']] = $_tmp['name'];
	}

?>
<style>
	#headmsg {
		color:#FFF;
		height: 80px; margin: 50px auto;
		cursor: default;
	}
	#headmsg h1 { font-size: 40px; line-height: 50px; font-weight: normal;}
	#headmsg h3 { font-size: 20px; line-height: 30px; font-weight: normal;}
</style>
<div class="cl" style="background: url('<?=$g["img_layout"]?>/event_bg.jpg') top center; height: 200px;">
	<div id="headmsg" class="inner_wrap center">
		<h1>교육신청</h1>
		<h3>달꿈과 함께하는 꿈을 찾는 교육</h3>
	</div>
</div>
<div class="cl">
	<div class="inner_wrap">
		<div id="pages_join" style="width: 100%; padding: 0 20px 20px 20px; margin: 20px 0;">
		<?php if($EAD['step'] == '0'):?>
			<form name="procForm" action="<?=$g['s']?>/" method="post" target="_action_frame_<?=$m?>" onsubmit="return saveCheck(this);">
			<input type="hidden" name="r" value="<?=$r?>" />
			<input type="hidden" name="c" value="<?=$c?>" />
			<input type="hidden" name="m" value="dalkkum" />
			<input type="hidden" name="a" value="apply_event" />
			<input type="hidden" name="act" value="apply" />
			<input type="hidden" name="uid" value="<?=$uid?>" />
			<input type="hidden" name="applier" value="<?=$my['memberuid']?>" />
		<?php endif; ?>
			<h2>교육 <?=(($uid)?'수정':'신청')?></h2>
			<div class="join_cl">
				<div class="cl"> <font class="black">담당자 이름</font><br> </div>
				<input type="text" id="a_name" name="a_name" class="d_form_underline" placeholder="담당자 이름이 입력해주세요." value="<?=$a_name?>" maxlength="50">
			</div>
			<div class="join_cl">
				<div class="cl"> <font class="black">소속 / 기관명</font><br> </div>
				<input type="text" id="a_group" name="a_group" class="d_form_underline" placeholder="소속 학교 또는 기관을 입력해주세요." value="<?=$a_group?>" maxlength="50">
			</div>
			<div class="join_cl">
				<div class="cl"> <font class="black">담당자 전화번호</font><br> </div>
				<div class="cl"><?php $tel2=explode('-',$a_tel)?>
					<input type="text" name="a_tel1" value="<?=$tel2[0]?>" maxlength="4" size="4" placeholder="" class="d_form_underline center" style="width : 20%" />-
					<input type="text" name="a_tel2" value="<?=$tel2[1]?>" maxlength="4" size="4" placeholder="" class="d_form_underline center" style="width : 20%" />-
					<input type="text" name="a_tel3" value="<?=$tel2[2]?>" maxlength="4" size="4" placeholder="" class="d_form_underline center" style="width : 20%" />
				</div>
			</div>
			<div class="join_cl">
				<div class="cl"> <font class="black">담당자 메일주소</font><br> </div>
				<input type="text" id="a_email" name="a_email" class="d_form_underline" placeholder="담당자 메일주소를 입력해주세요." value="<?=$a_email?>" maxlength="200">
			</div>
			<div class="join_cl">
				<div class="cl"> <font class="black">교육 장소</font><br> </div>
							<input type="hidden" id="addr_lat" name="a_lat" value="">
					<input type="hidden" id="addr_long" name="a_long" value="">
					<input type="text" class="d_form_underline center" name="keyword" id="place_keyword" style="width: 50%;" placeholder="도시명 / 동 / 번지 입력" autocomplete="off">
					<input type="button" onclick="search_move();" class="btnblue" value="지도에서 찾기">
					<div id="grp_map" style="width: 100%; height: 350px;"></div>
					<input type="text" id="address" class="d_form_underline" name="a_address" style="width: 100%;" value="" readonly="readonly" placeholder="주소 (지도 위 검색 후 자동 기입)"><br>
					<input type="text" id="address_detail" class="d_form_underline" name="a_address_detail" style="width: 100%;" placeholder="상세주소"
					 value="" autocomplete="off">
			</div>

			<div class="join_cl">
				<div class="cl"> <font class="black">학교 주소(동)</font><br> </div>
				<input type="text" id="a_address" name="a_address" class="d_form_underline" placeholder="학교 주소를 동까지 입력해주세요." value="<?=$a_address?>" maxlength="255">
			</div>

			<div class="join_cl">
				<div class="fl" style="width: 48%; margin-right:2%;"><font class="black">프로그램 선택</font><br> 
				<select name="a_program" id="a_program">
					<?php foreach ($programs as $key => $value) {?>
						<option value="<?=$key?>"<?php if($key==$a_program):?> selected="selected"<?php endif; ?>><?=$value?></option>
					<?php } ?>
				</select></div>
			</div>
			<div class="join_cl">
				<div class="fl" style="width: 48%; margin-right:2%;"><font class="black">모집 멘토 인원(명)</font><br> 
				<select name="a_mentor_num" id="a_mentor_num">
						<option value="0"<?php if($a_mentor_num=='0'):?> selected="selected"<?php endif; ?>>미정</option>
				<?php for ($i=1; $i <100 ; $i++):?>
						<option value="<?=$i?>"<?php if($a_mentor_num==$i):?> selected="selected"<?php endif; ?>><?=$i?>명</option>
				<?php endfor; ?>
				</select></div>
			</div>
			<div class="join_cl">
				<div class="cl"> <font class="black">교육 횟수</font><br> </div>
				<input type="text" id="a_event_num" name="a_event_num" class="d_form_underline" placeholder="교육 횟수를 입력해주세요" value="<?=$a_event_num?>" maxlength="50">
			</div>
			<div class="join_cl">
				<div class="cl"><font class="black">교육 일시</font><br></div>
				<div class="cl select_date" style="margin-top: 10px;">
					<select name="a_startdate1" style="width: 25%">
					<option value="">선택</option>
					<?php for($i = substr($date['today'],0,4)+1; $i > 1930; $i--):?>
					<option value="<?=$i?>"<?php if($i == $a_startdate1):?> selected="selected"<?php endif; ?>><?=$i?>년</option>
					<?php endfor?>
					</select>
					<select name="a_startdate2" style="width: 20%">
					<option value="">선택</option>
					<?php for($i = 1; $i < 13; $i++):?>
					<option value="<?=sprintf('%02d',$i)?>"<?php if($i == $a_startdate2):?> selected="selected"<?php endif; ?>><?=$i?>월</option>
					<?php endfor?>
					</select>
					<select name="a_startdate3" style="width: 20%">
					<option value="">선택</option>
					<?php for($i = 1; $i < 32; $i++):?>
					<option value="<?=sprintf('%02d',$i)?>"<?php if($i == $a_startdate3):?> selected="selected"<?php endif; ?>><?=$i?>일</option>
					<?php endfor?>
					</select> ~ <br>
					<select name="a_enddate1" style="width: 25%">
					<option value="">선택</option>
					<?php for($i = substr($date['today'],0,4)+1; $i > 1930; $i--):?>
					<option value="<?=$i?>"<?php if($i == $a_enddate1):?> selected="selected"<?php endif; ?>><?=$i?>년</option>
					<?php endfor?>
					</select>
					<select name="a_enddate2" style="width: 20%">
					<option value="">선택</option>
					<?php for($i = 1; $i < 13; $i++):?>
					<option value="<?=sprintf('%02d',$i)?>"<?php if($i == $a_enddate2):?> selected="selected"<?php endif; ?>><?=$i?>월</option>
					<?php endfor?>
					</select>
					<select name="a_enddate3" style="width: 20%">
					<option value="">선택</option>
					<?php for($i = 1; $i < 32; $i++):?>
					<option value="<?=sprintf('%02d',$i)?>"<?php if($i == $a_enddate3):?> selected="selected"<?php endif; ?>><?=$i?>일</option>
					<?php endfor?>
					</select>
				</div>
			</div>
			<div class="join_cl">
				<div class="cl"> <font class="black">진행 교시</font><br> </div>
				<div class="join_cl">
					<select name="many_times" id="manyTimes" onchange="times_show(this.value);">
					<?php for($i=1; $i <= 10; $i++):?>
						<option value="<?=$i?>"<?php if($i == $manyTimes):?> selected="selected"<?php endif; ?>><?=$i?>교시</option>
					<?php endfor; ?>
					</select>
				</div>
				<?php for($tsi=1; $tsi <= 10; $tsi++): ?>
				<div class="join_cl timesSelect" style="display:none; padding-left:20px;" id="timebox_<?=$tsi?>">
					<font class="black"><?=sprintf('%02d',$tsi)?> 교시</font> 
					<select name="a_times<?=$tsi?>_1" id="a_times<?=$tsi?>_1">
						<?php for($it = 0; $it < 23; $it++):?>
							<option value="<?=sprintf('%02d',$it)?>"<?php if($it == ${'a_times'.$tsi.'_1'}):?> selected="selected"<?php endif; ?>><?=sprintf('%02d',$it)?>시</option>
						<?php endfor?> : 
					</select>
					<select name="a_times<?=$tsi?>_2" id="a_times<?=$tsi?>_2">
						<?php for($it = 0; $it < 60; $it++):?>
						<option value="<?=sprintf('%02d',$it)?>"<?php if($it == ${'a_times'.$tsi.'_2'}):?> selected="selected"<?php endif; ?>><?=sprintf('%02d',$it)?>분</option>
						<?php endfor?>
					</select>
					 ~ 
					<select name="a_times<?=$tsi?>_3" id="a_times<?=$tsi?>_3">
						<?php for($it = 0; $it < 23; $it++):?>
							<option value="<?=sprintf('%02d',$it)?>"<?php if($it == ${'a_times'.$tsi.'_3'}):?> selected="selected"<?php endif; ?>><?=sprintf('%02d',$it)?>시</option>
						<?php endfor?> : 
					</select>
					<select name="a_times<?=$tsi?>_4" id="a_times<?=$tsi?>_4">
						<?php for($it = 0; $it < 60; $it++):?>
						<option value="<?=sprintf('%02d',$it)?>"<?php if($it == ${'a_times'.$tsi.'_4'}):?> selected="selected"<?php endif; ?>><?=sprintf('%02d',$it)?>분</option>
						<?php endfor?>
					</select>
				</div>
				<?php endfor; ?>
			</div>
			<div class="join_cl">
				<div class="cl"> <font class="black">총 예산</font><br> </div>
				<input type="text" id="a_money" name="a_money" value="<?=$a_money?>" class="d_form_underline" placeholder="총 예산을 입력해주세요" maxlength="50">
			</div>
			<div class="join_cl">
				<div class="cl"> <font class="black">참여 학생 수</font><br> </div>
				<input type="text" id="a_stdNum" name="a_stdNum" value="<?=$a_stdNum?>" class="d_form_underline" placeholder="참여 학생 수를 입력해주세요" maxlength="50">
			</div>
			<div class="join_cl">
				<div class="cl"> <font class="black">분반 수</font><br> </div>
				<input type="text" id="a_classNum" name="a_classNum" value="<?=$a_classNum?>" class="d_form_underline" placeholder="분반 수를 입력해주세요" maxlength="50">
			</div>
			<div class="join_cl">
				<div class="cl"> <font class="black">대상 학년</font><br> </div>
				<input type="text" id="a_target" name="a_target" value="<?=$a_target?>" class="d_form_underline" placeholder="대상 학년을 입력해주세요" maxlength="50">
			</div>
			<div class="join_cl">
				<div class="cl"> <font class="black">교시별 학생변경</font><br> </div>
				<input type="text" id="a_change" name="a_change" value="<?=$a_change?>" class="d_form_underline" placeholder="교시별 학생변경 여부를 입력해주세요" maxlength="50">
			</div>
			<div class="join_cl">
				<div class="cl"> <font class="black">학년간 혼합여부</font><br> </div>
				<input type="text" id="a_grade_sum" name="a_grade_sum" value="<?=$a_grade_sum?>" class="d_form_underline" placeholder="학년간 혼합 여부를 입력해주세요" maxlength="50">
			</div>
			<div class="join_cl">
				<div class="cl"> <font class="black">노트북 대여 가능</font><br><label for="a_rental"><input type="checkbox" name="a_rental" id="a_rental" value="Y">학교 / 기관에서 PC를 제공한다면 체크해주세요. <br>
<font color="red">(제공되지 않는다면 노트북 대여료는 추가됩니다.)</font></label>
<br></div>
			</div>
			<div class="cl">
				<div class="cl"> <font class="black">특이사항</font><br> </div>
				<textarea name="a_memo" id="a_memo" rows="10" style="resize: none; width: 100%; box-sizing: border-box;"><?=$a_memo?></textarea>
			</div>
			<div class="join_cl">
				<div class="fl"><font class="black">양식파일(세부 신청양식)</font></div>
				<div class="fr"><input type="button" class="btn" value="다운로드" style="border:solid 1px #ddd; padding: 5px 20px;" onclick="alert('준비중입니다.');"></div>
			</div>
		<?php if(!$EAD['step']):?>
			<div class="join_cl">
				<input type="submit" value="보내기" class="btn" style="width: 100%; height: 50px; line-height: 50px; background-color:#ffd200; border:none; font-weight: bold; font-size:18px;"  />		
			</div>

			</form>
		<?php endif?>
		</div>

	</div>
</div>
<script type="text/javascript">
//<![CDATA[

function times_show(num){
	$('[id^="timebox_"]').hide();
	var e = 1;
	for(e=1; e <= num; e++){
		$('#timebox_'+e).show();
	}
}

function saveCheck(f)
{
	if (f.a_name.value == '')
	{
		alert('이름을 입력해 주세요.');
		f.a_name.focus();
		return false;
	}
	if (f.a_group.value == '')
	{
		alert('소속 기관을 입력해 주세요.');
		f.a_group.focus();
		return false;
	}

	if (f.a_tel1.value == '')
	{
		alert('휴대폰번호를 입력해 주세요.');
		f.a_tel1.focus();
		return false;
	}
	if (f.a_tel2.value == '')
	{
		alert('휴대폰번호를 입력해 주세요.');
		f.a_tel2.focus();
		return false;
	}
	if (f.a_tel3.value == '')
	{
		alert('휴대폰번호를 입력해 주세요.');
		f.a_tel3.focus();
		return false;
	}

	if (f.a_email.value == '')
	{
		alert('이메일 입력해 주세요.');
		f.a_email.focus();
		return false;
	}


	if (f.a_program.value == '' || f.a_program.value == '0')
	{
		alert('프로그램을 선택해 주세요.');
		f.a_program.focus();
		return false;
	}

	if (f.a_program.value == '')
	{
		alert('주소를 입력해 주세요.');
		f.a_program.focus();
		return false;
	}

	if (f.a_event_num.value == '')
	{
		alert('교육 횟수를 입력해 주세요.');
		f.a_event_num.focus();
		return false;
	}

	if (f.a_startdate1.value == '' || f.a_startdate2.value == '' || f.a_startdate3.value == '' || f.a_enddate1.value == '' || f.a_enddate2.value == '' || f.a_enddate3.value == '' )
	{
		alert('교육 일시를 모두 선택해주세요.');
		f.a_startdate1.focus();
		return false;
	}

	if (f.a_money.value == '')
	{
		alert('교육 예산을 입력해 주세요.');
		f.a_money.focus();
		return false;
	}

	if (f.a_stdNum.value == '')
	{
		alert('참여 학생 수를 입력해 주세요.');
		f.a_stdNum.focus();
		return false;
	}

	if (f.a_target.value == '')
	{
		alert('대상 학년을 입력해 주세요.');
		f.a_target.focus();
		return false;
	}

	if (f.a_change.value == '')
	{
		alert('학년간 혼합여부를 입력해 주세요.');
		f.a_change.focus();
		return false;
	}
	if (f.a_grade_sum.value == '')
	{
		alert('학년간 혼합 여부를 입력해 주세요.');
		f.a_grade_sum.focus();
		return false;
	}

<?php if($R['uid']):?>
	return confirm('정말로 수정하시겠습니까?       ');
<?php else : ?>
	return confirm('정말로 등록하시겠습니까?       ');
<?php endif ?>
}
function cell_del(what){
	$(what).parent().remove();
}
$(document).ready(function(){
	times_show($('#manyTimes').val());
});

//]]>
</script>

<script>
	var default_lat = '';
	var default_long = '';
</script>
<script type="text/javascript" src="http://apis.daum.net/maps/maps3.js?apikey=6b72c4c6de26e90f11c0e92b8f79b97a"></script>
<script src="/static/daumPicker.js"></script>
