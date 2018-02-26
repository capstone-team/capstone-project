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
$content .= <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Loaned Equipment List</a></h2>
			</div>
			<div class="entry">

	<FORM ACTION="$PHP_SELF" METHOD="POST">
	<P>Narrow down this list:<BR>
	<TABLE BORDER=0>
	<TR><TD>Username: </TD><TD><INPUT TYPE="TEXT" NAME="username" SIZE="8" MAXLENGTH="8"></TD></TR>
        <TR><TD>Equipment Type: </TD><TD><SELECT NAME="equip_type">
	                     <OPTION VALUE="Show All">Show All</OPTION>
	                     <OPTION VALUE="Laptop">Laptop</OPTION>
	                     <OPTION VALUE="Desktop">Desktop</OPTION>
	                     <OPTION VALUE="Monitor">Monitor</OPTION>
	                     <OPTION VALUE="Printer">Printer</OPTION>
	                     <OPTION VALUE="Other">Other</OPTION> </SELECT> </TD></TR>
        <TR><TD>Status: </TD><TD><SELECT NAME="status">
	             <OPTION VALUE="Show All">Show All</OPTION>
		     <OPTION VALUE="OPEN" SELECTED>OPEN</OPTION>
		     <OPTION VALUE="CLOSED">CLOSED</OPTION> </SELECT> </TD></TR>
	</TABLE>
	<INPUT TYPE="SUBMIT" VALUE="Find">
	</FORM></P>

	<TABLE BORDER=1>
	<TR>
		<TD>ID</TD>
		<TD>Username</TD>
		<TD>LHU Prop. #</TD>
		<TD>Loan Prop. #</TD>
		<TD>Equip. Type</TD>
		<TD>Start Date</TD>
		<TD>End Date</TD>
		<TD>Status</TD>
	</TR>
EOD;
$rows = mysql_num_rows($loan_query);
while ($rows > 0):
	$loan_obj = mysql_fetch_object($loan_query);
$content .= <<<EOD
	<TR>
		<TD><A HREF="loan_disp.php?loan_id=$loan_obj->loan_id">$loan_obj->loan_id</A></TD>
		<TD>$loan_obj->username</TD>
		<TD>$loan_obj->lhu_prop_num</TD>
		<TD>$loan_obj->loan_prop_num</TD>
		<TD>$loan_obj->equip_type</TD>
		<TD>$loan_obj->start_date</TD>
		<TD>$loan_obj->end_date</TD>
		<TD>$loan_obj->status</TD>
	</TR>
EOD;
	--$rows;
	endwhile;
$content .= <<<EOD

</table>
			</div>
		</div>

EOD;

$display = str_replace("CONTENTPLACEHOLDER", $content, $wrapper);
echo $display;
?>