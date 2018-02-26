<?PHP
$handle = fopen("header.txt","r");
$header = fread($handle,filesize("header.txt"));
fclose($handle);
echo $header;
mysql_connect("localhost","","");
mysql_select_db("lhucc_webdb");

echo "
	<H3>Send Message to LHUCC Staff Phone</H3>
	<UL>
		<FORM ACTION=\"pager.php\" METHOD=\"POST\">
		<TABLE BORDER=0>
		<TR>
			<TD>Message Content:</TD>
			<TD><TEXTAREA NAME=\"message\" COLS=\"40\" ROWS=\"5\"></TEXTAREA></TD>
		</TR>
		<TR>
			<TD>Send To:</TD>
			<TD><SELECT NAME=\"ph_num\">
                              <OPTION VALUE=\"5702954145@txt.att.net\">Bo Miller</OPTION>
                              <OPTION VALUE=\"5707867045@txt.att.net\">Christian Glotfelty</OPTION>
                              <OPTION VALUE=\"5702956407@txt.att.net\">Don Patterson</OPTION>
                              <OPTION VALUE=\"5707867087@txt.att.net\">Jamie Walker</OPTION>
                              <OPTION VALUE=\"5702956406@txt.att.net\">Jeff Walker</OPTION>
                              <OPTION VALUE=\"5702954146@txt.att.net\">Jeff Sawyer</OPTION>
                              <OPTION VALUE=\"5702958035@txt.att.net\">Joel Register</OPTION>
                              <OPTION VALUE=\"5702954147@txt.att.net\">Manny Andrus</OPTION>
                              <OPTION VALUE=\"5706607263@txt.att.net\">Norm Wisor</OPTION>
                              <OPTION VALUE=\"5702954150@txt.att.net\">Paul Markert</OPTION>
                              <OPTION VALUE=\"5706600786@txt.att.net\">Rich Heimer</OPTION>
                              <OPTION VALUE=\"5702954148@txt.att.net\">Rick Christian</OPTION>
                              <OPTION VALUE=\"5702954149@txt.att.net\">Shane Jones</OPTION>
                              <OPTION VALUE=\"5706609381@txt.att.net\">Steve Davis</OPTION>
                            </SELECT>
                        </TD>
		</TR>

		</TABLE>
		<INPUT TYPE=\"SUBMIT\" VALUE=\"Send Message\">
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
