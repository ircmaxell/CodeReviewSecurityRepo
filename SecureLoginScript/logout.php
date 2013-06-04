<?php
session_start();
require('config.php');
function sanitize($data){
$data=trim($data);
$data=htmlspecialchars($data);
return $data;
}
$signature= sanitize($_GET['signature']);
if ($signature === $_SESSION['signature']) {
//authenticated user request
$_SESSION['logged_in'] = False;
session_destroy();   
session_unset();     
echo 'You have successfully logout from the private website! Thank you.<br /><br />';
?>
===============<br />
Navigation Menu<br />
===============<br />
<a href="index.php">Homepage</a><br />
<a href="about.php">About this page</a><br />
<?php
} else {
//unauthorized logout
header(sprintf("Location: %s", $forbidden_url));	
exit;  
}
?>