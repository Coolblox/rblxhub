<?php
include "../core/header.php";
include "../core/nav.php";
include "../core/conn.php";
$itemid = $_GET['id'] ?? 0;
$itemid = intval($itemid);

if(isset($_POST['buy_new'])){
// Do not edit that, please   -Codex
$itemcheck = mysqli_query($connect, "SELECT * FROM owneditems WHERE assetid='$itemid' AND userid='{$_USER['id']}'") or die(mysqli_error($connect));
$CheckEnd = mysqli_num_rows($itemcheck);
if ($CheckEnd > 0) {
 $owned = 1;
}
else {
 $owned = 0;
}

if($owned == 1) {

}else{
if (mysqli_connect_errno())
{
    printf("Connect failed: %s\n", mysqli_connect_error());
}

$itemq = mysqli_query($connect, "SELECT * FROM catalog WHERE id='$itemid'") or die(mysqli_error($connect));

$item = mysqli_fetch_assoc($itemq);

$userid = $_USER['id'];
$itemp = $item['price'];
if($item['currency'] !== "Robux") {
mysqli_query($connect, "UPDATE users SET tickets = '{$_USER['tickets']}' - '{$item['price']}' WHERE id = '{$_USER['id']}'");
}else{
mysqli_query($connect, "UPDATE users SET robux = '{$_USER['robux']}' - '{$item['price']}' WHERE id = '{$_USER['id']}'");
}
$itemid = $item['id'];
$itemp = $item['price'];
$userid = $_USER['id'];
$type = $item['type'];
$serial = "0";
$sql="INSERT INTO owneditems (assetid, userid, type, serial)

VALUES

('$itemid', '$userid', '$type', '$serial')";

if (!$connect->query($sql))
{
  printf("Error: %s\n", $connect->error);
}

$connect->close();
header("Location: /Catalog/item.php?id=$itemid");
}
}

//$itemq = mysqli_query($connect, "SELECT * FROM catalog WHERE id='$itemid'") or die(mysqli_error($connect));

//if (mysqli_num_rows($itemq) < 0) {
  //Item doesn't exist.

 // header("Location: /Catalog/");
  //die("<script>document.location = \"/Catalog/\"</script>");
//}

$itemq = $connect->query("SELECT * FROM catalog WHERE id='$itemid'") or die(mysqli_error($connect));

$item = mysqli_fetch_assoc($itemq);

$creator = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='{$item['creator']}'"));

$thumburlf = "/assets/thumbnails/catalog/big/". $item['id'] .".png";

$canbuy = true;

if ($isloggedin) {
  if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owneditems WHERE userid='{$_USER['id']}' AND assetid='{$item['id']}'")) > 0) {
      $canbuy = false;
  }
} else {
  $canbuy = false;
}
$soldout = false;

if (boolval($item['is_limited'])) {
  if ($item['sales'] >= $item['total_stock']) {
    $canbuy = false;
    $soldout = true;
  }
}

if ($item['onsale_until'] < time() && $item['onsale_until'] != 0) {
  $canbuy = false;
  $soldout = true;
}

if ($item['moderation_status'] == "REJECTED") {
  $thumburl = "/images/notfound.png";
}

if ($item['moderation_status'] == "PENDING") {
  $thumburl = "/images/unavail.png";
}



$currency_icon_url = ($item['currency'] == "Robux") ? "https://social-paradise.com/images/icons/brick.png" : "https://social-paradise.com/images/icons/stud.png";

$isitemowned = false;

if ($isloggedin) {
  $isitemowned = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM owneditems WHERE userid='{$_USER['id']}' AND assetid='{$item['id']}'")) > 0;
}



$commentq = mysqli_query($connect, "SELECT * FROM comments WHERE assetid='{$item['id']}' ORDER BY id DESC") or die(mysqli_error($connect));

