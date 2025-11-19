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
    <link rel="stylesheet" href="styles/bag.css">
</head>
<body>
    <div class="backdrop">
        <div class="hambi-navigation">
            <div class="hn-first">
                <a href="index.php">
                    <img src="imgs\icons\logo_black.svg" width="40" alt="">
                </a>
                <div class="leave-nav">
                    <img src="imgs\icons\x.svg" width="40" alt="">
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
            <img src="imgs\icons\logo_black.svg" class="logo" alt="">
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

    <header>
        <div class="bag-section">
            <h1 class="header">Bag</h1>
            <p>There are no items in your bag.</p>
        </div>
        <div class="calc">
            <p>Subtotal <span class="subtotal">-</span></p>
            <p>Estimated Shipping & Handling <span class="ship">-</span></p>
            <p>Estimated Tax <span class="tax">-</span></p>

            <button class="promo-btn">Do you have a Promo Code?
                <img src="imgs\icons\arrow-btn.svg" width="20" alt="">
            </button>
            <form class="promo-form hidden" action="checkout.php" method="POST">
                <div class="relative">
                    <div class="relative">
                        <input type="text" id="floating_outlined" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-heading bg-transparent rounded-base border-2 border-gray-900 appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" placeholder=" " />
                        <label for="floating_outlined" class="absolute text-sm text-body duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Promo Code</label>
                    </div>
                </div>
                <input type="submit" name="promo" class="promo-submit">
            </form>

            <hr>
            <p>Total <span class="total">-</span></p>
            <form action="checkout.php" method="post">
                <input type="submit" class="checkout" value="Checkout" name="checkout">
            </form>
        </div>
    </header>

    <script>
        const hambi = document.querySelector('.hambi')
        const backdrop = document.querySelector('.backdrop')
        const body = document.querySelector('body');
        const leaveNav = document.querySelector('.leave-nav');
        const promoBtn = document.querySelector('.promo-btn');
        const promoForm = document.querySelector('.promo-form');
        const promoFormImg = document.querySelector('.promo-btn img');

        hambi.addEventListener('click',()=>{
            backdrop.style.display="flex"
            body.style.overflow = "hidden"
        })
        backdrop.addEventListener('click',(e)=>{
            if(e.target === backdrop){
                backdrop.style.display="none"
                body.style.overflow = "auto"
            }
        })
        leaveNav.addEventListener('click',(e)=>{
            backdrop.style.display="none"
            body.style.overflow = "auto"
        })

        promoBtn.addEventListener('click',(e)=>{
            promoForm.classList.toggle('hidden')
            promoFormImg.classList.toggle('promo-showed')
        })
    </script>
</body>
</html>
