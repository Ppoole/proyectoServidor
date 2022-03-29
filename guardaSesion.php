<?php
session_start();
if(isset($_GET['variable']) && isset($_GET['valor']))
{
$_SESSION[$_GET['variable']] = $_GET['valor'];
}
?>