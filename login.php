<?php
    session_start();
    require_once "config.php";

    $errors = [];
    if (isset($_POST['login'])) {
        $email = htmlspecialchars($_POST['email']);
        $pass  = $_POST['pass'];

        if (empty($email) || empty($pass)) {
            $errors['general'] = "All fields should be filled.";
        } else {
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Wrong E-Mail format.";
            }
        }

        if (empty($errors)) {

            $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ? LIMIT 1");
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) < 1) {
                $errors['general'] = "Wrong E-Mail or Password";
            } else {
                $account = mysqli_fetch_assoc($result);
                $hashed  = password_verify($pass, $account['password']);

                if ($hashed) {
                    $_SESSION['succeseful'] = true;
                    $_SESSION['msg']        = "Welcome back " . $account['name'];
                    $_SESSION['id']         = $account['id'];
                    $_SESSION['username']   = $account['name'];

                    header("Location: index.php");
                    exit;
                } else {
                    $errors['general'] = "Wrong E-Mail or Password";
                }
            }
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

    <link rel="stylesheet" href="styles/sign.css">

</head>
<body>
        <a class="logo" href="index.php">
            <img src="imgs\icons\logo_black.svg" width="50rem" alt="">
        </a>
        <form action="login.php" method="post">
            <div class="text">
                <h1>Welcome back!</h1>
                <p>Log In to unlock all features we provided for you.</p>
            </div>
            <?php
                if (isset($errors['general'])) {
                    echo '<p class="error">' . $errors['general'] . '</p>';
                }
            ?>
            <div class="relative">
                <input value="<?php if (isset($email)) {
                                      echo $email;
                              }
                              ?>" type="email" id="mail" name="email" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-heading bg-transparent rounded-base border-2 border-gray-900 appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" placeholder=" " />
                <label for="mail" class="absolute text-sm text-body duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Email</label>
            </div>
            <?php
                if (isset($errors['email'])) {
                    echo "<p class='error'>{$errors['email']}</p>";
                }
            ?>
            <div class="relative">
                <input type="password" id="pw" name="pass" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-heading bg-transparent rounded-base border-2 border-gray-900 appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" placeholder=" " />
                <label for="pw" class="absolute text-sm text-body duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Password</label>
            </div>
            <?php
                if (isset($errors['password'])) {
                    echo "<p class='error'>{$errors['password']}</p>";
                }
            ?>
            <label for="agreement" name="agreement" class="flex items-start mb-5">
                <input id="agreement" type="checkbox" value="" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft" required />
                <p class="ms-2 text-sm font-medium text-heading select-none">I agree with the <a href="#" class="text-fg-brand hover:underline">terms and conditions</a>.</p>
            </label>

            <input type="submit" value="Log in" name="login" class="promo-submit">
            <p>Haven't account? <a href="register.php" class="text-fg-brand hover:underline">Register</a></p>
        </form>

</body>
</html>
