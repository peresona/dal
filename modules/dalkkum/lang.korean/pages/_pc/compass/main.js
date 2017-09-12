function job_autosearch(mode){
	if(mode == 'active'){
		$('#job_search').show();
	}else{
		$('#job_search').hide();
	}
}
function job_autosearching(keyword){
	var form_data = {
		need: 'search_job_kwd',
		jobkwd: keyword
	};
	$.ajax({
		type: "POST",
		url: "/?r=home&m=dalkkum&a=getData",
		data: form_data,
		success: function(response) {
			var results = $.parseJSON(response);
			//console.log(results);
				if(results.num > 0) {
					$('[data-inhtml="job_search_list"]').html(results.inhtml);
				}
				else {
					$('[data-inhtml="job_search_list"]').html('<li class="nothing">키워드를 입력해주세요.</li>');
				}
		}
	});
}
function jobNum(num, title){
	document.location.href="/compass/?job="+num;
}

function movejob(){
	location.href = '/compass/';
}
function movejob(num){
	location.href = '/compass/?job='+num;
}
function search_box(mode){
if(mode == "find"){
	$('.kin_search').hide();
	$('#kin_search2_1').show();
	$('#kin_search_btn1').addClass('active');
	$('#kin_search_btn2').removeClass('active');
}
else if(mode == "write"){
	$('.kin_search').hide();
	$('#kin_search2_2').show();
	$('#kin_search_btn1').removeClass('active');
	$('#kin_search_btn2').addClass('active');
}
}