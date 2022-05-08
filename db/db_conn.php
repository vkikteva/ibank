<?php
#echo '<br/>'.date(DATE_RFC822).'<br/>';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$ini = parse_ini_file("db.ini", true /* will scope sectionally */);
$servername=$ini['DB']['host'];
$username='';
$password='';
$db_name='';


// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $db_name);
if ($conn->connect_error) {
    die('Connection failed: '.$conn->connect_error);
}



?>