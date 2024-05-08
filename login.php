<?php
    session_start();

    require("connection.php");
    
    if (isset($_COOKIE['username']) != null) {
        header("location: dashboard.php");
    }else{
        if (isset($_POST['btn_submit'])){

            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM tblaccounts WHERE username = '$username'";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) == 1) { 
                $row = mysqli_fetch_assoc($result);
                
                if ($password == $row['password']) {
                    setcookie('username', $username ,time() + 1000000); 
                    header('location: dashboard.php');
                } else {
                    echo "Invalid password.";
                }
            } else {
                echo "User not found.";
            }
            
            
        }
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Login Page</title>
  </head>
  <body>
       
	   <center>
	   <br>
        <h1>Login</h1>
		<br>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required />
            <br/><br>
            <input type="password" name="password" placeholder="Password" required/>
            <br/><br>
            <input type="submit" name="btn_submit" value="Login"/>
        </form>
		<br>
		<a href="register.php">Sign Up</a>
		<center>

      
     
  </body>
</html>
