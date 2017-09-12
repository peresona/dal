<?php
if (!$rcvmbr) getLink('','parent.getLayerBoxHide();','회원이 지정되지 않았습니다.','');
$M = getDbData($table['s_mbrdata'],'memberuid='.$rcvmbr,'*');
if (!$M['memberuid']) getLink('','parent.getLayerBoxHide();','회원이 지정되지 않았습니다.','');
$g['snseng'] = array('t'=>'Twitter','f'=>'Facebook','m'=>'Me2day','y'=>'Yozm');
$g['snskor'] = array('t'=>'트위터','f'=>'페이스북','m'=>'미투데이','y'=>'요즘');
?>

<div id="snsNbox">

	<div class="snsaccount">
	<?php $g['mhsns']=explode('|',$M['sns'])?>
	<?php $i=0;foreach($g['snskor'] as $_key=>$_val):?>
	<?php $_snsuse=explode(',',$g['mhsns'][$i])?>

	<div class="snsx">
		<?php if($_snsuse[1]):?>
		<a href="<?php echo $_snsuse[1]?>" target="_blank"><img src="<?php echo $g['img_core']?>/_public/sns_<?php echo $_key?>2.gif" alt="<?php echo $_val?>" title="<?php echo $_val?>계정이 있습니다." /></a>
		<?php else:?>
		<img src="<?php echo $g['img_core']?>/_public/sns_<?php echo $_key?>2.gif" alt="<?php echo $_val?>" title="<?php echo $_val?>" class="filter gray" />
		<?php endif?>
		<span<?php if($_snsuse[1]):?> class="issns"<?php endif?>><?php echo $_val?></span>
	</div>
	<?php $i++; endforeach?>
	<div class="clear"></div>
	</div>

</div>

<script type="text/javascript">
//<![CDATA[
//parent.getId('_box_layer_').style.width = '300px';
//parent.getId('_box_layer_').style.height = '150px';
//parent.getId('_box_frame_').style.height = '120px';
//]]>
</script>

