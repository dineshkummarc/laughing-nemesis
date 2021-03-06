<?PHP
/**
 * Streamers Admin Panel
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
 * @version    3.2.1
 * @link       http://www.streamerspanel.com
*/
    //	djcrackhome & WallCity-Server Coop.
//	GNU License 
//	http://www.stremerspanel.com
///////////////////////////////////////////////
//	./pages/music_bottom.php
//	

if (stripos($_SERVER['PHP_SELF'], 'content.php') === false) {
    die ("You can't access this file directly...");
}

function shoutcastcheck($host, $port2, $wait_sec) {
	$fp = @fsockopen($host, $port2, &$errstr, &$errno, $wait_sec);
	if ($fp) {
		fputs($fp, "GET / HTTP/1.0\r\nUser-Agent:AmIoffOrOn\r\n\r\n");
		$ret = fgets($fp, 255);
		fclose($fp);
		return strpos($ret, '200') !== false;
	}
	else {
		return false;
	}
}
$limit = $setting['display_limit'];
if (!isset($_GET['p'])) {
	$p = 0;
}
else {
	$p = $_GET['p'] * $limit;
}
$l = $p + $limit;
$select = mysql_query("SELECT * FROM servers WHERE owner='".$loginun."' ORDER BY id ASC LIMIT $p,$limit");
?>
		<h2><?php echo $messages["374"];?></h2>
		<div class="contact_top_menu">
			<div class="tool_top_menu">
				<div class="main_shorttool"><?php echo $messages["375"];?></div>
				<div class="main_righttool">
					<h2><?php echo $messages["376"];?></h2>
					<p><?php echo $messages["377"];?></p>
					<p>&nbsp;</p>
				</div>
			</div>
			<table cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th><?php echo $messages["378"];?></th>
						<th><?php echo $messages["379"];?></th>
						<th><?php echo $messages["380"];?></th>
						<th><?php echo $messages["381"];?></th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if (mysql_num_rows($select)==0) {
					echo "<tr>
						<td colspan=\"5\">".$messages["382"]."</td>
						</tr>";
				}
				else {
					while($data = mysql_fetch_array($select)) {
					echo '<tr>
						<td><a href="http://'.$setting['host_add'].':'.$data['portbase'].'/" target="_blank">'.$setting['host_add'].'</a></td>
						<td><a href="http://'.$setting['host_add'].':'.$data['portbase'].'/" target="_blank">'.$data['portbase'].'</a></td>
						<td><div class="space_show" style="background-position:';
						if (file_exists("./pages/uploads/".$data['portbase']."/")) {
							$dir = "./pages/uploads/".$data['portbase']."/";
							$filesize = 0;
							if(is_dir($dir)) {
								if($dp = opendir($dir)) {
									while( $filename = readdir($dp) ) {
										if(($filename == '.') || ($filename == '..')) 
											continue;
										$filedata = stat($dir."/".$filename);
										$filesize += $filedata[7];
									}
									$actual_dir_size = $filesize/1024;
								}
							}
						}
						$negative_background_pos = ($actual_dir_size/$data['webspace'])*120;
						echo '-'.$negative_background_pos.'px 0px;"></div></td>
							<td><div class="space_show"></div></td>
							<td><a class="edit" href="content.php?include=playlist&portbase='.$data['portbase'].'">'.$messages["383"].'</a><a class="selector" href="content.php?include=upload&portbase='.$data['portbase'].'">'.$messages["384"].'</a></td>
							</tr>';
					}
				}
				?>
				</tbody>
			</table>
			<ul class="paginator">
				<?php
				if (mysql_num_rows($select)==0) { }
				else {
					$page = mysql_num_rows(mysql_query("SELECT * FROM servers WHERE owner='".$loginun."'"));
					$i = 0;
					$page = mysql_num_rows(mysql_query("SELECT * FROM servers"));
					while($page > "0") {
						echo "<li><a href=\"content.php?include=music&p=";
						if (($p / $limit) == $i){
							echo "";
						}
						echo "$i\">$i</a></li>";
						$i++;
						$page -= $limit;
					}
				}
				?>
			</ul>
		</div>