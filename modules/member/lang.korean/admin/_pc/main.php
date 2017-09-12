<?php
function getMDname($id)
{
	global $typeset;
	if ($typeset[$id]) return $typeset[$id].' ('.$id.')';
	else return $id;
}
$typeset = array
(
	'_join'=>'회원가입축하 양식',
	'_auth'=>'이메일인증 양식',
	'_pw'=>'비밀번호요청 양식',
);

$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,1);
$year1	= $year1  ? $year1  : '2001';
$month1	= $month1 ? $month1 : substr($date['today'],4,2);
$day1	= $day1   ? $day1   : 1;//substr($date['today'],6,2);
$year2	= $year2  ? $year2  : substr($date['today'],0,4);
$month2	= $month2 ? $month2 : substr($date['today'],4,2);
$day2	= $day2   ? $day2   : substr($date['today'],6,2);


$sort	= $sort ? $sort : 'memberuid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;

$accountQue = $account ? 'site='.$account.' and ':'';
//사이트선택적용
//$accountQue = $account ? 'a.site='.$account.' and ':'';
$_WHERE = $accountQue.'d_regis > '.$year1.sprintf('%02d',$month1).sprintf('%02d',$day1).'000000 and d_regis < '.$year2.sprintf('%02d',$month2).sprintf('%02d',$day2).'240000';
if ($auth) $_WHERE .= ' and auth='.$auth;
if ($sosok) $_WHERE .= ' and sosok='.$sosok;
if ($level) $_WHERE .= ' and level='.$level;
if ($now_log) $_WHERE .= ' and now_log='.($now_log-1);
if ($sex) $_WHERE .= ' and sex='.$sex;
if ($comp) $_WHERE .= ' and comp='.$comp;
if (!$mentor_all) $_WHERE .= ' and not(mentor_confirm="Y")';

if ($marr1)
{
	if ($marr1==1) $_WHERE .= ' and marr1=0';
	else $_WHERE .= ' and marr1>0';
}
if ($mailing) $_WHERE .= ' and mailing='.($mailing-1);
if ($sms) $_WHERE .= ' and sms='.($sms-1);

if ($addr0)
{
	$_WHERE .= $addr0!='NULL'?" and addr0='".$addr0."'":" and addr0=''";
}

if ($where && $keyw) $_WHERE .= " and replace(".$where.",' ','') like '%".trim($keyw)."%'";

//사이트선택적용
//$RCD = getDbArray($table['s_mbrdata'].' AS a left join '.$table['s_mbrid'].' AS b on memberuid=uid',$_WHERE,'a.*,b.uid,b.id,b.pw',$sort,$orderby,$recnum,$p);
//$NUM = getDbRows($table['s_mbrdata'].' AS a left join '.$table['s_mbrid'].' AS b on memberuid=uid',$_WHERE);


