console.log = function () {};

function NavBarClick() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}

function CopyToClipboard() {
  var input = document.getElementById("toClipboard");
  var textToClipboard = input.value;

  var success = true;
  if (window.clipboardData) {
    // Internet Explorer
    window.clipboardData.setData("Text", textToClipboard);
  } else {
    // create a temporary element for the execCommand method
    var forExecElement = CreateElementForExecCommand(textToClipboard);

    /* Select the contents of the element 
            (the execCommand for 'copy' method works on the selection) */
    SelectContent(forExecElement);

    var supported = true;

    // UniversalXPConnect privilege is required for clipboard access in Firefox
    try {
      if (window.netscape && netscape.security) {
        netscape.security.PrivilegeManager.enablePrivilege(
          "UniversalXPConnect"
        );
      }

      // Copy the selected content to the clipboard
      // Works in Firefox and in Safari before version 5
      success = document.execCommand("copy", false, null);
    } catch (e) {
      success = false;
    }

    // remove the temporary element
    document.body.removeChild(forExecElement);
  }

  if (success) {
    vm.ShowSuccessCopy = true;
  } else {
    vm.ShowFailedCopy = true;
  }
}

function CreateElementForExecCommand(textToClipboard) {
  var forExecElement = document.createElement("div");
  // place outside the visible area
  forExecElement.style.position = "absolute";
  forExecElement.style.left = "-10000px";
  forExecElement.style.top = "-10000px";
  // write the necessary text into the element and append to the document
  forExecElement.textContent = textToClipboard;
  document.body.appendChild(forExecElement);
  // the contentEditable mode is necessary for the  execCommand method in Firefox
  forExecElement.contentEditable = true;

  return forExecElement;
}

function SelectContent(element) {
  // first create a range
  var rangeToSelect = document.createRange();
  rangeToSelect.selectNodeContents(element);

  // select the contents
  var selection = window.getSelection();
  selection.removeAllRanges();
  selection.addRange(rangeToSelect);
}

const MainURL = "http://dare-quiz-game.freecluster.eu/";

