<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

include ("/storage/ssd1/648/16177648/public_html/core/header.php");
include ("/storage/ssd1/648/16177648/public_html/core/nav.php");

if (!$isloggedin) {
    header("Location: /Login/");
}

if (!isset($_GET['wtype'])) {
	$_GET['wtype'] = "hat";
}

$wardrobe_type = mysqli_real_escape_string($connect, $_GET['wtype']);

$querytype = "hat";
$querytype = strtolower($wardrobe_type);

$items_per_row = 4;
?>
<div id="Body">
    <style>

	.clothe
	{
		width:110px;
		/*height: 200px;*/
		margin: 10px;
		text-align: left;
		
		vertical-align: top;
		display: inline-block;
		display: -moz-inline-stack;
		*display: inline;
	}
	.clothe .name {
		font-weight: bold;
	}
	.nocl
	{
		font-family: Verdana;
		font-weight: bold;
		text-align: center;
	}
	.img{
		border:none;
		height: 100%;
	}
	.imgc
	{
		border:1px solid black;
		width: 110px;
		height: 110px;
		text-align: center;
		padding: 10px;
		position: relative;
	}
	.fixed
	{
		position:absolute;
		right:0;
		top:0;
		background-color: #EEEEEE;
		border: 1px solid #555555;
		color: blue;
		font-family: Verdana;
		font-size: 10px;
		font-weight: lighter;
	}
	#left{
		width: 69%;
		float: left;
	}
	#right{
		width: 30%;
		float: right;
	}
	#Body table
	{
		border: 1px black solid;
	}
	.tablehead
	{
		font-size:16px; font-weight: bold; border-bottom:black 1px solid; width: 100%; background-color: #CCCCCC; color: #222222;
	}
	.tablebody
	{
		font-weight: lighter; background-color: transparent;font-family: Verdana;
	}
	.margin{
		margin:10px;
	}
	.clickable, .clickable3, .clickable2
	{
		border: none;
		margin:1px;
	}
	.clickable{
		width:50px;
		height: 50px;
	}
	.clickablesm{
		width:40px;
		height:40px;
		margin:5px;
	}
	.clickable2{
		width:47px;
		height: 100px;
	}
	.clickable3{
		width:100px;
		height: 100px;
	}
	.nonsbtn
	{
		font-weight:normal;
	}
	#col{
		position: fixed;
		top: 50%;
		left: 50%;
		margin-top: -105px;
		margin-left: -205px;
		width: 410px;
		height: 210px;
		z-index: 498;
		background-color: white;
		text-align: center;
		vertical-align: center;
	}
	.tablebody a {
	    color:blue;
	}
	.tablebody a:hover {
	    cursor:pointer;
	}
