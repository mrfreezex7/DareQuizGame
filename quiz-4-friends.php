<?php require_once ('php/ConnectDB.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
	<title>Quiz Game | Are your friends smart enough to top your quiz?</title>
	<meta name="description" content="Friendship Challenge! Make quiz, share with your friends and find out if they can top your quiz?">

	<meta property="og:site_name" content="dare-quiz-game.com">
    <meta property="og:title" content="Friendship Challenge! Are you smart enough to top my quiz? Find out">
    <meta property="og:description"
        content="Friendship Challenge! Make quiz, share with your friends and find out if they can top your quiz?">
    <meta property="og:image" content="images/ogImages/quiz-4-friends-og.png" />
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://dare-quiz-game.com/" />

	
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
					<h2 class="h-2">Friendship Challenge!</h2>
					<h3 class="h-3">Are Your Friends Smart Enough To Top Your Quiz?</h3>
					<img class="img" src="images/createdare.png" alt="">
					<p class="p">Create a Quiz</p>
					<p class="p">& check thinking of your friends</p>
					<button class="button pulse" @click="ShowCreatePageType = 1">Create Quiz</button>
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
						<h2 class="title">Select 12 Questions</h2>
						<p class="message">Your friends give answer of these questions</p>
						<button class="button" @click="ShowSelectAlert=false">OK</button>
					</div>
				</div>	

				<div class="popup-bg" v-if="ShowCreatingLoadingBar" @click="ShowCreatingLoadingBar=false">
					<div class="popup">
						<div class="loader"></div>
					</div>
				</div>

				<div class="popup-bg" style="z-index:10;" v-if="ShowRemoveBar" @click="ShowRemoveBar=false">
					<div class="popup">
						<h2 class="title">Are you Sure?</h2>
						<div>
							<button class="button" style="background-color:#2BC4A2;" @click="DeleteCreateNew">Yes</button>
							<button class="button" style="background-color:#2BC4A2;" @click="ShowRemoveBar=false">Cancel</button>
						</div>
					</div>
				</div>

				<div class="question-selection" v-if="ShowCreatePageType == 2 || ShowCreatePageType == 7">
				
					<button class="change-button" @click="ChangeQuestion"  v-if="ShowCreatePageType == 2">Change Question({{QuestionSelectedCount}}/12)</button>
						<div  v-if="ShowCreatePageType == 7" class="question-counter">Questions : ({{CurrentQuestionIndex}}/12)</div>
					<div class="select-questions" v-if="ShowQuestionsType==1" >
						<p class="p" v-if="ShowCreatePageType == 2">Which is your b'day month?</p>
						<p class="p"  v-if="ShowCreatePageType == 7">Which is {{Details.nickname}}'s b'day month?</p>
						<button class="button3"  @click="SetAnswer('Q1',1)" :class="{correct:CorrectAnswer == 1,wrong:WrongAnswer == 1}">January</button>
						<button class="button3"  @click="SetAnswer('Q1',2)" :class="{correct:CorrectAnswer == 2,wrong:WrongAnswer == 2}">February</button>
						<button class="button3" @click="SetAnswer('Q1',3)" :class="{correct:CorrectAnswer == 3,wrong:WrongAnswer == 3}">March</button>
						<button class="button3" @click="SetAnswer('Q1',4)" :class="{correct:CorrectAnswer == 4,wrong:WrongAnswer == 4}">April</button>
						<button class="button3" @click="SetAnswer('Q1',5)" :class="{correct:CorrectAnswer == 5,wrong:WrongAnswer == 5}">May</button>
						<button class="button3" @click="SetAnswer('Q1',6)" :class="{correct:CorrectAnswer == 6,wrong:WrongAnswer == 6}">June</button>
						<button class="button3" @click="SetAnswer('Q1',7)" :class="{correct:CorrectAnswer == 7,wrong:WrongAnswer == 7}">July</button>
						<button class="button3" @click="SetAnswer('Q1',8)" :class="{correct:CorrectAnswer == 8,wrong:WrongAnswer == 8}">August</button>
						<button class="button3" @click="SetAnswer('Q1',9)" :class="{correct:CorrectAnswer == 9,wrong:WrongAnswer == 9}">September</button>
						<button class="button3" @click="SetAnswer('Q1',10)" :class="{correct:CorrectAnswer == 10,wrong:WrongAnswer == 10}">October</button>
						<button class="button3" @click="SetAnswer('Q1',11)" :class="{correct:CorrectAnswer == 11,wrong:WrongAnswer == 11}">November</button>
						<button class="button3" @click="SetAnswer('Q1',12)" :class="{correct:CorrectAnswer == 12,wrong:WrongAnswer == 12}">December</button>
					</div>

					<div class="select-questions" v-if="ShowQuestionsType==2">
						<p class="p"  v-if="ShowCreatePageType == 2">Do you like school life or college life?</p>
						<p class="p"  v-if="ShowCreatePageType == 7">Do {{Details.nickname}} like school life or college life?</p>
						<button class="button3" @click="SetAnswer('Q2',1)" :class="{correct:CorrectAnswer == 1,wrong:WrongAnswer == 1}">School Life</button>
						<button class="button3" @click="SetAnswer('Q2',2)" :class="{correct:CorrectAnswer == 2,wrong:WrongAnswer == 2}">College Life</button>
					</div>

					<div class="select-questions" v-if="ShowQuestionsType==3" >
						<p class="p" v-if="ShowCreatePageType == 2">What do you prefer?</p>
						<p class="p" v-if="ShowCreatePageType == 7">>What do {{Details.nickname}} prefer?</p>
						<button class="button3" @click="SetAnswer('Q3',1)" :class="{correct:CorrectAnswer == 1,wrong:WrongAnswer == 1}">Movies</button>
						<button class="button3" @click="SetAnswer('Q3',2)" :class="{correct:CorrectAnswer == 2,wrong:WrongAnswer == 2}">Anime</button>
						<button class="button3" @click="SetAnswer('Q3',3)" :class="{correct:CorrectAnswer == 3,wrong:WrongAnswer == 3}">Web Series</button>
						<button class="button3" @click="SetAnswer('Q3',4)" :class="{correct:CorrectAnswer == 4,wrong:WrongAnswer == 4}">All</button>
					</div>

					<div class="select-questions" v-if="ShowQuestionsType==4">
						<p class="p" v-if="ShowCreatePageType == 2">What do you use the most?</p>
						<p class="p" v-if="ShowCreatePageType == 7">What do {{Details.nickname}} use the most?</p>
						<button class="button3" @click="SetAnswer('Q4',1)" :class="{correct:CorrectAnswer == 1,wrong:WrongAnswer == 1}">Facebook</button>
						<button class="button3" @click="SetAnswer('Q4',2)" :class="{correct:CorrectAnswer == 2,wrong:WrongAnswer == 2}">Instagram</button>
						<button class="button3" @click="SetAnswer('Q4',3)" :class="{correct:CorrectAnswer == 3,wrong:WrongAnswer == 3}">Twitter</button>
						<button class="button3" @click="SetAnswer('Q4',4)" :class="{correct:CorrectAnswer == 4,wrong:WrongAnswer == 4}">Snapchat</button>
					</div>

					<div class="select-questions" v-if="ShowQuestionsType==5" >
						<p class="p" v-if="ShowCreatePageType == 2">How many relationships did you had?</p>
						<p class="p" v-if="ShowCreatePageType == 7">How many relationships did {{Details.nickname}} had?</p>
						<button class="button3" @click="SetAnswer('Q5',1)" :class="{correct:CorrectAnswer == 1,wrong:WrongAnswer == 1}">None</button>
						<button class="button3" @click="SetAnswer('Q5',2)" :class="{correct:CorrectAnswer == 2,wrong:WrongAnswer == 2}">One</button>
						<button class="button3" @click="SetAnswer('Q5',3)" :class="{correct:CorrectAnswer == 3,wrong:WrongAnswer == 3}">Two</button>
						<button class="button3" @click="SetAnswer('Q5',4)" :class="{correct:CorrectAnswer == 4,wrong:WrongAnswer == 4}">Three</button>
						<button class="button3" @click="SetAnswer('Q5',5)" :class="{correct:CorrectAnswer == 5,wrong:WrongAnswer == 5}">More</button>
					</div>

					<div class="select-questions" v-if="ShowQuestionsType==6" >
						<p class="p" v-if="ShowCreatePageType == 2">What is more important to you?</p>
						<p class="p" v-if="ShowCreatePageType == 7">What is more important to {{Details.nickname}}?</p>
						<button class="button3" @click="SetAnswer('Q6',1)" :class="{correct:CorrectAnswer == 1,wrong:WrongAnswer == 1}">Family & Friends</button>
						<button class="button3" @click="SetAnswer('Q6',2)" :class="{correct:CorrectAnswer == 2,wrong:WrongAnswer == 2}">Carrier</button>
						<button class="button3" @click="SetAnswer('Q6',3)" :class="{correct:CorrectAnswer == 3,wrong:WrongAnswer == 3}">Relationship</button>
						<button class="button3" @click="SetAnswer('Q6',4)" :class="{correct:CorrectAnswer == 4,wrong:WrongAnswer == 4}">Money</button>
					</div>
			
					<div class="select-questions" v-if="ShowQuestionsType==7" >
						<p class="p" v-if="ShowCreatePageType == 2">What do you like to do in free time?</p>
						<p class="p" v-if="ShowCreatePageType == 7">What do {{Details.nickname}} like to do in free time?</p>
						<button class="button3" @click="SetAnswer('Q7',1)" :class="{correct:CorrectAnswer == 1,wrong:WrongAnswer == 1}">Watching TV</button>
						<button class="button3" @click="SetAnswer('Q7',2)" :class="{correct:CorrectAnswer == 2,wrong:WrongAnswer == 2}">Reading Books</button>
						<button class="button3" @click="SetAnswer('Q7',3)" :class="{correct:CorrectAnswer == 3,wrong:WrongAnswer == 3}">Playing Game</button>
					</div>
			
					<div class="select-questions" v-if="ShowQuestionsType==8">
						<p class="p" v-if="ShowCreatePageType == 2">What do you prefer?</p>
						<p class="p" v-if="ShowCreatePageType == 7">What do {{Details.nickname}} prefer?</p>
						<button class="button3" @click="SetAnswer('Q8',1)" :class="{correct:CorrectAnswer == 1,wrong:WrongAnswer == 1}">Tea</button>
						<button class="button3" @click="SetAnswer('Q8',2)" :class="{correct:CorrectAnswer == 2,wrong:WrongAnswer == 2}">Cofee</button>
					</div>

					<div class="select-questions"  v-if="ShowQuestionsType==9">
						<p class="p" v-if="ShowCreatePageType == 2">If you had one wish, what would it be?</p>
						<p class="p" v-if="ShowCreatePageType == 7">If {{Details.nickname}} had one wish, what would it be?</p>
						<button class="button3" @click="SetAnswer('Q9',1)" :class="{correct:CorrectAnswer == 1,wrong:WrongAnswer == 1}">To be a billionaire</button>
						<button class="button3" @click="SetAnswer('Q9',2)" :class="{correct:CorrectAnswer == 2,wrong:WrongAnswer == 2}">To be best at everything</button>
						<button class="button3" @click="SetAnswer('Q9',3)" :class="{correct:CorrectAnswer == 3,wrong:WrongAnswer == 3}">Have superpowers</button>
						<button class="button3" @click="SetAnswer('Q9',4)" :class="{correct:CorrectAnswer == 4,wrong:WrongAnswer == 4}">Unlimited Foods</button>
					</div>

					<div class="select-questions" v-if="ShowQuestionsType==10">
						<p class="p" v-if="ShowCreatePageType == 2">Which one will you choose?</p>
						<p class="p" v-if="ShowCreatePageType == 7">Which one will {{Details.nickname}} choose?</p>
						<button class="button3" @click="SetAnswer('Q10',1)" :class="{correct:CorrectAnswer == 1,wrong:WrongAnswer == 1}">Beach</button>
						<button class="button3" @click="SetAnswer('Q10',2)" :class="{correct:CorrectAnswer == 2,wrong:WrongAnswer == 2}">Mountain</button>
					</div>

					<div class="select-questions" v-if="ShowQuestionsType==11">
						<p class="p" v-if="ShowCreatePageType == 2">Which season do you like?</p>
						<p class="p" v-if="ShowCreatePageType == 7">Which season do {{Details.nickname}} like?</p>
						<button class="button3" @click="SetAnswer('Q11',1)" :class="{correct:CorrectAnswer == 1,wrong:WrongAnswer == 1}">Summer</button>
						<button class="button3" @click="SetAnswer('Q11',2)" :class="{correct:CorrectAnswer == 2,wrong:WrongAnswer == 2}">Rainy</button>
						<button class="button3" @click="SetAnswer('Q11',3)" :class="{correct:CorrectAnswer == 3,wrong:WrongAnswer == 3}">Winter</button>
					</div>

					<div class="select-questions" v-if="ShowQuestionsType==12">
						<p class="p" v-if="ShowCreatePageType == 2">Do you like long hair or short hair?</p>
						<p class="p" v-if="ShowCreatePageType == 7">Do {{Details.nickname}} like long hair or short hair?</p>
						<button class="button3" @click="SetAnswer('Q12',1)" :class="{correct:CorrectAnswer == 1,wrong:WrongAnswer == 1}">Long</button>
						<button class="button3" @click="SetAnswer('Q12',2)" :class="{correct:CorrectAnswer == 2,wrong:WrongAnswer == 2}">Short</button>
					</div>
			
					<div class="select-questions" v-if="ShowQuestionsType==13">
						<p class="p" v-if="ShowCreatePageType == 2">Choose any one?</p>
						<p class="p" v-if="ShowCreatePageType == 7">What would {{Details.nickname}} choose?</p>
						<button class="button3" @click="SetAnswer('Q13',1)" :class="{correct:CorrectAnswer == 1,wrong:WrongAnswer == 1}">Netflix</button>
						<button class="button3" @click="SetAnswer('Q13',2)" :class="{correct:CorrectAnswer == 2,wrong:WrongAnswer == 2}">Youtube</button>
					</div>

					<div class="select-questions" v-if="ShowQuestionsType==14">
						<p class="p" v-if="ShowCreatePageType == 2">Do you want to be hugged or kissed?</p>
						<p class="p" v-if="ShowCreatePageType == 7">Do {{Details.nickname}} want to be hugged or kissed?</p>
						<button class="button3" @click="SetAnswer('Q14',1)" :class="{correct:CorrectAnswer == 1,wrong:WrongAnswer == 1}">Hug</button>
						<button class="button3" @click="SetAnswer('Q14',2)" :class="{correct:CorrectAnswer == 2,wrong:WrongAnswer == 2}">Kiss</button>
					</div>

					<div class="select-questions" v-if="ShowQuestionsType==15">
						<p class="p" v-if="ShowCreatePageType == 2">Which one do you like?</p>
						<p class="p" v-if="ShowCreatePageType == 7">Which one do {{Details.nickname}} like?</p>
						<button class="button3" @click="SetAnswer('Q15',1)" :class="{correct:CorrectAnswer == 1,wrong:WrongAnswer == 1}">Android </button>
						<button class="button3" @click="SetAnswer('Q15',2)" :class="{correct:CorrectAnswer == 2,wrong:WrongAnswer == 2}">Iphone(iOS)</button>
					</div>
			
				</div>

				<div class="created" v-if="ShowCreatePageType==3">
					<h2 class="h-2">Quiz Created!</h2>
					<img class="img" src="images/created.png" alt="">
					<p class="p">Send Quiz to friends</p>
					<p class="p">and they will answer your questions</p>
					<button class="button pulse" @click="OpenSharePage">Share Quiz</button>
				</div>

				<div class="result" style="margin-top:1em" v-if="ShowCreatePageType==3">

				<div class="leaderboard">
				 <h2 class="h2">Leaderboard</h2>
				 <div >
				 <p v-if="LeaderboardData.length <= 0" style="margin:0.3em 0">No one has given this quiz yet.</p>
					 <ul class="leaderboard_max_item">
					 	<div v-for="(data,i) in FilteredLeaderboard">
					 		<li class="leaderboard-data">
							 	<p class="rank">{{i+1}}</p>
							 	<p class="name">{{data.nickname}}</p>
							 	<p class="points">{{data.points}}/12</p>
							 </li>
					 	</div>
					 </ul>
				 </div>
				</div>
				
				<p class="p">Now, its your turn</p>
				<button class="button pulse" @click="ShowRemoveBar=true">Delete & Create New Quiz</button>
				</div>


				<div class="popup-bg" v-if="ShowShareOnInstagramPopup" @click="ShowShareOnInstagramPopup=false">
					<div class="popup">
						<h2 class="title">Share on Instagram</h2>
						<br>
						<p>Step 1: Copy your quiz link</p>
						<br>
						<p>Step 2: Send quiz link as DM(Message) to your friends</p>
						<button class="button" @click="ShowShareOnInstagramPopup=false">OK</button>
					</div>
				</div>

				<div class="popup-bg" v-if="ShowSuccessCopy" @click="ShowSuccessCopy=false">
					<div class="popup">
					<h2 class="title">The Link is Copied</h2>
						<br>
						<p>Send quiz link as DM(Message) to your friends</p>
						<button class="button" @click="ShowSuccessCopy=false">OK</button>
					</div>
				</div>

				<div class="popup-bg" v-if="ShowFailedCopy" @click="ShowFailedCopy=false">
					<div class="popup">
						<h2 class="title">Your browser doesn't allow clipboard access!</h2>
						<br>
						<p>Step 1: Copy your quiz link</p>
						<br>
						<p>Step 2: Send quiz link as DM(Message) to your friends</p>
						<button class="button" @click="ShowFailedCopy=false">OK</button>
					</div>
				</div>

				<div class="share-page zoomIn" v-if="ShowCreatePageType==4" style="z-index:4;">
					<h2 class="h-2">Now, Share Your Quiz!</h2>
					<img class="img" src="images/share.png" alt="">
					<p class="p">Your Quiz Link</p>
					<p class="p-link">{{"dare-quiz-game.freecluster.eu/q4f1g/"+Details.Link}}</p>
					<input v-show="false" id="toClipboard" :value="'dare-quiz-game.freecluster.eu/q4f1g/'+Details.Link"/>
    				<button class="copy-button" onclick='CopyToClipboard ()'>Copy Link</button>
					<a :href="whatsappLink"><button class="button-whatsapp pulse"><img src="images/whatsapp.png" alt=""> &nbsp; Share on Whatsapp</button></a>
					<button class="button-instagram pulse" @click="ShowShareOnInstagramPopup = true"><img src="images/instagram.png" alt=""> &nbsp; Share on Instagram</button>
					<a :href="'https://www.facebook.com/sharer/sharer.php?u=https%3A//dare-quiz-game.freecluster.eu/q4f1g/' + Details.Link" target="_blank"><button class="button-facebook pulse"><img src="images/facebook.png" alt=""> &nbsp; Share on Facebook</button></a>
					<p class="p-note">See Score of your friends once they complete your quiz.</p>
				</div>

				<div class="result" style="margin-top:1em" v-if="ShowCreatePageType==4">

				<div class="leaderboard">
				 <h2 class="h2">Leaderboard</h2>
				 <div >
				 <p v-if="LeaderboardData.length <= 0" style="margin:0.3em 0">No one has given this quiz yet.</p>
					 <ul class="leaderboard_max_item">
					 	<div v-for="(data,i) in FilteredLeaderboard">
					 		<li class="leaderboard-data">
							 	<p class="rank">{{i+1}}</p>
							 	<p class="name">{{data.nickname}}</p>
							 	<p class="points">{{data.points}}/12</p>
							 </li>
					 	</div>
					 </ul>
				 </div>
				</div>
				


				<p class="p">Now, its your turn</p>
				<button class="button pulse" @click="ShowRemoveBar=true">Delete & Create New Quiz</button>
				</div>

				
				<div class="accept-page" v-if="ShowCreatePageType==5">
					<h2 class="h-2">Did you know</h2>
					<h3 class="h-3">about {{Details.nickname}}?</h3>
					<img class="img" src="images/opinion.png" alt="">
					<p class="p">Accept Quiz</p>
					<p class="p">& see if you can top the leaderboard.</p>
					<button class="button pulse" @click="ShowCreatePageType=6">Accept Quiz</button>
				</div>

				<div class="name-input" v-if="ShowCreatePageType==6">
					<img class="img" src="images/nickname.png" alt="">
					<h2 class="h-2">Enter Your Nick Name</h2>
					<input class="input" type="text" placeholder="Type Here...."v-model="Nickname" :maxlength="MaxNickLength" v-on:keyup.enter="ValidateNicknameInput" autofocus>
					<button class="button" @click="ValidateNicknameInput">Start</button>
				</div>

				<div class="result" v-if="ShowCreatePageType==8">
				<h3 class="h3">Quiz Completed by <span class="given-nickname">{{Nickname}}</span></h3>

				<div class="player-points">You Got : <span>{{PlayerPoints}} Points</span>

				<div id="myProgress">
  					<div id="myBar"></div>
				</div>
				</div>

				<div class="leaderboard">
				 <h2 class="h2">Leaderboard</h2>
				 <div >
				 <p v-if="LeaderboardData.length <= 0" style="margin:0.3em 0">No one has given this quiz yet.</p>
					 <ul class="leaderboard_max_item">
					 	<div v-for="(data,i) in FilteredLeaderboard" :class="[data.UserId == uID? 'highlight-leaderboard-player':'']">
					 		<li class="leaderboard-data">
							 	<p class="rank">{{i+1}}</p>
							 	<p class="name">{{data.nickname}}</p>
							 	<p class="points">{{data.points}}/12</p>
							 </li>
					 	</div>
					 </ul>
				 </div>
				</div>
				


				<p class="p">Now, its your turn</p>
				<button class="button pulse" @click="CreateNew">Create Your Own Quiz Like This</button>
				</div>

            </div>

        </div>
    </div>

<script src="js/quiz-4-friends.js"></script>

</body>
</html>