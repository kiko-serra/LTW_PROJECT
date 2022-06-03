<?php
    declare(strict_types = 1); ?>

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

      
      <input type="submit" value="Submit">
    </form>
  </section>
<?php } ?>