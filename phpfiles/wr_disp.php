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
	if (strlen($cc_staff2) > 0) {
		array_push($fields,"cc_staff2");
		array_push($values,"'$cc_staff2'");
		}
	if (strlen($cc_staff3) > 0) {
		array_push($fields,"cc_staff3");
		array_push($values,"'$cc_staff3'");
		}
	if (strlen($priority) > 0) {
		array_push($fields,"priority");
		array_push($values,"$priority");
		}
	else {
		array_push($fields,"priority");
		array_push($values,"5");
		}
	if (strlen($cc_comments) <= 0) { $cc_comments = " "; }
	if (strlen($cc_comments) > 0) {
		$cc_comments = mysql_real_escape_string($cc_comments);
		array_push($fields,"cc_comments");
		array_push($values,"'$cc_comments'");
		}
	if (($status == "Started" || $status == "Waiting") && $old_status == "Approved") {
		array_push($fields,"start_date");
		array_push($values,"NOW()");
		}
	if ($status == "Finished" && $old_status != "Finished") {
		array_push($fields,"cmpl_date");
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
	if ($old_status != $status && $send_email == "Yes") {
		$mailmsg = 
"The status of your IT Department work request number $wr_id ($title) has been changed from $old_status to $status. You can view more detailed information about your work request at http://hitman.lhup.edu/wr_disp.php?wr_id=$wr_id.  If you have any questions, please call the IT Helpdesk at x2286.";
		mail("$req_uname@lhup.edu", "Work Request No. $wr_id", $mailmsg,
     			"From: helpdesk@lhup.edu\r\n"
    			."Reply-To: helpdesk@lhup.edu\r\n"
    			."X-Mailer: PHP/" . phpversion());
		}
	if ($old_status != $status && $status == "Finished") {
		$mailmsg = 
"The IT Department has completed your work request regarding $title.  To better improve our services, we ask that you take a few moments to fill out a customer satisfaction survey.  The survey can be found at http://hitman.lhup.edu/wr_survey.php?wr_id=$wr_id.  Thank you for helping us improve our service to you.";
		mail("$req_uname@lhup.edu", "Work Request Satisfaction Survey", $mailmsg,
     			"From: helpdesk@lhup.edu\r\n"
    			."Reply-To: helpdesk@lhup.edu\r\n"
    			."X-Mailer: PHP/" . phpversion());
		}

	}
	}
$wr_query = mysql_query("SELECT * FROM workrequests WHERE wr_id = $wr_id");
if (mysql_num_rows($wr_query) != 1) {
	$content .= "Debug data:" . $_GET["wr_id"];
	$content .= <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Error!</a></h2>
			</div>
			<div class="entry">
                        <p>No such work request id.</p>
                        </div>
                </div>
EOD;
	}
