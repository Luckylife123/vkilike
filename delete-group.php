<?php include_once('connect-to-db.php'); ?>
<?php

$vk_group_id = $_GET['vk-group-id'];
$sql = "DELETE FROM Vk_Groups WHERE id = '".$vk_group_id."'";

if ($conn->query($sql) === true) {
    $sql = "DELETE FROM Posts WHERE vk_group_id = '".$vk_group_id."'";
    if ($conn->query($sql) === true) {
        header("Location: /index.php");
        $conn->close();
        exit();
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
        $conn->close();
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    $conn->close();
}

?>