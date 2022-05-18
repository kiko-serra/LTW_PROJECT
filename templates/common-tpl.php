<?php

declare(strict_types=1); ?>

<?php function drawHeader()
{ ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Eats</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>

<?php } ?>




    <?php function drawFooter()
    { ?>
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
    echo "<p>Still Constructing log out button</p>";
}
?>

<!-- Session will later be a class so we can display user data  -->
<?php function drawNav(bool $session)
{ ?>
    <nav>
        <ul>
            <li>Eats</li>
            <li>Search</li>
            <li>
                <?php if ($session) echo '<a href="pages/login.html">Sign In</a>';
                else drawLogOutButton($session); ?>
            </li>
        </ul>
    </nav>
<?php } ?>