<?php
function generate_qr_code($data,$level='M',$size=5)
{
    //set it to writable location, a place for temp generated PNG files
   // $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $PNG_TEMP_DIR = 'phpqrcode_images_temp/temp/';
    //html PNG location prefix
    $PNG_WEB_DIR = 'phpqrcode_images_temp/';

    include "phpqrcode/qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    if (isset($level) && in_array($level, array('L','M','Q','H')))
        $errorCorrectionLevel = $level;    

    $matrixPointSize = 4;
    if (isset($size))
        $matrixPointSize = min(max((int)$size, 1), 10);


    if (isset($data)) { 
    
        //it's very important!
        if (trim($data) == '')
            die('data cannot be empty! <a href="?">back</a>');
            
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } else {    
    
        //default data
        echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }    
    
	copy($PNG_TEMP_DIR.basename($filename), $PNG_WEB_DIR.basename($filename));    
	    
    //display generated file
    //return $PNG_TEMP_DIR.basename($filename);  
 
    return $PNG_WEB_DIR.basename($filename);
}

$data = "Samsung 5005";
$level='M';
$size=20;
$qr_pic = generate_qr_code($data,$level,$size);
?>
<img src="<?=$qr_pic?>">




