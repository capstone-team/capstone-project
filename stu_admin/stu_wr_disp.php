<?PHP
foreach($_GET as $k => $v) $_GET[$k] = mysql_real_escape_string($v);
foreach($_POST as $k => $v) $_POST[$k] = mysql_real_escape_string($v);
foreach($_COOKIE as $k => $v) $_COOKIE[$k] = mysql_real_escape_string($v);
import_request_variables("gp");
$handle = fopen("header.txt","r");
$header = fread($handle,filesize("header.txt"));
fclose($handle);
echo $header;
mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");
if ($update == 'update') {
if ((strlen($req_uname) > 0) && (strlen($req_name) > 0) && (strlen($ph_num) > 0) &&
	(strlen($descrip) > 0) && (strlen($title))) {
	$req_uname = strtolower($req_uname);
	$req_name = mysql_real_escape_string($req_name);
	$title = mysql_real_escape_string($title);
	$descrip = mysql_real_escape_string($descrip);
	$fields = array("req_uname","req_name","ph_num","descrip","title");
	$values = array("'$req_uname'","'$req_name'","'$ph_num'","'$descrip'","'$title'");
	if (strlen($building) > 0) {
		array_push($fields,"building");
		array_push($values,"'$building'");
		}
	if (strlen($room_no) > 0) {
		array_push($fields,"room_no");
		array_push($values,"'$room_no'");
		}
	if (strlen($lhu_stu_id) > 0) {
		array_push($fields,"lhu_stu_id");
		array_push($values,"$lhu_stu_id");
		}
	if (strlen($wr_type) > 0) {
		array_push($fields,"wr_type");
		array_push($values,"'$wr_type'");
		}
	if (strlen($equip_type) > 0) {
		array_push($fields,"equip_type");
		array_push($values,"'$equip_type'");
		}
	if (strlen($mfg) > 0) {
		array_push($fields,"mfg");
		array_push($values,"'$mfg'");
		}
	if (strlen($model) > 0) {
		array_push($fields,"model");
		array_push($values,"'$model'");
		}
	if (strlen($serial) > 0) {
		array_push($fields,"serial");
		array_push($values,"'$serial'");
		}
	if (strlen($tag_num) > 0) {
		array_push($fields,"tag_num");
		array_push($values,"'$tag_num'");
		}
	if (strlen($status) > 0) {
		array_push($fields,"status");
		array_push($values,"'$status'");
		}
	if (strlen($cc_staff) > 0) {
		array_push($fields,"cc_staff");
		array_push($values,"'$cc_staff'");
		}
	if (strlen($passwds) > 0) {
		array_push($fields,"passwds");
		array_push($values,"'$passwds'");
		}
	if (strlen($cc_comments) > 0) {
		array_push($fields,"cc_comments");
		array_push($values,"'$cc_comments'");
		}
	if (($status == "Started" || $status == "Waiting") && $old_status == "Submitted") {
		array_push($fields,"start_date");
		array_push($values,"NOW()");
		}
	if ($status == "Finished" && $old_status != "Finished") {
		array_push($fields,"cmpl_date");
		array_push($values,"NOW()");
		}
	if ($format_perm == "yes") {
		array_push($fields,"format_perm");
		array_push($values,1);
		}
	else {
		array_push($fields,"format_perm");
		array_push($values,0);
		}
	if ($pwr_cord == "yes") {
		array_push($fields,"pwr_cord");
		array_push($values,1);
		}
	else {
		array_push($fields,"pwr_cord");
		array_push($values,0);
		}
	$query_str = "UPDATE stu_wr SET ";
	$iter = 0;
	while ($iter != (count($fields) - 1)):
		$query_str .= "$fields[$iter] = $values[$iter], ";
		++$iter;
		endwhile;
	$query_str .= "$fields[$iter] = $values[$iter] WHERE wr_id = $wr_id";
	mysql_query($query_str);
	if ($old_status != $status) {
		$mailmsg = 
"The status of your Student Technology Enhancement Program
work request number $wr_id has been changed from $old_status to $status.";
		mail("$req_uname@lhup.edu", "Work Request No. $wr_id", $mailmsg,
     			"From: stsc@lhup.edu\r\n"
    			."Reply-To: stsc@lhup.edu\r\n"
    			."X-Mailer: PHP/" . phpversion());
		}

	}
	}
