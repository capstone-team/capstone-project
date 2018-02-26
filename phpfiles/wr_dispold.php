<?PHP
$handle = fopen("header.txt","r");
$header = fread($handle,filesize("header.txt"));
fclose($handle);
echo $header;
mysql_connect("localhost","","");
mysql_select_db("lhucc_webdb");
if ($update == 'update') {
if ((strlen($req_uname) > 0) && (strlen($req_name) > 0) && (strlen($ph_num) > 0) &&
	(strlen($descrip) > 0) && (strlen($title))) {
	$req_uname = strtolower($req_uname);
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
	if (strlen($cc_comments) > 0) {
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
	if ($old_status != $status) {
		$mailmsg = 
"The status of your Computing and Instructional Technology Center
work request number $wr_id has been changed from $old_status to $status.
You can view more detailed information about your work request at
http://www.lhup.edu/computing_and_tech/wr_disp.php?wr_id=$wr_id.  If
you have any questions, please call the Computing and Instructional
Technology Hotline at x2286.";
		mail("$req_uname@lhup.edu", "Work Request No. $wr_id", $mailmsg,
     			"From: hotline@lhup.edu\r\n"
    			."Reply-To: hotline@lhup.edu\r\n"
    			."X-Mailer: PHP/" . phpversion());
		}
	if ($old_status != $status && $status == "Finished") {
		$mailmsg = 
"The Computing and Instructional Technology Center has completed your work
request regarding $title.  To better improve our services, we ask that you take
a few moments to fill out a customer satisfaction survey.  The survey can be found at
http://www.lhup.edu/computing_and_tech/wr_survey.php?wr_id=$wr_id.  Thank you for helping
us improve our service to you.";
		mail("$req_uname@lhup.edu", "Work Request Satisfaction Survey", $mailmsg,
     			"From: hotline@lhup.edu\r\n"
    			."Reply-To: hotline@lhup.edu\r\n"
    			."X-Mailer: PHP/" . phpversion());
		}

	}
	}
$wr_query = mysql_query("SELECT * FROM workrequests WHERE wr_id = $wr_id");
if (mysql_num_rows($wr_query) != 1) {
	echo "Error: No such request id";
	}
else {
	$wr_obj = mysql_fetch_object($wr_query);
	list ($due_date_yr, $due_date_mo, $due_date_day) = split ('-', $wr_obj->due_date);

        $staffopts = "<option value=\" \"> </option>
<option value=\"Andy Cajka\">Andy Cajka</option>
<option value=\"Boise Miller\">Boise Miller</option>
<option value=\"Brad Seyler\">Brad Seyler</option>
<option value=\"Brandi Kennedy\">Brandi Kennedy</option>
<option value=\"Brett Arnold\">Brett Arnold</option>
<option value=\"Brian Williamson\">Brian Williamson</option>
<option value=\"Carl Rosa\">Carl Rosa</option>
<option value=\"Christian Glotfelty\">Christian Glotfelty</option>
<option value=\"Fred Obiero\">Fred Obiero</option>
<option value=\"Greg Dicesare\">Greg Dicesare</option>
<option value=\"Ian Duer\">Ian Duer</option>
<option value=\"Jamie Walker\">Jamie Walker</option>
<option value=\"Jeff Walker\">Jeff Walker</option>
<option value=\"Jeffrey Sawyer\">Jeffrey Sawyer</option>
<option value=\"Jerry Eisley\">Jerry Eisley</option>
<option value=\"Jim Heiney\">Jim Heiney</option>
<option value=\"Joel Register\">Joel Register</option>
<option value=\"Joseph Reardon\">Joseph Reardon</option>
<option value=\"Josh Rote\">Josh Rote</option>
<option value=\"Justin Packer\">Justin Packer</option>
<option value=\"Manny Andrus\">Manny Andrus</option>
<option value=\"Melanie Parmenter\">Melanie Parmenter</option>
<option value=\"Norm Wisor\">Norm Wisor</option>
<option value=\"Paul Markert\">Paul Markert</option>
<option value=\"Randy Bordas\">Randy Bordas</option>
<option value=\"Rich Heimer\">Rich Heimer</option>
<option value=\"Rick Christian\">Rick Christian</option>
<option value=\"Steve Davis\">Steve Davis</option>
<option value=\"STSC\">STSC</option>
<option value=\"Tonia Guilfoy\">Tonia Guilfoy</option>";
	       
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
			if ($wr_obj->wr_type == "Comp. Move") {
				echo " SELECTED";
				}
			echo " VALUE=\"Comp. Move\">Comp. Move</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Phone") {
				echo " SELECTED";
				}
			echo " VALUE=\"Phone\">Phone</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Phone Move") {
				echo " SELECTED";
				}
			echo " VALUE=\"Phone Move\">Phone Move</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "Voice Mail") {
				echo " SELECTED";
				}
			echo " VALUE=\"Voice Mail\">Voice Mail</OPTION>
			<OPTION";
			if ($wr_obj->wr_type == "On Order") {
				echo " SELECTED";
				}
			echo " VALUE=\"On Order\">On Order</OPTION>
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
			if ($wr_obj->status == "Followup") {
				echo " SELECTED";
				}
			echo " VALUE=\"Finished\">Followup</OPTION>
			<OPTION";
			if ($wr_obj->status == "Closed") {
				echo " SELECTED";
				}
			echo " VALUE=\"Closed\">Closed</OPTION>
			</SELECT></TD>
	</TR>
	<TR>
		<TD>Created By:</TD>
		<TD>$wr_obj->creator</TD>
	</TR>
	<TR>
		<TD>CIT Staff:</TD>
		<TD><select name=\"cc_staff\">
			<option selected value=\"$wr_obj->cc_staff\">$wr_obj->cc_staff</option>
			$staffopts
		    </select></TD>
	</TR>
	<TR>
		<TD>CIT Staff:</TD>
		<TD><select name=\"cc_staff2\">
			<option selected value=\"$wr_obj->cc_staff2\">$wr_obj->cc_staff2</option>
			$staffopts
		    </select></TD>
	</TR>
	<TR>
		<TD>CIT Staff:</TD>
		<TD><select name=\"cc_staff3\">
			<option selected value=\"$wr_obj->cc_staff3\">$wr_obj->cc_staff3</option>
			$staffopts
		    </select></TD>
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
	$surveyquery = mysql_query("SELECT * FROM wr_survey where wr_id = $wr_obj->wr_id");
	if (mysql_num_rows($surveyquery)) {
		$surveyobj = mysql_fetch_object($surveyquery);
		echo "
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
			<td>Comments:</td>
			<td>$surveyobj->comments</td>
		</tr>
	</table>
	";
	}
	}
