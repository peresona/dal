<?php 
	$_result = getDbSelect('rb_dalkkum_eventapply','','*');
	$printDate = array();
	$stepName = array('제출','확인 전','확인 중','거절','진행중','완료');
	// 하나는 기본으로 넣어주기
	$_tempdate = array('title' => '기본 세팅', 'start' => '2010-01-01');
	$_stepColor = array('#ffcccc','#996666','','#ccc','','#ccccff');
	array_push($printDate, $_tempdate);

	while ($R = db_fetch_array($_result)) {

		$_tempdate = array('id' => $R['uid'], 'title' => '['.$stepName[$R['step']].']'.$R['a_group'].' '.($R['memo']?' - '.$R['memo']:''), 'start' => getDateFormat($R['start_date'],'Y-m-d\TH:i'), 'backgroundColor' => $_stepColor[$R['step']], 'borderColor' => $_stepColor[$R['step']]);
		array_push($printDate, $_tempdate);
	}
?><style>
	.cl {clear: both; overflow: hidden;}
	.fc-content {cursor: pointer; font-size: 15px;}
	.fc-toolbar.fc-header-toolbar {height: 50px;}
</style>
<link href='/static/fullcalendar.min.css' rel='stylesheet' />
<link href='/static/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='/static/moment.min.js'></script>
<script src='/static/fullcalendar.min.js'></script>
<script src='/static/fullcalendar.ko.js'></script>
<div id='calendar' style="position: relative;">
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
				console.log(event);
				OpenWindow('/?r=home&iframe=Y&m=dalkkum&front=manager&page=view_event_apply&uid='+event.id);
				return false;
			}
		});
		
	});


</script>