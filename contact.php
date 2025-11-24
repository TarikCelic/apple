<?php
    session_start();
    require_once "config.php";

    $errors = [];
    if (isset($_POST['send-msg'])) {
        $username = htmlspecialchars($_POST['name']);
        $email    = htmlspecialchars($_POST['email']);
        $subject  = htmlspecialchars($_POST['subject']);
        $message  = htmlspecialchars($_POST['message']);

        if (empty($username) || empty($email) || empty($subject) || empty($message)) {
            $errors['general'] = "Please fill all fields";
        } else {
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Wrong E-Mail format.";
            }
            if (strlen($subject) > 100) {
                $errors['subject'] = "Subject is too long.";
            }
            if (strlen($username) > 25) {
                $errors['name'] = "Name is too long.";
            }
            if (strlen($message) > 2000) {
                $errors['message'] = "Message is too long.";
            }
        }

        if (empty($errors)) {
            $id   = $_SESSION['id'];
            $stmt = mysqli_prepare($conn, "INSERT INTO contact_messages (user_id,name,email,subject,message) VALUES (?,?,?,?,?)");
            mysqli_stmt_bind_param($stmt, "issss", $id, $username, $email, $subject, $message);
            mysqli_stmt_execute($stmt);

            $_SESSION['succeseful'] = true;
            $_SESSION['msg']        = "You will get answer as soon as possible";

            header("Location: index.php");
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

    <link rel="stylesheet" href="styles/shared.css">
    <link rel="stylesheet" href="styles/contact.css">
</head>
<body>

    <?php require_once "nav.php" ?>
    <?php if (! isset($_SESSION['id'])): ?>

        <div class="error-msg">
            <h1>Sign in to continue</h1>
            <p>To contact us, please <a href="login.php" class="text-blue-600 hover:underline">log in</a> or <a href="register.php" class="text-blue-600 hover:underline">create an account</a> to continue. It only takes a minute!</p>
        </div>

    <?php else: ?>

    <div class="form">
        <h1>Contact formular</h1>
        <p>We will respond as fastest as possible</p>
            <?php
                if (isset($errors['general'])) {
                    echo '<p class="error">' . $errors['general'] . '</p>';
                }
            ?>
        <form action="contact.php" method="POST">

            <input value="<?php if (isset($username)) {
                                  echo htmlspecialchars($username);
                          }
                          ?>" class="input" type="text" name="name" placeholder="Your full name" >
            <?php
                if (isset($errors['name'])) {
                    echo '<p class="error">' . $errors['name'] . '</p>';
                }
            ?>
            <input value="<?php if (isset($email)) {
        echo htmlspecialchars($email);
}
?>" class="input" type="email" name="email" placeholder="Your email" >
                    <?php
                        if (isset($errors['email'])) {
                            echo '<p class="error">' . $errors['email'] . '</p>';
                        }
                    ?>
            <input value="<?php if (isset($subject)) {
        echo htmlspecialchars($subject);
}
?>" class="input" type="text" name="subject" placeholder="Subject" >
            <?php
                if (isset($errors['subject'])) {
                    echo '<p class="error">' . $errors['subject'] . '</p>';
                }
            ?>
            <textarea class="input" name="message" placeholder="Your message..." ><?php if (isset($message)) {
        echo htmlspecialchars($message);
}
?></textarea>
            <?php
                if (isset($errors['message'])) {
                    echo '<p class="error">' . $errors['message'] . '</p>';
                }
            ?>
            <input class="submit" name="send-msg" type="submit" value="Send Message">
        </form>
    </div>

    <?php endif; ?>

    </body>
</html>
