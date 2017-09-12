<?php
if(!defined('__KIMS__')) exit;
include_once $g['path_core'].'function/thumb.func.php';
include_once $g['dir_module'].'var/var.php';

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
		$tmpname	= 'tmp_'.$tmpname.'.'.$fileExt;
		$hidden		= 1;
		if($objName == 'mypic_change'){
			$saveFile1	= $g['path_var'].'simbol/'.$tmpname;
			$saveFile2	= $g['path_var'].'simbol/180.'.$tmpname;
		}elseif($objName == 'iphoto_change'){
			$saveFile1	= $g['path_var'].'iphoto/'.$tmpname;
			$saveFile2	= $g['path_var'].'iphoto/360.'.$tmpname;
		}


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
    imagejpeg($image_r, $saveFile1);
    switch ($fileExt) {
        case 'jpg':
            imagejpeg($image_r, $saveFile1);
            break;
        case 'jpeg':
            imagejpeg($image_r, $saveFile1);
            break;
        case 'png':
            imagepng($image_r, $saveFile1);
            break;
        case 'gif':
            imagegif($image_r, $saveFile1);
            break;
        default:
            imagejpeg($image_r, $saveFile1);
    }

	imagedestroy($image);
	imagedestroy($image_r);
	@chmod($saveFile1,0707);

	/* 썸네일 생성 */
	if($objName == 'mypic_change'){
		ResizeWidth($saveFile1,$saveFile2,180);
	}elseif($objName == 'iphoto_change'){
		ResizeWidth($saveFile1,$saveFile2,300);
	}
	@chmod($saveFile2,0707);
	$IM = getimagesize($saveFile1);
	$width = $IM[0];
	$height= $IM[1];
}


		
if($a) {
	$msg = '사진이 적용 되었습니다.';
	echo $objName.'|'.$tmpname.'|'.$msg;
}else echo '||에러가 발생하였습니다.'.$tmpname;
exit;
?>