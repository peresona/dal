function cate_change(cateName,cateValue){
	$('[data-invalue="search_cate_view"]').text(cateName);
	$('[data-invalue="search_cate"]').val(cateValue);
}

function main_recmd(obj, toggle, num){
	$(obj).siblings('.active').removeClass('active');
	$(obj).addClass('active');
	$('[data-toggle="'+toggle+'"]').hide();
	$('[data-toggle="'+toggle+'"][data-valno="'+num+'"]').fadeIn();
}
function moveBanner(mode){
	var bannerList = $('ul#scroller');
	if(mode=='prev'){
		var last_one = $('ul#scroller>li:last').clone().wrapAll("<div/>").parent().html();
		bannerList.prepend(last_one);
		$('ul#scroller>li:last').remove();
	}
	if(mode=='next'){
		var first_one = $('#scroller > li:nth-child(1)').clone().wrapAll("<div/>").parent().html();
		bannerList.append(first_one);
		$('#scroller > li:nth-child(1)').remove();
	}
}

