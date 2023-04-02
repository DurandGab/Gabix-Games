<?php

  session_start();  // utilisation des sessions

  include "connect.php"; // connexion au SGBD
  include "moteurtemplate.php";

  include "Controllers/jeuController.php";

  include "Controllers/utilisateurController.php";

  include "Controllers/categorieController.php";

  include "Controllers/noteretcommenterController.php";

  $jeuController = new JeuController($bdd, $twig);
  $utilisateurController = new UtilisateurController($bdd, $twig);
  $categorieController = new CategorieController($bdd, $twig);
  $noterController = new NoterController($bdd, $twig);

  // ============================== connexion / deconnexion - sessions ==================
  $message = "";


  // si la variable de session n'existe pas, on la crée
  if (!isset($_SESSION['acces'])) {     
   $_SESSION['acces']="non";
  }

  // ============================== Déconnecté et Connecté ====================


  // cas par défaut = page d'accueil
if (!isset($_GET["action"]) && empty($_POST)) {
  $jeuController->formRecherche('');
}
  // Click sur l'onglet 'Jeu', fait apparaitre la page d'accueil
if (isset($_GET["action"]) && $_GET["action"]=="accueil") {

  $jeuController->formRecherche('');
}
  // Click sur l'onglet 'Liste jeu', fait apparaitre la page de la liste des jeux
if (isset($_GET["action"]) && $_GET['action']=="jeux") { 
  $message= $jeuController->listeJeu();
}

  // Click sur le bouton 'En savoir plus' de la page 'Liste Jeux' pour afficher la page d'un jeu en particulier
if (isset($_GET["action"]) && $_GET['action']=="jeu" && isset($_GET["id"])){
  $jeuController->jeu($_GET["id"]);
}

  // Click sur l'onglet 'Liste Utilisateur', fait apparaitre la page de la liste des utilisateurs
if (isset($_GET["action"]) && $_GET['action']=="utilisateur") { 
  $utilisateurController->listeUtilisateur();
} 

  // Click sur le bouton 'En savoir plus' de la page 'Liste Utilisateur' pour afficher la page profil d'un utilisateur
if (isset($_GET["action"]) && $_GET['action']=="uti" && isset($_GET["pseudo"]))
  $utilisateurController->uti($_GET["pseudo"]);

  // Click sur l'onglet 'S'inscrire' fait apparaitre la page du formulaire d'inscription 
if (isset($_GET["action"]) && $_GET["action"]=="register") {     
  $utilisateurController->utilisateurRegister();
}

  // Click sur l'onglet 'Connexion', fait apparaitre la page du formulaire de connexion
if (isset($_GET["action"])  && $_GET["action"]=="login") {
  $utilisateurController->utilisateurFormulaire(); 
}
  // Après avoir remplie le formulaire de connexion, prends en compte les valeurs saisies et retour sur la page d'accueil avec un message de bienvenue 
if (isset($_POST["connexion"])) {     
  $message = $utilisateurController->utilisateurConnexion($_POST);
  $jeuController->formRecherche($message);
}
  // Après avoir remplie le formulaire d'inscription, prends en compte les valeurs saisies et retour sur la page d'accueil avec un message de confirmation de l'inscription
if (isset($_POST["register"])) {
  $message = $utilisateurController->utilisateurInscription($_POST);
  $jeuController->formRecherche($message);}


  // Après avoir remplie le formulaire de recherche d'un jeu, prend en compte les valeurs saisies et retourne sur la page d'accueil avec le résultat de la recherche
if (isset($_POST["okRecher"])) { 
  $jeuController->rechercheJeu($_POST);
}

  // ============================== Connecté ====================
  // Click sur le bouton déconnexion, retourne sur la page d'accueil avec un message 'aurevoir'
if (isset($_GET["action"]) && $_GET['action']=="logout") { 
  $message= $utilisateurController->utilisateurDeconnexion();
  $jeuController->formRecherche($message);} 
  // Click sur le bouton "mes jeux", fait apparaitre la page des jeux de l'utilisateur
if (isset($_GET["action"]) && $_GET['action']=="mesjeux") { 
  $jeuController->mesJeux($_SESSION['tabUtilisateur']['pseudo']);
  
} 
  // Click sur le bouton "ajout jeu", fait apparaitre la page du formulaire d'ajout de jeu
if (isset($_GET["action"]) && $_GET['action']=="ajout") { 
  $jeuController->formAjoutJeu($_SESSION['tabUtilisateur']['pseudo']);
} 
  // Après avoir remplie le formulaire de d'ajout d'un jeu, prend en compte les valeurs saisies et retourne sur la page d'accueil avec un jeu ajouté a la base de donnée.
if (isset($_POST["valider_ajout_jeu"])) { 
  $message = $jeuController->validerJeu($_POST);
  $jeuController->formRecherche($message);}

  // Click sur le bouton 'modifier jeu', 
if (isset($_GET["action"]) && $_GET['action']=="modif") { 
  $jeuController->choixModifJeu($_SESSION['tabUtilisateur']['pseudo']);
} 
  // Après avoir choisi le jeu à modifier, fait apparaitre la page du formulaire de modification du jeu
if (isset($_POST["valider_choix"])) { 
  $jeuController->formModifJeu();
}
  // Après avoir remplie le formulaire de modification du jeu, prend en compte les valeurs saisies et retourne sur la page d'accueil avec un message et le jeu modifié dans la base de donnée
if (isset($_POST["valider_modif_jeu"])) { 
  $message = $jeuController->ModifJeu();
  $jeuController->formRecherche($message);
}
  // Click sur le bouton 'supprimer jeu', fait apparaitre la page du formulaire du choix du jeu à supprimer
if (isset($_GET["action"]) && $_GET["action"]=="suppr") { 
  $jeuController->choixSuppJeu($_SESSION['tabUtilisateur']['pseudo']);
}
  // Après avoir choisi le jeu à supprimer, retourne sur la page d'accueil avec le jeu supprimé de la base de donnée
if (isset($_POST["valider_supp"])) { 
 $message =  $jeuController->validerSuppJeu();
  $jeuController->formRecherche($message);
}
  // Après avoir remplie le formulaire de notation d'un jeu, prend en compte les valeurs saisies et retourne sur la page d'accueil avec la notation pris en compte dans la base de donnée
if (isset($_POST["noter"])) { 
  $message =  $noterController->validerNote($_POST);
  $jeuController->formRecherche($message);
 }


?>

