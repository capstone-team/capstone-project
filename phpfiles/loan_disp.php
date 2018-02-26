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
if ($update == 'update') {
if ((strlen($username) > 0) && (strlen($equip_type) > 0)) {
        $end_date = date("Y",time()) . "/" . date("m",time()) . "/" . date("d",time());
	$fields = array("username","equip_type","status");
	$values = array("'$username'","'$equip_type'","'$status'");
	if (strlen($lhu_prop_num) > 0) {
		array_push($fields,"lhu_prop_num");
		array_push($values,"$lhu_prop_num");
		}
	if (strlen($loan_prop_num) > 0) {
		array_push($fields,"loan_prop_num");
		array_push($values,"$loan_prop_num");
		}
	if (strlen($comments) > 0) {
		array_push($fields,"comments");
		array_push($values,"'$comments'");
		}
	if ($status == "CLOSED" && $old_status != "CLOSED") {
		array_push($fields,"end_date");
		array_push($values,"'$end_date'");
		}
	$query_str = "UPDATE loanequip SET ";
	$iter = 0;
	while ($iter != (count($fields) - 1)):
		$query_str .= "$fields[$iter] = $values[$iter], ";
		++$iter;
		endwhile;
	$query_str .= "$fields[$iter] = $values[$iter] WHERE loan_id = $loan_id";
	mysql_query($query_str);
	}
	}
$loan_query = mysql_query("SELECT * FROM loanequip WHERE loan_id = $loan_id");
if (mysql_num_rows($loan_query) != 1) {
		$content = <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Error!</a></h2>
			</div>
			<div class="entry">
                        <p>No such loan id.</p>
                        </div>
                </div>
EOD;
	}
else {
	$loan_obj = mysql_fetch_object($loan_query);
	$content = <<<EOD
	<div class="post">
		<div class="title">
			<h2><a href="#">Loaned Equipment Display</a></h2>
		</div>
		<div class="entry">
	<FORM ACTION="$PHP_SELF" METHOD="POST">
	<INPUT TYPE="HIDDEN" NAME="update" VALUE="update">
	<INPUT TYPE="HIDDEN" NAME="loan_id" VALUE="$loan_obj->loan_id">
	<INPUT TYPE="HIDDEN" NAME="old_status" VALUE="$loan_obj->status">
	<TABLE BORDER = 0>
	<TR>
		<TD>Loan ID:</TD>
		<TD>$loan_obj->loan_id</TD>
	</TR>
	<TR>
		<TD>Username:</TD>
		<TD><INPUT TYPE="TEXT" NAME="username" SIZE="8" MAXLENGTH="16" VALUE="$loan_obj->username"></TD>
	</TR>
	<TR>
		<TD>LHU Prop. # (Broken):</TD>
		<TD><INPUT TYPE="TEXT" NAME="lhu_prop_num" SIZE="6" 
			MAXLENGTH="6" VALUE="$loan_obj->lhu_prop_num"></TD>
	</TR>
	<TR>
		<TD>LHU Prop. # (Loaner):</TD>
		<TD><INPUT TYPE="TEXT" NAME="loan_prop_num" SIZE="6" 
			MAXLENGTH="6" VALUE="$loan_obj->loan_prop_num"></TD>
	</TR>
	<TR>
		<TD>Equip Type:</TD>
		<TD><SELECT NAME="equip_type">
			<OPTION
EOD;
			if ($loan_obj->equip_type == "Laptop") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Laptop\">Laptop</OPTION>
			<OPTION";
			if ($loan_obj->equip_type == "Desktop") {
			$content .= " SELECTED";
				}
			$content .= " VALUE=\"Desktop\">Desktop</OPTION>
			<OPTION";
			if ($loan_obj->equip_type == "Monitor") {
			$content .= " SELECTED";
				}
			$content .= " VALUE=\"Monitor\">Monitor</OPTION>
			<OPTION";
			if ($loan_obj->equip_type == "Printer") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Printer\">Printer</OPTION>
			<OPTION";
			if ($loan_obj->equip_type == "Other") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Other\">Other</OPTION>";
			$content .= <<<EOD
			</SELECT></TD>
	</TR>
	<TR>
		<TD>Start Date:</TD>
		<TD>$loan_obj->start_date</TD>
	</TR>
	<TR>
		<TD>End Date:</TD>
		<TD>$loan_obj->end_date</TD>
	</TR>
	<TR>
		<TD>Status:</TD>
		<TD><SELECT NAME="status">
			<OPTION
EOD;
			if ($loan_obj->status == "OPEN") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"OPEN\">OPEN</OPTION>
			<OPTION";
			if ($loan_obj->status == "CLOSED") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"CLOSED\">CLOSED</OPTION>";
			$content .= <<<EOD
			</SELECT></TD>
	</TR>
	<TR>
		<TD>Comments:</TD>
		<TD><TEXTAREA NAME="comments" COLS="50" ROWS="8">$loan_obj->comments</TEXTAREA></TD>
	</TR>
	</TABLE>
	<INPUT TYPE="SUBMIT" VALUE="Update Request Record">
	</FORM>
			</div>
		</div>

EOD;
	}
$display = str_replace("CONTENTPLACEHOLDER", $content, $wrapper);
echo $display;
?>