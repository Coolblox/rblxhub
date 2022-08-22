<?php
require ("/storage/ssd1/648/16177648/public_html/core/header.php");
require ("/storage/ssd1/648/16177648/public_html/core/nav.php");
if (!$isloggedin) {
    header('Location: /Login/');
}
$msg = mysqli_query($connect, "SELECT * FROM friends WHERE user_to='{$_USER['id']}' AND arefriends='0' ORDER BY id DESC") or die(mysqli_error($connect));
$achievements = mysqli_query($connect, "SELECT * FROM owned_achievements WHERE user_id='{$_USER['id']}'") or die(mysqli_error($connect));
?>
<div id="Body">
<div id="UserContainer">
	<div id="LeftBank">
		<div>
			<div id="ProfilePane">
				<table width="100%" bgcolor="lightsteelblue" cellpadding="6" cellspacing="0">
					<tbody><tr>
						<td>
							<font face="Verdana"><span class="Title">Welcome, <?php echo $_USER['username'] ; ?>!</span><br></font>
						</td>
					</tr>
					<tr>
						<td>
						<font face="Verdana">
							<span>Your <?=$sitename?>:</span><br>
							<a href="/User.php?id=<?php echo $_USER['id'] ; ?>">https://rblxhub.ga/User.php?id=<?php echo $_USER['id'] ; ?></a>
							<br>
							<br>
							<div style="left: 0px; float: left; position: relative; top: 0px;margin-top:67px;margin-left:10px">
								<a disabled="disabled" title="qwertywasdda" onclick="return false" style="display:inline-block;height:220px;width:180px;">
									<iframe height="220" width="200" src="https://web.archive.org/web/20110711055128im_/http://t7.roblox.com/Avatar-180x220-a4c138a9343e14c5357d62566d3c9c1b.Png" frameborder="0" scrolling="no"></iframe>
								</a>
								<br>
							</div>
						<div style="float:right;text-align:left;width:210px;"><font face="Verdana">
							<p><a href="/my/inbox">Inbox</a>&nbsp;</p>
							<p><a href="/my/character">Change Character</a></p>
							<p><a href="/my/settings">Edit Profile</a></p>
							<p><a href="/my/balance">Account Balance</a></p>
							<p><a href="/User.php?id=<?php echo $_USER['id'] ; ?>">View Public Profile</a></p>
							<p>
																<a href="/my/createplace/">Create New Place</a>							</p>
							<p><a href="/info/TermsOfService">Terms, Conditions, and Rules</a></p>
							</font>
							</div>
						</font></td>
					</tr>
				</tbody></table>
							</div>
		</div>
		<div>	<div id="UserBadgesPane">
			<div id="UserBadges">
				<h4><a href="/Badges">Badges</a></h4>
				<table cellspacing="0" border="0" align="Center">
					<tbody>
					<td>
      <?php

            $i = 0;

            while ($ownedachievement = mysqli_fetch_assoc($achievements)) {
              $achievement = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM achievements WHERE id='{$ownedachievement['achievement_id']}'"));
              echo "<div class=\"Badge\">
                <div class=\"BadgeImage\">
                  <img src=\"/images/Badges/{$achievement['name_file']}.png\" title=\"{$achievement['description']}\" alt=\"{$achievement['name_file']}\"><br>
                  <div class=\"BadgeLabel\"><a href=\"/Badges\">{$achievement['name']}</a>
                </div>
              </div>
              <td><td>";
              $i += 1;

              if ($i >= 3) {
                echo "</div><div class=\"columns\">";
                $i = 0;
              }
            }

            ?>
	</tr>
</tbody></table>

</div>
			</div>
		<div id="UserStatisticsPane">
					<div id="UserStatistics">
						<div id="StatisticsPanel" style="transition: height 0.5s ease-out 0s; overflow: hidden; height: 200px;">
							<div class="Header">
								<h4>Statistics</h4>
								<span class="PanelToggle"></span>
							</div>
							<div style="margin: 10px 10px 150px 10px;" id="Results">
								<div class="Statistic">
									<div class="Label"><acronym title="The number of this user's friends.">Friends</acronym>:</div>
									<div class="Value"><span>0</span></div>
								</div>
																<div class="Statistic">
									<div class="Label"><acronym title="The number of times this user's profile has been viewed.">Profile Views</acronym>:</div>
									<div class="Value"><span>0</span></div>
								</div>
								<div class="Statistic">
									<div class="Label"><acronym title="The number of times this user's place has been visited.">Place Visits</acronym>:</div>
									<div class="Value"><span>0</span></div>
								</div>
								<div class="Statistic">
									<div class="Label"><acronym title="The number of times this user's models have been viewed - unfinished.">Model Views</acronym>:</div>
									<div class="Value"><span>0</span></div>
								</div>
								<div class="Statistic">
									<div class="Label"><acronym title="The number of times this user's character has destroyed another user's character in-game.">Knockouts</acronym>:</div>
									<div class="Value"><span>0</span></div>
								</div>
								<div class="Statistic">
									<div class="Label"><acronym title="The number of times this user's character has been destroyed in-game.">Wipeouts</acronym>:</div>
									<div class="Value"><span>0</span></div>
								</div>
							</div>
						</div>
					</div>
				</div>
