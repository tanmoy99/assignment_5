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
    if (isset($_POST["delete"])) {
        $taskId = $_POST["task_id"];
        $sql = "DELETE FROM tasks WHERE id = '$taskId'";
        if ($conn->query($sql) === TRUE) {
            // Task deleted successfully
        } else {
            echo "Error deleting task: " . $conn->error;
        }
    } elseif (isset($_POST["complete"])) {
        $taskId = $_POST["task_id"];
        $sql = "UPDATE tasks SET completed = 1 WHERE id = '$taskId'";
        if ($conn->query($sql) === TRUE) {
            // Task marked as completed successfully
        } else {
            echo "Error marking task as completed: " . $conn->error;
        }
    } else {
        $taskName = $_POST["task"];
        $sql = "INSERT INTO tasks (task_name) VALUES ('$taskName')";
        if ($conn->query($sql) === TRUE) {
            // Data added successfully
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:#ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 40%;
            height: 80vh; /* Set the container's height */
            overflow-y: auto; /* Add a scrollbar when content exceeds container's height */
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        form {
            margin-bottom: 10%;
        }
        input[type="text"] {
            width:50%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 15px;
            cursor: pointer;
            width: auto;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
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
                <li>
                    <?php echo htmlspecialchars($row["task_name"]); ?>
                    <?php if ($row["completed"] == 1): ?>
                        <span class="completed">Completed</span>
                    <?php endif; ?>
                    <form method="post" action="">
                        <input type="hidden" name="task_id" value="<?php echo $row["id"]; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                    <form method="post" action="">
                        <input type="hidden" name="task_id" value="<?php echo $row["id"]; ?>">
                        <button type="submit" name="complete">Mark Completed</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>

<?php
$conn->close();
?>
