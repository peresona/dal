<?php
if(!defined('__KIMS__')) exit;

include_once $g['path_core'].'function/thumb.func.php';
include_once $g['dir_module'].'var/var.php';

$sessArr	= explode('_',$sess_Code);
$tmpcode	= $sessArr[0];
$mbruid		= $sessArr[1];
$url		= $g['url_root'].'/files/';
$saveDir = $g['path_file'].'/';// <!-- 포토 업로드 폴더 -->

// 업로드 디렉토리 없는 경우 추가 
if(!is_dir($saveDir)){
   mkdir($saveDir,0707);
   @chmod($saveDir,0707);
}
foreach($_FILES as $file){
		$name		= strtolower($file['name']);
		$size		= $file['size'];
		$width		= 0;
		$height		= 0;
		$caption	= trim($caption);
		$down		= 0;
		$d_regis	= $date['totime'];
		$d_update	= '';
		$fileExt	= getExt($name);
		$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;
		$type		= getFileType($fileExt);
		$tmpname	= md5($name).substr($date['totime'],8,14);
		$tmpname	= ($type == 1 || $type == 2) ? $tmpname.'.'.$fileExt : $tmpname;
		$hidden		= 1;


		$savePath1	= $saveDir.substr($date['today'],0,4);
		$savePath2	= $savePath1.'/'.substr($date['today'],4,2);
		$savePath3	= $savePath2.'/'.substr($date['today'],6,2);
		$folder		= substr($date['today'],0,4).'/'.substr($date['today'],4,2).'/'.substr($date['today'],6,2);

			for ($i = 1; $i < 4; $i++)
			{
				if (!is_dir(${'savePath'.$i}))
				{
					mkdir(${'savePath'.$i},0707);
					@chmod(${'savePath'.$i},0707);
				}
			}

			$saveFile = $savePath3.'/'.$tmpname;
			$saveFile2 = $g['path_file'].$folder.'/'.$tmpname;

/* test */

	@ini_set('memory_limit', '512M');

    switch ($fileExt) {
        case 'jpg':
            $image = imagecreatefromjpeg($file['tmp_name']);
            break;
        case 'jpeg':
            $image = imagecreatefromjpeg($file['tmp_name']);
            break;
        case 'png':
            $image = imagecreatefrompng($file['tmp_name']);
            break;
        case 'gif':
            $image = imagecreatefromgif($file['tmp_name']);
            break;
        default:
            $image = imagecreatefromjpeg($file['tmp_name']);
    }


	$exif = exif_read_data($file['tmp_name']);

	if($exif['Orientation'] == '8'){
		$image_r = imagerotate($image,90,0);
	}elseif($exif['Orientation'] == '3'){
		$image_r = imagerotate($image,180,0);
	}elseif($exif['Orientation'] == '6'){
		$image_r = imagerotate($image,-90,0);
	}else{
		$image_r = $image;
	}

	/* 이미지 업로드 */
    imagejpeg($image_r, $saveFile2);
    switch ($fileExt) {
        case 'jpg':
            imagejpeg($image_r, $saveFile2);
            break;
        case 'jpeg':
            imagejpeg($image_r, $saveFile2);
            break;
        case 'png':
            imagepng($image_r, $saveFile2);
            break;
        case 'gif':
            imagegif($image_r, $saveFile2);
            break;
        default:
            imagejpeg($image_r, $saveFile2);
    }

	imagedestroy($image);
	imagedestroy($image_r);
	@chmod($saveFile2,0707);

	/* 썸네일 생성 */
	$thumbname = md5($tmpname).'.'.$fileExt;
	$thumbFile = $savePath3.'/'.$thumbname;
	ResizeWidth($saveFile2,$thumbFile,150);
	@chmod($thumbFile,0707);
	$IM = getimagesize($saveFile2);
	$width = $IM[0];
	$height= $IM[1];

	$mingid = getDbCnt($table['s_upload'],'min(gid)','');
	$gid = $mingid ? $mingid - 1 : 100000000;

	$QKEY = "gid,hidden,tmpcode,site,mbruid,type,ext,fserver,url,folder,name,tmpname,thumbname,size,width,height,caption,down,d_regis,d_update,cync";
	$QVAL = "'$gid','$hidden','$tmpcode','$s','$mbruid','$type','$fileExt','$fserver','$url','$folder','$name','$tmpname','$thumbname','$size','$width','$height','$caption','$down','$d_regis','$d_update','$cync'";
	getDbInsert($table['s_upload'],$QKEY,$QVAL);
	$_addnum = db_insert_id($DB_CONNECT);
	getDbUpdate($table['s_numinfo'],'upload=upload+1',"date='".$date['today']."' and site=".$s);
	if ($gid == 100000000) db_query("OPTIMIZE TABLE ".$table['s_upload'],$DB_CONNECT); 

}

echo '/files/'.substr($d_regis, 0,4).'/'.substr($d_regis, 4,2).'/'.substr($d_regis, 6,2).'/'.$tmpname."|".$width."|".$_addnum."|".$type."|".$exif['Orientation'];
exit;
?>