<?php
require ("/storage/ssd1/648/16177648/public_html/core/header.php");
require ("/storage/ssd1/648/16177648/public_html/core/nav.php");
$topic = $_GET['t'] ?? 1;

$topic = intval($topic);


$fq = mysqli_query($connect, "SELECT * FROM forum WHERE category='$topic' AND reply_to='0' ORDER BY `time_posted` DESC") or die(mysqli_error($connect));

$nowwww = new DateTime("@" . time());
$now = $nowwww->format('d F Y G:i');

$btthreads = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE category='1' AND reply_to='0'"));
$btreplies = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE category='1'"));

$hthreads = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE category='2' AND reply_to='0'"));
$hreplies = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE category='2'"));

$rnthreads = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE category='3' AND reply_to='0'"));
$rnreplies = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE category='3'"));

$sthreads = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE category='4' AND reply_to='0'"));
$sreplies = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE category='4'"));

$otthreads = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE category='5' AND reply_to='0'"));
$otreplies = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE category='5'"));

$rpthreads = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE category='6' AND reply_to='0'"));
$rpreplies = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE category='6'"));

$rmcthreads = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE category='7' AND reply_to='0'"));
$rmcreplies = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM forum WHERE category='7'"));



$lp1q = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM forum WHERE category='1' ORDER BY id DESC LIMIT 1"));
$lp1a = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='{$lp1q['author']}'"));
$lp1t = time_elapsed_string("@{$lp1q['time_posted']}");
$lp1 = "<center>$lp1t<br>by <a href=\"/User.php?id={$lp1q['author']}\">{$lp1a['username']}</a></center>";

$lp2q = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM forum WHERE category='2' ORDER BY id DESC LIMIT 1"));
$lp2a = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='{$lp2q['author']}'"));
$lp2t = time_elapsed_string("@{$lp2q['time_posted']}");
$lp2 = "<center>$lp2t<br>by <a href=\"/User.php?id={$lp2q['author']}\">{$lp2a['username']}</a></center>";

$lp3q = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM forum WHERE category='3' ORDER BY id DESC LIMIT 1"));
$lp3a = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='{$lp3q['author']}'"));
$lp3t = time_elapsed_string("@{$lp3q['time_posted']}");
$lp3 = "<center>$lp3t<br>by <a href=\"/User.php?id={$lp3q['author']}\">{$lp3a['username']}</a></center>";

$lp4q = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM forum WHERE category='4' ORDER BY id DESC LIMIT 1"));
$lp4a = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='{$lp4q['author']}'"));
$lp4t = time_elapsed_string("@{$lp4q['time_posted']}");
$lp4 = "<center>$lp4t<br>by <a href=\"/User.php?id={$lp4q['author']}\">{$lp4a['username']}</a></center>";

$lp5q = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM forum WHERE category='5' ORDER BY id DESC LIMIT 1"));
$lp5a = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='{$lp5q['author']}'"));
$lp5t = time_elapsed_string("@{$lp5q['time_posted']}");
$lp5 = "<center>$lp5t<br>by <a href=\"/User.php?id={$lp5q['author']}\">{$lp5a['username']}</a></center>";

$lp6q = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM forum WHERE category='6' ORDER BY id DESC LIMIT 1"));
$lp6a = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='{$lp6q['author']}'"));
$lp6t = time_elapsed_string("@{$lp6q['time_posted']}");
$lp6 = "<center>$lp6t<br>by <a href=\"/User.php?id={$lp6q['author']}\">{$lp6a['username']}</a></center>";

$lp7q = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM forum WHERE category='7' ORDER BY id DESC LIMIT 1"));
$lp7a = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='{$lp7q['author']}'"));
$lp7t = time_elapsed_string("@{$lp7q['time_posted']}");
$lp7 = "<center>$lp7t<br>by <a href=\"/User.php?id={$lp7q['author']}\">{$lp7a['username']}</a></center>";
?>
<link rel="stylesheet" href="/Forum/api/skins/default/style/default.css" type="text/css"/>
<div id="Body">
					
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td>
						
					</td>
				</tr>
				<tr valign="bottom">
					<td>
						<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
							<tr valign="top">
								<!-- left column -->
								<td class="LeftColumn">&nbsp;&nbsp;&nbsp;</td>
								<td id="ctl00_cphRoblox_LeftColumn" nowrap="nowrap" width="180" class="LeftColumn">
									<p>
										<span id="ctl00_cphRoblox_SearchRedirect">

<table class="tableBorder" cellspacing="1" cellpadding="3" width="100%">
  <tr>
    <th class="tableHeaderText" align="left" colspan="2">
      &nbsp;Search <?=$sitename?> Forums
    </th>
  </tr>
  <tr>
    <td class="forumRow" align="left" valign="top" colspan="2">
      <table cellspacing="1" border="0" cellpadding="2">
        <tr>
          <td>
            <input name="ctl00$cphRoblox$SearchRedirect$ctl00$SearchText" type="text" maxlength="50" id="ctl00_cphRoblox_SearchRedirect_ctl00_SearchText" size="10"/>
          </td>

          <td align="right" colspan="2">
            <input type="submit" name="ctl00$cphRoblox$SearchRedirect$ctl00$SearchButton" value="Search" id="ctl00_cphRoblox_SearchRedirect_ctl00_SearchButton"/>
          </td>
        </tr>
      </table>
      <span class="normalTextSmall">
      <br>
      <a href="/web/20071230050111/http://www.roblox.com/Forum/Search/default.aspx">More search options</a>
      </span>
    </td>
  </tr>
