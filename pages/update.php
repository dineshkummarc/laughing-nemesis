<?PHP
//	Shoutcast Admin Panel 3.2
//	djcrackhome & WallCity-Server Coop.
//	GNU License 
//	http://www.shoutcastadmin.info
///////////////////////////////////////////////
//	./pages/update.php
//
if (!eregi("content.php", $_SERVER['PHP_SELF'])) {
    die ("You can't access this file directly...");
}
$url = 'http://update.streamerspanel.com/';

$jsonFile = json_decode(file_get_contents($url));

if (version_compare($currentVersio, $jsonFile->latest, '<')) {
		$notifi[] = '<h2><a href=" '. $jsonFile->download .'" target="_blank">'.$messages["524"].'</a></h2>';
}