<?php
if(!defined('__KIMS__')) exit;
checkAdmin(0);

function getMDname($id)
{
	global $typeset;
	if ($typeset[$id]) return $typeset[$id].' ('.$id.')';
	else return $id;
}
	$_WHERE .= 'mentor_confirm="Y"';
	if($search=='name' && $keyword)	$_WHERE .= ' and replace(name," ","") like "%'.trim($keyword).'%"';
	if($search=='jobCode' && $keyword)	$_WHERE .= ' and mentor_job='.trim($keyword);
	$sort	= $sort ? $sort : 'memberuid';
	$orderby= $orderby ? $orderby : 'desc';
	$recnum	= $recnum && $recnum < 200 ? $recnum : 20;

	$RCD = getDbArray($table['s_mbrdata'].' left join '.$table['s_mbrid'].' on memberuid=uid',$_WHERE,'*',$sort,$orderby,$recnum,$p);
	$NUM = getDbRows($table['s_mbrdata'].' left join '.$table['s_mbrid'].' on memberuid=uid',$_WHERE);
	$TPG = getTotalPage($NUM,$recnum);
	$autharr = array('','인증','보류','대기','탈퇴');
?>


<div id="mbrlist">

	<div class="info">

		<div class="article">
			<?php echo number_format($NUM)?>명(<?php echo $p?>/<?php echo $TPG?>페이지)
		</div>
		
		<div class="category">
			<form id="searchForm" action="/" method="get">
				<input type="hidden" name="r" value="<?php echo $r?>" />
				<input type="hidden" name="m" value="<?php echo $m?>" />
				<input type="hidden" name="module" value="<?php echo $module?>" />
				<input type="hidden" name="front" value="<?php echo $front?>" />
				<select id="search" name="search" id="search_what">
					<option value="">검색기준</option>
					<option value="name"<?php if($search=='name'):?> selected="selected"<?php endif;?>>이름</option>
					<option value="jobCode"<?php if($search=='jobCode'):?> selected="selected"<?php endif;?>>직업번호</option>
				</select>
				<input id="keyword" type="text" name="keyword" value="<?php if($search) echo $keyword; ?>">
				<input type="submit" value="검색">
				<input type="button" value="취소" onclick="cancelSearch();">
			</form>
		</div>
		<div class="clear"></div>
	</div>


	<form name="listForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="" />
	<input type="hidden" name="act" value="" />
	<input type="hidden" name="_WHERE" value="<?php echo $_WHERE?>" />
	<input type="hidden" name="_num" value="<?php echo $NUM?>" />


	<table summary="회원리스트 입니다.">
	<caption>회원리스트</caption> 
	<colgroup> 
	<col width="30">
	<col width="50"> 
	<col width="70"> 
	<col width="100"> 
	<col width="70"> 
	<col width="30"> 
	<col width="30">
	<col width="30"> 
	<col width="60"> 
	<col width="50"> 
	<col width="80"> 
	<col width="70"> 
<?php if($wideview == 'Y'):?>
	<col width="70"> 
	<col width="150"> 
	<col width="70"> 
	<col width="60"> 
	<col width="30"> 
	<col width="30"> 
	<col width="60"> 
	<col width="60"> 
	<col width="70"> 
<?php else:?>
	<col width="70"> 
<?php endif?>
	<col>
	</colgroup> 
	<thead>
	<tr>
	<th scope="col" class="side1"><img src="<?php echo $g['img_core']?>/_public/ico_check_01.gif" alt="선택/반전" class="hand" onclick="chkFlag('mbrmembers[]');" /></th>
	<th scope="col">번호</th>
	<th scope="col">이름</th>
	<th scope="col">직업</th>
	<th scope="col">아이디</th>
	<th scope="col">등급</th>
	<th scope="col">성별</th>
	<th scope="col">나이</th>
	<th scope="col">생년월일</th>
	<th scope="col">지역</th>
	<th scope="col">연락처</th>
	<th scope="col">가입일</th>
<?php if($wideview == 'Y'):?>
	<th scope="col">최근접속</th>
	<th scope="col">이메일</th>
	<th scope="col">그룹</th>
	<th scope="col">직업</th>
	<th scope="col">메일</th>
	<th scope="col">SMS</th>
	<th scope="col">보유P</th>
	<th scope="col">사용P</th>
	<th scope="col">결혼기념일</th>
<?php else:?>
	<th scope="col">최근접속</th>
