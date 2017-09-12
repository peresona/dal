<?php
$typeset = array('config','module','widget','source');
$typeset1= array('','모듈연결','위젯전시','직접코딩');

$nameset = array
(
	'main'=>'메인화면',
	'join'=>'회원가입',
	'login'=>'로그인',
	'mypage'=>'나의',
	'search'=>'통합검색',
	'agreement'=>'홈페이지 이용약관',
	'private'=>'개인정보 취급방침',
	'postrule'=>'게시물 게재원칙',
);
if ($_page)
{
	$type = $type ? $type : $typeset[$_HP['pagetype']];
}
if (!$_HP['uid'])
{
	if (!$_make) getLink($g['s'].'/?r='.$r.'&iframe='.$iframe.'&system=edit.all&type=page','','','');
	$type = 'make';
}
$g['url_reset'] = $g['s'].'/?r='.$r.'&iframe='.$iframe.'&system='.$system.($_HP['uid']?'&amp;_page='.$_HP['uid']:'').($_make?'&amp;_make='.$_make:'');
?>
<div class="iframe<?php echo $iframe?>">
<div id="pages_top">

	<div class="title">
		<div class="xl"><h2><a href="<?php echo $g['url_reset']?>&amp;type=<?php echo $type?>">페이지-<?php echo $_HP['uid']?$_HP['name']:'새 페이지 만들기'?></a></h2></div>
		<div class="xr">
		
			<ul>
			<?php if($_HP['uid']):?>

			<li class="leftside<?php if($type=='config'):?> selected<?php endif?>"><a href="<?php echo $g['url_reset']?>&amp;type=config">등록정보</a></li>
			<?php if($_HP['pagetype']==1):?><li<?php if($type=='module'):?> class="selected"<?php endif?>><a href="<?php echo $g['url_reset']?>&amp;type=module">편집모드</a></li><?php endif?>
			<?php if($_HP['pagetype']==2):?><li<?php if($type=='widget'):?> class="selected"<?php endif?>><a href="<?php echo $g['url_reset']?>&amp;type=widget">편집모드</a></li><?php endif?>
			<?php if($_HP['pagetype']==3):?><li<?php if($type=='source'):?> class="selected"<?php endif?>><a href="<?php echo $g['url_reset']?>&amp;type=source">편집모드</a></li><?php endif?>

			<li>
				<div id="menutype" class="morebox">
					<ul class="dispbox">
					<li<?php if($_HP['pagetype']==1):?> class="nowdisp"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=display_type&amp;iframe=<?php echo $iframe?>&amp;type=page&amp;value=1&amp;uid=<?php echo $_HP['uid']?>" target="_action_frame_<?php echo $m?>" onclick="return displayChange();">모듈연결</a></li>
					<li<?php if($_HP['pagetype']==2):?> class="nowdisp"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=display_type&amp;iframe=<?php echo $iframe?>&amp;type=page&amp;value=2&amp;uid=<?php echo $_HP['uid']?>" target="_action_frame_<?php echo $m?>" onclick="return displayChange();">위젯전시</a></li>
					<li<?php if($_HP['pagetype']==3):?> class="nowdisp"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=display_type&amp;iframe=<?php echo $iframe?>&amp;type=page&amp;value=3&amp;uid=<?php echo $_HP['uid']?>" target="_action_frame_<?php echo $m?>" onclick="return displayChange();">직접코딩</a></li>
					</ul>
				</div>
				<a onclick="morebox('menutype');">전시형태 <img src="<?php echo $g['img_core']?>/_public/ico_arr_01.gif" alt="" /></a>
			</li>
			<?php endif?>
			</ul>

		</div>
		<div class="clear"></div>
	</div>
	
</div>




<?php if($type == 'make'):?>
<?php $_cats=array()?>
<?php $CATS=db_query("select *,count(*) as cnt from ".$table['s_page']." group by category",$DB_CONNECT)?>
<?php while($C=db_fetch_array($CATS)):$_cats[]=$C['category']?>
<?php endwhile?>

