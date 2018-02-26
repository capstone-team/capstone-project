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

$incomp = 0;
if ((strlen($username) > 0) && (strlen($equip_type) > 0)) {
	$start_date = date("Y",time()) . "/" . date("m",time()) . "/" . date("d",time());
	$fields = "username, equip_type, start_date, status";
	$values = "'$username','$equip_type','$start_date','OPEN'";
	if (strlen($lhu_prop_num) > 0) {
		$fields .= ",lhu_prop_num";
		$values .= ",$lhu_prop_num";
		}
	if (strlen($loan_prop_num) > 0) {
		$fields .= ",loan_prop_num";
		$values .= ",$loan_prop_num";
		}
	if (strlen($comments) > 0) {
		$fields .= ",comments";
		$values .= ",'$comments'";
		}
	$query = "INSERT INTO loanequip ($fields) VALUES ($values)";
	mysql_query($query);
	$content = <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Success!</a></h2>
			</div>
			<div class="entry">
                        <p>The loan record has been added.  Thank you.</p>
                        </div>
                </div>
EOD;
	}

else if ($action == "Submit" ) {
	$content = <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Error!</a></h2>
			</div>
			<div class="entry">
                        <p>Not all required fields were filled out.  Please press the back button, check for errors, and 				resubmit.</p>
                        </div>
                </div>
EOD;

	$incomp = 1;
	}

if ($incomp != 1) {
$content .= <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Add an equipment loan record</a></h2>
			</div>
			<div class="entry">
	<FORM ACTION="$PHP_SELF" METHOD="POST">
	<TABLE BORDER=0>
	<TR>
	<TD>*Borrower Username:</TD>
	<TD><INPUT TYPE="TEXT" NAME="username" SIZE="8" MAXLENGTH="16"></TD>
	</TR>
	<TR>
	<TD>LHU Property No. of Broken Equipment:</TD>
	<TD><INPUT TYPE="TEXT" NAME="lhu_prop_num" SIZE="6" MAXLENGTH="6"></TD>
	</TR>
	<TR>
	<TD>LHU Property No. of Loaner Equipment:</TD>
	<TD><INPUT TYPE="TEXT" NAME="loan_prop_num" SIZE="6" MAXLENGTH="6"></TD>
	</TR>
	<TR>
	<TD>Equipment Type:</TD>
	<TD><SELECT NAME="equip_type">
		<OPTION VALUE="Laptop">Laptop</OPTION>
		<OPTION VALUE="Desktop">Desktop</OPTION>
		<OPTION VALUE="Monitor">Monitor</OPTION>
		<OPTION VALUE="Printer">Printer</OPTION>
		<OPTION VALUE="Other">Other</OPTION>
		</SELECT></TD>
	</TR>
	<TR>
	<TD>Comments:</TD>
	<TD><TEXTAREA NAME="comments" ROWS="8" COLS="40"></TEXTAREA></TD>
	</TABLE>
	<B>Fields Marked with an Asterick (*) are required.  If you do not complete these
	you will be redirected back to this page</B><BR><BR>
	<INPUT TYPE="SUBMIT" NAME="action" VALUE="Submit">
	</FORM>
			</div>
		</div>

EOD;
	}

$display = str_replace("CONTENTPLACEHOLDER", $content, $wrapper);
echo $display;
?>