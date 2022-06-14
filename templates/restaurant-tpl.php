<?php 

require_once("../templates/common-tpl.php");
require_once("../templates/menus-tpl.php");


?>

<?php function drawRestaurant(Restaurant $restaurant)
{ ?>

    <section class="restaurant-container" onclick="restaurantCardClick(<?= $restaurant->id ?>)">
        <section class="restaurant-container-img">
            <img src="<?= $restaurant->img_url ?>">
        </section>
        <section class="restaurant-container-description">
            <header>
                <h2><?= $restaurant->name ?></h2>
            </header>
            <span class="restaurant-sentence">
                <p><?= $restaurant->title ?></p>
            </span>
        </section>

    </section>
<?php } ?>

<?php function drawRestaurantComment($comment)
{ ?>

    <section class="restaurant-comment" id=<?=$comment->id_comment?>>
        <?php 
            echo '<h2 class="comment-title">' . $comment->title . '</h2>';
        ?>
        </h2>
        <p class="comment-text">
            <span class="comment-username"><?= $comment->username ?></span>
            <?= $comment->comment; ?>
        </p>
        <button class="respond-to-comment" id_comment=<?=$comment->id_comment?>>Respond</button>  
    </section>
<?php } ?>

<?php function drawRestaurantComments($comments)
{
    echo '<section class="restaurant-comments">';
    foreach ($comments as $comment)
        drawRestaurantComment($comment);
    echo '</section>';
} ?>

<?php function drawAddComment(Session $session,int $id_restaurant)
{ ?>

    <section class="add-comment-section" id_restaurant="<?=$id_restaurant?>">
        <h2> Add Comment </h2>
        <section class="add-comment-form">
            <input type="text" name="title" placeholder="Title">
            <input type= "text" name="comment" placeholder="Your Comment">
            <button class= "clear-comment"> Clear Comment </button>
            <button class="add-comment">Add Comment</button>
        </section>
    </section>

<?php } ?>

<?php function drawRestaurants($restaurants)
{ ?>

    <section class="restaurants-list">
        <?php foreach ($restaurants as $restaurant) {
            drawRestaurant($restaurant);
        } ?>
    </section>
<?php } ?>

<?php function getRestaurants()
{

    $dbo = getDatabaseConnection();
    $res = array();

    try {

        $stmt = $dbo->prepare('SELECT * FROM Restaurant left join Photo using (id_photo)');
        $stmt->execute();
        $restaurants = $stmt->fetchAll();
        foreach ($restaurants as $restaurant) {
            $temp = new Restaurant($restaurant);
            $res[] = $temp;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $_SESSION['res'] = json_encode($res, true);
    return $res;
}
?>
<?php function drawCategories($categories)
{  ?>
    <section class="categories">
        <?php foreach ($categories as $category) {
            drawCategory($category);
        } ?>
    </section>


<?php } ?>
<?php function drawAddRestaurant()
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
        <script src="../javascript/popup.js" defer></script>
        <script src="../javascript/addRestaurant.js" defer></script>
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
        <section class="add-restaurant-page">
            <h2> Add Restaurant </h2>
            <section class="add-restaurant-form">
                <input type="text" name="name" placeholder="Name">
                <input type="text" name="address" placeholder="Address">
                <?php
                $cats = getFeaturedFoods();
                drawCategories($cats);
                ?>

                <input type="text" name="reviewScore" placeholder="Review Score">
                <input type="text" name="title" placeholder="Title">
                <input type="file" name="image">
                <button class="add-restaurant">Add Restaurant</button>
            </section>
        </section>

    <?php } ?>

    <?php function drawRestaurantForm(int $id, Restaurant $restaurant)
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
            <section class="edit-restaurant-page">
                <h2> Edit Restaurant </h2>
                <form class="edit-restaurant-form" action="../actions/action_edit_restaurant.php" method="post">
                    <input type="hidden" name="id" value="<?= $restaurant->id ?>">
                    <input type="text" name="name" value="<?= $restaurant->name ?>">
                    <input type="text" name="address" value="<?= $restaurant->address ?>">
                    <?php
                        $cats = getFeaturedFoods();
                        drawCategories($cats);
                    ?>
                    <input type="text" name="reviewScore" value="<?= $restaurant->reviewScore ?>">
                    <input type="text" name="title" value="<?= $restaurant->title ?>">
                    <input type="submit" value="Edit Restaurant">
                </form>
            </section>
        <?php } ?>