if (isset($_POST['ok'])) {
  $comment = $_POST['comment'];

  $comment = htmlspecialchars(mysqli_real_escape_string($connect, $comment));

  $newcomment = $comment;

  $p = FilterString($newcomment);
  while (FilterString($newcomment) != "OK") {
    $profanity = FilterString($newcomment);
    $repl = str_repeat("*", strlen($profanity));
    $newcomment = str_replace($profanity, $repl, $newcomment);
  }

$time_rn = time();

  mysqli_query($connect, "INSERT INTO `comments`
    (`id`, `userid`, `assetid`, `content`, `time_posted`) VALUES
    (NULL, '{$_USER['id']}','{$item['id']}','$newcomment','$time_rn')")
  or die(mysqli_error($connect));
  die("<script>document.location = document.location</script>");
}

$commentamt = mysqli_num_rows($commentq);

$ownedamt = 0;
$isonsale = false;

if ($item['is_limited']) {
if ((mysqli_num_rows(mysqli_query($connect, "SELECT * FROM on_sale_limiteds WHERE item_id='$itemid' ORDER BY price ASC")) != 0) && ($item['sales'] >= $item['total_stock'])) {
  $isonsale = true;
  $best_lim = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM on_sale_limiteds WHERE item_id='$itemid' ORDER BY price ASC"));
}}

if ($isloggedin) {
  $ownedamt = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `owneditems` WHERE `userid`='{$_USER['id']}' AND `assetid`='$itemid'"));
  if ($item['is_limited']) {
  if ($item['sales'] >= $item['total_stock']) {
    $canbuy = $isonsale;
  }}

}

if ($isonsale) {
  $currency_icon_url = "https://social-paradise.com/images/icons/brick.png";
  $item['price'] = $best_lim['price'];
}

if ($item['is_limited'] == 1) {
  $range = $_GET['range'] ?? 365*10;
  $range = intval($range);

  $min = floor((time() / 86400) - $range);

  $dataq = mysqli_query($connect, "SELECT * FROM `limited_sales` WHERE `item_id`='$itemid'") or die(mysqli_error($connect));

  if (mysqli_num_rows($dataq) == 0) {
    $chartData = "{x:0,y:0}";
  } else {
    $avgs = array();


    $first = true;
    while ($data = mysqli_fetch_assoc($dataq)) {
      if (!isset($avgs[$data['time']])) {
        $avgs[$data['time']] = $data['price'];
      } else {
        $newavg = ceil(($avgs[$data['time']] + $data['price']) / 2);
        $avgs[$data['time']] = $newavg;
      }
    }
    $chartData = "";
    $x = 0;
    foreach ($avgs as $key => $value) {
      $chartData .= "{x:$x,y:$value},";
      $x++;
    }

    $chartData = substr_replace($chartData ,"", -1);
  }

  $owners = mysqli_query($connect, "SELECT * FROM owneditems WHERE assetid='$itemid' ORDER BY serial ASC") or die(mysqli_error($connect));


}


?>
  <div id="Body">
    <style>
    #Item {
    font-family: Verdana, Sans-Serif;
    padding: 10px;
}
#ItemContainer {
    background-color: #eee;
    border: solid 1px #555;
    color: #555;
    margin: 0 auto;
    width: 620px;
}
#Actions {
    background-color: #fff;
    border-bottom: dashed 1px #555;
    border-left: dashed 1px #555;
    border-right: dashed 1px #555;
    clear: left;
    float: left;
    padding: 5px;
    text-align: center;
    min-width: 0;
    position: relative;
}
    </style>
	<div id="ItemContainer" style="float:left;width: 720px;">
	<h2><?php echo $item['name'] ?></h2>
	<div id="Item">
		<div id="Thumbnail">
			<a title="<?php echo $item['name'] ?>" style="display:inline-block;height:250px;width:250px;"><img src="<?php echo $thumburlf ?>" border="0" id="img" alt="<?php echo $item['name'] ?>" style="display:inline-block;height:250px;width:250px;"></a>
		</div>
		<div id="Summary">
			<h3><?=$sitename?> <?php echo ucfirst($item['type']) ?></h3>
<?php
if($item['currency'] == "Robux") {
echo'						<div id="RobuxPurchase">
				<div id="PriceInRobux">';
}else{
echo'						<div id="TicketsPurchase">
				<div id="PriceInTickets">';
}

if($item['currency'] == "Robux") {
echo"B$";
}else{
echo"Tix";
} ?>: <?php echo $item['price']; ?></div>
<?php
// Do not edit that, please   -Codex
$itemcheck = mysqli_query($connect, "SELECT * FROM owneditems WHERE assetid='$itemid' AND userid='{$_USER['id']}'") or die(mysqli_error($connect));
$CheckEnd = mysqli_num_rows($itemcheck);
if ($CheckEnd > 0) {
 $ownede = 1;
}
else {
 $ownede = 0;
}

if($ownede == 1) {
if($item['currency'] == "Robux") {
echo"
<div id='BuyWithRobux'>
<a class='Button'>You bought it!</a>";
}else{
echo"
<div id='BuyWithTickets'>
<a class='Button'>You bought it!</a>";
}
}else{
    if($item['currency'] == "Robux") {
echo"
<div id='BuyWithRobux'>
<a onclick=';showPurchaseDiag(0);' class='Button'>Buy with B$</a>";
}else{
echo"
<div id='BuyWithTickets'>
<a onclick=';showPurchaseDiag(0);' class='Button'>Buy with Tix</a>";
}
}
?>
				</div>
			</div>			<br><br>
						<div id="Creator"><br><a href="/user/?id=13"><img src="/images/Avatar.png" frameborder="0" scrolling="no" width="100"></iframe></a><br><span style="color:#555;">Creator: </span><a href="/User.php?id=<?php echo $creator['id'] ?>"><?php echo $creator['username'] ?></a></div>
			<div id="LastUpdate">Updated: <?php echo $item['updated'] ?></div>
			<div id="Favourites">Favorited: 0 times</div>
						<div>
				<div id="DescriptionLabel">Description:</div>
				<div id="Description"><?php echo $item['description'] ?></div>
			</div>
						<p>
				</p><div class="ReportAbusePanel">
					<span class="AbuseIcon"><a><img src="../images/abuse.gif" alt="Report Abuse" style="border-width:0px;"></a></span>
					<span class="AbuseButton"><a>Report Abuse</a></span>
				</div>
			<p></p>
		</div>
		<div id="Actions" style="width:240px;">
            	        <a href="#">Favorite</a>
	                            </div><div style="clear: both;"></div>

	</div>
