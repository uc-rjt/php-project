<html>

<head>
    <title>Review Page</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

        <link rel="stylesheet" href="main.css">

        <style>
                 #que_status {
            width: 20%;
        }
        </style>

</head>



<body>
    <div class='p-2'>
        <div class='row w-100'>
            <div class='col-2'>
                <a href='index.php' tabindex="-1"><img class='clearSession'
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
                        <ol class='mb-0 sideList'>
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
                            <a id='prev' class='px-4 mx-2 py-2 btn btn-outline-primary' href="#">Previous</a>

                            <button tabindex="-1" class='border-0 bg-transparent'><span class='queNo'>01</span> of <span
                                    class='totalQue'>11</span></button>

                            <a id='next' class='px-4 mx-2 py-2 btn btn-outline-primary' href="#
                            ">Next</a>
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

        <script src='index.js'></script>

    <script>

        let jsindex = 0;


        $.getJSON('question.json', function (data) {

            // fetch questionAnswers
            // questionAnswer(data);

            let queries = {};
            $.each(document.location.search.substr(1).split('&'), function (c, q) {
                let i = q.split('=');
                queries[i[0].toString()] = i[1].toString();
            });


            jsindex = Number(queries.que_index);

            // console.log('jsindex',jsindex);

            //   disable next-prev as per jsindex
            disableEnableButton(data);

            let questionAnswers = JSON.parse(data[jsindex].content_text);



            // display question status
            let user_answers = JSON.parse(sessionStorage.getItem('user_answers'));
            let correct_answers = JSON.parse(sessionStorage.getItem('correct_answers'));


            // display alert
            if (user_answers[jsindex] && user_answers[jsindex] == correct_answers[jsindex]) {
                $('#que_status').text('Correct').addClass('alert-success');
            } else if (!user_answers[jsindex]) {
                $('#que_status').text('Not attempted').addClass('alert-warning');
            } else {
                $('#que_status').text('Incorrect').addClass('alert-danger');

            }


            // display que. no.
            displayQueNo();

            // display question
             // fetch questionAnswers
             questionAnswer(data);
            displayQuestion();

            // make options dynamically START
            createOptions();
       






            // display options
            displayOption();


            let prevValue = user_answers[jsindex];
            let correctValue = correct_answers[jsindex];



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

            // create and display sideListItems
            // displaySidePanelQue(data); different
            let sideListItem = ``;

            for (let i = 0; i < data.length; i++) {
                sideListItem += `<li class='mt-3 pb-2 border-bottom side-list-item'><a tabindex='-1' class='h6 text-dark text-decoration-none' id='sideQue${i + 1}' href="reviewPage.php?que_index=${i}" value='${i}'>${data[i].snippet}</a></li>`
            }

            // $('ol').html(sideListItem);
            $('.sideList').html(sideListItem);

            // sideQue highlight START
            removeSideListHighlight(data);
           
            addSideListHighlight(`#sideQue${jsindex + 1}`);
           
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