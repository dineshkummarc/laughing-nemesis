<?php
/**
 * User: Dave
 * Date: 20.05.12
 * Time: 17:40
 */

$dbconfig = '
<?php
$db_host = "localhost";
$db_username = "sapuser";
$db_password = "jaro2812";
$database = "sap";
?>
';

$datei = fopen("database.php","w");
fwrite($datei, $dbconfig);