<div id="pages_make">
	<div class="tt">
		<img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" />
		요청된 페이지는 존재하지 않습니다. 지금 페이지를 만드시겠습니까?
	</div>

		<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return makeCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $g['sys_module']?>" />
		<input type="hidden" name="a" value="regispage" />
		<input type="hidden" name="layout" value="" />
		<input type="hidden" name="backc" value="user" />
		<input type="hidden" name="iframe" value="<?php echo $iframe?>" />

		<table>
			<tr>
				<td class="td1">
					페이지명칭
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_startpage','block','none');" />
				</td>
				<td class="td2">
					<input type="text" name="name" value="<?php echo $nameset[$_make]?>" class="input sname" />
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
					<input type="checkbox" name="ismain" value="1"<?php if($_make=='main'):?> checked="checked"<?php endif?> />시작페이지
					<input type="checkbox" name="mobile" value="1" />모바일용페이지
				</td>
			</tr>
			<tr>
				<td class="td1">
					페이지코드
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_pagecode','block','none');" />
				</td>
				<td class="td2">
					<input type="text" name="id" value="<?php echo $_make?>" maxlength="20" class="input sname" />
	
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
					<input type="text" name="category" value="기본분류" class="input sname" />
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
					<option value="3">ㆍ직접꾸미기</option>
					<option value="2">ㆍ위젯콘텐츠</option>
					<option value="1">ㆍ모듈콘텐츠</option>
					</select>

					<div id="jointBox" class="guide hide">
						<input type="text" name="joint" id="jointf" value="" class="input sname" />
						<input type="button" class="btngray" value="모듈연결" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.joint&iframe=Y&dropfield=jointf&cmodule=[<?php echo $g['sys_module']?>]');" />
						<div class="guide">
							이 페이지에 연결시킬 모듈이 있을 경우 모듈연결을 클릭한 후 선택해 주세요.<br />
							모듈 연결주소가 지정되면 이 페이지를 호출시 해당 연결주소의 모듈이 출력됩니다.<br />
							접근권한은 연결된 모듈의 권한설정을 따릅니다.
						</div>
					</div>
					<div id="widgetBox" class="guide hide">
						위젯을 이용해서 페이지를 꾸밀 수 있습니다.
					</div>
					<div id="codeBox" class="guide">
						HTML(PHP포함)소스를 직접 편집해서 페이지를 꾸밀 수 있습니다.
					</div>


					<div id="guide_contenttype" class="guide hide">
					<span class="b">직접꾸미기 : </span>소스코드를 직접 편집할 수 있습니다.<br />
					<span class="b">위젯콘텐츠 : </span>위젯을 이용하여 메뉴를 꾸밀 수 있습니다.<br />
					<span class="b">모듈콘텐츠 : </span>모듈 콘텐츠를 출력할 수 있습니다.<br />
					</div>
				</td>
			</tr>


		</table>
		
		<div class="submitbox">
			<input type="submit" class="btnblue" value="새 페이지 만들기" />
			<div class="clear"></div>
		</div>

		</form>
		


</div>


<?php endif?>

<?php if($type == 'config'):?>
<?php $_cats=array()?>
<?php $CATS=db_query("select *,count(*) as cnt from ".$table['s_page']." group by category",$DB_CONNECT)?>
<?php while($C=db_fetch_array($CATS)):$_cats[]=$C['category']?>
<?php endwhile?>


