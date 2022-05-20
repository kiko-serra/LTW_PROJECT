<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eats</title>
    <link rel="stylesheet" href="../css/style.css">
  </head>
  <body>

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
      </section>
  </body>
  <footer>
      <ul>
          <li>Local</li>
          <li>Copyright</li>
          <li>Owners</li>
          <li>Careers</li>

      </ul>
  </footer>

</html>