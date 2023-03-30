// let questionAnswers = JSON.parse(data[jsindex].content_text);


    let questionAnswers = null;
// var data_1 = null;
// data = null;

// console.log(data);

// function setData(){
//     data=data;
// console.log('data inside: ',data)

// }
// console.log('data outside: ',data)

// let data = null;

// function setData(data){
//     data=data;

//     console.log('data2: inside', data);
// }

// console.log('data2: outside', data);


function index(){
    console.log('index.js connected');
}

function questionAnswer(data) {
    console.log('data: ',data)
    // alert(data);
     questionAnswers = JSON.parse(data[jsindex].content_text);
    console.log('jsindex: ',jsindex);
     console.log('questionAnswers: ',questionAnswers);

}
// console.log('questionupdateAnswers: ',questionAnswers);


// function myName( variable_pass ) {
//      myname = "hello";
//     console.log(variable_pass+myname);
// }

function displayOption() {
    for (let i = 0; i < questionAnswers.answers.length; i++) {
        $(`#displayOption${i + 1}`).html(questionAnswers.answers[i].answer);
        $(`#displayOption${i + 1}`).attr('value', questionAnswers.answers[i].id);
        $(`#option_${i + 1}`).val(questionAnswers.answers[i].id);
    }
    // console.log('questionAnswers inside displayOption: ', questionAnswers)

}

function displayQuestion() {
    $('#displayQuestion').text(questionAnswers.question);
    // console.log('questionAnswers inside displayQuestion: ', questionAnswers)
}

function removeSideListHighlight(data) {
    for (let i = 0; i < data.length; i++) {
        $(`#sideQue${i + 1}`).removeClass('text-primary');
        $(`#sideQue${i + 1}`).addClass('text-dark');
    }
}

function addSideListHighlight(sideListSelector) {
    $(sideListSelector).addClass('text-primary');
    $(sideListSelector).removeClass('text-dark');
}

function persistUserOptions() {
    let userAnswer = JSON.parse(sessionStorage.getItem('user_answers')) ? JSON.parse(sessionStorage.getItem('user_answers')) : [];
    let prevValue = userAnswer[jsindex];

    for (let i = 0; i < questionAnswers.answers.length; i++) {


        if ($('.form-check-input')[i].value == prevValue) {

            $('.form-check-input')[i].click();
        }

    }
}

function displayQueNo() {
    $('.queNo').text(jsindex + 1 <= 9 ? `0${jsindex + 1}` : jsindex + 1);
}

function disableEnableButton(data) {
    if (jsindex == 0) {
        $('#prev').prop('disabled', true)
        $('#next').prop('disabled', false)

    } else if (jsindex == data.length - 1) {
        $('#next').prop('disabled', true)
        $('#prev').prop('disabled', false)

    } else {
        $('#prev').prop('disabled', false)
        $('#next').prop('disabled', false)
    }
}

function unCheckOptions() {
    $('.form-check-input').prop('checked', false);
}



function displaySidePanelQue(data){
    let sideListItem = ``;

    for (let i = 0; i < data.length; i++) {
        sideListItem += `<li class='mt-3 pb-2 border-bottom side-list-item'><a class='h6 text-dark text-decoration-none' id='sideQue${i + 1}' value='${i}'>${data[i].snippet}</a></li>`
    }


    $('.sideList').html(sideListItem);
}


function createOptions(){
    let optionsHtml = ``;
    for (let i = 0; i < questionAnswers.answers.length; i++) {
        optionsHtml += `<div class="form-check">
<label class="form-check-label">
    <input id='option_${i + 1}' tabindex='${i + 1}' type="radio" class="form-check-input answer_input" name="optradio"><span class='answer_input' id='displayOption${i + 1}'>Option ${i + 1}</span>
</label>
</div>
`;
    }

    $('.options').append(optionsHtml);
}