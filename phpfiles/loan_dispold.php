<?PHP
$handle = fopen("header.txt","r");
$header = fread($handle,filesize("header.txt"));
fclose($handle);
echo $header;
mysql_connect("localhost","","");
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
	echo "Error: No such request id";
	}
else {
	$loan_obj = mysql_fetch_object($loan_query);
	echo "
	<H2>Loaned Equipment Display</H2>
	<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
	<INPUT TYPE=\"HIDDEN\" NAME=\"update\" VALUE=\"update\">
	<INPUT TYPE=\"HIDDEN\" NAME=\"loan_id\" VALUE=\"$loan_obj->loan_id\">
	<INPUT TYPE=\"HIDDEN\" NAME=\"old_status\" VALUE=\"$loan_obj->status\">
	<TABLE BORDER = 0>
	<TR>
		<TD>Loan ID:</TD>
		<TD>$loan_obj->loan_id</TD>
	</TR>
	<TR>
		<TD>Username:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"username\" SIZE=\"8\" MAXLENGTH=\"16\" VALUE=\"$loan_obj->username\"></TD>
	</TR>
	<TR>
		<TD>LHU Prop. # (Broken):</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"lhu_prop_num\" SIZE=\"6\" 
			MAXLENGTH=\"6\" VALUE=\"$loan_obj->lhu_prop_num\"></TD>
	</TR>
	<TR>
		<TD>LHU Prop. # (Loaner):</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"loan_prop_num\" SIZE=\"6\" 
			MAXLENGTH=\"6\" VALUE=\"$loan_obj->loan_prop_num\"></TD>
	</TR>
	<TR>
		<TD>Equip Type:</TD>
		<TD><SELECT NAME=\"equip_type\">
			<OPTION";
			if ($loan_obj->equip_type == "Laptop") {
				echo " SELECTED";
				}
			echo " VALUE=\"Laptop\">Laptop</OPTION>
			<OPTION";
			if ($loan_obj->equip_type == "Desktop") {
				echo " SELECTED";
				}
			echo " VALUE=\"Desktop\">Desktop</OPTION>
			<OPTION";
			if ($loan_obj->equip_type == "Monitor") {
				echo " SELECTED";
				}
			echo " VALUE=\"Monitor\">Monitor</OPTION>
			<OPTION";
			if ($loan_obj->equip_type == "Printer") {
				echo " SELECTED";
				}
			echo " VALUE=\"Printer\">Printer</OPTION>
			<OPTION";
			if ($loan_obj->equip_type == "Other") {
				echo " SELECTED";
				}
			echo " VALUE=\"Other\">Other</OPTION>
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
		<TD><SELECT NAME=\"status\">
			<OPTION";
			if ($loan_obj->status == "OPEN") {
				echo " SELECTED";
				}
			echo " VALUE=\"OPEN\">OPEN</OPTION>
			<OPTION";
			if ($loan_obj->status == "CLOSED") {
				echo " SELECTED";
				}
			echo " VALUE=\"CLOSED\">CLOSED</OPTION>
			</SELECT></TD>
	</TR>
	<TR>
		<TD>Comments:</TD>
		<TD><TEXTAREA NAME=\"comments\" COLS=\"50\" ROWS=\"8\">$loan_obj->comments</TEXTAREA></TD>
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
