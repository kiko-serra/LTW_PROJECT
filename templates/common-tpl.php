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
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <script src="../javascript/restaurantAjax.js" defer></script>
        <script src="../javascript/popup.js" defer></script>
        <link rel="icon" type="image/x-icon" href="../pictures/pizza_.png">
    </head>

    <body>
        <header>
            <a href="../index.php"><img id="logo" src="pictures/ubereats_icon.png" width="200" height="200"></a>
        </header>
        <?php if ($session->isLoggedIn()) { ?>
            <section>
                <p>Olá, <?= $session->getName() ?></p>
            </section> <?php } ?>
        <header>
            <h1>Eats</h1>
        </header>

    <?php } ?>



    <?php

    require_once("popup.php");

    function drawFooter($session)
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




<?php function drawLogOutButton(bool $session)
{
?>
    <form action="actions/action_logout.php" method="post">
        <input type="submit" name="logout" value="LogOut" />
    </form>
<?php
}
?>

<?php function drawNav(bool $session)
{ ?>
    <script defer src="../javascript/sideScroller.js"></script>
    <script defer src="../javascript/sideNav.js"></script>
    <section id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <?php if ($session) drawLogOutButton($session);
        else echo '<a href="../pages/login.php">Sign In</a>'; ?>
        <a href="#">Contact</a>
        <a href="#">Copyright</a>
    </section>

    <span onclick="openNav()" class="material-symbols-outlined">
        menu
    </span>

    <section class="horizontal-nav">
        Search <input type="text" id="search-bar" class="hnav-item">
        <span class="hnav-item">
            <?php if ($session) drawLogOutButton($session);
            else echo '<a href="../pages/login.php">Sign In</a>'; ?>
        </span>
    </section>

<?php } ?>