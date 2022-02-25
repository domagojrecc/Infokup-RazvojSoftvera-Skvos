<?php 
include("database.php"); 

session_start(); 

if (!isset($_SESSION['username'])) {
  echo '<script type="text/JavaScript"> 
      alert("Morate biti prijavljeni za ovu mogućnost!");
      window.location = "login.php";
      </script>';
}

if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");
}

$username = $_SESSION['username'];
//Dobivanje vremena kojeg korisnik odabire
$unformatedTime= mysqli_real_escape_string($db, $_REQUEST['date']);
$hour= mysqli_real_escape_string($db, $_REQUEST['hour']);
$timeStart = date('Y-m-d H:i:s', strtotime("+$hour hour", strtotime($unformatedTime)));
$timeEnd = date('Y-m-d H:i:s', strtotime('+59 minutes', strtotime($timeStart)));
$court = mysqli_real_escape_string($db, $_REQUEST['court']);

$timeNow = date('Y/m/d H:i:s', time());

if ($timeStart>$timeNow) {
  echo '<script type="text/JavaScript"> 
      alert("Unesite valjani datum i vrijeme!");
      window.location = "tereni.php";
      </script>';
      exit('gg');
}

$rents = "SELECT vrijemeNajma, zavrsetakNajma FROM rezervacija WHERE teren_ID='$court'";
$rentCount = "SELECT COUNT(*) FROM rezervacija WHERE teren_ID='$court'";
$numberOfRents = mysqli_num_rows(mysqli_query($db, $rentCount));
$allRents = mysqli_query($db, $rents);

while ($row = mysqli_fetch_assoc($allRents)) { 
  for ($i=0; $i < $numberOfRents; $i++) { 
    $rentStart[$i]= $row['vrijemeNajma'];
    $rentEnd[$i]= $row['zavrsetakNajma'];
  }
  for ($i=0; $i <$numberOfRents; $i++){
    if (($timeStart>=$rentStart[$i]) && ($timeStart<=$rentEnd[$i]) || ($timeEnd>=$rentStart[$i]) && ($timeEnd<=$rentEnd[$i])){
      echo '<script type="text/JavaScript"> 
      alert("Već postoji rezervacija u odabranom terminu. Molimo odaberite drugi!");
      window.location = "tereni.php";
      </script>';
      exit('gg');
    }
  }
}

$queryMembership = mysqli_query($db, "SELECT rezervirao FROM clan WHERE username='$username'");
//Dohvaća rezultat i provjerava članarinu
$queryLastPayment= mysqli_fetch_row(mysqli_query($db, "SELECT datumPlacanja FROM clan WHERE username='$username'"));
$lastPayment = implode(" ",$queryLastPayment);
$lastDay = date('Y-m-d', strtotime('+30 day', strtotime($lastPayment)));
$timeNow = date('Y-m-d', time());
$lastPaymentFormatted = date('d.m.Y.', strtotime($lastPayment));

if (mysqli_num_rows($queryMembership)) { 
  while ($row = mysqli_fetch_assoc($queryMembership)) { 

    $reservation =  $row['rezervirao'];
    
//Provjerava jeli članarina plaćena
if ($timeNow<$lastDay) {
  if( $reservation == 1) {
    echo '<script type="text/JavaScript"> 
    alert("Već imate rezervaciju!");
    window.location = "tereni.php";
    </script>';
  } else {

$reserved = "UPDATE clan SET rezervirao=1 WHERE username='$username'";

if(mysqli_query($db, $reserved)){
} else {
  echo "ERROR: Could not able to execute $reserved. " . mysqli_error($db);
}

//Dohvaćanje ID člana preko korisničkog imena

$userId = mysqli_query($db, "SELECT ID_clan FROM clan WHERE username='$username'");

//Spaja ID člana i ID terena u tablici rezervacija + postavlja vrijeme najma
if (mysqli_num_rows($userId)) { 
  while ($row = mysqli_fetch_assoc($userId)) { 
    $dbReservation = "INSERT INTO rezervacija (teren_ID, clan_ID, vrijemeNajma, zavrsetakNajma) VALUES ('$court' , '$row[ID_clan]',  '$timeStart', '$timeEnd')";
    if(mysqli_query($db, $dbReservation)){
      } else {
        echo "ERROR: Could not able to execute $dbReservation. " . mysqli_error($db);
      }
    } 
  }


//Povećava broj rezervacija
$updateNumReservations = "UPDATE clan SET brojRezervacija=brojRezervacija+1 WHERE username='$username'";
if(mysqli_query($db, $updateNumReservations)){
} else {
  echo "ERROR: Could not able to execute $updateNumReservations. " . mysqli_error($db);
}

$updateNumReservationsCourt = "UPDATE teren SET brojNajmova=brojNajmova+1 WHERE ID_teren='$court'";
if(mysqli_query($db, $updateNumReservationsCourt)){
} else {
  echo "ERROR: Could not able to execute $updateNumReservationsCourt. " . mysqli_error($db);
}
 echo '<script type="text/JavaScript"> 
  window.location = "korisnik.php";
  </script>';

}
//Izbacuje upozorenje ako članarina nije plaćena
} else {
  echo '<script type="text/JavaScript"> 
  alert("Članarina nije plaćena");
  window.location = "tereni.php";
  </script>';
}
} 
}
?> 