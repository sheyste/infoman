<?php 
session_start();
if(isset($_COOKIE['username'])){
  $output = $_COOKIE['username'];
}else{
  header('location: login.php');
}
?>

<?php
include("connection.php");


if(isset($_GET['studID'])){
    $studID = $_GET['studID'];
} else {
    echo "Student ID is not set.";
    exit; 
}

if(isset($_POST['update_btn'])){
    $firstname = $_POST['txtfname'];
    $middlename = $_POST['txtmname'];
    $lastname = $_POST['txtlname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(!empty($_FILES['fileToUpload'])) {
        $folder = "files/";
        $originalFileName = basename($_FILES['fileToUpload']['name']); 
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION); 
        $newFileName = uniqid() . '.' . $fileExtension;
        $filepath = $folder . $newFileName;

        if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $filepath)) {
            $update = mysqli_query($con, "UPDATE tblstudents SET firstname='$firstname', middlename = '$middlename',
                lastname = '$lastname', photo = '$filepath' WHERE studID = $studID");
        } else {
            echo "There was an error uploading the file, please try again!";
        }
    } else {
        $update = mysqli_query($con, "UPDATE tblstudents SET firstname='$firstname', middlename = '$middlename',
            lastname = '$lastname' WHERE studID = $studID");
    }

    $update_account = mysqli_query($con, "UPDATE tblaccounts SET username='$username', password='$password' WHERE studID = $studID");

    if(!$update || !$update_account){
        die(mysqli_error($con));
    }else{
        echo "Update successful!";
        header("location: dashboard.php?m=update");
        exit; 
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Update User</title>
    </head>
    <body>
	<center>
        <h1>Update User</h1>
		<p><a href="dashboard.php">Home</a></p>
        <?php

        $result = mysqli_query($con, "SELECT tblstudents.*, tblaccounts.username, tblaccounts.password FROM tblstudents JOIN tblaccounts ON tblstudents.studID = tblaccounts.studID WHERE tblstudents.studID = $studID");
        if(!$result){
            die(mysqli_error($con));
        }

        while($row = mysqli_fetch_array($result)){?>

        <form method="POST" action="update.php?studID=<?php echo $studID; ?>" enctype="multipart/form-data">
            <div>
				<p>First Name:</p>
                <input type="text" name="txtfname" placeholder="First Name" value="<?php echo $row['firstname']?>"/>
            </div>
            <div>
				<p>Middle Name:</p>
                <input type="text" name="txtmname" placeholder="Middle Name" value="<?php echo $row['middlename']?>"/>
            </div>
            <div>
				<p>Last Name:</p>
                <input type="text" name="txtlname" placeholder="Last Name" value="<?php echo $row['lastname']?>"/>
            </div>
            <div>
				<p>Username:</p>
                <input type="text" name="username" placeholder="Username" value="<?php echo $row['username']?>"/>
            </div>
            <div>
				<p>Password:</p>
                <input type="password" name="password" placeholder="Password" value="<?php echo $row['password']?>"/>
            </div>
			<br>

            <div>Select file to upload: <input type="file" name="fileToUpload" id="fileToUpload"></div>
			<br>

            <div>
                <input type="submit" name="update_btn" value="Update"/>
            </div>
        </form>
        <?php } ?>
	</center>
    </body>
</html>
<?php include("closeconnection.php");?>
