<?php
session_start();
// initializing variables
$fname = "";
$lname = "";
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
include("database.php");

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $fname = mysqli_real_escape_string($db, $_POST['fname']);
  $lname = mysqli_real_escape_string($db, $_POST['lname']);
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($fname)) { array_push($errors, "Nema imena"); }
  if (empty($lname)) { array_push($errors, "Nema prezimena"); }
  if (empty($username)) { array_push($errors, "Nema korisničkog imena"); }
  if (empty($email)) { array_push($errors, "Nema email-a"); }
  if (empty($password_1)) { array_push($errors, "Nema lozinke"); }
  if ($password_1 != $password_2) { array_push($errors, "Lozinke se ne podudaraju"); }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM clan WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Korisničko ime već postoji");
    }

    if ($user['email'] === $email) {
      array_push($errors, "Email je iskorišten");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO clan (ime, prezime, username, password, email) 
    VALUES('$fname', '$lname','$username', '$password', '$email')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "Sada ste prijavljeni";
  	header('location: index.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  
  if (empty($username)) {
    array_push($errors, "Korisničko ime je potrebno");
  }

  if (empty($password)) {
    array_push($errors, "Lozinka je potrebna");
  }
  
  if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM clan WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "Uspješno ste prijavljeni";
      header('location: index.php');
    } else {
      array_push($errors, "Kriva lozinka/korisničko ime");
    }
  }
}
?>