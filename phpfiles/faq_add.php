<?PHP
foreach($_GET as $k => $v) $_GET[$k] = addslashes($v);
foreach($_POST as $k => $v) $_POST[$k] = addslashes($v);
foreach($_COOKIE as $k => $v) $_COOKIE[$k] = addslashes($v);
import_request_variables("gp");
include("FCKeditor/fckeditor.php");
$handle = fopen("wrapper.txt","r");
$wrapper = fread($handle,filesize("wrapper.txt"));
fclose($handle);
mysql_connect("151.161.128.40","hitman","pw4hitman");
mysql_select_db("lhucc_webdb");

$content .= <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">FAQ Addition</a></h2>
			</div>
			<div class="entry">
	<P>Question and answer can be any length.  HTML formatting can be
	used to add hyperlinks, images or pretty much anything else you
	can put on a webpage.  Please remember to close any HTML tags as
	these will affect the rest of the page.</P>
	<FORM ACTION="$PHP_SELF" METHOD="POST">
	<B>Question:</B><BR>
	<TEXTAREA NAME="question" COLS="50" ROWS="2">
EOD;
if ($action == "Preview") {
	$content .= stripslashes($question);
	}
$content .= <<<EOD
      </TEXTAREA><BR><BR>
	<B>Answer:</B><BR>
	<!---<TEXTAREA NAME="answer" COLS="50" ROWS="6">-->
EOD;
        $aFCKeditor = new FCKeditor('answer') ;
        $aFCKeditor->BasePath = 'FCKeditor/';
        $aFCKeditor->Value = stripslashes($answer);
        $content .= $aFCKeditor->CreateHTML() ;


$content .= <<<EOD
      <!---</TEXTAREA>--><BR><BR>
	<INPUT TYPE="SUBMIT" VALUE="Add" NAME="action">
	<INPUT TYPE="SUBMIT" VALUE="Preview" NAME="action">
	</FORM>
                        </div>
                </div>
EOD;

if ((strlen($question) > 0) || (strlen($answer) > 0)) {
	if ((strlen($question) > 0) && (strlen($answer) > 0) && ($action == "Add")) {
		mysql_query("INSERT INTO faqs (question,answer,date_added)
			VALUES ('$question','$answer',NOW())");
		$content .= <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Success!</a></h2>
			</div>
			<div class="entry">
EOD;

		$content.= "
			<P>Inserted Question: " . stripslashes($question) . "<BR>
			with Answer:<BR> " . stripslashes($answer) . "</P>
			";
		$content .= <<<EOD
                        </div>
                </div>
EOD;

		}
	else if ((strlen($question) > 0) && (strlen($answer) > 0) && ($action == "Preview")) {
		$content .= <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Preview</a></h2>
			</div>
			<div class="entry">
EOD;
		$content .= "
			<P>Question: " . stripslashes($question) . "<BR>
			Answer:<BR> " . stripslashes($answer) . "</P>
			";
		$content .= <<<EOD
                        </div>
                </div>
EOD;
		}
	else {
		$content .= <<<EOD
		<div class="post">
			<div class="title">
				<h2><a href="#">Error!</a></h2>
			</div>
			<div class="entry">
                        <p>You must specify both a question and an answer.</p>
                        </div>
                </div>
EOD;
		}
	}

$display = str_replace("CONTENTPLACEHOLDER", $content, $wrapper);
echo $display;
?>
