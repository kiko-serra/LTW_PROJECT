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

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

        <script>

        const searchBar = document.getElementById('search-bar');
        const restaurantList = document.getElementById('restaurants-list');
        searchBar.addEventListener('keyup', (e) =>{

            console.log(1);
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
                            <h2>${restaurant.name}</h2>
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

    <nav>
        <ul>
            <li>Eats</li>
            <li> Search <input type="text" id = "search-bar"></li>
            <li>
                <?php if ($session) echo '<a href="pages/login.html">Sign In</a>';
                else drawLogOutButton($session); ?>
            </li>
        </ul>
    </nav>
<?php } ?>