<?php 
$g['use_social'] = is_file($g['path_module'].'social/var/var.php');
if ($g['use_social']) include $g['path_module'].'social/var/var.php';
?>

<div id="loginBox">
	<form name="showLogBoxForm" action="<?php echo $d['admin']['ssl_type']?$g['ssl_root']:$g['url_root']?>/" method="post"  onsubmit="return showLogCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="a" value="login" />
	<input type="hidden" name="referer" value="" />
	<input type="hidden" name="__target" value="_parent" />

	<fieldset>
		<label> 
		<div>이메일 또는 아이디</div>
		<input type="text" name="id" class="xi" id="_xi_1" autocomplete="on" value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',0)?>" />
		</label>
		<label> 
		<div>비밀번호</div>
		<input type="password" name="pw" class="xi" id="_xi_2" value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',1)?>" />
		</label>
		<div class="submit">
		<label>
		<input type="checkbox" name="idpwsave" value="checked"<?php if($_COOKIE['svshop']):?> checked="checked"<?php endif?> />
		<span>아이디/비밀번호 기억</span>
		</label>
		<label>
		<input type="checkbox" name="gohub" value="Y" />
		<span>My page로 이동</span> 
		</label>
		</div>
		<input type="submit" id="_login_btn_" class="btnblue" value="로그인" />
	</fieldset>
	</form>



	<div id="__sns__login__" class="snslog">
		<div class="tt">소셜 로그인</div>
		<div class="icon">
		<img src="<?php echo $g['img_core']?>/_public/sns_t2.gif" alt="" title="트위터" class="_uset_<?php echo $d['social']['use_t']?>" onclick="snsCheck('t','<?php echo $d['social']['use_t']?>');" />
		<img src="<?php echo $g['img_core']?>/_public/sns_f2.gif" alt="" title="페이스북" class="_usef_<?php echo $d['social']['use_f']?>" onclick="snsCheck('f','<?php echo $d['social']['use_f']?>');" />
		<img src="<?php echo $g['img_core']?>/_public/sns_m2.gif" alt="" title="미투데이" class="_usem_<?php echo $d['social']['use_m']?>" onclick="snsCheck('m','<?php echo $d['social']['use_m']?>');" />
		<img src="<?php echo $g['img_core']?>/_public/sns_y2.gif" alt="" title="요즘" class="_usey_<?php echo $d['social']['use_y']?>" onclick="snsCheck('y','<?php echo $d['social']['use_y']?>');" />
		</div>
		<div class="guide">
			소셜네트워크 서비스 facebook, twitter, me2day, yozm 에 로그인하시면 사이트를 더 편리하게 이용하실 수 있습니다.
		</div>
	</div>
</div>

<script type="text/javascript">
//<![CDATA[
function showLogCheck(f)
{
	if (f.id.value == '')
	{
		alert('아이디나 이메일을 입력해 주세요.');
		f.id.focus();
		return false;
	}
	if (f.pw.value == '')
	{
		alert('비밀번호를 입력해 주세요.');
		f.pw.focus();
		return false;
	}
	if (f.gohub.checked == true)
	{
		f.referer.value = "<?php echo $g['s']?>/?r=<?php echo $r?>&mod=mypage";
	}
	else {
		f.referer.value = '<?php echo urldecode($referer)?>';
	}
	return true;
}
function snsCheck(key,use)
{
	if (use == '')
	{
		alert('선택하신 SNS는 서비스 현재 서비스중이 아닙니다.  ');
		return false;
	}
	var w;
	var h;

	switch(key) 
	{
		case 't':
			w = 810;
			h = 550;
			break;
		case 'f':
			w = 1024;
			h = 680;
			break;
		case 'm':
			w = 900;
			h = 500;
			break;
		case 'y':
			w = 450;
			h = 450;
			break;
	}
	var url = rooturl+'/?r='+raccount+'&m=social&a=snscall_direct&type='+key;
	window.open(url,'','width='+w+'px,height='+h+'px,statusbar=no,scrollbars=yes,toolbar=no');
}

window.onload = function()
{
	var doHide = 0; // 소셜로그인 숨김 = 1 / 보이기 = 0

	parent.getId('_modal_on_').style.overflow = 'hidden';
	parent.getId('_modal_on_').style.width = '520px';
	parent.getId('_modal_on_').style.height = '250px';

	<?php if(!$g['use_social']):?>
	if (doHide)
	{
		parent.getId('_modal_on_').style.width = '325px';
		parent.getId('_modal_on_').style.height = '270px';
		getId('loginBox').style.padding = '20px 0 0 30px';
		getId('_xi_1').style.width = '220px';
		getId('_xi_2').style.width = '220px';
		getId('_login_btn_').style.left = '182px';
		getId('__sns__login__').style.display = 'none';
	}
	<?php endif?>
}
//]]>
</script>
