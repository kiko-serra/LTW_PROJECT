<?php function drawLogin(){

?>
<section class = "signup-page">
          <form class = "signup-form" action = "../actions/action_signup.php" method = "post">

              <h2>Uber Eats</h2>
              <h3>Our Slogan</h3>
              <h3>Login</h3>
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
            <p>Don't have an account? <a href="../pages/signup.php">Sign Up!</a></p>
        </footer>
    </section>

<?php } ?>