<?php
$recnum = 15;
$catque = "pagetype>1";
if ($cat) $catque .= " and category='".$cat."'";
if ($_keyw) $catque .= " and ".$where." like '".$_keyw."%'";
$PAGES = getDbArray($table['s_page'],$catque,'*','uid','asc',$recnum,$p);
$NUM = getDbRows($table['s_page'],$catque);
$TPG = getTotalPage($NUM,$recnum);
?>


<div id="mjointbox">

	<div class="title">
		<form action="<?php echo $g['s']?>/" method="get">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="system" value="<?php echo $system?>" />
		<input type="hidden" name="iframe" value="<?php echo $iframe?>" />
		<input type="hidden" name="dropfield" value="<?php echo $dropfield?>" />
		<input type="hidden" name="smodule" value="<?php echo $smodule?>" />
		<input type="hidden" name="cmodule" value="<?php echo $cmodule?>" />
		<input type="hidden" name="p" value="<?php echo $p?>" />

		<select name="cat" class="cat" onchange="this.form.submit();">
		<option value="">&nbsp;+ 페이지분류</option>
		<option value="">------------------</option>
		<?php $_cats=array()?>
		<?php $CATS=db_query("select *,count(*) as cnt from ".$table['s_page']." group by category",$DB_CONNECT)?>
		<?php while($C=db_fetch_array($CATS)):$_cats[]=$C['category']?>
		<option value="<?php echo $C['category']?>"<?php if($C['category']==$cat):?> selected="selected"<?php endif?>>ㆍ<?php echo $C['category']?> (<?php echo $C['cnt']?>)</option>
		<?php endwhile?>
		</select>
 
		<select name="where">
		<option value="name"<?php if($where == 'name'):?> selected="selected"<?php endif?>>페이지명</option>
		<option value="id"<?php if($where == 'id'):?> selected="selected"<?php endif?>>페이지코드</option>
		</select>
		
		<input type="text" name="_keyw" size="10" value="<?php echo addslashes($_keyw)?>" class="input" />
		<input type="submit" value=" 검색 " class="btngray" />
		<input type="button" value=" 리셋 " class="btngray" onclick="this.form.p.value=1;this.form.cat.value='';this.form._keyw.value='';this.form.submit();" />
		
		</form>

	</div>

	<?php if($NUM):?>
	<table>
		<?php while($PR = db_fetch_array($PAGES)):?>
		<tr>
		<td class="name"><a href="<?php echo RW('mod='.$PR['id'])?>" target="_blank" title="페이지보기"><?php echo $PR['name']?></a><span>(<?php echo $PR['id']?>)</span></td>
		<td class="aply"><input type="button" value="연결" class="btnblue" onclick="dropJoint('<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $smodule?>&mod=<?php echo $PR['id']?>');" /></td>
		</tr>
		<?php endwhile?>
	</table>

	<div class="pagebox01">
		<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'<?php echo $g['img_core']?>/page/default');</script>
	</div>	
	<?php endif?>

</div>

<style type="text/css">
#mjointbox {}
#mjointbox .title {border-bottom:#dfdfdf dashed 1px;padding:0 0 10px 0;margin:0 0 20px 0;}
#mjointbox .title .cat {width:120px;}
#mjointbox table {width:100%;}
#mjointbox table .name {}
#mjointbox table .name span {font-size:11px;font-family:arial;color:#c0c0c0;padding:0 0 0 3px;}
#mjointbox table .aply {text-align:right;}
#mjointbox .pagebox01 {text-align:center;padding:15px 0 15px 0;margin:15px 0 0 0;border-top:#efefef solid 1px;}
</style>