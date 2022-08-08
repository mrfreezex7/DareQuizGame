<?php require_once ('../ConnectDB.php'); ?>

<?php

$uid =  $_POST["uid"];

$feedback = null;

$sql = "SELECT * FROM q4f1 WHERE UniqueUserID	='".$uid."'";

$Result = mysqli_query($conn,$sql);

if(mysqli_num_rows($Result) > 0){
    while($row = mysqli_fetch_assoc($Result)){
        $feedback = array("result"=>true ,"UserId"=>$row['UniqueUserID'], "Url" => $row['UniqueQuizUrl'],"nickname"=>$row['Nickname']);
    }
}else{
    $feedback = array("result"=>false , "UserId"=>"", "Url" => "","nickname"=>"","qna" =>"");
}

echo json_encode($feedback);

mysqli_close($conn);
?>