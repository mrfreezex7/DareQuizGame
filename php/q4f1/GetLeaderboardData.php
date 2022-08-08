<?php require_once ('../ConnectDB.php'); ?>

<?php

$link =  $_POST["link"];

$feedback = null;

$sql = "SELECT * FROM q4f1lb WHERE UniqueQuizUrl ='".$link."'";

$Result = mysqli_query($conn,$sql);

if(mysqli_num_rows($Result) > 0){
    while($row = mysqli_fetch_assoc($Result)){
        $feedback[] = array("result"=>true ,"UserId"=>$row['UniqueUserID'], "Url" => $row['UniqueQuizUrl'],"nickname"=>$row['Nickname'],"points"=>$row['Points']);
    }
}else{
    $feedback = [];
}

echo json_encode($feedback);

mysqli_close($conn);
?>