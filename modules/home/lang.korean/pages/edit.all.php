<?php
$typeset = array
(
	'site'=>'사이트 등록정보',
	'menu'=>'메뉴관리',
	'page'=>'페이지관리',
	'pageadd'=>($uid?'페이지 수정':'새 페이지 추가'),
);
$type = $type ? $type : 'page';
$g['url_reset'] = $g['s'].'/?r='.$r.'&amp;iframe='.$iframe.'&amp;system='.$system.'&amp;type='.$type;
?>
<div class="iframe<?php echo $iframe?>">
<div id="pages_top">

	<div class="title">
		<div class="xl"><h2><?php echo $makemenu?'새 메뉴 추가':$typeset[$type]?></h2></div>
		<div class="xr">
		
			<ul>
			<li class="leftside<?php if($type=='site'):?> selected<?php endif?>"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;iframe=<?php echo $iframe?>&amp;system=edit.all&amp;type=site">사이트</a></li>
			<li<?php if($type=='menu'&&!$makemenu):?> class="selected"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;iframe=<?php echo $iframe?>&amp;system=edit.all&amp;type=menu">메뉴</a></li>
			<li<?php if($type=='page'||($type=='pageadd'&&$uid)):?> class="selected"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;iframe=<?php echo $iframe?>&amp;system=edit.all&amp;type=page">페이지</a></li>
			<li<?php if($type=='menu'&&$makemenu):?> class="selected"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;iframe=<?php echo $iframe?>&amp;system=edit.all&amp;type=menu&makemenu=Y">새 메뉴</a></li>
			<li<?php if($type=='pageadd'&&!$uid):?> class="selected"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;iframe=<?php echo $iframe?>&amp;system=edit.all&amp;type=pageadd">새 페이지</a></li>
			</ul>

		</div>
		<div class="clear"></div>
	</div>
	
</div>

<?php if($type == 'site'):?>

<div id="sitebox">

	<div class="infobox">
		<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $g['sys_module']?>" />
		<input type="hidden" name="a" value="regissite" />
		<input type="hidden" name="site_uid" value="<?php echo $_HS['uid']?>" />
		<input type="hidden" name="icon" value="<?php echo $_HS['icon']?>" />
		<input type="hidden" name="iframe" value="<?php echo $iframe?>" />


		<table cellspacing="0" cellpadding="0">
			<tr>
				<td class="td1">사 이 트 명</td>
				<td class="td2">
					<input type="text" name="name" class="input sname" value="<?php echo $_HS['name']?>" />
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=<?php echo $g['sys_module']?>&amp;front=main&amp;type=makesite" target="_blank"><img src="<?php echo $g['img_core']?>/_public/btn_add.gif" alt="사이트추가" title="사이트추가" /></a>
				</td>
				<td class="td1">
					사이트제목
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_title','block','none');" />				
				</td>
				<td class="td2">
					<input type="text" name="title" class="input sname" value="<?php echo $_HS['title']?>" />
					<input type="checkbox" name="titlefix" value="1"<?php if($_HS['titlefix']):?> checked="checked"<?php endif?> />고정
				</td>
			</tr>
			<tr>
				<td class="td1">
					사이트언어
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_language','block','none');" />
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
				<td class="td1">
					사이트코드
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_sitecode','block','none');" />	
				</td>
				<td class="td2">
					<input type="text" name="id" class="input sname" value="<?php echo $_HS['id']?>" title="영문 대소문자/숫자/_ 조합으로 입력해 주세요." />
					<input type="checkbox" name="usescode" value="1"<?php if($_HS['usescode']):?> checked="checked"<?php endif?> />사용
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
					<option value="<?php echo $tpl?>/<?php echo $tpl1?>"<?php if($_HS['layout']==$tpl.'/'.$tpl1):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo str_replace('.php','',$tpl1)?>)</option>
					<?php endwhile?>
					<?php closedir($dirs1)?>
					<?php endwhile?>
					<?php closedir($dirs)?>
					</select>
				</td>
				<td class="td1">시작페이지</td>
				<td class="td2">
					<select name="startpage" class="select1">
					<option value="">&nbsp;+ 선택하세요</option>
					<option value="">--------------------------------</option>
					<?php $PAGES1 = getDbArray($table['s_page'],'ismain=1','*','uid','asc',0,1)?>
					<?php while($S = db_fetch_array($PAGES1)):?>
					<option value="<?php echo $S['uid']?>"<?php if($_HS['startpage']==$S['uid']):?> selected="selected"<?php endif?>>ㆍ<?php echo $S['name']?>(<?php echo $S['id']?>)</option>
					<?php endwhile?>
					<?php if(!db_num_rows($PAGES1)):?>
					<option value="">ㆍ시작페이지 등록 후 지정</option>
					<?php endif?>
					</select>
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;system=<?php echo $system?>&amp;type=pageadd"><img src="<?php echo $g['img_core']?>/_public/btn_add.gif" alt="페이지추가" title="페이지추가" /></a>
				</td>
			</tr>

			<tr>
				<td class="td1 m">
					(모바일접속)
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="himg hand" onclick="__layerShowHide('guide_mobile','block','none');" />				
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
					<option value="<?php echo $tpl?>/<?php echo $tpl1?>"<?php if($_HS['m_layout']==$tpl.'/'.$tpl1):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo str_replace('.php','',$tpl1)?>)</option>
					<?php endwhile?>
					<?php closedir($dirs1)?>
					<?php endwhile?>
					<?php closedir($dirs)?>
					</select>
				</td>
				<td class="td1 m">
					(모바일접속)
				</td>
				<td class="td2">
					<select name="m_startpage" class="select1">
					<option value="">&nbsp;+ PC접속과 동일</option>
					<option value="">--------------------------------</option>
					<?php $PAGES2 = getDbArray($table['s_page'],'mobile=1','*','uid','asc',0,1)?>
					<?php while($S = db_fetch_array($PAGES2)):?>
					<option value="<?php echo $S['uid']?>"<?php if($_HS['m_startpage']==$S['uid']):?> selected="selected"<?php endif?>>ㆍ<?php echo $S['name']?>(<?php echo $S['id']?>)</option>
					<?php endwhile?>
					<?php if(!db_num_rows($PAGES2)):?>
					<option value="">ㆍ모바일페이지 등록 후 지정</option>
					<?php endif?>
					</select>
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;system=<?php echo $system?>&amp;type=pageadd"><img src="<?php echo $g['img_core']?>/_public/btn_add.gif" alt="페이지추가" title="페이지추가" /></a>
				</td>
			</tr>

			<tr>
				<td class="td1">서비스상태</td>
				<td class="td2">
					<select name="open" class="select1">
					<option value="1"<?php if($_HS['open']=='1'):?> selected="selected"<?php endif?>>ㆍ정상서비스</option>
					<option value="2"<?php if($_HS['open']=='2'):?> selected="selected"<?php endif?>>ㆍ관리자오픈</option>
					<option value="3"<?php if($_HS['open']=='3'):?> selected="selected"<?php endif?>>ㆍ정지</option>
					</select>
				</td>

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
					<option value="nic"<?php if($_HS['nametype']=='nic'):?> selected="selected"<?php endif?>>ㆍ닉네임</option>
					<option value="name"<?php if($_HS['nametype']=='name'):?> selected="selected"<?php endif?>>ㆍ이름(실명)</option>
					<option value="id"<?php if($_HS['nametype']=='id'):?> selected="selected"<?php endif?>>ㆍ아이디</option>
					</select>
				</td>

				<td class="td1">시 간 조 정</td>
				<td class="td2">
					<select name="timecal" class="select1">
					<?php for($i = -23; $i < 24; $i++):?>
					<option value="<?php echo $i?>"<?php if($i == $_HS['timecal']):?> selected="selected"<?php endif?>>ㆍ<?php if($i > 0):?>+<?php endif?><?php echo $i?$i.'시간':'조정안함'?></option>
					<?php endfor?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td1">
					퍼 포 먼 스
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_rewrite','block','none');" />	
				</td>
				<td class="td2">
					<div class="shift">
					<div class="shift">
					<input type="checkbox" name="rewrite" value="1"<?php if($_HS['rewrite']):?> checked="checked"<?php endif?> />짧은주소사용
					<input type="checkbox" name="buffer" value="1"<?php if($_HS['buffer']):?> checked="checked"<?php endif?> />버퍼전송사용
					</div>
					</div>
				</td>
				<td class="td1">연결도메인</td>
				<td class="td2">
					<?php $DOMAINS = getDbArray($table['s_domain'],'site='.$s,'*','gid','asc',0,1)?>
					<?php $DOMAINN = db_num_rows($DOMAINS)?>
					<?php if($DOMAINN):?>
					<ul>
					<?php while($D=db_fetch_array($DOMAINS)):?>
					<li><a href="#." onclick="viewDomainMode('<?php echo $D['name']?>');"><?php echo $D['name']?></a></li>
					<?php endwhile?>
					</ul>
					<?php else:?>
					<span class="nodomain">연결된 도메인이 없습니다.</span>
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=domain&amp;selsite=<?php echo $_HS['uid']?>&amp;type=makedomain" class="jtdomain" target="_blank">도메인연결하기</a>
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
		<?php if($_HS['lang']!=$g['sys_selectlang']):?>
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
		모바일기기에 대해 정의하거나 모바일 전용사이트 등으로 이동시키려면 <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=mobile" target="_blank" class="u">모바일설정</a>을 이용하세요.<br />
		</div>

		<div id="guide_rewrite" class="guide hide">
		<div class="b">짤은주소사용 :</div>
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
			<div><textarea name="sitephpcode" rows="8" cols="70"><?php if(is_file($g['path_var'].'sitephp/'.$_HS['uid'].'.php')) echo htmlspecialchars(implode('',file($g['path_var'].'sitephp/'.$_HS['uid'].'.php')))?></textarea></div>

			<div class="tt">헤더코드 <span>- &lt;head&gt; 와 &lt;/head&gt; 사이에 삽입하고자 할 코드가 있을 경우 등록해 주세요.</span></div>
			<div><textarea name="headercode" rows="8" cols="70"><?php echo htmlspecialchars($_HS['headercode'])?></textarea></div>

			<div class="tt">테일코드 <span>- &lt;/body&gt;&lt;/html&gt; 바로앞에 삽입하고자 할 코드가 있을 경우 등록해 주세요.</span></div>
			<div><textarea name="footercode" rows="8" cols="70"><?php echo htmlspecialchars($_HS['footercode'])?></textarea></div>
		</div>

		<div class="submitbox">
			<input type="button" class="btngray" value="헤더/테일코드" onclick="__layerShowHide('headertail','block','none');" />
			<input type="submit" class="btnblue" value="사이트속성 변경" />
		</div>

		</form>
	</div>


