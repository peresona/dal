<?php
if(!defined('__KIMS__')) exit; checkAdmin(0);

$_ADS = getDbArray('rb_dalkkum_group','finish="N"','*','uid','desc',0,$p);
$NUM = db_num_rows($_ADS);

if ($uid)
{
	$R = getUidData('rb_dalkkum_group',$uid);
	$year1	= substr($R['date_start'],0,4);	$month1	= substr($R['date_start'],4,2);	$day1	= substr($R['date_start'],6,2);
	$hour1	= substr($R['date_start'],8,2);	$min1	= substr($R['date_start'],10,2);	
	$year2	= substr($R['date_end'],0,4);	$month2	= substr($R['date_end'],4,2);	$day2	= substr($R['date_end'],6,2);	
	$hour2	= substr($R['date_end'],8,2);	$min2	= substr($R['date_end'],10,2);

	$year1_2	= substr($R['date_start2'],0,4);	$month1_2	= substr($R['date_start2'],4,2);
	$day1_2	= substr($R['date_start2'],6,2);	$hour1_2	= substr($R['date_start2'],8,2);
	$min1_2	= substr($R['date_start2'],10,2);	$year2_2	= substr($R['date_end2'],0,4);
	$month2_2	= substr($R['date_end2'],4,2);	$day2_2	= substr($R['date_end2'],6,2);
	$hour2_2	= substr($R['date_end2'],8,2);	$min2_2	= substr($R['date_end2'],10,2);

	$year3	= substr($R['class_date'],0,4);	$month3	= substr($R['class_date'],4,2);
	$day3	= substr($R['class_date'],6,2);	$hour3	= substr($R['class_date'],8,2);
	$min3	= substr($R['class_date'],10,2);
	$_ABLE = getDbArray('rb_dalkkum_applyable','group_seq='.$R['uid'],'*','sc_grade,sc_class,sc_num','asc',0,$p);
	$ABLE_NUM = db_num_rows($_ABLE); unset($_ABLE);
}

for($_i=1; $_i<=$R['select_hour']; $_i++){
	${"start".$_i."_1"} = substr($R['start_'.$_i], 8,2);	${"start".$_i."_2"} = substr($R['start_'.$_i], 10,2);
	${"end".$_i."_1"} = substr($R['end_'.$_i], 8,2);	${"end".$_i."_2"} = substr($R['end_'.$_i], 10,2);
}
	// 프로그램 기재
	$_PGD = getDbSelect('rb_dalkkum_program','','*');
	$programs = array('');
	$programs[0] = '프로그램 선택';
	while ($_tmp = db_fetch_array($_PGD)) {
		$programs[$_tmp['uid']] = $_tmp['name'];
	}
?>

