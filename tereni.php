<?php 
include("database.php"); 
session_start(); 

if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");
}
if (isset($_SESSION['username'])) {
$username = $_SESSION['username'];
} else {
    $username = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="bulma/css/bulma.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-social@2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
    <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/hr.js"></script>
    <title>Tereni</title>
</head>
<body>

     <!-- Header -->
     <?php include("header.php"); 
if(isset($_GET["Date"])){
  $dateRent = $_GET["Date"];
} else {
  $dateRent = date('Y-m-d', strtotime('+2 day', strtotime(date('Y-m-d'))));
}

?>
      <!-- Kraj headera -->


      <!-- Main -->

      <div class="container">
        <h1 class="has-text-centered is-capitalized	has-text-weight-bold is-size-1 mt-6">Najam terena</h1>
      </div>
      <section class="section">

      <?php 
$numberOfCourts = mysqli_num_rows(mysqli_query($db, "SELECT * FROM teren"));
for($j=1; $j<=$numberOfCourts; $j++){
  $row = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM teren WHERE ID_teren ='$j'"));
  if($j % 2 != 0){
    echo '<div class="container">
    <div class="columns">
    <div class="column is-half">';
  } else {
    echo '<div class="column">';
  }
  $result =mysqli_query($db, 'SELECT HOUR(vrijemeNajma) FROM rezervacija WHERE DATE(vrijemeNajma)= "'.$dateRent.'" AND teren_ID = "'.$j.'"');
  $arr = array();
  while($rows = mysqli_fetch_row($result)){

    $arr[] = $rows[0];
  }
  $active = $row['aktivanTeren'];
    echo '
    <figure class="image img">
      <img style="width:700px; height: 500px; margin-left: auto; margin-right: auto;" src="data:image/jpeg;base64,'.base64_encode( $row['slika'] ).'">
    </figure>
    <div class="container has-text-centered has-text-weight-bold is-size-3">
      <h1>'.$row['vrstaTerena'].' teren</h1>
      <h1>Cijena: '.$row['naplata'].'kn/sat</h1>
  </div>

  <div class="field box has-text-centered">
      <div class="control">
      <form  id="DateSelection"  action="" method="GET" enctype="multipart/form-data">
      <input id="Date" class="timeStart" type="datetime-local" name="Date" onchange="this.form.submit()">
      
      </form>
      </div>
  <div class="control has-text-centered">
  <form  class="box" id="Rent"  action="unajmi.php?id='.$username.'" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="date" id="date" value="'.$dateRent.'"> 
  <div class="select mb-4">
  <select name="hour" id="hour">
     ';   
  
     
     for($i=8; $i<20; $i++) {
       if(!in_array($i,$arr)){
         echo "<option value=$i>$i:00</option>";
       }
     }
   echo '
   </select> </div>
       <input id="court" type="hidden" name="court" value="'.$row['ID_teren'].'"> 
 <div class="control">
  <button type="submit" class="button is-primary" '. (($active == 0) ? 'disabled' : '') .'>Rezerviraj!</button>
  </div>
  </form>  
  </div>
  </div>
  </div>


 ';

 if($j % 2 == 0){
  echo '</div>
  </div>';
}
}
 
?>

</section>

     <!-- Footer -->
     <?php include("footer.html"); ?>
      <!-- Kraj footera -->
      <script type="text/javascript">
 $(".timeStart").flatpickr({
    "locale": "hr",
    theme: "material_blue",
    altInput: true,
    altFormat: " j. F, Y.",
    dateFormat: "Y-m-d",
    defaultDate:  ["<?php echo "$dateRent";  ?>"],
    static: true,
  minDate: new Date().fp_incr(2),
});

  </script>

    
</body>
</html>