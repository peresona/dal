<?php 
	$_result = getDbSelect('rb_dalkkum_mainmsg','','*');
	$printDate = array();

	// 하나는 기본으로 넣어주기
	$_tempdate = array('title' => '기본 세팅', 'start' => '2016-01-01');
	array_push($printDate, $_tempdate);

	while ($R = db_fetch_array($_result)) {
		$_tempdate = array('id' => $R['uid'], 'title' => $R['content'].' '.$R['content2'].' '.$R['content3'], 'start' => getDateFormat($R['show_date'],'Y-m-d\TH:i'), 'url' => $R['']);
		array_push($printDate, $_tempdate);
	}
?><style>
	.cl {clear: both; overflow: hidden;}
	.fc-content {cursor: pointer;}
	.fc-toolbar.fc-header-toolbar {height: 50px;}
</style>
<link href='/static/fullcalendar.min.css' rel='stylesheet' />
<link href='/static/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='/static/moment.min.js'></script>
<script src='/static/fullcalendar.min.js'></script>
<script src='/static/fullcalendar.ko.js'></script>
<div id='calendar' style="position: relative;">
	<div style="position:absolute; top: 0px; right: 160px; text-align: right; z-index: 100;">
		<button type="button" class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right" onclick="$('#write_day').show();"> + 문구 추가하기</button><br>
		<div id="write_day" class="cl" style="margin-top: 10px; padding: 10px; background-color: #eee; display: none; line-height: 30px; text-align: center; border-radius: 10px; border: solid 2px #999;">
			<form action="/" target="_action_frame_admin">
				<input type="hidden" name="r" value="home">
				<input type="hidden" name="m" value="home">
				<input type="hidden" name="a" value="mainmsg">
				<input type="hidden" name="act" value="regis">
				문구 추가 할 날짜 : <select name="showdate" id="showdate">
					<?php for($i=$date['year']-2;$i<$date['year']+5;$i++):?><option value="<?php echo $i?>"<?php if(substr($date['today'],0,4)==$i):?> selected="selected"<?php endif?>><?php echo $i?>년</option><?php endfor?>
				</select>년
				<select name="showdate2" id="showdate">
					<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if(substr($date['today'],4,2)==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>월</option><?php endfor?>
				</select>월
				<select name="showdate3" id="showdate">
					<?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if(substr($date['today'],6,2)==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>일(<?php echo getWeekday(date('w',mktime(0,0,0,$month1,$i,$year1)))?>)</option><?php endfor?>
				</select>일<br>
					첫 째 줄 : <input type="text" name="content" value="[name]님" style="width: 400px;" placeholder="메인에 보일 메시지" maxlength="30"><br>
					둘 째 줄 : <input type="text" name="content2" value="" style="width: 400px;" placeholder="메인에 보일 메시지" maxlength="30"><br>
					셋 째 줄 : <input type="text" name="content3" value="" style="width: 400px;" placeholder="메인에 보일 메시지" maxlength="30"><br>
					링크 주소 : <input type="text" name="url" value="" style="width:400px;" placeholder="없으면 공란"><br>
					 - 이름 치환 문구 ( [name]님 => 김달빛님 ) <br>
					<input type="submit" value="추가">
					<input type="button" value="닫기" onclick="$('#write_day').hide();">
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listWeek'
			},
			defaultDate: '<?=getDateView($date['totime'], "-")?>',
			navLinks: true, // can click day/week names to navigate views
			editable: false,
		    timeFormat: ' ',
			eventLimit: true, // allow "more" link when too many events
			events: <?=json_encode($printDate)?>,
			eventClick: function(event){
				if(confirm('해당 메시지를 삭제하시겠습니까?')){
					window._action_frame_admin.location.href = "/?r=home&m=home&a=mainmsg&act=delete&uid="+event.id;
				}
				return false;
			}
		});
		
	});


</script>