</div>
			</div>
		</div>
	</div>
	<style>
	#RightBankTest {
    float: right;
    text-align: center;
    width: 444px;
    margin-bottom: 20px;
}
</style>
	<div id="RightBankTest">
		<div>
			<div id="UserPlacesPane">
				 <p style="padding: 10px 10px 10px 10px;">You don't have any <?=$sitename?> places.</p> 			</div>
			<div id="FriendsPane">
				<div id="Friends">
				    <?php
				    $friendnew = mysqli_query($connect, "SELECT * FROM friends WHERE (`user_from` = {$_USER['id']} AND `arefriends`='1') OR  (`user_to` = {$_USER['id']} AND `arefriends`='1')") or die(mysqli_error($connect));

$friendcountm = mysqli_num_rows($friendnew);
				    
				    ?>
										<h4>My friends <a href="/friends/?of=13">See all <?php echo $friendcountm ; ?></a>
													(<a href="/my/friends/edit">Edit</a>)
						</h4>					
<table cellspacing="0" align="Center" border="0" style="border-collapse:collapse;">
					<tbody><tr><?php
                    $resultsperpage = 3;
                    $check = mysqli_query($connect, "SELECT * FROM friends WHERE (`user_from` = {$_USER['id']} AND `arefriends`='1') OR  (`user_to` = {$_USER['id']} AND `arefriends`='1')");
                    $usercount = mysqli_num_rows($check);

                    $numberofpages = ceil($usercount/$resultsperpage);

                    $page = 1;

                    $thispagefirstresult = ($page-1)*$resultsperpage;

$friendq = mysqli_query($connect, "SELECT * FROM friends WHERE (`user_from` = {$_USER['id']} AND `arefriends`='1') OR  (`user_to` = {$_USER['id']} AND `arefriends`='1') LIMIT ".$thispagefirstresult.",".$resultsperpage) or die(mysqli_error($connect));

$friendnew = mysqli_query($connect, "SELECT * FROM friends WHERE (`user_from` = {$_USER['id']} AND `arefriends`='1') OR  (`user_to` = {$_USER['id']} AND `arefriends`='1')") or die(mysqli_error($connect));

$friendcount = mysqli_num_rows($friendnew);

            if ($friendcount < 1) {
              echo "<p style=\"padding: 10px 10px 10px 10px;\">You don't have any $sitename friends.</p>";
            } else {
              echo "<div class=\"columns\">";
              $total = 0;
              $row = 0;
              
              while ($friend = mysqli_fetch_assoc($friendq)) {
                if ($total <= 5) {


                $friendid = 0;

                if ($friend['user_from'] == $_USER['id']) {
                  $friendid = $friend['user_to'];
                } else {
                  $friendid = $friend['user_from'];
                }

                $friend_online = mysqli_query($connect, "SELECT * FROM users WHERE id='$friendid'") or die(mysqli_error($connect));
                
                $finfo = mysqli_fetch_assoc($friend_online);

                $usr = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='$friendid' LIMIT ".$thispagefirstresult.",".$resultsperpage));
                echo "<td><div class=\"Friend\">
																																<div class=\"Avatar\">
																																		<a title=\"{$usr['username']}\" href=\"/User.php?id=$friendid\" style=\"display:inline-block;max-height:100px;max-width:100px;cursor:pointer;\">
												<img src=\"/images/Avatar.png\" width=\"95\" border=\"0\" alt=\"{$usr['username']}\" blankurl=\"http://t6.roblox.com:80/blank-100x100.gif\">
																																		</a>
																																</div>
																																<div class=\"Summary\">
																																																								<span class=\"OnlineStatus\">
							";													
							$onlinetest = ($finfo['lastseen'] + 300 <= time()) ? "<img src=\"/images/Offline.gif\" style=\"border-width:0px;\">" : "<img src=\"/images/Online.gif\" style=\"border-width:0px;\">";
							echo"$onlinetest</span>
																																																								<span class=\"Name\"><a href=\"/User.php?id=$friendid\">{$usr['username']}</a></span>
																																</div>
																														</div></td>";
                $total++;
                $row++;

                if ($row >= 3) {
                  echo "</div><div class=\"columns\">";
                  $row = 0;
                }
              }}
              echo "</div>";
            }
            ?></tr></tbody></table>

