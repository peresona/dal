
<div id="_popwrap_">
	<?php $pops = getArrayString($pop)?>
	<?php foreach($pops['data'] as $_val):?>
	<?php $R=getUidData($table['s_popup'],$_val)?>
	<div id="poplayer<?php echo $R['uid']?>" style="position:absolute;z-index:<?php echo $R['uid']?>;width:<?php echo $R['width']?>px;height:<?php echo $R['height']?>px;top:<?php echo $R['ptop']?>px;left:<?php echo $R['pleft']?>px;<?php if($R['center']):?>margin:20% 30%;<?php endif?>">

		<div class="popupbody" style="height:<?php echo ($R['height']-25)?>px;overflow-x:hidden;overflow-y:<?php echo $R['scroll']?'auto':'hidden'?>;">
		<?php echo getContents($R['content'],$R['html'],'')?>
		</div>
		<div class="popclose">
			<input type="checkbox" id="popCheck_<?php echo $R['uid']?>" checked="cbecked" />
			오늘 하루 이창을 그만 엽니다.
			<img src="<?php echo $g['img_module_skin']?>/event_close_btn.gif" alt="창닫기" class="hand" onclick="hidePopupLayer('<?php echo $R['uid']?>');" />
		</div>
	</div>
	<?php endforeach?>
	<link type="text/css" rel="stylesheet" charset="utf-8" href="<?php echo $g['url_module_mode']?>.css" />
</div>

<script type="text/javascript">
//<![CDATA[
var pg = parent.getId('_hidden_layer_');
pg.style.position = 'absolute';
pg.style.width = '100%';
pg.style.height = '100%';
pg.style.top = '0px';
pg.style.left = '0px';
pg.innerHTML = getId('_popwrap_').innerHTML;
//]]>
</script> 

