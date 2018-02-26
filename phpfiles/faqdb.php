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
$content .= <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Frequently Asked Questions Database</a></h2>
			</div>
			<div class="entry">
	<P>Please type your search string below. All terms are included in the search.</P>
	<FORM ACTION="$PHP_SELF" METHOD="POST">
	<INPUT TYPE="TEXT" NAME="searchstring" SIZE="60"><BR>
	<INPUT TYPE="SUBMIT" VALUE="Search">
	</FORM>
	<BR><A HREF="$PHP_SELF?searchstring=%">See all FAQ's</A>
                        </div>
                </div>
EOD;

if (strlen($searchstring) > 0) {
	$keywords = preg_split ("/[\s,]+/", "$searchstring");
	$query_string = "SELECT faq_id,question,answer FROM faqs WHERE";
	$first = 1;
	foreach ($keywords as $keyword) {
		if ($first == 0) {
			$query_string .= " AND";
			}
		$first = 0;
		$query_string .= " (question LIKE '%$keyword%' OR answer LIKE '%$keyword%')";
		}
	//echo $query_string;
	$faq_query = mysql_query($query_string);
	$rows = mysql_num_rows($faq_query);

	$content .= <<<EOD
		<div class="post">
			<div class="entry">
		You searched for: <B>$searchstring</B>, which matched $rows questions.<BR><BR>
EOD;

	while ($rows > 0):
		$faq_obj = mysql_fetch_object($faq_query);
		$content .= <<<EOD
			<P><form action=faq_update.php method=post>
			<input type=hidden name=faq_id value="$faq_obj->faq_id">
			<input type=submit name=action value=Delete>
			<input type=submit name=action value=Update>
			$faq_obj->question</form></P>
EOD;
		--$rows;
		endwhile;
	$content .= <<<EOD
			</div>
		</div>
EOD;
	}
$content .= <<<EOD
		<div class="post">
			<div class="entry">
	<P><A HREF="faq_add.php">Add New FAQ</A></P>

			</div>
		</div>

EOD;

$display = str_replace("CONTENTPLACEHOLDER", $content, $wrapper);
echo $display;
?>