<div id="pages_make">
	<div class="tt">
		<img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" />
		페이지속성
	</div>

		<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return makeCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $g['sys_module']?>" />
		<input type="hidden" name="a" value="regispage" />
		<input type="hidden" name="uid" value="<?php echo $_HP['uid']?>" />
		<input type="hidden" name="orign_id" value="<?php echo $_HP['id']?>" />
		<input type="hidden" name="id" value="<?php echo $_HP['id']?>" />
		<input type="hidden" name="layout" value="<?php echo $_HP['layout']?>" />
		<input type="hidden" name="sosokmenu" value="<?php echo $_HP['sosokmenu']?>" />
		<input type="hidden" name="perm_g" value="<?php echo $_HP['perm_g']?>" />
		<input type="hidden" name="perm_l" value="<?php echo $_HP['perm_l']?>" />
		<input type="hidden" name="iframe" value="<?php echo $iframe?>" />

		<table>
			<tr>
				<td class="td1">
					페이지명칭
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_startpage','block','none');" />
				</td>
				<td class="td2">
					<input type="text" name="name" value="<?php echo $_HP['name']?>" class="input sname" />
	
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
					<input type="checkbox" name="ismain" value="1"<?php if($_HP['ismain']):?> checked="checked"<?php endif?> />시작페이지
					<input type="checkbox" name="mobile" value="1"<?php if($_HP['mobile']):?> checked="checked"<?php endif?> />모바일용페이지
				</td>
			</tr>
			<tr>
				<td class="td1">
					페이지분류
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_pagecat','block','none');" />
				</td>
				<td class="td2">
					<input type="text" name="category" value="<?php echo $_HP['category']?>" class="input sname" />
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
					<option value="3"<?php if($_HP['pagetype']==3):?> selected="selected"<?php endif?>>ㆍ직접꾸미기</option>
					<option value="2"<?php if($_HP['pagetype']==2):?> selected="selected"<?php endif?>>ㆍ위젯콘텐츠</option>
					<option value="1"<?php if($_HP['pagetype']==1):?> selected="selected"<?php endif?>>ㆍ모듈콘텐츠</option>
					</select>

					<div id="jointBox" class="guide<?php if($_HP['pagetype']!=1):?> hide<?php endif?>">
						<input type="text" name="joint" id="jointf" value="<?php echo $_HP['joint']?>" class="input sname" />
						<input type="button" class="btngray" value="모듈연결" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.joint&iframe=Y&dropfield=jointf&cmodule=[<?php echo $g['sys_module']?>]');" />
						<?php if($_HP['joint']):?>
						<input type="button" class="btngray" value="미리보기" onclick="window.open('<?php echo $_HP['joint']?>');" />
						<?php endif?>
						<div class="guide">
							이 페이지에 연결시킬 모듈이 있을 경우 모듈연결을 클릭한 후 선택해 주세요.<br />
							모듈 연결주소가 지정되면 이 페이지를 호출시 해당 연결주소의 모듈이 출력됩니다.<br />
							접근권한은 연결된 모듈의 권한설정을 따릅니다.
						</div>
					</div>
					<div id="widgetBox" class="guide<?php if($_HP['pagetype']!=2):?> hide<?php endif?>">
					<?php if($_HP['uid']):?>
					<input type="button" class="btngray w" value="위젯으로 꾸미기" onclick="goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=<?php echo $iframe?>&system=<?php echo $system?>&_page=<?php echo $_HP['uid']?>&type=widget');" />
					<?php endif?>
					</div>
					<div id="codeBox" class="guide<?php if($_HP['pagetype']&&$_HP['pagetype']!=3):?> hide<?php endif?>">
					<?php if($_HP['uid']):?>
					<input type="button" class="btngray w" value="소스코드 직접편집" onclick="goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=<?php echo $iframe?>&system=<?php echo $system?>&_page=<?php echo $_HP['uid']?>&type=source');" />
					<?php endif?>
					</div>

					<div id="guide_contenttype" class="guide hide">
					<span class="b">직접꾸미기 : </span>소스코드를 직접 편집할 수 있습니다.<br />
					<span class="b">위젯콘텐츠 : </span>위젯을 이용하여 메뉴를 꾸밀 수 있습니다.<br />
					<span class="b">모듈콘텐츠 : </span>모듈 콘텐츠를 출력할 수 있습니다.<br />
					</div>
				</td>
			</tr>


		</table>
		
		<div class="submitbox">
			<input type="button" class="btngray" value="더자세히" onclick="goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=<?php echo $iframe?>&system=edit.all&type=pageadd&uid=<?php echo $_HP['uid']?>');" />
			<input type="submit" class="btnblue" value="페이지 속성변경" />
			<div class="clear"></div>
		</div>

		</form>
		


</div>


<?php endif?>

<?php if($type == 'module'):?>

