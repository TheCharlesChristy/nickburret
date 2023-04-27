<?php
// update_playing.php

//Get Heroku ClearDB connection information
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$requestee = $_GET['requestee'];
$playing = $_GET['playing'];

// Prepare and execute the SQL update statement
$sql = "UPDATE queue SET Playing=? WHERE Requestee=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $playing, $requestee);
$stmt->execute();

$stmt->close();
$conn->close();
?>
