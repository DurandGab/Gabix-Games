<?php
/**
* définition de la classe jeu
*/
class Noter {
	private $_pseudo;   
	private $_id_jeu;
	private $_Ajout;
	private $_Commentaire;
	private $_Note;
	

		
	// contructeur
	public function __construct(array $donnees) {
	// initialisation d'un produit à partir d'un tableau de données
		if (isset($donnees['pseudo']))       { $this->_pseudo =       $donnees['pseudo']; }
		if (isset($donnees['id_jeu']))    { $this->_id_jeu =    $donnees['id_jeu']; }
		if (isset($donnees['Ajout']))  { $this->_Ajout =  $donnees['Ajout']; }
		if (isset($donnees['Commentaire'])) { $this->_Commentaire = $donnees['Commentaire']; }
		if (isset($donnees['Note'])) { $this->_Note = $donnees['Note']; }
		

	}           
	// GETTERS //
	public function pseudo()       { return $this->_pseudo;}
	public function id_jeu()    { return $this->_id_jeu;}
	public function Ajout()  { return $this->_Ajout;}
	public function Commentaire() { return $this->_Commentaire;}
	public function Note() { return $this->_Note;}
	

		
	// SETTERS //
	public function setpseudo($pseudo)             { $this->_pseudo = $pseudo; }
	public function setid_jeu($id_jeu)       { $this->_id_jeu = $id_jeu; }
	public function setAjout($Ajout)   { $this->_Ajout= $Ajout; }
	public function setCommentaire($Commentaire) { $this->_Commentaire = $Commentaire; }
	public function setNote($Note) { $this->_Note = $Note; }
	

}