<div id="pages_make">
	<div class="tt">
		<img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" />
		모듈콘텐츠 연결
	</div>

		<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return makeCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $g['sys_module']?>" />
		<input type="hidden" name="a" value="regispage" />
		<input type="hidden" name="uid" value="<?php echo $_HP['uid']?>" />
		<input type="hidden" name="orign_id" value="<?php echo $_HP['id']?>" />
		<input type="hidden" name="id" value="<?php echo $_HP['id']?>" />
		<input type="hidden" name="layout" value="<?php echo $_HP['layout']?>" />
		<input type="hidden" name="sosokmenu" value="<?php echo $_HP['sosokmenu']?>" />
		<input type="hidden" name="ismain" value="<?php echo $_HP['ismain']?>" />
		<input type="hidden" name="perm_g" value="<?php echo $_HP['perm_g']?>" />
		<input type="hidden" name="perm_l" value="<?php echo $_HP['perm_l']?>" />
		<input type="hidden" name="category" value="<?php echo $_HP['category']?>" />
		<input type="hidden" name="pagetype" value="<?php echo $_HP['pagetype']?>" />
		<input type="hidden" name="iframe" value="<?php echo $iframe?>" />

		<table>
			<tr>
				<td class="td1">페이지명</td>
				<td class="td2">
					<input type="text" name="name" value="<?php echo $_HP['name']?>" class="input sname" />
				</td>
			</tr>
			<tr>
				<td class="td1">
					연결주소
				</td>
				<td class="td2">

					<input type="text" name="joint" id="jointf" value="<?php echo $_HP['joint']?>" class="input sname" />
					<input type="button" class="btngray" value="찾아보기" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.joint&iframe=Y&dropfield=jointf&cmodule=[<?php echo $g['sys_module']?>]');" />
					<?php if($_HP['joint']):?>
					<input type="button" class="btngray" value="미리보기" onclick="window.open('<?php echo $_HP['joint']?>');" />
					<?php endif?>

					<div id="guide_joint" class="guide">
						<?php if($notenable=='Y'):?>
						<span class="warning">이 연결주소는 유효하지 않습니다.</span><br />
						<span class="warning">찾아보기를 이용해서 유효한 연결주소를 등록해 주세요.</span><br /><br />
						<?php endif?>
						이 페이지의 전시할 내용을 <span class="b">모듈콘텐츠</span>로 지정하면 사용할 수 있습니다.<br />
						이 페이지에 연결시킬 모듈이 있을 경우 찾아보기를 클릭한 후 선택해 주세요.<br />
						모듈 연결주소가 지정되면 이 페이지를 호출시 해당 연결주소의 모듈이 출력됩니다.
					</div>

				</td>
			</tr>


		</table>
		
		<div class="submitbox shift">
			<input type="checkbox" name="backgo" id="backgox" value="1" /><label for="backgox">저장 후 사용자페이지로 이동</label> &nbsp;&nbsp;
			<input type="submit" class="btnblue" value=" 모듈연결 " />
			<div class="clear"></div>
		</div>

		</form>
		

</div>

<?php endif?>

<?php if($type == 'widget'):?>
<?php $d['page']['widget'] = array()?>
<?php include_once $g['path_page'].$_HP['id'].'.widget.php'?>

