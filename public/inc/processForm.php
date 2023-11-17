<?php

ini_set('display_errors', 1); 
error_reporting(E_ALL);

//error_reporting(0);
//ini_set('display_errors', 0);

$logFilename = '../log.txt'; 

//require 'PHPMailer/src/Exception.php';
//require 'PHPMailer/src/PHPMailer.php';
//require 'PHPMailer/src/SMTP.php';

//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;

// WordPress environment
require($_SERVER['DOCUMENT_ROOT'] .'/wp-load.php' );

logToFile($logFilename, '--- START ---'. "\n");


date_default_timezone_set('America/New_York');

$wordpress_upload_dir = wp_get_upload_dir();
// $wordpress_upload_dir['path'] is the full server path to wp-content/uploads/2017/05, for multisite works good as well
// $wordpress_upload_dir['url'] the absolute URL to the same folder, actually we do not need it, just to show the link to file
// $wordpress_upload_dir['basedir'] is the full server path to wp-content/uploads/, for multisite works good as well
//$i = 1; // number of tries when the file with the same name is already exists

function checkEmail($email) {
	$find1 = strpos($email, '@');
	$find2 = strpos($email, '.');
	return ($find1 !== false && $find2 !== false && $find2 > $find1);
}

/*$uploadDir = trailingslashit($wordpress_upload_dir['basedir']). 'client-consult-photos';
//if (!file_exists($uploadDir)) {
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true);
}

$image_height = 1920;
$image_width = 1920;
*/
$ignoreArray = array('hpot','submitURL','MAX_FILE_SIZE');
$errorFeedback = ''; 

if (empty($_POST['hpot'])) {
	$formInfo = '';
	$formFrom = '';
	$formFromEmail = ''; 
	$attachments = array();
	$attachmentNames = array();
	
	$server = $_SERVER['HTTP_USER_AGENT'];
	//logToFile($logFilename, 'SERVER: '. $server . "\n");
	
	foreach($_POST as $key => $value) {
		if (!in_array($key,$ignoreArray)) {
			//$key = str_replace('_', ' ',$key);
			if (strpos($key,'consultPhoto') !== false) {
				//$attachments[] = $value;
				$attachments[] = $_SERVER["DOCUMENT_ROOT"] . $value; 
				$attachmentNames[] =  basename($value);
				//$errorFeedback .= 'IMAGE:'; 
			} else {
				// Format values for email display	
				$key = str_replace('_', ' ',$key);
				$value = ((is_array($value)) ? implode(',',$value) : $value);
				$formInfo .= '<p><strong>'. $key .':</strong> '. $value .'</p>';
				if (checkEmail($value)) {
					$clientEmail = $value;
					//$errorFeedback .= 'EMAIL:';
				}
			}
			$errorFeedback .= $key .':'. $value . "\n"; 
		}
	}
	logToFile($logFilename, $errorFeedback);
	$formInfo .= '<p><em>This email was generated from a web form on '. get_site_url() .'</em></p>';
	
	
	// Email Server Info
	$options = get_option('como-consult-options');
	$smtpServer = $options['smtp-email-server'];
	$smtpUN = $options['smtp-email-un'];
	$smtpPW = $options['smtp-email-pw'];
	$smtpPort = $options['smtp-email-port'];
	$smtpFromEmail = $options['smtp-email-from-address'];
	$smtpFromName = ($options['smtp-email-name'] ? $options['smtp-email-name'] : '');
	$smtpToEmail = $options['smtp-email-to-email-address'];
	$smtpSubject = ($options['smtp-email-subject'] ? $options['smtp-email-subject'] : 'Virtual Consultation');
	$smtpReplyTo = ($options['smtp-email-replyto-address'] ? $options['smtp-email-replyto-address'] : $options['smtp-email-from-address']);
	$smtpCcEmail = ($options['smtp-cc-email-address'] ? $options['smtp-cc-email-address'] : '');
	$messageHTML = $formInfo;
		
	if ($smtpFromName == 'TEST') {
		$smtpToEmail = 'josh@comocreative.com'; 
	}
	
	$cnt = count($attachments);
	$messageHTML .= '<p><strong>Image Attachments</strong><br>';
	for ($a=0;$a<$cnt;$a++) {
		$messageHTML .= $attachmentNames[$a] .'<br>';
	}
	$messageHTML .= '</p>';
	//$messageHTML .= $errorFeedback;
	
	$to = $smtpToEmail;
	$subject = $smtpSubject;
	$body = $messageHTML;
	$headers = array();
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
	$headers[] = 'From: '. $smtpFromName .' <'. $smtpFromEmail .'>';
	if (!empty($smtpCcEmail)) { $headers[] = 'Cc: '. $smtpCcEmail; }
	if (isset($clientEmail)) { $headers[] = 'Reply-To: '.$clientEmail; }
	//$headers[] = 'Bcc: josh@computerwc.com';
	
	logToFile($logFilename, 'TO: '. $to . "\n");
				
	if (wp_mail( $to, $subject, $body, $headers, $attachments)) {
		logToFile($logFilename, 'MAILED ' . "\n");
		$response = 'messagesent';
		$feedback = 'Thank you for your submission!';
	} else {
		logToFile($logFilename, 'NOT MAILED ' . "\n");
		$response = 'emailnotsent'; 
		$feedback = 'Sorry, we encountered a problem sending your email';
	}
	logToFile($logFilename, $response . "\n");
} else {
	// SPAM!!
	$response = 'spam';
	$feedback = 'Go away Spammer!';
}
$output = array('response'=>$response,'feedback'=>$feedback);

header('Content-Type: application/json; charset=utf-8', true); 
echo json_encode(array("output"=>$output));
?>