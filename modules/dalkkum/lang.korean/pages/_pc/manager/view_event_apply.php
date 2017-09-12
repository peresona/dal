<?php 

	if(!defined('__KIMS__')) exit;
	checkAdmin(0);
	
	if(!$uid) getLink($g['r'].'/','','비정상적인 접근입니다.','');

	$a_name = $my['name'];
	$a_tel = $my['tel2'];
	$a_email = $my['email'];

	if($uid) {
		$EAD= getUidData('rb_dalkkum_eventapply',$uid);
		$a_step = 	$EAD['step'];
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


		$eventdates1 = explode('|', $EAD['eventdate1']);
		$eventdates2 = explode('|', $EAD['eventdate2']);
		$eventnow = explode('|', $EAD['eventnow']);

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
		$step = array('','<font color="purple"><b>확인 전</b></font>','<font color="green">확인중</font>','<font color="red">거절</font>','<font color="green">진행중</font>','<font color="blue">완료</font>',);	// 프로그램 기재
			// 프로그램 기재
			$_PGD = getDbSelect('rb_dalkkum_program','','*');
			$programs = array('');
			$programs[0] = '프로그램 선택';
			while ($_tmp = db_fetch_array($_PGD)) {
				$programs[$_tmp['uid']] = $_tmp['name'];
			}
	}