</div>

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
//]]>
</script>


<?php endif?>

<?php if($type == 'page'):?>
<?php
$typeset1= array('','모듈콘텐츠','위젯콘텐츠','직접꾸미기');
$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;

$sqlque = 'uid';
if ($pagetype) $sqlque .= " and pagetype='".$pagetype."'";
if ($ismain) $sqlque .= ' and ismain='.($ismain-1);
if ($category) $sqlque .= " and category='".$category."'";
if ($where && $keyword)
{
	$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray($table['s_page'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_page'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);
?>



<div id="pages_all">
	<form action="<?php echo $g['s']?>/">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="system" value="<?php echo $system?>" />
	<input type="hidden" name="type" value="<?php echo $type?>" />
	<input type="hidden" name="orderby" value="<?php echo $orderby?>" />
	<input type="hidden" name="recnum" value="<?php echo $recnum?>" />
	<input type="hidden" name="iframe" value="<?php echo $iframe?>" />

	<div class="info">

		<div class="article">
			<?php echo number_format($NUM)?>개(<?php echo $p?>/<?php echo $TPG?>페이지)
		</div>
		<div class="category">

			<select name="ismain" onchange="this.form.submit();">
			<option value="">&nbsp;+ 형식(전체)</option>
			<option value="">-------------</option>
			<option value="1"<?php if($ismain==1):?> selected="selected"<?php endif?>>ㆍ일반페이지</option>
			<option value="2"<?php if($ismain==2):?> selected="selected"<?php endif?>>ㆍ시작페이지</option>
			<option value="3"<?php if($ismain==3):?> selected="selected"<?php endif?>>ㆍ모바일페이지</option>
			</select>

			<select name="pagetype" onchange="this.form.submit();">
			<option value="">&nbsp;+ 전시(전체)</option>
			<option value="">-------------</option>
			<option value="3"<?php if($pagetype==3):?> selected="selected"<?php endif?>>ㆍ직접꾸미기</option>
			<option value="2"<?php if($pagetype==2):?> selected="selected"<?php endif?>>ㆍ위젯콘텐츠</option>
			<option value="1"<?php if($pagetype==1):?> selected="selected"<?php endif?>>ㆍ모듈콘텐츠</option>
			</select>

			<select name="category" onchange="this.form.submit();">
			<option value="">&nbsp;+ 분류(전체)</option>
			<option value="">-------------</option>
			<?php $_CATS = getDbSelect($table['s_page'],"category<>'' group by category",'category')?>
			<?php while($_R=db_fetch_array($_CATS)):?>
			<option value="<?php echo $_R['category']?>"<?php if($_R['category']==$category):?> selected="selected"<?php endif?>>ㆍ<?php echo $_R['category']?></option>
			<?php endwhile?>
			</select>

		</div>
		<div class="clear"></div>
	</div>

	<table summary="페이지 리스트입니다.">
	<caption>페이지</caption> 
	<colgroup> 
	<col width="50"> 
	<col width="70"> 
	<col> 
	<col width="70"> 
	<col width="70"> 
	<col width="120"> 
	<col width="90"> 
	<col width="90"> 
	<col width="30"> 
	</colgroup> 
	<thead>
	<tr>
	<th scope="col">번호</th>
	<th scope="col">분류</th>
	<th scope="col">페이지명</th>
	<th scope="col">코드</th>
	<th scope="col">전시형태</th>
	<th scope="col">레이아웃</th>
	<th scope="col">등록일시</th>
	<th scope="col">최종수정</th>
	<th scope="col" class="side2"></th>
	</tr>
	</thead>
	<tbody>

	<?php while($R=db_fetch_array($RCD)):?>
	<tr>
	<td><?php echo 1+((($p-1)*$recnum)+$_rec++)?></td>
	<td class="cat"><?php echo $R['category']?></td>
	<td class="sbj"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;iframe=<?php echo $iframe?>&amp;system=<?php echo $system?>&amp;type=pageadd&amp;uid=<?php echo $R['uid']?>" title="등록정보"><?php echo $R['name']?></a></td>
	<td><a href="<?php echo RW('mod='.$R['id'])?>" title="새창으로보기" target="_blank"><?php echo $R['id']?></a></td>
	<td><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;iframe=<?php echo $iframe?>&amp;system=edit.page&amp;_page=<?php echo $R['uid']?>" title="편집모드"><?php echo $typeset1[$R['pagetype']]?></a></td>
	<td title="<?php echo str_replace('.php','',$R['layout'])?>"><?php echo !$R['layout']?'대표레이아웃':str_replace('.php','',$R['layout'])?></td>
	<td><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
	<td><?php echo $R['d_update'] ? getDateFormat($R['d_update'],'Y.m.d H:i') : '-'?></td>
	<td><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $g['sys_module']?>&amp;a=deletepage&amp;uid=<?php echo $R['uid']?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?     ')"><img src="<?php echo $g['img_core']?>/_public/btn_del_s01.gif" alt="삭제" title="삭제" /></a></td>
	</tr> 
	<?php endwhile?> 

	<?php if(!$NUM):?>
	<tr>
	<td colspan="9" class="sbj1">등록된 페이지가 없습니다</td>
	</tr> 
	<?php endif?>

	</tbody>
	</table>
	

	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'<?php echo $g['img_core']?>/page/default');</script>
	</div>

	<div class="searchform">
		<select name="where">
		<option value="name"<?php if($where=='name'):?> selected="selected"<?php endif?>>페이지명</option>
		<option value="id"<?php if($where=='id'):?> selected="selected"<?php endif?>>페이지코드</option>
		</select>
		
		<input type="text" name="keyword" size="30" value="<?php echo $_keyword?>" class="input" />
		<input type="submit" value=" 검색 " class="btngray" />
	</div>
	
	</form>
</div>

<?php endif?>

<?php if($type == 'pageadd'):?>
<?php if ($uid) $R = getUidData($table['s_page'],$uid)?>
<?php $_cats=array()?>
<?php $CATS=db_query("select *,count(*) as cnt from ".$table['s_page']." group by category",$DB_CONNECT)?>
<?php while($C=db_fetch_array($CATS)):$_cats[]=$C['category']?>
<?php endwhile?>

<div id="pageinfo">


	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $g['sys_module']?>" />
	<input type="hidden" name="a" value="regispage" />
	<input type="hidden" name="backc" value="add" />
	<input type="hidden" name="uid" value="<?php echo $R['uid']?>" />
	<input type="hidden" name="orign_id" value="<?php echo $R['id']?>" />
	<input type="hidden" name="perm_g" value="<?php echo $R['perm_g']?>" />
	<input type="hidden" name="iframe" value="<?php echo $iframe?>" />

	<div class="title">
		<div class="xleft">페이지 등록정보</div>
		<div class="xright"></div>
	</div>

	<div class="notice">
		관리가 편하도록 페이지분류를 적절히 지정하여 등록해 주세요.<br />
		전시할내용을 모듈콘텐츠로 지정하면 권한은 접근권한은 해당모듈의 설정을 따릅니다.
	</div>

	<table>
		<tr>
			<td class="td1">
				페이지명칭
				<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_startpage','block','none');" />
			</td>
			<td class="td2">
				<input type="text" name="name" value="<?php echo $R['name']?>" class="input sname" />
				<div id="guide_startpage" class="guide hide">
				페이지의 명칭을 입력합니다.<br />
				보기)메인화면,로그인,회원가입,My page,통합검색,이용약관,고객센터<br />
				시작페이지에 체크할 경우 사이트속성에서 시작페이지로 지정할 수 있습니다.<br />
				모바일용에 체크할 경우 모바일페이지로 사용할 수 있습니다.<br />
				메인화면으로 사용할 페이지일 경우 시작페이지에 체크해 주세요.<br />
				</div>
			</td>
		</tr>

		<tr>
			<td class="td1">
			</td>
			<td class="td2 shift">
				<input type="checkbox" name="ismain" value="1"<?php if($R['ismain']):?> checked="checked"<?php endif?> />시작페이지
				<input type="checkbox" name="mobile" value="1"<?php if($R['mobile']):?> checked="checked"<?php endif?> />모바일용페이지
			</td>
		</tr>

		<tr>
			<td class="td1">
				페이지코드
				<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_pagecode','block','none');" />
			</td>
			<td class="td2">
				<input type="text" name="id" value="<?php echo $R['id']?$R['id']:$_mod?>" class="input sname" />
				<?php if($R['id']):?>
				<span class="btn01"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $g['sys_module']?>&amp;a=deletepage&amp;uid=<?php echo $R['uid']?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?     ')">페이지삭제</a></span>
				<?php endif?>

				<div id="guide_pagecode" class="guide hide">
				페이지 호출시에 사용되는 코드이며 영문대소문자/숫자/_/- 조합으로 등록할 수 있습니다.<br />
				보기) 페이지호출주소 : <?php echo RW('mod=<span class="b">페이지코드</span>')?><br />
				보기) My page호출 : <?php echo RW('mod=<span class="b">mypage</span>')?><br />
				</div>
			</td>
		</tr>
		<tr>
			<td class="td1">
				페이지분류
				<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_pagecat','block','none');" />
			</td>
			<td class="td2">
				<input type="text" name="category" value="<?php echo $R['category']?>" class="input sname" />
				<select name="site" class="select2" onchange="catSelect(this);">
				<option value="">&nbsp;+ 선택하세요</option>
				<option value="">--------------------------------</option>
				<?php foreach($_cats as $_val):?>
				<option value="<?php echo $_val?>">ㆍ<?php echo $_val?></option>
				<?php endforeach?>
				<?php if(count($_cats)):?>
				<option value="">--------------------------------</option>
				<?php endif?>
				<option value="">ㆍ직접입력</option>
				</select>

				<div id="guide_pagecat" class="guide hide">
				페이지 분류는 직접 입력하거나 이미 등록된 분류를 선택할 수 있습니다.<br />
				분류를 직접입력하면 분류선택기에 자동으로 추가됩니다.
				</div>

			</td>
		</tr>
		<tr>
			<td class="td1">
				전시할내용
				<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_contenttype','block','none');" />
			</td>
			<td class="td2">
				<select name="pagetype" class="select1" onchange="displaySelect(this);">
				<option value="3"<?php if($R['pagetype']==3):?> selected="selected"<?php endif?>>ㆍ직접꾸미기</option>
				<option value="2"<?php if($R['pagetype']==2):?> selected="selected"<?php endif?>>ㆍ위젯콘텐츠</option>
				<option value="1"<?php if($R['pagetype']==1):?> selected="selected"<?php endif?>>ㆍ모듈콘텐츠</option>
				</select>

				<div id="jointBox" class="guide<?php if($R['pagetype']!=1):?> hide<?php endif?>">
					<input type="text" name="joint" id="jointf" value="<?php echo $R['joint']?>" class="input sname" />
					<input type="button" class="btngray" value="모듈연결" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.joint&iframe=Y&dropfield=jointf&cmodule=[<?php echo $g['sys_module']?>]');" />
					<?php if($R['joint']):?>
					<input type="button" class="btngray" value="미리보기" onclick="window.open('<?php echo $R['joint']?>');" />
					<?php endif?>
					<div class="guide">
					이 페이지에 연결시킬 모듈이 있을 경우 모듈연결을 클릭한 후 선택해 주세요.<br />
					모듈 연결주소가 지정되면 이 페이지를 호출시 해당 연결주소의 모듈이 출력됩니다.<br />
					접근권한은 연결된 모듈의 권한설정을 따릅니다.
					</div>
				</div>
				<div id="widgetBox" class="guide<?php if($R['pagetype']!=2):?> hide<?php endif?>">
					<?php if($R['uid']):?>
					<input type="button" class="btngray w" value="위젯으로 꾸미기" onclick="goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=<?php echo $iframe?>&system=edit.page&_page=<?php echo $R['uid']?>&type=widget');" />
					<?php else:?>
					페이지 등록 후 사용자페이지에서 직접 편집할 수 있습니다.<br />
					<?php endif?>
				</div>
				<div id="codeBox" class="guide<?php if($R['pagetype']&&$R['pagetype']!=3):?> hide<?php endif?>">
					<?php if($R['uid']):?>
					<input type="button" class="btngray w" value="소스코드 직접편집" onclick="goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=<?php echo $iframe?>&system=edit.page&_page=<?php echo $R['uid']?>&type=source');" />
					<?php else:?>
					페이지 등록 후 사용자페이지에서 직접 편집할 수 있습니다.<br />
					<?php endif?>
				</div>

				<div id="guide_contenttype" class="guide hide">
				<span class="b">직접꾸미기 : </span>소스코드를 직접 편집할 수 있습니다.<br />
				<span class="b">위젯콘텐츠 : </span>위젯을 이용하여 메뉴를 꾸밀 수 있습니다.<br />
				<span class="b">모듈콘텐츠 : </span>모듈 콘텐츠를 출력할 수 있습니다.<br />
				</div>
			</td>
		</tr>

		<tr>
			<td class="td1">레 이 아 웃</td>
			<td class="td2">
				<select name="layout" class="select1">
				<option value="">&nbsp;+ 사이트 대표레이아웃</option>
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
			<td class="td1">
				소 속 메 뉴
				<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_sosokmenu','block','none');" />				
			</td>
			<td class="td2">
				<select name="sosokmenu" class="select1">
				<option value="">&nbsp;+ 사용안함</option>
				<option value="">--------------------------------</option>
				<?php include_once $g['path_core'].'function/menu1.func.php'?>
				<?php $cat=$R['sosokmenu']?>
				<?php getMenuShowSelect($s,$table['s_menu'],0,0,0,0,0,'')?>
				</select>
				<div id="guide_sosokmenu" class="guide hide">
				이 페이지의 소속메뉴가 종종 필요할 수 있습니다.<br />
				특정메뉴의 서브페이지로 사용되기를 원할경우 지정해 주세요.<br />
				</div>
			</td>
		</tr>
		<tr>
			<td class="td1">허 용 등 급</td>
			<td class="td2">
				<select name="perm_l" class="select1">
				<option value="">&nbsp;+ 전체허용</option>
				<option value="">--------------------------------</option>
				<?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
				<?php while($_L=db_fetch_array($_LEVEL)):?>
				<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$R['perm_l']):?> selected="selected"<?php endif?>>ㆍ<?php echo $_L['name']?>(<?php echo number_format($_L['num'])?>) 이상</option>
				<?php if($_L['gid'])break; endwhile?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="td1">
				차 단 그 룹
				<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_permg','block','none');" />
			</td>
			<td class="td2">
				<select name="_perm_g" class="select1" multiple="multiple" size="5">
				<option value=""<?php if(!$R['perm_g']):?> selected="selected"<?php endif?>>ㆍ차단안함</option>
				<?php $_SOSOK=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
				<?php while($_S=db_fetch_array($_SOSOK)):?>
				<option value="<?php echo $_S['uid']?>"<?php if(strstr($R['perm_g'],'['.$_S['uid'].']')):?> selected="selected"<?php endif?>>ㆍ<?php echo $_S['name']?>(<?php echo number_format($_S['num'])?>)</option>
				<?php endwhile?>
				</select>
				<div id="guide_permg" class="guide hide">
				선택된 그룹에 속한 회원들은 이 메뉴에 대한 접근이 차단됩니다.<br />
				복수의 그룹을 선택하려면 드래그또는 Ctrl키를 누른다음 클릭해 주세요.
				</div>
			</td>
		</tr>
		<tr>
			<td class="td1">
				캐 시 적 용
				<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_cache','block','none');" />
			</td>
			<td class="td2">
				<?php $cachefile = $g['path_page'].$R['id'].'.txt'?>
				<?php $cachetime = file_exists($cachefile) ? implode('',file($cachefile)) : 0?>
				<select name="cachetime" class="select1">
				<option value="">&nbsp;+ 적용안함</option>
				<option value="">--------------------------------</option>
				<?php for($i = 1; $i < 61; $i++):?>
				<option value="<?php echo $i?>"<?php if($cachetime==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>분</option>
				<?php endfor?>
				</select>

				<div id="guide_cache" class="guide hide">
				DB접속이 많거나 위젯을 많이 사용하는 페이지일 경우 캐시를 적용하면<br />
				서버부하를 줄 일 수 있으며 속도를 높일 수 있습니다.<br />
				다만 반드시 실시간 처리를 요하는 페이지일 경우 적용하지 마세요.
				</div>
			</td>
		</tr>
		<?php if($R['uid']):?>
		<tr>
			<td class="td1">
				페이지주소
				<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_addr','block','none');" />
			</td>
			<td class="td2">
				<div class="addr1">
				물리주소 : <span class="hand" onclick="window.open(this.innerHTML);" title="접속하기"><?php echo $g['s']?>/index.php?r=<?php echo $r?>&amp;mod=<?php echo $R['id']?></span><br />
				현재주소 : <span class="link hand" onclick="window.open(this.innerHTML);" title="접속하기"><?php echo RW('mod='.$R['id'])?></span>
				</div>
				<div id="guide_addr" class="guide hide">
				<span class="b">물리주소 :</span> 이 페이지의 물리적인 실제 주소입니다.<br />
				<span class="b">현재주소 :</span> 주소줄이기/사이트코드 사용옵션 결과주소입니다.
				</div>
			</td>
		</tr>
		<?php endif?>
	</table>
	
	<div class="submitbox">
		<?php if($R['uid']):?>
		<input type="button" class="btngray" value="편집모드" onclick="goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=<?php echo $iframe?>&system=edit.page&_page=<?php echo $R['uid']?>');" />
		<?php endif?>
		<input type="submit" class="btnblue" value="<?php echo $R['uid']?'페이지속성 변경':'새페이지 등록'?>" />
		<div class="clear"></div>
	</div>

	</form>
	

</div>




<script type="text/javascript">
//<![CDATA[
function displaySelect(obj)
{
	var f = document.procForm;
	if (obj.value == '1')
	{
		getId('jointBox').style.display = 'block';
		getId('widgetBox').style.display = 'none';
		getId('codeBox').style.display = 'none';
		f.joint.focus();
	}
	else if (obj.value == '2')
	{
		getId('jointBox').style.display = 'none';
		getId('widgetBox').style.display = 'block';
		getId('codeBox').style.display = 'none';
	}
	else if (obj.value == '3')
	{
		getId('jointBox').style.display = 'none';
		getId('widgetBox').style.display = 'none';
		getId('codeBox').style.display = 'block';
	}
	else
	{
		getId('jointBox').style.display = 'none';
		getId('widgetBox').style.display = 'none';
		getId('codeBox').style.display = 'none';
	}
	__resetPageSize();
}
function catSelect(obj)
{
	if(obj.value)
	{
		obj.form.category.value = obj.value;
		obj.value='';
		obj.form.pagetype.focus();
	}
	else {
		obj.form.category.value = '';
		obj.value = '';
		obj.form.category.focus();
	}
}
function saveCheck(f)
{
    var l1 = f._perm_g;
    var n1 = l1.length;
    var i;
	var s1 = '';

	for	(i = 0; i < n1; i++)
	{
		if (l1[i].selected == true && l1[i].value != '')
		{
			s1 += '['+l1[i].value+']';
		}
	}

	f.perm_g.value = s1;

	if (f.name.value == '')
	{
		alert('페이지명 입력해 주세요.      ');
		f.name.focus();
		return false;
	}
	if (f.id.value == '')
	{
		alert('페이지코드를 입력해 주세요.      ');
		f.id.focus();
		return false;
	}

	if (!chkFnameValue(f.id.value))
	{
		alert('페이지코드는 영문대소문자/숫자/_/- 만 사용할 수 있습니다.      ');
		f.id.focus();
		return false;
	}
	if (f.category.value == '')
	{
		alert('페이지분류를 입력해 주세요.      ');
		f.category.focus();
		return false;
	}
	if (f.pagetype.value == '1')
	{
		if (f.joint.value == '')
		{
			alert('모듈을 연결해 주세요.      ');
			f.joint.focus();
			return false;
		}
	}
	return confirm('정말로 실행하시겠습니까?         ');
}
document.procForm.name.focus();
//]]>
</script>


<?php endif?>

<?php if($type == 'menu'):?>

<?php
include_once $g['path_core'].'function/menu.func.php';
$ISCAT = getDbRows($table['s_menu'],'site='.$s);
$catcode = '';
if($cat)
{
	$CINFO = getUidData($table['s_menu'],$cat);
	$ctarr = getMenuCodeToPath($table['s_menu'],$cat,0);
	$ctnum = count($ctarr);
	for ($i = 0; $i < $ctnum; $i++) $CXA[] = $ctarr[$i]['uid'];
}

$is_fcategory =  $CINFO['uid'] && $vtype != 'sub';
$is_regismode = !$CINFO['uid'] || $vtype == 'sub';
if ($is_regismode)
{
	$CINFO['menutype'] = '';
	$CINFO['name'] = '';
	$CINFO['joint'] = '';
	$CINFO['redirect'] = '';
	$CINFO['hidden'] = '';
	$CINFO['target'] = '';
	$CINFO['imghead']  = '';
	$CINFO['imgfoot']  = '';
}
?>


<div id="catebody">

	<div id="category">
		<div class="title">
			<div class="xml">
				<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=dumpmenu&amp;type=xml" target="_blank" title="메뉴구조를 XML파일로 생성/받기" onclick="return confirm('정말로 이 사이트의 메뉴구조를 XML파일로 받으시겠습니까?\n받기와함께 _var/xml폴더에 [menu_사이트코드.xml]로 생성됩니다    ');"><img src="<?php echo $g['img_core']?>/file/small/xml.gif" alt="xml" /></a>
				<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=dumpmenu&amp;type=xls" target="_action_frame_<?php echo $m?>" title="메뉴구조를 엑셀파일로 받기" onclick="return confirm('정말로 이 사이트의 메뉴구조를 엑셀파일로 받으시겠습니까?');"><img src="<?php echo $g['img_core']?>/file/small/xls.gif" alt="xls" /></a>
				<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=dumpmenu&amp;type=txt" target="_action_frame_<?php echo $m?>" title="메뉴구조를 텍스트파일로 받기" onclick="return confirm('정말로 이 사이트의 메뉴구조를 텍스트파일로 받으시겠습니까?');"><img src="<?php echo $g['img_core']?>/file/small/txt.gif" alt="txt" /></a>
			</div>
			<?php echo $_HS['name']?>	
		</div>
		<?php if($ISCAT):?>
		<div class="joinimg"></div>
		<div class="tree<?php if(strstr($_SERVER['HTTP_USER_AGENT'],'MSIE 7')):?> ie7<?php endif?>">

		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/core.js"></script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/events.js"></script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/css.js"></script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/coordinates.js"></script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/drag.js"></script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/dragsort.js"></script>

		<script type="text/javascript">
		//<![CDATA[
		var dragsort = ToolMan.dragsort();
		var TreeImg = "<?php echo $g['img_core']?>/tree/default_none";
		var ulink = "<?php echo $g['s']?>/?r=<?php echo $r?>&amp;iframe=<?php echo $iframe?>&amp;system=<?php echo $system?>&amp;type=<?php echo $type?>&amp;cat=";
		//]]>
		</script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/js/tree.js"></script>
		<script type="text/javascript">
		//<![CDATA[
		var TREE_ITEMS = [['', null, <?php getMenuShow($s,$table['s_menu'],0,0,0,$cat,$CXA,0)?>]];
		new tree(TREE_ITEMS, tree_tpl);
		<?php echo $MenuOpen?>
		//]]>
		</script>
		</div>
		<?php else:?>
		<div class="none">등록된 메뉴가 없습니다.</div>
		<?php endif?>

		<?php if($CINFO['isson']||(!$cat&&$ISCAT)):?>
		<form action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $g['sys_module']?>" />
		<input type="hidden" name="a" value="modifymenugid" />

		<div class="savebtn">
			<img src="<?php echo $g['img_core']?>/_public/btn_admin.gif" alt="" title="펼치기" onclick="orderOpen();" />
			<input type="image" src="<?php echo $g['img_core']?>/_public/btn_save.gif" title="순서저장" />
		</div>
		<div class="tt1">메뉴순서</div>
		<ul id="menuorder">
		<?php $_MENUS=getDbSelect($table['s_menu'],'site='.$s.' and parent='.intval($CINFO['uid']).' and depth='.($CINFO['depth']+1).' order by gid asc','*')?>
		<?php while($_M=db_fetch_array($_MENUS)):?>
		<li>
			<input type="checkbox" name="menumembers[]" value="<?php echo $_M['uid']?>" checked="checked" />
			<img src="<?php echo $g['img_core']?>/_public/ico_drag.gif" alt="" class="drag" />
			<?php echo $_M['name']?>
			<?php if($_M['hidden']):?><img src="<?php echo $g['img_core']?>/_public/ico_hidden.gif" alt="" /><?php endif?>
		</li>
		<?php endwhile?>
		</ul>
		</form>
		<?php endif?>


	</div>


	<div id="catinfo">

		<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" enctype="multipart/form-data" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $g['sys_module']?>" />
		<input type="hidden" name="a" value="regismenu" />
		<input type="hidden" name="backc" value="user" />
		<input type="hidden" name="account" value="<?php echo $s?>" />
		<input type="hidden" name="cat" value="<?php echo $CINFO['uid']?>" />
		<input type="hidden" name="vtype" value="<?php echo $vtype?>" />
		<input type="hidden" name="depth" value="<?php echo intval($CINFO['depth'])?>" />
		<input type="hidden" name="parent" value="<?php echo intval($CINFO['uid'])?>" />
		<input type="hidden" name="perm_g" value="<?php echo $CINFO['perm_g']?>" />
		<input type="hidden" name="iframe" value="<?php echo $iframe?>" />

		<div class="title">
			<div class="xleft">
			<?php if($is_regismode):?>
				<?php if($vtype == 'sub'):?>서브메뉴 만들기<?php else:?>최상위메뉴 만들기<?php endif?>
			<?php else:?>
				메뉴 등록정보
			<?php endif?>
			</div>
			<div class="xright">
				<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;iframe=<?php echo $iframe?>&amp;system=<?php echo $system?>&amp;type=<?php echo $type?>&amp;makemenu=Y">최상위메뉴 등록</a>
			</div>
		</div>

		<div class="notice">
			<?php if($is_regismode):?>
			복수의 메뉴를 한번에 등록하시려면 메뉴명을 콤마(,)로 구분해 주세요.<br />
			보기)회사소개,커뮤니티,고객센터<br />
			메뉴코드를 같이 등록하시려면 다음과 같은 형식으로 등록해 주세요.<br />
			보기)회사소개=company,커뮤니티=community,고객센터=center<br />
			메뉴코드는 미등록시 자동생성됩니다.
			<?php else:?>
			속성을 변경하려면 설정값을 변경한 후 [속성변경] 버튼을 클릭해주세요.<br />
			메뉴를 삭제하면 소속된 하위메뉴까지 모두 삭제됩니다.
			<?php endif?>
		</div>

		<table>
			<?php if($vtype == 'sub'):?>
			<tr>
				<td class="td1">상위메뉴</td>
				<td class="td2 b">
				<?php for ($i = 0; $i < $ctnum; $i++) :?>
				<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;iframe=<?php echo $iframe?>&amp;system=<?php echo $system?>&amp;type=<?php echo $type?>&amp;cat=<?php echo $ctarr[$i]['uid']?>"><?php echo $ctarr[$i]['name']?></a>
				<?php if($i < $ctnum-1):?> &gt; <?php endif?> 
				<?php $catcode .= $ctarr[$i]['id'].'/';endfor?>
				</td>
			</tr>
			<?php else:?>
			<?php if($cat):?>
			<tr>
				<td class="td1">상위메뉴</td>
				<td class="td2 b">
				<?php for ($i = 0; $i < $ctnum-1; $i++) :?>
				<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;iframe=<?php echo $iframe?>&amp;system=<?php echo $system?>&amp;type=<?php echo $type?>&amp;cat=<?php echo $ctarr[$i]['uid']?>"><?php echo $ctarr[$i]['name']?></a>
				<?php if($i < $ctnum-2):?> &gt; <?php endif?> 
				<?php $delparent=$ctarr[$i]['uid'];$catcode .= $ctarr[$i]['id'].'/';endfor?>
				<?php if(!$delparent):?>최상위메뉴<?php endif?>
				</td>
			</tr>
			<?php endif?>
			<?php endif?>
			<tr>
				<td class="td1">메뉴명칭</td>
				<td class="td2">
					<input type="text" name="name" value="<?php echo $CINFO['name']?>" class="input sname<?php echo $is_fcategory?1:2?>" />
					<?php if($is_fcategory):?>
					<span class="btn01"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $g['sys_module']?>&amp;a=deletemenu&amp;account=<?php echo $s?>&amp;iframe=<?php echo $iframe?>&amp;cat=<?php echo $cat?>&amp;parent=<?php echo $delparent?>&amp;backc=user" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?     ')">메뉴삭제</a></span>
					<span class="btn01"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;iframe=<?php echo $iframe?>&amp;system=<?php echo $system?>&amp;type=<?php echo $type?>&amp;cat=<?php echo $cat?>&amp;vtype=sub&amp;makemenu=Y">서브메뉴등록</a></span>
					<?php endif?>
				</td>
			</tr>
			<?php if($CINFO['uid']&&!$vtype):?>
			<tr>
				<td class="td1">
					메뉴코드
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_menucode','block','none');" />
				</td>
				<td class="td2">
					<input type="text" name="id" value="<?php echo $CINFO['id']?>" maxlength="20" class="input sname1" /> <span>(고유키=<?php echo sprintf('%05d',$CINFO['uid'])?>)</span>
					<div id="guide_menucode" class="guide hide">
					이 메뉴를 잘 표현할 수 있는 단어로 입력해 주세요.<br />
					영문대소문자/숫자/_/- 조합으로 등록할 수 있습니다.<br />
					보기) 메뉴호출주소 : <?php echo RW('c=<span class="b">메뉴코드</span>')?><br />
					같은 사이트내에서 메뉴코드는 중복될 수 없습니다.<br />
					</div>
				</td>
			</tr>
			<?php endif?>
			<tr>
				<td class="td1">
					전시내용
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_contenttype','block','none');" />
				</td>
				<td class="td2">
					<select name="menutype" class="select1" onchange="displaySelect(this);">
					<option value="3"<?php if($CINFO['menutype']==3):?> selected="selected"<?php endif?>>ㆍ직접꾸미기</option>
					<option value="2"<?php if($CINFO['menutype']==2):?> selected="selected"<?php endif?>>ㆍ위젯콘텐츠</option>
					<option value="1"<?php if($CINFO['menutype']==1):?> selected="selected"<?php endif?>>ㆍ모듈콘텐츠</option>
					</select>

					<div id="jointBox" class="guide<?php if($CINFO['menutype']!=1):?> hide<?php endif?>">
						<input type="text" name="joint" id="jointf" value="<?php echo $CINFO['joint']?>" class="input sname1" />
						<input type="button" class="btngray" value="모듈연결" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.joint&iframe=Y&dropfield=jointf');" />
						<?php if($CINFO['joint']):?>
						<input type="button" class="btngray" value="미리보기" onclick="window.open('<?php echo $CINFO['joint']?>');" />
						<?php endif?>
						<div class="guide">
						<div class="shift">
						<input type="checkbox" name="redirect" id="xredirect" value="1"<?php if($CINFO['redirect']):?> checked="checked"<?php endif?> />
						<label for="xredirect">입력된 주소로 리다이렉트 시켜줍니다.(외부주소 링크시 사용)</label>
						</div>
						이 메뉴에 연결시킬 모듈이 있을 경우 모듈연결 클릭 후 선택해 주세요.<br />
						연결주소가 지정되면 이 메뉴를 호출시 지정된 모듈이 출력됩니다.<br />
						접근권한은 연결된 모듈의 권한설정을 따릅니다.
						</div>
					</div>
					<div id="widgetBox" class="guide<?php if($CINFO['menutype']!=2):?> hide<?php endif?>">
						<?php if($CINFO['uid']):?>
						<input type="button" class="btngray w" value="위젯으로 꾸미기" onclick="goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=<?php echo $iframe?>&system=edit.menu&_menu=<?php echo $CINFO['uid']?>&type=widget');" />
						<?php else:?>
						메뉴 등록 후 사용자페이지에서 직접 편집할 수 있습니다.<br />
						<?php endif?>
					</div>
					<div id="codeBox" class="guide<?php if($CINFO['menutype']&&$CINFO['menutype']!=3):?> hide<?php endif?>">
						<?php if($CINFO['uid']):?>
						<input type="button" class="btngray w" value="소스코드 직접편집" onclick="goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=<?php echo $iframe?>&system=edit.menu&_menu=<?php echo $CINFO['uid']?>&type=source');" />
						<?php else:?>
						메뉴 등록 후 사용자페이지에서 직접 편집할 수 있습니다.<br />
						<?php endif?>
					</div>

					<div id="guide_contenttype" class="guide hide">
					<span class="b">직접꾸미기 : </span>소스코드를 직접 편집할 수 있습니다.<br />
					<span class="b">위젯콘텐츠 : </span>위젯을 이용하여 메뉴를 꾸밀 수 있습니다.<br />
					<span class="b">모듈콘텐츠 : </span>모듈 콘텐츠를 출력할 수 있습니다.<br />
					</div>
				</td>
			</tr>

			<tr>
				<td class="td1">
					메뉴옵션
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_mpro','block','none');" />
				</td>
				<td class="td2 shift">
					<input type="checkbox" name="mobile" id="xmobile" value="1"<?php if($CINFO['mobile']):?> checked="checked"<?php endif?> /><label for="xmobile">모바일메뉴출력</label>
					<input type="checkbox" name="target" id="xtarget" value="_blank"<?php if($CINFO['target']):?> checked="checked"<?php endif?> /><label for="xtarget">새창열기</label>
					<input type="checkbox" name="hidden" id="cat_hidden" value="1"<?php if($CINFO['hidden']):?> checked="checked"<?php endif?> /><label for="cat_hidden">메뉴숨김</label>
					<input type="checkbox" name="reject" id="cat_reject" value="1"<?php if($CINFO['reject']):?> checked="checked"<?php endif?> /><label for="cat_reject">메뉴차단</label>

					<div id="guide_mpro" class="guide hide">
					<span class="b">모바일메뉴출력 : </span>모바일 레이아웃 사용시 이 메뉴를 출력합니다.<br />
					<span class="b">새창열기 : </span>이 메뉴를 클릭시 새창으로 엽니다.<br />
					<span class="b">메뉴숨김 : </span>메뉴를 출력하지 않습니다.(링크접근가능)<br />
					<span class="b">메뉴차단 : </span>메뉴의 접근을 차단합니다.(링크접근불가)<br />
					</div>
				</td>
			</tr>
			<tr>
				<td class="td1">레이아웃</td>
				<td class="td2">
					<select name="layout" class="select1">
					<option value="">&nbsp;+ 사이트 대표레이아웃</option>
					<?php $dirs = opendir($g['path_layout'])?>
					<?php while(false !== ($tpl = readdir($dirs))):?>
					<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
					<?php $dirs1 = opendir($g['path_layout'].$tpl)?>
					<option value="">--------------------------------</option>
					<?php while(false !== ($tpl1 = readdir($dirs1))):?>
					<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
					<option value="<?php echo $tpl?>/<?php echo $tpl1?>"<?php if($CINFO['layout']==$tpl.'/'.$tpl1):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo str_replace('.php','',$tpl1)?>)</option>
					<?php endwhile?>
					<?php closedir($dirs1)?>
					<?php endwhile?>
					<?php closedir($dirs)?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td1">허용등급</td>
				<td class="td2">
					<select name="perm_l" class="select1">
					<option value="">&nbsp;+ 전체허용</option>
					<option value="">--------------------------------</option>
					<?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
					<?php while($_L=db_fetch_array($_LEVEL)):?>
					<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$CINFO['perm_l']):?> selected="selected"<?php endif?>>ㆍ<?php echo $_L['name']?>(<?php echo number_format($_L['num'])?>) 이상</option>
					<?php if($_L['gid'])break; endwhile?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td1">
					차단그룹
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_permg','block','none');" />
				</td>
				<td class="td2">
					<select name="_perm_g" class="select1" multiple="multiple" size="5">
					<option value=""<?php if(!$CINFO['perm_g']):?> selected="selected"<?php endif?>>ㆍ차단안함</option>
					<?php $_SOSOK=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
					<?php while($_S=db_fetch_array($_SOSOK)):?>
					<option value="<?php echo $_S['uid']?>"<?php if(strstr($CINFO['perm_g'],'['.$_S['uid'].']')):?> selected="selected"<?php endif?>>ㆍ<?php echo $_S['name']?>(<?php echo number_format($_S['num'])?>)</option>
					<?php endwhile?>
					</select>
					<div id="guide_permg" class="guide hide">
					선택된 그룹에 속한 회원들은 이 메뉴에 대한 접근이 차단됩니다.<br />
					복수의 그룹을 선택하려면 드래그또는 Ctrl키를 누른다음 클릭해 주세요.
					</div>
				</td>
			</tr>
			<tr>
				<td class="td1">
					캐시적용
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_cache','block','none');" />
				</td>
				<td class="td2">
					<?php $cachefile = $g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.txt'?>
					<?php $cachetime = file_exists($cachefile) ? implode('',file($cachefile)) : 0?>
					<select name="cachetime" class="select1">
					<option value="">&nbsp;+ 적용안함</option>
					<option value="">--------------------------------</option>
					<?php for($i = 1; $i < 61; $i++):?>
					<option value="<?php echo $i?>"<?php if($cachetime==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>분</option>
					<?php endfor?>
					</select>

					<div id="guide_cache" class="guide hide">
					DB접속이 많거나 위젯을 많이 사용하는 메뉴일 경우 캐시를 적용하면<br />
					서버부하를 줄 일 수 있으며 속도를 높일 수 있습니다.<br />
					다만 반드시 실시간 처리를 요하는 메뉴일 경우 적용하지 마세요.
					</div>
				</td>
			</tr>
			<?php if($CINFO['uid']):?>
			<tr>
				<td class="td1">
					메뉴주소
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_addr','block','none');" />
				</td>
				<td class="td2">
					<span class="addr1">
					물리주소 : <span class="hand" onclick="window.open(this.innerHTML);" title="접속하기"><?php echo $g['s']?>/index.php?r=<?php echo $r?>&amp;c=<?php echo $vtype?substr($catcode,0,strlen($catcode)-1):$catcode.$CINFO['id']?></span><br />
					현재주소 : <span class="link hand" onclick="window.open(this.innerHTML);" title="접속하기"><?php echo RW($CINFO['uid']?'c='.($vtype?substr($catcode,0,strlen($catcode)-1):$catcode.$CINFO['id']):0)?></span>
					</div>
					<div id="guide_addr" class="guide hide">
					<span class="b">물리주소 :</span> 이 메뉴의 물리적인 실제 주소입니다.<br />
					<span class="b">현재주소 :</span> 주소줄이기/사이트코드 사용옵션 결과주소입니다.
					</span>
				</td>
			</tr>
			<tr>
				<td class="td1">코드확장</td>
				<td class="td2 shift">
					<input type="checkbox" <?php if($CINFO['imghead']||is_file($g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.header.php')):?> checked="checked"<?php endif?> disabled="disabled" />메뉴헤더
					<img src="<?php echo $g['img_core']?>/_public/ico_under.gif" alt="접기/펼치기" title="접기/펼치기" id="dm_img_header" class="dm" onclick="codShowHide('menu_header','block','none',this);" />
					<input type="checkbox" <?php if($CINFO['imgfoot']||is_file($g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.footer.php')):?> checked="checked"<?php endif?> disabled="disabled" />메뉴풋터
					<img src="<?php echo $g['img_core']?>/_public/ico_under.gif" alt="접기/펼치기" title="접기/펼치기" id="dm_img_footer" class="dm" onclick="codShowHide('menu_footer','block','none',this);" />
					<input type="checkbox" <?php if($CINFO['addinfo']):?> checked="checked"<?php endif?> disabled="disabled" />부가필드
					<img src="<?php echo $g['img_core']?>/_public/ico_under.gif" alt="접기/펼치기" title="접기/펼치기" id="dm_img_addinfo" class="dm" onclick="codShowHide('menu_addinfo','block','none',this);" />
				</td>
			</tr>
			<?php endif?>
		</table>

		<?php if($CINFO['uid']):?>
		<div id="menu_header" class="hide">
		<table>
			<tr>
				<td class="td1">헤더파일</td>
				<td class="td2">
					<input type="file" name="imghead" class="upfile" />
					<?php if($CINFO['imghead']):?>
					<div><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&module=filemanager&front=main&editmode=Y&pwd=./_var/menu/&file=<?php echo $CINFO['imghead']?>" target="_blank" title="<?php echo $CINFO['imghead']?>" class="u">파일수정</a> <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=menu_file_delete&amp;cat=<?php echo $CINFO['uid']?>&amp;dtype=head" target="_action_frame_<?php echo $m?>" class="u" onclick="return confirm('정말로 삭제하시겠습니까?     ');">삭제</a></div>
					<?php else:?>
					<div>(gif/jpg/png/swf 가능)</div>
					<?php endif?>
				</td>
			</tr>
			<tr>
				<td class="td1">
					헤더코드
					<img src="<?php echo $g['img_core']?>/_public/btn_code.gif" class="dn hand" alt="편집기" title="" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=edit.editor&iframe=Y&droparea=codheadArea');" />
				</td>
				<td class="td2">
					<textarea name="codhead" id="codheadArea"><?php if(is_file($g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.header.php')) echo htmlspecialchars(implode('',file($g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.header.php')))?></textarea>
				</td>
			</tr>
			<tr>
				<td class="td1">
					노출위치
				</td>
				<td class="td2">
					<select name="puthead" class="select1">
					<option value="0"<?php if(!$CINFO['puthead']):?> selected="selected"<?php endif?>>콘텐트</option>
					<option value="1"<?php if($CINFO['puthead']):?> selected="selected"<?php endif?>>콘테이너</option>
					</select>
				</td>
			</tr>
		</table>
		</div>

		<div id="menu_footer" class="hide">
		<table>
			<tr>
				<td class="td1">풋터파일</td>
				<td class="td2">
					<input type="file" name="imgfoot" class="upfile" />
					<?php if($CINFO['imgfoot']):?>
					<div><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&module=filemanager&front=main&editmode=Y&pwd=./_var/menu/&file=<?php echo $CINFO['imgfoot']?>" target="_blank" title="<?php echo $CINFO['imgfoot']?>" class="u">파일수정</a> <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=menu_file_delete&amp;cat=<?php echo $CINFO['uid']?>&amp;dtype=foot" target="_action_frame_<?php echo $m?>" class="u" onclick="return confirm('정말로 삭제하시겠습니까?     ');">삭제</a></div>
					<?php else:?>
					<div>(gif/jpg/png/swf 가능)</div>
					<?php endif?>
				</td>
			</tr>
			<tr>
				<td class="td1">
					풋터코드
					<img src="<?php echo $g['img_core']?>/_public/btn_code.gif" class="dn hand" alt="편집기" title="" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=edit.editor&iframe=Y&droparea=codfootArea');" />
				</td>
				<td class="td2">
					<textarea name="codfoot" id="codfootArea"><?php if(is_file($g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.footer.php')) echo htmlspecialchars(implode('',file($g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.footer.php')))?></textarea>
				</td>
			</tr>
			<tr>
				<td class="td1">
					노출위치
				</td>
				<td class="td2">
					<select name="putfoot" class="select1">
					<option value="0"<?php if(!$CINFO['putfoot']):?> selected="selected"<?php endif?>>콘텐트</option>
					<option value="1"<?php if($CINFO['putfoot']):?> selected="selected"<?php endif?>>콘테이너</option>
					</select>
				</td>
			</tr>
		</table>
		</div>

		<div id="menu_addinfo" class="hide">
		<table>
			<tr>
				<td class="td1">
					부가필드
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="__layerShowHide('guide_addinfo','block','none');" />
				</td>
				<td class="td2">
					<textarea name="addinfo" class="add"><?php echo htmlspecialchars($CINFO['addinfo'])?></textarea>
					<div id="guide_addinfo" class="guide hide">
					이 메뉴에 대해서 추가적인 정보가 필요할 경우 사용합니다.<br />
					필드명은 <span class="b">[addinfo]</span> 입니다. 
					</div>
				</td>
			</tr>
		</table>
		</div>
		<?php endif?>


		<div class="submitbox">

			<?php if($is_fcategory && $CINFO['isson']):?>
			<div class="sbcopybox shift">
				<input type="checkbox" name="subcopy" id="cubcopy" value="1" checked="checked" /><label for="subcopy">이 설정(메뉴숨김,레이아웃,권한)을 서브메뉴에도 일괄적용</label> 
			</div>
			<?php endif?>

			<?php if($CINFO['uid']):?>
			<?php if($vtype!='sub'):?>
			<input type="button" class="btngray" value="편집모드" onclick="goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=<?php echo $iframe?>&system=edit.menu&_menu=<?php echo $CINFO['uid']?>');" />
			<?php else:?>
			<input type="button" class="btngray" value="등록취소" onclick="history.go(-1);" />
			<?php endif?>
			<?php endif?>
			<input type="submit" class="btnblue" value="<?php echo $is_fcategory?'메뉴속성 변경':'신규메뉴 등록'?>" />
			<div class="clear"></div>
		</div>

		</form>
		

	</div>
	<div class="clear"></div>
</div>




<script type="text/javascript">
//<![CDATA[
var orderopen = false;
function orderOpen()
{
	if (orderopen == false)
	{
		getId('menuorder').style.display = 'block';
		orderopen = true;
	}
	else {
		getId('menuorder').style.display = 'none';
		orderopen = false;
	}
	__resetPageSize();
}
function displaySelect(obj)
{
	var f = document.procForm;
	if (obj.value == '1')
	{
		getId('jointBox').style.display = 'block';
		getId('widgetBox').style.display = 'none';
		getId('codeBox').style.display = 'none';
		f.joint.focus();
	}
	else if (obj.value == '2')
	{
		getId('jointBox').style.display = 'none';
		getId('widgetBox').style.display = 'block';
		getId('codeBox').style.display = 'none';
	}
	else if (obj.value == '3')
	{
		getId('jointBox').style.display = 'none';
		getId('widgetBox').style.display = 'none';
		getId('codeBox').style.display = 'block';
	}
	else
	{
		getId('jointBox').style.display = 'none';
		getId('widgetBox').style.display = 'none';
		getId('codeBox').style.display = 'none';
	}
	__resetPageSize();
}
function codShowHide(layer,show,hide,img)
{
	if(getId(layer).style.display != show)
	{
		getId(layer).style.display = show;
		img.src = img.src.replace('ico_under','ico_over');
		setCookie('ck_'+layer,show,1);
	}
	else
	{
		getId(layer).style.display = hide;
		img.src = img.src.replace('ico_over','ico_under');
		setCookie('ck_'+layer,hide,1);
	}
	__resetPageSize();
}
function saveCheck(f)
{
    var l1 = f._perm_g;
    var n1 = l1.length;
    var i;
	var s1 = '';

	for	(i = 0; i < n1; i++)
	{
		if (l1[i].selected == true && l1[i].value != '')
		{
			s1 += '['+l1[i].value+']';
		}
	}

	f.perm_g.value = s1;

	if (f.name.value == '')
	{
		alert('매뉴명칭을 입력해 주세요.      ');
		f.name.focus();
		return false;
	}
	if (f.id)
	{
		if (f.id.value == '')
		{
			alert('메뉴코드를 입력해 주세요.      ');
			f.id.focus();
			return false;
		}
		if (!chkFnameValue(f.id.value))
		{
			alert('메뉴코드는 영문대소문자/숫자/_/- 만 사용할 수 있습니다.      ');
			f.id.focus();
			return false;
		}
	}
	if (f.menutype.value == '1')
	{
		if (f.joint.value == '')
		{
			alert('모듈을 연결해 주세요.      ');
			f.joint.focus();
			return false;
		}
	}
	return confirm('정말로 실행하시겠습니까?         ');
}
function slideshowOpen()
{
	<?php if($CINFO['uid']):?>

	var ch = getCookie('ck_menu_header');
	var cf = getCookie('ck_menu_footer');
	var ca = getCookie('ck_menu_addinfo');

	if (ch == 'block')
	{
		getId('menu_header').style.display = ch;
		getId('dm_img_header').src = getId('dm_img_header').src.replace('ico_under','ico_over');
	}
	if (cf == 'block')
	{
		getId('menu_footer').style.display = cf;
		getId('dm_img_footer').src = getId('dm_img_footer').src.replace('ico_under','ico_over');
	}
	if (ca == 'block')
	{
		getId('menu_addinfo').style.display = ca;
		getId('dm_img_addinfo').src = getId('dm_img_addinfo').src.replace('ico_under','ico_over');
	}
	<?php endif?>

	if(getId('menuorder')) dragsort.makeListSortable(getId("menuorder"));
}
slideshowOpen();
<?php if($makemenu=='Y'):?>
document.procForm.name.focus();
<?php endif?>
//]]>
</script>



<?php endif?>
</div>






<script type="text/javascript">
//<![CDATA[
function __layerShowHide(layer,show,hide)
{
	layerShowHide(layer,show,hide)
	__resetPageSize();
}
function __resetPageSize()
{
	<?php if($iframe=='Y'):?>
	parent.getId('_layer_title_').innerHTML = "사이트 빠른설정";
	parent.getId('_box_layer_').style.top = '29px';
	parent.getId('_box_layer_').style.height = (parseInt(document.body.offsetHeight)+50)+'px';
	parent.getId('_box_frame_').style.height = (parseInt(document.body.offsetHeight)+20)+'px';
	<?php endif?>
}
window.onload = function ()
{
	__resetPageSize();
}
//]]>
</script>

