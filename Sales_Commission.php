<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Commission</title>
</head>
<body>

<div>
    <h2>Sales Commission Calculation</h2>
    <form method="post" action="">
        <label for="id">ID:</label>
        <input type="text" name="id" id="id" required><br><br>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>
        
        <label for="month">Month:</label>
        <input type="text" name="month" id="month" required><br><br>
        
        <label for="sales">Sales Amount (RM):</label>
        <input type="number" name="sales" id="sales" required><br><br>
        
        <button type="submit">Calculate Commission</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $month = $_POST['month'];
        $sales = $_POST['sales'];
        $commission = 0;

        if ($sales >= 1 && $sales <= 2000) {
            $commission = $sales * 0.05;
        } elseif ($sales >= 2001 && $sales <= 5000) {
            $commission = $sales * 0.06;
        } elseif ($sales >= 5001 && $sales <= 7000) {
            $commission = $sales * 0.08;
        } elseif ($sales >= 7001) {
            $commission = $sales * 0.15;
        }

        $conn = new mysqli('localhost', 'root', '', 'sales_commission_db');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO commissions (id, name, month, sales_amount, commission) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdd", $id, $name, $month, $sales, $commission);
        $stmt->execute();
        
        echo "<h3>Sales Commission</h3>";
        echo "ID: " . htmlspecialchars($id) . "<br>";
        echo "Name: " . htmlspecialchars($name) . "<br>";
        echo "Month: " . htmlspecialchars($month) . "<br>";
        echo "Sales Amount: RM " . number_format($sales, 2) . "<br>";
        echo "Sales Commission: RM " . number_format($commission, 2) . "<br>";

        $stmt->close();
        $conn->close();
    }
    ?>
</div>
</body>
</html>