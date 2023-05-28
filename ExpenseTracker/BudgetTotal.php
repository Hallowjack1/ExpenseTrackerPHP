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

$sqlBudget = "SELECT SUM(budget) as totalBudget FROM budget";
$resultBudget = $conn->query($sqlBudget);

$outputBudget = array();

if ($resultBudget->num_rows > 0) {

  while($rowBudget = $resultBudget->fetch_assoc()) {
    $outputBudget['totalBudget'] = $rowBudget["totalBudget"];
  }
} else {
  echo "0 results";
}

$conn->close();

// Return as json
echo json_encode($outputBudget);
?>