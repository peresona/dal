		<article class="d_sub_midcell cl white" style="background-color: #4f9cd0">
			<div class="cl inner_wrap" style="height:260px; padding:20px 0; ">
				<div class="fl" style="margin-right: 40px;"><img src="<?=$g['img_layout']?>/apply_head.png" width="195" height="256" alt="수강신청"></div>
				<div class="fl" style="padding-top: 40px;"><span class="htitle">꿈을 찾을 때 까지 멘토를 만나라</span><br><span class="htitle3">나와 같은 고민을 했던 멘토, 해답은 그들에게 있다. <br>
길을 찾을 때까지 만나라. 해답은 분명히 그곳에 있다.</span></div>
			</div>
		</article>
		<article>
			<div id="d_main_appling" class="inner_wrap cl">	
				<div id="d_main_jobs_1" class="cl center"><font class="title_bold">현재 진행중인 </font><font class="title">수강신청</font><br> <font class="title_text">현재 진행중인 수강신청 목록입니다.</font></div>
				<div id="d_main_search" class="cl">
					<div>
						<form name="searchbox" onsubmit="return false;">
							<select name="sort" id="sort" class="btngray" onchange="apply_search();">
								<option value="">최근등록순</option>
								<option value="date_end|asc"<?if($sort == "date_end|asc"):?> selected<?endif;?>>신청마감순</option>
							</select>
							<select name="search" id="search" class="btngray">
								<option value="">선택</option>
								<option value="school"<?if($keyword && ($search == "school")):?> selected<?endif;?>>학교 이름</option>
								<option value="group"<?if($keyword && ($search == "group")):?> selected<?endif;?>>그룹 이름</option>
							</select>
							<input type="text" name="keyword" class="btngray" value="<?=$keyword?>" placeholder="키워드 입력">
							<input type="submit" class="btnblue" value="검색" onclick="apply_search();">
							<input type="button" class="btngray" value="취소" onclick="apply_search('reset');">
						</form>
					</div>
				</div>
				<div id="d_main_appling_main" class="cl">
					<ul data-inhtml="apply_lists">
					</ul>
				</div>
				<div class="cl" style="margin-top: 40px;">
					<span class="icon d_job_more btn" data-moreapply="0"></span>
				</div>

				<div id="ads_foot" class="cl">
					<div class="fl" style="width: 350px; height: 150px; background-color: #eee; margin:0 25px;">
						<a href="<?=($Bmainfoot_1['url']?$Bmainfoot_1['url']:'/')?>" target="_blank"><img src="<?='/files/_etc/foot_banner/'.($Bmainfoot_1['file']?$Bmainfoot_1['file']:'default.png')?>" width="350" height="150" alt="<?=$Bmainfoot_1['title']?>"></a>
					</div>
					<div class="fl" style="width: 350px; height: 150px; background-color: #eee; margin:0 25px;">
						<a href="<?=($Bmainfoot_2['url']?$Bmainfoot_2['url']:'/')?>" target="_blank"><img src="<?='/files/_etc/foot_banner/'.($Bmainfoot_2['file']?$Bmainfoot_2['file']:'default.png')?>" width="350" height="150"></a>
					</div>
					<div class="fr" style="width: 350px; height: 150px; background-color: #eee; margin:0 25px;">
						<a href="<?=($Bmainfoot_3['url']?$Bmainfoot_3['url']:'/')?>" target="_blank"><img src="<?='/files/_etc/foot_banner/'.($Bmainfoot_3['file']?$Bmainfoot_3['file']:'default.png')?>" width="350" height="150"></a>
					</div>
				</div>
			</div>
		</article>


<script>

function apply_search(mode){
	var f = document.searchbox;
	if(mode=='reset'){
		f.search.value="";
		f.keyword.value="";
		f.sort.value="";
	}
	$('[data-inhtml="apply_lists"]').children().hide('slow',function(){
		$(this).remove();
	});
	$('.d_job_more[data-moreapply]').show();
	$('[data-moreapply]').data('moreapply','0');
	more_apply_lists('0', $('[data-moreapply]'),f.search.value,f.keyword.value,f.sort.value);
}


function more_apply_lists(indexs,obj,search,keyword,sort){
		var form_data = {
			need: 'apply_lists',
			index: indexs,
			search: search,
			keyword: keyword,
			sort: sort
		};
		$.ajax({
			type: "POST",
			url: "/?r=home&m=dalkkum&a=getData",
			data: form_data,
			success: function(response) {
				var results = $.parseJSON(response);
					if(results.code=='100') {
						$('[data-inhtml="apply_lists"]').append(results.inhtml);
						$('[data-moreapply]').data('moreapply',$('[data-moreapply]').data('moreapply')+results.num);
						if(results.num != 6) {
							$('.d_job_more[data-moreapply]').hide();
						}
					}
					else{
						alert(results.msg);
					}
			}
		});
}


$(document).ready(function(){

	more_apply_lists('0', $('[data-moreapply]'),'<?=$search?>','<?=$keyword?>','<?=$sort?>');

	// 수강신청 추가
	$('[data-moreapply]').on('click',function(){
		var moreapply = $(this).data('moreapply');
		more_apply_lists(moreapply, $(this));
	})

});

</script>