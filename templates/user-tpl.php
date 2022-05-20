<?php
    declare(strict_types = 1); ?>

<?php function drawProfileForm(User $user) { ?>
<h2>Profile</h2>
<form class="profile" action = "../actions/action_edit_profile.php" method = "post" >

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
<?php } ?>