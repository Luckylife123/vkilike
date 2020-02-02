<?php include_once('connect-to-db.php'); ?>
<?php


$sql = "INSERT INTO Vk_Groups ('group_code', 'group_name', 'time_for_post') VALUES ('"
    . $_GET['group_code']
    . "','"
    . $_GET['group_name']
    . "','"
    . $_GET['time_for_post'] . "')";

if ($conn->query($sql) === true) {
    header("Location: /index.php");
    $conn->close();
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    $conn->close();
}

?>