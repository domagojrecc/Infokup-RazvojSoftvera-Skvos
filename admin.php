<div class="container has-text-centered">
<section class="section">
    <div class="container is-size-1 has-text-weight-bold">
        <h1>Tereni</h1>
    </div>
</section>
</div>
<!-- izmjena terena -->
<section class="section">
    <div class="columns">
<?php
$SQLcourt = mysqli_query($db, "SELECT * FROM teren");
while ($row = mysqli_fetch_assoc($SQLcourt)) { 
  $active = $row['aktivanTeren'];
  echo '
  <div class="column">
  <p class="has-text-centered title">Teren '.$row['ID_teren'].' - '.$row['vrstaTerena'].'</p>
  <figure class="image img">
      <img style="width:500px; height: 300px; margin-left: auto; margin-right: auto;" src="data:image/jpeg;base64,'.base64_encode( $row['slika'] ).'">
    </figure>
    <div class="container has-text-centered has-text-weight-bold">
        <form id="court_en_dis"  action="configTeren.php" method="POST" enctype="multipart/form-data" class="box">
      <div class="field">
          <div class="control ">
              <div class="select">
                  <select name="enable_disable">
                    <option '.  (($active == 1) ? 'selected' : '') .' value="1">Aktivan</option>
                    <option  '.  (($active == 0) ? 'selected' : '') .' value="0">Neaktivan</option>
                  </select>
                </div>
          </div>
      </div>
      <div class="field">
          <label class="label">Cijena</label>
          <div class="control ">
              <input class="input" type="text" name="price" value="'.$row['naplata'].'" placeholder="Unesite cijenu">
          </div>
      </div>
      <input type="hidden" id="court_ID" name="court_ID" value="'.$row['ID_teren'].'">
      <div class="control has-text-centered ">
          <button type="submit" class="button is-primary">Promjeni</button>
        </div>
  </form>
  </div>
</div>
';

}


?>
</div> 
</section>
<!-- kraj izmjene terena -->


<!-- tabele -->
<div class="container has-text-centered">
<section class="section">
    <div class="container is-size-1 has-text-weight-bold">
        <h1>Raspored terena</h1>
<div class="tabs is-centered">
  <ul>
  <a href="#teren1"><li>Teren 1</li></a>
  <a href="#teren2"><li>Teren 2</li></a>
  <a href="#teren3"><li>Teren 3</li></a>
  <a href="#teren4"><li>Teren 4</li></a>
  </ul>
</div>
    </div>
</section>
</div>
<?php
$numberOfCourts = mysqli_num_rows(mysqli_query($db, "SELECT * FROM teren"));
setlocale(LC_ALL, 'hr-HR.utf-8');

for ($a=1; $a <=$numberOfCourts ; $a++) { 
   
echo '<div class="container has-text-centered">
<section class="section">';
    echo '<h1 id ="teren'.$a.'" class="title">Teren '.$a.'</h1>';
echo '<table class="table is-hoverable is-fullwidth is-bordered">';
    for ($b=7; $b < 20; $b++) { 

        if ($b==7) {
            
            echo '<thead><th>Vrijeme</th>';
            for ($c=0; $c <8; $c++){
                $day = date('Y-m-d', strtotime("+$c day", strtotime(date('Y-m-d'))));
                $dayFormat = date('j.n.Y.', strtotime($day));
                $nameOfDay = ucfirst(strftime('%A', strtotime($day)));
                echo '<th class="column-td">'.$nameOfDay.'<br>'.$dayFormat.'</th>';
            }
            echo '</thead><tbody>'; 
        } else {
            echo '<tr>';
            $next = $b+1;
            echo '<td>'.$b.'-'.$next.'</td>';
            
            for ($d = 0; $d <8; $d++) {
                $k = $b -1;
                $hour = date('H', strtotime("+$k hours", strtotime(date(''))));
                $result =mysqli_query($db, 'SELECT DATE(vrijemeNajma) FROM rezervacija WHERE HOUR(vrijemeNajma)= "'.$hour.'" AND teren_ID = "'.$a.'"');
                $arr = array();
                while($rows = mysqli_fetch_row($result)){
                    $arr[] = $rows[0];
                  }
                $date = date('Y-m-d', strtotime("+$d day", strtotime(date('Y-m-d'))));
                
                if(!in_array($date,$arr)){
                    echo '<td>-</td>';
                  } else {
                    echo '<td>Zauzeto</td>';
                  }
            }
            echo '</tr>';
        }
    }
?>
</tbody>
</table>


<?php
    echo '</section></div>';
}?>
<!-- tabele -->