const vm = new Vue({
  el: "#app",
  data() {
    return {
      ShowRemoveBar: false,
      URL: "",
      PlayerPoints: 0,
      CurrentQuestionIndex: 1,
      IsChallengeCreator: false,
      uID: "",
      Details: {
        isCreater: false,
        userId: "",
        Link: "",
        nickname: "",
        QnA: "",
        FinalPoints: 0,
        maxQuestion: 12,
      },
      Nickname: "",
      MaxNickLength: 15,
      ShowNicknameAlert: false,
      ShowCreatePageType: -1,
      ShowSelectAlert: false,
      QnA: {
        Q1: 0,
        Q2: 0,
        Q3: 0,
        Q4: 0,
        Q5: 0,
        Q6: 0,
        Q7: 0,
        Q8: 0,
        Q9: 0,
        Q10: 0,
        Q11: 0,
        Q12: 0,
        Q13: 0,
        Q14: 0,
        Q15: 0,
      },
      QuestionSelectedCount: 0,
      ShowCreatingLoadingBar: false,
      ShowQuestionsType: 1,
      ShowShareOnInstagramPopup: false,
      ShowSuccessCopy: false,
      ShowFailedCopy: false,
      CompletedQnAList: [],
      CorrectAnswer: 0,
      WrongAnswer: 0,
      TempCQI: 1,
      LeaderboardData: [],
      ls: {
        nn: "",
        pt: "",
        cqi: "",
        cqal: "",
      },
      whatsappLink: "",
      componentKey: "",
    };
  },
  methods: {
    CreateNew: function () {
      window.location = MainURL + "/quiz-4-friends.php";
    },
    DeleteCreateNew: function () {
      this.ShowCreatePageType = -1;
      this.ShowRemoveBar = false;
      DeleteFromDataBase(this.Details.Link);
    },
    ShowNextQuestion: function () {
      this.CorrectAnswer = 0;
      this.WrongAnswer = 0;
      let index = 1;
      this.CurrentQuestionIndex++;

      for (const [i, [key, value]] of Object.entries(
        Object.entries(this.QnA)
      )) {
        if (this.CompletedQnAList.indexOf(key) === -1 && value != 0) {
          this.ShowQuestionsType = index;
          console.log(index);
          return;
        }
        index++;
      }
    },
    LoadQuestions: function () {
      let points = parseInt(localStorage.getItem(this.ls.pt));
      let cqi = parseInt(localStorage.getItem(this.ls.cqi));
      let cqal = JSON.parse(localStorage.getItem(this.ls.cqal));

      console.log(points, cqi, cqal);

      if (points) {
        if (points >= 12) {
          this.PlayerPoints = points;
        } else if (points <= 0) {
          this.PlayerPoints = 0;
        } else {
          this.PlayerPoints = points;
        }
      } else {
        this.PlayerPoints = 0;
      }

      if (cqi) {
        if (cqi <= 12) {
          this.CurrentQuestionIndex = cqi;
        } else {
          this.CurrentQuestionIndex = 0;
        }
      }

      if (cqal && cqal.length > 0) {
        this.CompletedQnAList = cqal;
        this.ShowNextQuestion();
      }
    },
    UpdateQuestions: function (qnaData) {
      let index = 1;
      this.QnA = qnaData;

      for (const key in this.QnA) {
        if (this.QnA.hasOwnProperty(key)) {
          const value = this.QnA[key];
          console.log(key);
          if (value != 0) {
            this.ShowQuestionsType = index;
            return;
          }
          index++;
        }
      }
    },
    SetAnswer: function (questionId, ans) {
      if (
        this.IsChallengeCreator &&
        this.CompletedQnAList.indexOf(questionId) === -1
      ) {
        this.QnA[questionId] = ans;
        this.QuestionSelectedCount++;
        this.CorrectAnswer = ans;
        this.CompletedQnAList.push(questionId);
        setTimeout(() => {
          this.ChangeQuestion();
        }, 200);
      } else {
        console.log(questionId);
        if (this.CompletedQnAList.indexOf(questionId) === -1) {
          if (this.QnA[questionId] === ans) {
            this.PlayerPoints++;
            localStorage.setItem(this.ls.pt, this.PlayerPoints);
            this.CorrectAnswer = ans;
          } else {
            this.WrongAnswer = ans;
            this.CorrectAnswer = this.QnA[questionId];
          }
          this.CompletedQnAList.push(questionId);
          localStorage.setItem(
            this.ls.cqal,
            JSON.stringify(this.CompletedQnAList)
          );
          localStorage.setItem(this.ls.cqi, this.CurrentQuestionIndex);
          setTimeout(() => {
            this.ShowNextQuestion();
          }, 500);
        }
      }
    },
    ValidateNicknameInput: function () {
      if (this.Nickname.trim().length <= 0) {
        this.Nickname = "";
        this.ShowNicknameAlert = true;
      } else {
        this.Nickname = this.Nickname.trim().substring(0, this.MaxNickLength);
        this.ShowCreatePageType++;

        localStorage.setItem(this.ls.nn, this.Nickname);

        this.ShowSelectAlert = true;
      }
    },
    ChangeQuestion: function () {
      this.CorrectAnswer = 0;
      if (this.QuestionSelectedCount < 12) {
        let AvaliableQuestionIndex = [];
        let index = 1;
        for (const key in this.QnA) {
          if (this.QnA.hasOwnProperty(key)) {
            const element = this.QnA[key];
            if (element === 0) {
              AvaliableQuestionIndex.push(index);
            }
            index++;
          }
        }
        if (AvaliableQuestionIndex.length > 0) {
          for (let i = 0; i < AvaliableQuestionIndex.length; i++) {
            if (AvaliableQuestionIndex[i] > this.ShowQuestionsType) {
              this.ShowQuestionsType = AvaliableQuestionIndex[i];
              return;
            }
          }

          this.ShowQuestionsType = AvaliableQuestionIndex[0];
        }
      }
    },
    OpenSharePage: function () {
      window.location = MainURL + "/q4f1s/" + this.Details.Link;
    },
    scrollToEnd: function () {
      window.scrollTo(
        0,
        document.body.scrollHeight || document.documentElement.scrollHeight
      );
    },
  },
  watch: {
    ShowCreatePageType: function () {
      if (this.ShowCreatePageType == 7) {
        this.LoadQuestions();
      }
    },
    QuestionSelectedCount: function () {
      if (this.QuestionSelectedCount >= 12) {
        setTimeout(() => {
          this.ShowCreatePageType = -1;
          this.ShowCreatingLoadingBar = true;
          CreateQuiz(this.uID, this.Nickname, JSON.stringify(this.QnA));
        }, 200);
      }
    },
    CurrentQuestionIndex: function () {
      if (this.CurrentQuestionIndex > 12) {
        this.ShowCreatePageType = -1;
        this.ShowCreatingLoadingBar = false;
        let points = this.PlayerPoints;
        if (points >= 12) {
          points = 12;
        } else if (points <= 0) {
          points = 0;
        }
        SubmitQuizResult(this.uID, this.Nickname, this.Details.Link, points);
      }
    },
    uID: function () {
      if (this.uID) {
        CheckIfQuizAlreadyCreated(this.uID);
      }
    },
  },
  mounted() {
    let url = window.location.href;
    let uid = getCookie("uID");

    if (url) {
      this.URL = url;
    }

    if (!uid) {
      this.uID = CreateNewUID();
    } else {
      this.uID = uid;
    }
  },
  computed: {
    FilteredLeaderboard: function () {
      return this.LeaderboardData.sort(compare);
    },
  },
});

