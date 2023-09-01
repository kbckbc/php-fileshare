<?php
/* For constant values and common functions
 */
// global constant variables
$DEBUG = false;
$FILE_UPLOAD_DIR = '/home/bychan/dev/m2g/uploads';
$FILE_USER = '/home/bychan/dev/m2g/user.txt';
$VIEW_PHP = 'viewfile.php';
$DELETE_PHP = 'deletefile.php';
$LOGIN_PHP = 'login.php';
$LIST_PHP = 'list.php';
$UPLOAD_PHP = 'uploadfile.php';
$SIGNUP_PHP = 'signup.php';
$SIGNOUT_PHP = 'signout.php';


// check user's login status
// return 
// If user already login, return the user name
// or redirect to login.php page
function checkLogin() {
    session_start();

    $username = $_SESSION['username'];

    // check login
    if($username != NULL ) {
        return $username;
    }
    else {
        header("Location: login.php");
        exit;       
    }
}

// check input file name validation
function checkFilename($filename) {
    // We need to make sure that the filename is in a valid format; if it's not, display an error and leave the script.
    // To perform the check, we will use a regular expression.
    $msg = "";
    if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
        $msg = "Invalid filename.";
    }
    return $msg;
}

// check input user name validation
function checkUsername($username) {
    // Get the username and make sure that it is alphanumeric with limited other characters.
    // You shouldn't allow usernames with unusual characters anyway, but it's always best to perform a sanity check
    // since we will be concatenating the string to load files from the filesystem.
    $msg = "";
    if( !preg_match('/^[\w_\-]+$/', $username) ){
        $msg = "Invalid username.";
    }  
    return $msg;
}

// print out log in a web browser console
function console_log($debug, $log) {
    if($debug == true) {
        $js_code = 'console.log(' . json_encode($log, JSON_HEX_TAG) . ');';
        $js_code = '<script>' . $js_code . '</script>';
        echo $js_code;
    }
}

// print out log in a php log file
function phpLog($debug, $log) {
    if($debug == true) {
        error_log('====================> '.$log, 0);
    }
}

// print out text in html
function htmlErrorMsg($msg) {
    $pieces = explode(".", $msg);
    foreach($pieces as $err) {
        if($err != null) {
            printf('<b>Error: %s</b><br>', htmlentities($err));
        }
    }
}

// print out back button in html
function htmlBackButton() {
    printf('<button onclick="history.back()">Go Back</button><br>');
}

// print out home button in html
function htmlHomeButton() {
    printf('<button onclick="location.href=\'login.php\'">Go to main</button><br>');
}
?>
