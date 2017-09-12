
<?php if($m!='admin'&&$iframe!='Y'&&!$g['mobile']):?>
<script type="text/javascript">
//<![CDATA[
var Popstring = '';
<?php $POPUPS = getDbSelect($table['s_popup'],'hidden=0','*')?>
<?php while($POP=db_fetch_array($POPUPS)):?>
<?php if (!$POP['term0'] && ($POP['term1'] > $date['totime'] || $POP['term2'] < $date['totime'])):?>
<?php getDbUpdate($table['s_popup'],'hidden=1','uid='.$POP['uid']);continue?>
<?php endif?>
<?php $POP['xdispage']='_'.$POP['dispage']?>
<?php if(strpos($POP['xdispage'],'[c['.$_HS['uid'].']]')) continue?>
<?php if(!strpos($POP['xdispage'],'[s['.$_HS['uid'].']]') && !strpos($POP['xdispage'],'[m['.$_HS['uid'].']'.$_HM['id'].']') && !strpos($POP['xdispage'],'[m['.$_HS['uid'].']'.$_HP['id'].']')) continue?>
if (getCookie('popview').indexOf('[<?php echo $POP['uid']?>]') == -1)
{
	<?php if($POP['type']):?>
	Popstring += '[<?php echo $POP['uid']?>]';
	<?php else:?>
	window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.window&uid=<?php echo $POP['uid']?>&iframe=Y','popview_<?php echo $POP['uid']?>','left=<?php echo $POP['pleft']?>,top=<?php echo $POP['ptop']?>,width=<?php echo $POP['width']?>,height=<?php echo $POP['height']?>,scrollbars=<?php echo $POP['scroll']?'yes':'no'?>,status=yes');
	<?php endif?> 
}
<?php endwhile?>
if(Popstring!='')
{
	frames._action_frame_<?php echo $m?>.location.href='<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.layer&iframe=Y&pop='+Popstring;
}
function hidePopupLayer(uid) 
{ 
	if (getId('popCheck_'+uid).checked == true)
	{
		var nowcookie = getCookie('popview');
		setCookie('popview', '['+uid+']' + nowcookie , 1);
	}    
	getId('poplayer'+uid).style.display = 'none';
}
//]]>
</script>
<?php endif?>