</div>
<div style="clear:both;"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
	var currency;
	var suffTix = true;
	var suffBux = true;
	function showPurchaseDiag(currencyA) {
		$("#VerifyPurchaseTix").hide();
		$("#VerifyPurchaseBux").hide();
		$("#VerifyPurchaseTixIn").hide();
		$("#VerifyPurchaseBuxIn").hide();
		$("#ProcessPurchase").hide();
		$("#PurchaseMessage").hide();
		currency = currencyA
		$("#itemPurchaseFade").show();
		if(currency == 0) {
			if (suffTix) {
				$("#VerifyPurchaseTix").show();
			} else {
				$("#VerifyPurchaseTixIn").show();
			}
		} else {
			if (suffBux) {
				$("#VerifyPurchaseBux").show();
			} else {
				$("#VerifyPurchaseBuxIn").show();
			}
		}
	}
</script>
<?php
if($item['currency'] == "Robux") {
echo"
<div id='itemPurchaseFade' style='position: fixed; z-index: 1; left: 0px; top: 0px; width: 100%; height: 100%; overflow: auto; background-color: rgba(100, 100, 100, 0.25); display: none;'>
	<div id='itemPurchase' class='anim' style='max-width: 325px; position: absolute; top: 50%; left: 50%; transform: translateX(-50%) translateY(-50%);'>
		<div style='background-color: #FFFFE0; border:3px solid gray; box-shadow: black 5px 5px;'>";
if($_USER['robux'] >= $item['price']) {
        echo "<div id='VerifyPurchaseRobux' style='margin: 1.5em; display: block;'>
				<h3>Purchase Item:</h3><br>
				<p>Would you like to purchase Hat {$item['name']} from {$creator['username']} for {$item['price']}?</p>
				<p>Your balance Robux: {$_USER['robux']}.</p>
				<br><form method='POST' action=''>
				<input type='submit' value='Buy Now!' name='buy_new' onclick='getHat()' class='MediumButton' style='width:100%;'></form>
				<br>
				<input type='submit' name='oof' value='Cancel' onclick='$(&#39;#itemPurchaseFade&#39;).hide();' class='MediumButton' style='width:100%;'>
			</div>";
        }
        else{
        echo "<div id='VerifyPurchaseTix' style='margin: 1.5em; display:none;'>
				<h3>Insufficient Funds</h3>
				<p>You need more Robux to purchase this item.</p>
				<p><input type='submit' name='oof' value='Cancel' onclick='$(&#39;#itemPurchaseFade&#39;).hide();' class='MediumButton' style='width:100%;'></p>
			</div>";
        }
}else{
echo"
<div id='itemPurchaseFade' style='position: fixed; z-index: 1; left: 0px; top: 0px; width: 100%; height: 100%; overflow: auto; background-color: rgba(100, 100, 100, 0.25); display: none;'>
	<div id='itemPurchase' class='anim' style='max-width: 325px; position: absolute; top: 50%; left: 50%; transform: translateX(-50%) translateY(-50%);'>
		<div style='background-color: #FFFFE0; border:3px solid gray; box-shadow: black 5px 5px;'>";
if($_USER['tickets'] >= $item['price']) {
        echo "<div id='VerifyPurchaseTix' style='margin: 1.5em; display: block;'>
				<h3>Purchase Item:</h3><br>
				<p>Would you like to purchase Hat {$item['name']} from {$creator['username']} for {$item['price']}?</p>
				<p>Your balance Tickets: {$_USER['tickets']}.</p>
				<br><form method='POST' action=''>
				<input type='submit' value='Buy Now!' name='buy_new' onclick='getHat()' class='MediumButton' style='width:100%;'></form>
				<br>
				<input type='submit' name='oof' value='Cancel' onclick='$(&#39;#itemPurchaseFade&#39;).hide();' class='MediumButton' style='width:100%;'>
			</div>";
        }
        else{
        echo "<div id='VerifyPurchaseTix' style='margin: 1.5em; display:none;'>
				<h3>Insufficient Funds</h3>
				<p>You need more Tickets to purchase this item.</p>
				<p><input type='submit' name='oof' value='Cancel' onclick='$(&#39;#itemPurchaseFade&#39;).hide();' class='MediumButton' style='width:100%;'></p>
			</div>";
        }
}
?>
</div>
<div style="clear:both"></div>
				<?php
include '/storage/ssd1/648/16177648/public_html/core/footer.php';
				?>