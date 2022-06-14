<?php
    declare(strict_types = 1); 
    require_once(__DIR__ . "/../templates/menus-tpl.php");
    ?>

<?php function drawProfileForm(User $user) { ?>

  <section>
        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
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
  <section class = "edit-profile-page">
    <h2>Profile</h2>
    <form class="edit-profile-form" action = "../actions/action_edit_profile.php" method = "post" >

      <label >First Name:</label>
      <input id="first_name" type="text" name="first_name" value="<?=$user->first_name?>">
      
      <label >Last Name:</label>
      <input id="last_name" type="text" name="last_name" value="<?=$user->last_name?>">  

      <label >Email:</label>
      <input id="email" type="text" name="email" value="<?=$user->email?>">

      <label >Address:</label>
      <input id="address" type="text" name="address" value="<?=$user->address?>">

      <label >Username:</label>
      <input id="username" type="text" name="username" value="<?=$user->username?>">

      <label >Phone Number:</label>
      <input id="phone_number" type="text" name="phone_number" value="<?=$user->phone_number?>">

      <label>Password:</label>
      <input id="password" type="password" name="password" value="<?=$user->password?>">
      <input type="submit" value="Edit">
    </form>
  </section>
<?php } ?>


<?php function drawProfileRestaurant(Restaurant $restaurant)
{ ?>

    <section class="restaurant-container" onclick="restaurantCardClick(<?=urlencode(strval($restaurant->id))?>)"> 
            <section class = "restaurant-container-img">
                <img src = "<?= $restaurant->img_url ?>">
            </section>
            <section class = "restaurant-container-description">
                <header>
                    <h2><?= $restaurant->name ?></h2>
                </header>
                <span class = "restaurant-sentence">
                    <p><?= $restaurant->title ?></p>
                </span>
            </section>
            
      </section>

<?php } ?>



<?php function drawOrderMenu($menu, $session, $count) { ?>
  
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
    <h3><?=$count[$menu->id_menu]?>x - <span class ="cost-info">Total Cost: <?=$count[$menu->id_menu] * $menu->price?>$</span> </h3>


<?php } ?>


<?php function drawCheckoutButton($totalPrice) { ?>
  <h2> <span class = "cost-info">Total Price:</span> <?=$totalPrice?>$</h2>
  <button class="place-order">Checkout</button>
<?php
} ?>

<?php function drawCheckout($menus, $session, $count, $totalPrice) { ?>

  <section class= "checkout-page">
    <section class = "checkout-form">
      <h1> My Order</h1>

  <?php
      if(!empty($menus)){
      foreach ($menus as $menu) {
              drawOrderMenu($menu, $session, $count);
          }

          
          drawCheckoutButton($totalPrice);
            }
      
      else {
        ?> <p> You haven't selected any menus to order </p> <?php
      }

      

    ?>
    </section>
  </section>

<?php } ?>


<?php function drawProfilePage(Session $session, $restaurants, $orders, $favourites, $db) { 
  
  $user = User::getUser($db, $session->getId());
  ?>
  <section class = "profile-page">
    <section class = "profile-filter">
            <h2> Profile Info </h2>
            <span class="select-button" id="details-button"> My Details </span>
            <span class="select-button" id="restaurants-button"> My Restaurants</span>
            <span class="select-button" id="orders-button"> Last Orders</span>
            <span class="select-button" id="favourites-button"> Favourites</span>

    </section>
      <section class="profile-info" >
        <h2>My Details</h2>

        <p> First Name:</p> <span> <?=$user->first_name?></span>
        <p> Last Name: </p><span> <?=$user->last_name?></span>
        <p> Email: </p><span> <?=$user->email?></span>
        <p> Address: </p><span> <?=$user->address?></span>
        <p> Username: </p><span> <?=$user->username?></span>
        <p> Phone Number:</p><span> <?=$user->phone_number?></span>
      </section>

    <section class ="profile-restaurants">
     <h2> My Restaurants </h2>
     
     <span id = "addButton">
        <a href = "add-restaurant.php">
          <img src = "/../pictures/addButton.png">
        </a>
      </span>
     
    <?php
    if(!empty($restaurants)){
    foreach ($restaurants as $restaurant) {
                drawProfileRestaurant($restaurant);
            }
          }
    else {
      ?> <p> You dont have any restaurants </p> <?php
    }
    ?>
          
    </section>

    <section class ="profile-orders">
     <h2> Last Orders </h2>
     
    <?php
    if(!empty($orders)){
    foreach ($orders as $order) {
                drawMenu($order, $session);
            }
          }
    else {
      ?> <p> You haven't ordered anything yet </p> <?php
    }
    ?>

    </section>
    <section class ="profile-favourites">
        <h2> Favourites </h2>
    <?php
        if(!empty($favourites)){
        foreach ($favourites as $favourite) {
                    drawMenu($favourite, $session);
                }
              }
        else {
          ?> <p> You haven't ordered anything yet </p> <?php
        }
        ?>
          
    </section>
  </section>
<?php } ?>