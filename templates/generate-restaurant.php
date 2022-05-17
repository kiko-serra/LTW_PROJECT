
<?php function drawRestaurant($restaurant) {?>
     <section class="restaurant-container">
                <article>
                    <header>
                        <h2><?=$restaurant->name?></h2>
                        <h3><?=$restaurant->title?></h3>
                    </header>
                    <p><?=$restaurant->description?></p>
                    <p><?=$restaurant->reviewScore?></p>
                </article>
</section>
 <?php } ?> 

<?php function drawHeader() { ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Page</title>
    <link rel='stylesheet' type='text/css' href='../css/style.css'>
</head>
<body>
    

<?php }?>

<?php function drawRestaurants($restaurants) {?>
    <section class="restaurants-list">
    <?php foreach($restaurants as $restaurant){
        drawRestaurant($restaurant);
    } ?>
</section>
    <?php }?>

<?php function drawFooter() { ?>
</body>
</html>
<?php }?>


<?php 
class Restaurant{
    public $name;
    public $title;
    public $description;
    public $reviewScore;
    private $id;

    public function __construct($r) {
    $this->name = $r["name"];
    $this->title = $r["title"];
    $this->description= $r["category"];
    $this->id = $r["id_restaurant"];
    $this->reviewScore = $r["review_score"];
  }

}
    session_start();

    $dbh = new PDO('sqlite:../database/uber.db');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $res = array();

    try {

        $stmt = $dbh->prepare('SELECT * FROM Restaurant');
        $stmt->execute();
        $restaurants = $stmt->fetchAll();
        foreach ($restaurants as $restaurant){
            $temp = new Restaurant($restaurant);
            $res[] = $temp;
            
        }

        drawHeader();
        drawRestaurants($res);
        drawFooter();

    }
    
     catch (PDOException $e) {
        echo $e->getMessage();
    }

    
?>
