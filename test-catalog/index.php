<?php
require ("/opt/htdocs/core/header.php");
require ("/opt/htdocs/core/nav.php");
$items_per_row = 4;

$type = $_GET['type'] ?? 'hat';
$sorttype = $_GET['sorttype'] ?? 'recentlyupdated';
$valid_types = array("hat", "tool", "face", "shirt", "pants");
$valid_sorttypes = array("recentlyupdated", "cheapest", "mostexpensive", "collectible", "bestselling");


$type = mysqli_real_escape_string($connect, $type);

if (!in_array($type, $valid_types)) {
  $type = "hat";
}

if (!in_array($sorttype, $valid_sorttypes)) {
  $sorttype = "recentlyupdated";
}

if ($sorttype == "recentlyupdated") {
  $querypart = "SELECT * FROM assets WHERE type='$type' AND (price >= 0 OR is_limited = 1) ORDER BY `time_updated` DESC";
} else if ($sorttype == "cheapest") {
  $querypart = "SELECT * FROM assets WHERE type='$type' AND (price >= 0 OR is_limited = 1) ORDER BY `price` ASC";
} else if ($sorttype == "mostexpensive") {
  $querypart = "SELECT * FROM assets WHERE type='$type' AND (price >= 0 OR is_limited = 1) ORDER BY `price` DESC";
} else if ($sorttype == "collectible") {
  $querypart = "SELECT * FROM assets WHERE type='$type' AND is_limited = 1 ORDER BY `time_updated` DESC";
} else {
  $querypart = "SELECT * FROM assets WHERE type='$type' AND (price >= 0 OR is_limited = 1) ORDER BY `sales` DESC";
}

$totalassetamt = mysqli_num_rows(mysqli_query($connect, "$querypart"));
$itemsperpage = 16;
$pages = ceil($totalassetamt / $itemsperpage);


$page = $_GET['page'] ?? 0;
$page = intval($page);

if ($page < 0) $page = 0;
if ($page > $pages - 1) $page = $pages - 1;

$offset = ($page * $itemsperpage);

if ($offset < 0) $offset = 0;



$assets = mysqli_query($connect, "$querypart LIMIT $itemsperpage OFFSET $offset ") or die(mysqli_error($connect));



$sname = ucfirst($type . "s");

if ($type == "pants") {
  $sname = "Pants";
}

if ($type == "tshirt") {
  $sname = "T-Shirts";
}
?>
<div id="Body">
					
    
    

<div id="CatalogContainer">
    <div id="SearchBar" class="SearchBar">
        <span class="SearchBox"><input name="ctl00$cphRoblox$rbxCatalog$SearchTextBox" type="text" maxlength="100" id="ctl00_cphRoblox_rbxCatalog_SearchTextBox" class="TextBox"/></span>
        <span class="SearchButton"><input type="submit" name="ctl00$cphRoblox$rbxCatalog$SearchButton" value="Search" id="ctl00_cphRoblox_rbxCatalog_SearchButton"/></span>
    </div>
    <div class="DisplayFilters">
	    <h2>Catalog</h2>
	    <div id="BrowseMode">
		    <h4>Browse</h4>
		    <ul>
			    <li><img id="ctl00_cphRoblox_rbxCatalog_BrowseModeFeaturedBullet" class="GamesBullet" src="https://web.archive.org/web/20070914235314im_/http://www.roblox.com/images/games_bullet.png" border="0"/><a id="ctl00_cphRoblox_rbxCatalog_BrowseModeFeaturedSelector" href="Catalog.aspx?m=Featured&amp;c=8&amp;d=All"><b>Featured</b></a></li>
			    <li><a id="ctl00_cphRoblox_rbxCatalog_BrowseModeForSaleSelector" href="Catalog.aspx?m=ForSale&amp;c=8&amp;d=All">For Sale</a></li>
			    <li><a id="ctl00_cphRoblox_rbxCatalog_BrowseModeBestSellingSelector" href="Catalog.aspx?m=BestSelling&amp;c=8&amp;t=PastDay&amp;d=All">Best Selling</a></li>
			    <li><a id="ctl00_cphRoblox_rbxCatalog_BrowseModeRecentlyUpdatedSelector" href="Catalog.aspx?m=RecentlyUpdated&amp;c=8">Recently Updated</a></li>
		    </ul>
	    </div>
	    <div id="Category">
		    <h4>Category</h4>
		    
				    <ul>
			    
				    <li>
					    <img id="ctl00_cphRoblox_rbxCatalog_AssetCategoryRepeater_ctl01_SelectedCategoryBullet" class="GamesBullet" src="https://web.archive.org/web/20070914235314im_/http://www.roblox.com/images/games_bullet.png" border="0"/>
					    <a id="ctl00_cphRoblox_rbxCatalog_AssetCategoryRepeater_ctl01_AssetCategorySelector" href="Catalog.aspx?m=Featured&amp;c=8&amp;t=AllTime&amp;d=All">Hats</a>
				    </li>
			    
				    <li>
					    
					    <a id="ctl00_cphRoblox_rbxCatalog_AssetCategoryRepeater_ctl02_AssetCategorySelector" href="Catalog.aspx?m=Featured&amp;c=2&amp;t=AllTime&amp;d=All">Shirts</a>
				    </li>
			    
				    </ul>
			    
	    </div>
	    <div id="ctl00_cphRoblox_rbxCatalog_CurrencyType">
	        <h4>Currency</h4>
	        <ul>
	            <li><img id="ctl00_cphRoblox_rbxCatalog_CurrencyAllBullet" class="GamesBullet" src="https://web.archive.org/web/20070914235314im_/http://www.roblox.com/images/games_bullet.png" border="0"/><a id="ctl00_cphRoblox_rbxCatalog_CurrencyAllSelector" href="Catalog.aspx?m=Featured&amp;c=8&amp;t=AllTime&amp;d=All"><b>All</b></a></li>
	            <li><a id="ctl00_cphRoblox_rbxCatalog_CurrencyRobuxSelector" href="Catalog.aspx?m=Featured&amp;c=8&amp;t=AllTime&amp;d=Robux">ROBUX</a></li>
	            <li><a id="ctl00_cphRoblox_rbxCatalog_CurrencyTicketsSelector" href="Catalog.aspx?m=Featured&amp;c=8&amp;t=AllTime&amp;d=Tickets">Tickets</a></li>
	        </ul>
	    </div>
	    
    </div>
    <div class="Assets">
        <span id="ctl00_cphRoblox_rbxCatalog_AssetsDisplaySetLabel" class="AssetsDisplaySet">Featured Hats</span>
	    <div id="ctl00_cphRoblox_rbxCatalog_HeaderPagerPanel" class="HeaderPager">
		    <span id="ctl00_cphRoblox_rbxCatalog_HeaderPagerLabel">Page 1 of 4:</span>
		    
		    <a id="ctl00_cphRoblox_rbxCatalog_HeaderPagerHyperLink_Next" href="Catalog.aspx?m=Featured&amp;c=8&amp;t=AllTime&amp;d=All&amp;q=&amp;p=2">Next <span class="NavigationIndicators">&gt;&gt;</span></a>
	    </div>
	    <table id="ctl00_cphRoblox_rbxCatalog_AssetsDataList" cellspacing="0" align="Center" border="0" width="735">
	<tr>
