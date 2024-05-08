<?php include("connection.php"); ?>

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
                header("location: login.php");
                exit();
            }
        } else {
            echo "There was an error uploading the file, please try again!";
        }
    } else {
        echo "Please select a file to upload.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
<center>
    <br>
    <h1>Register</h1>
    <br>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">

        <div><input type="text" name="fname" placeholder="First name"/></div>
        <br>
        <div><input type="text" name="mname" placeholder="Middle name"/></div>
        <br>
        <div><input type="text" name="lname" placeholder="Last name"/></div>
        <br>
        
        <div><input type="text" name="username" placeholder="Username"/></div>
        <br>
        <div><input type="password" name="password" placeholder="Password"/></div>
        <br>

        <div>Select file to upload: <input type="file" name="fileToUpload" id="fileToUpload"></div>
        <br>
        <div><input type="submit" name="submit_btn" value="Register"/></div>
    </form>
    <br>
    <a href='login.php'>Login</a>
</center>
</body>
</html>

<?php include("closeconnection.php");?>
