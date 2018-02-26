<?PHP
foreach($_GET as $k => $v) $_GET[$k] = mysql_real_escape_string($v);
foreach($_POST as $k => $v) $_POST[$k] = mysql_real_escape_string($v);
foreach($_COOKIE as $k => $v) $_COOKIE[$k] = mysql_real_escape_string($v);
import_request_variables("gp");
$handle = fopen("wrapper.txt","r");
$wrapper = fread($handle,filesize("wrapper.txt"));
fclose($handle);
mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");

$incomp = 0;
if ((strlen($req_uname) > 0) && (strlen($req_name) > 0) && (strlen($ph_num) > 0) &&
	(strlen($descrip) > 0) && (strlen($title)) && (strlen($creator)) && (strlen($lhu_prop_num))) {
	$creator = strtoupper($creator);
	$req_uname = strtolower($req_uname);
	$req_name = mysql_real_escape_string($req_name);
	$title = mysql_real_escape_string($title);
	$descrip = mysql_real_escape_string($descrip);
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
	$wr_id = mysql_insert_id();
	$mailmsg = 
"IT Work Request $wr_id has been generated regarding \"$title\". You can view more detailed information about your work request at http://hitman.lhup.edu/wr_disp.php?wr_id=$wr_id.  If you have any questions, please call the IT Helpdesk at x2286.  When calling or emailing about this matter, please be sure to reference work request number $wr_id.";
	mail("$req_uname@lhup.edu", "Work Request No. $wr_id", $mailmsg,
     		"From: helpdesk@lhup.edu\r\n"
    		."Reply-To: helpdesk@lhup.edu\r\n"
    		."X-Mailer: PHP/" . phpversion());
	$content .= <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Success!</a></h2>
			</div>
			<div class="entry">
                        <p>Your work request has been added with request number $wr_id.  Thank you. To continue work on this WR, <a href="wr_disp.php?wr_id=$wr_id">click here</a>.</p>
                        </div>
                </div>
EOD;
	}

else if ((strlen($req_uname) > 0) || (strlen($req_name) > 0) || (strlen($ph_num) > 0) ||
	(strlen($descrip) > 0) || (strlen($title)) || (strlen($creator)) || (strlen($lhu_prop_num))) {
	$content .= <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Error!</a></h2>
			</div>
			<div class="entry">
                        <p>Not all required fields were filled out.  Please press the back button, check for errors, and resubmit.</p>
                        </div>
                </div>
EOD;
	$incomp = 1;
	}

