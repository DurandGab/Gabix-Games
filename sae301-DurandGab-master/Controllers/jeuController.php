<?php
include "Modules/jeu.php";
include "Models/jeuManager.php";

/**
* Définition d'une classe permettant de gérer les jeux
*   en relation avec la base de données	
*/
class JeuController {
    
	//private $_db; // Instance de PDO - objet de connexion au SGBD
	private $jeuManager;
	private $noteretcommenterManager; // instance du manager
        
	/**
	* Constructeur = initialisation de la connexion vers le SGBD
	*/
	public function __construct($db, $twig) {
		//$this->_db=$db;
		$this->jeuManager = new JeuManager($db);
		$this->categorieManager = new CategorieManager($db);
		$this->noteretcommenterManager = new NoterManager($db);
		$this->twig=$twig;
	}
    
	public function listeJeu() {
		$jeux = $this->jeuManager->listjeu();
		if($_SESSION['acces']=="non"){
			echo $this->twig->render('jeu/liste.html.twig', ['jeux'=> $jeux,'session'=> $_SESSION]);
		}else{
			echo $this->twig->render('jeu/liste.html.twig', ['jeux'=> $jeux,'session'=> $_SESSION, 'admin' => $_SESSION['tabUtilisateur']['admin']]);
}

	}

	
	
	public function jeu($id){
		$jeu = $this->jeuManager->jeu($id);
		$notes = $this->noteretcommenterManager->note($id);
		if($_SESSION['acces']=="non"){
			echo $this->twig->render('jeu/jeu.html.twig', ['jeu'=> $jeu, 'session'=> $_SESSION, 'id'=>$id, 'notes'=>$notes ]);
		}else{
		echo $this->twig->render('jeu/jeu.html.twig', ['jeu'=> $jeu, 'session'=> $_SESSION, 'id'=>$id, "pseudo"=> $_SESSION["tabUtilisateur"]["pseudo"], 'notes'=>$notes ]);
		}
	}
	
	public function mesJeux($pseudo) {
		$jeux = $this->jeuManager->mesJeux($pseudo);
		echo $this->twig->render('jeu/mesjeux.html.twig', ['jeux'=> $jeux, 'session'=> $_SESSION]);
	}

	public function formRecherche($message) {
		echo $this->twig->render('recherche/recherche.html.twig', ['session'=> $_SESSION, 'message'=> $message]); 
	}
	
	public function rechercheJeu($data) {
		$data['nom_jeu'] = filter_input(INPUT_POST, 'nom_jeu', FILTER_SANITIZE_SPECIAL_CHARS);
		$data['nom_categorie'] = filter_input(INPUT_POST, 'nom_categorie', FILTER_SANITIZE_SPECIAL_CHARS);
		$data['materiel'] = filter_input(INPUT_POST, 'materiel', FILTER_SANITIZE_SPECIAL_CHARS);
		$jeux = New Jeu($data);
		$jeux = $this->jeuManager->search($_POST["nom_jeu"], $_POST["nom_categorie"], $_POST["materiel"]);
		echo $this->twig->render('recherche/resultat.html.twig', ['jeux'=> $jeux, 'session'=> $_SESSION]);
		
	}

	public function formAjoutJeu($pseudo) {
		$categories = $this->categorieManager->categoriesList();
		echo $this->twig->render('jeu/ajoutjeu.html.twig', ['session'=> $_SESSION, "pseudo"=> $pseudo, 'categories'=> $categories]);
	}

	public function validerJeu($data) {
		$data['nom_jeu'] = filter_input(INPUT_POST, 'nom_jeu', FILTER_SANITIZE_SPECIAL_CHARS);
		$data['regles'] = filter_input(INPUT_POST, 'regles', FILTER_SANITIZE_SPECIAL_CHARS);
		$data['temps_de_jeu_moyen'] = filter_input(INPUT_POST, 'temps_de_jeu_moyen', FILTER_SANITIZE_SPECIAL_CHARS);
		$data['materiel'] = filter_input(INPUT_POST, 'materiel', FILTER_SANITIZE_EMAIL);
		$date['nb_joueurs_minimum'] = filter_input(INPUT_POST, 'nb_joueurs_minimum', FILTER_SANITIZE_SPECIAL_CHARS);
		$data['age_minimum'] = filter_input(INPUT_POST, 'age_minimum', FILTER_UNSAFE_RAW);
		$data['pseudo'] = filter_input(INPUT_POST, 'pseudo', FILTER_UNSAFE_RAW);
		$data['nom_categorie'] = filter_input(INPUT_POST, 'nom_categorie', FILTER_UNSAFE_RAW);
		if ($_FILES["img_jeu"]["error"]==UPLOAD_ERR_OK) { 
   
			$uploaddir = "./img/"; 
			$uploadfile = $uploaddir . basename($_FILES["img_jeu"]["name"]);
			if (!move_uploaded_file($_FILES["img_jeu"]["tmp_name"], $uploadfile)) {
			echo "pb lors du telechargement"; } 
			}
		$nouveauJeu = $_POST;
		$nouveauJeu['img_jeu'] = basename($_FILES["img_jeu"]["name"]);;
		$jeu = new Jeu($nouveauJeu);
		$jeu = $this->jeuManager->ajoutJeu($jeu);

		if ($jeu){
			$message = "Jeu ajouté" ;
		} 
		else{
			$message = "probleme lors de l'ajout";
		} 
		return $message;
	}
	
	public function choixModifJeu($pseudo) { 
		$jeux = $this->jeuManager->mesjeux($pseudo);
		echo $this->twig->render('jeu/choixmodifjeu.html.twig', ['session'=> $_SESSION, "pseudo"=> $pseudo, 'jeux'=> $jeux]);
	}

	
	public function formModifJeu() {
		$jeu = $this->jeuManager->get($_POST["id_jeu"]);
		$categories = $this->categorieManager->categoriesList();
		echo $this->twig->render('jeu/modifjeu.html.twig', ['session'=> $_SESSION, "pseudo"=> $_SESSION["tabUtilisateur"]["pseudo"], 'jeu'=> $jeu,'categories'=> $categories]);
	}

	public function modifJeu() {
		$jeu =  new Jeu($_POST);
		$jeu = $this->jeuManager->update($jeu);
	
		if ($jeu){
			$message = "Jeu modifié" ;
		} 
		else{
			$message = "probleme lors de la modification";
		} 
		return $message;
	}

	public function choixSuppJeu($pseudo) {
		$jeux = $this->jeuManager->mesjeux($pseudo);
		echo $this->twig->render('jeu/choixsuppjeu.html.twig', ['session'=> $_SESSION, "pseudo"=> $pseudo, 'jeux'=> $jeux]);
	}

	public function validerSuppJeu() {
		$jeu = new jeu($_POST);
		$jeu = $this->jeuManager->deleteJeu($jeu);
		$count = $this->jeuManager->count();
		if ($jeu){
			$message = "Jeu supprimé" ;
			
		} 
		else{
			$message = "probleme lors de la suppression";
			
		} 
		return $message;
	}
	
}