<html>

<head>
    <title>Test Page</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <script>


        window.history.forward();
        function noBack() {
            window.history.forward();
        }
    </script>

    <link rel="stylesheet" href="main.css">

</head>

<body>
    <div class='p-2'>
        <div class='row w-100'>
            <div class='col-2'>
                <a href='index.php' tabindex='-1'><img id='reset'
                        src='https://www.ucertify.com/layout/themes/bootstrap4/images/logo/ucertify_logo.png'></a>
            </div>

            <div class='col-8'>
                <h1 class='text-center'>uCertify Test Prep</h1>
            </div>
        </div>

    </div>


    <div class="container">

        <!-- side panel START-->
        <div id="local-navbar" class="local-navbar card card-body bg-light">
            <!-- <h1 class='badge badge-primary badge-pill w-50 mt-3 mb-0 h-50 h1'>0 Attempted</h1> -->
            <div class='btn-group border-bottom border-light'>
                <!-- <center>
                <h5><span class='badge badge-primary mr-3'>0 Attempted</span></h5>
                <h5><span class='badge badge-warning'>0 Unattempted</span></h5>
                </center> -->
            <button tabindex="-1" class='btn btn-success btn-sm w-25 mt-3 mr-2 rounded mb-2'><strong><span id='listAttempted'>0</span> Attempted</strong></button>
            <button tabindex="-1" class='btn btn-danger text-white btn-sm w-25 mt-3 rounded mb-2'><strong><span id='listUnattempted'>11</span> Unattempted</strong></button>
            
            </div>
            <ol class='mb-0 sideList'>
            </ol>
        </div>

        <!-- side panel END-->



        <form class='mt-5'>
            <p><strong class='queNo'>01</strong>. <span id='displayQuestion'>Question</span></p>

            <div class='options'>

            </div>




        </form>


        <div class="d-flex justify-content-end fixed-bottom bg-light py-3 border-top border-dark">

            <div class='mr-5'>
                <button tabindex="-1" class='countdown px-4 mx-2 border-0 bg-transparent'><span id='timer'
                        class='js-timeout'>30:00</span></button>

                <button id='slide-button' class='px-4 mx-2 py-2 btn btn-success slide-button'>List</button>
                <button id='prev' class='px-4 mx-2 py-2 btn btn-outline-primary'>Previous</button>

                <button tabindex="-1" class='border-0 bg-transparent'><span class='queNo'>01</span> of <span
                        class='totalQue'>11</span></button>

                <button id='next' class='px-4 mx-2 py-2 btn btn-outline-primary'>Next</button>
                <button id='endTest' class='px-4 mx-2 py-2 btn btn-danger' data-toggle="modal"
                    data-target="#myModal">End Test</button>
            </div>



        </div>


        <!-- end test Modal START -->

        <div class="modal fade" id="myModal">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h4 class="modal-title">End test?</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body py-2">
                        <div class='row'>
                            <div class='col-12 text-center'>Do you wish to end this test?</div>
                        </div>
                        <div class='row mt-3'>
                            <div class='col-4 text-center'>
                                <h3 class='displayItems'>0</h3><span>Items</span>
                            </div>
                            <div class='col-4 text-center'>
                                <h3 class='displayAttempted'>0</h3><span>Attempted</span>
                            </div>
                            <div class='col-4 text-center'>
                                <h3 class='displayUnattempted'>0</h3><span>Unattempted</span>
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning text-white" data-dismiss="modal">Close</button>
                        <a id='finalEndTest' href='resultPage.php' class='btn btn-danger'>End Test</a>
                    </div>

                </div>
            </div>

        </div>




        <!-- end test Modal END -->
    </div>



    <!-- </div> -->


    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
        <script src ="index.js"> </script>   

    <script>
        let timer2 = "30:00";



        let interval = setInterval(function () {


            let timer = timer2.split(':');
            //by parsing integer, I avoid all extra string processing
            let minutes = parseInt(timer[0], 10);
            let seconds = parseInt(timer[1], 10);
            --seconds;
            minutes = (seconds < 0) ? --minutes : minutes;
            if (minutes < 0 && seconds == 00) clearInterval(interval);
            seconds = (seconds < 0) ? 59 : seconds;
            seconds = (seconds < 10) ? '0' + seconds : seconds;
            //minutes = (minutes < 10) ?  minutes : minutes;
            $('#timer').html(minutes + ':' + seconds);
            timer2 = minutes + ':' + seconds;

            if (minutes == '0' && seconds == '00') {


                $('#endTest').click();
                window.location.href = "resultPage.php";

                $(location).attr('href', 'resultPage.php');
                clearInterval(interval);
            }
        }, 1000);

        
        let jsindex = 0;
        

        $.getJSON('question.json', function (data) {

            // fetch que answers for que 1
            questionAnswer(data);
            // display question 1
            displayQuestion();

        


            // display totalQue
            $('.totalQue').text(data.length <= 9 ? `0${data.length}` : data.length);

            // make options dynamically START
                createOptions();

            // make options dynamically END


            // display options for que 1
            displayOption();




            // disable prev button on 1st page
            disableEnableButton();





            $('#next').on('click', function () {

                if (jsindex < data.length - 1) {
                    jsindex++;

                    // uncheck all options
                    unCheckOptions();


                    // fetch questionAnswers
                    questionAnswer(data);

                    // display question
                    displayQuestion();


                    // display options when click on next
                    displayOption();

                    // sideQue highlight START

                    // remove highlighting from all sideListItems when clicked on next
                    removeSideListHighlight(data);

                    // add highlighting
                    addSideListHighlight(`#sideQue${jsindex + 1}`);


                    // display queNo.
                    displayQueNo();


                    // persisting values
                    persistUserOptions();

                    // disableEnable next/prev button
                    disableEnableButton(data);

                }

            });

            $('#prev').on('click', function () {
                if (jsindex > 0) {
                    jsindex--;

                    // uncheck all options
                    unCheckOptions();

                    // fetch questionAnswers
                    questionAnswer(data);

                    // display question
                    displayQuestion();

                    // display options when clicked on prev button
                    displayOption();

                    // sideQue highlight START
                    // remove highlighting from all sideListItems when clicked on prev button
                    removeSideListHighlight(data);

                    // add highlight when clicked on prev
                    addSideListHighlight(`#sideQue${jsindex + 1}`);
                    // sideQue highlight END

                    // persisting user option
                    persistUserOptions();

                    // display queNo.
                    displayQueNo();


                    // disableEnable next/prev button
                    disableEnableButton(data);
                }

            });

            // side panel
            $('#slide-button').click(function () {
                $('#local-navbar').toggleClass('show');
            });

            //    display side panel questions
            displaySidePanelQue(data);




            // change color of 1st side que
            addSideListHighlight('#sideQue1');


            let listItem = $('a');

            $('a').on('click', function (e) {





                // uncheck all options
                unCheckOptions();

                $('#slide-button').click();



                jsindex = (Number)($(e.target).attr('value'));

                // fetch questionAnswers
                questionAnswer(data);

                // sideQue highlight START
                // remove highlighting from all sideListItems when clicked on sideListItem
                removeSideListHighlight(data);


                // add highlight to clicked sideListItem
                addSideListHighlight(e.target);
                // sideQue highlight END

                // display question
                displayQuestion();



                // display option when clicked on sideListItem
                displayOption();

                // persist user options
                persistUserOptions();

                // display queNo.
                displayQueNo();

                // disableEnable prev/next button
                disableEnableButton(data);
            })




            // hide sideList when clicked outside START

            window.addEventListener('click', function (e) {
                let _opened = $('#local-navbar').hasClass('show');

                if (_opened === true && !document.getElementById('local-navbar').contains(e.target) && !document.getElementById('slide-button').contains(e.target)) {
                    // Clicked in box


                    $('#local-navbar').toggleClass('show')



                }
            });
            // hide sideList when clicked outside END


            // CHECKING OPTIONS START

            // collecting options
            let correct_answers = [];
            for (let i = 0; i < data.length; i++) {
                questionAnswers = JSON.parse(data[i].content_text);


                for (let j = 0; j < questionAnswers.answers.length; j++) {
                    if (questionAnswers.answers[j].is_correct == 1) {


                        correct_answers.push(questionAnswers.answers[j].id);
                    }
                }
            }


            let user_answers = JSON.parse(sessionStorage.getItem('user_answers')) ? JSON.parse(sessionStorage.getItem('user_answers')) : [];

            let filtered_user_answers = [];
            let attempted = 0;
            let listAttempted = 0;

            filtered_user_answers = user_answers.filter(Boolean);

            $('#listAttempted').text(filtered_user_answers.length);
            $('#listUnattempted').text(data.length - filtered_user_answers.length);


            $('.answer_input').on('click', function (e) {


                user_answers[jsindex] = $(e.target).attr('value');


                filtered_user_answers = user_answers.filter(Boolean);



                attempted = filtered_user_answers.length;

                // setsession strorge when options are clicked
                sessionStorage.setItem('user_answers', JSON.stringify(user_answers));

                //  listAttempted = filtered_user_answers.length;

                $('#listAttempted').text(attempted);

                $('#listUnattempted').text(data.length - attempted);



            });


            // check options
            // CHECKING OPTIONS END

            // final end test link / sessionStorage

            $('#endTest').on('click', function () {

                // render question count
                $('.displayItems').text(data.length);
                $('.displayAttempted').text(attempted);
                $('.displayUnattempted').text(data.length - attempted);

                // storing correct_answers in session storage 
                sessionStorage.setItem('user_answers', JSON.stringify(user_answers));
                sessionStorage.setItem('correct_answers', JSON.stringify(correct_answers));



            });

            // persist user_option for que 1
            persistUserOptions();

            // session reset
            $('#reset').on('click', function () {
                sessionStorage.clear();

            });


        

        });

        const now = new Date();
        const options = { day: '2-digit', month: '2-digit', year: '2-digit', hour: '2-digit', minute:'2-digit'};
        const testDate = now.toLocaleString('en-GB', options);
        // console.log(testDate); // output: "02-04-23 11:30"

        sessionStorage.setItem('testDate', testDate);


    </script>

 

</body>

</html>