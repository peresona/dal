<?php
$typeset = array('config','module','widget','source');
if ($_menu)
{
	$type = $type ? $type : $typeset[$_HM['menutype']];
}
if (!$_HM['uid'])
{
	$type = 'config';
}
$g['url_reset'] = $g['s'].'/?r='.$r.'&amp;iframe='.$iframe.'&amp;system='.$system.($_HM['uid']?'&amp;_menu='.$_HM['uid']:'').($_make?'&amp;_make='.$_make:'');
?>
<div class="iframe<?php echo $iframe?>">
<div id="pages_top">

	<div class="title">
		<div class="xl"><h2><a href="<?php echo $g['url_reset']?>&amp;type=<?php echo $type?>">메뉴-<?php echo $_HM['name']?></a></h2></div>
		<div class="xr">
		
			<ul>

			<li class="leftside<?php if($type=='config'):?> selected<?php endif?>"><a href="<?php echo $g['url_reset']?>&amp;type=config">등록정보</a></li>
			
			<?php if($_HM['menutype']==1):?><li<?php if($type=='module'):?> class="selected"<?php endif?>><a href="<?php echo $g['url_reset']?>&amp;type=module">편집모드</a></li><?php endif?>
			<?php if($_HM['menutype']==2):?><li<?php if($type=='widget'):?> class="selected"<?php endif?>><a href="<?php echo $g['url_reset']?>&amp;type=widget">편집모드</a></li><?php endif?>
			<?php if($_HM['menutype']==3):?><li<?php if($type=='source'):?> class="selected"<?php endif?>><a href="<?php echo $g['url_reset']?>&amp;type=source">편집모드</a></li><?php endif?>
			<li>
			
				<div id="menutype" class="morebox">
					<ul class="dispbox">
					<li<?php if($_HM['menutype']==1):?> class="nowdisp"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=display_type&amp;iframe=<?php echo $iframe?>&amp;type=menu&amp;value=1&amp;uid=<?php echo $_HM['uid']?>" target="_action_frame_<?php echo $m?>" onclick="return displayChange();">모듈연결</a></li>
					<li<?php if($_HM['menutype']==2):?> class="nowdisp"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=display_type&amp;iframe=<?php echo $iframe?>&amp;type=menu&amp;value=2&amp;uid=<?php echo $_HM['uid']?>" target="_action_frame_<?php echo $m?>" onclick="return displayChange();">위젯전시</a></li>
					<li<?php if($_HM['menutype']==3):?> class="nowdisp"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=display_type&amp;iframe=<?php echo $iframe?>&amp;type=menu&amp;value=3&amp;uid=<?php echo $_HM['uid']?>" target="_action_frame_<?php echo $m?>" onclick="return displayChange();">직접코딩</a></li>
					</ul>
				</div>
				<a onclick="morebox('menutype');">전시형태 <img src="<?php echo $g['img_core']?>/_public/ico_arr_01.gif" alt="" /></a>
				
			</li>
			</ul>

		</div>
		<div class="clear"></div>
	</div>
	
</div>



<?php if($type == 'config'):?>

