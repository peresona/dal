<?php
if (!$folder || substr($folder,0,2) != './') getLink('','','잘못된 접근입니다.','close');
if ($sfolder) $sfolder .= '/';
?>

<div id="imagebox">

	<div class="header">
		<h1>이미지 불러오기</h1>
		<div class="guide">
		선택된 폴더내의 이미지파일을 본문에 삽입할 수 있습니다.<br />
		삽입하려는 이미지를 선택해 주세요.
		</div>
		<div class="clear"></div>
	</div>
	<div class="line1"></div>
	<div class="line2"></div>
	<div class="line3"></div>

	<div class="content">
		
		<?php $i=0?>
		<?php $dirs = opendir($folder.$sfolder)?>
		<?php while(false !== ($file = readdir($dirs))) :?>
		<?php if($file=='.'||$file=='..') continue?>
		<?php $fileExt = strtolower(getExt($file))?>
		<?php if(!strstr('[jpg][jpeg][png][gif]',$fileExt)) continue?>
		<?php $IM = getimagesize($folder.$sfolder.$file)?>
		<?php $i++?>
	
		<div class="photo"><img src="<?php echo $g['url_root'].str_replace('./','/',$folder).$sfolder.$file?>"<?php if($IM[0]>105):?> width="105"<?php endif?> alt="<?php echo $file?>" title="<?php echo $file?>" class="hand" onclick="insertPhoto(this);" /></div>
		
		<?php endwhile?>
		<?php closedir($dirs)?>
		
		<?php if(!$i):?>
		<div class="none">
		<img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" />
		현재폴더(<?php echo $folder.$sfolder?>)에는 이미지파일이 없습니다.
		</div>
		<?php endif?>

	</div>

	<div class="footer">

		폴더위치 : <?php echo $folder?>
		<select style="padding:2px;margin:1px;" onchange="goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&system=<?php echo $system?>&iframe=<?php echo $iframe?>&folder=<?php echo $folder?>&sfolder='+this.value);">
		<option value=""></option>
		<?php $dirs = opendir($folder)?>
		<?php while(false !== ($tpl = readdir($dirs))):?>
		<?php if($tpl=='.' || $tpl == '..' || is_file($folder.$tpl))continue?>
		<option value="<?php echo $tpl?>"<?php if($sfolder==$tpl.'/'):?> selected="selected"<?php endif?>><?php echo $tpl?></option>
		<?php endwhile?>
		<?php closedir($dirs)?>
		</select>

		<input type="button" value="이미지 올리기" class="btngray" onclick="window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=filemanager&front=main&fileupload=Y&iframe=Y&pwd=<?php echo $folder?>&pwd1=<?php echo str_replace('/','',$sfolder)?>');" />
		<input type="button" value="새 폴더" class="btngray" onclick="window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=filemanager&front=main&folderadd=Y&iframe=Y&pwd=<?php echo $folder?>');" />
		<input type="button" value="취소(창닫기)" class="btngray" onclick="top.close();" />
	</div>
</div>


<script type="text/javascript">
//<![CDATA[
function insertPhoto(obj)
{
	var photos = '<img src="'+obj.src+'" class="photo" alt="" /><br /><br />';
	opener.frames.editFrame.EditDrop(photos);
}
document.title = '이미지 불러오기';
top.resizeTo(630,600);
//]]>
</script>