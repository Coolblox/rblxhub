<meta http-equiv="refresh" content="3; URL=/">
<?php
include ("../core/conn.php");
$maintenance = "true";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title><?=$sitename?> Maintenance</title>
<style type="text/css"> 
      .content { /* border: 1px solid rgb(153, 153, 153); */
    	width: 800px;
        margin-top: 0px;
        margin-bottom: 10px;
        /* background-color: rgb(255, 255, 255); */
        margin-right: auto;
        margin-left: auto;
        text-align: justify;
        }
        @font-face {
            font-family: sourcesans;
            src: url(https://rblxhub.ga/SourceSansPro-Regular.otf);
        }
        </style>
</head>
<body style="background:rgb(252,252,252);">
<div style="width:900px;margin:auto;background:#fff;">
<img style="display:block;margin:auto;" src="/images/Logo.png">
<div class="content">
<p style="text-align: center">&nbsp;</p>
<p style="text-align: center">
<img src="/images/robloxteamsitedownimage1.jpg" id="ctl00_cphRoblox_imgRobloxTeam" alt="Offline"/>
</p>
<p style="text-align: center; font-size: 14px;font-family:sourcesans;letter-spacing: 0.2px;font-style: normal;">
The site is currently offline for maintenance and upgrades. Please check back soon!
</p>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<p>
    <?php
if(isset($_POST['login'])){

$maintPass = $_POST['login'];
if($maintPass == "thisisapassrblxhub4679"){
    session_start();
$_SESSION['maintenance'] = '1';
echo'<meta http-equiv="refresh" content="3;url=/" />';
echo"<p style='color: green;'>Success! Logging in shortly.&nbsp;&nbsp;</p>";
  die();
//echo"<p style='color: green;'>Success! Logging in shortly.&nbsp;&nbsp;</p>";    

}else{
echo"<p style='color: #c73535;'>Incorrect key!&nbsp;&nbsp;</p>";    
}

}
?>
<form action="" method="POST">
<input name="login" type="password"/>
<input type="submit" name="r" value="R"/>
<input type="submit" name="b" value="B"/>
<input type="submit" name="l" value="L"/>
<input type="submit" name="x" value="X"/>
<input type="submit" name="h" value="H"/>
<input type="submit" name="u" value="U"/>
<input type="submit" name="b2" value="B"/></form> </p>
</div>
<br/><br/>
<div style="font: normal 7pt/normal Verdana, sans-serif;text-align:center;">
<?php
include ("../core/footer.php");
?></body>
</html>