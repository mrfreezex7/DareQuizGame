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
      ShareData: "",
      ChallengeData: "",
      Details: {
        Link: "",
        nickname: "",
        Qs: "",
        maxQuestion: 0,
      },
      Nickname: "",
      MaxNickLength: 15,
      ShowNicknameAlert: false,
      ShowCreatePageType: -1,
      ShowSelectAlert: false,
      SelectedQuestions: {
        Q0: false,
        Q1: false,
        Q2: false,
        Q3: false,
        Q4: false,
        Q5: false,
        Q6: false,
        Q7: false,
        Q8: false,
        Q9: false,
      },
      Questions: {
        Q0: {
          question: "What is the talent of || ?",
          image: "images/talent.png",
          selected: false,
          ans: "",
        },
        Q1: {
          question: "Write funny name of || ?",
          image: "images/funny.png",
          selected: false,
          ans: "",
        },
        Q2: {
          question: "Which job suits of || ?",
          image: "images/job.png",
          selected: false,
          ans: "",
        },
        Q3: {
          question: "Write name of future gf/bf of || ?",
          image: "images/gfbf.png",
          selected: false,
          ans: "",
        },
        Q4: {
          question: "Which habit of || irritates you?",
          image: "images/irritates.png",
          selected: false,
          ans: "",
        },
        Q5: {
          question: "Which color does not suits on || ?",
          image: "images/color.png",
          selected: false,
          ans: "",
        },
        Q6: {
          question: "Do you want to steal anything from || ?",
          image: "images/steal.png",
          selected: false,
          ans: "",
        },
        Q7: {
          question: "A song that you want to dedicate to || ?",
          image: "images/song.png",
          selected: false,
          ans: "",
        },
        Q8: {
          question: "Name of || in your mobile contacts",
          image: "images/contact.png",
          selected: false,
          ans: "",
        },
        Q9: {
          question: "What is your opinion on me?",
          image: "images/opinion.png",
          selected: false,
          ans: "",
        },
      },
      ChallengeQuestions: [],
      QuestionSelectedCount: 0,
      SelectedQuestionsIndex: [],
      ShowMaxQuestionSelectAlert: false,
      ShowNotEnoughQuestionSelectedAlert: false,
      ShowCreatingLoadingBar: false,
      ShowQuestionsType: 0,
      MaxAnsLength: 30,
      SendScreenShotPopUp: false,
      ShowShareOnInstagramPopup: false,
      ShowTypeAnswerPopup: false,
      ShowSuccessCopy: false,
      ShowFailedCopy: false,
    };
  },
  methods: {
    CreateNew: function () {
      window.location = MainURL + "/dare-4-friends.php";
    },
    ShowNextQuestion: function () {
      if (
        this.ChallengeQuestions[this.ShowQuestionsType].ans.trim().length > 0
      ) {
        this.ChallengeQuestions[this.ShowQuestionsType].ans =
          this.ChallengeQuestions[this.ShowQuestionsType].ans
            .trim()
            .substring(0, this.MaxAnsLength);
        this.ShowQuestionsType++;
        if (this.ShowQuestionsType === this.Details.maxQuestion) {
          this.ShowCreatePageType = 8;
          window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = "o/";

            (e || window.event).returnValue = confirmationMessage; //Gecko + IE
            return confirmationMessage; //Webkit, Safari, Chrome
          });
          setTimeout(() => {
            this.SendScreenShotPopUp = true;
          }, 1000);
        }
      } else {
        this.ShowTypeAnswerPopup = true;
      }
    },
    LoadQuestions: function () {
      let Qs = this.Details.Qs.split(",");
      let counter = 0;
      for (const key in this.Questions) {
        if (this.Questions.hasOwnProperty(key)) {
          if (Qs.indexOf(counter.toString()) !== -1) {
            this.ChallengeQuestions.push(this.Questions[key]);
          }
          counter++;
        }
      }
      console.log(counter);
    },
    UpdateQuestions: function () {
      for (const key in this.Questions) {
        if (this.Questions.hasOwnProperty(key)) {
          const element = this.Questions[key].question;
          if (element.indexOf("||") !== -1) {
            if (this.Details.nickname !== "") {
              this.Questions[key].question = element.replace(
                "||",
                this.Details.nickname
              );
            } else {
              this.Questions[key].question = element.replace(
                "||",
                this.Nickname
              );
            }
          }
        }
      }
      if (this.ShowCreatePageType == 6) {
        this.LoadQuestions();
      }
    },
    ValidateNicknameInput: function () {
      if (this.Nickname.trim().length <= 0) {
        this.Nickname = "";
        this.ShowNicknameAlert = true;
      } else {
        this.UpdateQuestions();
        this.Nickname = this.Nickname.trim().substring(0, this.MaxNickLength);
        this.ShowCreatePageType++;

        this.ShowSelectAlert = true;
      }
    },
    SelectDeselectQuestion: function (qNo) {
      if (this.QuestionSelectedCount < 7 || this.Questions[qNo].selected) {
        this.Questions[qNo].selected = !this.Questions[qNo].selected;
        if (this.Questions[qNo].selected) {
          this.QuestionSelectedCount++;
        } else {
          this.QuestionSelectedCount--;
        }
      } else {
        this.ShowMaxQuestionSelectAlert = true;
      }
    },
    SaveQuestions: function () {
      if (this.QuestionSelectedCount == 7) {
        this.SelectedQuestionsIndex = [];
        let index = 0;
        for (const key in this.Questions) {
          if (this.Questions.hasOwnProperty(key)) {
            const element = this.Questions[key].selected;
            if (element) {
              this.SelectedQuestionsIndex.push(index);
            }
            index++;
          }
        }
        this.ShowCreatingLoadingBar = true;
        Create(this.Nickname, this.SelectedQuestionsIndex);
      } else {
        this.ShowNotEnoughQuestionSelectedAlert = true;
      }
    },
    LoadSharePage: function (data) {
      if (data) this.ShareData = data.toString();
    },
    LoadChallengePage: function (data) {
      if (data) this.ChallengeData = data.toString();
    },
    OpenSharePage: function () {
      window.location = MainURL + "/d4f1s/" + this.Details.Link;
    },
    scrollToEnd: function () {
      window.scrollTo(
        0,
        document.body.scrollHeight || document.documentElement.scrollHeight
      );
    },
  },
  watch: {
    QuestionSelectedCount: function () {
      if (this.QuestionSelectedCount == 7) {
        console.log("scolling to end");
        this.scrollToEnd();
      }
    },
    ShareData: function () {
      GetShareData(this.ShareData);
    },
    ChallengeData: function () {
      GetChallengeData(this.ChallengeData);
    },
  },
  mounted() {
    let url = window.location.href;
    if (url.indexOf("/d4f1s/") === -1 && url.indexOf("/d4f1g/") === -1) {
      this.ShowCreatePageType = 0;
    }
  },
});

