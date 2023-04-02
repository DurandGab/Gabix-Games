<?php
include "Modules/utilisateur.php";
include "Models/utilisateurManager.php";

/**
* Définition d'une classe permettant de gérer les utilisateurs 
*   en relation avec la base de données	
*/
class UtilisateurController {
    
	//private $_db; // Instance de PDO - objet de connexion au SGBD
	private $utilisateurManager; // instance du manager
        
	/**
	* Constructeur = initialisation de la connexion vers le SGBD
	*/
	public function __construct($db, $twig) {
		//$this->_db=$db;
		$this->utilisateurManager = new UtilisateurManager($db);
		$this->jeuManager = new JeuManager($db);
		$this->twig=$twig;
	}
    
	
	/**
	* liste de tous les itinéraires
	* @param aucun
	* @return rien
	*/

	public function listeUtilisateur() {
		$utilisateurs = $this->utilisateurManager->listeUtilisateur();
		echo $this->twig->render('utilisateur/liste.html.twig', ['utilisateurs'=> $utilisateurs,'session'=> $_SESSION]);

	}

	public function uti($pseudo){
		$uti = $this->utilisateurManager->uti($pseudo);
		$jeux = $this->jeuManager->mesJeux($pseudo);
		echo $this->twig->render('utilisateur/uti.html.twig', ['uti'=> $uti, 'session'=> $_SESSION, 'jeux'=>$jeux]);
	}
	/**
	* click sur s'inscrire
	* @param aucun
	* @return message string -> message de retour vers l'utilisateur
	*    qu'il est bien connecté ou pas
	*/

	function utilisateurRegister(){
		echo $this->twig->render('register/register.html.twig', ['session'=> $_SESSION]);
	}

	/**
	* s'enregistrer
	* @param aucun
	* @return message string -> message de retour vers l'utilisateur
	*    qu'il est bien connecté ou pas
	*/

	function utilisateurInscription($data) {
		$data['pseudo'] = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
		$data['prenom'] = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
		$data['nom'] = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
		$data['mail'] = filter_input(INPUT_POST, 'adresse_mail', FILTER_SANITIZE_EMAIL);
		$date['date'] = filter_input(INPUT_POST, 'date_naiss', FILTER_SANITIZE_SPECIAL_CHARS);
		$data['mdp'] = filter_input(INPUT_POST, 'mot_de_passe', FILTER_UNSAFE_RAW);
		$uti = New Utilisateur($data);
	$utilisateur = $this->utilisateurManager->ajoutUtilisateur($uti);
	$message='vous avez reussi à vous inscrire';
	return $message;	
	}
	

	/**
	* connexion
	* @param aucun
	* @return message string -> message de retour vers l'utilisateur
	*    qu'il est bien connecté ou pas
	*/
	function utilisateurConnexion($data) {
		 // verif du login et mot de passe
		if (($uti=$this -> utilisateurManager -> verif_identification($data ['login'], $data ['passwd']))!=false)
		{ // acces autorisé : variable de session acces = oui
			$_SESSION['acces'] = "oui";
			unset($_SESSION['tabUtilisateur']);
			$_SESSION["tabUtilisateur"] = ["pseudo" => $uti->pseudo(), "prenom" => $uti->prenom(), "nom" => $uti->nom(), "adresse_mail" => $uti->adresse_mail(), "date_naiss" => $uti->date_naiss(), "date_inscription" => $uti->date_inscription(), "mot_de_passe" => $uti->mot_de_passe(), "admin" => $uti->admin()];
			$message ="Bonjour ".$uti->prenom()."!";

		}
		else
		{ // acces non autorisé : variable de session acces = non
			$message="identification incorrecte";
			$_SESSION['acces'] = "non";
			unset($_SESSION['tabUtilisateur']);
		} 
		return $message;
		}	
	

	/**
	* deconnexion
	* @param aucun
	* @return message string -> message de retour vers l'utilisateur
	*/
	function utilisateurDeconnexion() {
		$_SESSION['acces'] = "non";
		unset($_SESSION['pseudo']);
		return "Aurevoir !";
	}

	/**
	* formulaire de connexion
	* @param aucun
	* @return rien
	*/
	function utilisateurFormulaire() {
		echo $this->twig->render('connexion/connexion.html.twig', ['session'=> $_SESSION]);
	}
}	