<!-- Statistička olimpijada -->
<?php 
$names = array();
$values = array();
$sqlTopUsers = mysqli_query($db, "SELECT ime, prezime, brojRezervacija FROM clan ORDER BY brojRezervacija DESC LIMIT 5");
while ($user = mysqli_fetch_assoc($sqlTopUsers)) { 
$names[] = $user['ime']." ".$user['prezime'];
$values[] = $user['brojRezervacija'];
}


$courts = array();
$court_reservations = array();
$sqlTopCourts = mysqli_query($db, "SELECT ID_teren, brojNajmova FROM teren ORDER BY brojNajmova DESC LIMIT 5");
while ($court = mysqli_fetch_assoc($sqlTopCourts)) { 
$courts[] = "Teren ".$court['ID_teren'];
$court_reservations[] = $court['brojNajmova'];
}



$limit = date('Y-m-d', strtotime('-30 day', time()));
$total_users_members = array();
$sqlMembers = mysqli_query($db, "SELECT * FROM clan WHERE datumPlacanja>'$limit'");
$sqlNonMembers = mysqli_query($db, "SELECT * FROM clan WHERE datumPlacanja<'$limit' OR datumPlacanja IS NULL");

$members = mysqli_num_rows($sqlMembers);
$nonMembers = mysqli_num_rows($sqlNonMembers);

$total_users_members[] = $nonMembers;
$total_users_members[] = $members;
?>

    <div class="container">
        <section class="section">
            <div class="container is-size-1 has-text-weight-bold has-text-centered">
                <h1>Statistika</h1>
            </div>
            <div class="columns">
                <div class="column">
                    <canvas id="user_data" style="width:100%;max-width:600px"></canvas>
                </div>
                <div class="column">
                    <canvas id="court_data" style="width:100%;max-width:600px"></canvas>
                </div>
                <div class="column">
                    <canvas id="member_data" style="width:100%;max-width:600px"></canvas>
                </div>
              </div>
        </section>
    </div>
            <script>
        var users = <?php echo json_encode($names);?>;
var user_reservations = <?php echo json_encode($values);?>;

var barColors = ["red", "green","blue","orange","brown"];

var courts = <?php echo json_encode($courts);?>;
var court_reservations = <?php echo json_encode($court_reservations);?>;

var users_members = <?php echo json_encode($total_users_members);?>;
var u_m = ["Neplaćene članarine", "Plaćene članarine"];    

new Chart("user_data", {
  type: "bar",
  data: {
    labels: users,
    datasets: [{
      backgroundColor: barColors,
      data: user_reservations
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Korisnici s najviše iznajmljivanja"
    }
  }
});

new Chart("court_data", {
  type: "pie",
  data: {
    labels: courts,
    datasets: [{
      backgroundColor: barColors,
      data: court_reservations
    }]
  },
  options: {
    title: {
      display: true,
      text: "Najviše unajmljivani tereni:"
    }
  }
});

new Chart("member_data", {
  type: "doughnut",
  data: {
    labels: u_m,
    datasets: [{
      backgroundColor: barColors,
      data: users_members
    }]
  },
  options: {
    title: {
      display: true,
      text: "Plaćene članarine:"
    }
  }
});
        </script>
            