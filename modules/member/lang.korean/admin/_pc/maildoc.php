<?php
function getMDname($id)
{
	global $typeset;
	if ($typeset[$id]) return $typeset[$id].'<span class="id">('.$id.')</span>';
	else return $id;
}
$typeset = array
(
	'_join'=>'회원가입축하 양식',
	'_auth'=>'이메일인증 양식',
	'_pw'=>'비밀번호요청 양식',
);
$type = $type ? $type : '_join';
?>
<div id="catebody">
	<div id="category">
		<div class="title">
			이메일양식
		</div>

		<div class="tree">
		<ul>
		<?php $tdir = $g['path_module'].$module.'/doc/'?>
		<?php $dirs = opendir($tdir)?>
		<?php while(false !== ($skin = readdir($dirs))):?>
		<?php if($skin=='.' || $skin == '..')continue?>
		<?php $_type = str_replace('.txt','',$skin)?>
		<li>
			<a href="<?php echo $g['adm_href']?>&amp;type=<?php echo $_type?>"><span class="name<?php if($_type==$type):?> on<?php endif?>"><?php echo getMDname($_type)?></span></a>
		</li>
		<?php endwhile?>
		<?php closedir($dirs)?>
		</ul>
		</div>

	</div>


	<div id="catinfo">


		<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $module?>" />
		<input type="hidden" name="a" value="maildoc_regis" />
		<input type="hidden" name="type" value="<?php echo $type?>" />

		<div class="title">
			<div class="xleft">
				양식등록정보
			</div>
			<div class="xright">

			</div>
		</div>

		<div class="notice">
			이메일 양식 소스코드를 등록해 주세요. 이미지 파일경로는 반드시 http://를 포함한 전체주소이어야 합니다.<br />
			내용에는 다음과 같은 치환문자를 사용할 수 있습니다.<br />
			회원이름 : {NAME} / 닉네임 {NICK} / 아이디 {ID} / 이메일 {EMAIL}
		</div>

		
		<div class="xwrap">
		<div class="iconbox">
			<a class="hand" onclick="window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&module=filemanager&front=main&fileupload=Y&iframe=Y&pwd=./files/_etc/&pwd1=email');" /><img src="<?php echo $g['img_core']?>/_public/ico_photo.gif" alt="" />이미지 첨부하기</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a class="hand" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.image&folder=./files/_etc/&sfolder=email&iframe=Y');" /><img src="<?php echo $g['img_core']?>/_public/ico_photo.gif" alt="" />이미지 불러오기</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a class="hand" onclick="ToolCheck('layout');">레이아웃</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a class="hand" onclick="ToolCheck('table');">테이블</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a class="hand" onclick="ToolCheck('box');">박스</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a class="hand" onclick="ToolCheck('link');">링크</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a class="hand" onclick="ToolCheck('icon');">아이콘</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a class="hand" onclick="frames.editFrame.ToolboxShowHide(0);" /><img src="<?php echo $g['img_core']?>/_public/ico_edit.gif" alt="" />편집</a>
		</div>

		<input type="hidden" name="html" id="editFrameHtml" value="HTML" />
		<input type="hidden" name="content" id="editFrameContent" value="<?php echo htmlspecialchars(implode('',file($g['path_module'].$module.'/doc/'.$type.'.txt')))?>" />
		<iframe name="editFrame" id="editFrame" src="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=editor&amp;toolbox=Y" width="100%" height="450" frameborder="0" scrolling="no"></iframe>
		</div>
		
		<div class="submitbox">
			<?php if(!$typeset[$type]):?>
			<input type="button" class="btngray" value=" 삭제 " onclick="delCheck('<?php echo $type?>');" />
			<?php endif?>
			<input type="submit" class="btnblue" value=" 수정 " />
			또는 이 양식을 
			<input type="text" name="newdoc" value="" size="15" class="input" title="영문소문자+숫자+_ 조합만 입력가능합니다." />으로
			<input type="submit" class="btngray" value=" 등록 " />
		</div>

		</form>
		

	</div>
	<div class="clear"></div>
</div>




<script type="text/javascript">
//<![CDATA[
function ToolCheck(compo)
{
	frames.editFrame.showCompo();
	frames.editFrame.EditBox(compo);
}
function delCheck(t)
{
	if (confirm('정말로 삭제하시겠습니까?   '))
	{
		frames._action_frame_<?php echo $m?>.location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $module?>&a=maildoc_delete&type=' + t;
	}
}
function saveCheck(f)
{
	frames.editFrame.getEditCode(f.content,f.html);
	if (f.content.value == '')
	{
		alert('내용을 입력해 주세요.       ');
		frames.editFrame.getEditFocus();
		return false;
	}
	if (f.newdoc.value != '')
	{
		if (!chkIdValue(f.newdoc.value))
		{
			alert('양식명은 영문소문자/숫자/_ 만 사용가능합니다.      ');
			f.newdoc.value = '';
			f.newdoc.focus();
			return false;
		}
	}

	return confirm('정말로 실행하시겠습니까?         ');
}
//]]>
</script>