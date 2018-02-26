<?PHP
$handle = fopen("header.txt","r");
$header = fread($handle,filesize("header.txt"));
fclose($handle);
echo $header;
mysql_connect("localhost","","");
mysql_select_db("lhucc_webdb");

$incomp = 0;
if ((strlen($req_uname) > 0) && (strlen($req_name) > 0) && (strlen($ph_num) > 0) &&
	(strlen($descrip) > 0) && (strlen($title)) && (strlen($creator))) {
	$creator = strtoupper($creator);
	$req_uname = strtolower($req_uname);
	$fields = "add_date,status,req_uname,req_name,ph_num,descrip,title,creator";
	$values = "NOW(),'Approved','$req_uname','$req_name','$ph_num','$descrip','$title','$creator'";
	if (strlen($building) > 0) {
		$fields .= ",building";
		$values .= ",'$building'";
		}
	if (strlen($room_no) > 0) {
		$fields .= ",room_no";
		$values .= ",'$room_no'";
		}
	if (strlen($lhu_prop_num) > 0) {
		$fields .= ",lhu_prop_num";
		$values .= ",$lhu_prop_num";
		}
	if (strlen($wr_type) > 0) {
		$fields .= ",wr_type";
		$values .= ",'$wr_type'";
		}
	if (strlen($due_date_yr) > 0) {
		$fields .= ",due_date";
		$values .= ",'$due_date_yr-$due_date_mo-$due_date_day'";
		}
	if (strlen($priority) > 0) {
		$fields .= ",priority";
		$values .= ",$priority";
		}
	else {
		$fields .= ",priority";
		$values .= ",5";
		}
	mysql_query("INSERT INTO workrequests ($fields) VALUES ($values)");
	echo "
		Your work request has been added.  Thank you.
		";
	}

else if ((strlen($req_uname) > 0) || (strlen($req_name) > 0) || (strlen($ph_num) > 0) ||
	(strlen($descrip) > 0) || (strlen($title)) || (strlen($creator))) {
	echo "
		Not all required fields were filled out.  Please press the back button, check for errors, and resubmit.
		";
	$incomp = 1;
	}

