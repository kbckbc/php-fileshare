<!--
/*
 * This file gets a filename from a caller page
 * And upload a file into a certain dir.
 * The uploaded file directory is defined in comm.php
 * If deletion is successful, then go back page
 * otherwise, shows fail msg and go back button
 */
-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>FSS(File Share System) Upload page</title>
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
  phpLog($DEBUG, 'username:'.$username);
  $errorMsg .= checkUsername($username);

  $filename = basename($_FILES['filename']['name']);
  phpLog($DEBUG, 'filename:'.$filename);
  $errorMsg .= checkFilename($filename);

  $full_path = sprintf("%s/%s/%s", $FILE_UPLOAD_DIR, $username, $filename);
  phpLog($DEBUG, 'full_path:'.$full_path);
  ?>

  <body>
    <h1>FSS(File Share System) Upload page</h1>
	
    <?php
    // upload a file to the folder
    if( move_uploaded_file($_FILES['filename']['tmp_name'], $full_path) ){
      phpLog($DEBUG, 'file upload succ');
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
    } else {
      $errorMsg .= 'file upload fail';

      phpLog($DEBUG, $errorMsg);
      htmlErrorMsg($errorMsg);
      htmlBackButton();
    }
    ?>

  </body>
</html>






