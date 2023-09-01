<!--
/*
 * This file gets a filename from a caller page
 * And upload a file into a certain dir.
 * The uploaded file directory is defined in comm.php
 */
-->
<!DOCTYPE html>
<?php
  require 'comm.php';

  $loginUser = "";
  $loginSucc = false;  

  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['loginUser']))
  {
    $loginUser = $_POST['loginUser'];

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
          if(strcmp($curruser, $loginUser) == 0) {
            $loginSucc = true;
          }
        }    
      }
    }
  }    
  phpLog($DEBUG, 'login.php page! loginUser:'.$loginUser);
  
?>  

<html lang="en">
  <head>
    <title>FSS(File Share System) Login page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">    
    <link rel="stylesheet" href="fss.css">
  </head>
  <body>
    <h1>FSS(File Share System) Login page</h1>
    <form name="myForm" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" >
      Username:
      <input type="text" name="loginUser" required autofocus>
      <br>
      <br>
      <input type="reset" value="Clear">      
      <input type="submit" value="Login">
      <button onclick="location.href='<?= htmlentities($SIGNUP_PHP)?>'" type="button">Sign UP</button>
    </form>
    <?php
      if($loginUser == "") {
        printf('Please login to use FSS.<br>');
        printf('Wanna join? Click Sign up!');
      }
      else {
        if(!$loginSucc) {
          printf("<b>There's no such user: %s</b><br>", htmlentities($loginUser));
          printf('Wanna join? Click Sign up!');
        }
        else {
          // Save username in SESSION
          // branch to a proper situation
          session_start();
          $_SESSION['username'] = $loginUser;
          header("Location:".$LIST_PHP);
          exit;       
        }
      }
      ?>
      
  </body>
</html>
