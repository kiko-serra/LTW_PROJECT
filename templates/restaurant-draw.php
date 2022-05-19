<?php

$restaurants = json_decode($_POST['filteredRestaurants']);


{ ?>
    <section class="restaurants-list" id = "restaurants-list">
        <?php foreach ($restaurants as $restaurant) {
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
        <?php }
        } ?>
    </section>
<?php } ?>