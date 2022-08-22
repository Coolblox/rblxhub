<?php
require ("/storage/ssd1/648/16177648/public_html/core/header.php");
require ("/storage/ssd1/648/16177648/public_html/core/nav.php");

$searchusername = $_GET['q'] ?? "";
$searchusername = mysqli_real_escape_string($connect, $searchusername);

$tuserq = mysqli_query($connect, "SELECT * FROM users WHERE username LIKE '%$searchusername%' ORDER BY lastseen DESC");
$usercount = mysqli_num_rows($tuserq);
$usersperpage = 10;
$pages = ceil($usercount / $usersperpage);
$page = $_GET['page'] ?? 1;
$page = intval($page);

if ($page < 1) {
  $page = 1;
}

if ($page >= $pages) {
  $page = $pages;
}

$offset = ($page * $usersperpage) - $usersperpage;

if ($offset < 1) {
  $offset = 0;
}
$userq = mysqli_query($connect, "SELECT * FROM users  WHERE username LIKE '%$searchusername%' ORDER BY lastseen DESC LIMIT $usersperpage OFFSET $offset") or die(mysqli_error($connect));
?>
<div id="Body">
					
    
                    <div id="ctl00_cphRoblox_Panel1">
                        <div id="BrowseContainer" style="text-align:center">
                                    <div>
   <table class="Grid" cellspacing="0" cellpadding="4" border="0" style="border-collapse:collapse;">
      <tbody>
        <tr class="GridHeader">
                    <th scope="col">Avatar</th>
          <th scope="col">Name</th>
          <th scope="col">Status</th>
          <th scope="col">Location / Last Seen</th>
      	          </tr>
                <?php
                    $resultsperpage = 10;
                    $check = mysqli_query($connect, "SELECT * FROM users");
                    $usercount = mysqli_num_rows($check);

                    $numberofpages = ceil($usercount/$resultsperpage);

                    if(!isset($_GET['page'])) {
                        $page = 1;
                    }else{
                        $page = $_GET['page'];
                    }

                    $thispagefirstresult = ($page-1)*$resultsperpage;
                    
                    $searchusername = $_GET['q'] ?? "";
$searchusername = mysqli_real_escape_string($connect, $searchusername);

                    $check = mysqli_query($connect, "SELECT * FROM users WHERE username LIKE '%$searchusername%' ORDER BY lastseen DESC LIMIT ".$thispagefirstresult.",".$resultsperpage);

                    while($row = mysqli_fetch_assoc($check)) {

    $id = htmlspecialchars($row['id']);
    $name = htmlspecialchars($row['username']);
		$descriptionn = htmlspecialchars($row['description']);

        echo "
		<tr class='GridItem'>
    <td>
    <img src='https://web.archive.org/web/20110711055128im_/http://t7.roblox.com/Avatar-180x220-a4c138a9343e14c5357d62566d3c9c1b.Png' width='60'>
    </td>
    <td href='/User.php?id=$id' style='word-break: break-all;'>
    <a href='/User.php?id=$id'>$name</a><br>
		<span>$descriptionn</span>
    </td>
    "; 
      $onlinetext = ($row['lastseen'] + 300 >= time()) ? "<span class=\"UserOnlineStatus\">Online</span>" : "<span class=\"UserOfflineStatus\">Offline</span>";
echo"
    <td><span>$onlinetext";
    echo"</span><br></td>
    <td><span>Website</span></td>
    </tr>";

    $_GET['username'] = $username;
                    }


                        echo "
                        <tr class='GridPager'>
                            <td colspan='4'>
                                <table border='0'>
                                    <tbody>
                        ";
                     
                    if($page <= $page) {  
                    $pagefix = $page + 9;
                    }
                    if($pagefix > $numberofpages) {
                    $pagefix = $numberofpages;
                    }
                    $page2 = $page - 1;
                    $page3 = $page - 2;
                    $page4 = $page - 3;
                    $page5 = $page - 4;
                    $page6 = $page - 5;
                    
                    
                    if($page == 1 OR $page == 2 OR $page == 3 OR $page == 4 OR $page == 5) {
                    }else{
                    echo"<td>
                            <a href='/users/?page=".$page6."'>".$page6." </a>
                        </td>
                    <td>
                            <a href='/users/?page=".$page5."'>".$page5." </a>
                        </td>
                    <td>
                            <a href='/users/?page=".$page4."'>".$page4." </a>
                        </td>
                    <td>
                            <a href='/users/?page=".$page3."'>".$page3." </a>
                        </td>
                    <td>
                            <a href='/users/?page=".$page2."'>".$page2." </a>
                        </td>
                    ";
                    }
                    
                    $pager = $page - 1;
                    $pager1 = $page - 2;
                    $pager2 = $page - 3;
                    $pager3 = $page - 4;
                    if($page == 5) {
                    echo"<td>
                            <a href='/users/?page=".$pager3."'>".$pager3." </a>
                        </td>
                    <td>
                            <a href='/users/?page=".$pager2."'>".$pager2." </a>
                        </td>
                    <td>
                            <a href='/users/?page=".$pager1."'>".$pager1." </a>
                        </td>
                    <td>
                            <a href='/users/?page=".$pager."'>".$pager." </a>
                        </td>
                    ";
                    }else{
                    }
                    
                    $pagej = $page - 1;
                    $pagej1 = $page - 2;
                    $pagej2 = $page - 3;
                    if($page == 4) {
                    echo"<td>
                            <a href='/users/?page=".$pagej2."'>".$pagej2." </a>
                        </td>
                    <td>
                            <a href='/users/?page=".$pagej1."'>".$pagej1." </a>
                        </td>
                    <td>
                            <a href='/users/?page=".$pagej."'>".$pagej." </a>
                        </td>
                    ";
                    }else{
                    }
                    
                    $pagey = $page - 1;
                    $pagey1 = $page - 2;
                    if($page == 3) {
                    echo"<td>
                            <a href='/users/?page=".$pagey1."'>".$pagey1." </a>
                        </td>
                    <td>
                            <a href='/users/?page=".$pagey."'>".$pagey." </a>
                        </td>
                    ";
                    }else{
                    }
                    
                    $paget = $page - 1;
                    if($page == 2) {
                    echo"<td>
                            <a href='/users/?page=".$paget."'>".$paget." </a>
                        </td>
                    ";
                    }else{
                    }
                    

                    for ($page<=$pagefix;$page<=$pagefix;$page++) {

                        echo "
                        <td>
                            <a href='/users/?page=".$page."'>".$page." </a>
                        </td>
                        ";
                    }

                    echo "
<td><a href='/users/?page=$numberofpages'>...</a></td>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    ";
                    ?>
      </tbody>
    </table>
                    </div>
                                
                        </div>
                    
                </div>
                
                                </div>
<?php
require ("/storage/ssd1/648/16177648/public_html/core/footer.php");
?>