<html>

<head>
    <title>Review Page</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <style>
        seq:before {

            content: attr(no);

        }

        .form-check {
            pointer-events: none;
        }

        #que_status {
            width: 20%;
        }

        .local-navbar {
            /* background-color: #191E38; */
            border-radius: 0 .25rem .25rem 0;
            display: flex;
            flex-direction: column;
            padding-left: 2rem;
            padding-right: 2rem;
            padding-top: 0rem;
            position: absolute;
            left: -475px;
            transition: all .24s ease-in;
            width: 475px;
            font-size: 12px;
            position: absolute;
            overflow: scroll;
            z-index: 99;
            top: 0;
            height: 90vh;
        }

        .show {
            left: 0;
        }

        li {
            cursor: pointer;
        }

        ol {
            list-style-type: decimal-leading-zero;
        }

        ol>li::marker {
            font-weight: bold;
        }

        li:last-child {
            /* border-bottom: 2px solid red; */
            margin-bottom: none;
        }

        #local-navbar {
            overflow-x: hidden;
            padding-top: none;
        }
    </style>

</head>



<body>
    <div class='p-2'>
        <div class='row w-100'>
            <div class='col-2'>
                <a href='index.php'><img class='clearSession'
                        src='https://www.ucertify.com/layout/themes/bootstrap4/images/logo/ucertify_logo.png'></a>
            </div>

            <div class='col-8'>
                <h1 class='text-center'>uCertify Test Prep</h1>
            </div>
        </div>

    </div>

    <div class='container'>
        <div class='row mt-3'>
            <div class='col-12'>
                <center>
                    <h3 id='que_status' class='text-dark text-center rounded'></h3>
                </center>
            </div>

            <div class='row mt-3'>


                <div class='container'>

                    <!-- side panel START-->
                    <div id="local-navbar" class="local-navbar card card-body bg-light">
                        <ol class='mb-0'>
                        </ol>
                    </div>

                    <!-- side panel END-->

                    <form>
                        <p><strong class='queNo'></strong>. <span id='displayQuestion'></span></p>

                        <div class='options'>

                        </div>


                    </form>




                    <div class="d-flex justify-content-end fixed-bottom bg-light py-3 border-top border-dark">

                        <div class='mr-5'>
                            <button id='slide-button' class='px-4 mx-2 py-2 btn btn-success slide-button'>List</button>
                            <a id='prev' class='px-4 mx-2 py-2 btn btn-outline-primary'>Previous</a>

                            <button class='border-0 bg-transparent'><span class='queNo'>01</span> of <span
                                    class='totalQue'>11</span></button>

                            <a id='next' class='px-4 mx-2 py-2 btn btn-outline-primary'>Next</a>
                            <a id='results' class='px-4 mx-2 py-2 btn btn-danger' href='resultPage.php'>Results</a>
                            <a class='clearSession px-4 mx-2 py-2 btn btn-warning text-white' href='index.php'>Go
                                Back</a>
                        </div>



                    </div>

                </div>


            </div>

        </div>

        <div class='row mt-5'>
            <h3 class='float-left'>Explanation</h3>
        </div>
        <hr>

        <div class='row'>
            <p id='displayExplanation'>Explanation Paragraph</p>
        </div>

        <div class='row'>

            <div class='col-12'>

            </div>

        </div>



    </div>





    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>

    <script>

        var jsindex = 0;


        $.getJSON('question.json', function (data) {

            var queries = {};
            $.each(document.location.search.substr(1).split('&'), function (c, q) {
                var i = q.split('=');
                queries[i[0].toString()] = i[1].toString();
            });


            jsindex = Number(queries.que_index);

            //   disable next-prev as per jsindex
            if (jsindex == 0) {

                $('#prev').prop('disabled', true);
                $('#prev').addClass('disabled');
            } else if (jsindex == 10) {

                $('#next').prop('disabled', true);
                $('#next').addClass('disabled');

            }





            var questionAnswers = JSON.parse(data[jsindex].content_text);



            // display question status
            var user_answers = JSON.parse(sessionStorage.getItem('user_answers'));
            var correct_answers = JSON.parse(sessionStorage.getItem('correct_answers'));



            if (user_answers[jsindex] && user_answers[jsindex] == correct_answers[jsindex]) {
                $('#que_status').text('Correct').addClass('alert-success');
            } else if (!user_answers[jsindex]) {
                $('#que_status').text('Not attempted').addClass('alert-warning');
            } else {
                $('#que_status').text('Incorrect').addClass('alert-danger');

            }


            // display que. no.
            $('.queNo').text(jsindex + 1 <= 9 ? `0${jsindex + 1}` : jsindex + 1);

            // display question
            $('#displayQuestion').text(questionAnswers.question);

            // make options dynamically START
            let optionsHtml = ``;
            for (let i = 0; i < questionAnswers.answers.length; i++) {
                optionsHtml += `<div class="form-check">
        <label class="form-check-label">
            <input id='option_${i + 1}' type="radio" class="form-check-input" name="optradio"><span class='answer_input' id='displayOption${i + 1}'>Option ${i + 1}</span>
        </label>
        </div>
        `;

            }

            $('.options').append(optionsHtml);






            // display options
            for (let i = 0; i < questionAnswers.answers.length; i++) {
                $(`#displayOption${i + 1}`).html(questionAnswers.answers[i].answer);
                $(`#displayOption${i + 1}`).attr('value', questionAnswers.answers[i].id);
                $(`#option_${i + 1}`).val(questionAnswers.answers[i].id);
            }

            var prevValue = user_answers[jsindex];
            var correctValue = correct_answers[jsindex];



            for (let i = 0; i < questionAnswers.answers.length; i++) {






                // put green color to correct_answers
                if ($('.form-check-input')[i].value == correctValue) {



                    $(`#displayOption${i + 1}`).addClass('text-success');
                }

                if ($('.form-check-input')[i].value == prevValue) {

                    $('.form-check-input')[i].click();


                    if ($('.form-check-input')[i].value == correctValue) {
                        $(`#displayOption${i + 1}`).addClass('text-success');
                    }
                    if ($('.form-check-input')[i].value != correctValue) {
                        $(`#displayOption${i + 1}`).addClass('text-danger');
                    }


                }


            }

            // display Explanation

            $('#displayExplanation').html(questionAnswers.explanation);



            // reset session
            $('.clearSession').on('click', function () {

                sessionStorage.clear();

            });

            // next-prev functionality
            $('#next').on('click', function () {



                if (jsindex < data.length - 1) {
                    $('#next').attr('href', `reviewPage.php?que_index=${jsindex + 1}`);
                    // $('#next').click();


                }


            });

            $('#prev').on('click', function () {


                if (jsindex > 0) {
                    $('#prev').attr('href', `reviewPage.php?que_index=${jsindex - 1}`);

                }



            });

            // side panel
            $('#slide-button').click(function () {
                $('#local-navbar').toggleClass('show');
            });

            var sideListItem = ``;

            for (var i = 0; i < data.length; i++) {
                sideListItem += `<li class='mt-3 pb-2 border-bottom side-list-item'><a class='h6 text-dark text-decoration-none' id='sideQue${i + 1}' href="reviewPage.php?que_index=${i}" value='${i}'>${data[i].snippet}</a></li>`
            }

            $('ol').html(sideListItem);

            // sideQue highlight START

            for (let i = 0; i < data.length; i++) {
                $(`#sideQue${i + 1}`).removeClass('text-primary');
                $(`#sideQue${i + 1}`).addClass('text-dark');
            }

            $(`#sideQue${jsindex + 1}`).addClass('text-primary');
            $(`#sideQue${jsindex + 1}`).removeClass('text-dark');
            // sideQue highlight END

            // hide sideList when clicked outside START

            window.addEventListener('click', function (e) {
                let _opened = $('#local-navbar').hasClass('show');

                if (_opened === true && !document.getElementById('local-navbar').contains(e.target) && !document.getElementById('slide-button').contains(e.target)) {
                    // Clicked in box
                    $('#local-navbar').toggleClass('show')

                }
            });


        });







    </script>
</body>

</html>