<?php
$SITES = getDbArray($table['s_site'],'','*','gid','asc',6,$p);
$SITEN = db_num_rows($SITES);
$PAGES1 = getDbArray($table['s_page'],'ismain=1','*','uid','asc',0,$p);
$PAGES2 = getDbArray($table['s_page'],'mobile=1','*','uid','asc',0,$p);

if ($type != 'makesite')
{
	$R = $_HS;
}
if ($R['uid'])
{
	$DOMAINS = getDbArray($table['s_domain'],'site='.$R['uid'],'*','gid','asc',0,$p);
	$DOMAINN = db_num_rows($DOMAINS);
}
?>


<div id="sitebox">

	<form name="" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="siteorder_update" />

	<table width="100%"><tr><td class="pannel">
		<ul id="siteorder">
		<?php while($S = db_fetch_array($SITES)):?>
		<li>
		<div id="iconbg<?php echo $S['uid']?>" class="site<?php if($S['uid']==$R['uid']):?> selected<?php endif?>" style="background:url('<?php echo $g['img_core']?>/siteicon/<?php echo $S['icon']?>') center center no-repeat;" title="<?php echo $S['name']?>">
			<input type="checkbox" name="sitemembers[]" value="<?php echo $S['uid']?>" checked="checked" />
			<div class="delbtn">
			<?php if($S['uid']==$R['uid']):?><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletesite&amp;account=<?php echo $R['uid']?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('사이트관련 모든 데이터가 삭제됩니다.\n정말로 선택된 사이트를 삭제하시겠습니까?');" title="사이트삭제"><img src="<?php echo $g['img_core']?>/_public/btn_del_s01.gif" alt="삭제" /></a><?php endif?>
			</div>
			<div class="icon"><a href="<?php echo $g['s']?>/?r=<?php echo $S['id']?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>"><img src="<?php echo $g['img_core']?>/blank.gif" alt="<?php echo $S['name']?>" /></a></div>
			<div class="name"><div class="namex" ondblclick="window.open('<?php echo $g['r']?>s=<?php echo $S['uid']?>');"><?php echo $S['name']?></div></div>
		</div>
		</li>

		<?php endwhile?>
		</ul>

		<?php if(!$SITEN):?>
		<div class="none">
		등록된 사이트가 없습니다. 
		</div>
		<div class="none1">
		사이트를 등록하려면 사이트 기본정보를 입력한 후 [신규사이트 등록]버튼을 클릭해 주세요.<br />
		필요한만큼 사이트를 추가할 수 있으며 각각의 사이트에 개별도메인을 지정할 수 있습니다.
		</div>
		<?php endif?>
		
		<div class="clear"></div>
	</td></tr></table>

	<div class="savebtn">
		<a href="<?php echo $g['adm_href']?>&amp;type=makesite" title="사이트추가"><img src="<?php echo $g['img_core']?>/_public/btn_add.gif" alt="추가" /></a>
		<input type="image" src="<?php echo $g['img_core']?>/_public/btn_save.gif" title="순서저장" alt="save" />
	</div>
	</form>


	<div class="infobox">
		<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $module?>" />
		<input type="hidden" name="a" value="regissite" />
		<input type="hidden" name="site_uid" value="<?php echo $R['uid']?>" />
		<input type="hidden" name="icon" value="<?php echo $R['icon']?$R['icon']:'1.png'?>" />
		<input type="hidden" name="backgo" value="admin" />
		<input type="hidden" name="iconaction" value="" />


		<table cellspacing="0" cellpadding="0">
			<tr>
				<td class="td1">사 이 트 명</td>
				<td class="td2">
					<input type="text" name="name" class="input sname" value="<?php echo $R['name']?>" />
				</td>
			</tr>
			<tr>
				<td class="td1">
					사이트제목
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_title','block','none');" />				
				</td>
				<td class="td2">
					<input type="text" name="title" class="input sname" value="<?php echo $R['title']?>" />
					<input type="checkbox" name="titlefix" value="1"<?php if($R['titlefix']):?> checked="checked"<?php endif?> />고정
				</td>
			</tr>
			<tr>
				<td class="td1">
					사이트언어
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_language','block','none');" />
				</td>
				<td class="td2">
					<select name="sitelang" class="select1">
					<?php $dirs = opendir($g['path_var'].'language/')?>
					<?php while(false !== ($tpl = readdir($dirs))):?>
					<?php if($tpl=='.'||$tpl=='..')continue?>
					<option value="<?php echo $tpl?>"<?php if($g['sys_selectlang']==$tpl):?> selected="selected"<?php endif?> title="<?php echo $tpl?>">ㆍ<?php echo getFolderName($g['path_var'].'language/'.$tpl)?></option>
					<?php endwhile?>
					<?php closedir($dirs)?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td1">
					사이트코드
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_sitecode','block','none');" />	
				</td>
				<td class="td2">
					<input type="text" name="id" class="input sname" value="<?php echo $R['id']?>" title="영문 대소문자/숫자/_ 조합으로 입력해 주세요." />
					<input type="checkbox" name="usescode" value="1"<?php if($R['usescode']):?> checked="checked"<?php endif?> />사용
				</td>
			</tr>
			<tr>
				<td class="td1">레 이 아 웃</td>
				<td class="td2">
					<select name="layout" class="select1">
					<option value="">&nbsp;+ 선택하세요</option>
					<?php $dirs = opendir($g['path_layout'])?>
					<?php while(false !== ($tpl = readdir($dirs))):?>
					<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
					<?php $dirs1 = opendir($g['path_layout'].$tpl)?>
					<option value="">--------------------------------</option>
					<?php while(false !== ($tpl1 = readdir($dirs1))):?>
					<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
					<option value="<?php echo $tpl?>/<?php echo $tpl1?>"<?php if($R['layout']==$tpl.'/'.$tpl1):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo str_replace('.php','',$tpl1)?>)</option>
					<?php endwhile?>
					<?php closedir($dirs1)?>
					<?php endwhile?>
					<?php closedir($dirs)?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td1 m">
					(모바일접속) 
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="himg hand" onclick="layerShowHide('guide_mobile','block','none');" />
				</td>
				<td class="td2">
					<select name="m_layout" class="select1">
					<option value="">&nbsp;+ PC접속과 동일</option>
					<?php $dirs = opendir($g['path_layout'])?>
					<?php while(false !== ($tpl = readdir($dirs))):?>
					<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
					<?php $dirs1 = opendir($g['path_layout'].$tpl)?>
					<option value="">--------------------------------</option>
					<?php while(false !== ($tpl1 = readdir($dirs1))):?>
					<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
					<option value="<?php echo $tpl?>/<?php echo $tpl1?>"<?php if($R['m_layout']==$tpl.'/'.$tpl1):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo str_replace('.php','',$tpl1)?>)</option>
					<?php endwhile?>
					<?php closedir($dirs1)?>
					<?php endwhile?>
					<?php closedir($dirs)?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td1">시작페이지</td>
				<td class="td2">
					<select name="startpage" class="select1">
					<option value="">&nbsp;+ 선택하세요</option>
					<option value="">--------------------------------</option>
					<?php while($S = db_fetch_array($PAGES1)):?>
					<option value="<?php echo $S['uid']?>"<?php if($R['startpage']==$S['uid']):?> selected="selected"<?php endif?>>ㆍ<?php echo $S['name']?>(<?php echo $S['id']?>)</option>
					<?php endwhile?>
					<?php if(!db_num_rows($PAGES1)):?>
					<option value="">ㆍ시작페이지 등록 후 지정</option>
					<?php endif?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td1 m">(모바일접속)</td>
				<td class="td2">
					<select name="m_startpage" class="select1">
					<option value="">&nbsp;+ PC접속과 동일</option>
					<option value="">--------------------------------</option>
					<?php while($S = db_fetch_array($PAGES2)):?>
					<option value="<?php echo $S['uid']?>"<?php if($R['m_startpage']==$S['uid']):?> selected="selected"<?php endif?>>ㆍ<?php echo $S['name']?>(<?php echo $S['id']?>)</option>
					<?php endwhile?>
					<?php if(!db_num_rows($PAGES2)):?>
					<option value="">ㆍ모바일페이지 등록 후 지정</option>
					<?php endif?>
					</select>				</td>
			</tr>

			<tr>
				<td class="td1">서비스상태</td>
				<td class="td2">
					<select name="open" class="select1">
					<option value="1"<?php if($R['open']=='1'):?> selected="selected"<?php endif?>>ㆍ정상서비스</option>
					<option value="2"<?php if($R['open']=='2'):?> selected="selected"<?php endif?>>ㆍ관리자오픈</option>
					<option value="3"<?php if($R['open']=='3'):?> selected="selected"<?php endif?>>ㆍ정지</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td1">D T D 형식</td>
				<td class="td2">
					<select name="dtd" class="select1">
					<option value="xhtml_1"<?php if($_HS['dtd']=='xhtml_1'):?> selected="selected"<?php endif?>>ㆍXHTML 1.0</option>
					<option value="html5"<?php if($_HS['dtd']=='html5'):?> selected="selected"<?php endif?>>ㆍHTML 5</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td1">이 름 표 시</td>
				<td class="td2">
					<select name="nametype" class="select1">
					<option value="nic"<?php if($R['nametype']=='nic'):?> selected="selected"<?php endif?>>ㆍ닉네임</option>
					<option value="name"<?php if($R['nametype']=='name'):?> selected="selected"<?php endif?>>ㆍ이름(실명)</option>
					<option value="id"<?php if($R['nametype']=='id'):?> selected="selected"<?php endif?>>ㆍ아이디</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td1">시 간 조 정</td>
				<td class="td2">
					<select name="timecal" class="select1">
					<?php for($i = -23; $i < 24; $i++):?>
					<option value="<?php echo $i?>"<?php if($i == $R['timecal']):?> selected="selected"<?php endif?>>ㆍ<?php if($i > 0):?>+<?php endif?><?php echo $i?$i.'시간':'조정안함'?></option>
					<?php endfor?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td1">
					퍼 포 먼 스
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_rewrite','block','none');" />	
				</td>
				<td class="td2">
					<div class="shift">
					<div class="shift">
					<input type="checkbox" name="rewrite" value="1"<?php if($R['rewrite']):?> checked="checked"<?php endif?> />짧은주소사용
					<input type="checkbox" name="buffer" value="1"<?php if($R['buffer']):?> checked="checked"<?php endif?> />버퍼전송사용
					</div>
					</div>
				</td>
			</tr>
			<tr>
				<td class="td1">연결도메인</td>
				<td class="td2" colspan="3">
					
					<?php if($R['uid']):?>
					<?php if($DOMAINN):?>
					<ul>
					<?php while($D=db_fetch_array($DOMAINS)):?>
					<li><a href="#." onclick="viewDomainMode('<?php echo $D['name']?>');"><?php echo $D['name']?></a></li>
					<?php endwhile?>
					</ul>
					<?php else:?>
					<span class="nodomain">연결된 도메인이 없습니다.</span><br />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=domain&amp;selsite=<?php echo $R['uid']?>&amp;type=makedomain" class="jtdomain">도메인연결하기</a>
					<?php endif?>
					<?php else:?>
					<span class="nodomain">사이트생성 후 연결할 수 있습니다.</span>
					<?php endif?>

				</td>
			</tr>
		</table>

		<br />

		<div id="guide_title" class="guide hide">
		<div class="b">사이트제목 :</div>
		사이트제목에 입력된 메세지는 브라우져의 타이틀에 출력됩니다.<br />
		[고정]에 체크하면 입력된 타이틀이 모든페이지에 고정되며 체크해제시 페이지별로 타이틀이 출력됩니다.<br />
		이 입력값은 일부 레이아웃의 사이트제목으로 사용됩니다.<br />
		</div>

		<div id="guide_language" class="guide hide">
		<div class="b">사이트언어 :</div>
		지정된 언어팩이 포함되어 있지 않은 모듈이 사용될 경우에는 <span class="b"><?php echo getFolderName($g['path_var'].'language/'.$g['sys_lang'])?></span>로 적용됩니다.<br />
		<?php if($R['lang']!=$g['sys_selectlang']):?>
		현재 선택된 언어는 <span class="b"><?php echo getFolderName($g['path_var'].'language/'.$g['sys_selectlang'])?></span>이나 언어팩이 존재하지 않아 <span class="b"><?php echo getFolderName($g['path_var'].'language/'.$g['sys_lang'])?></span>로 처리되었습니다.
		<?php else:?>
		현재 선택된 언어는 <span class="b"><?php echo getFolderName($g['path_var'].'language/'.$g['sys_selectlang'])?></span>입니다.
		<?php endif?>
		</div>

		<div id="guide_sitecode" class="guide hide">
		<div class="b">사이트코드 :</div>
		사이트별로 계정아이디를 등록합니다.(영문대/소문자+숫자+_ 조합으로 등록할 수 있습니다)<br />
		[사용]에 체크하면 사이트별로 계정값을 부여할 수 있으며 하나의 도메인으로 복수의 사이트에 접속할 수 있습니다.<br />
		사용하지 않을경우 현재의 도메인(<?php echo str_replace('/rb','',str_replace('http://','',$g['url_root']))?>)으로 사이트패널내의 첫번째 사이트만 접속할 수 있으며 나머지 사이트를 접속하려면 별도의 도메인을 연결해야 합니다.<br />
		사이트코드를 사용하면 사이트코드만큼 주소가 길어집니다.(kimsq.com/rb/ -> kimsq.com/rb/사이트코드/)<br />
		영문사이트 서비스 연결예제) kimsq.com/rb/kr/ , kimsq.com/rb/en/<br />
		</div>

		<div id="guide_mobile" class="guide hide">
		<div class="b">모바일접속 :</div>
		모바일기기로 접속시 출력할 사이트 레이아웃(UI)을 지정합니다.<br />
		지정된 모바일 레이아웃은 모든메뉴,모든페이지에 대해서 일괄적용됩니다.<br />
		모바일기기에 대해 정의하거나 모바일 전용사이트 등으로 이동시키려면 <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=mobile" target="_blank" class="u">모바일설정</a>을 이용하세요.<br />
		</div>

		<div id="guide_rewrite" class="guide hide">
		<div class="b">짧은주소사용 :</div>
		긴 주소줄을 간단하게 줄일 수 있습니다.(서버에서 rewrite_mod 를 허용해야합니다)<br />
		보기) ./?c=menu&uid=1000 -> /c/menu/1000<br />
		사이트코드를 사용하면 사이트코드를 포함한 주소를 줄여줍니다.<br />
		보기) ./?r=home&c=menu&uid=1000 -> /home/c/menu/1000<br />
		<div class="b">버퍼전송사용 :</div>
		실행결과를 브라우져에 출력해주는 과정에서 버퍼에 담아두었다가 실행이 완료되면 화면에 출력해 줍니다.<br />
		실행속도가 느릴경우 화면이 일부분만 출력되는 것을 한번에 열리도록 합니다.
		</div>

		<div id="headertail" class="headertail">
			<div class="tt">PHP코드 <span>- 이 사이트에 전용으로 사용될 PHP코드가 있을 경우 등록해 주세요.</span></div>
			<div><textarea name="sitephpcode" rows="8" cols="70"><?php if($R['uid']&&is_file($g['path_var'].'sitephp/'.$R['uid'].'.php')) echo htmlspecialchars(implode('',file($g['path_var'].'sitephp/'.$R['uid'].'.php')))?></textarea></div>

			<div class="tt">헤더코드 <span>- &lt;head&gt; 와 &lt;/head&gt; 사이에 삽입하고자 할 코드가 있을 경우 등록해 주세요.</span></div>
			<div><textarea name="headercode" rows="8" cols="70"><?php echo htmlspecialchars($R['headercode'])?></textarea></div>

			<div class="tt">테일코드 <span>- &lt;/body&gt;&lt;/html&gt; 바로앞에 삽입하고자 할 코드가 있을 경우 등록해 주세요.</span></div>
			<div><textarea name="footercode" rows="8" cols="70"><?php echo htmlspecialchars($R['footercode'])?></textarea></div>
		</div>

		<div class="submitbox">
			<!--input type="button" class="btngray" value="헤더/테일코드" onclick="layerShowHide('headertail','block','none');" /-->
			<input type="submit" class="btnblue" value="<?php echo $R['uid']?'사이트속성 변경':'신규사이트 등록'?>" />
			<div class="clear"></div>
		</div>

		</form>
	</div>
