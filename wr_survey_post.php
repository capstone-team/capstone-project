<?PHP
foreach($_GET as $k => $v) $_GET[$k] = mysql_real_escape_string($v);
foreach($_POST as $k => $v) $_POST[$k] = mysql_real_escape_string($v);
foreach($_COOKIE as $k => $v) $_COOKIE[$k] = mysql_real_escape_string($v);
import_request_variables("gp");
$handle = fopen("wrapper.txt","r");
$wrapper = fread($handle,filesize("wrapper.txt"));
fclose($handle);
mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");
$wr_query = mysql_query("SELECT * FROM workrequests WHERE wr_id = $wr_id");
if (mysql_num_rows($wr_query) != 1) {
$content = <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Error!</a></h2>
			</div>
			<div class="entry">
                        <p>That work request does not exist.</p>
                        </div>
                </div>
EOD;
	}
else {
	if ($overall_score < 1) {
		$overall_score = 10;
		}
	if ($tech_score < 1) {
		$tech_score = 10;
		}
	if ($time_score < 1) {
		$time_score = 10;
		}
	if ($help_score < 1) {
		$help_score = 10;
		}
	mysql_query("INSERT INTO wr_survey (wr_id, overall_score, tech_score, time_score, help_score, comments) VALUES ($wr_id,$overall_score,$tech_score,$time_score,$help_score,'$comments')");
	if ($overall_score <= 6 || $tech_score <= 6 || $time_score <= 6 || $help_score <= 6){
		mysql_query("UPDATE workrequests SET status = 'Followup' WHERE wr_id = $wr_id");
		$msg_txt = "An unsatisfactory WR survey has been completed.  Please review the WR at http://hitman.lhup.edu/admin/wr_disp.php?wr_id=$wr_id and contact the requestor.";
		mail("helpdesk@lhup.edu","Unsatisfactory Work Request Survey",$msg_txt);
		}
	else {
		mysql_query("UPDATE workrequests SET status = 'Closed' WHERE wr_id = $wr_id");
		}
$content = <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Work Request Satisfaction Survey</a></h2>
			</div>
			<div class="entry">
                        <p>Thank you for completing the survey.</p>
                        </div>
                </div>
EOD;
	}

$display = str_replace("CONTENTPLACEHOLDER", $content, $wrapper);
echo $display;
?>