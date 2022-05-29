<?php
declare(strict_types = 1);
?>

<?php function drawSignUp(){

?>
<section class = "signup-page">

<header><h2>New Account</h2></header>
          <form class = "signup-form" action = "../actions/action_signup.php" method = "post">

              <label for="first_name">First Name:</label>
              <input type="text" name = "first_name">

              <label for="last_name">Last Name:</label>
              <input type="text" name = "last_name">

              <label for="email">Email:</label>
              <input type="text" name = "email">

              <label for="Address">Address:</label>
              <input type="text" name = "address">

              <label for="username">Username:</label>
              <input type="text" name = "username">

              <label for="phone_number">Phone Number:</label>
              <input type="text" name = "phone_number">

              <label for="password">Password:</label>
              <input type="text" name = "password">
              
              <input type="submit" value="Submit">
          </form>

          <section class = "signup-background">
            <img src="../docs/images/ubereats_logo.jpg">
        </section>


        <footer>
            <p>Already have an account? <a href="../pages/login.php">Login!</a></p>
        </footer>
    </section>

<?php } ?>


<?php function drawLogIn() { ?>

    <section class = "login-page">
          <form class = "login-form" action = "../actions/action_login.php" method = "post">

              <h2>Uber Eats</h2>
              <h3>Our Slogan</h3>
              <h3>Login</h3>
              <input type="text" name = "username">
              <input type="text" name = "password">
              <input type="submit" value="Submit">
              <a href="./signup.php"><button type="button">Register</button></a>
          </form>
              
          <section class = "login-background">
            <img src="../docs/images/ubereats_logo.jpg">
        </section>
    </section>

<?php } ?>