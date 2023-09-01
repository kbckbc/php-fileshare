<!--
/*
 * This file creates a user for the site
 */
-->

<!DOCTYPE html>
<?php
  require 'comm.php';

  $errorMsg = "";
  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['signupUser']))
  {
    $signupUser = $_POST['signupUser'];
    phpLog($DEBUG,'signup.php signupUser:'.$signupUser);
    
    $errorMsg .= checkUsername($signupUser);

    $userFound = false;  
    if( file_exists($FILE_USER) ) {
      // read user file and set user array 
      $h = fopen($FILE_USER, "r");
      $user = array();
      if( $h ) {
        while( !feof($h) ){
            $fileline = trim(fgets($h));
            if( strcmp($fileline,"") != 0) {
                $user[] = $fileline;
            }
        }
        fclose($h);

        foreach($user as $curruser) {
          if(strcmp($curruser, $signupUser) == 0) {
            $userFound = true;
          }
        }    
      }
    }


    // check the username is in use
    if($userFound){
      $errorMsg .= sprintf('[%s] is in use! Try another name, please.', htmlentities($signupUser));
    }
    else {
      // add user to a user.txt
      $fp = fopen($FILE_USER, 'a+');//opens file in append mode  
      if( $fp == false ) {
        phpLog($DEBUG, sprintf("Signup fail, fopen [%s]", $FILE_USER));
        $errorMsg .= 'Signup fail: User creation.';
      }
      else {
        fwrite($fp, $signupUser."\n");  
        fclose($fp);  
      }

      // and create user foler
      if( !mkdir(sprintf("%s/%s", $FILE_UPLOAD_DIR, $signupUser)) ) {
        phpLog($DEBUG, sprintf("Signup fail, mkdir [%s, %s]", $FILE_UPLOAD_DIR, $signupUser));
        $errorMsg .= "Signup fail: Dir creation.";
      }
      else {
        // set session and move to list page
        session_start();
        $_SESSION['username'] = $signupUser;
        header("Location:".$LIST_PHP);
        exit;           
      }
    }
  }
?>
<html lang="en">
  <head>
    <title>FSS(File Share System) Sign up page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">    
    <link rel="stylesheet" href="fss.css">    
  </head>

  <body>
    <h1>FSS(File Share System) Sign-up page</h1>
    <form name="myForm" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" >
      Username:
      <input type="text" name="signupUser" required autofocus>
      <br>
      <br>
      <input type="submit" value="Sign up">
      <button onclick="history.back()">Go Back</button>     
    </form>
    <?php 
    if($errorMsg != "") {
      htmlErrorMsg($errorMsg);
    }
    ?>
  </body>
</html>
