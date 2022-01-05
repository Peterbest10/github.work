<?php
session_start();

require("src/connection.php");
 
	if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])){
 
		// VARIABLE
 
		$pseudo       = $_POST['pseudo'];
		$email        = $_POST['email'];
		$password     = $_POST['password'];
		$pass_confirm = $_POST['password_confirm'];
 
		// TEST SI PASSWORD = PASSWORD CONFIRM
 
		if($password != $pass_confirm){
				header('Location: index.php?error=1&pass=1');
					exit();
 
		}
 
		// TEST SI EMAIL UTILISE
		$req = $db->prepare("SELECT count(*) as numberEmail FROM users WHERE email = ?");
		$req->execute(array($email));
 
		while($email_verification = $req->fetch()){
			if($email_verification['numberEmail'] != 0) {
				header('location: inscription.php?error=1&email=1');
				exit();
 			}
		}
 
		// HASH
 		$secret = sha1($email).time();
		$secret = sha1($secret).time().time();
 
		// CRYPTAGE DU PASSWORD
 		$password = "aq1".sha1($password."1254")."25";
 
		// ENVOI DE LA REQUETE
 		$req = $db->prepare("INSERT INTO users(pseudo, email, password, secret) VALUES(?,?,?,?)");
		$value = $req->execute(array($pseudo, $email, $password, $secret));
			
		header('location: inscription.php?success=1');
		exit();
 
 	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
    <title>Inscrivez Vous Sur Web Market </title>
    <!-- Css dans un fichier separer  -->
    <link rel="stylesheet" href="css/styles.css"/>
  </head>
  <body>


   
      <!-- Logo-->
    <header class="header">
      <a href="/" class="logo">Web <span class="pink">Market</span></a>

      <!-- Lien de navigation-->
      <!-- <nav class="navbar">
        <a href="#home">Accueil</a>
        <a href="#services">Services</a>
        <a href="#about">À propos de nous</a>
        <a href="#contact">Contactez-nous</a> -->
        <a href="connection.php" class="btn">Connexion</a>
      </nav>

      <!-- Hamburger -->
      <!-- <div class="hamburger">
        <img src="./images/grid-outline.svg" alt="" />
      </div> -->
    </header>

    <!-- Home -->
    <section class="home" id="home">
      <div class="content">
        <h1 style="font-size: 28px;">Créer un compte Web  <span class="pink">Market</span></h1>
        <p>
         
        Pour voir nos produits vous devez créer un compte, et après connecter.
        Vos informations seront protégées avec nous visitez, <a style="color:#f60091;" href="">notre politique de donnes </a> pour savoir 
        Plus à ce sujet.



</p>


<a href="connection.php" class="home-btn">Connexion</a>
      </div>
      <?php
		if(!isset($_SESSION['connect'])){ ?>


		<?php
		 
			if(isset($_GET['error'])){
		 
				if(isset($_GET['pass'])){
					echo '<p id="error">Les mots de passe ne correspondent pas.</p>';
				}
				else if(isset($_GET['email'])){
					echo '<p id="error">Cette adresse email est déjà utilisée.</p>';
				}
			}
			else if(isset($_GET['success'])){
				echo '<p id="success">Inscription prise correctement en compte.</p>';
			}
		 
		?>
	 
	 	<div id="form">
			<form method="POST" action="inscription.php">
				<table>
					<tr>
						<td>Nom d'utilisateur</td>
						<td><input size="30" type="text" name="pseudo" placeholder="Ex : Peter" required></td>
					</tr>
					<tr>
						<td>Adresse email</td>
						<td><input size="30" type="email" name="email" placeholder="Ex : adresse@gmail.com" required></td>
					</tr>
					<tr>
						<td>Mot de passe</td>
						<td><input size="30" type="password" name="password" placeholder="Ex : ********" required ></td>
					</tr>
					<tr>
						<td>Retaper votre mot de passe</td>
						<td><input size="30" type="password" name="password_confirm" placeholder="Ex : ********" required></td>
					</tr>
				</table>
				<div id="button">
					<button type='submit'>Inscription</button>
				</div>
			</form>
		</div>

		<?php } else { ?>
		
		<p id="info">
			Bonjour <?= $_SESSION['pseudo'] ?><br>
			<a href="disconnection.php">Déconnexion</a>
		</p>

		<?php } ?>

	</div>

	
</body>
</html>
    
        
