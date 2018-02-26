<?PHP
foreach($_GET as $k => $v) $_GET[$k] = addslashes($v);
foreach($_POST as $k => $v) $_POST[$k] = addslashes($v);
foreach($_COOKIE as $k => $v) $_COOKIE[$k] = addslashes($v);
import_request_variables("gp");
$handle = fopen("wrapper.txt","r");
$wrapper = fread($handle,filesize("wrapper.txt"));
fclose($handle);
mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");

$content = <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Send Message to LHUCC Staff Phone</a></h2>
			</div>
			<div class="entry">

		<FORM ACTION="pager.php" METHOD="POST">
		<TABLE BORDER=0>
		<TR>
			<TD>Message Content:</TD>
			<TD><TEXTAREA NAME="message" COLS="40" ROWS="5"></TEXTAREA></TD>
		</TR>
		<TR>
			<TD>Send To:</TD>
			<TD><SELECT NAME="ph_num">
                              <OPTION VALUE="5702794339@txt.att.net">Bo Miller</OPTION>
                              <OPTION VALUE="5707867045@txt.att.net">Christian Glotfelty</OPTION>
                              <OPTION VALUE="5702956407@txt.att.net">Don Patterson</OPTION>
                              <OPTION VALUE="5707867087@txt.att.net">Jamie Walker</OPTION>
                              <OPTION VALUE="5702956406@vtext.com">Jeff Walker</OPTION>
                              <OPTION VALUE="5702954146@txt.att.net">Jeff Sawyer</OPTION>
                              <OPTION VALUE="5702958035@txt.att.net">Joel Register</OPTION>
                              <OPTION VALUE="5702954147@txt.att.net">Manny Andrus</OPTION>
                              <OPTION VALUE="5706607263@txt.att.net">Norm Wisor</OPTION>
                              <OPTION VALUE="5702954150@txt.att.net">Paul Markert</OPTION>
                              <OPTION VALUE="5702952857@vtext.com">Rich Heimer</OPTION>
                              <OPTION VALUE="5702954148@vtext.com">Rick Christian</OPTION>
                              <OPTION VALUE="5702954149@txt.att.net">Shane Jones</OPTION>
                              <OPTION VALUE="5706602163@vtext.com">Steve Davis</OPTION>
                            </SELECT>
                        </TD>
		</TR>

		</TABLE>
		<INPUT TYPE="SUBMIT" VALUE="Send Message">
		</FORM>
			</div>
		</div>

EOD;

$display = str_replace("CONTENTPLACEHOLDER", $content, $wrapper);
echo $display;
?>