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
</head>
<body>
      <!-- Header -->
      <?php include("header.php"); ?>
    <!-- Kraj headera -->

    <!-- Main -->
    <section class="section"> 
        <h1 class="title has-text-centered has-text-weight-bold is-size-1">Tko smo mi?</h1>
        <div class="box">
        <h2 class="subtitle has-text-centered">
           Mi smo skvoš klub koji nudi moderna rješenja za stare probleme.
        </h2>
      </div>
      </section>
      <section class="section"> 
        <h1 class="title has-text-centered has-text-weight-bold is-size-1">Gdje se nalazimo?</h1>
        <div class="box">
        <h2 class="subtitle has-text-centered">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d44670.38601313872!2d17.18306254835976!3d45.592572550145995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476798b28666fc23%3A0xcdc64d88de7a5177!2s43500%2C%20Daruvar!5e0!3m2!1shr!2shr!4v1645717294357!5m2!1shr!2shr" width="1280" height="720" style="border:0;" allowfullscreen="" loading="lazy"></iframe>       
            </h2>
      </div>
      </section>

     <!-- Footer -->
     <?php include("footer.html"); ?>
</body>
</html>