if ($incomp != 1) {
$due_date_mo = date("m",time() + 1209600);
$due_date_day = date("d",time() + 1209600);
$due_date_yr = date("Y",time() + 1209600);
$content .= <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Add a Work Request</a></h2>
			</div>
			<div class="entry">
	<script language="JavaScript">
	function DisableSubBtn(form) {
	  form.submitbtn.disabled = true;
	  form.submitbtn.value="Adding Work Request - Please Wait";
	  return true;
	  }
	</script>

	<FORM ACTION="$PHP_SELF" METHOD="POST" onsubmit="return DisableSubBtn(this)">
	<TABLE BORDER=0>
	<TR>
	<TD>*Requestor username:</TD>
	<TD><INPUT TYPE="TEXT" NAME="req_uname" SIZE="8" MAXLENGTH="8"></TD>
	</TR>
	<TR>
	<TD>*Requestor Name:</TD>
	<TD><INPUT TYPE="TEXT" NAME="req_name" SIZE="40" MAXLENGTH="40"></TD>
	</TR>
	<TR>
	<TD>Building Abbrev:</TD>
		<TD><SELECT NAME="building">
		       <OPTION VALUE=AKEL>AKEL</OPTION>
		       <OPTION VALUE=ANNX>ANNX</OPTION>
		       <OPTION VALUE=BENT>BENT</OPTION>
		       <OPTION VALUE=CLII>CLII</OPTION>
		       <OPTION VALUE=COUD>COUDERSPORT HOSPITAL (COUD)</OPTION>
		       <OPTION VALUE=DACC>DACC</OPTION>
		       <OPTION VALUE=DUC>DIXON UNIVERSITY CENTER (DUC)</OPTION>
		       <OPTION VALUE=ECAM>ECAM</OPTION>
		       <OPTION VALUE=ECSC>ECSC</OPTION>
		       <OPTION VALUE=EVER>EVER</OPTION>
		       <OPTION VALUE=FACL>FACL</OPTION>
		       <OPTION VALUE=FAIR>FAIR</OPTION>
		       <OPTION VALUE=FOUN>FOUN</OPTION>
		       <OPTION VALUE=GLEN>GLEN</OPTION>
		       <OPTION VALUE=GROS>GROS</OPTION>
		       <OPTION VALUE=HELP>HELPDESK/PHONE CALL</OPTION>
		       <OPTION VALUE=HIGH>HIGH</OPTION>
		       <OPTION VALUE=HIME>HIME</OPTION>
		       <OPTION VALUE=HONO>HONO</OPTION>
		       <OPTION VALUE=WILL>HPB (WILL)</OPTION>
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
	<TD><INPUT TYPE="TEXT" NAME="room_no" SIZE="4" MAXLENGTH="4"></TD>
	</TR>
	<TR>
	<TD>*Phone Number:</TD>
	<TD><INPUT TYPE="TEXT" NAME="ph_num" SIZE="12" MAXLENGTH="12"></TD>
	</TR>
	<TR>
	<TD>*Asset Number:</TD>
	<TD><INPUT TYPE="TEXT" NAME="lhu_prop_num" SIZE="6" MAXLENGTH="6" VALUE="000000"><font color="red"><i> Asset number is now required</i></font color></TD>
	</TR>
	<TR>
	<TD>*Request Title:</TD>
	<TD><INPUT TYPE="TEXT" NAME="title" SIZE="50" MAXLENGTH="100"></TD>
	</TR>
	<TR>
	<TD>*Request Description:</TD>
	<TD><TEXTAREA NAME="descrip" COLS="50" ROWS="8"></TEXTAREA></TD>
	</TR>
	<TR>
	<TD>WR Type:</TD>
	<TD><SELECT NAME="wr_type">
		<OPTION VALUE="Hardware">Hardware</OPTION>
		<OPTION VALUE="Software">Software</OPTION>
                <OPTION VALUE="HelpDesk">HelpDesk</OPTION>
		<OPTION VALUE="Install">Install</OPTION>
		<OPTION VALUE="Network">Network</OPTION>
		<OPTION VALUE="Account">Account</OPTION>
		<OPTION VALUE="Comp. Move">Comp. Move</OPTION>
		<OPTION VALUE="Phone">Phone</OPTION>
		<OPTION VALUE="Phone Move">Phone Move</OPTION>
		<OPTION VALUE="Voice Mail">Voice Mail</OPTION>
		<OPTION VALUE="On Order">On Order</OPTION>
		</SELECT></TD>
	</TR>
	<TR>
	<TD>Due Date (mm-dd-yyyy):</TD>
	<TD><INPUT TYPE="TEXT" NAME="due_date_mo" SIZE="2" MAXLENGTH="2" VALUE="$due_date_mo">
		-<INPUT TYPE="TEXT" NAME="due_date_day" SIZE="2" MAXLENGTH="2" VALUE="$due_date_day">
		-<INPUT TYPE="TEXT" NAME="due_date_yr" SIZE="4" MAXLENGTH="4" VALUE="$due_date_yr"></TD>
	</TR>
	<TR>
	<TD>Priority (0-9):</TD>
	<TD><INPUT TYPE="TEXT" NAME="priority" SIZE="1" MAXLENGTH="1" 		VALUE="5"></TD>
	</TR>
	<TD>*Added By:</TD>
	<TD><INPUT TYPE="TEXT" NAME="creator" SIZE="3" MAXLENGTH="3"></TD>
	</TABLE>
	<B>Fields Marked with an Asterick (*) are required.  If you do not complete these
	you will be redirected back to this page</B><BR><BR>
	<INPUT TYPE="SUBMIT" NAME="submitbtn" VALUE="Add Request">
	</FORM>

			</div>
		</div>

EOD;
	}

$display = str_replace("CONTENTPLACEHOLDER", $content, $wrapper);
echo $display;
?>
