/**

This function parses a JSON string containing a list of questions and answers, and assigns it to a variable called 'questionAnswers'.
@param {string} data - A string containing a JSON object with a list of questions and answers.
@param {number} jsindex - An index number indicating the position of the desired content_text value in the input data.
@returns {void} - This function does not return anything, but assigns the parsed JSON data to a global variable called 'questionAnswers'.
*/

function questionAnswer(data) {
     questionAnswers = JSON.parse(data[jsindex].content_text);
}

/**

This function displays the answer options for a given question.
@returns {void} - This function does not take any parameters or return anything.
It accesses the global variable 'questionAnswers' to retrieve the answer options for the current question, and uses jQuery to update the HTML of the corresponding DOM elements.
The answer options are displayed as radio buttons, and each radio button has a value corresponding to the ID of the corresponding answer in the 'questionAnswers' object.
*/

function displayOption() {
    for (let i = 0; i < questionAnswers.answers.length; i++) {
        $(`#displayOption${i + 1}`).html(questionAnswers.answers[i].answer);
        $(`#displayOption${i + 1}`).attr('value', questionAnswers.answers[i].id);
        $(`#option_${i + 1}`).val(questionAnswers.answers[i].id);
    }
}


/**

This function displays the current question to the user.
@returns {void} - This function does not take any parameters or return anything.
It accesses the global variable 'questionAnswers' to retrieve the question text for the current question, and uses jQuery to update the HTML of the corresponding DOM element.
*/
function displayQuestion() {
    $('#displayQuestion').text(questionAnswers.question);
    
}

/**

This function removes the highlight from all items in a list of questions.
@param {array} data - An array of question objects to be processed.
@returns {void} - This function does not return anything, but uses jQuery to update the HTML of the corresponding DOM elements.
The function loops through the array of questions and removes the 'text-primary' class, and adds the 'text-dark' class to each item in the list.
*/
function removeSideListHighlight(data) {
    for (let i = 0; i < data.length; i++) {
        $(`#sideQue${i + 1}`).removeClass('text-primary');
        $(`#sideQue${i + 1}`).addClass('text-dark');
    }
}

/**

This function adds a highlight to a selected item in a list of questions.
@param {string} sideListSelector - A CSS selector for the DOM element corresponding to the selected item in the list.
@returns {void} - This function does not take any parameters or return anything, but uses jQuery to update the HTML of the corresponding DOM element.
The function adds the 'text-primary' class to the selected item in the list, and removes the 'text-dark' class from that item.
*/
function addSideListHighlight(sideListSelector) {
    $(sideListSelector).addClass('text-primary');
    $(sideListSelector).removeClass('text-dark');
}

/**

This function persists the user's selected answer for the current question in session storage.
@returns {void} - This function does not take any parameters or return anything, but uses jQuery and the Session Storage API to persist the user's selected answer.
It retrieves the user's previous answer from session storage using the global variable 'jsindex' to identify the current question.
If the user has previously answered this question, the function selects the corresponding radio button using jQuery.
The user's selected answer is then saved in session storage as an array of answer IDs.
*/
function persistUserOptions() {
    let userAnswer = JSON.parse(sessionStorage.getItem('user_answers')) ? JSON.parse(sessionStorage.getItem('user_answers')) : [];
    let prevValue = userAnswer[jsindex];

    for (let i = 0; i < questionAnswers.answers.length; i++) {


        if ($('.form-check-input')[i].value == prevValue) {

            $('.form-check-input')[i].click();
        }

    }
}


/**

This function displays the current question number to the user.
@returns {void} - This function does not take any parameters or return anything.
It uses jQuery to update the HTML of the corresponding DOM element with the current question number, as determined by the global variable 'jsindex'.
If the current question number is less than 10, the function prepends a '0' to the number for display consistency.
*/
function displayQueNo() {
    $('.queNo').text(jsindex + 1 <= 9 ? `0${jsindex + 1}` : jsindex + 1);
}

/**

This function enables or disables the 'Previous' and 'Next' buttons based on the current question index.
@param {Array} data - An array of objects containing the quiz questions and answers.
@returns {void} - This function does not return anything, but uses jQuery to update the HTML of the corresponding DOM elements.
The function checks if the current question index (as determined by the global variable 'jsindex') is the first or last question in the quiz.
If it is the first question, the function disables the 'Previous' button and enables the 'Next' button.
If it is the last question, the function disables the 'Next' button and enables the 'Previous' button.
If it is neither the first nor last question, the function enables both buttons.
*/
function disableEnableButton(data) {
    if (jsindex == 0) {
        $('#prev').prop('disabled', true)
        $('#next').prop('disabled', false)
        $('#prev').addClass('disabled');
        $('#next').removeClass('disabled');

    } else if (jsindex == data.length - 1) {
        $('#next').prop('disabled', true)
        $('#prev').prop('disabled', false)
        $('#next').addClass('disabled');
        $('#prev').removeClass('disabled');


    } else {
        $('#prev').prop('disabled', false)
        $('#next').prop('disabled', false)
        $('#next').removeClass('disabled');
        $('#prev').removeClass('disabled');

    }
}

/**

This function unchecks all answer options for the current question.
@returns {void} - This function does not take any parameters or return anything.
It uses jQuery to select all input elements with the class 'form-check-input' and set their 'checked' property to false.
This clears any previously selected answer option for the current question.
*/
function unCheckOptions() {
    $('.form-check-input').prop('checked', false);
}


/**

This function dynamically generates the question list in the side panel.
@param {Array} data - An array of objects containing the quiz questions and answers.
@returns {void} - This function does not return anything, but uses jQuery to update the HTML of the corresponding DOM element.
The function loops through the array of quiz questions and answers (as passed in the 'data' parameter).
For each question, it generates an HTML list item element that displays the question text as a hyperlink.
The list item element is given the ID 'sideQueX', where 'X' is the index of the question in the array.
The function then appends the list item elements to the HTML of the corresponding DOM element.
*/
function displaySidePanelQue(data){
    let sideListItem = ``;

    for (let i = 0; i < data.length; i++) {
        sideListItem += `<li class='mt-3 pb-2 border-bottom side-list-item'><a class='h6 text-dark text-decoration-none' id='sideQue${i + 1}' value='${i}'>${data[i].snippet}</a></li>`
    }


    $('.sideList').html(sideListItem);
}

/**

This function dynamically generates the answer options for a quiz question.
@returns {void} - This function does not return anything, but uses jQuery to update the HTML of the corresponding DOM element.
The function loops through the array of answer options for the current quiz question (which is stored in the global 'questionAnswers' variable).
For each answer option, it generates an HTML input element of type 'radio', with an ID and value corresponding to the answer option ID.
It also generates a label element for the input element, which displays the answer option text.
The function then appends the input and label elements to the HTML of the corresponding DOM element.
*/
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