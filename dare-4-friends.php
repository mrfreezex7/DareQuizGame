<?php require_once ('php/ConnectDB.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>

	<base href="/">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Dare Game | What your friends know about you</title>
	<meta name="description" content="Create a dare and share it with your friends & see what they know about you?">

	<?php 
		if(isset($_GET["shareUrl"])){
			$url = $_GET["shareUrl"];
		$feedback = null;

		$sql = "SELECT * FROM dares WHERE UniqueDareUrl	='".$url."'";

		$Result = mysqli_query($conn,$sql);

		if(mysqli_num_rows($Result) > 0){
    	while($row = mysqli_fetch_assoc($Result)){
        	$feedback = array("result"=>true , "Url" => $row['UniqueDareUrl'],"nickname"=>$row['Nickname'],"Qs" =>$row['DareQuestions']);
    	}
		}else{
    		$feedback = array("result"=>false , "Url" => "","nickname"=>"","Qs" =>"");
		}

		$shareResult = $feedback;

		mysqli_close($conn);
		}
	?>

	<?php 
        
		if(isset($_GET["goUrl"])){
			$url = $_GET["goUrl"];
		$feedback = null;

		$sql = "SELECT * FROM dares WHERE UniqueDareUrl	='".$url."'";

		$Result = mysqli_query($conn,$sql);

		if(mysqli_num_rows($Result) > 0){
    	while($row = mysqli_fetch_assoc($Result)){
        	$feedback = array("result"=>true , "Url" => $row['UniqueDareUrl'],"nickname"=>$row['Nickname'],"Qs" =>$row['DareQuestions']);
    	}
		}else{
    		$feedback = array("result"=>false , "Url" => "","nickname"=>"","Qs" =>"");
		}

		$goResult = $feedback;

		mysqli_close($conn);
		}
		
	?>
	
	<?php

		if(isset($_GET["goUrl"])){
			$nickname = $goResult['nickname'];

	if($nickname!=''){
		echo '<meta property="og:site_name" content="dare-quiz-game.com">
		<meta property="og:title" content="Write 7 Truths about '.$nickname.'">
		<meta property="og:description" content="What you think about '.$nickname.'.">
		<meta property="og:image" content="images/ogImages/dare-4-friends-og.png" />
		<meta property="og:type" content="website">
		<meta property="og:url" content="https://dare-quiz-game.com/" />';
	}else{
		echo '<meta property="og:site_name" content="dare-quiz-game.com">
		<meta property="og:title" content="What your friends know about you">
		<meta property="og:description" content="Create a dare and share it with your friends & see what they know about you?">
		<meta property="og:image" content="images/ogImages/dare-4-friends-og.png" />
		<meta property="og:type" content="website">
		<meta property="og:url" content="https://dare-quiz-game.com/" />';
	}

	}else{
		echo '<meta property="og:site_name" content="dare-quiz-game.com">
		<meta property="og:title" content="What your friends know about you">
		<meta property="og:description" content="Create a dare and share it with your friends & see what they know about you?">
		<meta property="og:image" content="images/ogImages/dare-4-friends-og.png" />
		<meta property="og:type" content="website">
		<meta property="og:url" content="https://dare-quiz-game.com/" />';
	}

	?>

	<link rel="canonical" href="https://dare-quiz-game.com/">
	<meta name="robots" content="index, follow">

	<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
	<link rel="manifest" href="images/favicon/site.webmanifest">

	

	<meta name="theme-color" content="#4C1686">


	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700&display=swap" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<div id="app" v-cloak>
		<div class="container">

			<div class="nav-container">
					<!-- navbar -->
					<div class="topnav" id="myTopnav">
					<a class="nav-anchor" href="" style="padding: 0.5em 1em 0 1em;"><img style="border-radius:0.1em" src="images/favicon/favicon-32x32.png" 
							height="32" alt=""></a>
					<a class="nav-anchor" href="">Home</a>
					<a class="nav-anchor" href="about.html">About Us</a>
				  	<a class="nav-anchor" href="privacy.html">Privacy Policy</a>
					<div class="dropdown">
						<button class="dropbtn">Social
							<i class="fa fa-caret-down"></i>
						</button>
						<div class="dropdown-content">
							<a class="nav-anchor" href="https://www.instagram.com/dare-quiz-game/" target="_blank">Instagram</a>
							<a class="nav-anchor" href="https://www.facebook.com/dare-quiz-game/" target="_blank">Facebook</a>
						</div>
					</div>
					<div class="nav-anchor" style="float:right;"><p class="nav-credit-p">"Icon made by&nbsp;<a href="https://www.flaticon.com/authors/freepik">Freepik</a>&nbsp;from&nbsp;<a href="http://www.flaticon.com/" target="_blank" rel="noopener noreferrer">www.flaticon.com</a>"</p></div>
					<a class="nav-anchor icon" href="javascript:void(0);" style="font-size:15px;"
						onclick="NavBarClick()">&#9776;</a>
				</div>
				<!-- navbar-end -->
			</div>

			<div class="main-container">
				<div class="create-page zoomIn" v-if="ShowCreatePageType==0">
					<h2 class="h-2">What's your friends</h2>
					<h3 class="h-3">know about you?</h3>
					<img class="img" src="images/createdare.png" alt="">
					<p class="p">Create a dare</p>
					<p class="p">& check thinking of your friends</p>
					<button class="button pulse" @click="ShowCreatePageType = 1">Create Dare</button>
				</div>

				<div class="name-input" v-if="ShowCreatePageType==1">
					<img class="img" src="images/nickname.png" alt="">
					<h2 class="h-2">Enter Your Nick Name</h2>
					<input class="input" type="text" placeholder="Type nickname" v-model="Nickname"
						:maxlength="MaxNickLength" v-on:keyup.enter="ValidateNicknameInput" autofocus>
					<button class="button" @click="ValidateNicknameInput">Start</button>
				</div>

				<div class="popup-bg" v-if="ShowNicknameAlert" @click="ShowNicknameAlert=false">
					<div class="popup">
						<h2 class="title">Please Enter Your Nickname</h2>
						<button class="button" @click="ShowNicknameAlert=false">OK</button>
					</div>
				</div>

				<div class="popup-bg" v-if="ShowCreatePageType==2 && ShowSelectAlert == true"
					@click="ShowSelectAlert=false">
					<div class="popup">
						<h2 class="title">Select 7 Questions</h2>
						<p class="message">Your friends give answer of these questions</p>
						<button class="button" @click="ShowSelectAlert=false">OK</button>
					</div>
				</div>

				<div class="popup-bg" v-if="ShowMaxQuestionSelectAlert" @click="ShowMaxQuestionSelectAlert=false">
					<div class="popup">
						<h2 class="title">You can select 7 Questions Maximum</h2>
						<button class="button" @click="ShowMaxQuestionSelectAlert=false">OK</button>
					</div>
				</div>

				<div class="popup-bg" v-if="ShowNotEnoughQuestionSelectedAlert"
					@click="ShowNotEnoughQuestionSelectedAlert=false">
					<div class="popup">
						<h2 class="title">Please Select {{7 - QuestionSelectedCount}} more questions</h2>
						<button class="button" @click="ShowNotEnoughQuestionSelectedAlert=false">OK</button>
					</div>
				</div>

				<div class="popup-bg" v-if="ShowCreatingLoadingBar" @click="ShowCreatingLoadingBar=false">
					<div class="popup">
						<h2 class="title">Creating Dare</h2>
						<button class="button" @click="ShowCreatingLoadingBar=false">OK</button>
					</div>
				</div>

				<div class="question-selection" v-if="ShowCreatePageType==2">
					<h2 class="h-2">Select any 7 Questions</h2>

					<div class="select-questions" v-for="(key,keyName,index) in Questions" :class="{Selected:key.selected}">
						<p class="p">{{index+1}}.{{key.question}}</p>
						<img class="img" :src="key.image" alt="">
						<button :class="{button2:key.selected,button:key.selected==false}"
							@click="SelectDeselectQuestion(keyName)">{{key.selected? "Remove" : "Select" }}</button>
					</div>

					<button class="save-button" :class="{tada:QuestionSelectedCount===7}" @click="SaveQuestions">Save
						Questions({{QuestionSelectedCount}})</button>
				</div>


				<div class="created" v-if="ShowCreatePageType==3">
					<h2 class="h-2">Dare Created!</h2>
					<img class="img" src="images/created.png" alt="">
					<p class="p">Send dare to friends</p>
					<p class="p">and they will answer your questions</p>
					<button class="button pulse" @click="OpenSharePage">Share Dare</button>
				</div>


				<div class="popup-bg" v-if="ShowShareOnInstagramPopup" @click="ShowShareOnInstagramPopup=false">
					<div class="popup">
						<h2 class="title">Share on Instagram</h2>
						<br>
						<p>Step 1: Copy your dare link</p>
						<br>
						<p>Step 2: Send dare link as DM(Message) to your friends</p>
						<button class="button" @click="ShowShareOnInstagramPopup=false">OK</button>
					</div>
				</div>

				<div class="popup-bg" v-if="ShowSuccessCopy" @click="ShowSuccessCopy=false">
					<div class="popup">
					<h2 class="title">The Link is Copied</h2>
						<br>
						<p>Send dare link as DM(Message) to your friends</p>
						<button class="button" @click="ShowSuccessCopy=false">OK</button>
					</div>
				</div>

				<div class="popup-bg" v-if="ShowFailedCopy" @click="ShowFailedCopy=false">
					<div class="popup">
						<h2 class="title">Your browser doesn't allow clipboard access!</h2>
						<br>
						<p>Step 1: Copy your dare link</p>
						<br>
						<p>Step 2: Send dare link as DM(Message) to your friends</p>
						<button class="button" @click="ShowFailedCopy=false">OK</button>
					</div>
				</div>
				

				<?php

				if(isset($_GET['shareUrl'])){
					print "<p>{{LoadSharePage('".json_encode($shareResult)."')}}</p>";
				}

				?>

				<div class="share-page zoomIn" v-if="ShowCreatePageType==4" style="z-index:4;">
					<h2 class="h-2">Now, Share Your Dare!</h2>
					<img class="img" src="images/share.png" alt="">
					<p class="p">Your Dare Link</p>
					<p class="p-link">{{"dare-quiz-game.freecluster.eu/d4f1g/"+Details.Link}}</p>
					<input v-show="false" id="toClipboard" :value="'dare-quiz-game.freecluster.eu/d4f1g/'+Details.Link"/>
    				<button class="copy-button" onclick='CopyToClipboard ()'>Copy Link</button>

					<?php
					if(isset($_GET["shareUrl"])){
						$nickname = $shareResult['nickname'];
						$url = $shareResult['Url'];
						if($nickname!=''){
						echo '<a href="whatsapp://send?text=%F0%9F%94%94%20%2ADare%20For%20You%2A%20%F0%9F%94%94
								%0D%0A%0D%0A%0D%0AWrite any *7 Truths* you know about '.$nickname.'%0D%0A%0D%0A%0D%0A%F0%9F%93%B8%20answer%20it%20and%20send%20me%20screenshot%0D%0A%20%F0%9F%91%89%20https%3A%2F%2Fdare-quiz-game.freecluster.eu%2Fd4f1g%2F'.$url.'"><button class="button-whatsapp pulse"><img src="images/whatsapp.png" alt=""> &nbsp; Share on Whatsapp</button></a>';
						}else{
						echo '<a href="whatsapp://send?text=%F0%9F%94%94%20%2ADare%20For%20You%2A%20%F0%9F%94%94
							%0D%0A%0D%0A%0D%0AWrite any *7 Truths* you know about your friend.%0D%0A%0D%0A%0D%0A%F0%9F%93%B8%20answer%20it%20and%20send%20me%20screenshot%0D%0A%20%F0%9F%91%89%20https%3A%2F%2Fdare-quiz-game.freecluster.eu%2Fd4f1g%2F'.$url.'"><button class="button-whatsapp pulse"><img src="images/whatsapp.png" alt=""> &nbsp; Share on Whatsapp</button></a>';
						}
					
					}
						?>
					<button class="button-instagram pulse" @click="ShowShareOnInstagramPopup = true"><img src="images/instagram.png" alt=""> &nbsp; Share on Instagram</button>
					
					<?php
					if(isset($_GET["shareUrl"])){
						$nickname = $shareResult['nickname'];
						$url = $shareResult['Url'];
						if($nickname!=''){
						echo '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A//dare-quiz-game.freecluster.eu/d4f1g/'.$_GET["shareUrl"].'" target="_blank"><button class="button-facebook pulse"><img src="images/facebook.png" alt=""> &nbsp; Share on Facebook</button></a>';
						}else{
						echo '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A//dare-quiz-game.freecluster.eu" target="_blank"><button class="button-facebook pulse"><img src="images/facebook.png" alt=""> &nbsp; Share on Facebook</button></a>';
						}
					
					}
						?>
					<p class="p-note">Your Friends will send you Screenshot</p>
				</div>


				<?php

				if(isset($_GET['goUrl'])){
					print "<p>{{LoadChallengePage('".json_encode($goResult)."')}}</p>";
				}

				?>

			<div class="accept-page" v-if="ShowCreatePageType==5">
				<h2 class="h-2">Did you know</h2>
				<h3 class="h-3">about {{Details.nickname}}?</h3>
				<img class="img" src="images/opinion.png" alt="">
				<p class="p">Accept dare</p>
				<p class="p">& send screenshot to {{Details.nickname}}</p>
				<button class="button pulse" @click="ShowCreatePageType=6">Accept Dare</button>
			</div>

			<div class="name-input" v-if="ShowCreatePageType==6">
				<img class="img" src="images/nickname.png" alt="">
				<h2 class="h-2">Enter Your Nick Name</h2>
				<input class="input" type="text" placeholder="Type Here...."v-model="Nickname" :maxlength="MaxNickLength" v-on:keyup.enter="ValidateNicknameInput" autofocus>
				<button class="button" @click="ValidateNicknameInput">Start</button>
			</div>

			<div class="popup-bg" v-if="ShowTypeAnswerPopup" @click="ShowTypeAnswerPopup=false">
					<div class="popup">
						<h2 class="title">Please Type Answer</h2>
						<button class="button" @click="ShowTypeAnswerPopup=false">OK</button>
					</div>
			</div>

			<div  v-if="ShowCreatePageType==7">

				<div class="answer-input" v-for="(key,index) in ChallengeQuestions" v-if="ShowQuestionsType==index">
					<div class="img-rel">
						<img class="img" :src="key.image" alt="">
					</div>
					<p class="p-badge">Questions : ( {{ShowQuestionsType + 1 }} / 7 )</p>
					<h2 class="h-2">{{key.question}}</h2>
					<input class="input" type="text" placeholder="Type Something...." v-model="key.ans" :maxlength="MaxAnsLength" v-on:keyup.enter="ShowNextQuestion" autofocus>
					<button class="button fadeIn" v-show="key.ans.trim().length>0" @click="ShowNextQuestion">Next</button>
				</div>

			</div>

			<div class="popup-bg" v-if="SendScreenShotPopUp" @click="SendScreenShotPopUp=false">
					<div class="popup">
						<h2 class="title">Send Screenshot to {{Details.nickname}}</h2>
						<button class="button" @click="SendScreenShotPopUp=false">OK</button>
					</div>
			</div>

			<div class="result" v-if="ShowCreatePageType==8">
				<h2 class="h2">Now, Send Screenshot to <span class="nickname">{{Details.nickname}}</span></h2>
				<h3 class="h3">Dare Completed by <span class="given-nickname">{{Nickname}}</span></h3>
				<div class="ans-qa" v-for="(key,index) in ChallengeQuestions">

					<img class="img" :src="key.image" alt="">
					<div class="qa">
						<h4 class="h4">{{index+1}}.{{key.question}}</h4>
						<h4 class="h4"><span class="ans">Ans.</span> <span class="ans-r">{{key.ans}}</span></h4>
					</div>
				</div>
				
				<p class="p">Now, its your turn</p>
				<button class="button pulse" @click="CreateNew">Create Your Own Dare Like This</button>
			</div>

			</div>

		</div>

	</div>


	<script src="js/dare-4-friends.js"></script>
</body>

</html>