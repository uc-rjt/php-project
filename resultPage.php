<html>

<head>
    <title>Result Page</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
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

        <h2 class='text-center border-bottom border-dark py-4'>
            Test Results
        </h2>

        <div class='row mt-3'>
            <!-- <div class='col-12'> -->
            <div class='d-flex justify-content-center col-12'>
                <button class='col-2 btn btn-lg btn-basic mx-1 bg-light border border-primary'>
                    <div class='text-info displayResult'>0%</div><span class='text-dark'>Result</span>
                </button>
                <button class='col-2 btn btn-lg btn-basic mx-1 bg-light border border-primary'>
                    <div class='text-primary displayItems'>0</div><span class='text-dark'>Items</span>
                </button>
                <button class='col-2 btn btn-lg btn-basic mx-1 bg-light border border-primary'>
                    <div class='text-success displayCorrect'>0</div><span class='text-dark'>Correct</span>
                </button>
                <button class='col-2 btn btn-lg btn-basic mx-1 bg-light border border-primary'>
                    <div class='text-danger displayIncorrect'>0</div><span class='text-dark'>Incorrect</span>
                </button>
                <button class='col-2 btn btn-lg btn-basic mx-1 bg-light border border-primary'>
                    <div class='text-warning displayUnattempted'>0</div><span class='text-dark'>Unattempted</span>
                </button>
                <!-- </div> -->

            </div>

        </div>

        <!-- result table START -->
        <table class='table table-striped mt-4'>

            <thead>
                <th>S.no.</th>
                <th>Question snippet</th>
                <th>Answer</th>
                <th>Status</th>
            </thead>

            <tbody>



            </tbody>


        </table>

        <!-- result table END -->

        <div class='d-flex justify-content-end'>

            <a href='index.php' class='btn my-2 mr-0 btn-warning btn-lg text-white clearSession'> Go
                Back</a>
        </div>


    </div>


    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>

    <script>


        var jsindex = 0;



        $.getJSON('question.json', function (data) {






            var correct_answers = JSON.parse(sessionStorage.getItem('correct_answers'));
            var user_answers = JSON.parse(sessionStorage.getItem('user_answers'));
            var filtered_user_answers = user_answers.filter(Boolean);

            var attempted = filtered_user_answers.length;



            // display elements

            $('.displayItems').text(data.length);

            $('.displayUnattempted').text(data.length - attempted);

            // correct answers
            var correct = 0;
            var incorrect = 0;
            for (var i = 0; i < data.length; i++) {
                if (user_answers[i] && correct_answers[i] == user_answers[i]) {
                    correct++;
                } else if (user_answers[i] && correct_answers[i] != user_answers[i]) {
                    incorrect++;
                }
            }



            // display correct
            $('.displayCorrect').text(correct);

            $('.displayIncorrect').text(incorrect);



            // reset session
            $('.clearSession').on('click', function () {

                sessionStorage.clear();

            });


            var percentage = (correct / data.length) * 100;



            var roundOffPercentage = Math.round(percentage * 100) / 100


            $('.displayResult').text(roundOffPercentage + '%');




            // display table
            var tabrow = ``;

            for (var i = 0; i < data.length; i++) {

                tabrow += `<tr><td>${(i + 1) <= 9 ? `0${i + 1}` : i + 1}</td><td><a href='reviewPage.php?que_index=${i}' class='text-dark text-decoration-none'>${data[i].snippet}</a></td><td class='text-center'>
    <span class='h6' id='option_${i}_1'>A</span> <span class='h6' id='option_${i}_2'>B </span> <span class='h6' id='option_${i}_3'>C </span> <span class='h6' id='option_${i}_4'>D </span </td><td>${user_answers[i] ? (user_answers[i] == correct_answers[i] ? 'Correct' : 'Incorrect') : 'Not attempted'

                    }</td></tr>`;

            }





            // render html table
            $('tbody').html(tabrow);

            // put green color to correct_answers
            // get options and extract index
            // convert index to a,b,c,d
            for (let i = 0; i < data.length; i++) {
                let questionAnswers = JSON.parse(data[i].content_text);



                for (let j = 0; j < questionAnswers.answers.length; j++) {
                    if (questionAnswers.answers[j].is_correct == 1) {





                        $(`#option_${i}_${j + 1}`).addClass('text-success');



                    } else if (questionAnswers.answers[j].is_correct != 1 && questionAnswers.answers[j].id == user_answers[i]) {
                        $(`#option_${i}_${j + 1}`).addClass('text-danger');

                    }




                }
            }







        });




    </script>


</body>

</html>