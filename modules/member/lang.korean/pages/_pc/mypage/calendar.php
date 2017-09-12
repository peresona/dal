<?php 
	if($my['mentor_confirm']!="Y") getLink('','','멘토회원만 이용 가능한 페이지 입니다.','-1');
	$_sql = "select T.uid, T.class_time, T.nows, G.name, G.date_start, G.date_end from rb_dalkkum_team as T, rb_dalkkum_group as G, rb_dalkkum_sclist as SC where T.group_seq = G.uid and G.sc_seq = SC.uid and T.mentor_seq=".$my['memberuid'];
	$_result = db_query($_sql, $DB_CONNECT);
	$printDate = array();

	// 하나는 기본으로 넣어주기
	$_tempdate = array('title' => '기본 세팅', 'start' => '2016-01-01');
	array_push($printDate, $_tempdate);

	while ($R = db_fetch_array($_result)) {
		$_tempdate = array('id' => $R['uid'], 'title' => $R['name'], 'start' => getDateFormat($R['date_start'],'Y-m-d\TH:i'), 'url' => $R['']);
		array_push($printDate, $_tempdate);
	}
?><style>
	.fc-content {cursor: pointer;}
</style>
<link href='/static/fullcalendar.min.css' rel='stylesheet' />
<link href='/static/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='/static/moment.min.js'></script>
<script src='/static/fullcalendar.min.js'></script>
<script src='/static/fullcalendar.ko.js'></script>
<div id='calendar'></div>
<script>
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listWeek'
			},
			defaultDate: '<?=getDateView($date['totime'], '-')?>',
			navLinks: true, // can click day/week names to navigate views
			editable: false,
		    timeFormat: ' ',
			eventLimit: true, // allow "more" link when too many events
			events: <?=json_encode($printDate)?>,
			eventClick: function(event){
				classDayDetail(event._start._i.substring(0,10).replace(/-/gi, ''));
				return false;
			}
		});
		
	});

</script>