?>
	</td>
  </tr>
</table>
<br>
<table width="780" border="0">
  <tr>
    <td>
      <div align="center"> 
        <p><img src="bottom.gif" width="640" height="56"><br>
          <font size="1" face="ARIAL,HELVETICA"><b> <a href="http://www.lhup.edu/index.html"><font color="#EBEBEB">HOME</font></a><font color="#EBEBEB">&nbsp; 
          |&nbsp;</font><a href="http://www.lhup.edu/admissions/index.html"><font color="#EBEBEB">ADMISSIONS</font></a><font color="#EBEBEB">&nbsp; 
          |&nbsp;</font><a href="http://www.lhup.edu/academic/index.html"><font color="#EBEBEB">STUDENTS</font></a><font color="#EBEBEB">&nbsp; 
          |&nbsp;</font><a href="http://www.lhup.edu/alumni/index.html"><font color="#EBEBEB">ALUMNI</font></a><font color="#EBEBEB">&nbsp; 
          |&nbsp;</font><a href="http://www.lhup.edu/sports/index.htm"><font color="#EBEBEB">SPORTS</font></a><font color="#EBEBEB">&nbsp; 
          |&nbsp;</font><a href="http://www.lhup.edu/events/index.htm"><font color="#EBEBEB">EVENTS</font></a><font color="#EBEBEB">&nbsp; 
          |&nbsp;</font><a href="http://www.lhup.edu/site_index.htm"><font color="#EBEBEB">SITE 
          INDEX</font></a><br>
          Copyright 2002 Lock Haven University of PA - Site Design by Boise P. 
          Miller - LHUP Graphics by Scott Eldredge</b></font>
      </div>
    </td>
  </tr>
</table>
</body>
</html>