<div id="pages_widget">


	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return makeMap(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $g['sys_module']?>" />
	<input type="hidden" name="a" value="widgetwrite" />
	<input type="hidden" name="type" value="page" />
	<input type="hidden" name="escapevar" value="" />
	<input type="hidden" name="id" value="<?php echo $_HP['id']?>" />
	<input type="hidden" name="iframe" value="<?php echo $iframe?>" />

	<div class="tt">
		<img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" />
		위젯콘텐츠 꾸미기

		<input type="button" value="위젯추가" class="btnblue" onclick="getWidget(-1);" />
		<input type="submit" value="저장하기" class="btnblue" />
		
		<span class="height">
		<input type="checkbox" name="backgo" id="backgox" value="1" /><label for="backgox">저장 후 사용자페이지로 이동</label>
		(위젯판 높이
		<input type="text" name="mainheight" id="mainheight" value="<?php echo $d['page']['mainheight']?$d['page']['mainheight']:700?>" size="5" class="input" />px)
		</span>
		<span id="saveresult" class="result">
		저장되었습니다
		</span>
	</div>

	</form>

	<div id="workSpace" class="posrel"<?php if($iframe=='Y'):?> style="height:<?php echo $d['page']['mainheight']?$d['page']['mainheight']:700?>px;"<?php endif?>></div>

</div>


<script type="text/javascript">
//<![CDATA[

var isIE = document.all;
var isNN = !document.all&&getId;
var isHot = false;
var maxTiles = 20;
var MovableItem;
var moveObject = new Array(maxTiles);
var blocktitle = new Array(maxTiles);
var blockarray = new Array(maxTiles);
var scrollAmt  = new Array();

function layoutWidth(obj)
{
	var f = document.procForm;
	if (obj.value != '')
	{
		f.mainwidth.value = obj.value;
		getId('workSpace').style.width = obj.value;
	}
}
function startMove(e)
{
    if (!MovableItem) return;
    canvas = isIE ? "BODY" : "HTML";
        activeItem=isIE ? event.srcElement : e.target;  
        offsetx=isIE ? event.clientX : e.clientX;
        offsety=isIE ? event.clientY : e.clientY;
        lastX=parseInt(MovableItem.style.left);
        lastY=parseInt(MovableItem.style.top);
        lastW=parseInt(MovableItem.style.width);
        lastH=parseInt(MovableItem.style.height);
    if (offsetx+scrollAmt[0]>=(MovableItem.parentNode.offsetLeft+parseInt(MovableItem.style.left)+(MovableItem.offsetWidth*0.95)) || offsety+scrollAmt[1]>=(MovableItem.parentNode.offsetTop+parseInt(MovableItem.style.top)+(MovableItem.offsetHeight*0.95)) ){edge=true;MovableItem.style.cursor='se-resize';} else{edge=false;MovableItem.style.cursor='move';}
    moveEnabled=true;
    document.onmousemove=moveIt;
}
function widgetMove(obj, X, Y)
{
   scrollAmt = puGetScrollXY();
   if (X+scrollAmt[0]>=(obj.parentNode.offsetLeft+parseInt(obj.style.left)+(obj.offsetWidth*0.95)) || Y+scrollAmt[1]>=(obj.parentNode.offsetTop+parseInt(obj.style.top)+(obj.offsetHeight*0.95)) ) {obj.style.cursor='se-resize';} else{obj.style.cursor='move';}
}
function moveIt(e)
{
	if (!moveEnabled||!MovableItem) return;

	getWHTL();

	var w = isIE ? event.clientX-offsetx +lastW : e.clientX-offsetx+lastW;
	var h = isIE ? event.clientY-offsety +lastH : e.clientY-offsety+lastH;
	var x = isIE ? lastX+event.clientX-offsetx : lastX+e.clientX-offsetx;
	var y = isIE ? lastY+event.clientY-offsety : lastY+e.clientY-offsety;


	if (edge)
	{
		MovableItem.style.width = w+'px'; 
		MovableItem.style.height = h+'px'; 
		return false;
	}
	else
	{
		MovableItem.style.top = y+'px';
		MovableItem.style.left = x+'px';
		return false;
	}
}

function puGetScrollXY()
{
    var scrollXamt = 0, scrollYamt = 0;
    if( typeof( window.pageYOffset ) == 'number' )
	{
        scrollYamt = window.pageYOffset;
        scrollXamt = window.pageXOffset;
    } 
	else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) 
	{
        scrollYamt = document.body.scrollTop;
        scrollXamt = document.body.scrollLeft;
    } 
	else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) 
	{
        scrollYamt = document.documentElement.scrollTop;
        scrollXamt = document.documentElement.scrollLeft;
    }
    return [ scrollXamt, scrollYamt ];
}
function createTile(w,h,t,l)
{
	var i;
    for (i=0; i<maxTiles; i++)
	{
        if (moveObject[i].style.display == 'none')
		{
            moveObject[i].style.display = 'block';
            moveObject[i].style.width = w;
            moveObject[i].style.height = h;
            moveObject[i].style.top = t;
            moveObject[i].style.left = l;
			
			MovableItem = moveObject[i];
			getWHTL();
			return;
        }
    }
}
function poplayer(topObject)
{
	if (!topObject) return;
    for (var i=0; i<moveObject.length; i++)
	{
        moveObject[i].style.border = '#C5D7EF solid 1px';
        if (moveObject[i].style.zIndex > topObject.style.zIndex-1 && moveObject[i]!=topObject)
        {
			moveObject[i].style.zIndex = moveObject[i].style.zIndex-1;
		}
    }
    
	topObject.style.zIndex = moveObject.length-1;
    topObject.style.border = '#1A62BA solid 1px';
}
function getWHTL()
{
	var i;
	var w = parseInt(MovableItem.offsetWidth);
	var h = parseInt(MovableItem.offsetHeight);
	var t = parseInt(MovableItem.style.top);
	var l = parseInt(MovableItem.style.left);

	getId('whtl'+MovableItem.id.replace('popup','')).innerHTML = 'W : <input type="text" id="whtl'+MovableItem.id.replace('popup','')+'_w" value="'+(w)+'" size="4" class="input" style="z-index:100000;" title="폭" onkeypress="widgetAply(\''+MovableItem.id.replace('popup','')+'\',event)" /> / '+ 'H : <input type="text" id="whtl'+MovableItem.id.replace('popup','')+'_h" value="'+(h)+'" size="4" class="input" title="높이" onkeypress="widgetAply(\''+MovableItem.id.replace('popup','')+'\',event)" /> / '+ 'T : <input type="text" id="whtl'+MovableItem.id.replace('popup','')+'_t" value="'+(t)+'" size="4" class="input" title="상단" onkeypress="widgetAply(\''+MovableItem.id.replace('popup','')+'\',event)" /> / '+ 'L : <input type="text" id="whtl'+MovableItem.id.replace('popup','')+'_l" value="'+(l)+'" size="4" class="input" title="좌측" onkeypress="widgetAply(\''+MovableItem.id.replace('popup','')+'\',event)" /> ' + '<input type="button" value="적용" class="btngray" style="height:20px;position:relative;top:1px;" onclick="widgetAply(\''+MovableItem.id.replace('popup','')+'\',event)" />';
}
function widgetAply(layer,e)
{
	var keycode = event.keyCode ? event.keyCode : e.which;
	
	if (keycode == 13 || keycode == undefined)
	{
		var w = getId('whtl'+layer+'_w').value;
		var h = getId('whtl'+layer+'_h').value;
		var t = getId('whtl'+layer+'_t').value;
		var l = getId('whtl'+layer+'_l').value;

		moveObject[layer].style.width = parseInt(w)-2;
		moveObject[layer].style.height = parseInt(h)-2;
		moveObject[layer].style.top = t;
		moveObject[layer].style.left = l;
	}
}
function makeWorkspace()
{
	var i;
    var workspace='';
	var widgetvar;

    for (i=0; i<maxTiles; i++)
	{
		widgetvar=blockarray[i].split(',');
        workspace=workspace+'<div id=popup'+i+' style="'+
        ' z-Index:'+i+';display:none;position:absolute;left:0px;top:0px;filter:alpha(opacity=70);opacity:0.7;background:#ffffff url(\'<?php echo $g['img_module_skin']?>/btn_resize.gif\') bottom right no-repeat;border:#C5D7EF solid 1px;"'+
        ' onSelectStart="return false;"'+
        ' onmousedown="MovableItem=this;poplayer(this);return false;"'+
        ' onMouseover="isHot=true;"'+
        ' onMousemove="widgetMove(this,event.clientX,event.clientY);" '+
        ' onMouseout="isHot=false;" ondblclick="getWidget('+i+');">'+

		' <div style="height:20px;border-bottom:#C5D7EF;background:#D4E6FC;color:#224499;font-weight:bold;padding:8px 10px 0 10px;">'+
		' <div style="float:left;cursor:move;"><img src="<?php echo $g['img_module_skin']?>/btn_move.gif" alt="" title="이동" /> <span id="wtitle'+i+'" style="position:relative;top:-1px;">'+blocktitle[i]+'</span></div>'+
		' <div style="text-align:right;">'+
		' <img src="<?php echo $g['img_module_skin']?>/btn_conf.gif" alt="" title="속성" class="hand" onclick="getWidget('+i+');" />'+
		' <img src="<?php echo $g['img_module_skin']?>/btn_del.gif" alt="" title="삭제" class="hand" onclick="delWidget('+i+');" />'+
		' </div>'+
		' <div style="clear:both;"></div>'+
		' </div>'+
		' <div id="whtl'+i+'" style="font-size:12px;font-family:arial;color:#555;padding:7px 0 0 10px;width:100%;height:100%;background:url(\'<?php echo $g['img_module_skin']?>/widget/thumb_small.gif\') center center no-repeat;"></div>'+
		'</div>';
    }
    getId('workSpace').innerHTML = workspace;
}
function getWidget(i)
{
	var n = i < 0 ? 0 : i;
	var g = i < 0 ? '' : blockarray[i];
	window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.widget&iframe=Y&dropfield='+n+'&option='+g.replace(/&/g,'[!]'),'widgetWin','left=0,top=0,width=100px,height=100px,statusbar=no,scrollbars=no,toolbar=no');
}
function delWidget(i)
{
    if (!moveObject[i]) return;
	if (confirm('정말로 삭제하시겠습니까? '))
	{
		moveObject[i].style.display = "none";
		blocktitle[i] = '';
		blockarray[i] = '';
	}
}
function makeMap(f)
{
	getId('saveresult').style.display = 'inline';
	var i;
	var validMap = false;
	var mapSource = '\n\n';

    for (i=0; i<maxTiles; i++)
	{
        if (moveObject[i].style.display=='block')
		{
            mapSource=mapSource+

			'$d[\'page\'][\'widget\']['+i+'][\'name\'] = "'+blocktitle[i]+'";\n'+
			'$d[\'page\'][\'widget\']['+i+'][\'size\'] = "'+(moveObject[i].offsetWidth-2)+'px|'+(moveObject[i].offsetHeight-2)+'px|'+parseInt(moveObject[i].style.top)+'px|'+parseInt(moveObject[i].style.left)+'px";\n'+
			'$d[\'page\'][\'widget\']['+i+'][\'prop\'] = "'+blockarray[i]+'";\n\n';

			validMap = true;
        }
    }
	f.escapevar.value = mapSource;
}

