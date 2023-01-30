<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="assets/validation.js"></script>
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

    // Validation des données du formulaire
    $nom_erreur = '';
    $prenom_erreur = '';
    $email_erreur = '';
    $commentaire_erreur = '';

    if (empty($nom)) {
      $nom_erreur = 'Entrez un nom';
    } elseif (strlen($nom) < 2 || strlen($nom) > 255) {
      $nom_erreur = 'Ce nom n\'est pas valide, mon coco!';
    }

    if (empty($prenom)) {
      $prenom_erreur = 'Entrez un prénom';
    } elseif (strlen($prenom) < 2 || strlen($prenom) > 255) {
      $prenom_erreur = 'Rien ne va avec ce prénom, essaie encore.';
    }

    if (empty($email)) {
      $email_erreur = 'Entrez un email';
    } elseif (strlen($email) < 2 || strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_erreur = 'Cet email ne ressemble à rien!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Cet email ne ressemble à rien!";
    }

    if (empty($commentaire)) {
      $commentaire_erreur = 'Entrez un commentaire';
    } elseif (strlen($commentaire) < 2 || strlen($commentaire) > 1000) {
      $commentaire_erreur = 'Commentaire plutôt intéressant, mais il va falloir reformuler.';
    }

    // Si toutes les données sont valides, enregistrer les données dans la base de données
    if (empty($nom_erreur) && empty($prenom_erreur) && empty($email_erreur) && empty($commentaire_erreur)) {
      try {
        $pdo = new PDO('mysql:host=localhost;dbname=hackers-poulette', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, commentaire) VALUES (:nom, :prenom, :email, :commentaire)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':commentaire', $commentaire);
        $stmt->execute();

        // Afficher un message à l'utilisateur si le formulaire a été envoyé avec succès
        if($stmt->execute()){
            echo "<p class='merci'>Merci! Vous avez fait votre job, on s'attaque au nôtre :-)</p>";
          }else{
            echo "<p class='erreur'>Une erreur s'est produite lors de l'envoi du formulaire.</p>";
          }          

        // Rediriger l'utilisateur vers une page de confirmation
        header('Location: index.php');

        exit;

      } catch (PDOException $e) {
        echo "Erreur d'enregistrement : " . $e->getMessage();
      }
    }
  }
?>

<!-- Formulaire de contact (html sémantique) -->

<form name="formulaire" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" onsubmit="return validateForm()">
  <!-- for, id, placeholder pour l'accessibilité -->
    <div class="nom-form">
        <label class="nom-label" for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo isset($nom) ? $nom : ''; ?>" placeholder="Votre nom ici">
        <span><?php echo isset($nom_erreur) ? $nom_erreur : ''; ?></span>
    </div>

    <div class="prenom-form">
        <label class="prenom-label" for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo isset($prenom) ? $prenom : ''; ?>" placeholder="Votre prénom ici">
        <span><?php echo isset($prenom_erreur) ? $prenom_erreur : ''; ?></span>
    </div>

    <div class="email-form">
        <label class="email-label" for="email">Adresse email :</label>
        <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" placeholder="Votre email ici">
        <span><?php echo isset($email_erreur) ? $email_erreur : ''; ?></span>
    </div>

    <div class="comment-form">
        <label class="comment-label" for="commentaire">Commentaire :</label>
        <textarea id="comment" name="commentaire" rows="5" cols="40" value="<?php echo isset($commentaire) ? $commentaire : ''; ?>" placeholder="Votre commentaire ici"></textarea>
        <span><?php echo isset($commentaire_erreur) ? $commentaire_erreur : ''; ?></span>
    </div>
<div class="div-button">
    <button class="button-go" type="submit" value="go">Go</button>
</div>
</form>
</main>

<footer>Vaillamment réalisé par <a href=" https://github.com/DCoppee ">Dominique</a> pour <a href="https://becode.org">BeCode</a></footer>
</body>
</html>