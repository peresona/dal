<?php
$account = $account ? $account : $s;
if ($s != $account)
{
	$_TMPSITE=getUidData($table['s_site'],$account);
}
else {
	$_TMPSITE['id'] = $r;
}

$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p);
include_once $g['path_core'].'function/menu.func.php';
$ISCAT = getDbRows($table['s_menu'],'site='.$account);

if($cat)
{
	$CINFO = getUidData($table['s_menu'],$cat);
	$ctarr = getMenuCodeToPath($table['s_menu'],$cat,0);
	$ctnum = count($ctarr);
	for ($i = 0; $i < $ctnum; $i++) $CXA[] = $ctarr[$i]['uid'];
}

$catcode = '';
$is_fcategory =  $CINFO['uid'] && $vtype != 'sub';
$is_regismode = !$CINFO['uid'] || $vtype == 'sub';
if ($is_regismode)
{
	$CINFO['menutype'] = '';
	$CINFO['name']	   = '';
	$CINFO['joint']	   = '';
	$CINFO['redirect'] = '';
	$CINFO['hidden']   = '';
	$CINFO['target']   = '';
	$CINFO['imghead']  = '';
	$CINFO['imgfoot']  = '';
}
?>


<div id="catebody">

	<div id="category">
		<div class="title">
			
			<select onchange="goHref('<?php echo $g['adm_href']?>&amp;account='+this.value);">
			<?php while($S = db_fetch_array($SITES)):?>
			<option value="<?php echo $S['uid']?>"<?php if($account==$S['uid']):?> selected="selected"<?php endif?>>ㆍ<?php echo $S['name']?></option>
			<?php endwhile?>
			<?php if(!db_num_rows($SITES)):?>
			<option value="">등록된 사이트가 없습니다.</option>
			<?php endif?>
			</select>
			
			<a href="<?php echo $g['s']?>/?r=<?php echo $_TMPSITE['id']?>&amp;m=<?php echo $module?>&amp;a=dumpmenu&amp;type=xml" target="_blank" title="메뉴구조를 XML파일로 생성/받기" onclick="return confirm('정말로 이 사이트의 메뉴구조를 XML파일로 받으시겠습니까?\n받기와함께 _var/xml폴더에 [menu_사이트코드.xml]로 생성됩니다    ');"><img src="<?php echo $g['img_core']?>/file/small/xml.gif" alt="xml" /></a>
			<a href="<?php echo $g['s']?>/?r=<?php echo $_TMPSITE['id']?>&amp;m=<?php echo $module?>&amp;a=dumpmenu&amp;type=xls" target="_action_frame_<?php echo $m?>" title="메뉴구조를 엑셀파일로 받기" onclick="return confirm('정말로 이 사이트의 메뉴구조를 엑셀파일로 받으시겠습니까?');"><img src="<?php echo $g['img_core']?>/file/small/xls.gif" alt="xls" /></a>
			<a href="<?php echo $g['s']?>/?r=<?php echo $_TMPSITE['id']?>&amp;m=<?php echo $module?>&amp;a=dumpmenu&amp;type=txt" target="_action_frame_<?php echo $m?>" title="메뉴구조를 텍스트파일로 받기" onclick="return confirm('정말로 이 사이트의 메뉴구조를 텍스트파일로 받으시겠습니까?');"><img src="<?php echo $g['img_core']?>/file/small/txt.gif" alt="txt" /></a>
			<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;type=makesite"><img src="<?php echo $g['img_core']?>/_public/btn_add.gif" alt="사이트추가" title="사이트추가" /></a>

		</div>
		<?php if($ISCAT):?>
		<div class="joinimg"></div>
		<div class="tree<?php if(strstr($_SERVER['HTTP_USER_AGENT'],'MSIE 7')):?> ie7<?php endif?>">
		<?php if(!$_isDragScript):?>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/core.js"></script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/events.js"></script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/css.js"></script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/coordinates.js"></script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/drag.js"></script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/dragsort.js"></script>
		<script type="text/javascript">
		//<![CDATA[
		var dragsort = ToolMan.dragsort();
		//]]>
		</script>
		<?php endif?>
		<script type="text/javascript">
		//<![CDATA[
		var dragsort = ToolMan.dragsort();
		var TreeImg = "<?php echo $g['img_core']?>/tree/default_none";
		var ulink = "<?php echo $g['adm_href']?>&amp;account=<?php echo $account?>&amp;cat=";
		//]]>
		</script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/js/tree.js"></script>
		<script type="text/javascript">
		//<![CDATA[
		var TREE_ITEMS = [['', null, <?php getMenuShow($account,$table['s_menu'],0,0,0,$cat,$CXA,0)?>]];
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
		<input type="hidden" name="m" value="<?php echo $module?>" />
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
		<input type="hidden" name="m" value="<?php echo $module?>" />
		<input type="hidden" name="a" value="regismenu" />
		<input type="hidden" name="account" value="<?php echo $account?>" />
		<input type="hidden" name="cat" value="<?php echo $CINFO['uid']?>" />
		<input type="hidden" name="vtype" value="<?php echo $vtype?>" />
		<input type="hidden" name="depth" value="<?php echo intval($CINFO['depth'])?>" />
		<input type="hidden" name="parent" value="<?php echo intval($CINFO['uid'])?>" />
		<input type="hidden" name="perm_g" value="<?php echo $CINFO['perm_g']?>" />

		<div class="title">

			<div class="xleft">
			
			<?php if($is_regismode):?>
				<?php if($vtype == 'sub'):?>서브메뉴 만들기<?php else:?>최상위메뉴 만들기<?php endif?>
			<?php else:?>
				메뉴 등록정보
			<?php endif?>
			
			</div>
			<div class="xright">

				<a href="<?php echo $g['adm_href']?>&amp;account=<?php echo $account?>&amp;type=makesite">최상위메뉴 등록</a>

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
				<?php for ($i = 0; $i < $ctnum; $i++): ?>
				<a href="<?php echo $g['adm_href']?>&amp;account=<?php echo $account?>&amp;cat=<?php echo $ctarr[$i]['uid']?>"><?php echo $ctarr[$i]['name']?></a>
				<?php if($i < $ctnum-1):?> &gt; <?php endif?> 
				<?php $catcode .= $ctarr[$i]['id'].'/';endfor?>
				</td>
			</tr>
			<?php else:?>
			<?php if($cat):?>
			<tr>
				<td class="td1">상위메뉴</td>
				<td class="td2 b">
				<?php for ($i = 0; $i < $ctnum-1; $i++): ?>
				<a href="<?php echo $g['adm_href']?>&amp;account=<?php echo $account?>&amp;cat=<?php echo $ctarr[$i]['uid']?>"><?php echo $ctarr[$i]['name']?></a>
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
					<span class="btn01"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $moudle?>&amp;a=deletemenu&amp;account=<?php echo $account?>&amp;cat=<?php echo $cat?>&amp;parent=<?php echo $delparent?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?     ')">메뉴삭제</a></span>
					<span class="btn01"><a href="<?php echo $g['adm_href']?>&amp;account=<?php echo $account?>&amp;cat=<?php echo $cat?>&amp;vtype=sub">서브메뉴등록</a></span>
					<?php endif?>
				</td>
			</tr>
			<?php if($CINFO['uid']&&!$vtype):?>
			<tr>
				<td class="td1">
					메뉴코드
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_menucode','block','none');" />
				</td>
				<td class="td2">
					<input type="text" name="id" value="<?php echo $CINFO['id']?>" maxlength="20" class="input sname1" /> <span>(고유키=<?php echo sprintf('%05d',$CINFO['uid'])?>)</span>
					<div id="guide_menucode" class="guide hide">
					이 메뉴를 잘 표현할 수 있는 단어로 입력해 주세요.<br />
					영문대소문자/숫자/_/- 조합으로 등록할 수 있습니다.<br />
					보기) 메뉴호출주소 : <?php RW('c=<span class="b">메뉴코드</span>')?><br />
					메뉴코드는 중복될 수 없습니다.<br />
					</div>
				</td>
			</tr>
			<?php endif?>
			<tr>
				<td class="td1">
					전시내용
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_contenttype','block','none');" />
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
						이 메뉴에 연결시킬 모듈이 있을 경우 모듈연결을 클릭한 후 선택해 주세요.<br />
						모듈 연결주소가 지정되면 이 메뉴를 호출시 해당 연결주소의 모듈이 출력됩니다.<br />
						접근권한은 연결된 모듈의 권한설정을 따릅니다.
						</div>
					</div>
					<div id="widgetBox" class="guide<?php if($CINFO['menutype']!=2):?> hide<?php endif?>">
						<?php if($CINFO['uid']):?>
						<input type="button" class="btngray w" value="위젯으로 꾸미기" onclick="window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&system=edit.menu&_menu=<?php echo $CINFO['uid']?>&type=widget');" />
						<?php else:?>
						메뉴 등록 후 사용자페이지에서 직접 편집할 수 있습니다.<br />
						<?php endif?>
					</div>
					<div id="codeBox" class="guide<?php if($CINFO['menutype']&&$CINFO['menutype']!=3):?> hide<?php endif?>">
						<?php if($CINFO['uid']):?>
						<input type="button" class="btngray w" value="소스코드 직접편집" onclick="window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&system=edit.menu&_menu=<?php echo $CINFO['uid']?>&type=source');" />
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
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_mpro','block','none');" />
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
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_permg','block','none');" />
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
					복수의 그룹을 선택하려면 드래그하거나 Ctrl키를 누른다음 클릭해 주세요.
					</div>
				</td>
			</tr>
			<tr>
				<td class="td1">
					캐시적용
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_cache','block','none');" />
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
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_addr','block','none');" />
				</td>
				<td class="td2">
					<div class="addr1">
					물리주소 : <span class="hand" onclick="window.open(this.innerHTML);" title="접속하기"><?php echo $g['s']?>/index.php?r=<?php echo $r?>&amp;c=<?php echo $vtype?substr($catcode,0,strlen($catcode)-1):$catcode.$CINFO['id']?></span><br />
					현재주소 : <span class="link hand" onclick="window.open(this.innerHTML);" title="접속하기"><?php echo RW($CINFO['uid']?'c='.($vtype?substr($catcode,0,strlen($catcode)-1):$catcode.$CINFO['id']):0)?></span>
					</div>
					<div id="guide_addr" class="guide hide">
					<span class="b">물리주소 :</span> 이 메뉴의 물리적인 실제 주소입니다.<br />
					<span class="b">현재주소 :</span> 주소줄이기/사이트코드 사용옵션 결과주소입니다.
					</div>
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
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=filemanager&amp;front=main&amp;editmode=Y&amp;pwd=./_var/menu/&file=<?php echo $CINFO['imghead']?>" target="_blank" title="<?php echo $CINFO['imghead']?>" class="u">파일수정</a> <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=menu_file_delete&amp;cat=<?php echo $CINFO['uid']?>&amp;dtype=head" target="_action_frame_<?php echo $m?>" class="u" onclick="return confirm('정말로 삭제하시겠습니까?     ');">삭제</a>
					<?php else:?>
					<span>(gif/jpg/png/swf 가능)</span>
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
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=filemanager&amp;front=main&amp;editmode=Y&amp;pwd=./_var/menu/&file=<?php echo $CINFO['imgfoot']?>" target="_blank" title="<?php echo $CINFO['imgfoot']?>" class="u">파일수정</a> <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=menu_file_delete&amp;cat=<?php echo $CINFO['uid']?>&amp;dtype=foot" target="_action_frame_<?php echo $m?>" class="u" onclick="return confirm('정말로 삭제하시겠습니까?     ');">삭제</a>
					<?php else:?>
					<span>(gif/jpg/png/swf 가능)</span>
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
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_addinfo','block','none');" />
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

			<?php if($vtype=='sub'):?><input type="button" class="btngray" value="등록취소" onclick="history.back();" /><?php endif?>
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

	if (f.account.value == '')
	{
		alert('사이트가 등록되지 않았습니다.      ');
		return false;
	}
	if (f.name.value == '')
	{
		alert('메뉴명칭을 입력해 주세요.      ');
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
<?php if($type == 'makesite'):?>
document.procForm.name.focus();
<?php endif?>
//]]>
</script>