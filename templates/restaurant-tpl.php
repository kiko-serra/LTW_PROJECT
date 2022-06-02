<?php function drawRestaurant($restaurant)
{ ?>
    
        <section class="restaurant-container"> 
            <article>
                <header>
                    <h2><a href = "../pages/restaurant-page.php?id=<?= $restaurant->id?>&name=<?= $restaurant->name?>"><?= $restaurant->name ?></a></h2>
                    <h3><?= $restaurant->title ?></h3>
                </header>
                <p><?= $restaurant->description ?></p>
                <p><?= $restaurant->reviewScore ?></p>
            </article>
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


<<<<<<< HEAD
    $dbo= getDatabaseConnection();
    $res = array();

    try {

        $stmt = $dbo->prepare('SELECT * FROM Restaurant');
        $stmt->execute();
        $restaurants = $stmt->fetchAll();
        foreach ($restaurants as $restaurant) {
            $temp = new Restaurant($restaurant);
            $res[] = $temp;
        }


        
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
        
    return $res;
} 

?>
=======
>>>>>>> c14979e (Edit restaurant page done, action not strted)

<?php function drawAddRestaurant() { ?>
    <section class="add-restaurant">
        <form action="../actions/action_add_restaurant.php" method="post">
            <input type="text" name="name" placeholder="Name">
            <input type="text" name="address" placeholder="Address">
            <input type="text" name="category" placeholder="Category">
            <input type="text" name="reviewScore" placeholder="Review Score">
            <input type="text" name="title" placeholder="Title">
            <input type="submit" value="Add Restaurant">
        </form>
    </section>

<?php } ?>

<?php function drawRestaurantForm($restaurant){ ?>
    <section class="edit-restaurant">
        <form action="../actions/action_edit_restaurant.php" method="post">
            <input type="text" name="name" value="<?= $restaurant->name ?>">
            <input type="text" name="address" value="<?= $restaurant->address ?>">
            <input type="text" name="category" value="<?= $restaurant->category ?>">
            <input type="text" name="reviewScore" value="<?= $restaurant->reviewScore ?>">
            <input type="text" name="title" value="<?= $restaurant->title ?>">
            <input type="submit" value="Edit Restaurant">
        </form>
    </section>
<?php } ?>