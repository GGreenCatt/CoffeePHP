<?php
$host="127.0.0.1";
$username="root";
$password="";
$database="coffee";
$conn = mysqli_connect($host,$username,$password,$database);
mysqli_query($conn,"set names'utf8'");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_file = __DIR__ . '/../alter_log_table.sql';
$sql_content = file_get_contents($sql_file);

if ($sql_content === false) {
    die("Error: Could not read SQL file: " . $sql_file);
}

if ($conn->multi_query($sql_content)) {
    // To ensure all queries are executed
    do {
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->next_result());
    echo "Successfully altered 'lichsu_tonkho' table.\n";
} else {
    echo "Error altering table: " . $conn->error . "\n";
}

$conn->close();
?>
