<?PHP
include("FCKeditor/fckeditor.php");
$handle = fopen("header.txt","r");
$header = fread($handle,filesize("header.txt"));
fclose($handle);
echo $header;
mysql_connect("localhost","","");
mysql_select_db("lhucc_webdb");

echo "
	<H2>FAQ Addition</H2>
	<P>Question and answer can be any length.  HTML formatting can be
	used to add hyperlinks, images or pretty much anything else you
	can put on a webpage.  Please remember to close any HTML tags as
	these will affect the rest of the page.</P>
	<FORM ACTION=\"$PHP_SELF\" METHOD=\"POST\">
	<B>Question:</B><BR>
	<TEXTAREA NAME=\"question\" COLS=\"50\" ROWS=\"2\">";
if ($action == "Preview") {
	echo stripslashes($question);
	}
echo "</TEXTAREA><BR><BR>
	<B>Answer:</B><BR>
	<!---<TEXTAREA NAME=\"answer\" COLS=\"50\" ROWS=\"6\">-->";
        $aFCKeditor = new FCKeditor('answer') ;
        $aFCKeditor->BasePath = 'FCKeditor/';
        $aFCKeditor->Value = stripslashes($answer);
        $aFCKeditor->Create() ;
#if ($action == "Preview") {
#	echo "$answer";
#	}
echo "<!---</TEXTAREA>--><BR><BR>
	<INPUT TYPE=\"SUBMIT\" VALUE=\"Add\" NAME=\"action\">
	<INPUT TYPE=\"SUBMIT\" VALUE=\"Preview\" NAME=\"action\">
	</FORM>
	";

if ((strlen($question) > 0) || (strlen($answer) > 0)) {
	if ((strlen($question) > 0) && (strlen($answer) > 0) && ($action == "Add")) {
		mysql_query("INSERT INTO faqs (question,answer,date_added)
			VALUES ('$question','$answer',NOW())");
		echo "
			<P>Inserted Question: " . stripslashes($question) . "<BR>
			with Answer:<BR> " . stripslashes($answer) . "</P>
			";
		}
	else if ((strlen($question) > 0) && (strlen($answer) > 0) && ($action == "Preview")) {
		echo "
			<P><B>Preview:</B></P>
			<P>Question: " . stripslashes($question) . "<BR>
			Answer:<BR> " . stripslashes($answer) . "</P>
			";
		}
	else {
		echo "<BR><BR><B>Error: You must specify both a question
			and an answer</B>";
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