</div>
<?php include_once $g['path_module'].$module.'/lang.'.$_HS['lang'].'/action/a.inscheck.php'?>
<script type="text/javascript">
//<![CDATA[
function viewDomainMode(domain)
{
	var ux = location.href.split('?');
	var us = ux[0].split('/');
	var uh = 'http://'+domain+'/'+us[us.length-2].replace('index.php','')+'/';

	window.open(uh);
}
function saveCheck(f)
{
	if (f.name.value == '')
	{
		alert('사이트명을 입력해 주세요.      ');
		f.name.focus();
		return false;
	}
	if (f.title.value == '')
	{
		alert('사이트제목을 입력해 주세요.      ');
		f.title.focus();
		return false;
	}
	if (f.id.value == '')
	{
		alert('사이트코드를 입력해 주세요.      ');
		f.id.focus();
		return false;
	}
	if (!chkFnameValue(f.id.value))
	{
		alert('사이트코드는 영문대소문자/숫자/_/- 만 사용할 수 있습니다.      ');
		f.id.focus();
		return false;
	}
	if (f.layout.value == '')
	{
		alert('대표 레이아웃을 지정해 주세요.      ');
		f.layout.focus();
		return false;
	}
	if (f.startpage.value == '')
	{
		alert('시작페이지를 지정해 주세요.      ');
		f.startpage.focus();
		return false;
	}
	return confirm('정말로 실행하시겠습니까?         ');
}



<?php if($type == 'makesite' || $nosite == 'Y'):?>
document.procForm.name.focus();
<?php endif?>
//]]>
</script>
