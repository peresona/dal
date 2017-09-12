		<div id="d_headcell" class="inner_wrap2 cl center">
		<?php if(strpos($g['url_host'], 'app.')):?>
			<div class="cl pr">
				<div class="pa" style="right: 0; top:0; "><span class="icon d_sub_menu cp" onclick="app_drawer_menu();"></span></div>
				<a href="/"><span class="icon" style="width: 100%; height: 40px; line-height: 40px; font-size: 16px; font-size:bold; "><b><?=($_HM['name']?$_HM['name']:$_HP['name'])?></b></span></a>
				<div class="pa" style="left: 0; top:0; "><span class="icon d_sub_back cp" onclick="hybrid_menubar('hide'); history.back();"></span></div>
			</div>
		<?php else: ?>
			<div class="cl pr">
				<div class="pa" style="right: 0; top:0; "><span class="icon d_sub_menu cp" onclick="$('#d_drawer').addClass('show'); hybrid_menubar('hide'); "></span></div>
				<a href="/"><span class="icon d_logo"></span></a>
				<div class="pa" style="left: 0; top:0; "><a href="/search/"><span class="icon d_sub_search cp"></span></a></div>
			</div>
		<?php endif; ?>
		</div>