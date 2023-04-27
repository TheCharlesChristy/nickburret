<?php
header("Content-Type: application/json");
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

$song_id = isset($_POST['song_id']) ? $_POST['song_id'] : '';

if ($song_id !== '') {
  $sql = "DELETE FROM queue WHERE Requestee = ?";
  
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $song_id);
    $stmt->execute();
    $stmt->close();
    echo json_encode(["status" => "success"]);
  } else {
    echo json_encode(["status" => "error", "message" => "Error preparing statement."]);
  }
} else {
  echo json_encode(["status" => "error", "message" => "Song ID is missing."]);
}

$conn->close();
?>
