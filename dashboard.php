<?php
    session_start();
    require_once "config.php";

    if (isset($_POST['answer-btn'])) {
        $answer      = $_POST['answer'];
        $id_question = $_POST['question_id'];

        $errors = [];
        $id     = $_SESSION['id'];

        if (empty($answer) || strlen($answer) < 2) {
            $erros['general'] = "Answer is too short";
        } else {
            $stmt = mysqli_prepare($conn, "UPDATE contact_messages SET answer = ? , answered = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "sii", $answer, $id, $id_question);
            mysqli_stmt_execute($stmt);

            header("Location: dashboard.php");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="styles/dashboard.css">
</head>
<body>
    <nav>
        <a href="index.php">
            <img src="imgs/icons/logo_black.svg" width="37" alt="">
        </a>
    </nav>
    <article>
        <div class="side-bar">
            <div class="side-item jsitem">
                <img src="imgs/icons/statistics.svg" width="30" alt="">
                Statistics
            </div>
            <div class="side-item jsitem">
                <img src="imgs/icons/messages.svg" width="30" alt="">
                Answer Questions
            </div>
            <div class="side-item jsitem">
                <img src="imgs/icons/bag.svg" width="30" alt="">
                Orders
            </div>
            <div class="side-item jsitem">
                <img src="imgs/icons/phone.svg" width="30" alt="">
                Add Product
            </div>
            <div class="side-item jsitem">
                <img src="imgs/icons/pen.svg" width="30" alt="">
                Edit Products
            </div>
            <div class="side-item special">
                <div class="top">
                    <div class="ls">
                        <img src="imgs/icons/page.svg" width="30" alt="">
                        Manage Pages
                    </div>
                    <img src="imgs/icons/arrow-btn.svg" class="arrow" width="20" alt="">
                </div>
                <div class="bottom">
                    <div class="side-item-many jsitem">
                        <img src="imgs/icons/goto.svg" width="20" alt="">
                        Home Page
                    </div>
                    <div class="side-item-many jsitem">
                        <img src="imgs/icons/goto.svg" width="20" alt="">
                        Shop
                    </div>
                </div>
            </div>
            <div class="side-item jsitem">
                <img src="imgs/icons/user.svg" width="30" alt="">
                Manage Users
            </div>
            <div class="side-item jsitem">
                <img src="imgs/icons/promotions.svg" width="30" alt="">
                Promotions
            </div>
            <div class="side-item jsitem">
                <img src="imgs/icons/log.svg" width="30" alt="">
                View Logs
            </div>
        </div>
        <div class="main">
            <h1>Apple Admin Dashboard</h1>
            <p class="intro">Be careful with changes</p>
        </div>
    </article>
    <div class="answerModal hide">
        <div class="ans-form">
            <div class="f-row-form">
                <p class="questionSubj"></p>
                <div class="lsls">
                <p class="questionAskd"></p>
                <p class="questionDate"></p>
            </div>
            </div>
            <p class="questionTxt"></p>
            <div class="s-row-form">
                <form action="dashboard.php" method="POST">
                    <label for="answertxt">Answer goes here:</label>
                    <textarea name="answer" value="answer" id="answertxt" placeholder="Answer goes here"></textarea>
                    <input class="question_id hide" type="hidden" name="question_id">
                    <input type="submit" value="Answer this question" name="answer-btn">

                </form>
                <button class="answer-later">Answer Later</button>
            </div>
        </div>
    </div>
    <script src="scripts/dashboard.js"></script>
</body>
</html>
