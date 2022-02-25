<nav
  class="navbar is-light is-spaced has-shadow"
  role="navigation"
  aria-label="main navigation"
>
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php">
      <img src="slike/cock.png" width="200%" height="110%" style="object-fit: cover";>
    </a>

    <a
      role="button"
      class="navbar-burger"
      aria-label="menu"
      aria-expanded="false"
      data-target="navbarBasicExample"
    >
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
        <a class="button is-link is-inverted ml-1" href="index.php">Početna</a>
      <a class="button is-link is-outlined ml-1" href="tereni.php"> Tereni </a>
      <a class="button is-link is-outlined ml-1" href="onama.php"> O nama </a>
    </div>


    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
        <?php 

if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
$UserQuery = "SELECT ime, prezime FROM clan WHERE username='$username'";
$result = mysqli_query($db, $UserQuery);

  while ($row = mysqli_fetch_assoc($result)) { 
    $name = $row['ime'];
    $lastName = $row['prezime'];
  echo '  
  <a class="button is-primary is-outlined" href="korisnik.php">' . $row['ime'],' ', $row['prezime'] . '</a>';

echo '<a class="button is-danger" href="index.php?logout=1">Odjava</a>';
}
  }
if (!isset($_SESSION['username'])) {
  echo'
  <a class="button is-info" href="registracija.php">
            <strong>Registracija</strong>
          </a>
          <a class="button is-info is-outlined" href="login.php">Prijava</a>
  ';
}
?>
          
        </div>
      </div>
    </div>
  </div>
</nav>
<script type="text/javascript">
  $(document).ready(function () {
    // Check for click events on the navbar burger icon
    $(".navbar-burger").click(function () {
      // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
      $(".navbar-burger").toggleClass("is-active");
      $(".navbar-menu").toggleClass("is-active");
    });
  });
</script>
