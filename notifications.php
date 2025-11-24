<?php 
    session_start();
    require_once "config.php";

    if(isset($_SESSION['id'])){
        $id = $_SESSION['id'];

        $i        = 0;
        $messages = [];

        $stmt = mysqli_prepare($conn, "SELECT cm.*,
                                            u.name,
                                            ui.path FROM contact_messages cm LEFT JOIN users u ON  u.id = cm.answered
                                                                            LEFT JOIN user_imgs ui ON ui.user_id = cm.answered WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['answered']) {
                $messages[$i]['id']          = $row['id'];
                $messages[$i]['subject']     = $row['subject'];
                $messages[$i]['answer']      = $row['answer'];
                $messages[$i]['whoAnsweredName'] = $row['name'];

                if (!empty($row['path'])) {
                    $messages[$i]['whoAnswered'] = $row['path'];
                } else {
                    $messages[$i]['whoAnswered'] = "imgs/icons/user.svg";
                }
                $i++;
            }
        }
    }else{
        header("Location: login.php");
        exit;
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

    <link rel="stylesheet" href="styles/shared.css">
    <link rel="stylesheet" href="styles/notifications.css">
</head>
<body>
    <?php require_once "nav.php" ?>
    <main>
        <div class="text">
            <h1>Notifications</h1>
            <p>There will be displayed all your notifications</p>
        </div>
        <div class="messages">
        <?php foreach ($messages as $i => $message) {
            $msg = $messages[$i]; 
            
            echo "
                <div class='message' 
                    data-id='{$msg['id']}' 
                    data-subj='" . htmlspecialchars($msg['subject'], ENT_QUOTES) . "' 
                    data-answer='" . htmlspecialchars($msg['answer'], ENT_QUOTES) . "' 
                    data-answeredimg='" . htmlspecialchars($msg['whoAnswered'], ENT_QUOTES) . "' 
                    data-answered='" . htmlspecialchars($msg['whoAnsweredName'], ENT_QUOTES) . "'>
                    
                    <img class='profile-pic-little' src='" . htmlspecialchars($msg['whoAnswered'], ENT_QUOTES) . "'>
                    <div class='answered-box'>
                        <p class='answered'>" . htmlspecialchars($msg['whoAnsweredName']) . "</p>
                        <p class='text'>Replyed on <span class='subject'>" . htmlspecialchars($msg['subject']) . "</span></p>
                    </div>
                </div>
            ";
        }?>
        </div>
    </main>
    <script src="scripts/notifications.js"></script>
</body>
</html>
