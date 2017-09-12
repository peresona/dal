function change_tab(tab_num){
	$('[data-act="change_tab"][data-tab]').removeClass('active');
	$('[data-act="change_tab"][data-tab="'+tab_num+'"]').addClass('active');
	$('.apply_box').hide();
	$('#apply_'+tab_num+'.apply_box').show();
}
function cancel_apply(apply_time,apply_team){
		var form_data = {
			act: 'cancel',
			apply_time: apply_time,
			apply_team: apply_team,
		};
		$.ajax({
			type: "POST",
			url: "/?r=home&m=dalkkum&a=actionApply",
			data: form_data,
			success: function(response) {
				var results = $.parseJSON(response);
					alert(results.msg);
					if(results.code=='100') {
						$('tr[data-myapply_line="'+apply_time+'-'+apply_team+'"]').remove();
						$('span#getNumApply').text(results.hasClass);
						$('[data-cell="'+apply_time+'-'+apply_team+'"]').text($('[data-cell="'+apply_time+'-'+apply_team+'"]').text()-1);
					}
			}
		});
}
$(document).ready(function(){
	change_tab('1');
	// 탭변경
	$('[data-act="change_tab"][data-tab]').on('click',function(){
		change_tab($(this).data('tab'));
	});
	$('#apply_popup_title').on('click',function(){
		if($('#apply_popup_wrap').hasClass('active')){
			$('#apply_popup_wrap').removeClass('active');
		}
		else{
			$('#apply_popup_wrap').addClass('active');
		}
	});
	// 취소하기 버튼
	$('[data-cancelteam][data-canceltime]').on('click',function(){
		apply_time = $(this).data('canceltime');
		apply_team = $(this).data('cancelteam');
		cancel_apply(apply_time,apply_team);
	});
	// 신청하기 버튼
	$('[data-applyteam][data-applytime]').on('click',function(){
		var form_data = {
			act: 'apply',
			apply_time: $(this).data('applytime'),
			apply_team: $(this).data('applyteam'),
		};
		$.ajax({
			type: "POST",
			url: "/?r=home&m=dalkkum&a=actionApply",
			data: form_data,
			success: function(response) {
				var results = $.parseJSON(response);
					alert(results.msg);
					$('[data-cell="'+form_data.apply_time+'-'+form_data.apply_team+'"]').text(results.nows);
					if(results.code=='100') {
						$('#myapply > tbody:last').append('<tr data-myapply_line="'+results.class+'-'+form_data.apply_team+'"><td>'+results.class+'교시</td><td>'+results.job+'</td><td>'+results.mentor+'</td><td><input type="button" class="black_cancel cp" value="취소" onclick="cancel_apply(\''+results.class+'\',\''+form_data.apply_team+'\');"></td></tr>');
						$('span#getNumApply').text(results.hasClass);
						if(select_hour == results.hasClass){
							if(confirm('모든 교시의 수강신청이 완료되었습니다.\n메인으로 이동하시겠습니까?')){
								location.href = "/";
							}
						}
					}
			}
		});
	});
});
