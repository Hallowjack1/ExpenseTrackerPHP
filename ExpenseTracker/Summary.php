<!DOCTYPE html>
<html>
<head>
	<title>Order Summary</title>
	<style>
		body {
			font-family: Arial, sans-serif;
      background-color:#A5D7E8;
		}
		h2 {
      width: 71%;
			text-align: center;
      margin: auto;
      background-color: #576CBC;
      padding: 20px;
      color: #0B2447;
		}
		table {
      padding-left: 200px;
			border-collapse: fill;
			width: 87%;
			margin-bottom: 20px;
		}
		th, td {
      margin: auto;
			padding: 15px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}
		th {
			background-color: #0B2447;
      color: #ffffff;
		}
    tr {
			background-color: #f2f2f2;
      color: #0B2447;
		}
	</style>
</head>
<body>
	<?php
	$username = "root";
	$password = "";
	$host= "localhost";
	$dbname = "expensetracker";

	$conn = mysqli_connect($host, $username, $password, $dbname);


	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$start_date = "2023-05-01";
	$end_date = "2024-05-31";

	$budget_sql = "SELECT 
                        budgetID,
						date,  
                        budget,
						SUM(budget) AS budget_total, 
						description
					FROM 
						budget
					WHERE 
						date BETWEEN '$start_date' AND '$end_date'
                        GROUP BY budgetID";
	$budget_result = mysqli_query($conn, $budget_sql);


    $budget_total_sql = "SELECT 
                        budgetID,
						date,  
                        budget,
						SUM(budget) AS budget_total, 
						description
					FROM 
						budget
					WHERE 
						date BETWEEN '$start_date' AND '$end_date'";
	$budget_result_total = mysqli_query($conn, $budget_total_sql);

	$expense_sql = "SELECT  
                        expenseID,
						date,  
                        amount,
						SUM(amount) AS expense_total, 
						description
					FROM 
            expenses
					WHERE 
            date BETWEEN '$start_date' AND '$end_date'
            GROUP BY expenseID";
	$expense_result = mysqli_query($conn, $expense_sql);

    $expense_total_sql = "SELECT 
                        expenseID,
						date,  
                        amount,
						SUM(amount) AS expense_total, 
						description
					FROM 
						expenses
					WHERE 
						date BETWEEN '$start_date' AND '$end_date'";
	$expense_result_total = mysqli_query($conn, $expense_total_sql);

echo '<img src="logo.png" alt="logo" style = "width: 20%; margin-left: auto; margin-right: auto; display: block;">';

	if ($budget_total = mysqli_fetch_assoc($budget_result_total)) {
		echo "<h2>Budget Summary Report</h2>";
        echo "<h2>Total Budget (₱ ".$budget_total['budget_total'].")</h2>";
		echo "<table>";
		echo "<thead>
            <tr>
              <th>Date</th>
              <th>Budget</th>
              <th>Description</th>
            </tr>
          </thead>";
		echo "<tbody>";
		while ($row = mysqli_fetch_assoc($budget_result)) {
			
            echo "<tr>";
			echo "<td>" . $row['date'] . "</td>";
			echo "<td>" . $row['budget'] . "</td>";
			echo "<td>" . $row['description'] . "</td>  ";
			echo "</tr>";

		}
		echo "</tbody>";
		echo "</table>";
	} else {
		echo "<p>Error executing summary report query: " . mysqli_error($conn) . "</p>";
	}

if ($expense_total = mysqli_fetch_assoc($expense_result_total)) {
    echo "<h2>Expense Summary Report</h2>";
    echo "<h2>Total Expenses (₱ ".$expense_total['expense_total'].")</h2>";
  echo "<table>";
  echo "<thead>
          <tr>
            <th>Date</th>
            <th>Expense</th>
            <th>Description</th>
          </tr>
        </thead>";
  echo "<tbody>";
  while ($row = mysqli_fetch_assoc($expense_result)) {
    echo "<tr>";
    echo "<td>" . $row['date'] . "</td>";
    echo "<td>" . $row['amount'] . "</td>";
    echo "<td>" . $row['description'] . "</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
} else {
echo "<p>Error executing summary report query: " . mysqli_error($conn) . "</p>";
}

mysqli_close($conn);
?>

</body>
</html>