?>
<link rel="stylesheet" href="/static/datepicker.min.css">
<script src="/static/datepicker.min.js"></script>
<div id="pages_join">
	<form name="procForm" action="<?=$g['s']?>/" method="post" target="_action_frame_<?=$m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?=$r?>" />
	<input type="hidden" name="c" value="<?=$c?>" />
	<input type="hidden" name="m" value="dalkkum" />
	<input type="hidden" name="a" value="apply_event" />
	<input type="hidden" name="ver" value="manager" />
	<input type="hidden" name="act" value="apply" />
	<input type="hidden" name="uid" value="<?=$uid?>" />
	<input type="hidden" name="applier" value="<?=$my['memberuid']?>" />
	<h2>교육 <?=(($uid)?'수정':'신청')?></h2>
	<div class="join_cl">
		<div class="cl"> <font class="black">상태</font><br>
			<select name="step" id="step">
				<?php for($stepi=1; $stepi <= 5; $stepi++):?>
				<option value="<?=$stepi?>"<?php if($a_step==$stepi):?> selected="selected"<?php endif; ?>><?=$step[$stepi]?></option>
				<?php endfor; ?>
			</select>
		</div>
	</div>
	<div class="join_cl">
		<div class="cl"><font class="black">교육 일시</font><br></div>
		<div class="cl select_date" style="margin-top: 10px;">
			<select name="a_startdate1" id="a_startdate1">
			<option value="">선택</option>
			<?php for($i = substr($date['today'],0,4)+1; $i > 1930; $i--):?>
			<option value="<?=sprintf('%02d',$i)?>"<?php if($i == $a_startdate1):?> selected="selected"<?php endif; ?>><?=sprintf('%02d',$i)?>년</option>
			<?php endfor?>
			</select>
			<select name="a_startdate2" id="a_startdate2">
			<option value="">선택</option>
			<?php for($i = 1; $i < 13; $i++):?>
			<option value="<?=sprintf('%02d',$i)?>"<?php if($i == $a_startdate2):?> selected="selected"<?php endif; ?>><?=sprintf('%02d',$i)?>월</option>
			<?php endfor?>
			</select>
			<select name="a_startdate3" id="a_startdate3">
			<option value="">선택</option>
			<?php for($i = 1; $i < 32; $i++):?>
			<option value="<?=sprintf('%02d',$i)?>"<?php if($i == $a_startdate3):?> selected="selected"<?php endif; ?>><?=sprintf('%02d',$i)?>일</option>
			<?php endfor?>
			</select> ~ 
			<select name="a_enddate1" id="a_enddate1">
			<option value="">선택</option>
			<?php for($i = substr($date['today'],0,4)+1; $i > 1930; $i--):?>
			<option value="<?=sprintf('%02d',$i)?>"<?php if($i == $a_enddate1):?> selected="selected"<?php endif; ?>><?=sprintf('%02d',$i)?>년</option>
			<?php endfor?>
			</select>
			<select name="a_enddate2" id="a_enddate2">
			<option value="">선택</option>
			<?php for($i = 1; $i < 13; $i++):?>
			<option value="<?=sprintf('%02d',$i)?>"<?php if($i == $a_enddate2):?> selected="selected"<?php endif; ?>><?=sprintf('%02d',$i)?>월</option>
			<?php endfor?>
			</select>
			<select name="a_enddate3" id="a_enddate3">
			<option value="">선택</option>
			<?php for($i = 1; $i < 32; $i++):?>
			<option value="<?=sprintf('%02d',$i)?>"<?php if($i == $a_enddate3):?> selected="selected"<?php endif; ?>><?=sprintf('%02d',$i)?>일</option>
			<?php endfor?>
			</select>
		</div>
	</div>
	<style>
		#pages_join .join_cl input[type="text"] {width: 100%; text-align: left; height: 25px; line-height: 25px; margin: 0px; padding: 0px; box-sizing: border-box;}
		#pages_join .join_cl input.datepick {text-align: center;}
	</style>
	<div class="join_cl">
		<table>
			<tr>
				<th colspan="7" style="border-bottom: solid 1px #ddd;">교육 신청자에게 출력될 일정표입니다.</th>
			</tr>
			<tr>
				<th>접수</th>
				<th>선호도조사</th>
				<th>멘토섭외</th>
				<th>수강신청</th>
				<th>서류전달</th>
				<th>교육진행</th>
				<th>행정처리</th>
			</tr>
			<tr>
				<?php for ($i=1; $i <= 7 ; $i++):?>
				<td><input name="eventstart<?=$i?>" id="eventstart<?=$i?>" type="text" class="datepick noline" value="<?=getDateFormat($eventdates1[$i-1],'Y-m-d')?>" placeholder="시작일 선택" onchange="start_changes(this.value);"></td>
				<?php endfor;?>
			</tr>
			<tr>
				<?php for ($i=1; $i <= 7 ; $i++):?>
				<td><input name="eventend<?=$i?>" id="eventend<?=$i?>" type="text" class="datepick noline" value="<?=getDateFormat($eventdates2[$i-1],'Y-m-d')?>" placeholder="종료일 선택"></td>
				<?php endfor;?>
			</tr>
			<tr>
				<?php for ($i=1; $i <= 7 ; $i++):?>
				<td><select name="eventnow<?=$i?>" id="eventnow<?=$i?>">
					<option value="">진행상태</option>
					<option value="1"<?php if($eventnow[$i]=='1'):?> selected="selected"<?php endif; ?>>예정</option>
					<option value="2"<?php if($eventnow[$i]=='2'):?> selected="selected"<?php endif; ?>>진행중</option>
					<option value="3"<?php if($eventnow[$i]=='3'):?> selected="selected"<?php endif; ?>>완료</option>
					<option value="4"<?php if($eventnow[$i]=='4'):?> selected="selected"<?php endif; ?>>취소</option>
				</select></td>
				<?php endfor;?>
			</tr>
		</table>
	</div>
	<script>
		$('.datepick').datepicker({
  			date: new Date(<?=getDateFormat($date['totime'],'Y,(m-1),d')?>),
  			format: 'yyyy-mm-dd',
  			days: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
  			daysMin: ['일', '월', '화', '수', '목', '금', '토'],
  			monthsShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
  			yearSuffix: '년'
		});
	</script>
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
					<input type="hidden" id="addr_lat" name="a_lat" value="<?=$a_lat?>">
					<input type="hidden" id="addr_long" name="a_long" value="<?=$a_long?>">
					<input type="text" class="d_form_underline center" name="keyword" id="place_keyword" style="width: 50%;" placeholder="도시명 / 동 / 번지 입력  예) 서울 삼성동 152-67" autocomplete="off">
					<input type="button" onclick="search_move();" class="btnblue" value="지도에서 찾기">
					<div id="grp_map" style="width: 100%; height: 350px;"></div>
					<input type="text" id="address" class="d_form_underline" name="a_address" style="width: 100%;" value="<?=$a_address?>" readonly="readonly" placeholder="주소 (지도 위 검색 후 자동 기입)"><br>
					<input type="text" id="address_detail" class="d_form_underline" name="a_address_detail" style="width: 100%;" placeholder="상세주소"
					 value="<?=$a_address_detail?>" autocomplete="off">
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
		<div class="cl"> <font class="black">노트북 대여 가능</font><br> </div>
		<select name="a_rental" id="a_rental">
			<option value="">가능여부 선택</option>
			<option value="Y"<?php if($a_rental == 'Y'):?> selected="selected"<?php endif; ?>>학교 / 기관에서 PC 제공 가능</option>
			<option value="N"<?php if($a_rental != 'Y'):?> selected="selected"<?php endif; ?>>학교 / 기관에서 PC 제공 불가</option>
		</select>
	</div>
	<div class="cl">
		<div class="cl"> <font class="black">특이사항</font><br> </div>
		<textarea name="a_memo" id="a_memo" rows="10" style="resize: none; width: 100%; box-sizing: border-box;"><?=$a_memo?></textarea>
	</div>
	<div class="join_cl">
		<div class="fl"><font class="black">양식파일(세부 신청양식)</font></div>
		<div class="fr"><input type="button" class="btn" value="다운로드" style="border:solid 1px #ddd; padding: 5px 20px;" onclick="alert('준비중입니다.');"></div>
	</div>
	<div class="join_cl">
		<input type="submit" value="수정하기" class="btn" style="width: 100%; height: 50px; line-height: 50px; background-color:#ffd200; border:none; font-weight: bold; font-size:18px;"  />		
	</div>

	</form>
