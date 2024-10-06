  // Tableau des chemins d'accès des images
  var images = ['./images/1.jpg', './images/2.jpg', './images/3.jpg'];
  var index = 0; // Index de l'image actuelle

  // Fonction pour changer l'image automatiquement
  function changerImageAutomatiquement() {
      var image = document.getElementById('image');
      image.src = images[index]; // Change la source de l'image en fonction de l'index actuel
      index = (index + 1) % images.length; // Passe à l'image suivante dans le tableau
  }

  // Démarre le changement d'image automatique toutes les 3 secondes
  setInterval(changerImageAutomatiquement, 3000); // Change l'image toutes les 3 secondes (3000 millisecondes)
