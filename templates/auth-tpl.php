<?php
declare(strict_types = 1);
?>

<?php function drawSignUp(){

?>
<section class = "signup-page">
        <header><h2>Sign Up</h2></header>
          <form class = "signup-form" action = "../actions/action_signup.php" method = "post">

              <label for="first_name">First Name</label>
              <input type="text" name = "first_name">

              <label for="last_name">Last Name</label>
              <input type="text" name = "last_name">

              <label for="email">Email</label>
              <input type="text" name = "email">

              <label for="Address">Address</label>
              <input type="text" name = "address">

              <label for="username">Username</label>
              <input type="text" name = "username">

              <label for="phone_number">Phone Number</label>
              <input type="text" name = "phone_number">

              <label for="password">Password</label>
              <input type="text" name = "password">
              
              <input type="submit" value="Submit">

              
          </form>


        <footer>
            <p >Already have an account? <a href="../pages/login.php"><span style = "font-weight: 500">Login</spam></a></p>
        </footer>
    </section>
    </body>

    </html>

<?php } ?>


<?php function drawLogIn() { ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Eats</title>
        <link rel="stylesheet" href="../css/style.css">
        <link href='//fonts.googleapis.com/css?family=Montserrat:thin,extra-light,light,100,200,300,400,500,600,700,800' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <script src="../javascript/restaurantAjax.js" defer></script>
        <script src="../javascript/popup.js" defer></script>
        <link rel="icon" type="image/x-icon" href="../pictures/pizza_.png">
    </head>

    <body>

    <section class = "login-page">
          <form class = "login-form" action = "../actions/action_login.php" method = "post">

              <h2>Uber Eats</h2>
              <h3>Login</h3>
              <input type="text" name = "username">
              <input type="text" name = "password">
              <input type="submit" value="Submit">
              <a href="./signup.php"><button type="button">Register</button></a>

              <footer class = "login-footer">
            <ul>
                <li>Local</li>
                <li><a href="https://www.uber.com/legal/en/document/?name=general-terms-of-use&country=portugal&lang=en">Copyright</a>
                </li>
                <li>Owners</li>
                <li>Careers</li>

            </ul>
        </footer>
          </form>

   
          <section class = "login-background">
          <a href="../index.php"><img src="../docs/images/ubereats_logo.jpg"></a>
        </section>

    </section>

    </body>

    </html>

<?php } ?>