#left {
    width: 69%;
    float: left;
}
.clickable2 {
    width: 47px;
    height: 100px;
}
.clickable3 {
    width: 100px;
    height: 100px;
}
#right {
    width: 30%;
    float: right;
}
.tablebody {
    font-weight: lighter;
    background-color: transparent;
    font-family: Verdana;
}
.clickable {
    width: 50px;
    height: 50px;
}
.clickable, .clickable3, .clickable2 {
    border: none;
    margin: 1px;
}
#Body table {
    border: 1px black solid;
}
.tablehead {
    font-size: 16px;
    font-weight: bold;
    border-bottom: black 1px solid;
    width: 100%;
    background-color: #CCCCCC;
    color: #222222;
}
</style>
<div id="left">
	<table cellspacing="0px" width="100%" style="margin-bottom:10px;">
		<tbody><tr>
		    <th class="tablehead">My Wardrobe</th>
		</tr>
		<tr>
		    <?php
		    echo"
		    <td class=\"tablebody\" style=\"font-size:12px; text-align: center; border-bottom: 1px solid black;\">
		    ";
		    if($querytype == "t-shirt") {
		    echo"<a id=\"btn2\" href=\"../character/?wtype=t-shirt\" style=\"font-weight: bold;\">T-Shirts</a>";
		    }else{
		    echo"<a id=\"btn2\" href=\"../character/?wtype=t-shirt\">T-Shirts</a>";
		    }
		    if($querytype == "shirt") {
		    echo" 		        | 		        <a id=\"btn5\" href=\"../character/?wtype=shirt\" style=\"font-weight: bold;\">Shirts</a>";
		    }else{
		    echo" 		        | 		        <a id=\"btn2\" href=\"../character/?wtype=shirt\">Shirts</a>";
		    }
		    if($querytype == "pants") {
		    echo" 		        | 		        <a id=\"btn5\" href=\"../character/?wtype=pants\" style=\"font-weight: bold;\">Pants</a>";
		    }else{
		    echo" 		        | 		        <a id=\"btn2\" href=\"../character/?wtype=pants\">Pants</a>";
		    }
		    if($querytype == "hat") {
		    echo" 		        | 		        <a id=\"btn5\" href=\"../character/?wtype=hat\" style=\"font-weight: bold;\">Hats</a>";
		    }else{
		    echo" 		        | 		        <a id=\"btn2\" href=\"../character/?wtype=hat\">Hats</a>";
		    }
		    echo"
		    <br><a href=\"/Catalog/\">Shop</a>
		    </td>";
		    ?>
		</tr>
		<tr>
		    <td class="tablebody">
		        <div id="wardrobe" style="padding-left:13px;">
							    <?php
							    $itemsq = mysqli_query($connect, "SELECT * FROM owneditems WHERE userid='$CURRENT_USER_ID' AND type='$querytype'") or die(mysqli_error($connect));
							                    while($row = mysqli_fetch_assoc($itemsq)) {
							    $itemq = $connect->query("SELECT * FROM catalog WHERE id='{$row['assetid']}'") or die(mysqli_error($connect));

                                $item = mysqli_fetch_assoc($itemq);
                                
                                $thumburl = "/assets/thumbnails/catalog/small/". $row['assetid'] .".png";
                                
							    $iteml = $connect->query("SELECT * FROM users WHERE id='{$item['creator']}'") or die(mysqli_error($connect));

                                $user = mysqli_fetch_assoc($iteml);
							    



							    $id = htmlspecialchars($row['assetid']);
							    $name = htmlspecialchars($item['name']);
							    $creator = htmlspecialchars($user['username']);
							    

									echo"<div class='clothe' style='font-size:10.85px; display:inline-block; *display:inline; margin:5px; display: inline-block; display: -moz-inline-stack; *display: inline; vertial-align:top;'>
													<div id='$name' class='imgc' style='cursor:pointer;'><img class='img' src='$thumburl'>
														<div class='fixed'><a>[ wear ]</a></div>
													</div>
													<a class='name' href='/Catalog/item.php?id=$id'>$name</a><br>
													Type: Hat<br>
													Creator: <a href='/user/?id={$item['creator']}'>$creator</a>
												</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
									

							                    }
							                    ?>
<?php $checkt = mysqli_query($connect, "SELECT * FROM owneditems WHERE userid='$CURRENT_USER_ID' AND type='$querytype'") or die(mysqli_error($connect));
if(mysqli_num_rows($checkt) == 0) {
if($querytype == "pants") {
echo"<tr>
		    <td class='tablebody'>
		        <div id='wardrobe' style='padding-left:13px;'>No {$querytype} have been found.</div>
				<div style='clear:both;'></div>
			</td>
		</tr>";
}else{
echo"<tr>
		    <td class='tablebody'>
		        <div id='wardrobe' style='padding-left:13px;'>No {$querytype}s have been found.</div>
				<div style='clear:both;'></div>
			</td>
		</tr>";
}
}else{
echo"<br>
<div class='tablebody' style='font-size:12px; text-align: center; border-top: 1px solid black; padding: 5px 0;'>
<a style='color:black;font-weight:bold;' disabled=''>First</a>
<a style='color:black;font-weight:bold;' disabled=''>Previous</a>
<a style='color:black;font-weight:bold;' disabled=''>Next</a>
<a style='color:black;font-weight:bold;' disabled=''>Last</a>
<div>";
																	}
																	?>
																						</div>
				<div style="clear:both;"></div>
			</td>
		</tr>
	</tbody></table><div class="seperator"></div>
	<table cellspacing="0px" width="100%">
		<tbody><tr>
		    <th class="tablehead">Currently Wearing</th>
		</tr>
		<?php
		//here lol
		?>
	</tbody></table>
</div>
    <div id="right">
                    <table cellspacing="0px" width="100%">
                        <tbody>
                            <tr><th class="tablehead">My Character</th></tr>
                            <tr>
                                <th class="tablebody">
                                    <img width="180" height="220" class="margin" id="limg" src="https://web.archive.org/web/20110711055128im_/http://t7.roblox.com/Avatar-180x220-a4c138a9343e14c5357d62566d3c9c1b.Png">
                                    <img class="margin" id="uimg" src="">
                                    <form method="post">
                                        Something wrong with your avatar? Click <a href="#">here</a> to fix the problem!
                                    </form>
                                </th>
                            </tr>
                        </tbody>
                    </table>
</div>