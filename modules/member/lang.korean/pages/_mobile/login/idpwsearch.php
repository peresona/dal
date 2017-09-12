
<div id="pages_idpw">

	<h2><?php echo $d['member']['login_emailid']?'이메일':'아이디'?>/비밀번호 찾기</h2>

	<div class="msg">
		<?php if($d['member']['login_emailid']):?>
		이메일아이디는 회원가입시 등록한 이름(실명)과 아이디를 입력하시면 정보를 확인하실 수 있습니다.<br />
		비밀번호는 암호화되어 있으므로 이메일인증 후 새로운 비밀번호로 재등록하셔야 합니다.
		<?php else:?>
		아이디는 회원가입시 등록한 이름(실명)과 이메일을 입력하시면 정보를 확인하실 수 있습니다.<br />
		비밀번호는 암호화되어 있으므로 아이디인증 후 새로운 비밀번호로 재등록하셔야 합니다.
		<?php endif?>
	</div>

	<div class="tab">
		<ul>
		<li id="tagree1" class="selected" onclick="tabShow(1);"><?php echo $d['member']['login_emailid']?'이메일':'아이디'?> 찾기</li>
		<?php //<li id="tagree2" onclick="tabShow(2);">비밀번호 찾기</li> ?>
		<li id="tagree3" onclick="tabShow(3);">비밀번호 요청</li>
		</ul>
	</div>
	<div class="agreebox">
		<div id="bagree1">
		
			<form name="procForm1" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return idCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>" />
			<input type="hidden" name="m" value="<?php echo $m?>" />
			<input type="hidden" name="a" value="id_search" />

			<div class="tblbox">
			<table>
				<tr>
				<td class="key">이름(실명)</td>
				<td>
					<input type="text" name="name" value="" maxlength="10" class="input" />
				</td>
				</tr>
				<tr>
				<td class="key"><?php echo $d['member']['login_emailid']?'아이디':'이메일'?></td>
				<td>
					<input type="text" name="email" value="" class="input" />
				</td>
				</tr>
			</table>
			</div>

			<div class="submitbox">
				<input type="button" value="취소" class="btngray" onclick="goHref('<?php echo RW(0)?>');" />
				<input type="submit" value="<?php echo $d['member']['login_emailid']?'이메일':'아이디'?>찾기" class="btnblue" />
			</div>

			</form>

		</div>
		<div id="bagree2" class="hide">


			<form name="procForm2" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return pwCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>" />
			<input type="hidden" name="m" value="<?php echo $m?>" />
			<input type="hidden" name="a" value="pw_search" />
			<input type="hidden" name="id_auth" id="id_auth" value="1" />

			<div id="pwauth_step_1">
			<div class="tblbox">
			<table>
				<tr>
				<td class="key">인증단계</td>
				<td>
					<span class="b"><?php echo $d['member']['login_emailid']?'이메일':'아이디'?>인증</span> &gt; 비밀번호찾기 질문인증 &gt; 비밀번호 재등록
				</td>
				</tr>
				<tr>
				<td class="key"><?php echo $d['member']['login_emailid']?'이메일':'아이디'?></td>
				<td>
					<input type="text" name="new_id" id="pwsearchStep_1" value="" class="input" />
				</td>
				</tr>
			</table>
			</div>
			<div class="submitbox">
				<input type="button" value="취소" class="btngray" onclick="goHref('<?php echo RW(0)?>');" />
				<input type="submit" value="<?php echo $d['member']['login_emailid']?'이메일':'아이디'?> 인증요청" class="btnblue" />
			</div>
			</div>

			<div id="pwauth_step_2" class="hide">
			<div class="tblbox">
			<table>
				<tr>
				<td class="key">인증단계</td>
				<td>
					<?php echo $d['member']['login_emailid']?'이메일':'아이디'?>인증 &gt; <span class="b">비밀번호찾기 질문인증</span> &gt; 비밀번호 재등록
				</td>
				</tr>
				<tr>
				<td class="key">인증질문</td>
				<td id="pw_question" class="ques">
					이 곳은 PUSH에 의해 질문으로 자동 대체됩니다.
				</td>
				</tr>
				<tr>
				<td class="key">답변입력</td>
				<td>
					<input type="text" name="new_pw_a" id="pwsearchStep_2" value="" class="input" />
				</td>
				</tr>
			</table>
			</div>
			<div class="submitbox">
				<input type="button" value="취소" class="btngray" onclick="goHref('<?php echo RW(0)?>');" />
				<input type="submit" value="답변 인증요청" class="btnblue" />
			</div>
			</div>

			<div id="pwauth_step_3" class="hide">
			<div class="tblbox">
			<table>
				<tr>
				<td class="key">인증단계</td>
				<td>
					<?php echo $d['member']['login_emailid']?'이메일':'아이디'?>인증 &gt; 비밀번호찾기 질문인증 &gt; <span class="b">비밀번호 재등록</span>
				</td>
				</tr>
				<tr>
				<td class="key">비밀번호</td>
				<td>
					<input type="password" name="new_pw1" id="pwsearchStep_3" value="" maxlength="20" class="input" />
				</td>
				</tr>
				<tr>
				<td class="key">비번확인</td>
				<td>
					<input type="password" name="new_pw2" value="" maxlength="20" class="input" />
				</td>
				</tr>
			</table>
			</div>
			<div class="submitbox">
				<input type="button" value="취소" class="btngray" onclick="goHref('<?php echo RW(0)?>');" />
				<input type="submit" value="새 비밀번호 등록" class="btnblue" />
			</div>
			</div>
			</form>
		</div>


		<div id="bagree3" class="hide">
		
		<form name="procForm3" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return idCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $m?>" />
		<input type="hidden" name="a" value="id_auth" />

		<div class="tblbox">
		<table>
			<tr>
			<td class="key">이름(실명)</td>
			<td>
				<input type="text" name="name" value="" maxlength="10" class="input" />
			</td>
			</tr>
			<tr>
			<td class="key"><?php echo $d['member']['login_emailid']?'아이디':'이메일'?></td>
			<td>
				<input type="text" name="email" value="" class="input" />
			</td>
			</tr>
		</table>
		</div>

		<div class="submitbox">
			<input type="button" value="취소" class="btngray" onclick="goHref('<?php echo RW(0)?>');" />
			<input type="submit" value="비밀번호 요청" class="btnblue" />
		</div>

		</form>

		</div>


	</div>
