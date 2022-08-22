<?php
require ("/storage/ssd1/648/16177648/public_html/core/header.php");
require ("/storage/ssd1/648/16177648/public_html/core/nav.php");

if (!$isloggedin) {
  die("<center>
    <h1>Games are only available to admins for testing.</h1>
  </center>
");
}

if ($_USER['permission_level'] != "ADMINISTRATOR") {
  die("<center>
    <h1>Games are only available to admins for testing.</h1>
  </center>
");
}

$gamesq = mysqli_query($connect, "SELECT * FROM games WHERE active='1' ORDER BY playing DESC, id DESC") or die(mysqli_error($connect));
$items_per_row = 3;
?>
<div id="Body">
					
    
    <div id="GamesContainer">
        
<div id="ctl00_cphRoblox_rbxGames_GamesContainerPanel">
	
    <div class="DisplayFilters">
	    <h2>Games&nbsp;<a id="ctl00_cphRoblox_rbxGames_hlNewsFeed" href="/Games/?feed=rss"><img src="/images/feed-icons/feed-icon-14x14.png" border="0"/></a></h2>
	    <div id="BrowseMode">
		    <h4>Browse</h4>
		    <ul>
			    <li><img id="ctl00_cphRoblox_rbxGames_MostPopularBullet" class="GamesBullet" src="/images/games_bullet.png" border="0"/><a id="ctl00_cphRoblox_rbxGames_hlMostPopular" href="Games.aspx?m=MostPopular&amp;t=Now"><b>Most Popular</b></a></li>
			    <li><a id="ctl00_cphRoblox_rbxGames_hlRecentlyUpdated" href="/Games/?m=RecentlyUpdated">Recently Updated</a></li>
			    <li><a id="ctl00_cphRoblox_rbxGames_hlFeatured" href="/User.php?id=1">Featured Games</a></li>
		    </ul>
	    </div>
	    <div id="ctl00_cphRoblox_rbxGames_pTimespan">
		
		    <div id="Timespan">
			    <h4>Time</h4>
			    <ul>
				    <li><img id="ctl00_cphRoblox_rbxGames_TimespanNowBullet" class="GamesBullet" src="/images/games_bullet.png" border="0"/><a id="ctl00_cphRoblox_rbxGames_hlTimespanNow" href="Games.aspx?m=MostPopular&amp;t=Now"><b>Now</b></a></li>
				    <li><a id="ctl00_cphRoblox_rbxGames_hlTimespanPastDay" href="Games.aspx?m=MostPopular&amp;t=PastDay">Past Day</a></li>
				    <li><a id="ctl00_cphRoblox_rbxGames_hlTimespanPastWeek" href="Games.aspx?m=MostPopular&amp;t=PastWeek">Past Week</a></li>
				    <li><a id="ctl00_cphRoblox_rbxGames_hlTimespanPastMonth" href="Games.aspx?m=MostPopular&amp;t=PastMonth">Past Month</a></li>
				    <li><a id="ctl00_cphRoblox_rbxGames_hlTimespanAllTime" href="Games.aspx?m=MostPopular&amp;t=AllTime">All-time</a></li>
			    </ul>
		    </div>
	    
	</div>
    </div>
    
            <div id="Games">
                <span id="ctl00_cphRoblox_rbxGames_lGamesDisplaySet" class="GamesDisplaySet">Most Popular (Now)</span>
			    <div id="ctl00_cphRoblox_rbxGames_HeaderPagerPanel" class="HeaderPager">
				    <span id="ctl00_cphRoblox_rbxGames_HeaderPagerLabel">Page 1 of 11:</span>
				    
				    <a id="ctl00_cphRoblox_rbxGames_hlHeaderPager_Next" href="Games.aspx?m=MostPopular&amp;t=Now&amp;p=2">Next <span class="NavigationIndicators">&gt;&gt;</span></a>
				</div>
			    <table id="ctl00_cphRoblox_rbxGames_dlGames" cellspacing="0" align="Center" border="0" width="550">
		<tr>
			<?php
        $current = 0;
        $i = 0;
        while ($game = mysqli_fetch_assoc($gamesq)) {
          $creator = mysqli_fetch_assoc(mysqli_query($connect, "SELECT username FROM users WHERE id='{$game['creator_id']}'"));

          $thumburl = "/images/unavail_game.png";

          echo "<td class=\"Game\" valign=\"top\">
				    <div style=\"padding-bottom:5px\">
					    <div class=\"GameThumbnail\">
						    <a id=\"ctl00_cphRoblox_rbxGames_dlGames_ctl00_ciGame\" title=\"{$game['name']}\" href=\"/Games/place.php?id={$game['id']}\" style=\"display:inline-block;cursor:pointer;\"><img src=\"/images/thumbdefaultRBLXHUB2.jpg\" border=\"0\" id=\"img\" alt=\"{$game['name']}\"/></a>
					    </div>
					    <div class=\"GameDetails\">
						    <div class=\"GameName\"><a id=\"ctl00_cphRoblox_rbxGames_dlGames_ctl00_hlGameName\" href=\"/Games/place.php?id={$game['id']}\">{$game['name']}</a></div>
						    <div class=\"GameLastUpdate\"><span class=\"Label\">Updated:</span> <span class=\"Detail\">1 hour ago</span></div>
						    <div class=\"GameCreator\"><span class=\"Label\">Creator:</span> <span class=\"Detail\"><a id=\"ctl00_cphRoblox_rbxGames_dlGames_ctl00_hlGameCreator\" href=\"/User.php?id={$game['creator_id']}\">{$creator['username']}</a></span></div>
						    <div class=\"GamePlays\"><span class=\"Label\">Played:</span> <span class=\"Detail\">0 times today</span></div>
						    <div id=\"ctl00_cphRoblox_rbxGames_dlGames_ctl00_pGameCurrentPlayers\">
				
							    <div class=\"GameCurrentPlayers\"><span class=\"DetailHighlighted\">{$game['playing']} players online</span></div>
						    
			</div>
					    </div>
					</div>
				    </td>";
          $i++;
          $current++;

          if ($current >= $items_per_row) {
            echo "</td> <td class='Game'>";
            $current = 0;
          }
        }
        if ($current != 0) {
          for ($a = 0; $a < ($items_per_row - $current); $a++) {
            echo "<valign=\"top\"></div>";
          }
        }
        ?>
		</tr>
	</table>
                <div id="ctl00_cphRoblox_rbxGames_FooterPagerPanel" class="HeaderPager">
                    <span id="ctl00_cphRoblox_rbxGames_FooterPagerLabel">Page 1 of 11:</span>
                    
                    <a id="ctl00_cphRoblox_rbxGames_hlFooterPager_Next" href="Games.aspx?m=MostPopular&amp;t=Now&amp;p=2">Next <span class="NavigationIndicators">&gt;&gt;</span></a>
                </div>
            </div>
        

</div>
        
<div class="Ads_WideSkyscraper">
    <script type="text/javascript"><!--
        google_ad_client = "pub-2247123265392502";
        google_ad_width = 160;
        google_ad_height = 600;
        google_ad_format = "160x600_as";
        google_ad_type = "text_image";
        google_ad_channel = "";
        //-->
    </script>
    <script type="text/javascript" src="https://web.archive.org/web/20071229005629js_/http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</div>
        <div style="clear: both;">
        </div>
    </div>

				</div>
				<?php
require ("/storage/ssd1/648/16177648/public_html/core/footer.php");
?>