<?php
        $current = 0;
        $i = 0;
        while ($asset = mysqli_fetch_assoc($assets)) {
          $creator = mysqli_fetch_assoc(mysqli_query($connect, "SELECT username FROM users WHERE id='{$asset['creator']}'"));

          $thumburl = "/assets/thumbnails/catalog/". $asset['id'] .".png";


          if ($asset['moderation_status'] == "REJECTED") {
            $thumburl = "/images/notfound.png";
          }

          if ($asset['moderation_status'] == "PENDING") {
            $thumburl = "/images/unavail.png";
          }

          $currency_icon_url = ($asset['currency'] == "Robux") ? "/Note_1.png" : "/Note_1.png";

          $price = "Bux: ". number_format($asset['price']);

          if ($asset['price'] < 0) {
            $price = "<span class=\"\"><b>Not for sale</b></span>";
          }
          $tag = "";

          if ($asset['is_limited'] == 1) {
            $tag .= "<span class=\"tag is-success icon\">
  <i class=\"fas fa-chart-line\"></i>
</span>";
          }

          if ($asset['onsale_until'] != 0) {
            $cl = "link";

            if ($asset['onsale_until'] < time()) {
              $cl = "danger";
            }
            $tag .= "<span class=\"tag is-$cl icon\">
  <i class=\"fas fa-clock\"></i>
</span>";
          }

          echo "<td valign=\"top\">
		        <div class=\"Asset\">
			        <div class=\"AssetThumbnail\">
				        <a id=\"ctl00_cphRoblox_rbxCatalog_AssetsDataList_ctl00_AssetThumbnailHyperLink\" title=\"{$asset['name']}\" href=\"/web/20071229005603/http://www.roblox.com/Item.aspx?ID=1163672\" style=\"display:inline-block;cursor:pointer;\"><img src=\"$thumburl\" border=\"0\" id=\"img\" alt=\"{$asset['name']}\" blankurl=\"http://t6.roblox.com:80/blank-120x120.gif\"/></a>
			        </div>
			        <div class=\"AssetDetails\">
				        <div class=\"AssetName\"><a id=\"ctl00_cphRoblox_rbxCatalog_AssetsDataList_ctl00_AssetNameHyperLink\" href=\"Item.aspx?ID=1163672\">{$asset['name']}</a></div>
				        <div class=\"AssetCreator\"><span class=\"Label\">Creator:</span> <span class=\"Detail\"><a id=\"ctl00_cphRoblox_rbxCatalog_AssetsDataList_ctl00_GameCreatorHyperLink\" href=\"User.aspx?ID=1\">{$creator['username']}</a></span></div>
				        
				        
				        <div id=\"ctl00_cphRoblox_rbxCatalog_AssetsDataList_ctl00_Div3\" class=\"AssetPrice\"><span class=\"PriceInRobux\">$price</span></div>
			        </div>
			    </div>
		    </td>";
          }
        //}
        ?>
	</tr>
</table>
        <div id="ctl00_cphRoblox_rbxCatalog_FooterPagerPanel" class="HeaderPager">
            <span id="ctl00_cphRoblox_rbxCatalog_FooterPagerLabel">Page 1 of 4:</span>
            
            <a id="ctl00_cphRoblox_rbxCatalog_FooterPagerHyperLink_Next" href="Catalog.aspx?m=Featured&amp;c=8&amp;t=AllTime&amp;d=All&amp;q=&amp;p=2">Next <span class="NavigationIndicators">&gt;&gt;</span></a>
        </div>
    </div>
    <div style="clear: both;"/>
</div>

				</div>