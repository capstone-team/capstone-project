<?PHP
foreach($_GET as $k => $v) $_GET[$k] = addslashes($v);
foreach($_POST as $k => $v) $_POST[$k] = addslashes($v);
foreach($_COOKIE as $k => $v) $_COOKIE[$k] = addslashes($v);
import_request_variables("gp");
$handle = fopen("wrapper.txt","r");
$wrapper = fread($handle,filesize("wrapper.txt"));
fclose($handle);
mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");

$content = <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Administrative Site</a></h2>
			</div>
			<div class="entry">
		This section of the Computing Center Website is restricted
		to Computing Center Staff Only.
                        </div>
                </div>

		<div class="post">
			<div class="title">
				<h2><a href="#">Page LHUCC Staff via Cell Phone</a></h2>
			</div>
			<div class="entry">
		<a href="sendmessage.php">Click here</a> to send a message to a
		staff member's cell phone.
                        </div>
                </div>

		<div class="post">
			<div class="title">
				<h2><a href="#">Current News and Advisories</a></h2>
			</div>
			<div class="entry">
EOD;

$currmsg_query = mysql_query("SELECT * FROM messages ORDER BY post_date DESC");
$rows = min(5,mysql_num_rows($currmsg_query));
while ($rows != 0):
	$currmsg_obj = mysql_fetch_object($currmsg_query);
    	$content.= <<<EOD
			<div class="entry">
				<blockquote>
					<p>$currmsg_obj->message_data</p>
                                        <p><small>Posted by: $currmsg_obj->poster_name at $currmsg_obj->post_date</small></p>
				</blockquote>
			</div>
EOD;
	--$rows;
	endwhile;

$content .= <<<EOD
		</div>
EOD;

$display = str_replace("CONTENTPLACEHOLDER", $content, $wrapper);
echo $display;
?>