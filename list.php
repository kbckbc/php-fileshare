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

	$username = checkLogin();
	

	// 'logout' button event
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logOut']))
	{
		session_destroy();
		header("Location:".$LOGIN_PHP);
		exit;
	}


	$scanDir = scandir($FILE_UPLOAD_DIR.'/'.$username);
	$fileList = array();

	foreach($scanDir as $filename) {
		if( substr($filename,0,1) != '.') {
			$fileList[] = $filename;
		}
	}
?>
<html lang="en">
  <head>
    <title>FSS(File Share System) List page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">    
	<link rel="stylesheet" href="fss.css">    
	<script>
		function deleteAccount() {
			if( confirm('All files will be gone.\nAre you sure want to delete your account?')) {
				location.href='<?php echo htmlentities($SIGNOUT_PHP.'?username='.$username) ?>'
			}
		}
	</script>
  </head>
  <body>
    <h1>FSS(File Share System) List page</h1>

	<form name="myForm" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" >
		<input type="submit" name="logOut" value="Logout" />
		<button onclick="deleteAccount()" type="button">Delete account</button>
	</form>


	<h4><b><?php printf("Hello, %s! List of files", htmlentities($username));?></b></h4>

	<?php

	// show file list
	if(count($fileList) == 0) {
		printf('<blockquote>');
		printf('No file has been uploaded yet!<br>');
		printf('You can upload your files by clicking Upload file button!');
		printf('</blockquote>');
	}
	else {
		/* using table */
		printf('<blockquote>');

		printf("
			<table>
			<tr>
				<th>Name(Click to view)</th>
				<th>Date</th>
				<th>Size</th>
				<th>Action</th>
			</tr>
			");
		foreach($fileList as $filename) {
			$full_path = sprintf("%s/%s/%s", $FILE_UPLOAD_DIR, $username, $filename);

			printf("
			<tr>
				<td><a href='%s?filename=%s'><b>%s</b></a></td>
				<td>%s</td>
				<td>%s</td>
				<td><a href='%s?filename=%s' onclick=\"return confirm('Are you sure?')\"><b>Delete file</b></a> </td>
			</tr>",
			$VIEW_PHP,
			htmlentities($filename),
			htmlentities($filename),
			date ("F d Y H:i:s", filemtime($full_path)),
			sprintf("%-10d",filesize($full_path)),
			$DELETE_PHP,
			htmlentities($filename)
			);		
		}
		printf("</table>");
		printf('</blockquote>');

	}		
	?>

	<!-- show file upload form -->
	<form enctype="multipart/form-data" action="<?php echo $UPLOAD_PHP ?>" method="POST" >
		<p>
			<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
			<label for="uploadfile_input">Choose a file to upload:</label>
			<input name="filename" required type="file" id="uploadfile_input" />
		</p>
		<input type="submit" value="Upload File" />
	</form>
  </body>
</html>

