<?php
    require_once "auth.php";
    require_once "config.php";

    $changes = false;
    $errors  = [];

    $stmt = mysqli_prepare($conn, "SELECT email FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $user  = mysqli_fetch_assoc($result);
    $email = $user['email'];

    if (isset($_POST['submit'])) {
        $id = $_SESSION['id'];

        if (! empty($_POST['newUsername'])) {
            $newUsername = htmlspecialchars($_POST['newUsername']);

            $stmt = mysqli_prepare($conn, "UPDATE users SET name = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "si", $newUsername, $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $_SESSION['username'] = $newUsername;
        }
        if (! empty($_POST['oldPw']) && ! empty($_POST['newPw'])) {
            $oldPw = $_POST['oldPw'];
            $newPw = $_POST['newPw'];

            if (strlen($newPw) < 8) {
                $errors['password'] = "Password must be at least 8 characters long.";
            } else {
                $stmt = mysqli_prepare($conn, "SELECT password FROM users WHERE id = ?");
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);

                $user        = mysqli_fetch_assoc($result);
                $hashedCheck = password_verify($oldPw, $user['password']);

                if (empty($errors)) {
                    if ($hashedCheck) {
                        $hashedNew = password_hash($newPw, PASSWORD_DEFAULT);
                        $stmt      = mysqli_prepare($conn, "UPDATE users SET password = ? WHERE id = ?");
                        mysqli_stmt_bind_param($stmt, "si", $hashedNew, $id);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);
                        $changes = true;
                    } else {
                        $errors['password'] = "Old password is incorrect.";
                    }
                }
            }
        }
        if (! empty($_POST['oldPw']) && empty($_POST['newPw'])) {
            $errors['password-confirm'] = "Passwords should match.";
        }
        if (empty($_POST['oldPw']) && ! empty($_POST['newPw'])) {
            $errors['password'] = "Passwords should't be empty.";
        }
        if (isset($_FILES['profileImg']) && $_FILES['profileImg']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['profileImg'];

            $fileName         = $file['name'];
            $fileTempLocation = $file['tmp_name'];
            $fileSize         = $file['size'];
            $fileError        = $file['error'];
            $fileExt          = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $uploadDir        = "imgs_users/";

            $maxFileSize = 10 * 1024 * 1024;
            $allowedExt  = ['jpg', 'jpeg', 'png', 'gif'];

            if ($fileSize > $maxFileSize) {
                $errors['file'] = "File is too large. The maximum allowed size is 10MB";
            }
            if (! in_array($fileExt, $allowedExt)) {
                $errors['file'] = "Disallowed file extension";
            }
            if (empty($errors)) {
                if (! file_exists($uploadDir) && ! is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $newFileName = "user-" . uniqid() . "-" . time() . "." . $fileExt;
                $destination = $uploadDir . $newFileName;

                $stmt = mysqli_prepare($conn, "SELECT * FROM user_imgs WHERE user_id = ?");
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    $userImg = mysqli_fetch_assoc($result);

                    if (file_exists($userImg['path'])) {
                        unlink($userImg['path']);
                    }

                    if (move_uploaded_file($fileTempLocation, $destination)) {

                        $stmt = mysqli_prepare($conn, "UPDATE user_imgs SET path = ? WHERE user_id = ?");
                        mysqli_stmt_bind_param($stmt, "si", $destination, $id);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);
                    }
                } else {
                    if (move_uploaded_file($fileTempLocation, $destination)) {
                        $stmt = mysqli_prepare($conn, "INSERT INTO user_imgs (path,user_id) VALUES (?,?) ");
                        mysqli_stmt_bind_param($stmt, "si", $destination, $id);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);
                    }
                }
                $changes = true;
            }
        }
        if ($changes) {
            $_SESSION['succeseful'] = true;
            $_SESSION['msg']        = "Profile updated successfully";
        }
        header("Location: account.php");
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
    <link rel="stylesheet" href="styles/account.css">
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
                                <?php endif; ?>
                            </div>
                        </div>
                        <a class="um-item">
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
                        <a class="um-item">
                            <div class="left-um-item">
                                <img src="imgs/icons/dashboard.svg" width="20" alt="">
                                Dashboard
                            </div>
                            <img src="imgs\icons\goto.svg" width="25"  alt="">
                        </a>
                        <?php endif; ?>
                        <hr>
                        <a href="logout.php" class="um-item">
                            <div class="left-um-item">
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

    <article>
        <div class="left-side">
            <img class="profile-pic" src=<?php echo $_SESSION['img'] ?> alt="">
            <div class="stats">
                <div class="li">
                    <img src="imgs\icons\purchase.svg" width="20rem" alt="">
                    <div class="res">
                        Purchased Products:
                        <span class="res-n">30</span>
                    </div>
                </div>
                <div class="li">
                    <img src="imgs\icons\wish.svg" width="20rem" alt="">
                    <div class="res">
                        Wishlist:
                        <span class="res-n">30</span>
                    </div>
                </div>
                <div class="li">
                    <img src="imgs\icons\review.svg" width="20rem" alt="">
                    <div class="res">
                        Reviews:
                        <span class="res-n">30</span>
                    </div>
                </div>
                <div class="li">
                    <img src="imgs\icons\question.svg" width="20rem" alt="">
                    <div class="res">
                        Asked Questions:
                        <span class="res-n">30</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-side">
            <div class="text-box">
                <h1><?php echo $_SESSION['username'] ?></h1>
                <p><?php echo $email ?></p>
                <button class="edit">Edit Profile</button>
                <div class="stats2">
                <div class="li">
                    <img src="imgs\icons\purchase.svg" width="20rem" alt="">
                    <div class="res">
                        Purchased Products:
                        <span class="res-n">30</span>
                    </div>
                </div>
                <div class="li">
                    <img src="imgs\icons\wish.svg" width="20rem" alt="">
                    <div class="res">
                        Wishlist:
                        <span class="res-n">30</span>
                    </div>
                </div>
                <div class="li">
                    <img src="imgs\icons\review.svg" width="20rem" alt="">
                    <div class="res">
                        Reviews:
                        <span class="res-n">30</span>
                    </div>
                </div>
                <div class="li">
                    <img src="imgs\icons\question.svg" width="20rem" alt="">
                    <div class="res">
                        Asked Questions:
                        <span class="res-n">30</span>
                    </div>
                </div>
            </div>
            </div>
            <hr>
            <div class="favourites">
                <h2>Favourites</h2>
                <div class="favs-items">
                    <p>There's nothing</p>
                </div>
            </div>
        </div>
    </article>
    <div class="over">
        <div class="form">
            <form method="POST" action="account.php" enctype="multipart/form-data">
                <div class="top">
                    <h2>Profile settings</h2>
                    <img src="imgs\icons/x.svg" width="40" alt="">
                </div>
                <input type="text" placeholder="New Username" name="newUsername" value="<?php if (isset($_SESSION['username'])) {
                                                                                                echo($_SESSION['username']);
                                                                                        }
                                                                                        ?>">
                <div class="change-img">
                    <div class="img-top">

                    Change Profile Picture
                    <img src="imgs/icons/user.svg" width="20" alt="">
                    </div>
                    <div class="img-bottom">
                      <label for="file-input" class="sr-only">Choose file</label>
                      <input type="file" name="profileImg" id="file-input" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400
                            file:bg-gray-50 file:border-0
                            file:me-4
                            file:py-3 file:px-4
                            dark:file:bg-neutral-700 dark:file:text-neutral-400">
                        <?php if (isset($errors['file'])): ?>
                        <p class="error"><?php echo $errors['file'] ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="change-pw">
                    <div class="pw-top">

                    Change Password
                    <img src="imgs/icons/pen.svg" width="20" alt="">
                    </div>
                    <div class="pw-bottom">
                        <input type="password" name="oldPw" placeholder="Old Password">
                        <?php if (isset($errors['password'])): ?>
                        <p class="error"><?php echo $errors['password'] ?></p>
                        <?php endif; ?>
                        <input type="password" name="newPw" placeholder="New Password">
                        <?php if (isset($errors['password-confirm'])): ?>
                        <p class="error"><?php echo $errors['password-confirm'] ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <input type="submit" name="submit" value="Save Changes">
            </form>
        </div>
    </div>
    <script src="scripts/navigation.js"></script>

    <script>
        const leaveModal = document.querySelector('.top img')
        const edit = document.querySelector('.edit')
        const over = document.querySelector('.over')
        const form = document.querySelector('.form')
        const changePw = document.querySelector('.change-pw')
        const pwTop = document.querySelector('.pw-top')
        const pwBottom = document.querySelector('.pw-bottom')


        const changeImg = document.querySelector('.change-img')
        const imgTop = document.querySelector('.img-top')
        const imgBottom = document.querySelector('.img-bottom')

        console.log(changeImg)
        console.log(imgTop)
        console.log(imgBottom)

        edit.addEventListener('click',()=>{
            over.style.display = "flex";
        })
        leaveModal.addEventListener('click',()=>{
            over.style.display = "none";
        })
        over.addEventListener('click' , (e) =>{
            if(e.target === over){
                over.style.display = "none";
            }
        })
        let dim = 0
        changePw.addEventListener('click' , (e) =>{
            if(e.target === pwTop){
                if(dim == 0){
                    pwBottom.style.display = "flex"
                    dim = 1
                }else{
                    pwBottom.style.display = "none"
                    dim = 0
                }
            }
        })
        let dimm = 0
        changeImg.addEventListener('click' , (e) =>{
            if(e.target === imgTop){
                if(dimm == 0){
                    imgBottom.style.display = "flex"
                    dimm = 1
                }else{
                    imgBottom.style.display = "none"
                    dimm = 0
                }
            }
        })
    </script>


    <div class="msgIsland">
        <img src="" width="20" alt="">
        <p class="msgTxt"></p>
    </div>

    <?php
        if (isset($_SESSION['msg'])) {
            $msg    = $_SESSION['msg'];
            $sucess = $_SESSION['succeseful'];

            unset($_SESSION['msg']);
            unset($_SESSION['succeseful']);

            $icon = $sucess ? "imgs/icons/sucess.svg" : "imgs/icons/wrong.svg";

            echo '
                <script>

                    const msgIsland = document.querySelector(".msgIsland");
                    const msgTxt = document.querySelector(".msgTxt");
                    const msgIcon = document.querySelector(".msgIsland img");

                    msgIsland.style.display = "flex"
                    msgTxt.textContent = ' . json_encode($msg) . ';
                    msgIcon.src = "' . $icon . '";

                </script>
            ';
        }
    ?>

    </body>
</html>