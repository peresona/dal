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