$RCD = getDbArray($table['s_mbrdata'].' left join '.$table['s_mbrid'].' on memberuid=uid',$_WHERE,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_mbrdata'].' left join '.$table['s_mbrid'].' on memberuid=uid',$_WHERE);

//$RCD = getDbArray($table['s_mbrdata'],$_WHERE,'*',$sort,$orderby,$recnum,$p);
//$NUM = getDbRows($table['s_mbrdata'],$_WHERE);
$TPG = getTotalPage($NUM,$recnum);
$autharr = array('','인증','보류','대기','탈퇴');

$xyear1	= substr($date['totime'],0,4);
$xmonth1= substr($date['totime'],4,2);
$xday1	= substr($date['totime'],6,2);
$xhour1	= substr($date['totime'],8,2);
$xmin1	= substr($date['totime'],10,2);
?>


<div id="mbrlist">


	<div class="sbox">
		<form name="procForm" action="<?php echo $g['s']?>/" method="get">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $m?>" />
		<input type="hidden" name="module" value="<?php echo $module?>" />
		<input type="hidden" name="front" value="<?php echo $front?>" />

		<select name="account" class="account" onchange="this.form.submit();">
		<option value="">&nbsp;+ 전체사이트</option>
		<option value="">---------------------------</option>
		<?php while($S = db_fetch_array($SITES)):?>
		<option value="<?php echo $S['uid']?>"<?php if($account==$S['uid']):?> selected="selected"<?php endif?>>ㆍ<?php echo $S['name']?></option>
		<?php endwhile?>
		<?php if(!db_num_rows($SITES)):?>
		<option value="">등록된 사이트가 없습니다.</option>
		<?php endif?>
		</select>

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
		<input type="button" class="btngray" value="전체" onclick="dropDate('20010101','<?php echo $date['today']?>');" />
		</div>

		<div>

		<select name="auth" onchange="this.form.submit();">
		<option value="">회원인증</option>
		<option value="">--------</option>
		<option value="1"<?php if($auth == 1):?> selected="selected"<?php endif?>><?php echo $autharr[1]?></option>
		<option value="2"<?php if($auth == 2):?> selected="selected"<?php endif?>><?php echo $autharr[2]?></option>
		<option value="3"<?php if($auth == 3):?> selected="selected"<?php endif?>><?php echo $autharr[3]?></option>
		<option value="4"<?php if($auth == 4):?> selected="selected"<?php endif?>><?php echo $autharr[4]?></option>
		</select>

		<select name="sosok" onchange="this.form.submit();">
		<option value="">회원그룹</option>
		<option value="">--------</option>
		<?php $_GRPARR = array()?>
		<?php $GRP = getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
		<?php while($_G=db_fetch_array($GRP)):$_GRPARR[$_G['uid']] = $_G['name']?>
		<option value="<?php echo $_G['uid']?>"<?php if($_G['uid']==$sosok):?> selected="selected"<?php endif?>><?php echo $_G['name']?> (<?php echo number_format($_G['num'])?>)</option>
		<?php endwhile?>
		</select>

		<select name="level" onchange="this.form.submit();">
		<option value="">회원등급</option>
		<option value="">--------</option>
		<?php $_LVLARR = array()?>
		<?php $levelnum = getDbData($table['s_mbrlevel'],'gid=1','*')?>
		<?php $LVL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',$levelnum['uid'],1)?>
		<?php while($_L=db_fetch_array($LVL)):$_LVLARR[$_L['uid']] = $_L['name']?>
		<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$level):?> selected="selected"<?php endif?>><?php echo $_L['name']?> (<?php echo number_format($_L['num'])?>)</option>
		<?php endwhile?>
		</select>

		<select name="sex" onchange="this.form.submit();">
		<option value="">회원성별</option>
		<option value="">--------</option>
		<option value="1"<?php if($sex == 1):?> selected="selected"<?php endif?>>남성</option>
		<option value="2"<?php if($sex == 2):?> selected="selected"<?php endif?>>여성</option>
		</select>

		<select name="addr0" onchange="this.form.submit();">
		<option value="">가입지역</option>
		<option value="">--------</option>
		<option value="서울"<?php if($addr0 == '서울'):?> selected="selected"<?php endif?>>서울</option>
		<option value="경기"<?php if($addr0 == '경기'):?> selected="selected"<?php endif?>>경기</option>
		<option value="인천"<?php if($addr0 == '인천'):?> selected="selected"<?php endif?>>인천</option>
		<option value="강원"<?php if($addr0 == '강원'):?> selected="selected"<?php endif?>>강원</option>
		<option value="충남"<?php if($addr0 == '충남'):?> selected="selected"<?php endif?>>충남</option>
		<option value="충북"<?php if($addr0 == '충북'):?> selected="selected"<?php endif?>>충북</option>
		<option value="대전"<?php if($addr0 == '대전'):?> selected="selected"<?php endif?>>대전</option>
		<option value="전남"<?php if($addr0 == '전남'):?> selected="selected"<?php endif?>>전남</option>
		<option value="전북"<?php if($addr0 == '전북'):?> selected="selected"<?php endif?>>전북</option>
		<option value="광주"<?php if($addr0 == '광주'):?> selected="selected"<?php endif?>>광주</option>
		<option value="경남"<?php if($addr0 == '경남'):?> selected="selected"<?php endif?>>경남</option>
		<option value="경북"<?php if($addr0 == '경북'):?> selected="selected"<?php endif?>>경북</option>
		<option value="부산"<?php if($addr0 == '부산'):?> selected="selected"<?php endif?>>부산</option>
		<option value="대구"<?php if($addr0 == '대구'):?> selected="selected"<?php endif?>>대구</option>
		<option value="울산"<?php if($addr0 == '울산'):?> selected="selected"<?php endif?>>울산</option>
		<option value="제주"<?php if($addr0 == '제주'):?> selected="selected"<?php endif?>>제주</option>
		<option value="해외"<?php if($addr0 == '해외'):?> selected="selected"<?php endif?>>해외</option>
		<option value="NULL"<?php if($addr0 == 'NULL'):?> selected="selected"<?php endif?>>없음</option>
		</select>

		<select name="now_log" onchange="this.form.submit();">
		<option value="">현재접속</option>
		<option value="">--------</option>
		<option value="2"<?php if($now_log == 2):?> selected="selected"<?php endif?>>온라인</option>
		<option value="1"<?php if($now_log == 1):?> selected="selected"<?php endif?>>오프라인</option>
		</select>

		<select name="marr1" onchange="this.form.submit();">
		<option value="">결혼여부</option>
		<option value="">--------</option>
		<option value="1"<?php if($marr1 == 1):?> selected="selected"<?php endif?>>미혼</option>
		<option value="2"<?php if($marr1 == 2):?> selected="selected"<?php endif?>>기혼</option>
		</select>

		<select name="mailing" onchange="this.form.submit();">
		<option value="">메일수신</option>
		<option value="">--------</option>
		<option value="2"<?php if($mailing == 2):?> selected="selected"<?php endif?>>동의</option>
		<option value="1"<?php if($mailing == 1):?> selected="selected"<?php endif?>>동의안함</option>
		</select>

		<select name="sms" onchange="this.form.submit();">
		<option value="">문자수신</option>
		<option value="">--------</option>
		<option value="2"<?php if($sms == 2):?> selected="selected"<?php endif?>>동의</option>
		<option value="1"<?php if($sms == 1):?> selected="selected"<?php endif?>>동의안함</option>
		</select>

		</div>

		<div>
		<select name="sort" onchange="this.form.submit();">
		<option value="memberuid"<?php if($sort=='memberuid'):?> selected="selected"<?php endif?>>가입일</option>
		<option value="sosok"<?php if($sort=='sosok'):?> selected="selected"<?php endif?>>회원그룹</option>
		<option value="level"<?php if($sort=='level'):?> selected="selected"<?php endif?>>회원등급</option>
		<option value="point"<?php if($sort=='point'):?> selected="selected"<?php endif?>>보유포인트</option>
		<option value="usepoint"<?php if($sort=='usepoint'):?> selected="selected"<?php endif?>>사용포인트</option>
		<option value="cash"<?php if($sort=='cash'):?> selected="selected"<?php endif?>>보유적립금</option>
		<option value="money"<?php if($sort=='money'):?> selected="selected"<?php endif?>>보유예치금</option>
		<option value="last_log"<?php if($sort=='last_log'):?> selected="selected"<?php endif?>>최근접속</option>
		<option value="birth1"<?php if($sort=='birth1'):?> selected="selected"<?php endif?>>나이</option>
		<option value="birth2"<?php if($sort=='birth2'):?> selected="selected"<?php endif?>>생년월일</option>
		</select>
		<select name="orderby" onchange="this.form.submit();">
		<option value="desc"<?php if($orderby=='desc'):?> selected="selected"<?php endif?>>역순</option>
		<option value="asc"<?php if($orderby=='asc'):?> selected="selected"<?php endif?>>정순</option>
		</select>

		<select name="recnum" onchange="this.form.submit();">
		<option value="20"<?php if($recnum==20):?> selected="selected"<?php endif?>>20명</option>
		<option value="35"<?php if($recnum==35):?> selected="selected"<?php endif?>>35명</option>
		<option value="50"<?php if($recnum==50):?> selected="selected"<?php endif?>>50명</option>
		<option value="75"<?php if($recnum==75):?> selected="selected"<?php endif?>>75명</option>
		<option value="90"<?php if($recnum==90):?> selected="selected"<?php endif?>>90명</option>
		</select>
		<select name="where">
		<option value="id"<?php if($where=='id'):?> selected="selected"<?php endif?>>아이디</option>
		<option value="name"<?php if($where=='name'):?> selected="selected"<?php endif?>>이름</option>
		<option value="nic"<?php if($where=='nic'):?> selected="selected"<?php endif?>>닉네임</option>
		</select>

		<input type="text" name="keyw" value="<?php echo stripslashes($keyw)?>" class="input" />

		<input type="submit" value="검색" class="btnblue" />
		<input type="button" value="리셋" class="btngray" onclick="location.href='<?php echo $g['adm_href']?>';" />

		<input type="checkbox" name="comp" id="compmember" value="1"<?php if($comp=='1'):?> checked="checked"<?php endif?> onclick="this.form.submit();" /><label for="compmember">기업회원</label>
		<input type="checkbox" name="wideview" id="wideview" value="Y"<?php if($wideview=='Y'):?> checked="checked"<?php endif?> onclick="this.form.submit();" /><label for="wideview">와이드뷰</label>
		</div>

		</form>
	</div>


	<div class="info">

		<div class="article">
			<?php echo number_format($NUM)?>명(<?php echo $p?>/<?php echo $TPG?>페이지)
		</div>
		
		<div class="category">

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
	<col width="30"> 
	<col width="30"> 
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
	<th scope="col">인증</th>
	<th scope="col">접속</th>
	<th scope="col">이름</th>
	<th scope="col">닉네임</th>
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
	<td><?php echo $autharr[$R['auth']]?></td>
	<td><?php echo $R['now_log']?'Y':'N'?></td>
	<td><a href="javascript:OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=<?php echo $module?>&front=manager&page=main&mbruid=<?php echo $R['memberuid']?>');" title="회원메니져"><?php echo $R['name']?></a></td>
	<td><a href="javascript:OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=<?php echo $module?>&front=manager&page=post&mbruid=<?php echo $R['memberuid']?>');" title="게시정보"><?php echo $R['nic']?></a></td>
	<td><a href="javascript:OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=<?php echo $module?>&front=manager&page=info&mbruid=<?php echo $R['memberuid']?>');" title="회원정보"><?php echo $_R['id']?></a></td>
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
	<div class="nodata"><img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" /> 조건에 해당하는 회원이 없습니다.</div>
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
		<?php $tdir = $g['path_module'].$module.'/doc/'?>
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
function ToolCheck(compo)
{
	frames.editFrame.showCompo();
	frames.editFrame.EditBox(compo);
}
function maildocLoad(obj)
{
	if (obj.value)
	{
		frames._action_frame_<?php echo $m?>.location.href = "<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $module?>&a=maildoc_load&type=" + obj.value;
		obj.value = '';
		obj.form.subject.focus();
	}
}
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
	//회원삭제
	if (flag == 'tool_delete')
	{

	}
	//회원탈퇴
	if (flag == 'tool_out')
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
	//이메일추출
	if (flag == 'dump_email')
	{

	}
	//연락처추출
	if (flag == 'dump_tel')
	{

	}
	//DM추출
	if (flag == 'dump_address')
	{

	}
	//전체데이터추출
	if (flag == 'dump_alldata')
	{

	}

	if (confirm('정말로 실행하시겠습니까?        '))
	{
		submitFlag = true;
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
