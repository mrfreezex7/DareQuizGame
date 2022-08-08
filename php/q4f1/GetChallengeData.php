<?php require_once ('../ConnectDB.php'); ?>

<?php

	if(isset($_POST["link"])){
        $url = $_POST["link"];

    $feedback = null;
    $qna=null;

    $sql = "SELECT * FROM q4f1 WHERE UniqueQuizUrl ='".$url."'";

    $Result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($Result) > 0){
    while($row = mysqli_fetch_assoc($Result)){
        $feedback = array("result"=>true ,"UserId"=>$row['UniqueUserID'], "Url" => $row['UniqueQuizUrl'],"nickname"=>$row['Nickname'],"qna"=>json_decode($row["QnA"]));
        $qna = json_decode($row["QnA"]);
    }	
    }else{
        $feedback = array("result"=>false ,"UserId"=>"", "Url" => "","nickname"=>"");
        $qna = "";
    }

    echo json_encode($feedback);
 

    mysqli_close($conn);
    }
?>