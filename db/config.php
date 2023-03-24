<?php
define('dbuser', 'root');
define('dbpass', '');
define('dbname', 'personal_banking');
define('dbhost', 'localhost');

$conn = mysqli_connect(dbhost, dbuser, dbpass,dbname);

if (!$conn) {
    die('Could not connect: ' . mysqli_error());
}


?>