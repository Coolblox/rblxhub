<?php
require("../core/header.php");
require("../core/nav.php");

$id = $_GET['id'] ?? 0;

$id = intval($id);
                    $resultsperpage = 25;
                    $check = mysqli_query($connect, "SELECT * FROM users");
                    $usercount = mysqli_num_rows($check);

                    $numberofpages = ceil($usercount/$resultsperpage);

                    if(!isset($_GET['page'])) {
                        $page = 1;
                    }else{
                        $page = $_GET['page'];
                    }

                    $thispagefirstresult = ($page-1)*$resultsperpage;
                    
$fr = mysqli_query($connect, "SELECT * FROM forum WHERE reply_to='$id' LIMIT ".$thispagefirstresult.",".$resultsperpage) or die(mysqli_error($connect));

$fq = mysqli_query($connect, "SELECT * FROM forum WHERE id='$id'") or die(mysqli_error($connect));

if (mysqli_num_rows($fq) < 1) {
  die("<script>document.location = \"/Forum/\"</script>");
}

$fpost = mysqli_fetch_assoc($fq);

if ($fpost['reply_to'] != 0) {
  die("<script>document.location = \"/Forum/\"</script>");
}

                    $resultsperpage = 2;
                    $check = mysqli_query($connect, "SELECT * FROM forum WHERE reply_to='$id'");
                    $usercount = mysqli_num_rows($check);

                    $numberofpages = ceil($usercount/$resultsperpage);

                    if(!isset($_GET['page'])) {
                        $page = 1;
                    }else{
                        $page = $_GET['page'];
                    }

                    $thispagefirstresult = ($page-1)*$resultsperpage;
                    

$fauthor = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='{$fpost['author']}'"));

$ftimeago = time_elapsed_string("@{$fpost['time_posted']}");

$fauthorpostcount = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE author='{$fauthor['id']}'"));

