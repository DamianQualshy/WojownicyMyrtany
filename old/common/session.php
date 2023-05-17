<?php
session_start();
header('Cache-control: private');

if (!isset($_SESSION['inicjuj']))
{
    session_regenerate_id();
    $_SESSION['inicjuj'] = true;
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
}
if($_SESSION['ip'] !== $_SERVER['REMOTE_ADDR'])
{
    session_destroy();
}
?>