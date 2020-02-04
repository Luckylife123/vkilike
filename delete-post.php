<?php include_once('connect-to-db.php'); ?>
<?php

$post_id = $_GET['post-id'];
$sql = "DELETE FROM Posts WHERE id = '".$post_id."'";

if ($conn->query($sql) === true) {
    header("Location: /index.php");
    $conn->close();
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    $conn->close();
}

?>