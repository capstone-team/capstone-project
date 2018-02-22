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

if ((strlen($req_uname) > 0) && (strlen($req_name) > 0) && (strlen($ph_num) > 0) &&
	(strlen($descrip) > 0) && (strlen($title) > 0) && (strlen($building) >0)) {
	$req_uname = strtolower($req_uname);
	$req_name = mysql_real_escape_string($req_name);
	$title = mysql_real_escape_string($title);
	$descrip = mysql_real_escape_string($descrip);
	$fields = "add_date,status,req_uname,req_name,ph_num,descrip,title,wr_type,equip_type";
	$values = "NOW(),'Submitted','$req_uname','$req_name','$ph_num','$descrip','$title','$wr_type','$equip_type'";
	if (strlen($building) > 0) {
		$fields .= ",building";
		$values .= ",'$building'";
		}
	if (strlen($room_no) > 0) {
		$fields .= ",room_no";
		$values .= ",'$room_no'";
		}
	if (strlen($lhu_stu_id) > 0) {
		$fields .= ",lhu_stu_id";
		$values .= ",$lhu_stu_id";
		}
	if (strlen($mfg) > 0) {
		$fields .= ",mfg";
		$values .= ",'$mfg'";
		}
	if (strlen($model) > 0) {
		$fields .= ",model";
		$values .= ",'$model'";
		}
	if (strlen($serial) > 0) {
		$fields .= ",serial";
		$values .= ",'$serial'";
		}
	if (strlen($passwds) > 0) {
		$fields .= ",passwds";
		$values .= ",'$passwds'";
		}
	if (strlen($tag_num) > 0) {
		$fields .= ",tag_num";
		$values .= ",'$tag_num'";
		}
	if ($format_perm == "yes") {
		$fields .= ",format_perm";
		$values .= ",1";
		}
	else {
		$fields .= ",format_perm";
		$values .= ",0";
		}
	if ($pwr_cord == "yes") {
		$fields .= ",pwr_cord";
		$values .= ",1";
		}
	else {
		$fields .= ",pwr_cord";
		$values .= ",0";
		}
	if (mysql_query("INSERT INTO stu_wr ($fields) VALUES ($values)")){
	$insertid = mysql_insert_id();
	echo "
		Your work request has been submitted.  Thank you.
                <p><a href=\"stu_wr_disp.php?wr_id=$insertid\" target=\"_blank\">Show Request Record</a></p>
		";
		}
        else {
	echo "
	        An error has occurred. <BR>
		" . mysql_error();
		}
	
	$msg_txt = 
"A work request has been submitted via the web.  Please review it at 
http://www.lhup.edu/computing_and_tech/stu_admin/stu_wr_queue.php";

	#mail("lhulabs@lhup.edu","Work Request Submitted via web",$msg_txt);
	}
else if ((strlen($req_uname) > 0) || (strlen($req_name) > 0) || (strlen($ph_num) > 0) ||
	(strlen($descrip) > 0) || (strlen($title) > 0) || (strlen($building) >0)) {
	echo "Not all required fields were filled out.  Please press the Back button to correct this.";
	}