if ($incomp != 1) {
$due_date_mo = date("m",time() + 1209600);
$due_date_day = date("d",time() + 1209600);
$due_date_yr = date("Y",time() + 1209600);
echo "
	<H2>Add a Work Request</H2>

	<script language=\"JavaScript\">
	function DisableSubBtn(form) {
	  form.submitbtn.disabled = true;
	  form.submitbtn.value=\"Adding Work Request - Please Wait\";
	  return true;
	  }
	</script>

	<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\" onsubmit=\"return DisableSubBtn(this)\">
	<TABLE BORDER=0>
	<TR>
	<TD>*Requestor username:</TD>
	<TD><INPUT TYPE=\"TEXT\" NAME=\"req_uname\" SIZE=\"8\" MAXLENGTH=\"8\"></TD>
	</TR>
	<TR>
	<TD>*Requestor Name:</TD>
	<TD><INPUT TYPE=\"TEXT\" NAME=\"req_name\" SIZE=\"40\" MAXLENGTH=\"40\"></TD>
	</TR>
	<TR>
	<TD>Building Abbrev:</TD>
		<TD><SELECT NAME=\"building\">
		       <OPTION VALUE=AKEL>AKEL</OPTION>
		       <OPTION VALUE=ANNX>ANNX</OPTION>
		       <OPTION VALUE=BENT>BENT</OPTION>
		       <OPTION VALUE=DACC>DACC</OPTION>
		       <OPTION VALUE=ECAM>ECAM</OPTION>
		       <OPTION VALUE=EVER>EVER</OPTION>
		       <OPTION VALUE=FOUN>FOUN</OPTION>
		       <OPTION VALUE=GLEN>GLEN</OPTION>
		       <OPTION VALUE=GROS>GROS</OPTION>
		       <OPTION VALUE=HIGH>HIGH</OPTION>
		       <OPTION VALUE=HIME>HIME</OPTION>
		       <OPTION VALUE=HONO>HONO</OPTION>
		       <OPTION VALUE=HPB>HPB</OPTION>
		       <OPTION VALUE=HURS>HURS</OPTION>
		       <OPTION VALUE=INTE>INTE</OPTION>
		       <OPTION VALUE=JACK>JACK</OPTION>
		       <OPTION VALUE=MCEN>MCEN</OPTION>
		       <OPTION VALUE=NORT>NORT</OPTION>
		       <OPTION VALUE=PARS>PARS</OPTION>
		       <OPTION VALUE=PRCE>PRCE</OPTION>
		       <OPTION VALUE=PRES>PRES</OPTION>
		       <OPTION VALUE=RAUB>RAUB</OPTION>
		       <OPTION VALUE=ROBI>ROBI</OPTION>
		       <OPTION VALUE=ROGE>ROGE</OPTION>
		       <OPTION VALUE=ROTC>ROTC</OPTION>
		       <OPTION VALUE=RUSS>RUSS</OPTION>
		       <OPTION VALUE=SIEG>SIEG</OPTION>
		       <OPTION VALUE=SLOA>SLOA</OPTION>
		       <OPTION VALUE=SMIT>SMIT</OPTION>
		       <OPTION VALUE=SRC>SRC</OPTION>
		       <OPTION VALUE=STEV>STEV</OPTION>
		       <OPTION VALUE=SULL>SULL</OPTION>
		       <OPTION VALUE=THOA>THOA</OPTION>
		       <OPTION VALUE=THOM>THOM</OPTION>
		       <OPTION VALUE=TOML>TOML</OPTION>
		       <OPTION VALUE=ULME>ULME</OPTION>
		       <OPTION VALUE=VILL>VILL</OPTION>
		       <OPTION VALUE=WOOL>WOOL</OPTION>
		       <OPTION VALUE=ZIMM>ZIMM</OPTION>
		    </SELECT></TD>
	</TR>
	<TR>
	<TD>Room No:</TD>
	<TD><INPUT TYPE=\"TEXT\" NAME=\"room_no\" SIZE=\"4\" MAXLENGTH=\"4\"></TD>
	</TR>
	<TR>
	<TD>*Phone Number:</TD>
	<TD><INPUT TYPE=\"TEXT\" NAME=\"ph_num\" SIZE=\"12\" MAXLENGTH=\"12\"></TD>
	</TR>
	<TR>
	<TD>Asset Number:</TD>
	<TD><INPUT TYPE=\"TEXT\" NAME=\"lhu_prop_num\" SIZE=\"6\" MAXLENGTH=\"6\"></TD>
	</TR>
	<TR>
	<TD>*Request Title:</TD>
	<TD><INPUT TYPE=\"TEXT\" NAME=\"title\" SIZE=\"50\" MAXLENGTH=\"100\"></TD>
	</TR>
	<TR>
	<TD>*Request Description:</TD>
	<TD><TEXTAREA NAME=\"descrip\" COLS=\"50\" ROWS=\"8\"></TEXTAREA></TD>
	</TR>
	<TR>
	<TD>WR Type:</TD>
	<TD><SELECT NAME=\"wr_type\">
		<OPTION VALUE=\"Hardware\">Hardware</OPTION>
		<OPTION VALUE=\"Software\">Software</OPTION>
		<OPTION VALUE=\"Install\">Install</OPTION>
		<OPTION VALUE=\"Network\">Network</OPTION>
		<OPTION VALUE=\"Account\">Account</OPTION>
		<OPTION VALUE=\"Comp. Move\">Comp. Move</OPTION>
		<OPTION VALUE=\"Phone\">Phone</OPTION>
		<OPTION VALUE=\"Phone Move\">Phone Move</OPTION>
		<OPTION VALUE=\"Voice Mail\">Voice Mail</OPTION>
		<OPTION VALUE=\"On Order\">On Order</OPTION>
		</SELECT></TD>
	</TR>
	<TR>
	<TD>Due Date (mm-dd-yyyy):</TD>
	<TD><INPUT TYPE=\"TEXT\" NAME=\"due_date_mo\" SIZE=\"2\" MAXLENGTH=\"2\" VALUE=\"$due_date_mo\">
		-<INPUT TYPE=\"TEXT\" NAME=\"due_date_day\" SIZE=\"2\" MAXLENGTH=\"2\" VALUE=\"$due_date_day\">
		-<INPUT TYPE=\"TEXT\" NAME=\"due_date_yr\" SIZE=\"4\" MAXLENGTH=\"4\" VALUE=\"$due_date_yr\"></TD>
	</TR>
	<TR>
	<TD>Priority (0-9):</TD>
	<TD><INPUT TYPE=\"TEXT\" NAME=\"priority\" SIZE=\"1\" MAXLENGTH=\"1\" 		VALUE=\"5\"></TD>
	</TR>
	<TD>*Added By:</TD>
	<TD><INPUT TYPE=\"TEXT\" NAME=\"creator\" SIZE=\"3\" MAXLENGTH=\"3\"></TD>
	</TABLE>
	<B>Fields Marked with an Asterick (*) are required.  If you do not complete these
	you will be redirected back to this page</B><BR><BR>
	<INPUT TYPE=\"SUBMIT\" NAME=\"submitbtn\" VALUE=\"Add Request\">
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
