<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expensetracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT 
        (SELECT SUM(budget) FROM budget) -
        (SELECT SUM(amount) FROM expenses) AS result";

$result = $conn->query($sql);

$output = array();

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $output['result'] = $row["result"];
  }
} else {
  echo "0 results";
}

$conn->close();

// Return as json
echo json_encode($output);
?>