</table>



</span>
										<br>
										
										<br>
								<td class="LeftColumn">&nbsp;&nbsp;&nbsp;</td>
								<!-- center column -->
								<td class="CenterColumn">&nbsp;&nbsp;&nbsp;</td>
								<td id="ctl00_cphRoblox_CenterColumn" width="95%" class="CenterColumn">
									<span id="ctl00_cphRoblox_NavigationMenu2">
<table width="100%" cellspacing="1" cellpadding="0">
	<tr>
		<td align="right" valign="middle">
			<a id="ctl00_cphRoblox_NavigationMenu2_ctl00_HomeMenu" class="menuTextLink" href="/web/20071230050111/http://www.roblox.com/Forum/Default.aspx"><img src="/Forum/api/skins/default/images/icon_mini_home.gif" border="0">Home &nbsp;</a>
			<a id="ctl00_cphRoblox_NavigationMenu2_ctl00_SearchMenu" class="menuTextLink" href="/web/20071230050111/http://www.roblox.com/Forum/Search/default.aspx"><img src="/Forum/api/skins/default/images/icon_mini_search.gif" border="0">Search &nbsp;</a>
			
			
			<a id="ctl00_cphRoblox_NavigationMenu2_ctl00_RegisterMenu" class="menuTextLink" href="/web/20071230050111/http://www.roblox.com/Forum/User/CreateUser.aspx"><img src="/Forum/api/skins/default/images/icon_mini_register.gif" border="0">Register &nbsp;</a>
			
			
			
			
		</td>
	</tr>
</table>
</span>
									<br>
									<table cellpadding="0" cellspacing="2" width="100%">
										<tr>
											<td align="left">
												<span class="normalTextSmallBold">Current time: </span><span class="normalTextSmall"><?php echo $now ?></span>
											</td>
											<td align="right">
												
											</td>
										</tr>
									</table>
									<table cellpadding="2" cellspacing="1" border="0" width="100%" class="tableBorder"><tr>
	<th class="tableHeaderText" colspan="2" height="20">Forum</th><th class="tableHeaderText" width="50" nowrap="nowrap">&nbsp;&nbsp;Threads&nbsp;&nbsp;</th><th class="tableHeaderText" width="50" nowrap="nowrap">&nbsp;&nbsp;Posts&nbsp;&nbsp;</th><th class="tableHeaderText" width="135" nowrap="nowrap">&nbsp;Last Post&nbsp;</th>
</tr><tr id="ctl00_cphRoblox_ForumGroupRepeater1_ctl01_ForumGroup">
	<td class="forumHeaderBackgroundAlternate" colspan="5" height="20"><a id="ctl00_cphRoblox_ForumGroupRepeater1_ctl01_GroupTitle" class="forumTitle" href="/web/20071230050111/http://www.roblox.com/Forum/ShowForumGroup.aspx?ForumGroupID=1"><?=$sitename?></a></td>
</tr><tr>
	<td class="forumRow" align="center" valign="top" width="34" nowrap="nowrap"><img src="/Forum/api/skins/default/images/forum_status.gif" width="34" border="0"/></td><td class="forumRow" width="80%"><a class="forumTitle" href="/Forum/ShowForum.php?id=1">General Discussion</a><span class="normalTextSmall"><br>This is the place for conversation about all things <?=$sitename?>.  Posts not pertaining to <?=$sitename?> will be mercilessly pruned by our crack squad of moderators.</span></td><td class="forumRowHighlight" align="center"><span class="normalTextSmaller"><?php echo $btthreads ?></span></td><td class="forumRowHighlight" align="center"><span class="normalTextSmaller"><?php echo $btreplies ?></span></td><td class="forumRowHighlight" align="center"><span class="normalTextSmaller"><span><b><?php echo $lp1 ?><a href="#"><img border="0" src="/Forum/api/skins/default/images/icon_mini_topic.gif"></a></span></td>
</tr><tr>
	<td class="forumRow" align="center" valign="top" width="34" nowrap="nowrap"><img src="/Forum/api/skins/default/images/forum_status.gif" width="34" border="0"/></td><td class="forumRow" width="80%"><a class="forumTitle" href="/Forum/ShowForum.php?id=2">Suggestions, Feedback, and Ideas</a><span class="normalTextSmall"><br>Do you have a suggestion for how to make <?=$sitename?> better? Share your feedback here.</span></td><td class="forumRowHighlight" align="center"><span class="normalTextSmaller"><?php echo $hthreads ?></span></td><td class="forumRowHighlight" align="center"><span class="normalTextSmaller"><?php echo $hreplies ?></span></td><td class="forumRowHighlight" align="center"><span class="normalTextSmaller"><span><b><?php echo $lp2 ?><a href="#"><img border="0" src="/Forum/api/skins/default/images/icon_mini_topic.gif"></a></span></td>
</tr>
</table>
									<p></p>
								</td>

								<td class="CenterColumn">&nbsp;&nbsp;&nbsp;</td>
								<!-- right margin -->
								<td class="RightColumn">&nbsp;&nbsp;&nbsp;</td>
								
							</tr>
						</table>
					</td>
				</tr>
			</table>

				</div>