</div>


<script type="text/javascript">
//<![CDATA[
function tabShow(n)
{
	var i;


	for (i = 1; i < 4; i++)
	{
		$('#tagree'+i).css('borderBottom','#dfdfdf solid 1px');
		$('#tagree'+i).css('background','#efefef');
		$('#tagree'+i).css('color','#666666');
		$('#bagree'+i).css('display','none');
	}

		$('#tagree'+n).css('borderBottom','#ffffff solid 1px');
		$('#tagree'+n).css('background','#ffffff');
		$('#tagree'+n).css('color','#000000');
		$('#bagree'+n).css('display','block');
	if (n == 1)
	{
		document.procForm1.name.focus();
	}
	else if (n == 2) {
		if (getId('id_auth').value == '1')
		{
			document.procForm2.new_id.focus();
		}
		if (getId('id_auth').value == '2')
		{
			document.procForm2.new_pw_a.focus();
		}
	}
	else {
		document.procForm3.name.focus();
	}
}
function idCheck(f)
{
	if (f.name.value == '')
	{
		alert('이름을 입력해 주세요.   ');
		f.name.focus();
		return false;
	}
	if (f.email.value == '')
	{
		alert('<?php echo $d['member']['login_emailid']?'아이디를':'이메일을'?> 입력해 주세요.   ');
		f.email.focus();
		return false;
	}
}
function pwCheck(f)
{
	if (f.new_id.value == '')
	{
		alert('<?php echo $d['member']['login_emailid']?'이메일을':'아이디를'?> 입력해 주세요.   ');
		f.new_id.focus();
		return false;
	}
	if (f.id_auth.value == '2')
	{
		if (f.new_pw_a.value == '')
		{
			alert('답변을 입력해 주세요.   ');
			f.new_pw_a.focus();
			return false;
		}
	}
	if (f.id_auth.value == '3')
	{
		if (f.new_pw1.value == '')
		{
			alert('새 패스워드를 입력해 주세요.');
			f.new_pw1.focus();
			return false;
		}
		if (f.new_pw2.value == '')
		{
			alert('새 패스워드를 한번더 입력해 주세요.');
			f.new_pw2.focus();
			return false;
		}
		if (f.new_pw1.value != f.new_pw2.value)
		{
			alert('새 패스워드가 일치하지 않습니다.');
			f.new_pw1.focus();
			return false;
		}

		alert('입력하신 패스워드로 재등록 되었습니다.');
	}
}

window.onload = function()
{
	<?php if($ftype == 'pw'):?>
	tabShow(2);
	<?php elseif($ftype == 'auth'):?>
	tabShow(3);
	<?php else:?>
	document.procForm1.name.focus();
	<?php endif?>
}
//]]>
</script>