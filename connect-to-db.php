<?php
$dbhost = "localhost";
$dbuser = "cr27008";
$dbpass = "ayLU2t1Ve";
$db = "cr27008_vposts";
$conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
die("test");
?>