<div id="pages_make">
	<div class="tt">
		<img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" />
		메뉴속성
	</div>

		<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $g['sys_module']?>" />
		<input type="hidden" name="a" value="regismenu_user" />
		<input type="hidden" name="uid" value="<?php echo $_HM['uid']?>" />
		<input type="hidden" name="iframe" value="<?php echo $iframe?>" />


		<table>
			<tr>
				<td class="td1">메 뉴 명 칭</td>
				<td class="td2"><input type="text" name="name" value="<?php echo $_HM['name']?>" class="input sname" /></td>
			</tr>
			<tr>
				<td class="td1">
					메 뉴 코 드
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_menucode','block','none');" />
				</td>
				<td class="td2">
					<input type="text" name="id" value="<?php echo $_HM['id']?>" maxlength="20" class="input sname" /> <span>(고유키=<?php echo sprintf('%05d',$_HM['uid'])?>)</span>
					<div id="guide_menucode" class="guide hide">
					메뉴 호출시에 사용되는 코드이며 영문대소문자/숫자/_/- 조합으로 등록할 수 있습니다.<br />
					보기) 메뉴호출주소 : ./?c=<span class="b">메뉴코드</span><br />
					이 메뉴를 잘 표현할 수 있는 단어로 입력해 주세요.<br />
					같은 사이트내에서 메뉴코드는 중복될 수 없습니다.<br />
					</div>
				</td>
			</tr>
			<tr>
				<td class="td1">
					전시할내용
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_contenttype','block','none');" />
				</td>
				<td class="td2">
					<select name="menutype" class="select1" onchange="displaySelect(this);">
					<option value="3"<?php if($_HM['menutype']==3):?> selected="selected"<?php endif?>>ㆍ직접꾸미기</option>
					<option value="2"<?php if($_HM['menutype']==2):?> selected="selected"<?php endif?>>ㆍ위젯콘텐츠</option>
					<option value="1"<?php if($_HM['menutype']==1):?> selected="selected"<?php endif?>>ㆍ모듈콘텐츠</option>
					</select>

					<div id="jointBox" class="guide<?php if($_HM['menutype']!=1):?> hide<?php endif?>">
						<input type="text" name="joint" id="jointf" value="<?php echo $_HM['joint']?>" class="input sname" />
						<input type="button" class="btngray" value="모듈연결" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.joint&iframe=Y&dropfield=jointf');" />
						<?php if($_HM['joint']):?>
						<input type="button" class="btngray" value="미리보기" onclick="window.open('<?php echo $_HM['joint']?>');" />
						<?php endif?>
						<div class="guide">
							<div class="shift">
							<input type="checkbox" name="redirect" id="xredirect" value="1"<?php if($_HM['redirect']):?> checked="checked"<?php endif?> />
							<label for="xredirect">입력된 주소로 리다이렉트 시켜줍니다.(외부주소 링크시 사용)</label>
							</div>
							이 메뉴에 연결시킬 모듈이 있을 경우 모듈연결을 클릭한 후 선택해 주세요.<br />
							모듈 연결주소가 지정되면 이 메뉴를 호출시 해당 연결주소의 모듈이 출력됩니다.<br />
							접근권한은 연결된 모듈의 권한설정을 따릅니다.
						</div>
					</div>
					<div id="widgetBox" class="guide<?php if($_HM['menutype']!=2):?> hide<?php endif?>">
						<input type="button" class="btngray w" value="위젯으로 꾸미기" onclick="goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=<?php echo $iframe?>&system=<?php echo $system?>&_menu=<?php echo $_HM['uid']?>&type=widget');" />
					</div>
					<div id="codeBox" class="guide<?php if($_HM['menutype']&&$_HM['menutype']!=3):?> hide<?php endif?>">
						<input type="button" class="btngray w" value="소스코드 직접편집" onclick="goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=<?php echo $iframe?>&system=<?php echo $system?>&_menu=<?php echo $_HM['uid']?>&type=source');" />
					</div>
					<div id="guide_contenttype" class="guide hide">
					<span class="b">직접꾸미기 : </span>소스코드를 직접 편집할 수 있습니다.<br />
					<span class="b">위젯콘텐츠 : </span>위젯을 이용하여 메뉴를 꾸밀 수 있습니다.<br />
					<span class="b">모듈콘텐츠 : </span>모듈 콘텐츠를 출력할 수 있습니다.<br />
					</div>
				</td>
			</tr>

			<tr>
				<td class="td1"></td>
				<td class="td2 shift">
				<input type="checkbox" name="mobile" id="xmobile" value="1"<?php if($_HM['mobile']):?> checked="checked"<?php endif?> /><label for="xmobile">모바일메뉴출력</label>
				<input type="checkbox" name="target" id="xtarget" value="_blank"<?php if($_HM['target']):?> checked="checked"<?php endif?> /><label for="xtarget">새창열기</label>
				<input type="checkbox" name="hidden" id="cat_hidden" value="1"<?php if($_HM['hidden']):?> checked="checked"<?php endif?> /><label for="cat_hidden">메뉴숨김</label>
				<input type="checkbox" name="reject" id="cat_reject" value="1"<?php if($_HM['reject']):?> checked="checked"<?php endif?> /><label for="cat_reject">메뉴차단</label>
				</td>
			</tr>
		</table>
		
		<div class="submitbox">
			<input type="button" class="btngray" value="더자세히" onclick="goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=<?php echo $iframe?>&system=edit.all&type=menu&cat=<?php echo $_HM['uid']?>');" />
			<input type="submit" class="btnblue" value="메뉴 속성변경" />
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
		<input type="hidden" name="a" value="regismenu_user" />
		<input type="hidden" name="uid" value="<?php echo $_HM['uid']?>" />
		<input type="hidden" name="id" value="<?php echo $_HM['id']?>" />
		<input type="hidden" name="menutype" value="<?php echo $_HM['menutype']?>" />
		<input type="hidden" name="target" value="<?php echo $_HM['target']?>" />
		<input type="hidden" name="hidden" value="<?php echo $_HM['hidden']?>" />
		<input type="hidden" name="reject" value="<?php echo $_HM['reject']?>" />
		<input type="hidden" name="iframe" value="<?php echo $iframe?>" />


		<table>
			<tr>
				<td class="td1">메뉴명칭</td>
				<td class="td2"><input type="text" name="name" value="<?php echo $_HM['name']?>" class="input sname" /></td>
			</tr>
			<tr>
				<td class="td1">
					연결주소
				</td>
				<td class="td2">

					<input type="text" name="joint" id="jointf" value="<?php echo $_HM['joint']?>" class="input sname1" onclick="layerShowHide('guide_joint','block','none');" />
					<input type="button" class="btngray" value="찾아보기" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.joint&iframe=Y&dropfield=jointf');" />
					<?php if($_HM['joint']):?>
					<input type="button" class="btngray" value="미리보기" onclick="window.open('<?php echo $_HM['joint']?>');" />
					<?php endif?>

					<div id="guide_joint" class="guide">
						<div class="shift">
						<input type="checkbox" name="redirect" id="xredirect" value="1"<?php if($_HM['redirect']):?> checked="checked"<?php endif?> />
						<label for="xredirect">입력된 주소로 리다이렉트 시켜줍니다.(외부주소 링크시 사용)</label>
						</div>
						<?php if($notenable=='Y'):?>
						<span class="warning">이 연결주소는 유효하지 않습니다.</span><br />
						<span class="warning">연결주소가 잘 못 되었거나 연결주소에서도 모듈콘텐츠로 연결되어 있습니다.</span><br />
						<span class="warning">연결주소에서 연결한 모듈콘텐츠로 직접 연결해 주세요.</span><br />
						<span class="warning">연결주소관련 자세한 작동방식은 관련 매뉴얼을 참고하세요.</span><br /><br />
						<?php endif?>
						이 메뉴에 전시할 내용을 <span class="b">모듈콘텐츠</span>로 지정하면 사용할 수 있습니다.<br />
						이 메뉴에 연결시킬 모듈이 있을 경우 찾아보기를 클릭한 후 선택해 주세요.<br />
						모듈 연결주소가 지정되면 이 메뉴를 호출시 해당 연결주소의 모듈이 출력됩니다.
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
<?php include_once $g['path_page'].'menu/'.sprintf('%05d',$_HM['uid']).'.widget.php'?>

