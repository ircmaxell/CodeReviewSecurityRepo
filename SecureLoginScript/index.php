<?php
require('authenticate.php');
?>
Hi this is a protected content! You are logged-in. Happy viewing.
<br />
<br />
===============<br />
Navigation Menu<br />
===============<br />
<a href="index.php">Homepage</a><br />
<a href="about.php">About this page</a><br />
<?php if (isset($_SESSION['logged_in'])) { ?><a href="logout.php?signature=<?php echo $_SESSION['signature']; ?>">Logout</a><br /><?php } ?>