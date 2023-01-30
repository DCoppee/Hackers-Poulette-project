// Vérifier les entrées du formulaire avant d'envoyer les données au serveur
// Si elles sont vides, afficher un message d'erreur (alert)
function validateForm() {
  var x = document.forms["formulaire"]["nom"].value;
  if (x == "") {
    alert("Votre nom est absolument obligatoire!");
    return false;
  }
  var y = document.forms["formulaire"]["prenom"].value;
  if (y == "") {
    alert("Prénom indispensable, vraiment.");
    return false;
  }
  var z = document.forms["formulaire"]["email"].value;
  if (z == "") {
    alert("Sans e-mail, on ne peut rien pour vous...");
    return false;
  }
  var a = document.forms["formulaire"]["commentaire"].value;
  if (a == "") {
    alert("On aimerait un commentaire, même avec des fautes d'othographe.");
    return false;
  }
}
