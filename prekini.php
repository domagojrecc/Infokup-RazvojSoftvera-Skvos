<?php 
include("database.php");
session_start(); 

if (!isset($_SESSION['username'])) {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php');
}

if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");
}

$username = $_SESSION['username'];

$cancelReservation = "UPDATE clan SET rezervirao=0 WHERE username='$username'";

$resultAll = mysqli_query($db, "SELECT * FROM clan WHERE username='$username'");
# Die if connection net established
if(!$resultAll){
  die(mysqli_error($db));
}

# Check if result greater then 0
if (mysqli_num_rows($resultAll) > 0){
  while($rowData = mysqli_fetch_assoc($resultAll)){
    $deleteReservation = "DELETE FROM rezervacija WHERE clan_ID='$rowData[ID_clan]'";
    if(mysqli_query($db, $deleteReservation)){
    } else {
      echo "ERROR: Could not able to execute $deleteReservation. " . mysqli_error($db);
    }
	}
}

if(mysqli_query($db, $cancelReservation)){
} else {
  echo "ERROR: Could not able to execute $cancelReservation. " . mysqli_error($db);
}
 echo '<script type="text/JavaScript"> 
 window.location = "korisnik.php";
  </script>';
?>
</body>
</html>