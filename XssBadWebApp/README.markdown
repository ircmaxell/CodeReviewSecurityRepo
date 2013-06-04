WARNING
-------

**DO NOT USE THIS APPLICATION!**  

This is a "Bad Web Application" that's designed to be vulnerable.  

**WARNING:** FOR RESEARCH USE ONLY!

**DISCLAIMER:** This application is for education use only.  Installing it on a public facing server will expose the server to several security vulnerabilities.  The author takes absolutely no responsibility for any damage that may occur from the use or misuse of any of this code.

You have been warned.

Requirements
------------

- PHP >= 5.3

- A Pear install of Smarty

- A Pear install of Twig

Known Vulnerabilities
---------------------

 - On 404 Error Page
    - Remote IP is displayed without escaping.  Data is pulled from the X--Forwarded-For Header

*TODO: Create a list of known vulnerabilities here*

