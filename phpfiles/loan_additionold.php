<?PHP
$handle = fopen("header.txt","r");
$header = fread($handle,filesize("header.txt"));
fclose($handle);
echo $header;
mysql_connect("localhost","","");
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
	echo "
		The loan record has been added.  Thank you.
		";
	}

else if ($action == "Submit" ) {
	echo "
		Not all required fields were filled out.  Please press the back button, check for errors, and resubmit.
		";
	$incomp = 1;
	}

if ($incomp != 1) {
echo "
	<H2>Add an equipment loan record</H2>

	<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
	<TABLE BORDER=0>
	<TR>
	<TD>*Borrower Username:</TD>
	<TD><INPUT TYPE=\"TEXT\" NAME=\"username\" SIZE=\"8\" MAXLENGTH=\"16\"></TD>
	</TR>
	<TR>
	<TD>LHU Property No. of Broken Equipment:</TD>
	<TD><INPUT TYPE=\"TEXT\" NAME=\"lhu_prop_num\" SIZE=\"6\" MAXLENGTH=\"6\"></TD>
	</TR>
	<TR>
	<TD>LHU Property No. of Loaner Equipment:</TD>
	<TD><INPUT TYPE=\"TEXT\" NAME=\"loan_prop_num\" SIZE=\"6\" MAXLENGTH=\"6\"></TD>
	</TR>
	<TR>
	<TD>Equipment Type:</TD>
	<TD><SELECT NAME=\"equip_type\">
		<OPTION VALUE=\"Laptop\">Laptop</OPTION>
		<OPTION VALUE=\"Desktop\">Desktop</OPTION>
		<OPTION VALUE=\"Monitor\">Monitor</OPTION>
		<OPTION VALUE=\"Printer\">Printer</OPTION>
		<OPTION VALUE=\"Other\">Other</OPTION>
		</SELECT></TD>
	</TR>
	<TR>
	<TD>Comments:</TD>
	<TD><TEXTAREA NAME=\"comments\" ROWS=\"8\" COLS=\"40\"></TEXTAREA></TD>
	</TABLE>
	<B>Fields Marked with an Asterick (*) are required.  If you do not complete these
	you will be redirected back to this page</B><BR><BR>
	<INPUT TYPE=\"SUBMIT\" NAME=\"action\" VALUE=\"Submit\">
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