<style>
fix {
    display: table-cell;
    vertical-align: inherit;
}
</style></div>
			</div>
			<div id="FavoritesPane" style="clear: right; margin: 10px 0 0 0; border: solid 1px #000;">
				<div>
	            <style>
	                #FavoritesPane #Favorites h4
	                {
                        background-color: #ccc;
                        border-bottom: solid 1px #000;
                        color: #333;
                        font-family: Comic Sans MS,Verdana,Sans-Serif;
                        margin: 0;
                        text-align: center;
                    }
                    #Favorites .PanelFooter
                    {
					    background-color: #fff;
					    border-top: solid 1px #000;
					    color: #333;
					    font-family: Verdana,Sans-Serif;
					    margin: 0;
					    padding: 3px;
					    text-align: center;
					}
					#UserContainer #AssetsContent .HeaderPager, #UserContainer #FavoritesContent .HeaderPager
					{
					    margin-bottom: 10px;
					}
					#UserContainer #AssetsContent .HeaderPager, #UserContainer #FavoritesContent .HeaderPager, #UserContainer #AssetsContent .FooterPager, #UserContainer #FavoritesContent .FooterPager {
					    margin: 0 12px 0 10px;
					    padding: 2px 0;
					    text-align: center;
					}
                </style>
                <script>
                    function getFavs(type,page)
                    {
                    	if(page == undefined){ page = 1; }
                        $.post("https://error", {uid:5657,type:type,page:page}, function(data)
                        {
                        	$("#FavoritesContent").empty();
                            $("#FavoritesContent").html(data);
                        })
                        .fail(function()
                        {
                            $("#FavoritesContent").html("Failed to get favourites");
                        });
                    }
                    $(function()
                    {
                        $("#FavCategories").on("change", function()
                        {
                            getFavs(this.value);
                        });
                        getFavs(0);
                    });
                </script>
				<div id="Favorites">
					<h4>Favorites</h4>
					<div id="FavoritesContent">This user does not have any favorites for this type</div>
					<div class="PanelFooter">
						Category:&nbsp;
						<select id="FavCategories">
							<option value="7">Heads</option>
							<option value="8">Faces</option>
							<option value="2">T-Shirts</option>
							<option value="5">Shirts</option>
							<option value="6">Pants</option>
							<option value="1">Hats</option>
							<option value="4">Decals</option>
							<option value="3">Models</option>
							<option selected="selected" value="0">Places</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
		<br>
	<div id="FriendRequestsPane">
		<div id="FriendRequests">
			<span id="FriendRequestsHeaderLabel"><h4>My Friend Requests</h4></span>
			<table cellspacing="0" border="0" style="border-collapse:collapse;">
				<tbody><tr>
<?php
        if (mysqli_num_rows($msg) < 1) {
          die ("<p style=\'padding: 10px 10px 10px 10px;\'>You don't have any $sitename Friend Requests.</p>");
        }
        ?>

<?php
    while ($message = mysqli_fetch_assoc($msg)) {
      $userrrrr = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='{$message['user_from']}'"));
      $binner = "";
      $bouter = "";

      echo "<tr>
        <td><img src='/images/Avatar.png' width=\"95\"></td>
        <td>$binner{$userrrrr['username']}$bouter</td>
        <td><button class=\"button is-success\" onclick=\"document.location = '/api/AddFriend.php?id={$message['user_from']}&from_rq_page=true'\">Accept</button> &nbsp;<button class=\"button is-danger\" onclick=\"document.location = '/api/RemoveFriend.php?id={$message['user_from']}&from_rq_page=true'\">Decline</button></td>
      </tr>";
    }
    ?>

				                       								</tr>
			</tbody></table>
		</div>
	</div>
		<div>
	</div>
</div>
<div style="clear:both"></div>
<?php
include '/storage/ssd1/648/16177648/public_html/core/footer.php';
				?>