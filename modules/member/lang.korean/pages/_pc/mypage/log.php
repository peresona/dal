<?php
include_once $g['dir_module_skin'].'_menu.php';

$year1	= $year1  ? $year1  : substr($date['today'],0,4);
$month1	= $month1 ? $month1 : substr($date['today'],4,2);
$day1	= $day1   ? $day1   : 1;//substr($date['today'],6,2);
$year2	= $year2  ? $year2  : substr($date['today'],0,4);
$month2	= $month2 ? $month2 : substr($date['today'],4,2);
$day2	= $day2   ? $day2   : substr($date['today'],6,2);

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;

$sqlque = 'mbruid='.$my['uid'].' and site='.$s;
$sqlque = $sqlque.' and d_regis > '.$year1.sprintf('%02d',$month1).sprintf('%02d',$day1).'000000 and d_regis < '.$year2.sprintf('%02d',$month2).sprintf('%02d',$day2).'240000';

if ($where && $keyword)
{
	$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray($table['s_referer'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_referer'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);

?>



<div id="loglist">

	<form name="bbssearchf" action="<?php echo $g['s']?>/">
	<input type="hidden" name="r" value="<?php echo $r?>" />

	<div class="info">

		<div class="article">
			<?php echo number_format($NUM)?>건(<?php echo $p?>/<?php echo $TPG?>페이지)
		</div>
		<div class="category">


			<select name="year1" class="big">
			<?php for($i=$date['year'];$i>2009;$i--):?><option value="<?php echo $i?>"<?php if($year1==$i):?> selected="selected"<?php endif?>><?php echo $i?>년</option><?php endfor?>
			</select>
			<select name="month1" class="big">
			<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($month1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>월</option><?php endfor?>
			</select>
			<select name="day1" class="big">
			<?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($day1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>일(<?php echo getWeekday(date('w',mktime(0,0,0,$month1,$i,$year1)))?>)</option><?php endfor?>
			</select> ~
			<select name="year2" class="big">
			<?php for($i=$date['year'];$i>2009;$i--):?><option value="<?php echo $i?>"<?php if($year2==$i):?> selected="selected"<?php endif?>><?php echo $i?>년</option><?php endfor?>
			</select>
			<select name="month2" class="big">
			<?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($month2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>월</option><?php endfor?>
			</select>
			<select name="day2" class="big">
			<?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($day2==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>일(<?php echo getWeekday(date('w',mktime(0,0,0,$month2,$i,$year2)))?>)</option><?php endfor?>
			</select>

			<input type="button" class="btngray" value="기간적용" onclick="this.form.submit();" style="height: 30px;" />


		</div>
	</div>

	<table summary="접속기록 리스트입니다.">
	<caption>접속기록</caption> 
	<colgroup> 
	<col width="70"> 
	<col width="150"> 
	<col> 
	<col width="120"> 
	<col width="110"> 
	</colgroup> 
	<thead>
	<tr>
	<th scope="col" class="side1">번호</th>
	<th scope="col">아이피</th>
	<th scope="col">접속경로</th>
	<th scope="col">브라우져</th>
	<th scope="col" class="side2">날짜</th>
	</tr>
	</thead>
	<tbody>

	<?php while($R=db_fetch_array($RCD)):?>
	<?php $_browse = getBrowzer($R['agent'])?>
	<tr>
	<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
	<td class="sbj"><a href="#." onclick="whoisSearch('<?php echo $R['ip']?>');" title="후이즈 IP정보"><?php echo $R['ip']?></a></td>
	<td class="cat"><a href="<?php echo $R['referer']?>" target="_blank" title="<?php echo $R['referer']?>"><?php echo getDomain($R['referer'])?></a></td>
	<td class="agent">
		<?php if($_browse=='Mobile'):?>
		<img src="<?php echo $g['img_core']?>/_public/ico_mobile.gif" class="imgpos" alt="모바일" title="모바일(<?php echo isMobileConnect($R['agent'])?>)접속" />
		<?php endif?>		
		<?php echo strtoupper($_browse)?>
	</td>
	<td><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
	</tr> 
	<?php endwhile?> 

	<?php if(!$NUM):?>
	<tr>
	<td>1</td>
	<td class="sbj1" colspan="5">접속기록이 없습니다.</td>
	</tr> 
	<?php endif?>

	</tbody>
	</table>
	

	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'<?php echo $g['img_core']?>/page/default');</script>
	</div>

	<div class="searchform">
		<?php if($_mod):?>
		<input type="hidden" name="mod" value="<?php echo $_mod?>" />
		<?php else:?>
		<input type="hidden" name="m" value="<?php echo $m?>" />
		<input type="hidden" name="front" value="<?php echo $front?>" />
		<?php endif?>
		<input type="hidden" name="page" value="<?php echo $page?>" />
		<input type="hidden" name="sort" value="<?php echo $sort?>" />
		<input type="hidden" name="orderby" value="<?php echo $orderby?>" />
		<input type="hidden" name="recnum" value="<?php echo $recnum?>" />
		<input type="hidden" name="type" value="<?php echo $type?>" />
		<input type="hidden" name="iframe" value="<?php echo $iframe?>" />
		<input type="hidden" name="skin" value="<?php echo $skin?>" />

		<select name="where">
		<option value="ip"<?php if($where=='ip'):?> selected="selected"<?php endif?>>아이피</option>
		<option value="referer"<?php if($where=='referer'):?> selected="selected"<?php endif?>>접속경로</option>
		</select>
		
		<input type="text" name="keyword" size="30" value="<?php echo $_keyword?>" class="input" />
		<input type="submit" value="검색" class="btngray" />
		<input type="button" value="리셋" class="btngray" onclick="goHref('<?php echo $g['url_page']?>');" />
	</div>
	
	</form>


	<form name="whois_search_form">
	<input type="hidden" name="domain_name" value="" />
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
function whoisSearch(ip)
{
	var f = document.whois_search_form;

		f.domain_name.value = ip;
		f.target	= "_blank";
		f.method	= "post";
		f.action	= "http://whois.kisa.or.kr/result.php";
		f.submit();
}
//]]>
</script>
