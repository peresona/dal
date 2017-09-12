<?php
$_MH = getUidData($table['s_mbrid'],$option);
$_MH = array_merge(getDbData($table['s_mbrdata'],"memberuid='".$_MH['uid']."'",'*'),$_MH);
?>


[RESULT:

<?php if($type=='post'):?>
<ul class="xrecent1">
<?php $_RCD=getDbArray($table['bbsdata'],'site='.$s.' and mbruid='.$_MH['uid'],'*','gid','asc',10,1)?>
<?php while($_R=db_fetch_array($_RCD)):?>
<?php $_B=getUidData($table['bbslist'],$_R['bbs'])?>
<?php $_L=getOverTime($date['totime'],$_R['d_regis'])?>
<li>
<a href="<?php echo getPostLink($_R)?>" class="sbj">
<?php echo $_R['subject']?>
<?php if($_R['comment']):?> <span class="comment">(<?php echo $_R['comment']?><?php if($_R['oneline']):?>+<?php echo $_R['oneline']?><?php endif?>)</span><?php endif?>
</a>
<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=bbs&amp;bid=<?php echo $_B['id']?>" class="link"><?php echo $_B['name']?></a>에서
<?php echo $_L[1]<3?$_L[0].$lang['sys']['time'][$_L[1]].'전':getDateFormat($_R['d_regis'],'Y.m.d ')?>에 남김<?php if($_R['comment']):?><span class="comment"> , 댓글 <?php echo $_R['comment']?><?php if($_R['oneline']):?>+<?php echo $_R['oneline']?><?php endif?>개 있음</span><?php endif?>

</li>
<?php endwhile?>
<?php if(!db_num_rows($_RCD)):?>
<li class="none">작성한 게시글이 없습니다.</li>
<?php endif?>
</ul>
<?php endif?>


<?php if($type=='comment'):?>
<ul class="xrecent1">
<?php $_RCD = getDbArray($table['s_comment'],'site='.$s.' and mbruid='.$_MH['uid'],'*','uid','asc',10,1)?>
<?php while($_R=db_fetch_array($_RCD)):?>
<?php $_G=getUidData($table['bbsdata'],str_replace('bbs','',$_R['parent']))?>
<?php $_B=getUidData($table['bbslist'],$_G['bbs'])?>
<?php $_L=getOverTime($date['totime'],$_R['d_regis'])?>
<li>
<a href="<?php echo getCyncUrl($_R['cync'].',CMT:'.$_R['uid'])?>#CMT" class="sbj">
<?php echo $_R['subject']?>
<?php if($_R['oneline']):?> <span class="comment">(<?php echo $_R['oneline']?>)</span><?php endif?>
</a>
<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=bbs&amp;bid=<?php echo $_B['id']?>" class="link"><?php echo $_B['name']?></a>에서 <?php echo $_G[$_HS['nametype']]?>님의 게시물에
<?php echo $_L[1]<3?$_L[0].$lang['sys']['time'][$_L[1]].'전':getDateFormat($_R['d_regis'],'Y.m.d ')?>에 남김<?php if($_R['oneline']):?><span class="comment"> , 덧글 <?php echo $_R['oneline']?>개 있음</span><?php endif?>

</li>
<?php endwhile?>
<?php if(!db_num_rows($_RCD)):?>
<li class="none">작성한 댓글이 없습니다.</li>
<?php endif?>
</ul>
<?php endif?>

:RESULT]
