		<style>
		.forsub li#head_search {
			display: inline-block;
			padding: 0px;
		    width: 120px;
    		height: 40px;
		    margin: 16px 0 0 0;
		    font-size: 12px;
		    line-height: 16px;
		    color: #000;
		    border: solid 1px transparent;
		}
		.forsub li#head_search:hover {
		    border: solid 1px #000;
		}
		.forsub li#head_search input[type="text"],li#head_search.active input[type="button"] {display: none;}
		.forsub li#head_search:hover input[type="text"] {display: inline-block; width:98px; height: 36px; line-height: 34px; border: none;}
		.forsub li#head_search .pa {right: 10px; top: 10px;}
		.forsub li#head_search .pa input{border: none;}
		.forsub .icon.keyword {background: url('<?=$g['img_layout']?>/search_bk.png') no-repeat center center; width: 19px; height: 19px; margin:9px 0; border: none;}
		.forsub .icon.head_login {background: url('<?=$g['img_layout']?>/in_bk.png') no-repeat center center; width: 24px; height: 22px; margin:26px 0 15px 0; border: none;}
		.forsub .icon.head_logout {background: url('<?=$g['img_layout']?>/out_bk.png') no-repeat center center; width: 24px; height: 22px; margin:26px 0 15px 0; border: none;}
		.forsub .icon.head_mypage {background: url('<?=$g['img_layout']?>/my_bk.png') no-repeat center center; width: 24px; height: 22px; margin:26px 0 15px 0; border: none;}
		</style>
		<div id="d_headcell" class="inner_wrap2 cl">
			<ul>
				<li class="fl"><a href="/"><span class="icon d_logo"></span></a></li>
				<li class="fr"><span class="icon d_sub_menu cp" onclick="$('#d_drawer').addClass('show'); "></span></li>
				<?php if($my['uid']):?>
				<li class="fr"><a href="/?r=home&a=logout" onclick="return confirm('로그아웃 하시겠습니까?');"><span class="icon head_logout"></span></a></li>
				<li class="fr"><a href="/mypage"><span class="icon head_mypage"></span></a></li>
				<?php else: ?>
				<li class="fr"><a href="/?mod=login"><span class="icon head_login"></span></a></li>
				<?php endif; ?>
				<li class="fr" id="head_search">
					<form action="/search/" method="get">
						<div class="fr"><input type="submit" class="icon keyword" value="">
						<input type="text" name="keyword" placeholder="검색" class="fl">
					</form>
				</li>
				<?php getWidget('menu01',array('smenu'=>'0','limit'=>'1',))?>
			</ul>
		</div>

		<script>
		</script>