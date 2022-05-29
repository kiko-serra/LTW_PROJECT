<?php 
  declare(strict_types = 1); 

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
    </head>

    <body>
    <section id="messages">
      <?php foreach ($session->getMessages() as $messsage) { ?>
        <article class="<?=$messsage['type']?>">
          <?=$messsage['text']?>
        </article>
      <?php } ?>
    </section>
    <?php if($session->isLoggedIn()){?>
    <section> <p>Olá, <?=$session->getName()?></p></section> <?php } ?>
      <header>
        <h1>Eats</h1>
      </header>

    <?php } ?>




    <?php 
    
    require_once("popup.php");

    function drawFooter($session)
    {
        drawPopUp($session)?>
    
        <footer>
            <ul>
                <li>Local</li>
                <li><a href="https://www.uber.com/legal/en/document/?name=general-terms-of-use&country=portugal&lang=en">Copyright</a>
                </li>
                <li>Owners</li>
                <li>Careers</li>

            </ul>
        </footer>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

        <script>

        const buttonLeft = document.querySelector('.scroll-left');
        const buttonRight = document.querySelector('.scroll-right');

        buttonRight.onclick = function() {
            document.querySelector('.scrolling-wrapper').scrollLeft += 400;
        };

        buttonLeft.onclick = function() {
            document.querySelector('.scrolling-wrapper').scrollLeft -= 400;
        };

        function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        }

        /* Set the width of the side navigation to 0 */
        function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        }

        const searchBar = document.getElementById('search-bar');
        const restaurantList = document.querySelector('.restaurants-list');
        searchBar.addEventListener('keyup', (e) =>{

            
            let session = '<?php echo $_SESSION['res']?>';
            const searchString = e.target.value.toLowerCase();
            
            session = session.trim();
            const restaurants = JSON.parse(session);


            const filteredRestaurants = restaurants.filter((restaurant) => {
                return (
                    restaurant.name.toLowerCase().includes(searchString)
                );
            });
            
            displayRestaurants(filteredRestaurants);

        });

        const displayRestaurants= (restaurants) => {
        const htmlString = restaurants
            .map((restaurant) => {
                return `
                <section class="restaurant-container">
                    <article>
                        <header>
                            <h2><a href = "../pages/restaurant-page.php?id=<?php { ?> ${restaurant.id}<?php }?>&name=<?php { ?> ${restaurant.name}<?php }?>">${restaurant.name}</a></h2>
                            <h3>${restaurant.title}</h3>
                        </header>
                        <p>${restaurant.description}</p>
                        <p>${restaurant.reviewScore}</p>
                    </article>
                </section>
            `;
            })
            .join('');
        restaurantList.innerHTML = htmlString;
        };</script>

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


    <section id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <?php if ($session) drawLogOutButton($session);
            else echo '<a href="../pages/login.php">Sign In</a>';?>
        <a href="#">Contact</a>
        <a href="#">Copyright</a>
    </section>

    <span onclick="openNav()" class="material-symbols-outlined">
        menu
    </span>

    <section class = "horizontal-nav">
        Search <input type="text" id = "search-bar" class = "hnav-item">
        <span class = "hnav-item">
            <?php if ($session) drawLogOutButton($session);
            else echo '<a href="../pages/login.php">Sign In</a>'; ?>
        </span>
    </section>

        <!-- Use any element to open the sidenav -->
    <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->

<?php } ?>