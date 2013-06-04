<?php
header('HTTP/1.1 403 Forbidden');
?>
<html>
<head>
<title>Congratulations! You have been DENIED access</title>
</head>
<body>
<font size="4">You have been denied access because of the following reasons:<br /><br />
1.) Too many failed login attempts, so you are likely brute forcing through logins.<br />
2.) You have been accessing an authorized user account login through a stolen or hijacked session.<br /></font>
</body>
</html>