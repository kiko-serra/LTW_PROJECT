<?php
    declare(strict_types = 1); ?>

<?php function drawProfileForm(User $user) { ?>
<h2>Profile</h2>
<form action="../actions/action_edit_profile.php" method="post" class="profile">

  <label for="first_name">First Name:</label>
  <input id="first_name" type="text" name="first_name" value="<?=$user->first_name?>">
  
  <label for="last_name">Last Name:</label>
  <input id="last_name" type="text" name="last_name" value="<?=$user->last_name?>">  

  <label for="email">Email:</label>
  <input id="email" type="text" name="email" value="<?=$user->email?>">

  <label for="Address">Address:</label>
  <input id="address" type="text" name="address" value="<?=$user->address?>">

  <label for="username">Username:</label>
  <input id="username" type="text" name="username" value="<?=$user->username?>">

  <label for="phone_number">Phone Number:</label>
  <input id="phone_number" type="text" name="phone_number" value="<?=$user->phone_number?>">

  
  <button type="submit">Save</button>
</form>
<?php } ?>