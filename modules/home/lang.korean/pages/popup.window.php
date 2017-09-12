<?php
$R = getUidData($table['s_popup'],$uid);
if (!$R['uid']) getLink('','','','close');
?>



<div id="popclose">
	<form name="pop"> 
		<input type="checkbox" name="x" checked="cbecked" />
		오늘 하루 이창을 그만 엽니다.
		<a href=".#" onclick="closeWin();"><img src="<?php echo $g['img_module_skin']?>/event_close_btn.gif" alt="창닫기" /></a>
	</form>
</div>
<div id="popupbody">
<?php echo getContents($R['content'],$R['html'],'')?>
</div>

<script type="text/javascript">
//<![CDATA[
function closeWin() 
{ 
    if ( document.pop.x.checked )
	{
		var nowcookie = getCookie("popview");
        setCookie( "popview", "[<?php echo $R[uid]?>]" + nowcookie , 1);
	}    
	self.close(); 
}
function popPositionSet()
{
	<?php if($R['center']):?>
	var width = parseInt(document.body.clientWidth);
	var height = parseInt(document.body.clientHeight);
	var windowX = (parseInt((window.screen.width-width)/2)+<?php echo $R['pleft']?>);
	var windowY = (parseInt((window.screen.height-height)/2)+<?php echo $R['ptop']?>);
	window.moveTo(windowX,windowY);
	<?php endif?>
	document.title = "<?php echo $R['name']?>";
}
window.onload = popPositionSet;
//]]>
</script> 

