<?PHP
include("FCKeditor/fckeditor.php");
$handle = fopen("header.txt","r");
$header = fread($handle,filesize("header.txt"));
fclose($handle);
echo $header;
mysql_connect("localhost","","");
mysql_select_db("lhucc_webdb");

if ((strlen($message_data) > 0) || (strlen($poster_name) > 0)) {
	if ((strlen($message_data) > 0) && (strlen($poster_name) > 0)) {
		mysql_query("INSERT INTO messages (post_date,poster_name,message_data,exp_date)
			VALUES (NOW(),'$poster_name','$message_data','$exp_yr-$exp_mo-$exp_day')");
		echo "Message Posted.<br>";
		}
	else {
		echo "Content and Name required to post message<br>";
		}
	}

echo "
	<H3>Add A Message to \"Current News and Advisories\" on Computing Center Public Page</H3>
	<P>HTML formatting can be used to include hyperlinks.  Please remember to close HTML tags.</P>
	<UL>
		<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
			Message Content:<br>
			<!---<TEXTAREA NAME=\"message_data\" COLS=\"40\" ROWS=\"5\"></TEXTAREA>-->";
		        $mFCKeditor = new FCKeditor('message_data') ;
		        $mFCKeditor->BasePath = 'FCKeditor/';
		        $mFCKeditor->Value = "Type message to be displayed here";
		        $mFCKeditor->Create() ;

			echo "
		<TABLE BORDER=0>
		<TR>
		<TR>
			<TD>Posted By:</TD>
			<TD><INPUT TYPE=\"TEXT\" NAME=\"poster_name\" SIZE=\"40\"
				MAXLENGTH=\"40\"></TD>
		</TR>
		<TR>
			<TD>Expire On:</TD>
			<TD><INPUT TYPE=\"TEXT\" NAME=\"exp_mo\" SIZE=\"2\" MAXLENGTH=\"2\">
			-<INPUT TYPE=\"TEXT\" NAME=\"exp_day\" SIZE=\"2\" MAXLENGTH=\"2\">
			-<INPUT TYPE=\"TEXT\" NAME=\"exp_yr\" SIZE=\"4\" MAXLENGTH=\"4\"></TD>
		</TR>
		</TABLE>
		<INPUT TYPE=\"SUBMIT\" VALUE=\"Post Message\">
		</FORM>
	</UL>
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
