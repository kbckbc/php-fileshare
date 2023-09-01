<?php
/*
 * This file deletes a user of the site
 */
require 'comm.php';

$username = checkLogin();

$full_dir_path = sprintf("%s/%s", $FILE_UPLOAD_DIR, $username);
phpLog($DEBUG, 'full_dir_path:'.$full_dir_path);

// read user file and save it to users array 
$h = fopen($FILE_USER, "r");
$users = array();
if(!$h) {
	while( !feof($h) ){
		$fileline = trim(fgets($h));
		if( strcmp($fileline,"") != 0 && $fileline != $username) {
			$users[] = $fileline;
		}
	}
}
fclose($h);
phpLog($DEBUG, 'read $FILE_USER done.');


// delete $FILE_USER 
// and create $FILE_USER without deleteing account
if(file_exists($FILE_USER)) {
	// delete $FILE_USER
	if(!unlink($FILE_USER)) {
		phpLog($DEBUG, 'unlink $FILE_USER  fail');
		exit;
	}

	// create new $FILE_USER 
	$fp = fopen($FILE_USER, 'w');
	if( $fp == false ) {
		phpLog($DEBUG, 'fopen $FILE_USER fail');
		exit;
	}
	else {
		foreach($users as $user) {
			fwrite($fp, $user."\n");  
		}
		fclose($fp);  
	}

	// remove user's folder
	if (!is_dir($full_dir_path)) {
		phpLog($DEBUG, 'is_dir fail');
		exit;
	}

	if(!deleteDirectory($full_dir_path)) {
		phpLog($DEBUG, 'deleteDirectory fail');
		exit;
	}

	phpLog($DEBUG, 'delete account done.');
	header("Location:".$LOGIN_PHP);
}

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}
?>