<div id="pages_widget">


	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return makeMap(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $g['sys_module']?>" />
	<input type="hidden" name="a" value="widgetwrite" />
	<input type="hidden" name="type" value="menu" />
	<input type="hidden" name="escapevar" value="" />
	<input type="hidden" name="uid" value="<?php echo $_HM['uid']?>" />
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

	getId('whtl'+MovableItem.id.replace('popup','')).innerHTML = 'W : <input type="text" id="whtl'+MovableItem.id.replace('popup','')+'_w" value="'+(w)+'" size="4" class="input" title="폭" onkeypress="widgetAply(\''+MovableItem.id.replace('popup','')+'\',event)" /> / '+ 'H : <input type="text" id="whtl'+MovableItem.id.replace('popup','')+'_h" value="'+(h)+'" size="4" class="input" title="높이" onkeypress="widgetAply(\''+MovableItem.id.replace('popup','')+'\',event)" /> / '+ 'T : <input type="text" id="whtl'+MovableItem.id.replace('popup','')+'_t" value="'+(t)+'" size="4" class="input" title="상단" onkeypress="widgetAply(\''+MovableItem.id.replace('popup','')+'\',event)" /> / '+ 'L : <input type="text" id="whtl'+MovableItem.id.replace('popup','')+'_l" value="'+(l)+'" size="4" class="input" title="좌측" onkeypress="widgetAply(\''+MovableItem.id.replace('popup','')+'\',event)" /> ' + '<input type="button" value="적용" class="btngray" style="height:20px;position:relative;top:1px;" onclick="widgetAply(\''+MovableItem.id.replace('popup','')+'\',event)" />';
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
			'$d[\'page\'][\'widget\']['+i+'][\'size\'] = "'+(moveObject[i].offsetWidth-2)+'px|'+(moveObject[i].offsetHeight-2)+'px|'+(moveObject[i].offsetTop)+'px|'+(moveObject[i].offsetLeft)+'px";\n'+
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
	<input type="hidden" name="type" value="menu" />
	<input type="hidden" name="uid" value="<?php echo $_HM['uid']?>" />
	<input type="hidden" name="iframe" value="<?php echo $iframe?>" />

	<div class="tt">
		<img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" />
		메뉴소스 직접꾸미기
		
		<input type="checkbox" id="ck_html" checked="checked" disabled="disabled" /><span>HTML</span>
		<input type="checkbox" id="ck_mobile" name="ck_mobile" onclick="tareacheck(this);"<?php if(is_file($g['path_page'].'menu/'.sprintf('%05d',$_HM['uid']).'.mobile.php')):?> checked="checked"<?php endif?> /><span>MOBILE</span>
		<input type="checkbox" id="ck_css" name="ck_css" onclick="tareacheck(this);"<?php if(is_file($g['path_page'].'menu/'.sprintf('%05d',$_HM['uid']).'.css')):?> checked="checked"<?php endif?> /><span>CSS</span>
		<input type="checkbox" id="ck_js" name="ck_js" onclick="tareacheck(this);"<?php if(is_file($g['path_page'].'menu/'.sprintf('%05d',$_HM['uid']).'.js')):?> checked="checked"<?php endif?> /><span>Java Script</span>
		<span>(저장파일 : <?php echo $g['path_page'].'menu/'.sprintf('%05d',$_HM['uid'])?>.확장자)</span>

	</div>

	<div class="editarea">
		<div>
		<div class="subtt">
			PC모드 HTML
			<img src="<?php echo $g['img_core']?>/_public/btn_html.gif" alt="편집기" title="편집기" class="hand" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=edit.editor&iframe=Y&droparea=MENU_sourceArea');" />
			<img src="<?php echo $g['img_core']?>/_public/btn_code.gif" alt="위젯코드" title="위젯코드" class="hand" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.widget&iframe=Y&isWcode=Y');" />
			<img src="<?php echo $g['img_core']?>/_public/btn_explorer.gif" alt="파일올리기" title="파일올리기" class="hand" onclick="window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=filemanager&front=main&fileupload=Y&iframe=Y&pwd=./pages/image/');" />
		</div>
		<textarea name="source" id="MENU_sourceArea" style="height:500px;"><?php echo htmlspecialchars(implode('',file($g['path_page'].'menu/'.sprintf('%05d',$_HM['uid']).'.php')))?></textarea>
		</div>

		<div id="sourceArea_ck_mobile"<?php if(!is_file($g['path_page'].'menu/'.sprintf('%05d',$_HM['uid']).'.mobile.php')):?> class="hide"<?php endif?>>
		<div class="subtt">
			모바일모드 HTML
			<img src="<?php echo $g['img_core']?>/_public/btn_html.gif" alt="편집기" title="편집기" class="hand" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=edit.editor&iframe=Y&droparea=MENU_sourceArea_mobile');" />
			<img src="<?php echo $g['img_core']?>/_public/btn_code.gif" alt="위젯코드" title="위젯코드" class="hand" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.widget&iframe=Y&isWcode=Y');" />
			<img src="<?php echo $g['img_core']?>/_public/btn_explorer.gif" alt="파일올리기" title="파일올리기" class="hand" onclick="window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=filemanager&front=main&fileupload=Y&iframe=Y&pwd=./pages/image/');" />
			<span class="gx">- 등록하지 않으면 모바일접속시 PC모드 HTML로 대체됩니다.</span>
		</div>
		<textarea name="mobile" id="MENU_sourceArea_mobile" style="height:200px;"><?php if(is_file($g['path_page'].'menu/'.sprintf('%05d',$_HM['uid']).'.mobile.php')) echo htmlspecialchars(implode('',file($g['path_page'].'menu/'.sprintf('%05d',$_HM['uid']).'.mobile.php')))?></textarea>
		</div>

		<div id="sourceArea_ck_css"<?php if(!is_file($g['path_page'].'menu/'.sprintf('%05d',$_HM['uid']).'.css')):?> class="hide"<?php endif?>>
		<div class="subtt">CSS</div>
		<textarea name="css" style="height:200px;"><?php if(is_file($g['path_page'].'menu/'.sprintf('%05d',$_HM['uid']).'.css')) echo htmlspecialchars(implode('',file($g['path_page'].'menu/'.sprintf('%05d',$_HM['uid']).'.css')))?></textarea>
		</div>

		<div id="sourceArea_ck_js"<?php if(!is_file($g['path_page'].'menu/'.sprintf('%05d',$_HM['uid']).'.js')):?> class="hide"<?php endif?>>
		<div class="subtt">자바스크립트</div>
		<textarea name="js" style="height:200px;"><?php if(is_file($g['path_page'].'menu/'.sprintf('%05d',$_HM['uid']).'.js')) echo htmlspecialchars(implode('',file($g['path_page'].'menu/'.sprintf('%05d',$_HM['uid']).'.js')))?></textarea>
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
function saveCheck(f)
{
	if (f.name.value == '')
	{
		alert('매뉴명칭을 입력해 주세요.      ');
		f.name.focus();
		return false;
	}
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

