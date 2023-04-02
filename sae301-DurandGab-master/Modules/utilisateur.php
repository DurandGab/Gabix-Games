<?php
/** 
* définition de la classe Utilisateur
*/
class Utilisateur {
        private string $_pseudo;
		private string $_prenom;
        private string $_nom;    
		private string $_adresse_mail;
		private string $_date_naiss;
		private string $_date_inscription;
		private string $_mot_de_passe;
		private string $_admin;
		
        // contructeur
        public function __construct(array $donnees) {
		// initialisation d'un produit à partir d'un tableau de données
			if (isset($donnees['pseudo'])) { $this->_pseudo = $donnees['pseudo']; }
			if (isset($donnees['prenom'])) { $this->_prenom = $donnees['prenom']; }
			if (isset($donnees['nom'])) { $this->_nom = $donnees['nom']; }
			if (isset($donnees['adresse_mail'])) { $this->_adresse_mail = $donnees['adresse_mail']; }
			if (isset($donnees['date_naiss'])) { $this->_date_naiss = $donnees['date_naiss']; }
			if (isset($donnees['date_inscription'])) { $this->_date_inscription = $donnees['date_inscription']; }
			if (isset($donnees['mot_de_passe'])) { $this->_mot_de_passe = $donnees['mot_de_passe']; }
			if (isset($donnees['admin'])) { $this->_admin = $donnees['admin']; }
        }           
        // GETTERS //
		public function pseudo() { return $this->_pseudo;}
		public function prenom() { return $this->_prenom;}
		public function nom() { return $this->_nom;}
		public function adresse_mail() { return $this->_adresse_mail;}	
		public function date_naiss() { return $this->_date_naiss;}
		public function date_inscription() { return $this->_date_inscription;}
		public function mot_de_passe() { return $this->_mot_de_passe;}
		public function admin() { return $this->_admin;}
		
		// SETTERS //
		public function setIdMembre(int $pseudo) { $this->_pseudo = $pseudo; }
        public function setNom(string $nom) { $this->_nom= $nom; }
		public function setPrenom(string $prenom) { $this->_prenom = $prenom; }
		public function setEmail(string $adresse_mail) { $this->_adresse_mail = $_adresse_mail; }
		public function setAnneeNaissance(int $date_naiss) { $this->_date_naiss = $date_naiss; }
		public function setSexe(string $date_inscription) { $this->_date_inscription = $date_inscription; }
		public function setMot_de_passe(string $mot_de_passe) { $this->_mot_de_passe = $mot_de_passe; }
		public function setAdmin(int $admin) { $this->_admin = $admin; }		

    }

?>