<?php
$recnum= 15;
$catque= ($cat?"category='".$cat."'":'');
$PAGES = getDbArray($table['s_page'],$catque,'*','uid','asc',$recnum,$p);
$NUM = getDbRows($table['s_page'],$catque);
$TPG = getTotalPage($NUM,$recnum);

if ($uid)
{
	$R = getUidData($table['s_page'],$uid);
}
?>


<div id="catebody">
	<div id="category">
		<div class="title">
			<select class="c1" onchange="goHref('<?php echo $g['adm_href']?>&amp;cat='+this.value);">
			<option value="">&nbsp;+ 페이지분류</option>
			<option value="">--------------------------------</option>
			<?php $_cats=array()?>
			<?php $CATS=db_query("select *,count(*) as cnt from ".$table['s_page']." group by category",$DB_CONNECT)?>
			<?php while($C=db_fetch_array($CATS)):$_cats[]=$C['category']?>
			<option value="<?php echo $C['category']?>"<?php if($C['category']==$cat):?> selected="selected"<?php endif?>>ㆍ<?php echo $C['category']?> (<?php echo $C['cnt']?>)</option>
			<?php endwhile?>
			</select>
			<select class="c2" onchange="goHref('<?php echo $g['adm_href']?>&amp;cat=<?php echo $cat?>&amp;p='+this.value);">
			<?php for($i = 1; $i <= $TPG; $i++):?>
			<option value="<?php echo $i?>"<?php if($i==$p):?> selected="selected"<?php endif?>>P.<?php echo $i?></option>
			<?php endfor?>
			</select>
		</div>
		
		<?php if($NUM):?>
		<div class="tree">
			<ul>
			<?php while($PR = db_fetch_array($PAGES)):?>
			<li>
				<img src="<?php echo $g['img_core']?>/_public/ico_folder_0<?php echo $PR['joint']?2:1?>.gif" alt="" />
				<a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $cat?>&amp;p=<?php echo $p?>&amp;uid=<?php echo $PR['uid']?>"><span class="name<?php if($PR['uid']==$uid):?> on<?php endif?>"><?php echo $PR['name']?></span></a><a href="<?php RW('mod='.$PR['id'])?>" target="_blank"><span class="id">(<?php echo $PR['id']?>)</span></a>
			</li>
			<?php endwhile?>
			</ul>
		</div>
		<?php else:?>
		<div class="none">등록된 페이지가 없습니다.</div>
		<?php endif?>
	</div>


	<div id="catinfo">


		<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $module?>" />
		<input type="hidden" name="a" value="regispage" />
		<input type="hidden" name="uid" value="<?php echo $R['uid']?>" />
		<input type="hidden" name="orign_id" value="<?php echo $R['id']?>" />
		<input type="hidden" name="perm_g" value="<?php echo $R['perm_g']?>" />

		<div class="title">

			<div class="xleft">
				페이지 등록정보
			</div>
			<div class="xright">

				<a href="<?php echo $g['adm_href']?>&amp;type=makepage">새페이지 등록</a>

			</div>





		</div>

		<div class="notice">
			관리가 편하도록 페이지분류를 적절히 지정하여 등록해 주세요.<br />
			전시할내용을 모듈콘텐츠로 지정하면 권한은 접근권한은 해당모듈의 설정을 따릅니다.
		</div>


		<table>
			<tr>
				<td class="td1">
					페이지명칭
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_startpage','block','none');" />
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
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_pagecode','block','none');" />
				</td>
				<td class="td2">
					<input type="text" name="id" value="<?php echo $R['id']?$R['id']:$_mod?>" maxlength="20" class="input sname" />
					<?php if($R['id']):?>
					<span class="btn01"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletepage&amp;uid=<?php echo $R['uid']?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?     ')">페이지삭제</a></span>
					<?php endif?>
	
					<div id="guide_pagecode" class="guide hide">
					페이지 호출시에 사용되는 코드이며 영문대소문자/숫자/_/- 조합으로 등록할 수 있습니다.<br />
					보기) 페이지호출주소 : <?php echo $g['r']?>/?mod=<span class="b">페이지코드</span><br />
					보기) My page호출 : <?php echo $g['r']?>/?mod=<span class="b">mypage</span><br />
					</div>
				</td>
			</tr>
			<tr>
				<td class="td1">
					페이지분류
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_pagecat','block','none');" />
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
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_contenttype','block','none');" />
				</td>
				<td class="td2">
					<select name="pagetype" class="select1" onchange="displaySelect(this);">
					<option value="3"<?php if($R['pagetype']==3):?> selected="selected"<?php endif?>>ㆍ직접꾸미기</option>
					<option value="2"<?php if($R['pagetype']==2):?> selected="selected"<?php endif?>>ㆍ위젯콘텐츠</option>
					<option value="1"<?php if($R['pagetype']==1):?> selected="selected"<?php endif?>>ㆍ모듈콘텐츠</option>
					</select>

					<div id="jointBox" class="guide<?php if($R['pagetype']!=1):?> hide<?php endif?>">
						<input type="text" name="joint" id="jointf" value="<?php echo $R['joint']?>" class="input sname" />
						<input type="button" class="btngray" value="모듈연결" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.joint&iframe=Y&dropfield=jointf&cmodule=[home]');" />
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
						<input type="button" class="btngray w" value="위젯으로 꾸미기" onclick="window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&system=edit.page&_page=<?php echo $R['uid']?>&type=widget');" />
						<?php else:?>
						페이지 등록 후 사용자페이지에서 직접 편집할 수 있습니다.<br />
						<?php endif?>
					</div>
					<div id="codeBox" class="guide<?php if($R['pagetype']&&$R['pagetype']!=3):?> hide<?php endif?>">
						<?php if($R['uid']):?>
						<input type="button" class="btngray w" value="소스코드 직접편집" onclick="window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&system=edit.page&_page=<?php echo $R['uid']?>&type=source');" />
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
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_sosokmenu','block','none');" />				
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
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_permg','block','none');" />
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
					복수의 그룹을 선택하려면 드래그하거나 Ctrl키를 누른다음 클릭해 주세요.
					</div>
				</td>
			</tr>
			<tr>
				<td class="td1">
					캐 시 적 용
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_cache','block','none');" />
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
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_addr','block','none');" />
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
			<input type="submit" class="btnblue" value="<?php echo $R['uid']?'페이지속성 변경':'새페이지 등록'?>" />
			<div class="clear"></div>
		</div>

		</form>
		

	</div>
	<div class="clear"></div>
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
<?php if($type == 'makepage'):?>
document.procForm.name.focus();
<?php endif?>
//]]>
</script>
