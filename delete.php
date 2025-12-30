<?php
include 'config.php';
$id = $_GET['id'];
$query = "DELETE FROM players WHERE id='$id'";

if (mysqli_query($conn, $query)) {
    header("Location: index.php");
} else {
    echo "Failed To Delete Data";
}
?>