<?php
    session_start();
    require_once "config.php";

    $id = $_SESSION['id'];

    $i        = 0;
    $messages = [];

    $stmt = mysqli_prepare($conn, "SELECT * FROM contact_messages WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['answered']) {
            $messages[$i]['id']          = $row['id'];
            $messages[$i]['subject']     = $row['subject'];
            $messages[$i]['answer']      = $row['answer'];
            $messages[$i]['whoAnswered'] = $row['answered'];

            $whoAnswered = $messages[$i]['whoAnswered'];

            $stmt2 = mysqli_prepare($conn, "SELECT path FROM user_imgs WHERE user_id = ?");
            mysqli_stmt_bind_param($stmt2, "i", $whoAnswered);
            mysqli_stmt_execute($stmt2);
            $result2 = mysqli_stmt_get_result($stmt2);

            $stmt3 = mysqli_prepare($conn, "SELECT name FROM users WHERE id = ?");
            mysqli_stmt_bind_param($stmt3, "i", $whoAnswered);
            mysqli_stmt_execute($stmt3);
            $result3                         = mysqli_stmt_get_result($stmt3);
            $nameAnswerer                    = mysqli_fetch_assoc($result3);
            $messages[$i]['whoAnsweredName'] = $nameAnswerer['name'];

            if (mysqli_num_rows($result2) > 0) {
                $user                        = mysqli_fetch_assoc($result2);
                $messages[$i]['whoAnswered'] = $user['path'];
            } else {
                $messages[$i]['whoAnswered'] = "imgs/icons/user.svg";
            }

            $i++;
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
    <link rel="stylesheet" href="styles/notifications.css">
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
            <?php if (isset($_SESSION['id'])): ?>
                <div class="user-menu">
                    <img src="imgs\icons\user.svg" width ="25" alt="">

                    <div class="user-dropdown">
                        <div class="user-about">
                            <div class="user-img">
                                <img src=<?php echo $_SESSION['img'] ?> class="profile-pic-little" alt="">
                            </div>
                            <div class="user-name-n-r">
                                <p class="name"><?php echo $_SESSION['username'] ?></p>

                                <?php if ($_SESSION['perm'] == 1): ?>
                                <p class="role r-s">Supporter</p>
                                <?php elseif ($_SESSION['perm'] == 2): ?>
                                <p class="role r-a">Administrator</p>
                                <?php elseif ($_SESSION['perm'] == 3): ?>
                                <p class="role r-sa">Super Administrator</p>
                                <?php elseif ($_SESSION['perm'] == 4): ?>
                                <p class="role r-g">💩Govance</p>

                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="account.php" class="um-item">
                            <div class="left-um-item">
                                <img src="imgs/icons/manage.svg" width="20" alt="">
                                Manage Account
                            </div>
                            <img src="imgs\icons\goto.svg" width="25"  alt="">
                        </a>
                        <a class="um-item">
                            <div class="left-um-item">
                                <img src="imgs/icons/notifications.svg" width="20" alt="">
                                Notifications
                            </div>
                            <img src="imgs\icons\goto.svg" width="25"  alt="">
                        </a>
                        <a class="um-item">
                            <div class="left-um-item">
                                <img src="imgs/icons/help.svg" width="20" alt="">
                                Help and Support
                            </div>
                            <img src="imgs\icons\goto.svg" width="25"  alt="">
                        </a>
                        <?php if ($_SESSION['perm'] > 0): ?>
                        <a href="dashboard.php" class="um-item">
                            <div class="left-um-item">
                                <img src="imgs/icons/dashboard.svg" width="20" alt="">
                                Dashboard
                            </div>
                            <img src="imgs\icons\goto.svg" width="25"  alt="">
                        </a>
                        <?php endif; ?>
                        <hr>
                        <a href="logout.php" class="um-item">
                            <div href="logout.php" class="left-um-item">
                                <img src="imgs/icons/logout.svg" width="20" alt="">
                                Log out
                            </div>
                            <img src="imgs\icons\goto.svg" width="25"  alt="">
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        <div class="hambi">
            <img src="imgs/icons/hambi.svg" width="25rem" alt="">
        </div>
        </div>
    </nav>
    <main>
        <div class="text">
            <h1>Notifications</h1>
            <p>There will be displayed all your notifications</p>
        </div>
        <div class="messages">
            <?php foreach ($messages as $i => $message) {
                    echo "
                        <div class='message' data-id='{$messages[$i]['id']}' data-subj='{$messages[$i]['subject']}' data-answer='{$messages[$i]['answer']}' data-answeredimg='{$messages[$i]['whoAnswered']}' data-answered='{$messages[$i]['whoAnsweredName']}'>
                            <img class='profile-pic-little' src='{$messages[$i]['whoAnswered']}'>
                            <div class='answered-box'>
                                <p class='answered'>{$messages[$i]['whoAnsweredName']}</p>
                                <p class='text'>Replyed on <span class='subject'>{$messages[$i]['subject']}</span></p>
                            </div>
                        </div>
                ";
            }?>
        </div>
    </main>
    <script src="scripts/notifications.js"></script>
    <script src="scripts/navigation.js"></script>
</body>
</html>
