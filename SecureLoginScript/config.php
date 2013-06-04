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
 * Refer to license.txt to how code snippets from other authors or sources are attributed.
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

///////////////////////////////////////
//START OF USER CONFIGURATION/////////
/////////////////////////////////////

//Define MySQL database parameters

$username = "Your MySQL username";
$password = "Your MySQL password";
$hostname = "Your MySQL hostname";
$database = "Your MySQL database name";

//Define your canonical domain including trailing slash!, example:
$domain= "http://www.example.com/";

//Define sending email notification to webmaster

$email='youremail@example.com';
$subject='New user registration notification';
$from='From: www.example.com';

//Define Recaptcha parameters
$privatekey ="Your Recaptcha private key";
$publickey = "Your Recaptcha public key";

//Define length of salt,minimum=10, maximum=35
$length_salt=15;

//Define the maximum number of failed attempts to ban brute force attackers
//minimum is 5
$maxfailedattempt=5;

//Define session timeout in seconds
//minimum 60 (for one minute)
$sessiontimeout=180;

////////////////////////////////////
//END OF USER CONFIGURATION/////////
////////////////////////////////////

//DO NOT EDIT ANYTHING BELOW!

$dbhandle = mysql_connect($hostname, $username, $password)
 or die("Unable to connect to MySQL");
$selected = mysql_select_db($database,$dbhandle)
or die("Could not select $database");
$loginpage_url= $domain.'securelogin/';
$forbidden_url= $domain.'securelogin/403forbidden.php';
?>