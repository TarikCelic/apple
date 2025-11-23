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

    <div class="backdrop">
        <div class="hambi-navigation">
            <div class="hn-first">
                <a href="index.php">
                    <img src="imgs\icons\logo_black.svg" width="45" alt="">
                </a>
                <div class="leave-nav">
                    <img src="imgs\icons\x.svg" width="45" alt="">
                </div>
            </div>
            <div class="hn-second">
                <ul>
                    <li><a class="nav-link" href="">Store <img src="imgs\icons\goto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">Mac <img src="imgs\icons\goto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">iPad <img src="imgs\icons\goto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">iPhone <img src="imgs\icons\goto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">Watch <img src="imgs\icons\goto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">Vision <img src="imgs\icons\goto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">AirPods <img src="imgs\icons\goto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">TV & Home <img src="imgs\icons\goto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">Entertainment <img src="imgs\icons\goto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">Accesories <img src="imgs\icons\goto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">Support <img src="imgs\icons\goto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" style="margin-top:2rem" href="bag.php">Bag <img src="imgs\icons\bag.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">Search <img src="imgs\icons\search.svg" width="25" alt=""></a></li>
                </ul>
            </div>
        </div>
    </div>
    <nav>
        <a class="logo" href="index.php">
            <img src="imgs\icons\logo_black.svg" width="27" alt="">
        </a>
        <ul>
            <li><a class="nav-link" href="">Store</a></li>
            <li><a class="nav-link" href="">Mac</a></li>
            <li><a class="nav-link" href="">iPad</a></li>
            <li><a class="nav-link" href="">iPhone</a></li>
            <li><a class="nav-link" href="">Watch</a></li>
            <li><a class="nav-link" href="">Vision</a></li>
            <li><a class="nav-link" href="">AirPods</a></li>
            <li><a class="nav-link" href="">TV & Home</a></li>
            <li><a class="nav-link" href="">Entertainment</a></li>
            <li><a class="nav-link" href="">Accesories</a></li>
            <li><a class="nav-link" href="">Support</a></li>
        </ul>

        <div class="nav-right">
            <a href="" class="search nav-icon">
                <img src="imgs\icons\search.svg" width="25rem" alt="">
            </a>
            <a href="bag.php" class="bag nav-icon">
                <img src="imgs\icons\bag.svg" width="25rem" alt="">
            </a>
        </div>
        <div class="hambi">
            <img src="imgs/icons/hambi.svg" width="25rem" alt="">
        </div>
    </nav>

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
                                  echo $username;
                          }
                          ?>" class="input" type="text" name="name" placeholder="Your full name" >
            <?php
                if (isset($errors['name'])) {
                    echo '<p class="error">' . $errors['name'] . '</p>';
                }
            ?>
            <input value="<?php if (isset($email)) {
        echo $email;
}
?>" class="input" type="email" name="email" placeholder="Your email" >
                    <?php
                        if (isset($errors['email'])) {
                            echo '<p class="error">' . $errors['email'] . '</p>';
                        }
                    ?>
            <input value="<?php if (isset($subject)) {
        echo $subject;
}
?>" class="input" type="text" name="subject" placeholder="Subject" >
            <?php
                if (isset($errors['subject'])) {
                    echo '<p class="error">' . $errors['subject'] . '</p>';
                }
            ?>
            <textarea value="<?php if (isset($message)) {
        echo $message;
}
?>" class="input" name="message" placeholder="Your message..." ></textarea>
            <?php
                if (isset($errors['message'])) {
                    echo '<p class="error">' . $errors['message'] . '</p>';
                }
            ?>
            <input class="submit" name="send-msg" type="submit" value="Send Message">
        </form>
    </div>

    <?php endif; ?>


    <script src="scripts/navigation.js"></script>
    </body>
</html>
