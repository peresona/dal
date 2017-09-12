<?php
$xtarget = substr($droparea,0,4);
if ($xtarget=='MENU'||$xtarget == 'PAGE')
{
	$xpwd = './pages/image/';
	$pwd1 = '';
}
else
{
	$xpwd = './files/_etc/';
	$pwd1 = 'etc';
}
?>
<div id="editbox">


	<form name="writeForm" method="post" onsubmit="return writeCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="upfiles" id="upfilesValue" value="<?php echo $reply=='Y'?'':$R['upload']?>" />


	<div class="iconbox">
		<a class="hand" onclick="window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&amp;module=filemanager&amp;front=main&amp;fileupload=Y&amp;iframe=Y&amp;pwd=<?php echo $xpwd?>&pwd1=<?php echo $pwd1?>');" /><img src="<?php echo $g['img_core']?>/_public/ico_photo.gif" alt="" />이미지 첨부하기</a>
		<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
		<a class="hand" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.image&folder=<?php echo $xpwd?>&iframe=Y');" /><img src="<?php echo $g['img_core']?>/_public/ico_photo.gif" alt="" />이미지 불러오기</a>
		<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
		<a href="#." onclick="ToolCheck('layout');">레이아웃</a>
		<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
		<a href="#." onclick="ToolCheck('table');">테이블</a>
		<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
		<a href="#." onclick="ToolCheck('box');">박스</a>
		<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
		<a href="#." onclick="ToolCheck('char');">특수문자</a>
		<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
		<a href="#." onclick="ToolCheck('link');">링크</a>
		<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />

		<a href="#." onclick="ToolCheck('icon');">아이콘</a>
		<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
		<a href="#." onclick="ToolCheck('flash');">플래쉬</a>
		<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
		<a href="#." onclick="ToolCheck('movie');">동영상</a>
		<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
		<a href="#." onclick="ToolCheck('html');">HTML</a>
		<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
		<a href="#." onclick="frames.editFrame.ToolboxShowHide(0);" /><img src="<?php echo $g['img_core']?>/_public/ico_edit.gif" alt="" />편집</a>
	</div>

	<div>
	<input type="hidden" name="html" id="editFrameHtml" value="HTML" />
	<input type="hidden" name="content" id="editFrameContent" value="" />
	<iframe name="editFrame" id="editFrame" src="" width="100%" height="565" frameborder="0" scrolling="no"></iframe>
	</div>
	<br />
	<div class="btnbox">
	<input type="button" value=" 창닫기 " class="btngray" onclick="top.close();" />
	<?php if($droparea):?><input type="submit" value=" 소스적용하기 " class="btnblue" /><?php endif?>
	</div>
	</form>


</div>

<script type="text/javascript">
//<![CDATA[
function ToolCheck(compo)
{
	frames.editFrame.showCompo();
	frames.editFrame.EditBox(compo);
}
function writeCheck(f)
{
	frames.editFrame.getEditCode(f.content,f.html);

	if (f.content.value == '')
	{
		alert('내용을 입력해 주세요.       ');
		frames.editFrame.getEditFocus();
		return false;
	}

	opener.getId('<?php echo $droparea?>').value = f.content.value;
	top.close();

	return false;
}
function editStart()
{
	<?php if($droparea):?>document.writeForm.content.value = opener.getId('<?php echo $droparea?>').value;<?php endif?>
	getId('editFrame').src = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=editor&toolbox=Y&reSize=N';
	document.title = "편집기";
	document.body.style.padding = '5px';
	document.body.style.background = '#333333';
	top.resizeTo(950,765);
}
window.onload = editStart;
//]]>
</script>
