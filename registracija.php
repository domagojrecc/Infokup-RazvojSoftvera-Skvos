<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bulma/css/bulma.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-social@2/css/all.min.css">
    <title>Registracija</title>
</head>
<body>
    <div class="hero is-fullheight is-primary">
        <div class="hero is-fullheight is-link">
            <div class="hero-body">
              <div class="container has-text-centered">
                <div class="column is-8 is-offset-2">
                    <h3 class="title has-text-white">Registracija</h3>
                    <hr class="login-hr">
                    <div class="box">
                        <div class="title has-text-grey is-5">Unesite tražene podatke kako biste se uspješno registrirali.</div>
                        <form method="post" action="registracija.php">
                        <?php include('errors.php'); ?>
                            <div class="field">
                                <div class="control">
                                  <input class="input is-large" type="text" placeholder="Ime" name="fname" value="<?php echo $fname; ?>" autofocus="">
                                </div>
                              </div>
                              <div class="field">
                                <div class="control">
                                  <input class="input is-large" type="text" placeholder="Prezime"  name="lname" value="<?php echo $lname; ?>" autofocus="">
                                </div>
                              </div>
                              <div class="field">
                                <div class="control">
                                  <input class="input is-large" type="text" placeholder="Korisničko ime" name="username" value="<?php echo $username; ?>" autofocus="">
                                </div>
                              </div>
                            <div class="field">
                              <div class="control">
                                <input class="input is-large" type="email" placeholder="Elektronička pošta" name="email" value="<?php echo $email; ?>" autofocus="">
                              </div>
                            </div>
                            <div class="field">
                              <div class="control">
                                <input class="input is-large" type="password" placeholder="Lozinka" name="password_1">
                              </div>
                            </div>
                              <div class="field">
                                <div class="control">
                                  <input class="input is-large" type="password" placeholder="Ponovite lozinku" name="password_2">
                                </div>
                              </div>
                              <label class="checkbox" style="margin: 20px;">
                                
                              <button class="button is-block is-danger is-large is-fullwidth" type="submit" name="reg_user">Registriraj se</button>
                              
                            </div>
                            
                          </form>
                          <div class="container has-text-centered is-size-4 has-text-weight-heavy has-text-link box" >
                                <a href="login.php">Već imate račun? Prijavite se!</a>
                              </div>
                          <div class="container has-text-centered is-size-4 has-text-weight-heavy has-text-link box" >
                                <a href="index.php">Povratak na početnu!</a>
                              </div>
                      </div>
                </div>
              </div>
            </div>
          </div>
    </div>
</body>
</html>