<?php endif?>
	<th scope="col" class="side2"></th>
	</tr>
	</thead>
	<tbody>
	<?php while($R=db_fetch_array($RCD)):?>
	<?php $_R=getUidData($table['s_mbrid'],$R['memberuid'])?>
	<tr>
	<td class="side1"><input type="checkbox" name="mbrmembers[]" value="<?php echo $R['memberuid']?>" /></td>
	<td><?php echo ($NUM-((($p-1)*$recnum)+$_recnum++))?></td>
	<td><a href="javascript:OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=member&front=manager&page=main&mbruid=<?php echo $R['memberuid']?>');" title="회원메니져"><?php echo $R['name']?></a></td>
	<td><?php echo getJobName($R['mentor_job'])?></td>
	<td><a href="javascript:OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=member&front=manager&page=info&mbruid=<?php echo $R['memberuid']?>');" title="회원정보"><?php echo $_R['id']?></a></td>
	<td><?php echo $R['level']?></td>
	<td><?php if($R['sex']) echo getSex($R['sex'])?></td>
	<td><?php if($R['birth1']) echo getAge($R['birth1'])?></td>
	<td><?php if($R['birth1']):?><?php echo substr($R['birth1'],2,2)?>/<?php echo substr($R['birth2'],0,2)?>/<?php echo substr($R['birth2'],2,2)?><?php endif?></td>
	<td><?php echo $R['addr0']?></td>
	<td><?php echo $R['tel2']?$R['tel2']:$R['tel1']?></td>
	<td><?php echo getDateFormat($R['d_regis'],'Y.m.d')?></td>
	<td title="<?php echo getDateFormat($R['last_log'],'Y.m.d')?>"><?php echo -getRemainDate($R['last_log'])?>일</td>
<?php if($wideview == 'Y'):?>
	<td><?php echo $R['email']?></td>
	<td><?php echo $_GRPARR[$R['sosok']]?></td>
	<td><?php echo $R['job']?></td>
	<td><?php echo $R['mailing']?'Y':'N'?></td>
	<td><?php echo $R['sms']?'Y':'N'?></td>
	<td><a href="javascript:OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=<?php echo $module?>&front=manager&page=point&price=1&mbruid=<?php echo $R['memberuid']?>');" title="포인트획득내역"><?php echo number_format($R['point'])?></a></td>
	<td><a href="javascript:OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=<?php echo $module?>&front=manager&page=point&price=2&mbruid=<?php echo $R['memberuid']?>');" title="포인트사용내역"><?php echo number_format($R['usepoint'])?></a></td>
	<td class="side2"><?php echo $R['marr1']&&$R['marr2']?getDateFormat($R['marr1'].$R['marr2'],'Y.m.d'):''?></td>
