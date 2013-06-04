<!--
/**
 * A Bad Web Application.  Note that this is intentionally vulnerable to several
 * security vulnerabilities.  DO NOT INSTALL THIS ON A PUBLIC SERVER!
 * 
 * WARNING: FOR RESEARCH USE ONLY!  DO NOT USE!
 * 
 * DISCLAIMER: This application is for education use only.  Installing it on a 
 * public facing server will expose the server to several security vulnerabilities
 * The author takes absolutely no resposibility for any damage that may occur
 * from the use or misuse of any of this code.
 *
 * PHP version 5.3
 *
 * @category   XssBadWebApp
 * @package    Templates
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 */
-->
<html>
	<head>
		<title>Home!</title>
                <style type="text/css">
                    {literal}
                    body {
                        font-size: 3em;
                    }
                    table {
                        border: 1px solid black;
                        border-spacing: 0px;
                    }
                    th {
                        font-size: 3em;
                    }
                    td {
                        border: 1px solid black;
                        padding: 4px;
                        font-size: 2.5em;
                    }
                    {/literal}
                </style>
	</head>
	<body>
		{if $message}<h3>{$message}</h3>{/if}
		<div>
			<h3>Welcome To The GuestBook: {if $user->isRegistered()}{$user->getName()} <a href="index.php?controller=user&action=logout">Logout</a>{else}Guest, Please <a href="index.php?controller=user&action=login">Login</a>{/if}</h3>
		</div>
		<table>
			<tr>
				<th>Name</th>
				<th>Location</th>
				<th>Greeting</th>
                                <th>Edit Link</th>
			</tr>
		
			{foreach from=$data item=entry}
				<tr>
					<td>{$entry->getName()}</td>
					<td>{$entry->getLocation()}</td>
					<td>{$entry->getGreeting()}</td>
                                        <td><a href="index.php?action=edit&id={$entry->getId()}">Edit Entry</a></td>
				</tr>
			{/foreach}
		</table>
		<p>{if $current_page > 1}<a href="index.php?page={$prev_page}">{else}<span>{/if}Previous Page{if $current_page > 1}</a>{else}</span>{/if}&nbsp;
			{if $current_page < $pages}<a href="index.php?page={$next_page}">{else}<span>{/if}Next Page{if $current_page < $pages}</a>{else}</span>{/if}
			 of {$pages} Total Pages</p>
		{if $user->isRegistered()}
			<a href="index.php?action=add">Add a new entry!</a>
		{/if}

	</body>
</html>