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

if (stripos($_SERVER['PHP_SELF'], 'content.php') === false) {
    die ("You can't access this file directly...");
}

?>
		<h2><?php echo $messages["525"];?> <?php echo $port?></h2>
		<div class="contact_top_menu">
			<div class="tool_top_menu">
				<div class="main_shorttool"><?php echo $messages["526"];?></div>
				<div class="main_righttool">
					<h2><?php echo $messages["527"];?></h2>
					<p><?php echo $messages["528"];?></p>
					<p>&nbsp;</p>
				</div>
			</div>
			<form method="post" action="content.php?include=upload&portbase=<?php echo $port?>" enctype="multipart/form-data">
				<fieldset>
					<legend><?php echo $messages["529"];?> <?php echo $port?></legend>
					<table cellpadding="0" cellspacing="0" class="upload_table">
						<thead>
							<tr>
								<th><?php echo $messages["530"];?></th>
								<th><?php echo $messages["531"];?></th>
								<th colspan="4"><?php echo $messages["532"];?></th>
							</tr>
						</thead>
						<tbody>
							<tr class="upload_table">
								<td class="subnav_child"><?php echo $messages["533"];?></td>
								<td class="upload_table"><?php echo "".round(($data['webspace']/1024), 2)." MB";?></td>
								<td class="upload_table"><?php echo "".round(($actual_dir_size/1024), 2)." MB";?></td>
								<?php 
								echo '<td><div class="upload_table_show" style="background-position:';
									$negative_background_pos = ($actual_dir_size/$data['webspace'])*180;
								echo '-'.$negative_background_pos.'px 0px;"></div></td>';
								?>
						    </tr>
							<tr class="upload_table">
								<td class="subnav_child"><?php echo $messages["535"];?></td>
								<td colspan="3" class="upload_table"><?php echo "".ini_get('upload_max_filesize')."B";?></td>
							</tr>
							<tr class="upload_table">
								<td class="subnav_child"><?php echo $messages["536"];?></td>
								<td colspan="3" class="upload_table">MP3</td>
							</tr>
							<tr class="upload_table">
								<td class="subnav_child"><?php echo $messages["537"];?></td>
								<td colspan="3" class="upload_table"><?php echo $port;?></td>
							</tr>
						</tbody>
					</table>
                    <div id="uploadbox"></div>
				</fieldset>
			</form>
			<br />
			<table cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th><?php echo $messages["541"];?></th>
						<th><?php echo $messages["542"];?></th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php
					for($i=$listing_start;$i<=$listing_end;$i++) {
						if (($dirlisting[$i]!=".") and ($dirlisting[$i]!="..") and ($dirlisting[$i]!="")) {
							echo "<tr>
								<td>$dirlisting[$i]</td>
								<td>".round((filesize("./pages/uploads/".$port."/".$dirlisting[$i])/1024), 2)." KB (".round((filesize("./pages/uploads/".$port."/".$dirlisting[$i])/1024/1024), 2)." MB)</td>
									<td><a class=\"delete\" href=\"content.php?include=upload&portbase=".$port."&delete=".base64_encode($dirlisting[$i])."\">".$messages["543"]."</a><a class=\"selector\" href=\"content.php?include=upload&portbase=".$port."&download=".base64_encode($dirlisting[$i])."\">".$messages["544"]."</a></td>
								</tr>";
						}
					}
					?>
				</tbody>
			</table>
			<ul class="paginator">
				<?php
				static $counter;
				$counter=0;
				$recursive=false;
				while (($datei = readdir($dirlistdir)) !== false) {
					if(($datei!=".") and ($datei!="..")) {
						$counter = (is_dir("./pages/uploads/".$port."/".$datei)) ? num_files("./pages/uploads/".$port."/".$datei, $recursive, $counter) : $counter+1;
					}
				}
				closedir($dirlistdir);
				$pagessubcount = ceil($counter/7);
				if ($offset == 1) {
					echo "<li><a href=\"content.php?include=upload&portbase=".$port."&filecount=".($offset)."\">".$messages["545"]."</a></li>";
				}
				else {
					echo "<li><a href=\"content.php?include=upload&portbase=".$port."&filecount=".($offset-1)."\">".$messages["545"]."</a></li>";
				}
				for ($pagessubcountfor=0; $pagessubcountfor <= $pagessubcount; $pagessubcountfor += 1) {
					if ($pagessubcountfor!==0) {
						echo "<li";
						if ($offset==$pagessubcountfor) {
							echo " class=\"current\"";
						}
						echo"><a href=\"content.php?include=upload&portbase=".$port."&filecount=".$pagessubcountfor."\">".$pagessubcountfor."</a></li>";
					}
				}
				if ($offset == $pagessubcount) {
				echo "<li><a href=\"content.php?include=upload&portbase=".$port."&filecount=".($offset)."\">".$messages["546"]."</a></li>";
				}
				else {
					echo "<li><a href=\"content.php?include=upload&portbase=".$port."&filecount=".($offset+1)."\">".$messages["546"]."</a></li>";
				}
				?>
			</ul>
		</div>