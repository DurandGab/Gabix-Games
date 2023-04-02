<?php
/**
* définition de la classe jeu
*/
class Jeu {
	private $_id_jeu;   
	private $_nom_jeu;
	private $_regles;
	private $_temps_de_jeu_moyen;
	private $_materiel;
	private $_nb_joueurs_minimum;
	private $_age_minimum;
	private $_img_jeu;
	private $_pseudo;
	private $_nom_categorie;

		
	// contructeur
	public function __construct(array $donnees) {
	// initialisation d'un produit à partir d'un tableau de données
		if (isset($donnees['id_jeu']))       { $this->_id_jeu =       $donnees['id_jeu']; }
		if (isset($donnees['nom_jeu']))    { $this->_nom_jeu =    $donnees['nom_jeu']; }
		if (isset($donnees['regles']))  { $this->_regles =  $donnees['regles']; }
		if (isset($donnees['temps_de_jeu_moyen'])) { $this->_temps_de_jeu_moyen = $donnees['temps_de_jeu_moyen']; }
		if (isset($donnees['materiel'])) { $this->_materiel = $donnees['materiel']; }
		if (isset($donnees['nb_joueurs_minimum']))  { $this->_nb_joueurs_minimum =  $donnees['nb_joueurs_minimum'];}		
		if (isset($donnees['age_minimum']))       { $this->_age_minimum =       $donnees['age_minimum']; }
		if (isset($donnees['img_jeu']))    { $this->_img_jeu =    $donnees['img_jeu']; }
		if (isset($donnees['pseudo']))    { $this->_pseudo =    $donnees['pseudo']; }
		if (isset($donnees['nom_categorie'])) { $this->_nom_categorie = $donnees['nom_categorie']; }

	}           
	// GETTERS //
	public function id_jeu()       { return $this->_id_jeu;}
	public function nom_jeu()    { return $this->_nom_jeu;}
	public function regles()  { return $this->_regles;}
	public function temps_de_jeu_moyen() { return $this->_temps_de_jeu_moyen;}
	public function materiel() { return $this->_materiel;}
	public function nb_joueurs_minimum()  { return $this->_nb_joueurs_minimum;}
	public function age_minimum()       { return $this->_age_minimum;}
	public function img_jeu()    { return $this->_img_jeu;}
	public function pseudo()    { return $this->_pseudo;}
	public function nom_categorie() { return $this->_nom_categorie;}

		
	// SETTERS //
	public function setid_jeu($id_jeu)             { $this->_id_jeu = $id_jeu; }
	public function setnom_jeu($nom_jeu)       { $this->_nom_jeu = $nom_jeu; }
	public function setregles($regles)   { $this->_regles= $regles; }
	public function settemps_de_jeu_moyen($temps_de_jeu_moyen) { $this->_temps_de_jeu_moyen = $temps_de_jeu_moyen; }
	public function setmateriel($materiel) { $this->_materiel = $materiel; }
	public function setnb_joueurs_minimum($nb_joueurs_minimum)   { $this->_nb_joueurs_minimum = $nb_joueurs_minimum; }
	public function setage_minimum($age_minimum)             { $this->_age_minimum = $age_minimum; }
	public function setimg_jeu($img_jeu)       { $this->_img_jeu = $img_jeu; }
	public function setpseudo($pseudo)       { $this->_pseudo = $pseudo; }
	public function setnom_categorie($nom_categorie) { $this->_nom_categorie = $nom_categorie; }
	

}

