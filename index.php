<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tasklist";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskName = $_POST["task"];

    $sql = "INSERT INTO tasks (task_name) VALUES ('$taskName')";

    if ($conn->query($sql) === TRUE) {
        // Data added successfully
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM tasks ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Task List</h1>
        <form method="post">
            <input type="text" name="task" placeholder="Enter a new task">
            <button type="submit">Add Task</button>
        </form>
        <h2>Tasks:</h2>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li><?php echo $row["task_name"]; ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>

<?php
$conn->close();
?>
