<?PHP
$handle = fopen("wrapper.txt","r");
$wrapper = fread($handle,filesize("wrapper.txt"));
fclose($handle);
mysql_connect("localhost","","");
mysql_select_db("lhucc_webdb");
if (strlen($req_uname) > 0){
	$name_cond = "AND req_uname LIKE '%$req_uname%'";
	}
$wr_query = mysql_query("SELECT wr_id,req_name,title,status,cc_staff,ph_num,building,room_no FROM workrequests 
	WHERE (status = 'Finished' OR status = 'Cancelled' OR status = 'Followup') $name_cond ORDER BY status,wr_id");
$content .= <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Work Request Closeout</a></h2>
			</div>
			<div class="entry">
	<P>The following work requests have been either Finished or cancelled and are ready for follow-up.</P>
	<FORM ACTION="$PHP_SELF" METHOD="POST">
	<P>Show requests from user:
	<INPUT TYPE="TEXT" NAME="req_uname" SIZE="8" MAXLENGTH="8">
	<INPUT TYPE="SUBMIT" VALUE="Find">
	</FORM></P>
      <TABLE BORDER=1>
	<TR>
		<TD>ID</TD>
		<TD>Requestor</TD>
		<TD>Phone</TD>
		<TD>Location</TD>
		<TD>Title</TD>
		<TD>Status</TD>
		<TD>Staff</TD>
	</TR>
EOD;
$rows = mysql_num_rows($wr_query);
while ($rows > 0):
	$wr_obj = mysql_fetch_object($wr_query);
$content .= <<<EOD
	<TR>
		<TD><A HREF="wr_disp.php?wr_id=$wr_obj->wr_id">$wr_obj->wr_id</A></TD>
		<TD>$wr_obj->req_name</TD>
		<TD>$wr_obj->ph_num</TD>
		<TD>$wr_obj->building $wr_obj->room_no</TD>
		<TD>$wr_obj->title</TD>
		<TD>$wr_obj->status</TD>
		<TD>$wr_obj->cc_staff</TD>
	</TR>
EOD;
	--$rows;
	endwhile;
$content .= <<<EOD
      </TABLE>

			</div>
		</div>

EOD;

$display = str_replace("CONTENTPLACEHOLDER", $content, $wrapper);
echo $display;
?>