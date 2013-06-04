<?php
/*
 * This is a PHP Secure login system.
 *    - Documentation and latest version
 *          Refer to readme.txt
 *    - To download the latest copy:
 *          http://www.php-developer.org/php-secure-authentication-of-user-logins/
 *    - Discussion, Questions and Inquiries
 *          email codex_m@php-developer.org
 *
 * Copyright (c) 2011 PHP Secure login system -- http://www.php-developer.org
 * AUTHORS:
 *   Codex-m
 * Refer to license.txt to how codes from other projects are attributed.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
//require user configuration and database connection parameters
require('config.php');

//pre-define validation parameters

$usernamenotempty=TRUE;
$usernamevalidate=TRUE;
$usernamenotduplicate=TRUE;
$passwordnotempty=TRUE;
$passwordmatch=TRUE;
$passwordvalidate=TRUE;
$captchavalidation= TRUE;

//Check if user submitted the desired password and username
if ((isset($_POST["desired_password"])) && (isset($_POST["desired_username"])) && (isset($_POST["desired_password1"])))  {
	
//Username and Password has been submitted by the user
//Receive and validate the submitted information

//sanitize user inputs

function sanitize($data){
$data=trim($data);
$data=htmlspecialchars($data);
$data=mysql_real_escape_string($data);
return $data;
}

$desired_username=sanitize($_POST["desired_username"]);
$desired_password=sanitize($_POST["desired_password"]);
$desired_password1=sanitize($_POST["desired_password1"]);

//validate username

if (empty($desired_username)) {
$usernamenotempty=FALSE;
} else {
$usernamenotempty=TRUE;
}

if ((!(ctype_alnum($desired_username))) || ((strlen($desired_username)) >11)) {
$usernamevalidate=FALSE;
} else {
$usernamevalidate=TRUE;
}

if (!($fetch = mysql_fetch_array( mysql_query("SELECT `username` FROM `authentication` WHERE `username`='$desired_username'")))) {
//no records for this user in the MySQL database
$usernamenotduplicate=TRUE;
}
else {
$usernamenotduplicate=FALSE;
}

//validate password

if (empty($desired_password)) {
$passwordnotempty=FALSE;
} else {
$passwordnotempty=TRUE;
}

if ((!(ctype_alnum($desired_password))) || ((strlen($desired_password)) < 8)) {
$passwordvalidate=FALSE;
} else {
$passwordvalidate=TRUE;
}

if ($desired_password==$desired_password1) {
$passwordmatch=TRUE;
} else {
$passwordmatch=FALSE;
}

//Validate recaptcha
require_once('recaptchalib.php');
$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

if (!$resp->is_valid) {
//captcha validation fails
$captchavalidation=FALSE;
} else {
$captchavalidation=TRUE;	
}

if (($usernamenotempty==TRUE)
&& ($usernamevalidate==TRUE)
&& ($usernamenotduplicate==TRUE)
&& ($passwordnotempty==TRUE)
&& ($passwordmatch==TRUE)
&& ($passwordvalidate==TRUE)
&& ($captchavalidation==TRUE)) {
//The username, password and recaptcha validation succeeds.

//Hash the password
//This is very important for security reasons because once the password has been compromised,
//The attacker cannot still get the plain text password equivalent without brute force.

function HashPassword($input)
{
//Credits: http://crackstation.net/hashing-security.html
//This is secure hashing the consist of strong hash algorithm sha 256 and using highly random salt
$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)); 
$hash = hash("sha256", $salt . $input); 
$final = $salt . $hash; 
return $final;
}

$hashedpassword= HashPassword($desired_password);

//Insert username and the hashed password to MySQL database

mysql_query("INSERT INTO `authentication` (`username`, `password`) VALUES ('$desired_username', '$hashedpassword')") or die(mysql_error());
//Send notification to webmaster
$message = "New member has just registered: $desired_username";
mail($email, $subject, $message, $from);
//redirect to login page
header(sprintf("Location: %s", $loginpage_url));	
exit;
}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Register as a Valid User</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
.invalid {
border: 1px solid #000000;
background: #FF00FF;
}
</style>
</head>
<body >
<h2>User registration Form</h2>
<br />
Hi! This private website is restricted to public access. If you want to see the content, please register below. You will be redirected to a login page after successful registration.
<br /><br />
<!-- Start of registration form -->
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
Username: (<i>alphanumeric less than 12 characters</i>) <input type="text" class="<?php if (($usernamenotempty==FALSE) || ($usernamevalidate==FALSE) || ($usernamenotduplicate==FALSE))  echo "invalid"; ?>" id="desired_username" name="desired_username"><br /><br />
Password: (<i>alphanumeric greater than 8 characters</i>) <input name="desired_password" type="password" class="<?php if (($passwordnotempty==FALSE) || ($passwordmatch==FALSE) || ($passwordvalidate==FALSE)) echo "invalid"; ?>" id="desired_password" ><br /><br />
Type the password again: <input name="desired_password1" type="password" class="<?php if (($passwordnotempty==FALSE) || ($passwordmatch==FALSE) || ($passwordvalidate==FALSE)) echo "invalid"; ?>" id="desired_password1" ><br />
<br /><br />
Type the captcha below:
<br /> <br />
<?php
require_once('recaptchalib.php');
echo recaptcha_get_html($publickey);
?>
<br /><br />
<input type="submit" value="Register">
<br /><br />
<a href="index.php">Back to Homepage</a><br />
<!-- Display validation errors -->
<?php if ($captchavalidation==FALSE) echo '<font color="red">Please enter correct captcha</font>'; ?><br />
<?php if ($usernamenotempty==FALSE) echo '<font color="red">You have entered an empty username.</font>'; ?><br />
<?php if ($usernamevalidate==FALSE) echo '<font color="red">Your username should be alphanumeric and less than 12 characters.</font>'; ?><br />
<?php if ($usernamenotduplicate==FALSE) echo '<font color="red">Please choose another username, your username is already used.</font>'; ?><br />
<?php if ($passwordnotempty==FALSE) echo '<font color="red">Your password is empty.</font>'; ?><br />
<?php if ($passwordmatch==FALSE) echo '<font color="red">Your password does not match.</font>'; ?><br />
<?php if ($passwordvalidate==FALSE) echo '<font color="red">Your password should be alphanumeric and greater 8 characters.</font>'; ?><br />
<?php if ($captchavalidation==FALSE) echo '<font color="red">Your captcha is invalid.</font>'; ?><br />
</form>
<!-- End of registration form -->
</body>
</html>