<?php require_once ('../ConnectDB.php'); ?>
<?php require_once ('../Utils.php'); ?>

<?php

$uniqueUserID = $_POST["uid"];
$uniqueQuizUrl = generateRandomString(6);
$nickname = $_POST["nickname"];
$qna = $_POST["qna"];


$feedback = null;

$sql = "INSERT INTO q4f1 (UniqueUserID,UniqueQuizUrl,Nickname,QnA) VALUES ('".$uniqueUserID."','".$uniqueQuizUrl."','".$nickname."','".$qna."')";
$result = mysqli_query($conn,$sql);

if($result){
    $feedback = array("result"=>true , "UserId"=>$uniqueUserID,"Url" => $uniqueQuizUrl,"nickname"=>$nickname,"qna" =>$qna);
}else{
    $feedback = array("result"=>false , "UserId"=>"", "Url" => "","nickname"=>"","qna" =>"");
}

echo json_encode($feedback);

mysqli_close($conn);
?>