if ($isloggedin) {
  if (isset($_POST['content'])) {
    if ($is_limited_account) {
      die("<center>Your account has to be at least three days old to post on the forums.</center>");
    }
    $content = mysqli_real_escape_string($connect, htmlspecialchars($_POST['content']));

    while (FilterString($content) != "OK") {
      $profanity = FilterString($content);
      $repl = str_repeat("*", strlen($profanity));
      $content = str_replace($profanity, $repl, $content);
    }

    $rn = time();
    $q = mysqli_query($connect, "INSERT INTO `forum`
      (`id`, `author`, `reply_to`, `title`, `content`, `time_posted`, `category`) VALUES
      (NULL, '{$_USER['id']}', '$id', 'reaction to post','$content','$rn','{$fpost['category']}')") or die(mysqli_error($connect));

      die("<script>document.location = \"/Forum/ShowPost?id=$id\"</script>");
  }
}

$fmembership = "";

if ($fauthor['membership_type'] == "LEVEL_1") {
  $fmembership = "<br>&nbsp;<img src=\"/images/baron_icon.png\" title=\"This user has purchased the Baron Membership.\" height=\"28\" width=\"28\">";
} else if ($fauthor['membership_type'] == "LEVEL_2") {
  $fmembership = "<br>&nbsp;<img src=\"/images/duke_icon.png\" title=\"This user has purchased the Duke Membership.\" height=\"28\" width=\"28\">";
} else if ($fauthor['membership_type'] == "LEVEL_3") {
  $fmembership = "<br>&nbsp;<img src=\"/images/king_icon.png\" title=\"This user has purchased the King Membership.\" height=\"28\" width=\"28\">";
}


$fpostedatsss = new DateTime("@{$fpost['time_posted']}");
$fpostedat =  $fpostedatsss->format('d F Y G:i');


$fisonline = "Offline";

if ($fauthor['lastseen'] + 300 > time()) {
  $fisonline = "Online";
}
?>
<div id="Body">
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr><td></td></tr>
                        <tr valign="bottom">
                            <td>
                                <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
                                    <tbody>
                                        <tr valign="top">
                                            <td>&nbsp;&nbsp;&nbsp;</td>
                                            <td width="95%" class="CenterColumn">
                                                <br>
                                                <span></span>
                                                <span>
                                                    <table cellpadding="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td align="left" colspan="2">&nbsp;
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <table class="tableBorder" cellspacing="1" cellpadding="0" border="0" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="forumHeaderBackgroundAlternate" colspan="2" height="20">
                                                                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                                                        <tbody>
                                                                                            <tr>
				<td align="left"></td><td align="right"><a class="linkSmallBold" href="">Previous Thread</a>&nbsp;<span class="normalTextSmallBold">::</span>&nbsp;<a class="linkSmallBold" href="">Next Thread</a>&nbsp;</td>
			</tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
		<th class="tableHeaderText" align="left" height="25" width="100">&nbsp;Author</th><th class="tableHeaderText" align="left" width="85%">&nbsp;Thread: <?php echo $fpost['title'] ?></th>
	</tr>
                                        
                                <tr>
                        <td class="forumRow" valign="top" width="150" nowrap="nowrap">
                            <table border="0">
                                <tbody>
                                    <tr>
            <form method="post" id="forumform">
				<td>				    <?php 
				    $online = ($fauthor['lastseen'] + 300 <= time()) ? "<img src='/Forum/api/skins/default/images/Offline.gif' border='0'>&nbsp;" : "<img src='/Forum/api/skins/default/images/Online.gif' border='0'>&nbsp;";
				    echo"$online";
				    ?><a class="normalTextSmallBold" href="/User.php?id=<?php echo $fauthor['id'] ?>"><?php echo $fauthor['username'] ?></a><br></td>
			</tr>
			<tr>
				<td>
				    <a href="/User.php?id=<?php echo $fauthor['id'] ?>"><img src="/images/Avatar.png" width="64" border="0"></a></td>
			</tr>
			<?php
              if ($fauthor['permission_level'] != "ADMINISTRATOR") {
                  
              }else{
                echo"<tr>
				<td><img src=\"/Forum/api/skins/default/images/users_moderator.gif\" alt=\"Forum Moderator\" border=\"0\"></td>
			</tr>";
              }
              if($fauthorpostcount >= "25") {
                 echo"<td><img src=\"/Forum/api/skins/default/images/top25.gif\" alt=\"Forum Moderator\" border=\"0\"></td>";
              }
			?>
			<tr>
				<td><span class="normalTextSmaller"><b>Joined:</b> <?php
                $dt = new DateTime("@{$fauthor['time_joined']}");
                echo $dt->format('d F Y');
                ?></span></td>
			</tr>
			<tr>
				<td><span class="normalTextSmaller"><b>Total Posts: </b><?php echo $fauthorpostcount ?></span></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			
                                </tbody>
                            </table>
                        </td>
                        <td class="forumRow" valign="top">
                            <table cellspacing="0" cellpadding="3" border="0" width="100%">
                                <tbody>
                                    <tr>
                        				<td class="forumRowHighlight"><span class="normalTextSmallBold"><?php echo $fpost['title'] ?><a name="112"></a></span><a name="112"><br><span class="normalTextSmaller"> Posted: </span><span class="normalTextSmaller"><?php echo $fpostedat ?></span></a></td>
                        			</tr>
                        			<tr>
                        			    <td colspan="2">
                        			        <span class="normalTextSmall">
                        			            <?php echo $fpost['content'] ?>
                        			        </span>
                        			    </td>
                        			</tr>
                        			<tr>
				<td colspan="2"><span class="normalTextSmaller"></span></td>
			</tr><tr>
				<td height="2"></td>
			</tr>
			<tr>
			    <td colspan="2">
			        <a href="/Forum/reply.php?id=<?php echo $fpost['id'] ?>"><img border="0" src="/images/newpost.gif"></a>
			        <a href="" style="font-size: 12px;">Report Abuse</a>
			    </td>
			</tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
<?php
            while ($post = mysqli_fetch_assoc($fr)) {

              $author = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='{$post['author']}'"));
              $timeago = time_elapsed_string("@{$post['time_posted']}");
              $authorpostcount = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE author='{$author['id']}'"));

              $membership = "";

              if ($author['membership_type'] == "LEVEL_1") {
                $membership = "<br>&nbsp;<img src=\"/images/baron_icon.png\" title=\"This user has purchased the Baron Membership.\" height=\"28\" width=\"28\">";
              } else if ($author['membership_type'] == "LEVEL_2") {
                $membership = "<br>&nbsp;<img src=\"/images/duke_icon.png\" title=\"This user has purchased the Duke Membership.\" height=\"28\" width=\"28\">";
              } else if ($author['membership_type'] == "LEVEL_3") {
                $membership = "<br>&nbsp;<img src=\"/images/king_icon.png\" title=\"This user has purchased the King Membership.\" height=\"28\" width=\"28\">";
              } else if ($author['membership_type'] == "PRO") {
                $membership = "<br>&nbsp;<img src=\"/images/pro.png\" title=\"This user has purchased a Pro Membership.\" height=\"28\" width=\"28\">";
              }
              //$adm = "";
              //if ($author['permission_level'] != "DEFAULT") {
                //$adm = "<tr><td><img src=\"content/users_moderator.gif\" alt=\"Forum Moderator\" border=\"0\"></td></tr>";
              //}

              if ($author['lastseen'] + 300 > time()) {
                $bababababba = "Online";
              } else {
                $bababababba = "Offline";
              }

              $dtasdf = new DateTime("@{$author['time_joined']}");
              $joinedat =  $dtasdf->format('d F Y');

              $postedatsss = new DateTime("@{$post['time_posted']}");
              $postedat =  $postedatsss->format('d F Y G:i');
              $post['content'] = nl2br($post['content']);
              				    $onlinee = ($author['lastseen'] + 300 <= time()) ? "<img src='/Forum/api/skins/default/images/Offline.gif' border='0'>&nbsp;" : "<img src='/Forum/api/skins/default/images/Online.gif' border='0'>&nbsp;";
            echo "
            <tr>
                        <td class='forumRow' valign='top' width='150' nowrap='nowrap'>
                            <table border='0'>
                                <tbody>
                                    <tr>
            <form method='post' id='forumform'></form>
				<td>$onlinee<a class='normalTextSmallBold' href='/User.php?id={$author['id']}'>{$author['username']}</a><br></td>
			</tr>
			<tr>
				<td><a href='/User.php?id={$author['id']}'><img src='/images/Avatar.png' width='64' border='0'></a></td>
			</tr>
";
              if ($author['permission_level'] != "ADMINISTRATOR") {
                  
              }else{
                echo"<tr>
				<td><img src=\"/Forum/api/skins/default/images/users_moderator.gif\" alt=\"Forum Moderator\" border=\"0\"></td>
			</tr>";
              }
echo"
			<tr>
				<td><span class='normalTextSmaller'><b>Joined: </b>
				
			";
			$dt = new DateTime("@{$author['time_joined']}");
                echo $dt->format('d F Y');
			echo"
			</span></td>
			</tr>
			<tr>
				<td><span class='normalTextSmaller'><b>Total Posts: </b>$authorpostcount</span></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			
                                </tbody>
                            </table>
                        </td>
                        <td class='forumRow' valign='top'>
                            <table cellspacing='0' cellpadding='3' border='0' width='100%'>
                                <tbody>
                                    <tr>
                        				<td class='forumRowHighlight'><span class='normalTextSmallBold'>RE: {$fpost['title']}<a name='112'></a></span><a name='112'><br><span class='normalTextSmaller'> Posted: </span><span class='normalTextSmaller'>$postedat</span></a></td>
                        			</tr>
                        			<tr>
                        			    <td colspan='2'>
                        			        <span class='normalTextSmall'>{$post['content']}</span>
                        			    </td>
                        			</tr>
                        			<tr>
				<td colspan='2'><span class='normalTextSmaller'></span></td>
			</tr><tr>
				<td height='2'></td>
			</tr>
			<tr>
			    <td colspan='2'>
			        <a href='/Forum/reply.php?id={$post['id']}'><img border='0' src='/images/newpost.gif'></a>
			        <a href='' style='font-size: 12px;'>Report Abuse</a>
			    </td>
			</tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    ";
          }
            ?>
                    	<tr>
		<td class="forumHeaderBackgroundAlternate" colspan="2" height="20"><table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tbody><tr>
				<td align="left"></td><td align="right"><a class="linkSmallBold" href="">Previous Thread</a>&nbsp;<span class="normalTextSmallBold">::</span>&nbsp;<a class="linkSmallBold" href="">Next Thread</a>&nbsp;</td>
			</tr>
		</tbody></table></td>
	</tr>
<?php
echo "<span id='ctl00_cphRoblox_ThreadView1_ctl00_Pager'><table cellspacing='0' cellpadding='0' border='0' width='100%'>
<tr>
	<td><span class='normalTextSmallBold'>";
	if($numberofpages == 0) {
	echo"Page $page of 1";
	}else{
	echo"Page $page of $numberofpages";
	}
	echo"</span></td><td align='right'><span><span class='normalTextSmallBold'>Goto to page: </span>
";

                    if($numberofpages == 0) {
                    echo"<a id='ctl00_cphRoblox_ThreadView1_ctl00_Pager_Page0' class='normalTextSmallBold' href='/Forum/ShowPost.php?id=$id&page=1'>1</a>";
                    }
                   for ($page=1;$page<=$numberofpages;$page++) {

                        echo "<a id='ctl00_cphRoblox_ThreadView1_ctl00_Pager_Page0' class='normalTextSmallBold' href='/Forum/ShowPost.php?id=$id&page=$page'>$page</a> ";
                    }
                    echo "	<span class='normalTextSmallBold'></td>
</tr>
</table></span>";
?>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </span>
                                            </td>
                                            <td>&nbsp;&nbsp;&nbsp;</td>
                                            <td>&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                    <?php
    require ("/storage/ssd1/648/16177648/public_html/core/footer.php");
    ?>
            </div>
            <style>
/*****************************************************
General Anchor
*****************************************************/
a.linkSmallBold, a.linkMenuSink
{
    font-weight: bold;
}

a.linkSmall, a.LinkSmallBold, a.linkMenuSink
{
    color: navy;
    font-size: 10px;
}


a.linkSmallBold:visited, a.linkMenuSink:visited
{
    color: #013DA4;
}

a.linkSmallBold:Hover, a.linkMenuSink:Hover
{
    color: #DD6900;
}


/*****************************************************
Text and Anchor to display when a user is online
*****************************************************/
.userOnlineLinkBold, a.userOnlineLinkBold, a.userOnlineLinkBold:Visited, a.userOnlineLinkBold:Hover, a.userOnlineLinkBold:Link
{
    font-weight: bold;
    color: #0055E7;
}

.moderatorOnlineLinkBold, a.moderatorOnlineLinkBold, a.moderatorOnlineLinkBold:Visited, a.moderatorOnlineLinkBold:Hover, a.moderatorOnlineLinkBold:Link
{
    font-weight: bold;
    color: darkblue;
}

.adminOnlineLinkBold, a.adminOnlineLinkBold, a.adminOnlineLinkBold:Visited, a.adminOnlineLinkBold:Hover, a.adminOnlineLinkBold:Link
{
    font-weight: bold;
    color: black;
}

/*****************************************************
Text and anchors used in the navigation menu
*****************************************************/
.menuTitle
{
    font-weight: bold;
    font-size: 20px;
    font: normal 8pt/normal Verdana, sans-serif;
    FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
    color: navy;
}

.menuText
{
    font-size: 0.9em;
    font-weight: bold;
    font: normal 8pt/normal Verdana, sans-serif;
    color: #FFFFFF;
}

a.menuTextLink:visited, a.menuTextLink:link
{
    font-size: 0.9em;
    text-decoration: none; 
    font: normal 8pt/normal Verdana, sans-serif;
    color: #013DA4;
}

a.menuTextLink:Hover
{
    color: #000000;
}


/*****************************************************
Text and anchors used in the search
*****************************************************/
.searchPager
{
    font-size : 0.9em;
    font-weight: bold;
}

.searchItem
{
    background-color: #DDEEFF; 
}

.searchAlternatingItem
{
    background-color: #FFFFFF;
}


/*****************************************************
Default separator style for PostList
*****************************************************/
td.flatViewSpacing
{
    height: 2px;
    background-color: #80B7FF;
}

/*****************************************************
Table Header and cell definitions
*****************************************************/
th
{
    background-image: url(/Forum/api/skins/default/images/forumHeaderBackground.gif);
    background-color: #4455aa
}

td.forumHeaderBackgroundAlternate
{
    background-image: url(/Forum/api/skins/default/images/forumHeaderBackgroundAlternate.gif);
    background-color: #EBEDF6;
}

/*****************************************************
Body
*****************************************************/
body 
{
    FONT-SIZE: 8pt;
    font: normal 8pt/normal Verdana, sans-serif;
    scrollbar-face-color: #DEE3E7;
    scrollbar-highlight-color: #FFFFFF;
    scrollbar-shadow-color: #DEE3E7;
    scrollbar-3dlight-color: #D1D7DC;
    scrollbar-arrow-color:  #006699;
    scrollbar-track-color: #EFEFEF;
    scrollbar-darkshadow-color: #98AAB1;
}


/*****************************************************
Validation Text
*****************************************************/
.validationWarningSmall
{
    color: Red;
    font-size : 0.9em;
}

/*****************************************************
General Text
*****************************************************/
.normalTextSmall 
{ 
    font-size : 11px;
}

.normalTextSmallBold
{ 
    font-size : 11px;
    font-weight: bold;
}

.normalTextSmaller
{
    font-size: 10px;
}

.normalTextSmall, .normalTextSmallBold, .normalTextSmaller
{ 
    FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
}

/*****************************************************
Text used on tables with a background
*****************************************************/
.tableHeaderText
{
    color: white;
    font-size: 10px;
    font-weight:bold;
    font: normal 8pt/normal Verdana, sans-serif;
}

/*****************************************************
Border used around tables
*****************************************************/
.tableBorder
{
    border: 1px #013DA4 solid; 
    background-color: #FFFFFF;
}

/*****************************************************
Main forum colors
*****************************************************/
td.forumRow
{
    background-color: #DDEEFF;
}


td.forumAlternate
{
    background-color: #DAE7FD;
}

/*****************************************************
Background color and text used in threaded view
*****************************************************/
td.threadTitle
{
    background-color: #D4D9EC;
}

.threadDetailTextSmall
{
    color: #0055E7;
    font-size: 0.9em;
}

.threadDetailTextSmallBold
{
    color: #0055E7;
    font-size: 0.9em;
    font-weight: bold;
    font: normal 8pt/normal Verdana, sans-serif;
}

td.forumRowHighlight
{
    background-color: #D4D9EC;
}

/*****************************************************
Text and links used in ForumGroupRepeater and ForumRepeater
*****************************************************/
.forumTitle
{
    font-size: 1.0px;
    font-weight: bold;
    font: normal 8pt/normal Verdana, sans-serif;
    color: #013DA4;
}


a.forumTitle:visited, a.forumTitle:link
{
    font-size: 1.0em;
    font-weight: bold;
    color: #013DA4;
}

a.forumTitle:hover
{
    color: #DD6900;
}

.forumName
{
    font-weight: bold;
    FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
    font-size: 16px; 
    text-decoration: none; 
    color: navy;
}

a.forumName:hover
{
    color: #DD6900;
    text-decoration: underline;
}


/*****************************************************
Form Elements
*****************************************************/
select
{   FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
    font-size: 0.9em;
    font-weight: bold;
    background-color: #DAE7FD;
    border-color: Black;
}

textarea
{
    font-size: 0.9em;
    FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
    background-color: White;
    border-color: Black;
}

/*****************************************************
Menu Controls
*****************************************************/
A.linkMenuSink
{
    font-size: 0.9em;
    FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
    position: relative;
}

TD.popupMenuSink
{
    position: relative;
}

DIV.popupMenu
{
    border: 1px solid blue;
}

DIV.popupTitle
{
	FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
    color: white;
    font-weight: bold;
    background-color: #4455AA;
}

DIV.popupItem
{
    font-size: 1.0em;
    font-weight: bold;
	FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
    background-color: #DDEEFF;
}
</style>