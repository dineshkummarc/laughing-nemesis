<?PHP
/**
 * Streamers Admin Panel 3.2 - Final
 *
 * Originally written by Sebastian Graebner <djcrackhome>
 * Fixed and edited by David Schomburg <dave>
 *
 * The Streamers Admin Panel is a web-based administration interface for
 * Nullsoft, Inc.'s SHOUTcast Distributed Network Audio Server (DNAS),
 * and is intended for use on the Linux-distribution Debian.
 *
 * LICENSE: This work is licensed under the Creative Commons Attribution-
 * ShareAlike 3.0 Unported License. To view a copy of this license, visit
 * http://creativecommons.org/licenses/by-sa/3.0/ or send a letter to
 * Creative Commons, 444 Castro Street, Suite 900, Mountain View, California,
 * 94041, USA.
 *
 * @author     Sebastian Graebner <djcrackhome@streamerspanel.com>
 * @author     David Schomburg <dave@streamerspanel.com>
 * @copyright  2009-2012  S. Graebner <djcrackhome> D. Schomburg <dave>
 * @license    http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-ShareAlike 3.0 Unported License
 * @version    3.2 Final
 * @link       http://www.streamerspanel.com
 * @since      File available since Release 3.2 public-beta
 */

if (!eregi("content.php", $_SERVER['PHP_SELF'])) {
    die ("You can't access this file directly...");
}

$settingsq = mysql_query("SELECT * FROM settings WHERE id='0'") or die($messages["g5"]);
foreach(mysql_fetch_array($settingsq) as $key => $pref) {
	if (!is_numeric($key)) {
		$setting[$key] = stripslashes($pref);
	}
}

if (isset($_POST['submit'])) {
	if ($_POST['u_cuser_password'] !== "") {
		if ($_POST['u_user_password'] == $_POST['u_cuser_password']) {
			$update_ne = "1";
			$loginpw = $_POST['u_user_password'];
			$u_md5_hash = md5($loginun.$loginpw);
			if (mysql_query("UPDATE users SET user_password='".$loginpw."',md5_hash='".md5($loginun.$loginpw)."',  WHERE id='".$userdata['id']."' ") )
				$_SESSION['user_password'] = $_POST['u_user_password'];
		}
		else {
			$notifi[] = "<h2>".$messages["82"]."</h2>";
		}
	}
	if ($_SESSION['user_password'] !== $_POST['u_user_password']) {
		$notifi[] = "<h2>".$messages["83"]."</h2>";
	}
	$fields = "";
	$values = "";
	if (mysql_query("UPDATE users SET user_email='".$_POST["u_user_email"]."',contact_number='".$_POST["u_contact_number"]."',mobile_number='".$_POST["u_mobile_number"]."',name='".$_POST["u_name"]."',surname='".$_POST["u_surname"]."',age='".$_POST["u_age"]."' WHERE id='".$userdata['id']."' ") ) {
		$correc[] = "<h2>".$messages["84"]."</h2>";
	}
	else{
		$errors[] = "<h2>".$messages["85"]."</h2>";
	}
}
?>