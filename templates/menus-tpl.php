
<?php
require_once(__DIR__ . "/../database/connection.php");
require_once(__DIR__ . "/../database/category.php");
?>

<?php function drawMenu($menu)
{ ?>
    <section class="restaurant-container">
            <header>
                <h3><?= $menu->name ?></h2>
                <p>Price = <?= $menu->price ?></p>
            </header>
  
    </section>
<?php } ?>

<?php function drawCategory($category)
{ ?>
        <article class= "feature-food-card" 
    style = "background: linear-gradient(0deg, rgba(26, 19, 47, 0.5), rgba(26, 19, 47, 0.5)), url('<?= $category-> img_url?>'); background-size: cover;" >
            <h1><?= $category-> name ?></h1>
        </article>
<?php } ?>


<?php function drawMenus($menus)
{ ?>
    <section class="restaurants-list">
        
        <?php foreach ($menus as $menu) {
            drawMenu($menu);
        } ?>
   
    </section>
<?php } ?>


<?php function drawFeaturedFoods($categories)
{  ?>
    <section class="featured-foods" >
        <section class="scrolling-wrapper" >
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


<?php function getFeaturedFoods() {


    $dbo= getDatabaseConnection();
    $res = array();

    try {

    $stmt = $dbo->prepare('SELECT * FROM Category');
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