else {
	$wr_obj = mysql_fetch_object($wr_query);
	list ($due_date_yr, $due_date_mo, $due_date_day) = split ('-', $wr_obj->due_date);

        $staffopts = "<option value=\" \"> </option>
<option value=\"Boise Miller\">Boise Miller</option>
<option value=\"Dustin Keith\">Dustin Keith</option>
<option value=\"Jamie Walker\">Jamie Walker</option>
<option value=\"Jan Bottorf\">Jan Bottorf</option>
<option value=\"Jeff Walker\">Jeff Walker</option>
<option value=\"Jeffrey Sawyer\">Jeffrey Sawyer</option>
<option value=\"Jerry Eisley\">Jerry Eisley</option>
<option value=\"Jim Heiney\">Jim Heiney</option>
<option value=\"Joan Walker\">Joan Walker</option>
<option value=\"Joel Register\">Joel Register</option>
<option value=\"Manny Andrus\">Manny Andrus</option>
<option value=\"Melanie Parmenter\">Melanie Parmenter</option>
<option value=\"Paul Markert\">Paul Markert</option>
<option value=\"Randy Bordas\">Randy Bordas</option>
<option value=\"Rich Heimer\">Rich Heimer</option>
<option value=\"Rick Christian\">Rick Christian</option>
<option value=\"Scott Schreiber\">Scott Schreiber</option>
<option value=\"Steve Davis\">Steve Davis</option>
<option value=\"Tim Cervinsky\">Tim Cervinsky</option>
<!---<option value=\"STSC\">STSC</option>-->
<option value=\" \">*********</option>
<option value=\"Angie Ndungu\">Angie Ndungu</option>
<option value=\"Arpit Patel\">Arpit Patel</option>
<option value=\"Avery McCown\">Avery McCown</option>
<option value=\"Brandon Singer\">Brandon Singer</option>
<option value=\"Cardan Robinson\">Cardan Robinson</option>
<option value=\"Caroline Rublein\">Caroline Rublein</option>
<option value=\"Catherine Brown\">Catherine Brown</option>
<option value=\"Gordon Draine\">Gordon Draine</option>
<option value=\"Haley Wilkinson\">Haley Wilkinson</option>
<option value=\"Hanna Fitch\">Hanna Fitch</option>
<option value=\"Ian Fixemer\">Ian Fixemer</option>
<option value=\"Jeremiah Hoy\">Jeremiah Hoy</option>
<option value=\"Logan Horst\">Logan Horst</option>
<option value=\"Luke Heidel\">Luke Heidel</option>
<option value=\"Luke Vandament\">Luke Vandament</option>
<option value=\"Lydia Runkle\">Lydia Runkle</option>
<option value=\"Matt Behrens\">Matt Behrens</option>
<option value=\"Matt Holt\">Matt Holt</option>
<option value=\"Nathan Ulmer\">Nathan Ulmer</option>
<option value=\"Nick Hall\">Nick Hall</option>
<option value=\"Sean Robert\">Sean Robert</option>
<option value=\"Serenity Schon\">Serenity Schon</option>
<option value=\"Taylor Johnston\">Taylor Johnston</option>
<option value=\"Valerie Cesare\">Valerie Cesare</option>
";
	       
$content .= <<<EOD
		<div class="post">
			<div class="title">
				<h2>
                                  <a href="#">Work Request Display</a>
                                  <a href="wr_print.php?wr_id=$wr_obj->wr_id" target="_blank"><img src="printer.gif" border="0"></a>
                                </h2>
			</div>
			<div class="entry">
	<FORM ACTION="$PHP_SELF" METHOD="POST">
	<INPUT TYPE="HIDDEN" NAME="update" VALUE="update">
	<INPUT TYPE="HIDDEN" NAME="wr_id" VALUE="$wr_obj->wr_id">
	<INPUT TYPE="HIDDEN" NAME="old_status" VALUE="$wr_obj->status">
	<TABLE BORDER = 0>
	<TR>
		<TD>Request ID:</TD>
		<TD>$wr_obj->wr_id</TD>
	</TR>
	<TR>
		<TD>Title:</TD>
		<TD><INPUT TYPE="TEXT" NAME="title" SIZE="50" MAXLENGTH="100" VALUE="$wr_obj->title"></TD>
	</TR>
	<TR>
		<TD>Requestor:</TD>
		<TD><INPUT TYPE="TEXT" NAME="req_name" SIZE="40" MAXLENGTH="40" VALUE="$wr_obj->req_name"></TD>
	</TR>
	<TR>
		<TD>Username:</TD>
		<TD><INPUT TYPE="TEXT" NAME="req_uname" SIZE="8" MAXLENGTH="8" VALUE="$wr_obj->req_uname"></TD>
	</TR>
	<TR>
		<TD>Building:</TD>
		<TD><INPUT TYPE="TEXT" NAME="building" SIZE="4" MAXLENGTH="4" VALUE="$wr_obj->building"></TD>
	</TR>
	<TR>
		<TD>Room No.:</TD>
		<TD><INPUT TYPE="TEXT" NAME="room_no" SIZE="4" MAXLENGTH="4" VALUE="$wr_obj->room_no"></TD>
	</TR>
	<TR>
		<TD>Phone No.:</TD>
		<TD><INPUT TYPE="TEXT" NAME="ph_num" SIZE="12" MAXLENGTH="12" VALUE="$wr_obj->ph_num"></TD>
	</TR>
	<TR>
		<TD>LHU Tag:</TD>
		<TD><INPUT TYPE="TEXT" NAME="lhu_prop_num" SIZE="6" 
			MAXLENGTH="6" VALUE="$wr_obj->lhu_prop_num"></TD>
	</TR>
	<TR>
		<TD>WR Type:</TD>
		<TD><SELECT NAME="wr_type">
			<OPTION
EOD;
			if ($wr_obj->wr_type == "Hardware") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Hardware\">Hardware</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Software") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Software\">Software</OPTION>
                        <OPTION";
			if ($wr_obj->wr_type == "HelpDesk") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"HelpDesk\">HelpDesk</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Install") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Install\">Install</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Network") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Network\">Network</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Account") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Account\">Account</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Comp. Move") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Comp. Move\">Comp. Move</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Phone") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Phone\">Phone</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Phone Move") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Phone Move\">Phone Move</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Voice Mail") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Voice Mail\">Voice Mail</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "On Order") {
				$content .= " SELECTED";
				}
$content .= <<<EOD
 VALUE="On Order">On Order</OPTION>
			</SELECT></TD>
	</TR>
	<TR>
		<TD>Description:</TD>
		<TD><TEXTAREA NAME="descrip" COLS="50" ROWS="8">$wr_obj->descrip</TEXTAREA></TD>
	</TR>
	<TR>
		<TD>Add Date:</TD>
		<TD>$wr_obj->add_date</TD>
	</TR>
	<TR>
		<TD>Due Date (mm-dd-yyyy):</TD>
		<TD><INPUT TYPE="TEXT" NAME="due_date_mo" SIZE="2" MAXLENGTH="2" VALUE="$due_date_mo">
		-<INPUT TYPE="TEXT" NAME="due_date_day" SIZE="2" MAXLENGTH="2" VALUE="$due_date_day">
		-<INPUT TYPE="TEXT" NAME="due_date_yr" SIZE="4" MAXLENGTH="4" VALUE="$due_date_yr"></TD>
	</TR>
	<TR>
		<TD>Completion Date:</TD>
		<TD>$wr_obj->cmpl_date</TD>
	</TR>
	<TR>
		<TD>Status:</TD>
		<TD><SELECT NAME="status">
			<OPTION