$wr_query = mysql_query("SELECT * FROM stu_wr WHERE wr_id = $wr_id");
if (mysql_num_rows($wr_query) != 1) {
	echo "Error: No such request id";
	}
else {
	$wr_obj = mysql_fetch_object($wr_query);
	list ($due_date_yr, $due_date_mo, $due_date_day) = split ('-', $wr_obj->due_date);
	if ($wr_obj->format_perm == true) {
		$fpchecked = "checked=\"checked\"";
		}
	if ($wr_obj->pwr_cord == true) {
		$pcchecked = "checked=\"checked\"";
		}
	echo "
	<H2>Work Request Display <a href=\"wr_print.php?wr_id=$wr_obj->wr_id\" target=\"_blank\"><img src=\"printer.gif\" border=\"0\"></a></H2>
	<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
	<INPUT TYPE=\"HIDDEN\" NAME=\"update\" VALUE=\"update\">
	<INPUT TYPE=\"HIDDEN\" NAME=\"wr_id\" VALUE=\"$wr_obj->wr_id\">
	<INPUT TYPE=\"HIDDEN\" NAME=\"old_status\" VALUE=\"$wr_obj->status\">
	<TABLE BORDER = 0>
	<TR>
		<TD>Request ID:</TD>
		<TD>$wr_obj->wr_id</TD>
	</TR>
	<TR>
		<TD>Title:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"title\" SIZE=\"50\" MAXLENGTH=\"100\" VALUE=\"$wr_obj->title\"></TD>
	</TR>
	<TR>
		<TD>Requestor:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"req_name\" SIZE=\"40\" MAXLENGTH=\"40\" VALUE=\"$wr_obj->req_name\"></TD>
	</TR>
	<TR>
		<TD>Username:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"req_uname\" SIZE=\"8\" MAXLENGTH=\"8\" VALUE=\"$wr_obj->req_uname\"></TD>
	</TR>
	<TR>
		<TD>Building:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"building\" SIZE=\"4\" MAXLENGTH=\"4\" VALUE=\"$wr_obj->building\"></TD>
	</TR>
	<TR>
		<TD>Room No.:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"room_no\" SIZE=\"4\" MAXLENGTH=\"4\" VALUE=\"$wr_obj->room_no\"></TD>
	</TR>
	<TR>
		<TD>Phone No.:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"ph_num\" SIZE=\"12\" MAXLENGTH=\"12\" VALUE=\"$wr_obj->ph_num\"></TD>
	</TR>
	<TR>
		<TD>LHU Student ID:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"lhu_stu_id\" SIZE=\"6\" 
			MAXLENGTH=\"6\" VALUE=\"$wr_obj->lhu_stu_id\"></TD>
	</TR>
	<TR>
		<TD>WR Type:</TD>
		<TD><SELECT NAME=\"wr_type\">
			<OPTION";
			if ($wr_obj->wr_type == "Software") {
				echo " SELECTED";
				}
			echo " VALUE=\"Software\">Software</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Network") {
				echo " SELECTED";
				}
			echo " VALUE=\"Network\">Network</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "CCA") {
				echo " SELECTED";
				}
			echo " VALUE=\"CCA\">CCA</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Hardware") {
				echo " SELECTED";
				}
			echo " VALUE=\"Hardware\">Hardware</OPTION>
			</SELECT></TD>
	</TR>
	<TR>
		<TD>Equip. Type:</TD>
		<TD><SELECT NAME=\"equip_type\">
			<OPTION";
			if ($wr_obj->equip_type == "Laptop") {
				echo " SELECTED";
				}
			echo " VALUE=\"Laptop\">Laptop</OPTION>
			<OPTION";
			if ($wr_obj->equip_type == "Desktop") {
				echo " SELECTED";
				}
			echo " VALUE=\"Desktop\">Desktop/Tower</OPTION>
			<OPTION";
			if ($wr_obj->equip_type == "Printer") {
				echo " SELECTED";
				}
			echo " VALUE=\"Printer\">Printer</OPTION>
			<OPTION";
			if ($wr_obj->equip_type == "Other") {
				echo " SELECTED";
				}
			echo " VALUE=\"Other\">Other</OPTION>
			</SELECT></TD>
	</TR>
	<TR>
		<TD>Manufacturer:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"mfg\" SIZE=\"20\" 
			MAXLENGTH=\"20\" VALUE=\"$wr_obj->mfg\"></TD>
	</TR>
	<TR>
		<TD>Model No.:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"model\" SIZE=\"25\" 
			MAXLENGTH=\"25\" VALUE=\"$wr_obj->model\"></TD>
	</TR>
	<TR>
		<TD>Serial No.:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"serial\" SIZE=\"50\" 
			MAXLENGTH=\"50\" VALUE=\"$wr_obj->serial\"></TD>
	</TR>
	<TR>
		<TD>Toe Tag No.:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"tag_num\" SIZE=\"5\" 
			MAXLENGTH=\"3\" VALUE=\"$wr_obj->tag_num\"></TD>
	</TR>
	<TR>
		<TD>Permission to Format:</TD>
		<TD><INPUT TYPE=\"CHECKBOX\" NAME=\"format_perm\" VALUE=\"yes\" $fpchecked></TD>
	</TR>
	<TR>
		<TD>Has Power Cord:</TD>
		<TD><INPUT TYPE=\"CHECKBOX\" NAME=\"pwr_cord\" VALUE=\"yes\" $pcchecked></TD>
	</TR>
	<TR>
		<TD>Description:</TD>
		<TD><TEXTAREA NAME=\"descrip\" COLS=\"50\" ROWS=\"8\">$wr_obj->descrip</TEXTAREA></TD>
	</TR>
	<TR>
		<TD>Passwords:</TD>
		<TD><TEXTAREA NAME=\"passwds\" COLS=\"30\" ROWS=\"4\">$wr_obj->passwds</TEXTAREA></TD>
	</TR>
	<TR>
		<TD>Add Date:</TD>
		<TD>$wr_obj->add_date</TD>
	</TR>
	<TR>
		<TD>Start Date:</TD>
		<TD>$wr_obj->start_date</TD>
	</TR>
	<TR>
		<TD>Completion Date:</TD>
		<TD>$wr_obj->cmpl_date</TD>
	</TR>
	<TR>
		<TD>Status:</TD>
		<TD><SELECT NAME=\"status\">
			<OPTION";
			if ($wr_obj->status == "Submitted") {
				echo " SELECTED";
				}
			echo " VALUE=\"Submitted\">Submitted</OPTION>
			<OPTION";
			if ($wr_obj->status == "Started") {
				echo " SELECTED";
				}
			echo " VALUE=\"Started\">Started</OPTION>
			<OPTION";
			if ($wr_obj->status == "Waiting") {
				echo " SELECTED";
				}
			echo " VALUE=\"Waiting\">Waiting</OPTION>
			<OPTION";
			if ($wr_obj->status == "Cancelled") {
				echo " SELECTED";
				}
			echo " VALUE=\"Cancelled\">Cancelled</OPTION>
			<OPTION";
			if ($wr_obj->status == "Finished") {
				echo " SELECTED";
				}
			echo " VALUE=\"Finished\">Finished</OPTION>
			</SELECT></TD>
	</TR>
	<TR>
		<TD>CIT Staff:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"cc_staff\" SIZE=\"40\" MAXLENGTH=\"40\" VALUE=\"$wr_obj->cc_staff\"></TD>
	</TR>
	<TR>
		<TD>CIT Comments:</TD>
		<TD><TEXTAREA NAME=\"cc_comments\" COLS=\"50\" ROWS=\"8\">$wr_obj->cc_comments</TEXTAREA></TD>
	</TR>
	</TABLE>
	<INPUT TYPE=\"SUBMIT\" VALUE=\"Update Request Record\">
	</FORM>
	";
	}
?>
	</td>
  </tr>
</table>

</body>
</html>
