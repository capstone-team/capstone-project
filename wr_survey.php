<?PHP
import_request_variables("gp");
$handle = fopen("wrapper.txt","r");
$wrapper = fread($handle,filesize("wrapper.txt"));
fclose($handle);
mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");
$wr_query = mysql_query("SELECT * FROM workrequests WHERE wr_id = $wr_id");
if (mysql_num_rows($wr_query) != 1) {
$content = <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Error!</a></h2>
			</div>
			<div class="entry">
                        <p>That work request does not exist.</p>
                        </div>
                </div>
EOD;
	}
else {
	$wr_obj = mysql_fetch_object($wr_query);
$content = <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Work Request Satisfaction Survey</a></h2>
			</div>
			<div class="entry">
	<p>Work Request ID: $wr_id<br>
	   Requestor: $wr_obj->req_name<br>
	   Title: $wr_obj->title<p>
	<p>To better improve our service to you, please take a moment to answer the following questions:</p>
	<form action="wr_survey_post.php">
	<input type=hidden name="wr_id" value="$wr_id">
	<TABLE BORDER=1 width=100%>
	  <tr>
	    <td colspan=10>Please rate your overall satisfaction with our response to your request.</td>
	  </tr>
	  <tr>
	    <td colspan=10>
	      <table border=0 width=100%><tr>
	        <td width=50% align=left>Outstanding</td>
	        <td width=50% align=right>Poor</td>
	      </tr></table>
	    </td>
	  </tr>
	  <tr>
	    <td width=10% align=center>10</td>
	    <td width=10% align=center>9</td>
	    <td width=10% align=center>8</td>
	    <td width=10% align=center>7</td>
	    <td width=10% align=center>6</td>
	    <td width=10% align=center>5</td>
	    <td width=10% align=center>4</td>
	    <td width=10% align=center>3</td>
	    <td width=10% align=center>2</td>
	    <td width=10% align=center>1</td>
	  </tr>
	  <tr>
	    <td align=center><input type=radio name="overall_score" value="10"></td>
	    <td align=center><input type=radio name="overall_score" value="9"></td>
	    <td align=center><input type=radio name="overall_score" value="8"></td>
	    <td align=center><input type=radio name="overall_score" value="7"></td>
	    <td align=center><input type=radio name="overall_score" value="6"></td>
	    <td align=center><input type=radio name="overall_score" value="5"></td>
	    <td align=center><input type=radio name="overall_score" value="4"></td>
	    <td align=center><input type=radio name="overall_score" value="3"></td>
	    <td align=center><input type=radio name="overall_score" value="2"></td>
	    <td align=center><input type=radio name="overall_score" value="1"></td>
	  </tr>
	</TABLE>
	<br><br>
	<TABLE BORDER=1 width=100%>
	  <tr>
	    <td colspan=10>Please rate the knowledge and attentiveness of the technician.</td>
	  </tr>
	  <tr>
	    <td colspan=10>
	      <table border=0 width=100%><tr>
	        <td width=50% align=left>Outstanding</td>
	        <td width=50% align=right>Poor</td>
	      </tr></table>
	    </td>
	  </tr>
	  <tr>
	    <td width=10% align=center>10</td>
	    <td width=10% align=center>9</td>
	    <td width=10% align=center>8</td>
	    <td width=10% align=center>7</td>
	    <td width=10% align=center>6</td>
	    <td width=10% align=center>5</td>
	    <td width=10% align=center>4</td>
	    <td width=10% align=center>3</td>
	    <td width=10% align=center>2</td>
	    <td width=10% align=center>1</td>
	  </tr>
	  <tr>
	    <td align=center><input type=radio name="tech_score" value="10"></td>
	    <td align=center><input type=radio name="tech_score" value="9"></td>
	    <td align=center><input type=radio name="tech_score" value="8"></td>
	    <td align=center><input type=radio name="tech_score" value="7"></td>
	    <td align=center><input type=radio name="tech_score" value="6"></td>
	    <td align=center><input type=radio name="tech_score" value="5"></td>
	    <td align=center><input type=radio name="tech_score" value="4"></td>
	    <td align=center><input type=radio name="tech_score" value="3"></td>
	    <td align=center><input type=radio name="tech_score" value="2"></td>
	    <td align=center><input type=radio name="tech_score" value="1"></td>
	  </tr>
	</TABLE>
	<br><br>
	<TABLE BORDER=1 width=100%>
	  <tr>
	    <td colspan=10>Please rate the timeliness of the completion of your request.</td>
	  </tr>
	  <tr>
	    <td colspan=10>
	      <table border=0 width=100%><tr>
	        <td width=50% align=left>Outstanding</td>
	        <td width=50% align=right>Poor</td>
	      </tr></table>
	    </td>
	  </tr>
	  <tr>
	    <td width=10% align=center>10</td>
	    <td width=10% align=center>9</td>
	    <td width=10% align=center>8</td>
	    <td width=10% align=center>7</td>
	    <td width=10% align=center>6</td>
	    <td width=10% align=center>5</td>
	    <td width=10% align=center>4</td>
	    <td width=10% align=center>3</td>
	    <td width=10% align=center>2</td>
	    <td width=10% align=center>1</td>
	  </tr>
	  <tr>
	    <td align=center><input type=radio name="time_score" value="10"></td>
	    <td align=center><input type=radio name="time_score" value="9"></td>
	    <td align=center><input type=radio name="time_score" value="8"></td>
	    <td align=center><input type=radio name="time_score" value="7"></td>
	    <td align=center><input type=radio name="time_score" value="6"></td>
	    <td align=center><input type=radio name="time_score" value="5"></td>
	    <td align=center><input type=radio name="time_score" value="4"></td>
	    <td align=center><input type=radio name="time_score" value="3"></td>
	    <td align=center><input type=radio name="time_score" value="2"></td>
	    <td align=center><input type=radio name="time_score" value="1"></td>
	  </tr>
	</TABLE>
	<br><br>
	<TABLE BORDER=1 width=100%>
	  <tr>
	    <td colspan=10>Please rate your experience with the IT Helpdesk.</td>
	  </tr>
	  <tr>
	    <td colspan=10>
	      <table border=0 width=100%><tr>
	        <td width=50% align=left>Outstanding</td>
	        <td width=50% align=right>Poor</td>
	      </tr></table>
	    </td>
	  </tr>
	  <tr>
	    <td width=10% align=center>10</td>
	    <td width=10% align=center>9</td>
	    <td width=10% align=center>8</td>
	    <td width=10% align=center>7</td>
	    <td width=10% align=center>6</td>
	    <td width=10% align=center>5</td>
	    <td width=10% align=center>4</td>
	    <td width=10% align=center>3</td>
	    <td width=10% align=center>2</td>
	    <td width=10% align=center>1</td>
	  </tr>
	  <tr>
	    <td align=center><input type=radio name="help_score" value="10"></td>
	    <td align=center><input type=radio name="help_score" value="9"></td>
	    <td align=center><input type=radio name="help_score" value="8"></td>
	    <td align=center><input type=radio name="help_score" value="7"></td>
	    <td align=center><input type=radio name="help_score" value="6"></td>
	    <td align=center><input type=radio name="help_score" value="5"></td>
	    <td align=center><input type=radio name="help_score" value="4"></td>
	    <td align=center><input type=radio name="help_score" value="3"></td>
	    <td align=center><input type=radio name="help_score" value="2"></td>
	    <td align=center><input type=radio name="help_score" value="1"></td>
	  </tr>
	</TABLE>
	<p>Please provide any additional comments you may have:</p>
	<TEXTAREA NAME="comments" COLS="50" ROWS="8"></TEXTAREA>
	<br><br>
	<input type="submit" value="Complete Survey">
	</form>
	
			</div>
		</div>

EOD;
	}
$display = str_replace("CONTENTPLACEHOLDER", $content, $wrapper);
echo $display;
?>