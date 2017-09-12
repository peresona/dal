<?php
$year1	= $year1  ? $year1  : 2016;
$month1	= $month1 ? $month1 : 12;
$day1	= $day1   ? $day1   : 1;//substr($date['today'],6,2);
$year2	= $year2  ? $year2  : substr($date['today'],0,4);
$month2	= $month2 ? $month2 : substr($date['today'],4,2);
$day2	= $day2   ? $day2   : substr($date['today'],6,2);

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;

$_WHERE = 'd_regis > '.$year1.sprintf('%02d',$month1).sprintf('%02d',$day1).'000000 and d_regis < '.$year2.sprintf('%02d',$month2).sprintf('%02d',$day2).'240000';
if ($where && $keyw)
{
	if (strstr('[name][nic][id][ip]',$where)) $_WHERE .= " and ".$where."='".$keyw."'";
	else $_WHERE .= getSearchSql($where,$keyw,$ikeyword,'or');	
}
$RCD = getDbArray('rb_dalkkum_eventapply',$_WHERE,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows('rb_dalkkum_eventapply',$_WHERE);
$TPG = getTotalPage($NUM,$recnum);
$step = array('','<font color="purple"><b>확인 전</b></font>','<font color="green">확인중</font>','<font color="red">거절</font>','<font color="green">진행중</font>','<font color="blue">수락</font>',);
	// 프로그램 기재
	$_PGD = getDbSelect('rb_dalkkum_program','','*');
	$programs = array('');
	while ($_tmp = db_fetch_array($_PGD)) {
		$programs[$_tmp['uid']] = $_tmp['name'];
	}
?>

<div id="applylist">
	<div class="sbox">
		<form name="procForm" action="<?php echo $g['s']?>/" method="get">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $m?>" />
		<input type="hidden" name="module" value="<?php echo $module?>" />
		<input type="hidden" name="front" value="<?php echo $front?>" />
	<div>
		<select name="year1">
		<?php for($i=$date['year'];$i>2000;$i--):?><option value="<?php echo $i?>"<?php if($year1==$i):?> selected="selected"<?php endif?>><?php echo $i?>년</option><?php endfor?>
		</select>
		<select name="month1">
		<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($month1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>월</option><?php endfor?>
		</select>
		<select name="day1">
		<?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($day1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>일(<?php echo getWeekday(date('w',mktime(0,0,0,$month1,$i,$year1)))?>)</option><?php endfor?>
		</select> ~
		<select name="year2">
		<?php for($i=$date['year'];$i>2000;$i--):?><option value="<?php echo $i?>"<?php if($year2==$i):?> selected="selected"<?php endif?>><?php echo $i?>년</option><?php endfor?>
		</select>
		<select name="month2">
		<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($month2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>월</option><?php endfor?>
		</select>
		<select name="day2">
		<?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($day2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>일(<?php echo getWeekday(date('w',mktime(0,0,0,$month2,$i,$year2)))?>)</option><?php endfor?>
		</select>

		<input type="button" class="btngray" value="기간적용" onclick="this.form.submit();" />
		<input type="button" class="btngray" value="어제" onclick="dropDate('<?php echo date('Ymd',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-1,substr($date['today'],0,4)))?>','<?php echo date('Ymd',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-1,substr($date['today'],0,4)))?>');" />
		<input type="button" class="btngray" value="오늘" onclick="dropDate('<?php echo $date['today']?>','<?php echo $date['today']?>');" />
		<input type="button" class="btngray" value="일주" onclick="dropDate('<?php echo date('Ymd',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-7,substr($date['today'],0,4)))?>','<?php echo $date['today']?>');" />
		<input type="button" class="btngray" value="한달" onclick="dropDate('<?php echo date('Ymd',mktime(0,0,0,substr($date['today'],4,2)-1,substr($date['today'],6,2),substr($date['today'],0,4)))?>','<?php echo $date['today']?>');" />
		<input type="button" class="btngray" value="당월" onclick="dropDate('<?php echo substr($date['today'],0,6)?>01','<?php echo $date['today']?>');" />
		<input type="button" class="btngray" value="전월" onclick="dropDate('<?php echo date('Ym',mktime(0,0,0,substr($date['today'],4,2)-1,substr($date['today'],6,2),substr($date['today'],0,4)))?>01','<?php echo date('Ym',mktime(0,0,0,substr($date['today'],4,2)-1,substr($date['today'],6,2),substr($date['today'],0,4)))?>31');" />
		<input type="button" class="btngray" value="전체" onclick="dropDate('20090101','<?php echo $date['today']?>');" />
		</div>

		<div>
		<select name="sort" onchange="this.form.submit();">
		<option value="uid"<?php if($sort=='uid'):?> selected="selected"<?php endif?>>등록일</option>
		<!--
		<option value="hit"<?php if($sort=='hit'):?> selected="selected"<?php endif?>>조회</option>
		<option value="down"<?php if($sort=='down'):?> selected="selected"<?php endif?>>다운</option>
		<option value="comment"<?php if($sort=='comment'):?> selected="selected"<?php endif?>>댓글</option>
		<option value="oneline"<?php if($sort=='oneline'):?> selected="selected"<?php endif?>>한줄의견</option>
		<option value="trackback"<?php if($sort=='trackback'):?> selected="selected"<?php endif?>>트랙백</option>
		<option value="score1"<?php if($sort=='score1'):?> selected="selected"<?php endif?>>점수1</option>
		<option value="score2"<?php if($sort=='score2'):?> selected="selected"<?php endif?>>점수2</option>
		<option value="singo"<?php if($sort=='singo'):?> selected="selected"<?php endif?>>신고</option>
		-->
		</select>
		<select name="orderby" onchange="this.form.submit();">
		<option value="desc"<?php if($orderby=='desc'):?> selected="selected"<?php endif?>>역순</option>
		<option value="asc"<?php if($orderby=='asc'):?> selected="selected"<?php endif?>>정순</option>
		</select>

		<select name="recnum" onchange="this.form.submit();">
		<option value="20"<?php if($recnum==20):?> selected="selected"<?php endif?>>20개</option>
		<option value="35"<?php if($recnum==35):?> selected="selected"<?php endif?>>35개</option>
		<option value="50"<?php if($recnum==50):?> selected="selected"<?php endif?>>50개</option>
		<option value="75"<?php if($recnum==75):?> selected="selected"<?php endif?>>75개</option>
		<option value="90"<?php if($recnum==90):?> selected="selected"<?php endif?>>90개</option>
		</select>
		<select name="where">
		<option value="name|a_group"<?php if($where=='name|a_group'):?> selected="selected"<?php endif?>>담당자 이름 + 소속</option>
		<option value="tel"<?php if($where=='tel'):?> selected="selected"<?php endif?>>연락처</option>
		<option value="email"<?php if($where=='email'):?> selected="selected"<?php endif?>>메일주소</option>
		</select>

		<input type="text" name="keyw" value="<?php echo stripslashes($keyw)?>" class="input" />

		<input type="submit" value="검색" class="btnblue" />
		<input type="button" value="리셋" class="btngray" onclick="location.href='<?php echo $g['adm_href']?>';" />

		</div>

		</form>
	</div>


	<div class="info">

		<div class="article">
			<?php echo number_format($NUM)?>개(<?php echo $p?>/<?php echo $TPG?>페이지)
		</div>
		
		<div class="category">

		</div>
		<div class="clear"></div>
	</div>



	<form name="listForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="" />


	<table summary="전체 게시물리스트 입니다.">
	<caption>전체게시물</caption> 
	<colgroup> 
	<col width="30"> 
	<col width="50"> 
	<col width="120"> 
	<col width="120"> 
	<col width="120"> 
	<col width="120"> 
	<col width="120"> 
	<col width="150"> 
	<col width="120"> 
	<col width="120"> 
	<col width="120"> 
	<col width="120"> 
	<col width="120"> 
	<col> 
	</colgroup> 
	<thead>
	<tr>
	<th scope="col" class="side1"><img src="<?php echo $g['img_core']?>/_public/ico_check_01.gif" class="hand" alt="" onclick="chkFlag('post_members[]');" /></th>
	<th scope="col"></th>
	<th scope="col">담당자 이름</th>
	<th scope="col">소속/기관</th>
	<th scope="col">프로그램</th>
	<th scope="col">연락처</th>
	<th scope="col">메일주소</th>
	<th scope="col">교육일시</th>
	<th scope="col">진행교시</th>
	<th scope="col">학생규모</th>
	<th scope="col">상태</th>
	<th scope="col">신청일</th>
	<th scope="col"></th>
	<th scope="col" class="side2"></th>
	</tr>
	</thead>
	<tbody>

	<?php while($R=db_fetch_array($RCD)):?>
	<?php $R['mobile']=isMobileConnect($R['agent'])?>
	<tr>
	<td><input type="checkbox" name="post_members[]" value="<?php echo $R['uid']?>" /></td>
	<td>
		<?php if($R['uid'] != $uid):?>
		<?php echo $NUM-((($p-1)*$recnum)+$_rec++)?>
		<?php else:$_rec++?>
		<span class="now">&gt;&gt;</span>
		<?php endif?>
	</td>
	<td>
		<?php if($R['notice']):?><img src="<?php echo $g['img_module_admin']?>/ico_notice.gif" class="imgpos1" alt="공지글" title="공지글" /><?php endif?>
		<?php if($R['mobile']):?><img src="<?php echo $g['img_core']?>/_public/ico_mobile.gif" class="imgpos" alt="모바일" title="모바일(<?php echo $R['mobile']?>)로 등록된 글입니다" /><?php endif?>
		<?php if($R['category']):?><span class="cat">[<?php echo $R['category']?>]</span><?php endif?>
		<a href="<?php echo getPostLink($R)?>" target="_blank"><?php echo $R['name']?></a>
		<?php if(strstr($R['content'],'.jpg')):?><img src="<?php echo $g['img_core']?>/_public/ico_pic.gif" class="imgpos" alt="사진" title="사진" /><?php endif?>
		<?php if($R['upload']):?><img src="<?php echo $g['img_core']?>/_public/ico_file.gif" class="imgpos" alt="첨부파일" title="첨부파일" /><?php endif?>
		<?php if($R['hidden']):?><img src="<?php echo $g['img_core']?>/_public/ico_hidden.gif" class="imgpos" alt="비밀글" title="비밀글" /><?php endif?>
		<?php if($R['comment']):?><span class="comment">[<?php echo $R['comment']?><?php if($R['oneline']):?>+<?php echo $R['oneline']?><?php endif?>]</span><?php endif?>
		<?php if($R['trackback']):?><span class="trackback">[<?php echo $R['trackback']?>]</span><?php endif?>
		<?php if(getNew($R['d_regis'],24)):?><span class="new">new</span><?php endif?>
	</td>
	<td><?php echo $R['a_group']?></td>
	<td><?php echo $programs[$R['program']]?></td>
	<td class="hit b"><?php echo $R['tel']?></td>
	<td><?php echo $R['email']?></td>
	<td><?=getDateFormat($R['start_date'],'Y.m.d')?> ~ <?=getDateFormat($R['end_date'],'Y.m.d')?></td>
	<td><?php echo $R['many_times']?></td>
	<td><?php echo $R['std_num']?></td>
	<td><?php echo $step[$R['step']]?></td>
	<td><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
	<td><input type="button" class="bluebtn" value="조회" onclick="OpenWindow('/?r=home&iframe=Y&m=dalkkum&front=manager&page=view_event_apply&uid=<?=$R['uid']?>');"></td>
	<td></td>
	</tr> 
	<?php endwhile?> 

	<?php if(!$NUM):?>
	<tr>
	<td><input type="checkbox" disabled="disabled" /></td>
	<td colspan="10">표시할 목록이 없습니다.</td>
	<td></td>
	</tr> 
	<?php endif?>

	</tbody>
	</table>

	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'<?php echo $g['img_core']?>/page/default');</script>
	</div>

	<!--
	<input type="button" value="선택/해제" class="btngray" onclick="chkFlag('post_members[]');" />
	<input type="button" value="삭제" class="btnblue" onclick="actCheck('multi_delete');" />
	<input type="button" value="복사" class="btnblue" onclick="actCheck('multi_copy');" />
	<input type="button" value="이동" class="btnblue" onclick="actCheck('multi_move');" />
	-->
	</form>



</div>


<script type="text/javascript">
//<![CDATA[
function dropDate(date1,date2)
{
	var f = document.procForm;
	f.year1.value = date1.substring(0,4);
	f.month1.value = date1.substring(4,6);
	f.day1.value = date1.substring(6,8);
	
	f.year2.value = date2.substring(0,4);
	f.month2.value = date2.substring(4,6);
	f.day2.value = date2.substring(6,8);

	f.submit();
}
function actCheck(act)
{
	var f = document.listForm;
    var l = document.getElementsByName('post_members[]');
    var n = l.length;
	var j = 0;
    var i;
	var s = '';

    for (i = 0; i < n; i++)
	{
		if(l[i].checked == true)
		{
			j++;
			s += '['+l[i].value+']';
		}
	}
	if (!j)
	{
		alert('선택된 게시물이 없습니다.      ');
		return false;
	}
	
	if (act == 'multi_delete')
	{
		if(confirm('정말로 삭제하시겠습니까?    '))
		{
			f.a.value = act;
			f.submit();
		}
	}
	else {
		OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=<?php echo $m?>&module=<?php echo $module?>&front=movecopy&type='+act+'&postuid='+s);
	}
	return false;
}
//]]>
</script>
