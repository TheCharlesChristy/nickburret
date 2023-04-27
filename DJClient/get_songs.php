<?php
header('Content-Type: application/json');
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

// Get the sorting parameter from the query string
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'artist';

if ($conn->connect_error) {
    die(json_encode(array("status" => "error", "message" => "Connection failed: " . $conn->connect_error)));
}

// Sort the data by the given parameter
$sql = "SELECT * FROM songs ORDER BY $sort_by ASC";
$result = $conn->query($sql);

$songs = array();
while ($row = $result->fetch_assoc()) {
    $songs[] = $row;
}

echo json_encode($songs);

$conn->close();
?>
