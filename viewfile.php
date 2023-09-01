<?php
/*
 * This file gets a query string as an input param
 * And open the file which matches input param
 * The uploaded file directory is defined in comm.php
 */
require 'comm.php';

$errorMsg = "";

$username = checkLogin();
// $username = "chan";
$errorMsg .= checkUsername($username);
phpLog($DEBUG, 'username:'.$username);

$filename = $_GET['filename'];
$errorMsg .= checkFilename($filename);
phpLog($DEBUG, 'filename:'.$filename);

$full_path = sprintf("%s/%s/%s", $FILE_UPLOAD_DIR, $username, $filename);
phpLog($DEBUG, 'full_path:'.$full_path);


// Now we need to get the MIME type (e.g., image/jpeg).  PHP provides a neat little interface to do this called finfo.
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($full_path);

if($DEBUG) {
	printf("username: %s<br>", htmlentities($username));
	printf("filename: %s<br>", htmlentities($filename));
	printf("full_path: %s<br>", htmlentities($full_path));
	printf("mime: %s<br>", htmlentities($mime));
	printf("filesize: %s<br>", filesize($full_path));	
}
else {
	if($errorMsg != "") {
        phpLog($DEBUG, $errorMsg);
		htmlErrorMsg($errorMsg);
		htmlBackButton();
	}
	else {
		// Finally, set the Content-Type header to the MIME type of the file, and display the file.
		header("Content-Type: ".$mime);
		header('Content-Length: ' . filesize($full_path));
		header('content-disposition: inline; filename="'.$filename.'";');
		readfile($full_path);
	}
}


?>