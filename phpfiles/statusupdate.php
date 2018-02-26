<?PHP
foreach($_GET as $k => $v) $_GET[$k] = addslashes($v);
foreach($_POST as $k => $v) $_POST[$k] = addslashes($v);
foreach($_COOKIE as $k => $v) $_COOKIE[$k] = addslashes($v);
import_request_variables("gp");
include("FCKeditor/fckeditor.php");
$handle = fopen("wrapper.txt","r");
$wrapper = fread($handle,filesize("wrapper.txt"));
fclose($handle);
mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");

if ((strlen($message_data) > 0) || (strlen($poster_name) > 0)) {
	if ((strlen($message_data) > 0) && (strlen($poster_name) > 0)) {
		mysql_query("INSERT INTO messages (post_date,poster_name,message_data,exp_date)
			VALUES (NOW(),'$poster_name','$message_data','$exp_yr-$exp_mo-$exp_day')");
		$content = <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Success!</a></h2>
			</div>
			<div class="entry">
                        <p>Message Posted.</p>
                        </div>
                </div>
EOD;
		}
	else {
		$content = <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Error!</a></h2>
			</div>
			<div class="entry">
                        <p>Content and Name required to post message.</p>
                        </div>
                </div>
EOD;
		}
	}
$content .= <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Status Message Update</a></h2>
			</div>
			<div class="entry">
	<P>HTML formatting can be used to include hyperlinks.  Please remember to close HTML tags.</P>

		<FORM ACTION="$PHP_SELF" METHOD="POST">
			Message Content:<br>
			<!---<TEXTAREA NAME="message_data" COLS="40" ROWS="5"></TEXTAREA>-->
EOD;
		        $mFCKeditor = new FCKeditor('message_data') ;
		        $mFCKeditor->BasePath = 'FCKeditor/';
		        $mFCKeditor->Value = "Type message to be displayed here";
		        $content .= $mFCKeditor->CreateHTML() ;

$content .= <<<EOD
		<TABLE BORDER=0>
		<TR>
		<TR>
			<TD>Posted By:</TD>
			<TD><INPUT TYPE="TEXT" NAME="poster_name" SIZE="40"
				MAXLENGTH="40"></TD>
		</TR>
		<TR>
			<TD>Expire On:</TD>
			<TD><INPUT TYPE="TEXT" NAME="exp_mo" SIZE="2" MAXLENGTH="2">
			-<INPUT TYPE="TEXT" NAME="exp_day" SIZE="2" MAXLENGTH="2">
			-<INPUT TYPE="TEXT" NAME="exp_yr" SIZE="4" MAXLENGTH="4"></TD>
		</TR>
		</TABLE>
		<INPUT TYPE="SUBMIT" VALUE="Post Message">
		</FORM>

			</div>
		</div>

EOD;

$display = str_replace("CONTENTPLACEHOLDER", $content, $wrapper);
echo $display;
?>