<?php
session_start();

if(isset($_SESSION['connect'])){
	header('location: index.php');
	exit();
}

require('src/connection.php');

// CONNEXION
if(!empty($_POST['email']) && !empty($_POST['password'])){

	// VARIABLES
	$email 		= $_POST['email'];
	$password 	= $_POST['password'];
	$error		= 1;

	// CRYPTER LE PASSWORD
	$password = "aq1".sha1($password."1254")."25";

	echo $password;

	$req = $db->prepare('SELECT * FROM users WHERE email = ?');
	$req->execute(array($email));

	while($user = $req->fetch()){

		if($password == $user['password']){
			$error = 0;
			$_SESSION['connect'] = 1;
			$_SESSION['pseudo']	 = $user['pseudo'];

			if(isset($_POST['connect'])) {
				setcookie('log', $user['secret'], time() + 365*24*3600, '/', null, false, true);
			}

			header('location: connection.php?success=1');
			exit();
		}

	}

	if($error == 1){
		header('location: connection.php?error=1');
		exit();
	}

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
        <a href="inscription.php" class="btn">Inscription</a>
      </nav>

      <!-- Hamburger -->
      <!-- <div class="hamburger">
        <img src="./images/grid-outline.svg" alt="" />
      </div> -->
    </header>

    <!-- Home -->
    <section class="home" id="home">
      <div class="content">
        <h1 style="font-size: 28px;">Connecter Sur Web <span class="pink">Market</span></h1>
        <p>
         
        Si vous avez déjà un compte connecter vous sinon </br> <a style="color:#f60091" href=""> créer un compte </a>
       


</p>


<a href="inscription.php" class="home-btn">Inscription</a>
      </div>
      <?php
		if(!isset($_SESSION['connect'])){ ?>


	 	
        <?php
			if(isset($_GET['error'])){
				echo'<p id="error">Nous ne pouvons pas vous authentifier.</p>';
			}
			else if(isset($_GET['success'])){
				echo'<p id="success">Vous êtes maintenant connecté.</p>';
			}
		?>
  
	 
	 	<div id="form">
			<form method="POST" action="connection.php">
			<table>
					<tr>
						<td>Email</td>
						<td><input type="email" name="email" placeholder="Ex : example@google.com" required></td>
					</tr>
					<tr>
						<td>Mot de passe</td>
						<td><input type="password" name="password" placeholder="Ex : ********" required ></td>
					</tr>
				</table>
				<p><label><input type="checkbox" name="connect" checked>Connexion automatique</label></p>
				<div id="button">
					<button type='submit'>Connexion</button>
				</div>
			</form>
		</div>
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
    
        
