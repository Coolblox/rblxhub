<?php
session_start();
session_destroy();
if (isset($_COOKIE['BT_AUTH'])) {
    unset($_COOKIE['BT_AUTH']);
    setcookie('BT_AUTH', null, -1, '/');
}
header("Location: /");
die();
?>