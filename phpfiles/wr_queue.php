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
if (strlen($req_uname) > 0){
	$name_cond = "AND req_uname LIKE '%$req_uname%'";
	}
if (strlen($cc_staff) > 0){
	$tech_cond = "AND (cc_staff LIKE '%$cc_staff%' OR cc_staff2 LIKE '%$cc_staff%' OR cc_staff3 LIKE '%$cc_staff%')";
	}
if (strlen($building) > 0){
	$bldg_cond = "AND building LIKE '%$building%'";
	}
if (strlen($wr_type) > 0){
	$type_cond = "AND wr_type = '$wr_type'";
	}
if (strlen($sortfield) > 0){
	$order_by = $sortfield;
	}
else {
	$order_by = "priority";
	}
$desc = "";
if ($order_by == $prevsortfield){
	$desc = "desc";
	}
$wr_query = mysql_query("SELECT wr_id,wr_type,req_name,title,status,cc_staff,cc_staff2,cc_staff3,priority,ph_num,building,room_no,add_date FROM 
	workrequests WHERE (status = 'Approved' OR status = 'Started' OR status = 'Waiting') 
	$name_cond $tech_cond $bldg_cond $type_cond ORDER BY $order_by $desc ,add_date,status");
$content .= <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Work Request Queue</a></h2>
			</div>
			<div class="entry">
	<P>The following work requests have been promoted to the general queue.</P>
	<FORM ACTION="$PHP_SELF" METHOD="POST">
	<P>Show requests from user:
	<INPUT TYPE="TEXT" NAME="req_uname" SIZE="8" MAXLENGTH="8">
	<INPUT TYPE="SUBMIT" VALUE="Find">
	</FORM></P>
	<FORM ACTION="$PHP_SELF" METHOD="POST">
	<P>Show requests for building:
	<INPUT TYPE="TEXT" NAME="building" SIZE="4" MAXLENGTH="4">
	<INPUT TYPE="SUBMIT" VALUE="Find">
	</FORM></P>
	<FORM ACTION="$PHP_SELF" METHOD="POST">
	<P>Show requests for technician:
	<INPUT TYPE="TEXT" NAME="cc_staff" SIZE="40" MAXLENGTH="40">
	<INPUT TYPE="SUBMIT" VALUE="Find">
	</FORM></P>
	<FORM ACTION="$PHP_SELF" METHOD="POST">
	<P>Show requests by type:
	<SELECT NAME="wr_type">
		<OPTION VALUE="Hardware">Hardware</OPTION>
		<OPTION VALUE="Software">Software</OPTION>
		<OPTION VALUE="Install">Install</OPTION>
		<OPTION VALUE="Network">Network</OPTION>
		<OPTION VALUE="Account">Account</OPTION>
		<OPTION VALUE="Comp. Move">Comp. Move</OPTION>
		<OPTION VALUE="Phone">Phone</OPTION>
		<OPTION VALUE="Phone Move">Phone Move</OPTION>
		<OPTION VALUE="Voice Mail">Voice Mail</OPTION>
	</SELECT>
	<INPUT TYPE="SUBMIT" VALUE="Find">
	</FORM></P>
      <TABLE BORDER=1>
	<TR>
		<TD><FORM ACTION="$PHP_SELF" METHOD="POST">
		    <INPUT TYPE="hidden" NAME="sortfield" VALUE="wr_id">
		    <INPUT TYPE="hidden" NAME="prevsortfield" VALUE="$order_by">
		    <INPUT TYPE="submit" VALUE="ID">
		    </FORM></TD>
		<TD><FORM ACTION="$PHP_SELF" METHOD="POST">
		    <INPUT TYPE="hidden" NAME="sortfield" VALUE="wr_type">
		    <INPUT TYPE="hidden" NAME="prevsortfield" VALUE="$order_by">
		    <INPUT TYPE="submit" VALUE="WR Type">
		    </FORM></TD>
		<TD><FORM ACTION="$PHP_SELF" METHOD="POST">
		    <INPUT TYPE="hidden" NAME="sortfield" VALUE="req_name">
		    <INPUT TYPE="hidden" NAME="prevsortfield" VALUE="$order_by">
		    <INPUT TYPE="submit" VALUE="Requestor">
		    </FORM></TD>
		<TD><FORM ACTION="$PHP_SELF" METHOD="POST">
		    <INPUT TYPE="hidden" NAME="sortfield" VALUE="title">
		    <INPUT TYPE="hidden" NAME="prevsortfield" VALUE="$order_by">
		    <INPUT TYPE="submit" VALUE="Title">
		    </FORM></TD>
		<TD><FORM ACTION="$PHP_SELF" METHOD="POST">
		    <INPUT TYPE="hidden" NAME="sortfield" VALUE="ph_num">
		    <INPUT TYPE="hidden" NAME="prevsortfield" VALUE="$order_by">
		    <INPUT TYPE="submit" VALUE="Phone">
		    </FORM></TD>
		<TD><FORM ACTION="$PHP_SELF" METHOD="POST">
		    <INPUT TYPE="hidden" NAME="sortfield" VALUE="building">
		    <INPUT TYPE="hidden" NAME="prevsortfield" VALUE="$order_by">
		    <INPUT TYPE="submit" VALUE="Location">
		    </FORM></TD>
		<TD><FORM ACTION="$PHP_SELF" METHOD="POST">
		    <INPUT TYPE="hidden" NAME="sortfield" VALUE="status">
		    <INPUT TYPE="hidden" NAME="prevsortfield" VALUE="$order_by">
		    <INPUT TYPE="submit" VALUE="Status">
		    </FORM></TD>
		<TD><FORM ACTION="$PHP_SELF" METHOD="POST">
		    <INPUT TYPE="hidden" NAME="sortfield" VALUE="priority">
		    <INPUT TYPE="hidden" NAME="prevsortfield" VALUE="$order_by">
		    <INPUT TYPE="submit" VALUE="Pri.">
		    </FORM></TD>
		<TD><FORM ACTION="$PHP_SELF" METHOD="POST">
		    <INPUT TYPE="hidden" NAME="sortfield" VALUE="cc_staff">
		    <INPUT TYPE="hidden" NAME="prevsortfield" VALUE="$order_by">
		    <INPUT TYPE="submit" VALUE="Staff 1">
		    </FORM></TD>
		<TD><FORM ACTION="$PHP_SELF" METHOD="POST">
		    <INPUT TYPE="hidden" NAME="sortfield" VALUE="cc_staff2">
		    <INPUT TYPE="hidden" NAME="prevsortfield" VALUE="$order_by">
		    <INPUT TYPE="submit" VALUE="Staff 2">
		    </FORM></TD>
		<TD><FORM ACTION="$PHP_SELF" METHOD="POST">
		    <INPUT TYPE="hidden" NAME="sortfield" VALUE="cc_staff3">
		    <INPUT TYPE="hidden" NAME="prevsortfield" VALUE="$order_by">
		    <INPUT TYPE="submit" VALUE="Staff 3">
		    </FORM></TD>
		<TD><FORM ACTION="$PHP_SELF" METHOD="POST">
		    <INPUT TYPE="hidden" NAME="sortfield" VALUE="add_date">
		    <INPUT TYPE="hidden" NAME="prevsortfield" VALUE="$order_by">
		    <INPUT TYPE="submit" VALUE="Add Date">
		    </FORM></TD>
	</TR>
EOD;
$rows = mysql_num_rows($wr_query);
while ($rows > 0):
	$wr_obj = mysql_fetch_object($wr_query);
	$content .= <<<EOD
	<TR>
		<TD><A HREF="wr_disp.php?wr_id=$wr_obj->wr_id">$wr_obj->wr_id</A></TD>
		<TD>$wr_obj->wr_type</TD>
		<TD>$wr_obj->req_name</TD>
		<TD>$wr_obj->title</TD>
		<TD>$wr_obj->ph_num</TD>
		<TD>$wr_obj->building $wr_obj->room_no</TD>
		<TD>$wr_obj->status</TD>
		<TD>$wr_obj->priority</TD>
		<TD>$wr_obj->cc_staff</TD>
		<TD>$wr_obj->cc_staff2</TD>
		<TD>$wr_obj->cc_staff3</TD>
		<TD>$wr_obj->add_date</TD>
	</TR>
EOD;
	--$rows;
	endwhile;
$content .= <<<EOD
     </TABLE>
EOD;
$tot_query = mysql_query("SELECT COUNT(wr_id) FROM workrequests where add_date > '2017-07-01'");
$sub_query = mysql_query("SELECT COUNT(wr_id) FROM workrequests WHERE status = 'Submitted' and add_date > '2017-07-01'");
$app_query = mysql_query("SELECT COUNT(wr_id) FROM workrequests WHERE status = 'Approved' and add_date > '2017-07-01'");
$ip_query = mysql_query("SELECT COUNT(wr_id) FROM workrequests WHERE (status = 'Waiting' OR status ='Started') and add_date > '2017-07-01'");
$fin_query = mysql_query("SELECT COUNT(wr_id) FROM workrequests WHERE (status = 'Finished' OR status ='Cancelled'
	OR status = 'Closed') and add_date > '2017-07-01'");
$tot_num = mysql_result($tot_query,0);
$sub_num = mysql_result($sub_query,0);
$app_num = mysql_result($app_query,0);
$ip_num = mysql_result($ip_query,0);
$fin_num = mysql_result($fin_query,0);
$open_num = $tot_num - $fin_num;
$content .= <<<EOD
	<P>Since July 1st, $tot_num requests have been entered into the system.  Of those, $fin_num have been completed and
	$open_num are open: $ip_num are in progress, $app_num are waiting on a technician, and $sub_num are waiting for 
	approval.</P>
			</div>
		</div>
EOD;

$display = str_replace("CONTENTPLACEHOLDER", $content, $wrapper);
echo $display;
?>