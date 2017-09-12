<?php include_once $g['dir_module_skin'].'_menu.php'?>





<div id="pages_join">

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" enctype="multipart/form-data" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="simbol" />


	<div class="photo"><?php if($my['photo']):?><img src="<?php echo $g['url_root']?>/_var/simbol/<?php echo $my['photo']?>" alt="<?php echo $my['photo']?>" /><?php endif?></div>
	<div class="msg">
		회원님을 알릴 수 있는 사진을 등록해 주세요.<br />
		등록된 사진은 회원님의 게시물이나 댓글등에 사용됩니다.<br />
		<?php if($my['photo']):?><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=simbol_delete" title="<?php echo $my['photo']?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?    ');">현재사진삭제</a><?php endif?>
	</div>
	<div class="clear"></div>

	<div class="upload">
		<input type="file" name="upfile" class="upfile" />
		<input type="submit" value="사진등록" class="btngray" />
		
		<span>( gif / jpg / png - 50 * 50 픽셀)</span>
	</div>
	


	</form>

</div>

<script type="text/javascript">
//<![CDATA[
function saveCheck(f)
{
	if (f.upfile.value == '')
	{
		alert('사진파일을 선택해 주세요.');
		f.upfile.focus();
		return false;
	}
	var extarr = f.upfile.value.split('.');
	var filext = extarr[extarr.length-1].toLowerCase();
	var permxt = '[gif][jpg][jpeg][png]';

	if (permxt.indexOf(filext) == -1)
	{
		alert('gif/jpg/png 파일만 등록할 수 있습니다.    ');
		f.upfile.focus();
		return false;
	}

	return confirm('정말로 등록하시겠습니까?       ');
}
//]]>
</script>







<script type="text/javascript">
//<![CDATA[
function outCheck()
{
	if (confirm('탈퇴하시면 회원님의 모든 회원데이터가 삭제됩니다.    \n\n정말로 탈퇴하시겠습니까?'))
	{
		if (confirm('다시한번'))
		{
			return true;
		}
	}
	return false;
}
//]]>
</script>