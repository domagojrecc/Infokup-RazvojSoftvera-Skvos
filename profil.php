<?php
//stanje članarine
include("database.php");
$queryLastPayment= mysqli_fetch_row(mysqli_query($db, "SELECT datumPlacanja FROM clan WHERE username='$username'"));
$lastPayment = implode(" ",$queryLastPayment);
$lastDay = date('Y-m-d', strtotime('+30 day', strtotime($lastPayment)));
$timeNow = date('Y-m-d', time());
$lastPaymentFormatted = date('d.m.Y.', strtotime($lastPayment)); 
$lastDayFormatted = date('d.m.Y.', strtotime($lastDay)); 
?>

<div class="container box">
        <h1 class="has-text-centered is-capitalized	has-text-weight-bold is-size-2 mt-6"><?php echo $name." ".$lastName ?></h1>
       <section class="section">


           <h2 class="subtitle has-text-centered is-size-3"><strong>Stanje članarine:</strong>
           <?php if ($timeNow<$lastDay) {
  echo "aktivna";
} elseif ($timeNow>$lastDay) {
  echo 'nije aktivna
  <br>
    <a href="payment.php?id=' . $username  . '">
      Aktiviranje članarine
    </a>';
} ?></h2>

<?php

$membershipQuery = mysqli_fetch_row(mysqli_query($db, "SELECT clanarina FROM clan WHERE username='$username'"));
$membership = implode(" ",$membershipQuery);
if(($membership!=0)){
  echo '<h2 class="subtitle has-text-centered is-size-3"><strong>Zadnja članarina plaćena:</strong> '.$lastPaymentFormatted.'</h2>
  <h2 class="subtitle has-text-centered is-size-3"><strong>Datum isteka članarine:</strong> 
  '.$lastDayFormatted.'</h2>
  ';
} else {
  echo '<h2 class="subtitle has-text-centered is-size-3"><strong>Zadnja članarina plaćena:</strong> Još niste nikada platili članarinu.</h2>';
}
?>

           
       </section> 
      </div>



      <div class="container box">
        <h1 class="has-text-centered is-capitalized	has-text-weight-bold is-size-2 mt-6">Unajmljeni teren</h1>
        <section class="section">
        <?php

$queryMember = mysqli_query($db, "SELECT clan.*, rezervacija.*, teren.* FROM clan
JOIN rezervacija  ON clan.ID_clan = rezervacija.clan_ID
JOIN teren ON rezervacija.teren_ID = teren.ID_teren
WHERE username='$username'");

while($row = $queryMember->fetch_assoc()) {
  $DateOnly = date('d.m.Y.', strtotime($row['vrijemeNajma']));
  $fromHour = date('H:i', strtotime($row['vrijemeNajma']));
  $toHour = date('H:i', strtotime($row['zavrsetakNajma']));

  echo '<div class = container>
  <figure class="image img">
  <img style="width:800px; height: 600px; margin-left: auto; margin-right: auto; object-fit: cover;" src="data:image/jpeg;base64,' . base64_encode( $row['slika'] ) . '" />';  
  
  echo'<br><div class="container has-text-centered is-size-4"><p class="rentTime">'.$DateOnly .' '.$fromHour .'-'. $toHour . '</p></div></div><br>';
  echo '<form  id="Delete"  action="prekini.php?id=' . $username  . '" method="POST" enctype="multipart/form-data">
  <fieldset>
  <div class="container has-text-centered is-size-3">
  <p>Otkaži najam:</p>
  <button class="button is-danger" style="margin-top:10px" type="submit" name="Cancel" id="Cancel"  >Otkaži</button>
  </div>
  </fieldset>
  </form>';
  }


$queryRent = mysqli_query($db, "SELECT * FROM clan WHERE username='$username'");      
while($row = $queryRent->fetch_assoc()) {              
  if($row['rezervirao']==0){
    echo '<h2 class="subtitle has-text-centered is-size-3">Trenutačno nemate unajmljenih terena.</h2>
    <div class="container has-text-centered is-size-4"><span class="prettyText"><a href="tereni.php"><b class="link">Najam terena</b></a></span></div>';
  }
}
?>

        </section>
      </div>

    