function Create(nickname, dares) {
  fetch("php/d4f1/CreateDare.php", {
    method: "POST",
    body: new URLSearchParams("nickname=" + nickname + "&dares=" + dares),
  })
    .then((res) => res.json())
    .then((res) => CreateResult(res))
    .catch((e) => console.log("error" + e));
}

function CreateResult(data) {
  console.log(data);
  if (data.result) {
    UpdateShareDetails(data);
    vm.ShowCreatingLoadingBar = false;
    vm.ShowCreatePageType = 3;
  } else {
    vm.ShowCreatingLoadingBar = false;
    vm.ShowCreatingLoadingBar = 2;
  }
}

function GetShareData(data) {
  UpdateSharePage(JSON.parse(data));
}

function GetChallengeData(data) {
  UpdateChallengePage(JSON.parse(data));
}

function UpdateSharePage(data) {
  console.log(data);
  if (data.result) {
    UpdateShareDetails(data);
    vm.ShowCreatingLoadingBar = false;
    vm.ShowCreatePageType = 4;
  } else {
    window.location = MainURL + "/dare-4-friends.php";
  }
}

function UpdateChallengePage(data) {
  console.log(data);
  if (data.result) {
    UpdateShareDetails(data);
    vm.ShowCreatingLoadingBar = false;
    vm.ShowCreatePageType = 5;
  } else {
    window.location = MainURL + "/dare-4-friends.php";
  }
}

function UpdateShareDetails(data) {
  if (data.result) {
    vm.Details.Link = data.Url;
    vm.Details.nickname = data.nickname;
    vm.Details.Qs = data.Qs;
    vm.Details.maxQuestion = data.Qs.split(",").length;
    vm.ShowCreatingLoadingBar = false;
  }
}
