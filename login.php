<?php

if(isset($_POST['submit']))
 {
  $username = $_POST['name'];
  $password = $_POST['pwd'];
  $text = $username . ";" . $password . "\n";
  $fp = fopen('accounts.txt', 'a+');

    if(fwrite($fp, $text))  {
        echo 'saved';

    }
fclose ($fp);    
header("location:Password.php");
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta name="Description" content="Password">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet"  href="style.css">
<title>Login</title>
</head>

<body class='login'>
<p><a href="summary.html" class="about">About</a></p>
     <div class="content">
            <header>Signup Form</header>
            <form action = "" method="POST">
               <div class="field">
                  <span class="fa fa-user"></span>
                  <input type="text" name = "name" required placeholder="Name">
               </div>
               <div class="field space">
                  <span class="fa fa-lock"></span>
                  <input type="password" class="pass-key" name = "pwd" required placeholder="Password">
               </div>
               <div class="field">
                  <input type="submit" name="submit" id = "submit" value = "submit">
               </div>
            </form>
            <div class="signup">
               Already have an account?
               <a href="Password.php">Sign In</a>
            </div>
         </div>
    <!-- </form> -->

</body>
</html>	