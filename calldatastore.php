<?php
date_default_timezone_set('UTC');
$timenow = date('l jS \of F Y h:i:s A');
$queryval = $_GET['searchtext'] . ' ' . $timenow;
echo $queryval;
?>