</div>


<script type="text/javascript">
//<![CDATA[
top.resizeTo(640,700);
window.onload = function(){
	window.document.body.scroll = "auto";
}
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

	if (f.a_address.value == '')
	{
		alert('주소를 입력해 주세요.');
		f.a_address.focus();
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
		alert('대상 학년을 입력해 주세요.');
		f.a_change.focus();
		return false;
	}
	if (f.a_grade_sum.value == '')
	{
		alert('학년간 혼합 여부를 입력해 주세요.');
		f.a_grade_sum.focus();
		return false;
	}

	if (f.a_rental.value == '')
	{
		alert('노트북 렌탈 가능 여부를 선택해 주세요.');
		f.a_rental.focus();
		return false;
	}

	return confirm('정말로 수정하시겠습니까?       ');
}
function cell_del(what){
	$(what).parent().remove();
}
// 날짜 더하기
function dateAdd(sDate, v, t) {
		var yy = parseInt(sDate.substr(0, 4), 10);
		var mm = parseInt(sDate.substr(5, 2), 10);
		var dd = parseInt(sDate.substr(8), 10);

		if(t == "d"){
			d = new Date(yy, mm - 1, dd + v);
		}else if(t == "m"){
			d = new Date(yy, mm - 1 + v, dd);
		}else if(t == "y"){
			d = new Date(yy + v, mm - 1, dd);
		}else{
			d = new Date(yy, mm - 1, dd + v);
		}

		yy = d.getFullYear();
		mm = d.getMonth() + 1; mm = (mm < 10) ? '0' + mm : mm;
		dd = d.getDate(); dd = (dd < 10) ? '0' + dd : dd;

		return '' + yy + '-' +  mm  + '-' + dd;
}

function start_changes(val){
	var tmp_start = $('#a_startdate1').val()+'-'+$('#a_startdate2').val()+'-'+$('#a_startdate3').val();
	var tmp_end = $('#a_enddate1').val()+'-'+$('#a_enddate2').val()+'-'+$('#a_enddate3').val();
	var tmp_arrs = {};
	var tmp_arre = {};
	var tmp_arrm = {};
	tmp_arrs[1] = val; // 선호도조사
	tmp_arrs[2] = dateAdd(tmp_start, -30, 0); // 선호도조사
	tmp_arrs[3] = dateAdd(tmp_start, -21, 0); // 멘토섭외
	tmp_arrs[4] = dateAdd(tmp_start, -14, 0); // 수강신청
	tmp_arrs[5] = dateAdd(tmp_start, -14, 0); // 서류전달
	tmp_arrs[6] = dateAdd(tmp_start, 0, 0); // 교육진행
	tmp_arrs[7] = dateAdd(tmp_start, 1, 0); // 행정처리

	tmp_arre[1] = val;
	tmp_arre[2] = dateAdd(tmp_end, -27, 0);
	tmp_arre[3] = dateAdd(tmp_end, -14, 0);
	tmp_arre[4] = dateAdd(tmp_end, -11, 0);
	tmp_arre[5] = dateAdd(tmp_end, -7, 0);
	tmp_arre[6] = dateAdd(tmp_end, 0, 0);
	tmp_arre[7] = dateAdd(tmp_end, 8, 0);


	tmp_arrm[1] = '3'; // 선호도조사
	tmp_arrm[2] = '1'; // 선호도조사
	tmp_arrm[3] = '1'; // 멘토섭외
	tmp_arrm[4] = '1'; // 수강신청
	tmp_arrm[5] = '1'; // 서류전달
	tmp_arrm[6] = '1'; // 교육진행
	tmp_arrm[7] = '1'; // 행정처리

	for (var i = 1; i <= 7; i++) {
		$('#eventstart'+i).val(tmp_arrs[i]);
		$('#eventend'+i).val(tmp_arre[i]);
		$('#eventnow'+i).val(tmp_arrm[i]);
	}

}
function end_changes(val){

}

$(document).ready(function(){
	times_show($('#manyTimes').val());
});

//]]>
</script>

<script>
	var default_lat = '<?=$a_lat?>';
	var default_long = '<?=$a_long?>';
</script>
<script type="text/javascript" src="http://apis.daum.net/maps/maps3.js?apikey=6b72c4c6de26e90f11c0e92b8f79b97a"></script>
<script src="/static/daumPicker.js"></script>
