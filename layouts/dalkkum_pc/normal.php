	<header class="cl forsub">	
		<div class="inner_wrap2 pr">
			<div id="quick_box" class="pa center cl">
				<div class="cl" style="border-bottom: solid 1px #666; padding-bottom: 8px;">Quick</div>
				<?php getWidget('quick_menu',array())?>
			</div>
		</div>
		<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/head_sub.php';?>

	</header>
	<section>
		<article>
			<div id="d_sub_content" class="inner_wrap cl">
				<div id="d_sub_content_main" class="cl">
					<?php include __KIMS_CONTENT__;?>
				</div>
			</div>
		</article>
	</section>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/copyright.php';?>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/drawer.php';?>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/modal.php';?>
