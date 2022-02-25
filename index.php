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
    <title>Skvoš klub</title>
</head>
<body>
   <!-- Header  -->
<?php include("header.php"); ?>
<!-- Kraj headera  -->
<!-- //TODO: notifikacija za prijavu 
<?php /*if (isset($_SESSION['success'])) :   ?>
			<div class="error success" >
				<h3>
					<?php 
					echo $_SESSION['success']; 
					unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif */?>
-->

      <!-- Main -->
      <div class="container">
        <h1 class="has-text-centered is-capitalized	has-text-weight-bold is-size-1 mt-6">Squash klub "Reket"</h1>
      </div>

      <section class="section">
        <div class="box">
        <h2 class="subtitle has-text-centered">
            Squash je jedan od najbržih, najiscrpljujućih i najzdravijih sportova na svijetu! Zaigrajte sa prijateljima na našim terenima!        
        </h2>
        <div class="has-text-centered">
            <figure class="image img">
                <img style="width:800px; height: 600px; margin-left: auto; margin-right: auto; object-fit: cover;" src="slike/squash-game.jpg">
              </figure>
        </div>
      </div>
      </section>

        <section class="section"> 
        <h1 class="title has-text-centered has-text-weight-bold is-size-1">Besplatna oprema</h1>
        <div class="box">
        <h2 class="subtitle has-text-centered">
           Uz najam terena besplatno koristite naše rekete i lopticu ili ponesite Vašu opremu!
        </h2>
        <div class="has-text-centered">
          <figure class="image img">
            <img style="width:800px; height: 600px; margin-left: auto; margin-right: auto; object-fit: cover;" src="slike/ssskvos.png">
          </figure>
        </div>
      </div>
      </section>

      <section class="section"> 
        <h1 class="title has-text-centered has-text-weight-bold is-size-1">Dostupnost</h1>
        <div class="box">
        <h2 class="subtitle has-text-centered">
          Naše radno vrijeme Vam omogućuje korištenje naših terena svaki dan!
        </h2>
        <div class="has-text-centered">
          <figure class="image img">
            <img style="width:800px; height: 600px; margin-left: auto; margin-right: auto; object-fit: cover;" src="slike/squash-ball.jpg">
          </figure>
        </div>
        </div>
      </section>
      <!-- Kraj maina -->

<!-- Footer  -->
<?php include("footer.html"); ?>
<!-- Footer  -->	

</body>
</html>