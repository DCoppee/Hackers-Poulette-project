<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/style.css" rel="stylesheet">
    <title>Hackers Poulette</title>
</head>
<body>
    <header>
        <h1>Hackers Poulette</h1>
        <h2>comme sur des roulettes !</h2>
            <p class="bienvenue">Bienvenue sur la page de contact de <span class="hackers-poulette"> Hackers Poulette</span>. Notre dream team de support est au taquet pour vous aider ! <span class="remplir">Merci de remplir le formulaire ci-dessous</span>, nous vous répondrons illico presto !</p>
    </header>

    <main>
<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $commentaire = $_POST['commentaire'];

    // Valider des données du formulaire
    $nom_erreur = "";
    $prenom_erreur = "";
    $email_erreur = "";
    $commentaire_erreur = "";

    // Détenction des spams avec honeypot
    if (!empty($_POST['nom-honeypot']) || !empty($_POST['prenom-honeypot']) || !empty($_POST['email-honeypot']) || !empty($_POST['comment-honeypot'])) {
      // Ce champ est rempli, il s'agit probablement d'un spam: alors, exit!
      exit;
    }

    if (empty($nom)) {
      $nom_erreur = "<div class='msg-erreur'>Votre nom est absolument obligatoire!</div>";
    } elseif (strlen($nom) < 2 || strlen($nom) > 255) {
      $nom_erreur = "<div class='msg-erreur'>Ce nom n\'est pas valide, mon coco!</div>";
    }

    if (empty($prenom)) {
      $prenom_erreur = "<div class='msg-erreur'>Prénom indispensable, vraiment.</div>";
    } elseif (strlen($prenom) < 2 || strlen($prenom) > 255) {
      $prenom_erreur = "<div class='msg-erreur'>Rien ne va avec ce prénom, essayez encore.</div>";
    }

    if (empty($email)) {
      $email_erreur = "<div class='msg-erreur'>Sans e-mail, on ne peut rien pour vous...</div>";
    } elseif (strlen($email) < 2 || strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_erreur = "<div class='msg-erreur'>Cet email ne ressemble à rien!</div>";
    }

    if (empty($commentaire)) {
      $commentaire_erreur = "<div class='msg-erreur'>On aimerait un commentaire, même avec des fautes.</div>";
    } elseif (strlen($commentaire) < 2 || strlen($commentaire) > 1000) {
      $commentaire_erreur = "<div class='msg-erreur'>Commentaire plutôt intéressant, mais il va falloir reformuler.</div>";
    }

    // Si toutes les données sont valides, enregistrer les données dans la base de données
    if (empty($nom_erreur) && empty($prenom_erreur) && empty($email_erreur) && empty($commentaire_erreur)) {
      
      try {
        //Se connecter à la base de données
        $pdo = new PDO('mysql:host=localhost;dbname=hackers-poulette', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Insérer les données dans la base de données
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, commentaire) VALUES (:nom, :prenom, :email, :commentaire)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':commentaire', $commentaire);

        // Renvoyer un message à l'utilisateur selon son action
        if($stmt->execute()){
          header('Location: checkout.php');
          }else{
            header('Location: error.php');
          }          

        exit;

        //Message en cas d'erreur de connexion à la base de données
      } catch (PDOException $e) {
        echo "Erreur d'enregistrement : " . $e->getMessage();
      }
    }
  }
?>

<!-- Formulaire de contact (html sémantique) -->

<form name="formulaire" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
  
  <!-- Champs cachés pour implémenter le honeypot -->
  <input type="text" name="nom-honeypot" style="display:none;">
  <input type="text" name="prenom-honeypot" style="display:none;">
  <input type="text" name="email-honeypot" style="display:none;">
  <input type="text" name="comment-honeypot" style="display:none;">

    <div class="nom-form">
        <label class="nom-label" for="nom">* Nom</label>
        <input type="text" class="nom-input" name="nom" value="<?php echo isset($nom) ? $nom : ''; ?>" placeholder="Votre nom ici"> <!-- placeholder pour l'accessibilité -->
        <span><?php echo isset($nom_erreur) ? $nom_erreur : ''; ?></span>
    </div>

    <div class="prenom-form">
        <label class="prenom-label" for="prenom">* Prénom</label>
        <input type="text" class="prenom-input" name="prenom" value="<?php echo isset($prenom) ? $prenom : ''; ?>" placeholder="Votre prénom ici">
        <span><?php echo isset($prenom_erreur) ? $prenom_erreur : ''; ?></span>
    </div>

    <div class="email-form">
        <label class="email-label" for="email">* Adresse email</label>
        <input type="email" class="email-input" name="email" value="<?php echo isset($email) ? $email : ''; ?>" placeholder="Votre email ici">
        <span><?php echo isset($email_erreur) ? $email_erreur : ''; ?></span>
    </div>

    <div class="comment-form">
        <label class="comment-label" for="commentaire">* Commentaire</label>
        <textarea class="comment-input" name="commentaire" rows="5" cols="40" value="<?php echo isset($commentaire) ? $commentaire : ''; ?>" placeholder="Votre commentaire ici"></textarea>
        <span><?php echo isset($commentaire_erreur) ? $commentaire_erreur : ''; ?></span>
    </div>
<div class="div-btn">
    <button class="btn-go" type="submit" value="go">Go</button>
</div>
</form>
</main>

<footer>Vaillamment réalisé par <a href=" https://github.com/DCoppee ">Dominique</a> pour <a href="https://becode.org">BeCode</a></footer>
</body>
</html>