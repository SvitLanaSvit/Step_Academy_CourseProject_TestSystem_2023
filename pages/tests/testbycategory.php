<div class="container p-3" style="background-color: rgba(47, 79, 79, 0.8); border-radius: 10px; 
/*user-select:none; -moz-user-select:none; -webkit-user-select:none; -ms-user-select:none; */
">
    <?
    include_once('/OSPanel/domains/CourseProject/functions/functions.php');
    if (isset($_GET['category'])) {
        session_start();
        $category = $_GET['category'];
        if (!isset($_SESSION['randomQuestion'])) {
            $randomQuetions = getAllQuestionsIsNotBlockedLanguageRandom($category);
            $_SESSION['randomQuestion'] = $randomQuetions;
        } else {
            $randomQuetions = $_SESSION['randomQuestion'];
        }

        $totalQuestions = count($randomQuetions);

        // Get the current date in 'YYYY-MM-DD' format
        $dateOfTest = date('Y-m-d');

        //Get category id by category name for result
        $categoryId = getCategoryId(ucfirst($category));

        // Initialize the question index to 0 (first question)
        $questionIndex = 0;
        $correctAnswer = 0;

        //Get userId from session
        $userId = $_SESSION['id'];

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the selected answer for the current question
            $questionId = $_POST['questionId'];
            $selectedAnswerId = $_POST['answer'];
            $questionIndex = $_POST['questionIndex'];
            $correctAnswer = $_POST['correctAnswer'];

            $answer = getAnswerById($selectedAnswerId);
            $isRealAnswer = intval($answer['IsRealAnswer']);
            if ($isRealAnswer === 1) {
                $correctAnswer++;
            }

            $_SESSION['answers'][$questionId] = $selectedAnswerId;
            $questionIndex++;

            if ($questionIndex >= $totalQuestions) {
                echo "<h3>Quiz Completed</h3>";
                $result = $correctAnswer;
                $i = 1;
                foreach ($_SESSION['answers'] as $questionId => $selectedAnswerId) {
                    // echo "<h4>Question ID: $questionId, Selected Answer ID: $selectedAnswerId</h4>";
                    echo "<h4>$i. Question: </h4>";
                    $question = getQuestionById($questionId);
                    echo "<p>$question[Question]</p>";
                    if ($question['ImagePath'] != null) {
                        echo "<img src='$question[ImagePath]' style='width: 350px; height: auto;' alt='question_id_$questionId'>";
                    }
                    echo "<h4 class='mt-3'>Selected answer: </h4>";
                    $myAnswer = getAnswerById($selectedAnswerId);
                    if (intval($myAnswer['IsRealAnswer']) === 1) {
                        if ($myAnswer['AnswerText'] != null) {
                            echo "<div class='alert alert-success w-50'>
                                    <p style='color: green;'>$myAnswer[AnswerText]</p>
                                </div>";
                        }
                        else if($myAnswer['AnswerPhoto'] != null){
                            echo "<div class='alert alert-success w-50'>
                                    <img src='$myAnswer[AnswerPhoto]' style='width: 200px; height: auto;' alt='answer_id_$myAnswer[Id]'>
                                </div>";
                        }
                    }
                    else{
                        if ($myAnswer['AnswerText'] != null) {
                            echo "<div class='alert alert-danger w-50'>
                                    <p style='color: red;'>$myAnswer[AnswerText]</p>
                                </div>";
                        }
                        else if($myAnswer['AnswerPhoto'] != null){
                            echo "<div class='alert alert-danger' w-50>
                                    <img src='$myAnswer[AnswerPhoto]' style='width: 200px; height: auto;' alt='answer_id_$myAnswer[Id]'>
                                </div>";
                        }

                        echo "<h4>Real answer:</h4>";
                        $row = getRealAnswerByQuestionId($questionId);
                        if ($row['AnswerText'] != null) {
                            echo "<div class='alert alert-success w-50'>
                                    <p style='color: green;'>$row[AnswerText]</p>
                                </div>";
                        }
                        else if($row['AnswerPhoto'] != null){
                            echo "<div class='alert alert-danger w-50'>
                                    <img src='$row[AnswerPhoto]' alt='answer_id_$row[Id]'>
                                </div>";
                        }
                    }
                    $i++;
                    echo "<hr style='border: 1px solid white; opacity: 1'>";
                }
                writeResultToSQLFromTest($userId, $categoryId, $dateOfTest, $result);
                unset($_SESSION['randomQuestion']);
                unset($_SESSION['answers']);
            }
        }

        if ($questionIndex < $totalQuestions) {
            $currentQuestion = $randomQuetions[$questionIndex];
            $ps = getAnswerByQuestionId($currentQuestion['IdQuestion']);
            $answers = $ps->fetchAll();
    ?>
            <h3><?= strtoupper($category) ?></h3>
            <div class="container">
                <form method="POST" id="questionForm" enctype="multipart/form-data">
                    <input type="hidden" name="questionId" id="questionId" value="<?= $currentQuestion['IdQuestion'] ?>">
                    <input type="hidden" name="questionIndex" id="questionIndex" value="<?= $questionIndex ?>">
                    <input type="hidden" name="correctAnswer" id="correctAnswer" value="<?= $correctAnswer ?>">
                    <div class="mb-3">
                        <div id="question">
                            <p><?= $currentQuestion['Question'] ?></p>
                        </div>
                    </div>
                    <?
                    if ($currentQuestion['ImagePathQuestion'] != null) {
                        $imagePath = $currentQuestion['ImagePathQuestion'];
                    ?>
                        <img style="max-width: 350px; height:auto" src="<?= $imagePath ?>" alt="current_question_id_<?= $currentQuestion['IdQuestion'] ?>">
                    <?
                    }
                    ?>
                    <div class="mb-3 mt-2">
                        <p>Choose one answer:</p>
                    </div>
                    <?
                    $i = 1;
                    foreach ($answers as $answer) :
                    ?>
                        <div class="mb-3 d-flex">
                            <div style="margin-right: 10px;">
                                <p><?= $i ?>.</p>
                            </div>
                            <div>
                                <?
                                if ($answer['AnswerText'] != null) {
                                ?>
                                    <input type="radio" name="answer" value="<?= $answer['AnswerId'] ?>" class="form-check-input" required>
                                    <label for="textAnswer" class="form-check-label"><?= $answer['AnswerText'] ?></label>
                                <? } else
                            if ($answer['AnswerPhoto'] != null) {
                                ?>
                                    <input type="radio" name="answer" value="<?= $answer['AnswerId'] ?>" class="form-check-input" required>
                                    <label for="photoAnswer" class="form-check-label">
                                        <img style="max-width: 350px; height:auto" src="<?= $answer['AnswerPhoto'] ?>" alt="answer_id_<?= $answer['AnswerId'] ?>">
                                    </label>
                                <?
                                }
                                ?>
                            </div>
                        </div>
                    <?
                        $i++;
                    endforeach;
                    ?>
                    <button class="btn btn-warning" type="submit" name="next">Next</button>
                </form>
            </div>
    <?
        }
    }
    ?>
</div>