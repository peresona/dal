<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/modal.php';?>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/drawer.php';?>
	<header class="cl forsub" <?php if(strpos($g['url_host'], 'app.')):?>style="display:none;"<?php endif; ?>>	
		<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/head_sub.php';?>
	</header>
	<section>
		<article>
			<div id="d_sub_content" class="inner_wrap cl">
				<div id="d_sub_content_main" class="cl">
					<?php getWidget('mobile_head',array('menu'=>'mblog','MUID'=>$mentor,'JUID'=>$job)); ?>
					<?php include __KIMS_CONTENT__;?>
				</div>
			</div>
		</article>
	</section>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/copyright.php';?>