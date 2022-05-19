<?php function drawRestaurant($restaurant)
{ ?>
    <section class="restaurant-container">
        <article>
            <header>
                <h2><?= $restaurant->name ?></h2>
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

<?php function getRestaurants() {

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
        
    $_SESSION['res'] = json_encode($res, true);
    return $res;
} 

?>
