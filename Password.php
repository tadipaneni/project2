<?php  session_start(); ?> 
 
<?php
 

 
if(isset($_POST['login'])){   // it checks whether the user clicked login button or not 

     $user = $_POST['user'];
     $pass = $_POST['pass'];
 
    if(isset($_POST["user"]) && isset($_POST["pass"])){
    $file = fopen('accounts.txt', 'r');
    $good=false;
    while(!feof($file)){
        $line = fgets($file);
        $array = explode(";",$line);
		
    if(trim($array[0]) == $_POST['user'] && trim($array[1]) == $_POST['pass']){
	   
	        $good=true;
            break;
        }
    }
 
    if($good){
    $_SESSION['user'] = $user;
	header("Location:game.php"); 
          
    }else{
        echo "Invalid UserName or Password";
    }
    fclose($file);
    }
    
 
}
?>  
	  
      
   


<!DOCTYPE html>
<html lang="en">
<head>
<meta name="Description" content="Password">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.css">
<title>Login</title>
</head>

<body>
<p><a href="summary.html" class="about">About</a></p>
<div class="content">
            <header>SignIn to Start Playing</header>
            <form action = "" method="POST">
               <div class="field">
                  <span class="fa fa-user"></span>
                  <input type="text" name = "user" required placeholder="Name">
               </div>
               <div class="field space">
                  <span class="fa fa-lock"></span>
                  <input type="password" class="pass-key" name="pass" required placeholder="Password">
               </div>
               <div class="field">
                  <input name="login" type="submit" value="login">
               </div>
            </form>
            <div class="signup">
               Don't have account?
               <a href="login.php">Signup Now</a>
            </div>
         </div>

<!-- </form> -->

</body>
</html>


           
           		   
         	  
		

