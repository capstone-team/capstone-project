<?PHP
$handle = fopen("header.txt","r");
$header = fread($handle,filesize("header.txt"));
fclose($handle);
echo $header;
mysql_connect("localhost","","");
mysql_select_db("lhucc_webdb");
if (strlen($username) > 0){
	$name_cond = "AND username LIKE '%$username%'";
	}
if ($equip_type != "Show All" and strlen($equip_type) > 0){
	$type_cond = "AND equip_type = '$equip_type'";
	}
if ($status != "Show All" and strlen($status) > 0){
	$status_cond = "AND status = '$status'";
	}
if (strlen($status) <= 0){
        $status_cond = "AND status = 'OPEN'";
	}
$loan_query = mysql_query("SELECT * FROM loanequip WHERE loan_id > 0 $name_cond $status_cond $type_cond ORDER BY status, start_date, username");
echo "
	<H2>Loaned Equipment List</H2>
	";
echo "
	<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
	<P>Narrow down this list:<BR>
	<TABLE BORDER=0>
	<TR><TD>Username: </TD><TD><INPUT TYPE=\"TEXT\" NAME=\"username\" SIZE=\"8\" MAXLENGTH=\"8\"></TD></TR>
        <TR><TD>Equipment Type: </TD><TD><SELECT NAME=\"equip_type\">
	                     <OPTION VALUE=\"Show All\">Show All</OPTION>
	                     <OPTION VALUE=\"Laptop\">Laptop</OPTION>
	                     <OPTION VALUE=\"Desktop\">Desktop</OPTION>
	                     <OPTION VALUE=\"Monitor\">Monitor</OPTION>
	                     <OPTION VALUE=\"Printer\">Printer</OPTION>
	                     <OPTION VALUE=\"Other\">Other</OPTION> </SELECT> </TD></TR>
        <TR><TD>Status: </TD><TD><SELECT NAME=\"status\">
	             <OPTION VALUE=\"Show All\">Show All</OPTION>
		     <OPTION VALUE=\"OPEN\" SELECTED>OPEN</OPTION>
		     <OPTION VALUE=\"CLOSED\">CLOSED</OPTION> </SELECT> </TD></TR>
	</TABLE>
	<INPUT TYPE=\"SUBMIT\" VALUE=\"Find\">
	</FORM></P>
	";
$rows = mysql_num_rows($loan_query);
echo "<TABLE BORDER=1>
	<TR>
		<TD>ID</TD>
		<TD>Username</TD>
		<TD>LHU Prop. #</TD>
		<TD>Loan Prop. #</TD>
		<TD>Equip. Type</TD>
		<TD>Start Date</TD>
		<TD>End Date</TD>
		<TD>Status</TD>
	</TR>";
while ($rows > 0):
	$loan_obj = mysql_fetch_object($loan_query);
	echo "
	<TR>
		<TD><A HREF=\"loan_disp.php?loan_id=$loan_obj->loan_id\">$loan_obj->loan_id</A></TD>
		<TD>$loan_obj->username</TD>
		<TD>$loan_obj->lhu_prop_num</TD>
		<TD>$loan_obj->loan_prop_num</TD>
		<TD>$loan_obj->equip_type</TD>
		<TD>$loan_obj->start_date</TD>
		<TD>$loan_obj->end_date</TD>
		<TD>$loan_obj->status</TD>
	</TR>";
	--$rows;
	endwhile;
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