window.onload = function()
{
	var i;
    document.onmousedown = startMove;
    document.onmouseup = Function("moveEnabled=false;MovableItem=''");

	<?php $i = 0?>
	<?php foreach($d['page']['widget'] as $_key => $_val):?>
	blocktitle[<?php echo $i?>] = "<?php echo $d['page']['widget'][$_key]['name']?>";
	blockarray[<?php echo $i?>] = "<?php echo $d['page']['widget'][$_key]['prop']?>";
	<?php $i++; endforeach?>

	for(i=0;i<maxTiles;i++)
	{
		if (!blocktitle[i]) blocktitle[i] = '';
		if (!blockarray[i]) blockarray[i] = '';
	}

	makeWorkspace();

	for(i=0;i<maxTiles;i++) moveObject[i] = getId('popup'+i);

	<?php $i = 0?>
	<?php foreach($d['page']['widget'] as $_key => $_val):?>
	<?php $_size = explode('|',$d['page']['widget'][$_key]['size'])?>
	
	createTile("<?php echo $_size[0]?>","<?php echo $_size[1]?>","<?php echo $_size[2]?>","<?php echo $_size[3]?>");

	<?php $i++; endforeach?>

	getId('workSpace').style.height = getId('mainheight').value + 'px';
	__resetPageSize();
}
//]]>
</script>