EOD;
	if ($wr_obj->status == "Submitted" || $wr_obj->status == "Approved") {
			if ($wr_obj->status == "Submitted") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Submitted\">Submitted</OPTION>
			<OPTION";
			if ($wr_obj->status == "Approved") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Approved\">Approved</OPTION>
			<OPTION";
			if ($wr_obj->status == "Started") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Started\">Started</OPTION>
			<OPTION";
			if ($wr_obj->status == "Cancelled") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Cancelled\">Cancelled</OPTION>";
		}
	else {
			if ($wr_obj->status == "Submitted") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Submitted\">Submitted</OPTION>
			<OPTION";
			if ($wr_obj->status == "Approved") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Approved\">Approved</OPTION>
			<OPTION";
			if ($wr_obj->status == "Started") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Started\">Started</OPTION>
			<OPTION";
			if ($wr_obj->status == "Waiting") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Waiting\">Waiting</OPTION>
			<OPTION";
			if ($wr_obj->status == "Cancelled") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Cancelled\">Cancelled</OPTION>
			<OPTION";
			if ($wr_obj->status == "Finished") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Finished\">Finished</OPTION>
			<OPTION";
			if ($wr_obj->status == "Followup") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Followup\">Followup</OPTION>";
		if ($wr_obj->status == "Cancelled" || $wr_obj->status == "Finished" || $wr_obj->status == "Followup" ||
				$wr_obj->status == "Closed") {
			$content .= "<OPTION";
			if ($wr_obj->status == "Closed") {
				$content .= " SELECTED";
				}
			$content .= " VALUE=\"Closed\">Closed</OPTION>";
			}
		}
$content .= <<<EOD
			</SELECT></TD>
	</TR>
	<TR>
		<TD>Created By:</TD>
		<TD>$wr_obj->creator</TD>
	</TR>
	<TR>
		<TD>IT Staff:</TD>
		<TD><select name="cc_staff">
			<option selected value="$wr_obj->cc_staff">$wr_obj->cc_staff</option>
			$staffopts
		    </select></TD>
	</TR>
	<TR>
		<TD>IT Staff:</TD>
		<TD><select name="cc_staff2">
			<option selected value="$wr_obj->cc_staff2">$wr_obj->cc_staff2</option>
			$staffopts
		    </select></TD>
	</TR>
	<TR>
		<TD>IT Staff:</TD>
		<TD><select name="cc_staff3">
			<option selected value="$wr_obj->cc_staff3">$wr_obj->cc_staff3</option>
			$staffopts
		    </select></TD>
	</TR>
	<TR>
		<TD>Start Date:</TD>
		<TD>$wr_obj->start_date</TD>
	</TR>
	<TR>
		<TD>Priority (0-9):</TD>
		<TD><INPUT TYPE="TEXT" NAME="priority" SIZE="1" MAXLENGTH="1" VALUE="$wr_obj->priority"></TD>
	</TR>
	<TR>
		<TD>IT Comments:</TD>
		<TD><TEXTAREA NAME="cc_comments" COLS="50" ROWS="8">$wr_obj->cc_comments</TEXTAREA></TD>
	</TR>
	<TR>
		<TD>Send Status Email:</TD>
		<TD><input type="checkbox" name="send_email" value="Yes" checked></TD>
	</TR>
	</TABLE>
	<INPUT TYPE="SUBMIT" VALUE="Update Request Record">
	</FORM>
EOD;
	$surveyquery = mysql_query("SELECT * FROM wr_survey where wr_id = $wr_obj->wr_id");
	if (mysql_num_rows($surveyquery)) {
		$surveyobj = mysql_fetch_object($surveyquery);
		$content .= <<<EOD
	<p><b>Survey Information</b><p>
	<table border=0>
		<tr>
			<td>Overall Score:</td>
			<td>$surveyobj->overall_score</td>
		</tr>
		<tr>
			<td>Tech Score:</td>
			<td>$surveyobj->tech_score</td>
		</tr>
		<tr>
			<td>Timeliness Score:</td>
			<td>$surveyobj->time_score</td>
		</tr>
		<tr>
			<td>Helpdesk Score:</td>
			<td>$surveyobj->help_score</td>
		</tr>
		<tr>
			<td>Comments:</td>
			<td>$surveyobj->comments</td>
		</tr>
	</table>
EOD;
	}

$content .= <<<EOD
	</div>
		</div>

EOD;
	}
$display = str_replace("CONTENTPLACEHOLDER", $content, $wrapper);
echo $display;
?>