<!--
/*
 * This file gets a query string as an input param
 * And delete a file which is the same with an input param
 * If deletion is successful, then go back page
 * otherwise, shows fail msg and go back button
 */
-->

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>FSS(File Share System) Delete page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">    
    <link rel="stylesheet" href="fss.css">    
  </head>

  <?php
  require 'comm.php';

  $errorMsg = "";

  $username = checkLogin();
  // $username = "chan";
  $errorMsg .= checkUsername($username);
  phpLog($DEBUG, 'username:'.$username);

  if($_SERVER['REQUEST_METHOD'] == "GET" and isset($_GET['filename']))
  {
    $filename = $_GET['filename'];
    $errorMsg .= checkFilename($filename);
    phpLog($DEBUG, 'filename:'.$filename);
  
    $full_path = sprintf("%s/%s/%s", $FILE_UPLOAD_DIR, $username, $filename);
    phpLog($DEBUG, 'full_path:'.$full_path);
  
    // remove a file from folder
    if(file_exists($full_path)) {
      if(unlink($full_path)) {
        phpLog($DEBUG, 'file deletion succ');
          header('Location: ' . $_SERVER['HTTP_REFERER']);
      } else {
        $errorMsg .= 'file deletion fail.';
      }
    }
  }
  ?> 

<body>
  <h1>FSS(File Share System) Delete page</h1>
  
  <?php 
  if($errorMsg != "") {
    htmlErrorMsg($errorMsg);
    htmlBackButton();
  }
  ?>

  </body>
</html>