function CreateNewUID() {
  let uid = makeid(8);
  setCookie("uID", uid, 15);
  return uid;
}

function CheckIfQuizAlreadyCreated(uid) {
  fetch("php/q4f1/GetDataQ4F1.php", {
    method: "POST",
    body: new URLSearchParams("uid=" + uid),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.result) {
        UpdateDetails(data);
        if (
          vm.URL.indexOf("/q4f1s/") === -1 &&
          vm.URL.indexOf("/q4f1g/") === -1
        ) {
          vm.IsChallengeCreator = false;
          vm.ShowCreatePageType = 3;
          GetLeaderBoardData(data.Url);
        } else if (vm.URL.indexOf("/q4f1s/") !== -1) {
          vm.ShowCreatingLoadingBar = false;
          vm.whatsappLink = `whatsapp://send?text=%F0%9F%A4%9D *Friendship Challenge!* %F0%9F%A4%9D %0A%F0%9F%A4%A9 Are you smart enough to top ${
            data.nickname
          } quiz?%F0%9F%A4%A9%0A %F0%9F%92%AB%F0%9F%91%87%F0%9F%91%87%F0%9F%91%87%F0%9F%91%87%F0%9F%91%87%F0%9F%92%AB %0A${
            MainURL + "/q4f1g/" + data.Url
          }`;
          vm.ShowCreatePageType = 4;
          GetLeaderBoardData(data.Url);
        } else if (vm.URL.indexOf("/q4f1g/") !== -1) {
          let urlLen = vm.URL.indexOf("/q4f1g/") + 7;
          let url = vm.URL.substr(urlLen);
          if (url == data.Url) {
            window.location = MainURL + "/quiz-4-friends.php";
          } else {
            IsChallengeAlreadyCompleted(vm.uID, url);
          }
        }
      } else {
        if (
          vm.URL.indexOf("/q4f1s/") === -1 &&
          vm.URL.indexOf("/q4f1g/") === -1
        ) {
          vm.IsChallengeCreator = true;
          vm.ShowCreatePageType = 0;
        } else if (vm.URL.indexOf("/q4f1s/") !== -1) {
          window.location = MainURL + "/quiz-4-friends.php";
        } else if (vm.URL.indexOf("/q4f1g/") !== -1) {
          let urlLen = vm.URL.indexOf("/q4f1g/") + 7;
          let url = vm.URL.substr(urlLen);
          console.log("loadingQuiz");
          IsChallengeAlreadyCompleted(vm.uID, url);
        }
      }
    })
    .catch((e) => console.log("error" + e));
}

function UpdateDetails(data) {
  if (data.result) {
    vm.Details.Link = data.Url;
    vm.Details.nickname = data.nickname;
    vm.Details.userId = data.UserId;
    vm.Details.maxQuestion = 12;
    vm.ShowCreatingLoadingBar = false;
  }
}

function CreateQuiz(uid, nickname, qna) {
  fetch("php/q4f1/CreateQuizQ4F1.php", {
    method: "POST",
    body: new URLSearchParams(
      "uid=" + uid + "&nickname=" + nickname + "&qna=" + qna
    ),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.result) {
        UpdateDetails(data);
        vm.ShowCreatingLoadingBar = false;
        vm.ShowCreatePageType = 3;
        GetLeaderBoardData(data.Url);
      } else {
        // show retry creating the quiz again
        //make a popup and ask to create or retry if case if the server responder with failed creating
        // vm.ShowCreatingLoadingBar = false;
        // vm.ShowCreatePageType = 0;
      }
    })
    .catch((e) => console.log("error" + e));
}

