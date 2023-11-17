<?php

ini_set('display_errors', 1); 
error_reporting(E_ALL);

//echo 'HERE';
//exit;

//require($_SERVER['DOCUMENT_ROOT'] .'/wp-load.php' );
date_default_timezone_set('America/New_York');
//$wordpress_upload_dir = wp_get_upload_dir();

//$logFilename = '../uploadLog.txt'; 

//logToFile($logFilename, 'HERE WE GO!' . "\n");

// Get file extension - used for image resize script
function getFileExtension($str) {
	$i = strrpos($str,".");
    if (!$i) { return ""; }
    $l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
    return $ext;
}

// Clean Filename for upload & add random # to avoid overwrites
function cleanFilename($filename) {
	$filename = $filename;
	$filename = preg_replace('/[^ A-Za-z0-9.]/', '-', $filename);   
	$filename = preg_replace('/[ \t\n\r]+/', '-', $filename);   
	$filename = str_replace(' ', '-', $filename);   
	$filename = preg_replace('/[ _]+/', '-', $filename); 
	$filename = substr($filename, 0, 200);
	$imgExt = '.'. getFileExtension($filename);
	$filename = str_replace($imgExt, '', $filename);
	$randNum = rand(1000000000,10000000000);
	$filename .= '-'. $randNum . $imgExt;
	return  $filename;
}

$fieldName = $_POST['fieldName'];
$response['status'] = 'here';

function createDir($dirName) {
	if (!file_exists($dirName)) {
		mkdir($dirName, 0755, true);
	}
}
$uploadDir = '../../../../uploads/';
//$uploadDir = trailingslashit($wordpress_upload_dir['basedir']);
createDir($uploadDir .'client-consult-photos');
$targetDir = $uploadDir .'/client-consult-photos';

//logToFile($logFilename, 'Target Dir: ' . $targetDir . "\n");

if (isset($_POST) == true) {
	
	//logToFile($logFilename, 'POST' . "\n");
	
	$fileName = cleanFilename(date('YmdHis') .'-'. basename($_FILES['file']["name"]));
	$fileType = getFileExtension($_FILES['file']['name']);
	$targetFilePath = $targetDir .'/'. $fileName; 
	$allowTypes = array('jpg','png','jpeg','JPG','PNG','JPEG','x-png');
	if (in_array($fileType, $allowTypes)){
		$image_height = 1920;
		$image_width = 1920;
	
		$image_size_info  = getimagesize($_FILES['file']['tmp_name']); 
		if($image_size_info){
			$image_type = $image_size_info['mime']; //image type
		} else {
			$response['status'] = 'Invalid Image File';
		}
		
		if( !class_exists("Imagick") ) {
			// No Imagick
			$image = $_FILES['file']['tmp_name'];
			$cmd = "/usr/bin/convert {$image} -resize {$image_width}x{$image_height} {$targetFilePath}";
			$return = null;
			exec($cmd, $return, $return);
			$uploadResult = true;
		} else {
			//Use Imagick
			$image = new Imagick($_FILES['file']['tmp_name']);
			if($image_type=="image/gif") {
				//if it's GIF file, resize each frame
				$image = $image->coalesceImages(); 
				foreach ($image as $frame) { 
					$frame->resizeImage($image_height, $image_width, Imagick::FILTER_LANCZOS, 1, TRUE);
				} 
				$image = $image->deconstructImages(); 
			} else {
				//otherwise just resize
				$image->resizeImage($image_height, $image_width, Imagick::FILTER_LANCZOS, 1, TRUE);
			}
			//write image to a file
			$uploadResult = $image->writeImages($targetFilePath, true);
		}
		
		if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
			$uploadResult = true;
		} else {
			$uploadResult = false;
		}
		
		if ($uploadResult) {
            $response['status'] = utf8_encode('ok');
			$response['fileName'] = utf8_encode($fileName);
			$response['fieldName'] = utf8_encode($fieldName);
			//logToFile($logFilename, $response['fileName'] . "\n");
        } else {
            $response['status'] = utf8_encode('err');
        }
    } else {
        $response['status'] = utf8_encode('type_err');
	}
} else {
	$response['status'] = utf8_encode('err');
}
//logToFile($logFilename, $response['status'] . "\n");
echo json_encode($response);

?>