<?php require_once ('../ConnectDB.php'); ?>

<?php

$uid =  $_POST["uid"];
$link =  $_POST["link"];

$feedback = null;

$sql = "SELECT * FROM q4f1lb WHERE UniqueUserID ='".$uid."' AND UniqueQuizUrl ='".$link."'";

$Result = mysqli_query($conn,$sql);

if(mysqli_num_rows($Result) > 0){
    while($row = mysqli_fetch_assoc($Result)){
        $feedback = array("result"=>true ,"UserId"=>$row['UniqueUserID'], "Url" => $row['UniqueQuizUrl'],"nickname"=>$row['Nickname'],"points"=>$row['Points']);
        echo json_encode($feedback);
        mysqli_close($conn);
        return;
    }
}else{
    $feedback = array("result"=>false , "UserId"=>"", "Url" => "","nickname"=>"","points"=>"");
}

echo json_encode($feedback);

mysqli_close($conn);
?>