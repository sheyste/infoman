<?php 
    session_start();
    if(isset($_COOKIE['username'])){
      $output = $_COOKIE['username'];
    }else{
      header('location: login.php');
    }
?>

<?php
  include('connection.php');

  $retrieve = mysqli_query($con, "SELECT tblstudents.*, tblaccounts.username, tblaccounts.password FROM tblstudents JOIN tblaccounts ON tblstudents.studID = tblaccounts.studID");
  if(!$retrieve){
    die(mysqli_error());
  }

  if(isset($_GET['m'])){
    if($_GET['m'] == "delete"){
      echo "<strong>Record deleted successfully!</strong><hr/>";
    }elseif($_GET['m'] == "update"){
      echo "<strong>Record updated successfully!</strong><hr/>";
    }
  }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Document</title>
	</head>
	<body>
		<h1>Dashboard</h1>
		<p><a href="adduser.php">Add User</a></p>
		
		<table border="1" class="mytable">
      <thead>
        <tr>
          <th>Student ID</th>
          <th>First Name</th>
          <th>Middle Name</th>
          <th>Last Name</th>
          <th>Photo</th>
		  <th>Username</th>
		  <th>Password</th>
		  <th>Update</th>

        </tr>
      </thead>
      <tbody>
          <?php
            while($row = mysqli_fetch_array($retrieve)){ ?>
              <tr>
                  <td><?php echo $row['studID']; ?></td>
                  <td><?php echo $row['firstname']; ?></td>
                  <td><?php echo $row['middlename']; ?></td>
                  <td><?php echo $row['lastname']; ?></td>
				  <td><img style="width: 20%;" src="<?php echo $row['photo']; ?>"></td>
				  <td><?php echo $row['username']; ?></td>
				  <td><?php echo $row['password']; ?></td>
                  <td>
                    <a href="update.php?studID=<?php echo $row['studID']; ?>">Update</a>
                  </td>
              </tr>

          <?php } ?>
      </tbody>
		</table>
		<p><a href="logout.php">Logout</a></p>
		
	</body>
</html>

<?php
	mysqli_close($con);
?>

