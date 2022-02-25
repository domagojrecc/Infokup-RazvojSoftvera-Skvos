<?php 
include("database.php"); 
session_start(); 

if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="bulma/css/bulma.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-social@2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>
<body>
      <!-- Header -->
      <?php include("header.php"); 
      if (!isset($_SESSION['username'])) {
        echo '<script type="text/JavaScript"> 
        alert("Morate biti prijavljeni za pregled ove stranice!");
        window.location = "index.php";
        </script>';
      } else {
      
      
      $username = $_SESSION['username'];
      
      if($username == 'admin'){
        include("admin.php");
      } else {
        include("profil.php");
      }
      } ?>
    <!-- Kraj headera -->


     <!-- Footer -->
     <?php include("footer.html"); ?>
</body>
</html>