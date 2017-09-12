<script>
	var std_info = {
		sc_name : "<?=$my['sc_name']?>",
		grade : "<?=$my['sc_grade']?>",
		class : "<?=$my['sc_class']?>",
		num : "<?=$my['sc_num']?>",
		name : "<?=$my['name']?>"
	};
	function hybrid_menubar(mode){

	}
</script>

<?php if(!strpos($g['url_host'], 'app.')):?>
<article class="copyright_bg">
	<div id="copyright_side" class="inner_wrap cl center">
						<p><a href="/intro">달꿈소개</a>   |   
		<a href="/agreement/">이용약관</a>   |   
		<a href="/private/">개인정보 취급방침</a><br> 
		<a href="/postrule/">게시물 게재원칙</a>   |  
		<a href="/partnership/">제휴문의</a></p>
		<p>상호명 : (주)달꿈 | 사업자등록번호 : 215-87-96093 <br> 대표자 : 김동연 | 주소 : 서울시 강남구 삼성동<br> 152-67 일신빌딩 4층 <br>
			전화 : 02-562-1116 | 팩스 : 02-564-1116 <br> 이메일 : help@dalkkum.com
			</p>
		<p><font color="#999999">Copyright © 2015 Dalkkum - All Rights Reserved </font></p>

	</div>
</article>
<script>
	mheader('show');
</script>
<?php else : ?>
	<script src="/static/hybrid.js"></script>
	<script>
	function hybrid_menubar(mode){
		if(mode == 'show'){
			Hybrid.exe('HybridIfEx.showToolbar', {isShow : true});  
		}else if (mode=='hide'){
			Hybrid.exe('HybridIfEx.showToolbar', {isShow : false});  
		}
	}
	function app_drawer_menu() {
	    if ($('#d_drawer').hasClass('show')) {
	        $('#d_drawer').removeClass('show');
	    	hybrid_menubar('show');
	    } else {
	        $('#d_drawer').addClass('show');
	        $('#d_drawer').css('z-index','100');
	    	hybrid_menubar('hide');
	    }
	}
	
	<?php 
	$c_set = array('intro','apply','review','notice','cs','jkin','lib','explorer','compass','profile','mblog','jblog');
	$mod_set = array('mypage','search','join','agreement','private','postrule','login','join');
	if(in_array($c, $c_set) || in_array($mod, $mod_set) || in_array($_GET['c'], $c_set) || in_array($_GET['mod'], $mod_set) || $bid):?>mheader('show');<?php else: ?>mheader('hide');<?php endif; ?>
	</script>
	<style>
		body {padding-top: 0px !important;}
	</style>
<?php endif; ?>