<?php
    require_once "auth.php";
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
    <link rel="stylesheet" href="styles/bag.css">
</head>
<body>
    <?php require_once "nav.php" ?>

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
                <img src="imgs/iconsarrow-btn.svg" width="20" alt="">
            </button>
            <form class="promo-form hidden" action="checkout.php" method="POST">
                <div class="relative">
                    <div class="relative">
                        <input type="text" id="floating_outlined" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-heading bg-transparent rounded-base border-2 border-gray-900 appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" placeholder=" " />
                        <label for="floating_outlined" class="absolute text-sm text-body duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Promo Code</label>
                    </div>
                </div>
                <input type="submit" name="promo" value="Submit" class="promo-submit">
            </form>

            <hr>
            <p>Total <span class="total">-</span></p>
            <form action="checkout.php" method="post">
                <input type="submit" class="checkout" value="Checkout" name="checkout">
            </form>
        </div>
    </header>

    <script>

        const promoBtn = document.querySelector('.promo-btn');
        const promoForm = document.querySelector('.promo-form');
        const promoFormImg = document.querySelector('.promo-btn img');

        promoBtn.addEventListener('click',(e)=>{
            promoForm.classList.toggle('hidden')
            promoFormImg.classList.toggle('promo-showed')
        })
    </script>

</body>
</html>
