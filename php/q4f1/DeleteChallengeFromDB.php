<?php require_once ('../ConnectDB.php'); ?>

<?php

$link = $_POST["link"];


$feedback = null;

$sql = "DELETE FROM q4f1 WHERE UniqueQuizUrl = '".$link."' ";
$sql2 = "DELETE FROM q4f1lb WHERE UniqueQuizUrl = '".$link."' ";


$result = mysqli_query($conn,$sql);
$result2 = mysqli_query($conn,$sql2);


echo 'true';

mysqli_close($conn);
?>