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

$sqlExpense = "SELECT SUM(amount) as totalExpense FROM expenses";
$resultExpense = $conn->query($sqlExpense);

$outputExpense = array();

if ($resultExpense->num_rows > 0) {

    while($rowExpense = $resultExpense->fetch_assoc()) {
      $outputExpense['totalExpense'] = $rowExpense["totalExpense"];
    }
  } else {
    echo "0 results";
  }

$conn->close();

// Return as json
echo json_encode($outputExpense);
?>