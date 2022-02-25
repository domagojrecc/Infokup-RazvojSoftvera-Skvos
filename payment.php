<?php 
//Plaćanje članarine
include("database.php"); 
session_start(); 

if (!isset($_SESSION['username'])) {
  $_SESSION['msg'] = "Morate biti prijavljeni za pregled ove stranice!";
  header('location: login.php');
}

if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");
}

$timeNow = date('Y-m-d', time());

$username = $_SESSION['username'];
$sql = "UPDATE clan SET clanarina=clanarina+1, datumPlacanja='$timeNow' WHERE username='$username'";

mysqli_query($db, $sql); 
?>
<script>
  window.location = 'korisnik.php';
</script>


