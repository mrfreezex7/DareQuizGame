<?php require_once ('../ConnectDB.php'); ?>
<?php require_once ('../Utils.php'); ?>

<?php

$uniqueDareUrl = generateRandomString(6);
$nickname = $_POST["nickname"];
$dares =  $_POST["dares"];


$feedback = null;

$sql = "INSERT INTO dares (UniqueDareUrl,Nickname,DareQuestions) VALUES ('".$uniqueDareUrl."','".$nickname."','".$dares."')";
$result = mysqli_query($conn,$sql);

if($result){
    $feedback = array("result"=>true , "Url" => $uniqueDareUrl,"nickname"=>$nickname,"Qs" =>$dares);
}else{
    $feedback = array("result"=>false , "Url" => $uniqueDareUrl,"nickname"=>$nickname,"Qs" =>$dares);
}

echo json_encode($feedback);

mysqli_close($conn);
?>