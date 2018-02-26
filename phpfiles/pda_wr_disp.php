<html>
<head>
<title>LHUP Computing Center</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>


<?PHP
foreach($_GET as $k => $v) $_GET[$k] = addslashes($v);
foreach($_POST as $k => $v) $_POST[$k] = addslashes($v);
foreach($_COOKIE as $k => $v) $_COOKIE[$k] = addslashes($v);
import_request_variables("gp");
mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");
if ($update == 'update') {
if ((strlen($req_uname) > 0) && (strlen($req_name) > 0) && (strlen($ph_num) > 0) &&
	(strlen($descrip) > 0) && (strlen($title))) {
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
	if (strlen($lhu_prop_num) > 0) {
		array_push($fields,"lhu_prop_num");
		array_push($values,"$lhu_prop_num");
		}
	if (strlen($wr_type) > 0) {
		array_push($fields,"wr_type");
		array_push($values,"'$wr_type'");
		}
	if (strlen($due_date_yr) > 0 && strlen($due_date_mo) > 0 && strlen($due_date_day) > 0) {
		array_push($fields,"due_date");
		array_push($values,"'$due_date_yr-$due_date_mo-$due_date_day'");
		}
	if (strlen($status) > 0) {
		array_push($fields,"status");
		array_push($values,"'$status'");
		}
	if (strlen($cc_staff) > 0) {
		array_push($fields,"cc_staff");
		array_push($values,"'$cc_staff'");
		}
	if (strlen($priority) > 0) {
		array_push($fields,"priority");
		array_push($values,"$priority");
		}
	if (strlen($cc_comments) > 0) {
		array_push($fields,"cc_comments");
		array_push($values,"'$cc_comments'");
		}
	if (($status == "Started" || $status == "Waiting") && $old_status == "Approved") {
		array_push($fields,"start_date");
		array_push($values,"NOW()");
		}
	$query_str = "UPDATE workrequests SET ";
	$iter = 0;
	while ($iter != (count($fields) - 1)):
		$query_str .= "$fields[$iter] = $values[$iter], ";
		++$iter;
		endwhile;
	$query_str .= "$fields[$iter] = $values[$iter] WHERE wr_id = $wr_id";
	mysql_query($query_str);
	}
	}
$wr_query = mysql_query("SELECT * FROM workrequests WHERE wr_id = $wr_id");
if (mysql_num_rows($wr_query) != 1) {
	echo "Error: No such request id";
	}
else {
	$wr_obj = mysql_fetch_object($wr_query);
	list ($due_date_yr, $due_date_mo, $due_date_day) = split ('-', $wr_obj->due_date);
	echo "
	<H2>Work Request Display</H2>
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
		<TD>LHU Tag:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"lhu_prop_num\" SIZE=\"6\" 
			MAXLENGTH=\"6\" VALUE=\"$wr_obj->lhu_prop_num\"></TD>
	</TR>
	<TR>
		<TD>WR Type:</TD>
		<TD><SELECT NAME=\"wr_type\">
			<OPTION";
			if ($wr_obj->wr_type == "Hardware") {
				echo " SELECTED";
				}
			echo " VALUE=\"Hardware\">Hardware</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Software") {
				echo " SELECTED";
				}
			echo " VALUE=\"Software\">Software</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Install") {
				echo " SELECTED";
				}
			echo " VALUE=\"Install\">Install</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Network") {
				echo " SELECTED";
				}
			echo " VALUE=\"Network\">Network</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Account") {
				echo " SELECTED";
				}
			echo " VALUE=\"Account\">Account</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "CARS") {
				echo " SELECTED";
				}
			echo " VALUE=\"CARS\">CARS</OPTION>
			</SELECT></TD>
	</TR>
	<TR>
		<TD>Description:</TD>
		<TD><TEXTAREA NAME=\"descrip\" COLS=\"50\" ROWS=\"8\">$wr_obj->descrip</TEXTAREA></TD>
	</TR>
	<TR>
		<TD>Add Date:</TD>
		<TD>$wr_obj->add_date</TD>
	</TR>
	<TR>
		<TD>Due Date (mm-dd-yyyy):</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"due_date_mo\" SIZE=\"2\" MAXLENGTH=\"2\" VALUE=\"$due_date_mo\">
		-<INPUT TYPE=\"TEXT\" NAME=\"due_date_day\" SIZE=\"2\" MAXLENGTH=\"2\" VALUE=\"$due_date_day\">
		-<INPUT TYPE=\"TEXT\" NAME=\"due_date_yr\" SIZE=\"4\" MAXLENGTH=\"4\" VALUE=\"$due_date_yr\"></TD>
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
			if ($wr_obj->status == "Approved") {
				echo " SELECTED";
				}
			echo " VALUE=\"Approved\">Approved</OPTION>
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
			<OPTION";
			if ($wr_obj->status == "Closed") {
				echo " SELECTED";
				}
			echo " VALUE=\"Closed\">Closed</OPTION>
			</SELECT></TD>
	</TR>
	<TR>
		<TD>CIT Staff:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"cc_staff\" SIZE=\"40\" MAXLENGTH=\"40\" VALUE=\"$wr_obj->cc_staff\"></TD>
	</TR>
	<TR>
		<TD>Start Date:</TD>
		<TD>$wr_obj->start_date</TD>
	</TR>
	<TR>
		<TD>Priority (0-9):</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"priority\" SIZE=\"1\" MAXLENGTH=\"1\" VALUE=\"$wr_obj->priority\"></TD>
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

</body>
</html>