function IsChallengeAlreadyCompleted(uid, url) {
  fetch("php/q4f1/IsChallengeCompleted.php", {
    method: "POST",
    body: new URLSearchParams("uid=" + uid + "&link=" + url),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);
      if (data.result) {
        UpdateDetails(data);
        vm.Nickname = data.nickname;
        vm.PlayerPoints = data.points;
        vm.ShowCreatePageType = 8;
        setTimeout(() => {
          move((parseInt(data.points) / 12) * 100);
        }, 500);
        GetLeaderBoardData(url);
      } else {
        GetChallengeData(url);
      }
    })
    .catch((e) => console.log("error" + e));
}

function GetChallengeData(url) {
  fetch("php/q4f1/GetChallengeData.php", {
    method: "POST",
    body: new URLSearchParams("link=" + url),
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data);
      if (data.result) {
        UpdateDetails(data);
        vm.UpdateQuestions(data.qna);
        vm.ShowCreatingLoadingBar = false;
        CreateLocalStorageDataNames(url);
        vm.ShowCreatePageType = 5;
      } else {
        window.location = MainURL + "/quiz-4-friens.php";
      }
    })
    .catch((e) => console.log("error" + e));
}

function CreateLocalStorageDataNames(url) {
  vm.ls.nn = url + "nn";
  vm.ls.pt = url + "pt";
  vm.ls.cqi = url + "cqi";
  vm.ls.cqal = url + "cqal";

  console.log(localStorage.getItem(vm.ls.nn) == true);

  if (!localStorage.getItem(vm.ls.nn)) localStorage.setItem(vm.ls.nn, "");
  if (!localStorage.getItem(vm.ls.pt)) localStorage.setItem(vm.ls.pt, 0);
  if (!localStorage.getItem(vm.ls.cqi)) localStorage.setItem(vm.ls.cqi, 0);
  if (!localStorage.getItem(vm.ls.cqal)) localStorage.setItem(vm.ls.cqal, 0);

  vm.LoadQuestions();
}

function SubmitQuizResult(uid, nickname, quizlink, points) {
  console.log("Submitting Result");
  fetch("php/q4f1/SubmitQuizResult.php", {
    method: "POST",
    body: new URLSearchParams(
      "uid=" +
        uid +
        "&nickname=" +
        nickname +
        "&link=" +
        quizlink +
        "&points=" +
        points
    ),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.result) {
        DeleteAllLocalStorageData();
        vm.Nickname = data.nickname;
        vm.PlayerPoints = data.points;
        vm.ShowCreatePageType = 8;
        setTimeout(() => {
          move((parseInt(data.points) / 12) * 100);
        }, 500);
        GetLeaderBoardData(quizlink);
      } else {
        //show popup error
      }
    })
    .catch((e) => console.log("error" + e));
}

function DeleteAllLocalStorageData() {
  localStorage.removeItem(vm.ls.nn);
  localStorage.removeItem(vm.ls.pt);
  localStorage.removeItem(vm.ls.cqi);
  localStorage.removeItem(vm.ls.cqal);
}

function GetLeaderBoardData(link) {
  fetch("php/q4f1/GetLeaderboardData.php", {
    method: "POST",
    body: new URLSearchParams("link=" + link),
  })
    .then((res) => res.json())
    .then((data) => {
      vm.LeaderboardData = data;
      setTimeout(() => {
        console.log("force update");
        vm.$forceUpdate();
      }, 1000);
    })
    .catch((e) => console.log("error" + e));
}

function DeleteFromDataBase(link) {
  fetch("php/q4f1/DeleteChallengeFromDB.php", {
    method: "POST",
    body: new URLSearchParams("link=" + link),
  })
    .then((res) => res.json())
    .then((res) => IsDataDeleted(res))
    .catch((e) => console.log("error" + e));
}

function IsDataDeleted(data) {
  console.log(data);
  window.location = MainURL + "/quiz-4-friends.php";
}

//cookies fns

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  var expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(";");
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function deleteCookie(cname) {
  document.cookie = cname + "=; Path=/; Expires=Thu, 01 Jan 1990 00:00:01 GMT;";
}

function makeid(length) {
  var result = "";
  var characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  var charactersLength = characters.length;
  for (var i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}

var i = 0;
function move(maxDistance) {
  if (i == 0) {
    i = 1;
    var elem = document.getElementById("myBar");
    var width = 1;
    var id = setInterval(frame, 10);
    function frame() {
      if (width >= maxDistance) {
        clearInterval(id);
        i = 0;
      } else {
        width++;
        elem.style.width = width + "%";
      }
    }
  }
}

function compare(a, b) {
  let val1 = parseInt(a.points);
  let val2 = parseInt(b.points);
  if (val1 < val2) return 1;
  if (val1 > val2) return -1;
  return 0;
}
