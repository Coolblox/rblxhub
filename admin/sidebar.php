<style>
    body {
        background-color: #f3f3f3;
    }
    #admin {
        width: 15%;
        background-color: #e8e8e8;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 0;
    }
    #header {
        overflow: hidden;
    }
    #logo {
        text-align: center;
        padding: 5px 10px 0;
        border: 0;
    }
    #img {
        border: 0;
    }
</style>
<link id="ctl00_Imports" rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"></link>
<div id="admin">
<div id="header">
    <div id="logo">
        <a href="/admin">
        <img id="imglogo" src="./altlogo.png" alt="<?=$sitename?> Admin Panel">
        </a>
        <br><br><br>
        <a href="#">Abuse reports</a><br><br>
        <a href="#">Images</a><br><br>
        <a href="/admin/usermoderation.php">Users</a><br><br>
        <a href="/admin/maintenance_mode.php">Maintenance Mode</a><br><br>
        <a href="/admin/site_alert.php">Change Site Alert</a><br><br>
        <a href="/admin/alt_identification.php">Alt Identification</a><br><br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <a href="/">My <?=$sitename?></a>
    </div>
</div>
</div>