<?php endif?>
	<td></td>
	</tr>
	<?php endwhile?>
	</tbody>
	</table>

	<?php if(!$NUM):?>
	<div class="nodata"><img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" /> 인증된 멘토가 없습니다.</div>
	<?php endif?>

	<div class="pagebox01">
		<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'<?php echo $g['img_core']?>/page/default');</script>
	</div>


	<div class="prebox">
		<div class="xt">
		<input type="button" class="btngray" value="작업" onclick="actQue('tool');" />
		<input type="button" class="btngray" value="지급" onclick="actQue('give');" />
		<input type="button" class="btngray" value="쪽지" onclick="actQue('paper');" />
		<input type="button" class="btngray" value="메일" onclick="actQue('email');" />
		<input type="button" class="btngray" value="추출" onclick="actQue('dump');" />
		<input type="button" class="btnblue" value="멘토 임명" onclick="actQue('mentor_apply');" />
		<input type="button" class="btnblue" value="임명 거절" onclick="actQue('mentor_refuse');" />
		<input type="button" class="btnblue" value="임명 취소" onclick="actQue('mentor_delete');" />
		<input type="checkbox" name="all" id="all_check" /><label for="all_check">현재 해당되는 모든회원(<?php echo number_format($NUM)?>명) 선택</label>
		</div>
		
		<div id="span_member_tool" class="xt1 hide">

		<select name="auth" class="select">
		<option value="">회원인증</option>
		<option value="">-----------------</option>
		<option value="1">ㆍ<?php echo $autharr[1]?></option>
		<option value="2">ㆍ<?php echo $autharr[2]?></option>
		<option value="3">ㆍ<?php echo $autharr[3]?></option>
		<option value="4">ㆍ<?php echo $autharr[4]?></option>
		</select>
		<input type="button" class="btnblue" value="변경" onclick="actQue('tool_auth');" /> <br />

		<select name="sosok" class="select">
		<option value="">회원그룹</option>
		<option value="">--------</option>
		<?php $_GRPARR = array()?>
		<?php $GRP = getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
		<?php while($_G=db_fetch_array($GRP)):$_GRPARR[$_G['uid']] = $_G['name']?>
		<option value="<?php echo $_G['uid']?>">ㆍ<?php echo $_G['name']?> (<?php echo number_format($_G['num'])?>)</option>
		<?php endwhile?>
		</select>

		<input type="button" class="btnblue" value="변경" onclick="actQue('tool_sosok');" /> <br />

		<select name="level" class="select">
		<option value="">회원등급</option>
		<option value="">--------</option>
		<?php $_LVLARR = array()?>
		<?php $levelnum = getDbData($table['s_mbrlevel'],'gid=1','*')?>
		<?php $LVL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',$levelnum['uid'],1)?>
		<?php while($_L=db_fetch_array($LVL)):$_LVLARR[$_L['uid']] = $_L['name']?>
		<option value="<?php echo $_L['uid']?>">ㆍ<?php echo $_L['name']?> (<?php echo number_format($_L['num'])?>)</option>
		<?php endwhile?>
		</select>
		<input type="button" class="btnblue" value="변경" onclick="actQue('tool_level');" />  <br />

		<input type="button" class="btnblue" value="데이터삭제" onclick="actQue('tool_delete');" />
		<input type="button" class="btnblue" value="탈퇴처리" onclick="actQue('tool_out');" />

		</div>

		<div id="span_member_give" class="xt1 hide">

		<select name="pointType">
		<option value="point">포인트</option>
		<option value="cash">적립금</option>
		<option value="money">예치금</option>
		</select>		
		<select name="how" class="sm">
		<option value="+">+</option>
		<option value="-">-</option>
		</select>
		<input type="text" name="price" size="5" class="input" />포인트(원) | 지급사유 : 
		<input type="text" name="comment" size="60" class="input" />
		<input type="button" class="btnblue" value="지급(차감)" onclick="actQue('give_point');" />

		</div>

		<div id="span_member_paper" class="xt1 hide">

		<textarea name="memo" rows="8" cols="60" class="textarea"></textarea><br />

		전송시간 : 
		<select name="year1">
		<?php for($i=$date['year'];$i<$date['year']+2;$i++):?><option value="<?php echo $i?>"<?php if($xyear1==$i):?> selected="selected"<?php endif?>><?php echo $i?></option><?php endfor?>
		</select>
		<select name="month1">
		<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($xmonth1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
		</select>
		<select name="day1">
		<?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($xday1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
		</select>
		<select name="hour1">
		<?php for($i=0;$i<24;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($xhour1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
		</select>:
		<select name="min1">
		<?php for($i=0;$i<60;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($xmin1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
		</select>

		<input type="button" class="btnblue" value="보내기" onclick="actQue('send_paper');" />

		</div>

		<div id="span_member_email" class="xt1 hide">

		불러오기 : 

		<select class="maildoc" onchange="maildocLoad(this);">
		<option value="">&nbsp;+ 이메일양식 불러오기</option>
		<option value="">----------------------------------------------------------------------</option>
		<?php $tdir = $g['path_module'].'member/doc/'?>
		<?php $dirs = opendir($tdir)?>
		<?php while(false !== ($skin = readdir($dirs))):?>
		<?php if($skin=='.' || $skin == '..')continue?>
		<?php $_type = str_replace('.txt','',$skin)?>
		<option value="<?php echo $_type?>">ㆍ<?php echo getMDname($_type)?></option>
		<?php endwhile?>
		<?php closedir($dirs)?>
		</select>
		<br />

		메일제목 : <input type="text" name="subject" value="" size="80" class="input" />
		<input type="checkbox" name="mailing" value="1" checked="checked" />메일링 비동의회원 제외<br />

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
		<input type="hidden" name="content" id="editFrameContent" value="" />
		<iframe name="editFrame" id="editFrame" src="" width="100%" height="550" frameborder="0" scrolling="no"></iframe><br /><br />
		<input type="button" class="btnblue" value="보내기" onclick="actQue('send_email');" />
		</div>

		<div id="span_member_dump" class="xt1 hide">
		<input type="button" class="btnblue" value="이메일" onclick="actQue('dump_email');" />
		<input type="button" class="btnblue" value="연락처" onclick="actQue('dump_tel');" />
		<input type="button" class="btnblue" value="DM주소" onclick="actQue('dump_address');" />
		<input type="button" class="btnblue" value="전체데이터" onclick="actQue('dump_alldata');" />
		</div>
	</div>
	</form>



</div>


<script type="text/javascript">
//<![CDATA[
function cancelSearch(){
	$('#keyword').val('');
	$('#search').val('');
	$('#searchForm').submit();
}

function ToolCheck(compo)
{
	frames.editFrame.showCompo();
	frames.editFrame.EditBox(compo);
}
function maildocLoad(obj)
{
	if (obj.value)
	{
		frames._action_frame_<?php echo $m?>.location.href = "<?php echo $g['s']?>/?r=<?php echo $r?>&m=member&a=maildoc_load&type=" + obj.value;
		obj.value = '';
		obj.form.subject.focus();
	}
}
var submitFlag = false;

function actQue(flag)
{
	if (submitFlag == true)
	{
		alert('요청하신 작업을 실행중에 있습니다. 완료될때까지 기다려 주세요.  ');
		return false;
	}

	var f = document.listForm;
    var l = document.getElementsByName('mbrmembers[]');
    var n = l.length;
    var i;
	var j=0;
	var s='';

	for	(i = 0; i < n; i++)
	{
		if (l[i].checked == true)
		{
			j++;
			s += l[i].value +',';
		}
	}
	if (!j && f.all_check.checked == false)
	{
		alert('회원을 선택해 주세요.     ');
		return false;
	}
	
	if (flag == 'tool' || flag == 'give' || flag == 'paper' || flag == 'email' || flag == 'dump')
	{
		getId('span_member_tool').style.display = 'none';
		getId('span_member_give').style.display = 'none';
		getId('span_member_paper').style.display = 'none';
		getId('span_member_email').style.display = 'none';
		getId('span_member_dump').style.display = 'none';

		getId('span_member_'+flag).style.display = 'block';
		
		if (flag == 'email')
		{
			frames.editFrame.location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=editor&toolbox=Y';
		}
		return false;
	}


	//회원인증
	if (flag == 'tool_auth')
	{
		if (f.auth.value == '')
		{
			alert('변경할 회원인증 상태를 선택해 주세요.   ');
			f.auth.focus();
			return false;
		}
	}
	//회원그룹
	if (flag == 'tool_sosok')
	{
		if (f.sosok.value == '')
		{
			alert('변경할 회원그룹을 선택해 주세요.   ');
			f.sosok.focus();
			return false;
		}
	}
	//일반회원으로 전환
	if (flag == 'mentor_delete')
	{
		if(!confirm('선택한 멘토를 일반회원으로 전환하시겠습니까?\n전환 후 회원이 멘토를 다시 지원 할 수 있습니다.')) return false;
	}
	//일반회원으로 전환
	if (flag == 'mentor_refuse')
	{
		if(!confirm('선택한 멘토 지원자를 거절하시겠습니까?\n전환 후 회원이 멘토를 다시 지원 할 수 있습니다.')) return false;
	}
	//회원등급
	if (flag == 'tool_level')
	{
		if (f.level.value == '')
		{
			alert('변경할 회원등급을 선택해 주세요.   ');
			f.level.focus();
			return false;
		}
	}
	//회원삭제, 탈퇴, 멘토 임명
	if (flag == 'tool_delete' || flag == 'tool_out' || flag == 'mentor_apply')
	{

	}
	//포인트지급
	if (flag == 'give_point')
	{
		if (f.price.value == '')
		{
			alert('지급할 포인트를 입력해 주세요.   ');
			f.price.focus();
			return false;
		}
		if (f.comment.value == '')
		{
			alert('지급사유를 입력해 주세요.   ');
			f.comment.focus();
			return false;
		}
	}
	//쪽지전송
	if (flag == 'send_paper')
	{
		if (f.all_check.checked == true)
		{
			if (parseInt(f._num.value) > 5000)
			{
				alert('쪽지는 한번에 최대 5000명까지만 전송할 수 있습니다.     ');
				return false;
			}
		}
		if (f.memo.value == '')
		{
			alert('내용을 입력해 주세요.   ');
			f.memo.focus();
			return false;
		}
	}
	//메일전송
	if (flag == 'send_email')
	{
		if (f.all_check.checked == true)
		{
			if (parseInt(f._num.value) > 1000)
			{
				alert('이메일은 한번에 최대 1000명까지만 전송할 수 있습니다.     ');
				return false;
			}
		}
		if (f.subject.value == '')
		{
			alert('제목을 입력해 주세요.   ');
			f.subject.focus();
			return false;
		}

		frames.editFrame.getEditCode(f.content,f.html);
		if (f.content.value == '')
		{
			alert('내용을 입력해 주세요.       ');
			frames.editFrame.getEditFocus();
			return false;
		}
	}
	//이메일추출, 연락처추출, DM추출, 전체데이터추출
	if (flag == 'dump_email' || flag == 'dump_tel' || flag == 'dump_address' || flag == 'dump_alldata')
	{

	}

	if (confirm('정말로 실행하시겠습니까?        '))
	{
		submitFlag = true;
		f.m.value = 'member';
		f.a.value = 'admin_action';
		f.act.value = flag;
		f.submit();
	}
	else 
	{
		return false;
	}
}
//]]>
</script>
