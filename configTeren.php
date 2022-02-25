<?php
include("database.php"); 

session_start(); 

if (!isset($_SESSION['username'])) {
  echo '<script type="text/JavaScript"> 
      alert("Morate biti prijavljeni za pregled ove stranice!");
      window.location = "login.php";
      </script>';
}

if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");
}
$court_ID= mysqli_real_escape_string($db, $_REQUEST['court_ID']);
$enable_disable= mysqli_real_escape_string($db, $_REQUEST['enable_disable']);
$price= mysqli_real_escape_string($db, $_REQUEST['price']);

$SQL_enable_disable = mysqli_query($db, "UPDATE teren SET aktivanTeren= '$enable_disable',  naplata='$price' WHERE ID_teren = '$court_ID';");

echo '<script type="text/JavaScript"> 
window.location = "korisnik.php";
</script>';

?>
