
<?php
require_once(__DIR__ . "/../database/connection.php");
require_once(__DIR__ . "/../database/category.php");
?>

<?php function drawMenu($menu)
{ ?>

        <section class="menu-container"> 
            <span class="material-symbols-outlined" id = "addButton" >add_circle</span>
            <section class = "menu-container-img">
                <img src = "<?= $menu->img_url ?>">
            </section>
            <section class = "menu-container-description">
                <header>
                    <h2><?= $menu->name ?></h2>
                    
                </header>
                <span class = "menu-price">
                    <p><?= $menu->price ?>$</p>
                </span>
            </section>
            
        </section>
<?php } ?>

<?php function drawCategory($category)
{ ?>
        <article class= "feature-food-card"  category-id ="<?=$category->id_category?>"
    style = "background: linear-gradient(0deg, rgba(26, 19, 47, 0.5), rgba(26, 19, 47, 0.5)), url('<?= $category-> img_url?>'); background-size: cover;" >
            <h1><?= $category-> name ?></h1>
        </article>
<?php } ?>


<?php function drawMenus($menus)
{ ?>
    <section class ="menu-page">
        <section class = "menu-filter">
            <h2> Category </h2>
            <span class="select-button" id="bbutton"> Breakfast </span>
            <span class="select-button" id="fdbutton"> Full Dish</span>
            <span class="select-button" id="dbutton"> Desserts</span>
        </section>
        
        <section class="menus-list" id = "menu-breakfast">
            <h2> Breakfast </h2>
            <?php foreach ($menus as $menu) {
                if ($menu->id_menu_type == 3)
                    drawMenu($menu);
            } ?>
        </section>
        <section class="menus-list" id = "menu-dish">
            <h2> Full Dish </h2>
            <?php foreach ($menus as $menu) {
                if ($menu->id_menu_type == 1)
                    drawMenu($menu);
            } ?>
        </section> 
        <section class="menus-list" id = "menu-dessert">
            <h2> Desserts </h2>
            <?php foreach ($menus as $menu) {
                if ($menu->id_menu_type == 2)
                    drawMenu($menu);
            } ?>
        </section>

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