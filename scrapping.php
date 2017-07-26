<?php

include 'phpQuery-onefile.php';

// Open connection 
$host = '{imap.gmail.com:993/ssl}INBOX';
$user = 'whatever_account@gmail.com';
$pass = 'myTrustyPassword';

$mail = imap_open($host, $user , $pass) or die ('Cannot connect to the remote host ' 
		. imap_last_error());

// Search in all the emails which the criteria we want, unseen in this case.
$emails = imap_search($mail, 'UNSEEN');

// If we want all the headers we can use this function and get a list with flags (new, recent, flagged, unseen, etc..)
// $allHeaders = imap_headers($mail);

// We can set a key word for doing searchs with it.
$search = 'Reservations';

// Iterate the list of unseen emails taking the headers.
foreach ($emails as $emailUnseen)
{
	$head = imap_header($mail, $emailUnseen);
	foreach ($head as $reqhead)
	{
		// Once we get the header is time to doing the search of our key word(Reservations).
		$pos = strpos($reqhead, $search, 1);
		// If the result is not false we can do things with it.
		if ($pos)
		{
			// Print the search results for unseen emails.
			echo ' ****FOUND ' . $search . ' in this position ' . $pos . '****';
			
			// Now we iterate the unseen emails which fill the search criteria and we can read the body.
			$body = imap_body($mail, $emailUnseen);
			$document = phpQuery::newDocumentHTML($body);
			// Using find() with the 'body' search criteria we will receive all the body content, 
			// if we only want the plain text we need to use the text() function.
			$result = $document->find('body')->text();
			
			echo $result;
}
// Close the connection.
imap_close($mail);









