<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawHeader(Session $session)
{ ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Eats</title>

        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/mobile-style.css">
        <link rel="stylesheet" href = "../css/waves.css">
        <link href='//fonts.googleapis.com/css?family=Montserrat:thin,extra-light,light,100,200,300,400,500,600,700,800' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

        <script src="../javascript/restaurantAjax.js" defer></script>
        <script src="../javascript/restaurantCard-click.js" defer></script>
        <script src="../javascript/popup.js" defer></script>
        <script src="../javascript/categorySelect.js" defer></script>
        <script src="../javascript/infoSelect.js" defer></script>
        <script src="../javascript/favouriteMenu.js" defer></script>
        <script src="../javascript/favouriteRestaurant.js" defer></script>
        <script src="../javascript/addToCart.js" defer></script>
        <script src="../javascript/addComment.js" defer></script>
        <link rel="icon" type="image/x-icon" href="../pictures/pizza_.png">
    </head>

    <body>

    <?php } ?>



    <?php

    require_once("popup.php");

    function drawFooter(Session $session)
    {
        drawPopUp($session) ?>
        <footer>
            <ul>
                <li>Local</li>
                <li><a href="https://www.uber.com/legal/en/document/?name=general-terms-of-use&country=portugal&lang=en">Copyright</a>
                </li>
                <li>Owners</li>
                <li>Careers</li>

            </ul>
        </footer>
    </body>

    </html>
<?php } ?>




<?php function drawLogOutButton()
{
?>
    <a href= "../actions/action_logout.php"> Log Out </a>
<?php
}
?>

<?php function drawNav(Session $session)
{ ?>
    <script defer src="../javascript/sideScroller.js"></script>
    <script defer src="../javascript/sideNav.js"></script>
    <section id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <?php if ($session->isLoggedIn()) drawLogOutButton($session->isLoggedIn());
        else echo '<a href="../pages/login.php">Sign In</a>'; ?>
        <a href="#">Contact</a>
        <a href="#">Copyright</a>
    </section>


    <section class="horizontal-nav">
        <span onclick="openNav()" class="material-symbols-outlined " style="font-size: 2em" id = "sandwich-menu">
            menu
        </span>
        <span class = "hnav-item" >
            <a href="../index.php"><img id="logo" src="../pictures/logo_transparent.png"></a>
        </span>
        <input type="text" id="search-bar" class="hnav-item">

        <?php if ($session->isLoggedIn()){
                ?>
                <a href="../pages/profile.php?id=<?= $session->getId()?>" class="hnav-item">
                <span id="user-icon" class="material-symbols-outlined"  userId="<?=$session->getId()?>" style = "font-size: 2em;">
                    account_circle
                </span>
                </a>
                <a href="../pages/checkout.php?id=<?= $session->getId()?>" class="hnav-item">
                <span class="material-symbols-outlined" style = "font-size: 1.8em;">
                    shopping_cart
                </span>
                </a>
            <?php
        } ?>

        <span class="hnav-item" id = "signin-button">
            <?php if ($session->isLoggedIn()){
                drawLogOutButton();
            }
            else echo '<a href="../pages/login.php">Sign In</a>'; ?>
        </span>

    </section>

<?php } ?>