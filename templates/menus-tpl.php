<?php function drawMenu($menu)
{ ?>
    <section class="menu-container">
        <li>
            <header>
                <h3><?= $menu->name ?></h2>
                <p>Price = <?= $menu->price ?></p>
            </header>
        </li>
    </section>
<?php } ?>


<?php function drawMenus($menus)
{ ?>
    <section class="menu-list">
        <ul>
        <?php foreach ($menus as $menu) {
            drawMenu($menu);
        } ?>
        </ul>
    </section>
<?php } ?>


<?php function drawFeaturedFoods()
{  ?>
    <section class="featured-foods">
        <article>
            <header>
                <h1>First Food</h1>
                <p>Sentence about first food topic</p>
            </header>
        </article>


        <article>
            <header>
                <h1>Second Food</h1>
                <p>Sentence about second food topic</p>
            </header>
        </article>

        <article>
            <header>
                <h1>Third Food</h1>
                <p>Sentence about third food topic</p>
            </header>
        </article>
    </section>
<?php } ?>