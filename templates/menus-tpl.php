<?php function drawMenu($menu)
{ ?>
    <section class="restaurant-container">
            <header>
                <h3><?= $menu->name ?></h2>
                <p>Price = <?= $menu->price ?></p>
            </header>
  
    </section>
<?php } ?>


<?php function drawMenus($menus)
{ ?>
    <section class="restaurants-list">
        <?php foreach ($menus as $menu) {
            drawMenu($menu);
        } ?>
   
    </section>
<?php } ?>


<?php function drawFeaturedFoods()
{  ?>
    <section class="scrolling-wrapper" >
        <article class= "card">
            <header>
                <h1>First Food</h1>
                <p>Sentence about first food topic</p>
            </header>
        </article>


        <article class= "card">
            <header>
                <h1>Second Food</h1>
                <p>Sentence about second food topic</p>
            </header>
        </article>

        <article class= "card">

                <h1>Third Food</h1>
                <p>Sentence about third food topic</p>
        </article>
        <article class= "card">

            <h1>Third Food</h1>
            <p>Sentence about third food topic</p>
        </article>
        <article class= "card">

            <h1>Third Food</h1>
            <p>Sentence about third food topic</p>
        </article>
        <article class= "card">

        <h1>Third Food</h1>
        <p>Sentence about third food topic</p>
        </article>
        <article class= "card">

        <h1>Third Food</h1>
        <p>Sentence about third food topic</p>
        </article>
    </section>
<?php } ?>