<div id="catebody">
	<div id="category">
		<div class="title">
			수강신청 그룹목록
		</div>
		
		<?php if($NUM):?>
		<div class="tree">
			<ul>
			<?php while($ADS = db_fetch_array($_ADS)):?>
			<li><a href="<?=$g['adm_href']?>&amp;uid=<?=$ADS['uid']?>"><span class="name<?php if($ADS['uid']==$uid):?> on<?php endif?>"><?=$ADS['name']?></span></a></li>
			<?php endwhile?>
			</ul>
		</div>
		<?php else:?>
		<div class="none">등록된 수강신청이 없습니다.</div>
		<?php endif?>
	</div>
	<div id="catinfo">
		<form name="procForm" action="<?=$g['s']?>/" method="post" target="_action_frame_<?=$m?>" onsubmit="return saveCheck(this);" enctype="multipart/form-data">
		<input type="hidden" name="r" value="<?=$r?>" />
		<input type="hidden" name="m" value="<?=$module?>" />
		<input type="hidden" name="a" value="regisgroup" />
		<input type="hidden" name="uid" value="<?=$R['uid']?>" />
		<div class="title">
			<div class="xleft">
				수강신청 그룹목록
			</div>
			<div class="xright">
				<a href="<?=$g['adm_href']?>&amp;newpop=Y">새 수강신청 등록</a>
			</div>
		</div>

		<div class="notice">
			수강신청을 등록합니다. 수강신청 '시작' 버튼을 누른 이후에는 메인에서 유저들이 수강신청을 할 수 있는 상태가 되며, 멘토 및 인원 수를 수정 불가능합니다. <br>
			수강신청 그룹을 등록한 후에 멘토 모집이 가능합니다. <br>
			<font color="blue">수강신청 시작 이 후 그룹 정보 수정이 필요 할 땐, 초기화 버튼을 이용하여 지원학생들을 초기화하면 다시 수정 할 수 있는 상태가 됩니다.</font><br>
			<font color="red">인원에 오류가 있을땐 인원 동기화 버튼을 눌러주시면 동기화됩니다.</font>
		</div>
		<table>
			<tr>
				<td class="td1">그룹명</td>
				<td class="td2">
					<input type="text" name="name" value="<?=$R['name']?>" class="input sname" />
					<?php if($R['uid'] && ($R['apply_start']!="Y")):?>
					<input type="button" class="btnblue" value="수강신청 시작" onclick="if(confirm('수강신청을 시작하시겠습니까?\n 시작 후 수업 멘토 및 일부 정보에 관해서 수정이 불가능합니다.')) frames._action_frame_<?php echo $m?>.location.href='<?=$g['s']?>/?r=<?=$r?>&amp;m=<?=$module?>&amp;a=actionGroup&amp;act=start&amp;uid=<?=$R['uid']?>'">
					<?php elseif($R['uid'] && ($R['apply_start']=="Y")):?>
					<input type="button" class="btnblue" value="수강신청 완료" onclick="if(confirm('수강신청을 종료하시겠습니까?\n 마감시 수강신청이 및 수정이 불가능하며, 조회만 가능합니다.')) frames._action_frame_<?php echo $m?>.location.href='<?=$g['s']?>/?r=<?=$r?>&amp;m=<?=$module?>&amp;a=actionGroup&amp;act=finish&amp;uid=<?=$R['uid']?>'">
					<?php endif?>
						<input type="hidden" name="apply_seq" id="apply_seq" value="<?=$R['apply_seq']?>">
					<?php if($R['apply_seq']):?>
						<input type="button" class="btnblue" value="교육신청 연동해제" onclick="if(confirm('교육신청 연동을 취소하시겠습니까?')) frames._action_frame_<?php echo $m?>.location.href='<?=$g['s']?>/?r=<?=$r?>&amp;m=<?=$module?>&amp;a=actionGroup&amp;act=reset_applyevent&amp;group=<?=$R['uid']?>'">
					<?php else:?>
						<input type="button" class="btnblue" value="교육신청 불러오기" onclick="if(confirm('교육신청 연동 후에 그룹 정보를 수정 할 시에는 연동된 정보(주소, 학교명 등)이 동일하게 수정되므로 유의하시기 바랍니다.')){OpenWindow('/?r=home&iframe=Y&m=dalkkum&front=manager&page=select_applyevent');}">
					<?php endif?>
				</td>
			</tr>
		<?php if($R['apply_seq']):
			$EAD = getUidData('rb_dalkkum_eventapply',$R['apply_seq']);
			$programD = getUidData('rb_dalkkum_program',$EAD['program']);
		?>
			<tr>
				<td colspan="2">
					<table style="text-align: center;" border="0">
						<tr style="background-color: #ddd;">
							<th colspan="6">연동 교육신청 UID : <?=$R['apply_seq']?></th>
						</tr>
						<tr style="background-color: #ddd;">
							<th width="150">학교명</th>
							<th width="200">주소</th>
							<th width="100">프로그램</th>
							<th width="150">교육일정</th>
							<th width="90">반별 학생수</th>
							<th width="80">변경여부</th>
						</tr>
						<tr>
							<td><?=$EAD['a_group']?></td>
							<td><?=$EAD['address']?><br><?=$EAD['address_detail']?></td>
							<td><?=$programD['name']?></td>
							<td><?=getDateFormat($EAD['start_date'].substr($EAD['times'],0,4),'Y.m.d H:i')?>~<br>
							<?=getDateFormat($EAD['start_date'].substr($EAD['times'],-4,4),'Y.m.d H:i')?></td>
							<td><?=$EAD['std_num']?></td>
							<td><?=$EAD['a_change']?></td>
						</tr>
					</table>
				</td>
			</tr>
		<?php endif?>
			<tr>
				<td class="td1">학교선택</td>
				<td class="td2">
					<input type="text" name="sc_name" value="<?=getSchoolName($R['sc_seq'])?>" class="input" readonly />
					<input type="hidden" name="sc_seq" value="<?=$R['sc_seq']?>" class="input" readonly />
					<?php if($R['apply_start']!="Y"):?><input type="button" class="btnblue" value="학교선택" onclick="javascript:OpenWindow('/?r=home&iframe=Y&m=dalkkum&front=manager&page=select_school');" /><?php endif?>
					<?php if($R['uid']):?>
						<input type="button" class="btnblue" value="멘토 모집" onclick="select_mentor_window('','mentor_requestList','mentor_request');"/>
						<input type="button" class="btnblue" value="담당자 지정" onclick="window.open('/?r=home&iframe=Y&m=dalkkum&front=manager&page=appointAdmin&group=<?=$R['uid']?>','new','width=700px,height=700px,top=100,left=100');"/>
					<?php endif; ?>
				</td>
			</tr>
			<?php if($R['admins']):?>
			<tr>
				<td class="td1">담당자</td>
				<td class="td2">
					<?php 
						$admins_data = db_query('select * from rb_s_mbrdata where memberuid in ('.trim($R['admins']).')',$DB_CONNECT);
						while ($admin = db_fetch_array($admins_data)) {
							echo '<a href="/?r=home&m=dalkkum&a=actionGroup&act=delAdmin&uid='.$R['uid'].'&adminuid='.$admin['memberuid'].'" target="_action_frame_'.$m.'" onclick="return confirm(\'해당 멘토의 담당자 권한을 삭제하시겠습니까?\')">'.$admin['name'].'('.$admin['email'].')'.'</a>　';
						}
					 ?>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td class="td1">프로그램 선택</td>
				<td class="td2">
					<select name="program_seq" id="program_seq">
					<?php foreach ($programs as $key => $value) {?>
						<option value="<?=$key?>"<?php if($key==$R['program_seq']):?> selected="selected"<?php endif; ?>><?=$value?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
			<?php if($uid):?>
			<tr>
				<td class="td1">진행상태</td>
				<td class="td2">				<?php
					$num_apply = array();
					$num_apply['all'] = getDbRows('rb_dalkkum_applyable','group_seq='.$R['uid']);	// 총원
					$num_apply['end'] = getDbRows('rb_dalkkum_apply','group_seq='.$R['uid'].' and nows='.$R['select_hour']);	// 완료
					$num_apply['not'] = $num_apply['all'] - $num_apply['end'];	// 미완료
				?>
					<?php if($R['uid'] && ($R['finish']=="Y")):?><font color="blue"><b>수강신청 완료</b></font>
					<?php elseif($R['uid'] && ($R['apply_start']=="Y") && ($R['finish']!="Y") && (($R['date_start']<=$date['totime']) && ($date['totime'] <= $R['date_end']) || ($R['date_start2']<=$date['totime']) && ($date['totime'] <= $R['date_end2']) )):?> <font color="green"><b>수강신청 진행중</b></font>
					<?php elseif(($R['finish']!="Y") && !(($R['date_start']<=$date['totime']) && ($date['totime'] <= $R['date_end']))):?> <font color="green"><b>신청기간이 아닙니다 (신청이 완료되었다면 수강신청 완료 버튼을 눌러주세요.)</b></font>
					<?php else:?> 대기
					<?php endif?>
					 - 총 <?=$num_apply['all']?>명 ( 완료 : <?=$num_apply['end']?>명 / 미완료 : <?=$num_apply['not']?>명)
					<?php if($uid):?><input type="button" class="btnblue" value="조회" onclick="javascript:OpenWindow('<?=$g['s']?>/?r=home&amp;iframe=Y&amp;m=dalkkum&amp;a=export_group&amp;uid=<?=$R['uid']?>&mode=web');" />
						<input type="button" class="btnblue" value="엑셀"  onclick="if(confirm('현재까지 신청된 정보를 다운로드 하시겠습니까?')) frames._action_frame_<?php echo $m?>.location.href='<?=$g['s']?>/?r=home&amp;iframe=Y&amp;m=dalkkum&amp;a=export_group&amp;uid=<?=$R['uid']?>'" />
					<input type="button" class="btnblue" value="초기화" onclick="if(confirm('현재까지 지원한 수강신청 인원을 초기화하시겠습니까?\n초기화후에는 그룹정보 수정이 다시 가능해지며,\n수강신청 시작을 눌러주셔야 다시 진행됩니다.\n(복구가 불가능하므로 신중하게 눌러주세요!)')) frames._action_frame_<?php echo $m?>.location.href='<?=$g['s']?>/?r=<?=$r?>&amp;m=<?=$module?>&amp;a=actionGroup&amp;act=reset&amp;uid=<?=$R['uid']?>'" />
					<?php endif;?>
				</td>
			</tr><?php endif; ?>
			<tr>
				<td class="td1">신청 가능 학생</td>
				<td class="td2">
					<?php if($uid):?>
					<input type="text" name="available" value="<?=$ABLE_NUM?>명" class="input" readonly />
					<input type="hidden" name="sc_seq" value="<?=$R['sc_seq']?>" class="input" readonly />
					<input type="button" class="btnblue" value="가능인원관리" onclick="javascript:OpenWindow('/?r=home&iframe=Y&m=dalkkum&front=manager&page=insert_student&group=<?=$R['uid']?>');" />
					<a href="/?r=home&m=dalkkum&a=etcAction&act=sync_num" target="_action_frame_admin"><input type="button" class="btnblue" value="인원 동기화" /></a>
					<?php else:?>수강신청 생성 후 학생을 추가 하실 수 있습니다.<?endif?>
				</td>
			</tr>
			<tr>
				<td class="td1"><br>1차신청</td>
				<td class="td2">
									<select name="year1">
					<?php for($i=$date['year'];$i<$date['year']+3;$i++):?><option value="<?=$i?>"<?php if($year1==$i):?> selected="selected"<?php endif?>><?=$i?></option><?php endfor?>
					</select>
					<select name="month1">
					<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($month1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>
					<select name="day1">
					<?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($day1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>
					<select name="hour1">
					<?php for($i=0;$i<24;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($hour1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>:
					<select name="min1">
					<?php for($i=0;$i<60;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($min1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>
					 ~ 
					<select name="year2">
					<?php for($i=$date['year'];$i<$date['year']+3;$i++):?><option value="<?=$i?>"<?php if($year2==$i):?> selected="selected"<?php endif?>><?=$i?></option><?php endfor?>
					</select>
					<select name="month2">
					<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($month2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>
					<select name="day2">
					<?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($day2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>
					<select name="hour2">
					<?php for($i=0;$i<24;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($hour2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>:
					<select name="min2">
					<?php for($i=0;$i<60;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($min2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select> 까지
				</td>
			</tr>
			<tr>
				<td class="td1">2차신청</td>
				<td class="td2">
					<select name="year1_2">
					<?php for($i=$date['year'];$i<$date['year']+3;$i++):?><option value="<?=$i?>"<?php if($year1_2==$i):?> selected="selected"<?php endif?>><?=$i?></option><?php endfor?>
					</select>
					<select name="month1_2">
					<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($month1_2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>
					<select name="day1_2">
					<?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($day1_2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>
					<select name="hour1_2">
					<?php for($i=0;$i<24;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($hour1_2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>:
					<select name="min1_2">
					<?php for($i=0;$i<60;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($min1_2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>
					 ~ 
					<select name="year2_2">
					<?php for($i=$date['year'];$i<$date['year']+3;$i++):?><option value="<?=$i?>"<?php if($year2_2==$i):?> selected="selected"<?php endif?>><?=$i?></option><?php endfor?>
					</select>
					<select name="month2_2">
					<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($month2_2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>
					<select name="day2_2">
					<?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($day2_2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>
					<select name="hour2_2">
					<?php for($i=0;$i<24;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($hour2_2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>:
					<select name="min2_2">
					<?php for($i=0;$i<60;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($min2_2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select> 까지 <b><label for="use_second">(<input type="checkbox" name="use_second" id="use_second" value="Y"<?php if($R['use_second']=='Y'):?> checked="checked"<?php endif; ?>>사용)</label></b>
				</td>
			</tr>
			<tr>
				<td class="td1">이미지</td>
				<td class="td2">
				<?php if($R['img']) :?><img src="<?=$g['path_root'].'files/_etc/group/'.$R['img']; ?>" alt=""><br><?php endif ?>
				<input type="file" name="img" value="">
				<input type="hidden" name="before_img" value="<?=$R['img']; ?>">
				</td>
			</tr>
			<tr>
				<td class="td1">수업 일시</td>
				<td class="td2">
					<select name="class_year">
					<?php for($i=$date['year']-1;$i<$date['year']+3;$i++):?><option value="<?=$i?>"<?php if($year3==$i):?> selected="selected"<?php endif?>><?=$i?></option><?php endfor?>
					</select>년 
					<select name="class_month">
					<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($month3==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>월 
					<select name="class_day">
					<?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($day3==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
					</select>일 
				</td>
			</tr>
			<tr>
				<td class="td1">위치</td>
				<td class="td2">

					<input type="hidden" id="addr_lat" name="grp_lat" value="<?=$R['grp_lat']?>">
					<input type="hidden" id="addr_long" name="grp_long" value="<?=$R['grp_long']?>">
					<input type="text" class="d_form_underline center" name="keyword" id="place_keyword" style="width: 50%;" placeholder="도시명 / 동 / 번지 입력  예) 서울 삼성동 152-67" autocomplete="off">
					<input type="button" onclick="search_move();" class="btnblue" value="지도에서 찾기">
    				<div id="grp_map" style="width: 600px; height: 400px;"></div>
					<input type="text" id="address" class="d_form_underline" name="address"  style="width: 600px;" readonly="readonly" placeholder="주소 (지도 위 검색 후 자동 기입)"  value="<?=$R['address']?>"><br>
					<input type="text" id="address_detail" class="d_form_underline" name="address_detail"  style="width: 600px;" placeholder="상세주소"
					 autocomplete="off" value="<?=$R['address_detail']?>">
				</td>
			</tr>
			<tr>
				<td class="td1">교시</td>
				<td class="td2">
			<?php if($R['apply_start']!="Y"):?>
					<select name="select_hour" onchange="show_times(this.value);">
						<option value="0">미정</option>
						<?php for($i=1;$i<11;$i++):?><option value="<?=$i?>"<?php if($R['select_hour']==$i):?> selected="selected"<?php endif?>><?=$i ?></option><?php endfor?>
					</select>
			<?php else: ?>
				<?=$R['select_hour']?> 교시
				<input type="hidden" name="select_hour" value="<?=$R['select_hour']?>">
			<?php endif; ?>
				</td>
			</tr>
			<?php for($e=1; $e<=10; $e++):
				$_ment = explode("%%%",$R['mentor_'.$e]); 
			?>
			<tr class="times_hide_<?=$e?>">
				<td class="td1"><?=$e?>교시<?=($R['uid']?' 멘토':'')?></td>
				<td class="td2">
					<select id="start<?=$e?>_1" name="start<?=$e?>_1" style="width: 50px;">
						<?php for($i=0; $i<=23; $i++):?>
							<option value="<?=sprintf('%02d',$i)?>"<?php if(substr($R['start_'.$e],8,2)==sprintf('%02d',$i)):?> selected="selected"<?php endif;?>><?=sprintf('%02d',$i)?></option>
						<?php endfor;?>
					</select> : 
					<select id="start<?=$e?>_2" name="start<?=$e?>_2" style="width: 50px;">
						<?php for($i=0; $i<=59; $i++):?>
							<option value="<?=sprintf('%02d',$i)?>"<?php if(substr($R['start_'.$e],10,2)==sprintf('%02d',$i)):?> selected="selected"<?php endif;?>><?=sprintf('%02d',$i)?></option>
						<?php endfor;?>
					</select> ~ 
					<select id="end<?=$e?>_1" name="end<?=$e?>_1" style="width: 50px;">
						<?php for($i=0; $i<=23; $i++):?>
							<option value="<?=sprintf('%02d',$i)?>"<?php if(substr($R['end_'.$e],8,2)==sprintf('%02d',$i)):?> selected="selected"<?php endif;?>><?=sprintf('%02d',$i)?></option>
						<?php endfor;?>
					</select> : 
					<select id="end<?=$e?>_2" name="end<?=$e?>_2" style="width: 50px;">
						<?php for($i=0; $i<=59; $i++):?>
							<option value="<?=sprintf('%02d',$i)?>"<?php if(substr($R['end_'.$e],10,2)==sprintf('%02d',$i)):?> selected="selected"<?php endif;?>><?=sprintf('%02d',$i)?></option>
						<?php endfor;?>
					</select>
					<?php if($R['uid']):?>
					<input type="button" class="btnblue" value="멘토 선택" onclick="select_mentor_window('<?=$e?>','select_mentor','select_mentor2');"/><br>
					<input type="hidden" name="mentor_name_<?=$e?>" value="<?=$_ment[0]?>" class="input sname" readonly />
					<input type="hidden" name="mentor_<?=$e?>" value="<?=$_ment[1]?>" class="input" readonly />
					<table id="lists">
						<tr>
							<th width="100">멘토</th>
							<th width="200">직업</th>
							<th width="100">지원자</th>
							<th width="100">1차 정원</th>
							<th width="100">2차 정원</th>
							<th width="100">정원</th>
							<th width="130">비고</th>
						</tr>
					<?php
					 $_temp = explode('|', $_ment[1]); 
					 $_where = "(";
					 foreach ($_temp as $value) {
						// mentorNum : 멘토번호,직업번호,정원
					 	$_mentorNum = explode(',', $value); 
					 	$_where .= "T.mentor_seq=".$_mentorNum[0]." or ";
					 }
					 $_where .= "1)";
					 $_result = db_query("select T.*, M.name as mentorName, J.name as jobName
from rb_dalkkum_team as T, rb_dalkkum_group as G, rb_dalkkum_sclist as SC, rb_s_mbrdata as M, rb_dalkkum_job as J
where T.group_seq=G.uid and T.job_seq=J.uid and G.sc_seq=SC.uid and T.mentor_seq=M.memberuid and G.uid = ".$R['uid']." and T.class_time=".$e." and ".$_where, $DB_CONNECT);
					 while ($CL = db_fetch_array($_result)):
					 	$_check_nows = getDbRows('rb_dalkkum_apply','group_seq='.$CL['group_seq'].' and class_'.$e.'='.$CL['uid']);
					 ?>
					 	<tr>
					 		<td class="center" onclick="javascript:OpenWindow('/?r=home&iframe=Y&m=dalkkum&a=export_team&uid=<?=$CL['uid']?>&mode=web');"><?=$CL['mentorName']?></td>
					 		<td class="center" onclick="javascript:OpenWindow('/?r=home&iframe=Y&m=dalkkum&a=export_team&uid=<?=$CL['uid']?>&mode=web');"><?=$CL['jobName']?></td>
					 		<td class="center" onclick="javascript:OpenWindow('/?r=home&iframe=Y&m=dalkkum&a=export_team&uid=<?=$CL['uid']?>&mode=web');"><?=$_check_nows?></td>
					 		<td class="center"><input type="text" class="limits" value="<?=$CL['limits']?>" data-limits_tid="<?=$CL['uid']?>"><input type="button" value="증원" onclick="limits_change('<?=$CL['uid']?>','1');"></td>
					 		<td class="center"><input type="text" class="limits" value="<?=$CL['limits2']?>" data-limits_tid2="<?=$CL['uid']?>"><input type="button" value="증원" onclick="limits_change('<?=$CL['uid']?>','2');"></td>
					 		<td class="center" onclick="javascript:OpenWindow('/?r=home&iframe=Y&m=dalkkum&a=export_team&uid=<?=$CL['uid']?>&mode=web');"><?=($R['use_second']?$CL['limits']+$CL['limits2']:$CL['limits'])?></td>
					 		<td class="center"><?php
					 		 if(($CL['limits']+$CL['limits']) == $_check_nows) echo '<font color="blue">마감</font>';
					 		 else if(($CL['limits']+$CL['limits2']) < $_check_nows) {
					 		 	$_getLastStd = getDbData('rb_dalkkum_team','uid='.$CL['uid'],'lastmbr_seq');
					 		 	$getLastStd = getDbData('rb_dalkkum_applyable','uid='.$_getLastStd['lastmbr_seq'],'name');
					 		 	if($getLastStd['name']) $_add = '<br>(LAST : '.$getLastStd['name'].' 학생)';
					 		 	echo '<font color="red">에러</font>'.$_add;}
					 		?></td>
					 	</tr>
					 <? endwhile; ?>
					</table><?php endif; ?>
				</td>
			</tr>
			<?php unset($_ment); endfor ?>
		</table>

		<div class="submitbox">
			<input type="submit" class="btnblue" value="<?=$R['uid']?'수강신청속성 변경':'새 수강신청 등록'?>" />
			<div class="clear"></div>
		</div>

		</form>
		

	</div>
	<div class="clear"></div>
</div>




<script type="text/javascript">
//<![CDATA[
function select_mentor_window(mytime,page,topage){
	window.open('/?r=home&iframe=Y&m=dalkkum&front=manager&mytime='+mytime+'&page='+page+'&topage='+topage+'&group=<?=$R['uid']?>','new','width=700px,height=700px,top=100,left=100');
}
function limits_change(tid,order){
	var changes;
	if(order=='1'){
		changes = $('[data-limits_tid="'+tid+'"]').val();
	} else if (order=='2'){
		changes = $('[data-limits_tid2="'+tid+'"]').val();
	}
	if(confirm('해당 수업의 멘토를 정말 변경하시겠습니까?')){
		$('[name="_action_frame_<?=$m?>"]').attr('src', '/?r=home&iframe=Y&m=dalkkum&a=changeMentor&act=modifyLimits&change='+changes+'&order='+order+'&tid='+tid);
	}
}

function show_times(num){
if(!num) num = 0;
		$('tr[class^="times_hide"]').hide();
	for(var i=1; i<=num; i++){
		$('tr[class="times_hide_'+i+'"]').show();
	}
}
function ToolCheck(compo)
{
	frames.editFrame.showCompo();
	frames.editFrame.EditBox(compo);
}
function open_apply(applyUID){
		var form_data = {
			need: 'share_applyevent',
			auid: applyUID
		};
		$.ajax({
			type: "POST",
			url: "/?r=home&m=dalkkum&a=getData",
			data: form_data,
			success: function(response) {
				var results = $.parseJSON(response);
				var inputin = results.result;
					if(results.code=='100') {
						$('[name="apply_seq"]').val(inputin.uid);
						$('select[name="class_year"]').val(inputin.start_date_y);
						$('select[name="class_month"]').val(inputin.start_date_m);
						$('select[name="class_day"]').val(inputin.start_date_d);
						$('select[name="select_hour"]').val(inputin.many_times);


		                map.setCenter(new daum.maps.LatLng(inputin.a_lat, inputin.a_long));
		                marker.setPosition(new daum.maps.LatLng(inputin.a_lat, inputin.a_long));

		                $('#addr_lat').val(inputin.a_lat);
		                $('#addr_long').val(inputin.a_long);

						show_times($('select[name="select_hour"]').val());
						$('input#address').val(inputin.address);
						$('input#address_detail').val(inputin.address_detail);

						for (var i = 0; i < inputin.many_times ; i++) {							
							$('select#start'+(i+1)+'_1').val(results.result.a_times[i][0]);
							$('select#start'+(i+1)+'_2').val(results.result.a_times[i][1]);
							$('select#end'+(i+1)+'_1').val(results.result.a_times[i][2]);
							$('select#end'+(i+1)+'_2').val(results.result.a_times[i][3]);
						}

						alert('데이터를 불러왔습니다.');
					}else{
						alert('데이터를 불러오는 도중 실패하였습니다.');
					}
			}
		});
}
function saveCheck(f)
{
	if (f.name.value == '')
	{
		alert('수강신청 그룹이름을 입력해 주세요.');
		f.name.focus();
		return false;
	}
	if (f.program_seq.value == '' || f.program_seq.value == '0')
	{
		alert('프로그램을 선택해주세요.');
		f.program_seq.focus();
		return false;
	}

	return confirm('정말로 실행하시겠습니까?');
}
$(document).ready(function(){
	show_times(<?=$R['select_hour'] ?>);
});
//]]>
</script>
<script>
	var default_lat = '<?=$R['grp_lat']?>';
	var default_long = '<?=$R['grp_long']?>';
</script>
<script type="text/javascript" src="http://apis.daum.net/maps/maps3.js?apikey=6b72c4c6de26e90f11c0e92b8f79b97a"></script>
<script src="/static/daumPicker.js"></script>