else {
	echo "
		<H2>Submit a Work Request</H2>
		<P>If you don't work for the STSC, IT, CIA, FBI, NSA, KGB, WTF or BBQ, you shouldn't be on this page.</P>

		<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
		<TABLE BORDER=0>
		<TR>
		<TD>*Requestor username:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"req_uname\" SIZE=\"8\" MAXLENGTH=\"8\">@lhup.edu</TD>
		</TR>
		<TR>
		<TD>*Requestor Name (Last, First):</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"req_name\" SIZE=\"40\" MAXLENGTH=\"40\"></TD>
		</TR>
		<TR>
		<TD>*Building Abbrev:</TD>
		<TD><SELECT NAME=\"building\">
		       <OPTION VALUE=EVER>EVER</OPTION>
		       <OPTION VALUE=FAIR>FAIR</OPTION>
		       <OPTION VALUE=GROS>GROS</OPTION>
		       <OPTION VALUE=HIGH>HIGH</OPTION>
		       <OPTION VALUE=MCEN>MCEN</OPTION>
		       <OPTION VALUE=NORT>NORT</OPTION>
		       <OPTION VALUE=RUSS>RUSS</OPTION>
		       <OPTION VALUE=SMIT>SMIT</OPTION>
		       <OPTION VALUE=VILL>VILL</OPTION>
		       <OPTION VALUE=WOOL>WOOL</OPTION>
		       <OPTION VALUE=OFFC>Off Campus</OPTION>
		       <OPTION VALUE=COUD>COUDERSPORT HOSPITAL (COUD)</OPTION>
		       <OPTION VALUE=DUC>DIXON UNIVERSITY CENTER - RICHARDS (DUC)</OPTION>
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
		<TD>LHU Student ID:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"lhu_stu_id\" SIZE=\"6\" MAXLENGTH=\"6\"></TD>
		</TR>
		<TR>
		<TD>*Work Request Title:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"title\" SIZE=\"50\" MAXLENGTH=\"100\" VALUE=\"STSC Repair\"></TD>
		</TR>
		<TR>
		<TD>*Request Description:</TD>
		<TD><TEXTAREA NAME=\"descrip\" COLS=\"50\" ROWS=\"8\"></TEXTAREA>
		</TD>
		</TR>
		<TR>
		<TD>Passwords:</TD>
		<TD><TEXTAREA NAME=\"passwds\" COLS=\"30\" ROWS=\"4\"></TEXTAREA>
		</TR>
		<TR>
		<TD>*Request Type:</TD>
		<TD><SELECT NAME=\"wr_type\">
		        <OPTION VALUE=\"Software\">Software</OPTION>
		        <OPTION VALUE=\"Network\">Network</OPTION>
		        <OPTION VALUE=\"CCA\">CCA</OPTION>
			<OPTION VALUE=\"Hardware\">Hardware (Dell Laptop Purchase Program Only)</OPTION>
		    </SELECT></TD>
		</TR>
		<TR>
		<TD>*Equip. Type:</TD>
		<TD><SELECT NAME=\"equip_type\">
		        <OPTION VALUE=\"Laptop\">Laptop</OPTION>
		        <OPTION VALUE=\"Desktop\">Desktop/Tower</OPTION>
		        <OPTION VALUE=\"Printer\">Printer</OPTION>
		        <OPTION VALUE=\"Other\">Other</OPTION>
		    </SELECT></TD>
		</TR>
		<TR>
		<TD>Manufacturer:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"mfg\" SIZE=\"20\" MAXLENGTH=\"20\"></TD>
		</TR>
		<TR>
		<TD>Model No.:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"model\" SIZE=\"25\" MAXLENGTH=\"25\"></TD>
		</TR>
		<TR>
		<TD>Serial No.:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"serial\" SIZE=\"50\" MAXLENGTH=\"50\"></TD>
		</TR>
		<TD>Toe Tag No.:</TD>
		<TD><INPUT TYPE=\"TEXT\" NAME=\"tag_num\" SIZE=\"5\" MAXLENGTH=\"3\"></TD>
		</TR>
		<TR>
		<TD>Permission to Format:</TD>
		<TD><INPUT TYPE=\"CHECKBOX\" NAME=\"format_perm\" VALUE=\"yes\"></TD>
		</TR>
		<TR>
		<TD>Has Power Cord:</TD>
		<TD><INPUT TYPE=\"CHECKBOX\" NAME=\"pwr_cord\" VALUE=\"yes\"></TD>
		</TR>
		</TABLE>
		<B>Fields Marked with an Asterick (*) are required.  If you do not complete these
		you will be redirected back to this page</B><BR><BR>
		<INPUT TYPE=\"SUBMIT\" VALUE=\"Submit My Request\">
		</FORM>
		<P>
		<FORM action=\"stu_wr_queue.php\" method=\"POST\">
		<INPUT TYPE=\"SUBMIT\" VALUE=\"View Work Request Queue\">
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