<?php endif?>

<?php if($type == 'source'):?>

<div id="pages_source">

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return sourcecheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $g['sys_module']?>" />
	<input type="hidden" name="a" value="sourcewrite" />
	<input type="hidden" name="type" value="page" />
	<input type="hidden" name="id" value="<?php echo $_HP['id']?>" />
	<input type="hidden" name="iframe" value="<?php echo $iframe?>" />

	<div class="tt">
		<img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" />
		페이지소스 직접꾸미기

		<input type="checkbox" id="ck_html" checked="checked" disabled="disabled" /><span>HTML</span>
		<input type="checkbox" id="ck_mobile" name="ck_mobile" onclick="tareacheck(this);"<?php if(is_file($g['path_page'].$_HP['id'].'.mobile.php')):?> checked="checked"<?php endif?> /><span>MOBILE</span>
		<input type="checkbox" id="ck_css" name="ck_css" onclick="tareacheck(this);"<?php if(is_file($g['path_page'].$_HP['id'].'.css')):?> checked="checked"<?php endif?> /><span>CSS</span>
		<input type="checkbox" id="ck_js" name="ck_js" onclick="tareacheck(this);"<?php if(is_file($g['path_page'].$_HP['id'].'.js')):?> checked="checked"<?php endif?> /><span>Java Script</span>
		<span>(저장파일 : <?php echo $g['path_page'].$_HP['id']?>.확장자)</span>

	</div>

	<div class="editarea">
		<div>
		<div class="subtt">
			PC모드 HTML
			<img src="<?php echo $g['img_core']?>/_public/btn_html.gif" alt="편집기" title="편집기" class="hand" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=edit.editor&iframe=Y&droparea=PAGE_sourceArea');" />
			<img src="<?php echo $g['img_core']?>/_public/btn_code.gif" alt="위젯코드" title="위젯코드" class="hand" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.widget&iframe=Y&isWcode=Y');" />
			<img src="<?php echo $g['img_core']?>/_public/btn_explorer.gif" alt="파일올리기" title="파일올리기" class="hand" onclick="window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=filemanager&front=main&fileupload=Y&iframe=Y&pwd=./pages/image/');" />
		</div>
		<textarea name="source" id="PAGE_sourceArea" style="height:500px;"><?php echo htmlspecialchars(implode('',file($g['path_page'].$_HP['id'].'.php')))?></textarea>
		</div>

		<div id="sourceArea_ck_mobile"<?php if(!is_file($g['path_page'].$_HP['id'].'.mobile.php')):?> class="hide"<?php endif?>>
		<div class="subtt">
			모바일모드 HTML
			<img src="<?php echo $g['img_core']?>/_public/btn_html.gif" alt="편집기" title="편집기" class="hand" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=edit.editor&iframe=Y&droparea=PAGE_sourceArea_mobile');" />
			<img src="<?php echo $g['img_core']?>/_public/btn_code.gif" alt="위젯코드" title="위젯코드" class="hand" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.widget&iframe=Y&isWcode=Y');" />
			<img src="<?php echo $g['img_core']?>/_public/btn_explorer.gif" alt="파일올리기" title="파일올리기" class="hand" onclick="window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=filemanager&front=main&fileupload=Y&iframe=Y&pwd=./pages/image/');" />
			<span class="gx">- 등록하지 않으면 모바일접속시 PC모드 HTML로 대체됩니다.</span>
		</div>
		<textarea name="mobile" id="PAGE_sourceArea_mobile" style="height:200px;"><?php if(is_file($g['path_page'].$_HP['id'].'.mobile.php')) echo htmlspecialchars(implode('',file($g['path_page'].$_HP['id'].'.mobile.php')))?></textarea>
		</div>

		<div id="sourceArea_ck_css"<?php if(!is_file($g['path_page'].$_HP['id'].'.css')):?> class="hide"<?php endif?>>
		<div class="subtt">CSS</div>
		<textarea name="css" style="height:200px;"><?php if(is_file($g['path_page'].$_HP['id'].'.css')) echo htmlspecialchars(implode('',file($g['path_page'].$_HP['id'].'.css')))?></textarea>
		</div>

		<div id="sourceArea_ck_js"<?php if(!is_file($g['path_page'].$_HP['id'].'.js')):?> class="hide"<?php endif?>>
		<div class="subtt">자바스크립트</div>
		<textarea name="js" style="height:200px;"><?php if(is_file($g['path_page'].$_HP['id'].'.js')) echo htmlspecialchars(implode('',file($g['path_page'].$_HP['id'].'.js')))?></textarea>
		</div>	
	</div>

	<div class="submitbtn">
		<input type="checkbox" name="backgo" id="backgox" value="1" /><label for="backgox">저장 후 사용자페이지로 이동</label> &nbsp;&nbsp;
		<input type="submit" value=" 저장하기 " class="btnblue" />
	</div>
	</form>

</div>
<script type="text/javascript">
//<![CDATA[
function tareacheck(obj)
{
	if (obj.checked == true)
	{
		getId('sourceArea_'+obj.id).style.display = 'block';
	}
	else {
		getId('sourceArea_'+obj.id).style.display = 'none';
	}
	__resetPageSize();
}
//]]>
</script>
<?php endif?>
</div>

<script type="text/javascript">
//<![CDATA[
function morebox(layer)
{
	if (getId(layer).style.display == 'block')
	{
		getId(layer).style.display = 'none';
	}
	else {
		getId(layer).style.display = 'block';
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
	__resetPageSize();
}
function makeCheck(f)
{

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
function sourcecheck(f)
{
	return confirm('정말로 실행하시겠습니까?         ');
}
function displayChange()
{
	if (confirm('선택한 전시방식으로 변경하시겠습니까?\n\n확인을 클릭하시면 실시간으로 변경됩니다.    '))
	{
		return true;
	}
	return false;
}
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
<?php if($type != 'widget'):?>
window.onload = function ()
{
	__resetPageSize();
}
<?php endif?>
//]]>
</script>

