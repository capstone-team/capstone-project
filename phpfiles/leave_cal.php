<?PHP
import_request_variables("gp");
$handle = fopen("header.txt","r");
$header = fread($handle,filesize("header.txt"));
fclose($handle);
echo $header;
mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");
echo "
	<H3>Staff Out Today</H3>
	";
$staffout_query = mysql_query("SELECT person,comments FROM leavecalendar
	WHERE leave_date = CURDATE()");
$rows = mysql_num_rows($staffout_query);
if ($rows == 0) {
	echo "
		None
		";
	}
else {
	echo "<UL>";
	while ($rows != 0):
		$staffout_obj = mysql_fetch_object($staffout_query);
		echo "
			<LI>$staffout_obj->person - $staffout_obj->comments</LI>
			";
		--$rows;
		endwhile;
	echo "</UL>";
	}
echo "
	<H3>Staff Out Tomorrow</H3>
	";
$staffout_query = mysql_query("SELECT person,comments FROM leavecalendar
	WHERE leave_date = CURDATE() + 1");
$rows = mysql_num_rows($staffout_query);
if ($rows == 0) {
	echo "
		None
		";
	}
else {
	echo "<UL>";
	while ($rows != 0):
		$staffout_obj = mysql_fetch_object($staffout_query);
		echo "
			<LI>$staffout_obj->person - $staffout_obj->comments</LI>
			";
		--$rows;
		endwhile;
	echo "</UL>";
	}
$curr_year = date("Y");
echo "
	<H3>Show Entire Month</H3>
	<FORM ACTION=\"lc_month.php\" METHOD=\"POST\">
	<SELECT NAME=\"month\">
		<OPTION VALUE=\"01\">January</OPTION>
		<OPTION VALUE=\"02\">February</OPTION>
		<OPTION VALUE=\"03\">March</OPTION>
		<OPTION VALUE=\"04\">April</OPTION>
		<OPTION VALUE=\"05\">May</OPTION>
		<OPTION VALUE=\"06\">June</OPTION>
		<OPTION VALUE=\"07\">July</OPTION>
		<OPTION VALUE=\"08\">August</OPTION>
		<OPTION VALUE=\"09\">September</OPTION>
		<OPTION VALUE=\"10\">October</OPTION>
		<OPTION VALUE=\"11\">November</OPTION>
		<OPTION VALUE=\"12\">December</OPTION>
	</SELECT>
	<INPUT TYPE=\"TEXT\" NAME=\"year\" SIZE=\"4\" MAXLENGTH=\"4\" VALUE=\"$curr_year\">
	<INPUT TYPE=\"SUBMIT\" VALUE=\"Show Month\">
	</FORM>
	<H3>Schedule Leave Time</H3>
	<FORM ACTION=\"lc_add.php\" METHOD=\"POST\">
	<TABLE BORDER=0>
	<TR>
	<TD>Date of leave (mm-dd-yyyy):</TD>
	<TD><INPUT TYPE=\"TEXT\" NAME=\"month\" SIZE=\"2\" MAXLENGTH=\"2\">
	-
	<INPUT TYPE=\"TEXT\" NAME=\"day\" SIZE=\"2\" MAXLENGTH=\"2\">
	-
	<INPUT TYPE=\"TEXT\" NAME=\"year\" SIZE=\"4\" MAXLENGTH=\"4\"></TD>
	</TR>
	<TR>
	<TD>Name:</TD>
	<TD><INPUT TYPE=\"TEXT\" NAME=\"person\" SIZE=\"40\" MAXLENGTH=\"40\"></TD>
	</TR>
	<TR>
	<TD>Comments:</TD>
	<TD><TEXTAREA NAME=\"comments\" COLS=\"50\" ROWS=\"3\"></TEXTAREA></TD>
	</TR></TABLE>
	<INPUT TYPE=\"SUBMIT\" VALUE=\"Add to Calendar\">
	</FORM>
	";

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
