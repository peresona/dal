<style>
	input.btn.d_login {background: url('<?=$g['img_layout']?>/login.png') top center no-repeat; width:575px; height: 72px; }
	input.btn.d_login_f {background: url('<?=$g['img_layout']?>/login_f.png') top center no-repeat; width:575px; height: 72px; }
	input.btn.d_login_n {background: url('<?=$g['img_layout']?>/login_n.png') top center no-repeat; width:575px; height: 72px; }
	input.btn.d_login_k {background: url('<?=$g['img_layout']?>/login_k.png') top center no-repeat; width:575px; height: 72px; }
	span.d_login_line {display:block; background: url('<?=$g['img_layout']?>/login_line.png') top center no-repeat; width: width:1158px; height: 54px; margin-top: 70px; cursor: default;}
</style>
	<form name="loginform" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return loginCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="a" value="login" />
	<input type="hidden" name="referer" value="<?php echo $referer ? $referer : $_SERVER['HTTP_REFERER']?>" />
	<input type="hidden" name="usessl" value="<?php echo $d['member']['login_ssl']?>" />
		<div id="d_sub_content_title" class="cl center"><font class="bigtitle_bold">달꿈 </font><font class="bigtitle">로그인</font><br> <font class="title_text">달꿈에 로그인 하시고 다양한 서비스를 만나보세요.</font></div>
		<div id="d_id_input" class="cl login_form">
			<font class="black">이메일</font><br>
			<input type="text" id="userid" name="id" class="d_form_underline" placeholder="이메일 주소를 입력해주세요." value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',0)?>"><br>
			<font class="black">패스워드</font><br>
			<input type="password" name="pw" class="d_form_underline" placeholder="패스워드를 입력해주세요." value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',1)?>"><br>
		</div>
		<div class="cl login_form gray" style="margin:0px auto;">
			<span class="fl"><input type="checkbox" name="idpwsave" value="checked" onclick="remember_idpw(this)"<?php if($_COOKIE['svshop']):?> checked="checked"<?php endif?> /><?php echo $d['member']['login_emailid']?'이메일':'아이디'?>/비밀번호 기억</span>
			<span class="fr"><a href="/?mod=join">회원가입</a></span>
			<span class="fr"><a href="<?php echo $g['url_reset']?>&page=idpwsearch">아이디 · 비밀번호 찾기</a></span>
		</div>
		<input type="submit" class="btn d_login cl" value="">
		<span class="btn d_login_line cl"></span>

		<?php foreach($g['snskor'] as $key => $val):?>
		<?php if(!$d[$g['mdl_slogin']]['use_'.$key])continue?>
		<input type="button" class="btn d_login_<?=substr($val[1], 0, 1)?> cl" onclick="location.href='<?php echo $slogin[$val[1]]['callapi']?>'">
		<?php endforeach?>
	</form>

<script type="text/javascript">
//<![CDATA[
function loginCheck(f)
{
	if (f.id.value == '')
	{
		alert('<?php echo $d['member']['login_emailid']?'이메일을':'아이디를'?> 입력해 주세요.');
		f.id.focus();
		return false;
	}
	if (f.pw.value == '')
	{
		alert('비밀번호를 입력해 주세요.');
		f.pw.focus();
		return false;
	}
	if (f.usessl.value == '1')
	{
		if (f.ssl.checked == true)
		{
			var fs = document.SSLLoginForm;
			fs.id.value = f.id.value;
			fs.pw.value = f.pw.value;
			if(f.idpwsave.checked == true) fs.idpwsave.value
			fs.submit();
			return false;
		}
	}
}
function remember_idpw(ths)
{
	if (ths.checked == true)
	{
		if (!confirm('\n\n패스워드정보를 저장할 경우 다음접속시 \n\n패스워드를 입력하지 않으셔도 됩니다.\n\n그러나, 개인PC가 아닐 경우 타인이 로그인할 수 있습니다.     \n\nPC를 여러사람이 사용하는 공공장소에서는 체크하지 마세요.\n\n정말로 패스워드를 기억시키겠습니까?\n\n'))
		{
			ths.checked = false;
		}
	}
}

window.onload = function()
{
	document.getElementById('userid').focus();
}
//]]>
</script>