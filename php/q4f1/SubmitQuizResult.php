<?php require_once ('../ConnectDB.php'); ?>

<?php

$uniqueUserID =  $_POST["uid"];
$uniqueQuizUrl =  $_POST["link"];
$nickname = $_POST["nickname"];
$points =  $_POST["points"];


$feedback = null;


$sql = "INSERT INTO q4f1lb (UniqueUserID,UniqueQuizUrl,Nickname,Points) VALUES ('".$uniqueUserID."','".$uniqueQuizUrl."','".$nickname."','".$points."')";
$result = mysqli_query($conn,$sql);

if($result){
    $feedback = array("result"=>true , "UserId"=> $uniqueUserID ,"Url" => $uniqueQuizUrl,"nickname"=>$nickname,"points" =>$points);
}else{
    $feedback = array("result"=>false , "UserId"=>"", "Url" => "","nickname"=>"","points" =>"");
}

echo json_encode($feedback);

mysqli_close($conn);
?>