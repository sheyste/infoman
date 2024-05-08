<?php include("connection.php"); ?>

<?php 
    session_start();
    if(isset($_COOKIE['username'])){
      $output = $_COOKIE['username'];
    }else{
      header('location: login.php');
    }
?>

<?php
if(isset($_POST['submit_btn'])){

    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(!empty($_FILES['fileToUpload'])) {
        $folder = "files/";
        $originalFileName = basename($_FILES['fileToUpload']['name']); 
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION); 
        $newFileName = uniqid() . '.' . $fileExtension;
        $filepath = $folder . $newFileName;

        if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $filepath)) {
            $insert_student = mysqli_query($con,
                "INSERT INTO tblstudents (firstname, middlename, lastname, photo)
                VALUES('$fname', '$mname', '$lname', '$filepath')"
            );

            $insert_account = mysqli_query($con,
                "INSERT INTO tblaccounts (studID, username, password)
                VALUES(LAST_INSERT_ID(), '$username', '$password')"
            );

            if(!$insert_student || !$insert_account){
                die(mysqli_error($con));
            } else {
                header("location: dashboard.php");
                exit();
            }
        } else {
            echo "Please try again!";
        }
    } else {
        echo "Select a file to upload.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
</head>
<body>

    <h1>Add User</h1>
	<p><a href="dashboard.php">Home</a></p>
    <br>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">

        <input type="text" name="fname" placeholder="First name"/>
        <br><br>
        <input type="text" name="mname" placeholder="Middle name"/>
        <br><br>
        <input type="text" name="lname" placeholder="Last name"/>
        <br><br>
        
        <input type="text" name="username" placeholder="Username"/>
        <br><br>
        <input type="password" name="password" placeholder="Password"/>
        <br><br>

        <div>Select file to upload: <br><input type="file" name="fileToUpload" id="fileToUpload"></div>
        <br><br>
        <div><input type="submit" name="submit_btn" value="Add User"/></div>
    </form>

</body>
</html>

<?php
	mysqli_close($con);
?>

