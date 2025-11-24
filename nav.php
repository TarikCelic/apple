<?php 
    require_once "config.php";
    require_once "auth.php";
?>

    <div class="backdrop">
        <div class="hambi-navigation">
            <div class="hn-first">
                <a href="index.php">
                    <img src="imgs/iconslogo_black.svg" width="45" alt="">
                </a>
                <div class="leave-nav">
                    <img src="imgs/iconsx.svg" width="45" alt="">
                </div>
            </div>
            <div class="hn-second">
                <ul>
                    <li><a class="nav-link" href="">Store <img src="imgs/iconsgoto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">Mac <img src="imgs/iconsgoto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">iPad <img src="imgs/iconsgoto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">iPhone <img src="imgs/iconsgoto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">Watch <img src="imgs/iconsgoto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">Vision <img src="imgs/iconsgoto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">AirPods <img src="imgs/iconsgoto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">TV & Home <img src="imgs/iconsgoto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">Entertainment <img src="imgs/iconsgoto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">Accesories <img src="imgs/iconsgoto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">Support <img src="imgs/iconsgoto.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" style="margin-top:2rem" href="bag.php">Bag <img src="imgs/iconsbag.svg" width="25" alt=""></a></li>
                    <li><a class="nav-link" href="">Search <img src="imgs/iconssearch.svg" width="25" alt=""></a></li>
                </ul>
            </div>
        </div>
    </div>
    <nav>
        <a class="logo" href="index.php">
            <img src="imgs/iconslogo_black.svg" width="27" alt="">
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
                <img src="imgs/iconssearch.svg" width="25rem" alt="">
            </a>
            <a href="bag.php" class="bag nav-icon">
                <img src="imgs/iconsbag.svg" width="25rem" alt="">
            </a>
            <?php if (isset($_SESSION['id'])): ?>
                <div class="user-menu">
                    <img src="imgs/iconsuser.svg" width ="25" alt="">

                    <div class="user-dropdown">
                        <div class="user-about">
                            <div class="user-img">
                                <img src=<?php echo htmlspecialchars($_SESSION['img'],ENT_QUOTES) ?> class="profile-pic-little" alt="">
                            </div>
                            <div class="user-name-n-r">
                                <p class="name"><?php echo htmlspecialchars($_SESSION['username']) ?></p>

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
                            <img src="imgs/iconsgoto.svg" width="25"  alt="">
                        </a>
                        <a href="notifications.php" class="um-item">
                            <div class="left-um-item">
                                <img src="imgs/icons/notifications.svg" width="20" alt="">
                                Notifications
                            </div>
                            <img src="imgs/iconsgoto.svg" width="25"  alt="">
                        </a>
                        <a class="um-item">
                            <div class="left-um-item">
                                <img src="imgs/icons/help.svg" width="20" alt="">
                                Help and Support
                            </div>
                            <img src="imgs/iconsgoto.svg" width="25"  alt="">
                        </a>
                        <?php if ($_SESSION['perm'] > 0): ?>
                        <a href="dashboard.php" class="um-item">
                            <div class="left-um-item">
                                <img src="imgs/icons/dashboard.svg" width="20" alt="">
                                Dashboard
                            </div>
                            <img src="imgs/iconsgoto.svg" width="25"  alt="">
                        </a>
                        <?php endif; ?>
                        <hr>
                        <a href="logout.php" class="um-item">
                            <div href="logout.php" class="left-um-item">
                                <img src="imgs/icons/logout.svg" width="20" alt="">
                                Log out
                            </div>
                            <img src="imgs/iconsgoto.svg" width="25"  alt="">
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        <div class="hambi">
            <img src="imgs/icons/hambi.svg" width="25rem" alt="">
        </div>
        </div>
    </nav>
    <script src="scripts/navigation.js"></script>
