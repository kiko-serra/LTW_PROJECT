<?php
require_once(__DIR__ . "/../database/connection.php");
require_once(__DIR__ . "/../database/category.php");
require_once(__DIR__ . "/../database/user.php");

?>

<?php function drawMenu(Menu $menu, Session $session)
{ ?>


    <section class="menu-container" id_menu="<?=$menu->id_menu?>" >
        <?php if ($session->isLoggedIn()) { 
            $db = getDatabaseConnection();
            $user = User::getUser($db, $session->getId());
            ?>

        <section class="favourite-button-container">
        <span class="favourite-menu material-symbols-outlined"
        <?php if($user->isMenuFavourite($menu->id_menu)){
          
          ?> favourite <?php } ?>
          >
            favorite
        </span>
        </section>
        <?php } ?> 
        <span id="addButton">
            <img src="/../pictures/addButton.png">
        </span>
        <section class="menu-container-img">
            <img src="<?= $menu->img_url ?>">
        </section>
        <section class="menu-container-description">
            <header>
                <h2><?= $menu->name ?></h2>

            </header>
            <span class="menu-price">
                <p><?= $menu->price ?>$</p>
            </span>
        </section>

    </section>
<?php } ?>

<?php function drawCategory(Category $category)
{ ?>
    <article class="feature-food-card" category-id="<?= $category->id_category ?>" style="background: linear-gradient(0deg, rgba(26, 19, 47, 0.5), rgba(26, 19, 47, 0.5)), url('<?= $category->img_url ?>'); background-size: cover;">
        <h1><?= $category->name ?></h1>
    </article>
<?php } ?>


<?php function drawMenus($menus, $ownership, $id_restaurant, $session)
{ ?>
    <section class="menu-page">
        <section class="menu-filter">
            <h2> Category </h2>
            <span class="select-button" id="bbutton"> Breakfast </span>
            <span class="select-button" id="fdbutton"> Full Dish</span>
            <span class="select-button" id="dbutton"> Desserts</span>
        </section>

        <section class="menus-list" id="menu-breakfast">
            <h2> Breakfast </h2>
            <?php
            $any = false;
            foreach ($menus as $menu) {
                if ($menu->id_menu_type == 3) {
                    drawMenu($menu, $session);
                    $any = true;
                }
            }

            if ($ownership) {
            ?> <span id="addButton">
                    <a href="../pages/add-menu.php?id=<?= urlencode($id_restaurant) ?>&type=<?=3?>">
                        <img src="/../pictures/addButton.png">
                    </a>
                </span>
            <?php
            }

            if (!$any) {
            ?> <p> This restaurant has no breakfast menus </p> <?php
                                                            }


                                                                ?>
        </section>
        <section class="menus-list" id="menu-dish">
            <h2> Full Dish </h2>
            <?php
            $any = false;
            foreach ($menus as $menu) {
                if ($menu->id_menu_type == 1) {
                    drawMenu($menu, $session);
                    $any = true;
                }
            }

            if ($ownership) {
            ?> <span id="addButton">
                    <a href="../pages/add-menu.php?id=<?= urlencode($id_restaurant) ?>&type=<?=1?>">
                        <img src="/../pictures/addButton.png">
                    </a>
                </span>
            <?php
            }

            if (!$any) {
            ?> <p> This restaurant has no full dish menus </p> <?php
                                                            } ?>
        </section>
        <section class="menus-list" id="menu-dessert">
            <h2> Desserts </h2>
            <?php
            $any = false;
            foreach ($menus as $menu) {
                if ($menu->id_menu_type == 2) {
                    drawMenu($menu,  $session);
                    $any = true;
                }
            }

            if ($ownership) {
            ?> <span id="addButton">
                    <a href="../pages/add-menu.php?id=<?= urlencode($id_restaurant) ?>&type=<?=2?>">
                        <img src="/../pictures/addButton.png">
                    </a>
                </span>
            <?php
            }

            if (!$any) {
            ?> <p> This restaurant has no desserts </p> <?php
                                                    } ?>
        </section>

    </section>
<?php } ?>


<?php function drawAddMenu(int $restaurant_id,int $menu_type)
{ ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Eats</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/waves.css">
        <link rel="stylesheet" href="../css/mobile-style.css">
        <link href='//fonts.googleapis.com/css?family=Montserrat:thin,extra-light,light,100,200,300,400,500,600,700,800' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <script src="../javascript/restaurantAjax.js" defer></script>
        <script src="../javascript/addMenu.js" defer></script>
        <script src="../javascript/popup.js" defer></script>
        <link rel="icon" type="image/x-icon" href="../pictures/pizza_.png">
    </head>

    <body>
        <section>
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
                </g>
            </svg>
        </section>
        <section class="add-menu-page" restaurant-id=<?=$restaurant_id?> menu-type=<?=$menu_type?>>
            <h2> Add Menu </h2>
            <section class="add-menu-form">
                <input type="text" name="name" placeholder="Name">
                <input type="text" name="description" placeholder="Small Menu Description">
                <input type="text" name="price" placeholder="Price">
                <label>Photo
                    <input type="file" name="image" placeholder="Photo URL">
                </label>
                <button class="add-menu">Add Menu</button>
            </section>
        </section>

    <?php } ?>

    <?php function drawFeaturedFoods($categories)
    {  ?>
        <section class="featured-foods">
            <section class="scrolling-wrapper">
                <?php foreach ($categories as $category) {
                    drawCategory($category);
                } ?>

            </section>

            </div>
            <button class="scroll-left"> &#10094;</button>
            <button class="scroll-right"> &#10095;</button>
            </div>
        </section>


    <?php } ?>


    <?php function getFeaturedFoods()
    {


        $dbo = getDatabaseConnection();
        $res = array();

        try {

            $stmt = $dbo->prepare('SELECT id_category,name,link FROM Category join Photo using (id_photo)');
            $stmt->execute(array());
            $categories = $stmt->fetchAll();

            foreach ($categories as $category) {
                $temp = new Category($category);
                $res[] = $temp;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $res;
    }
    ?>