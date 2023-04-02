<?php

/**
* Définition d'une classe permettant de gérer les utilisateurs 
* en relation avec la base de données
*
*/

class UtilisateurManager
    {
        private $_db; // Instance de PDO - objet de connexion au SGBD
        
		/** 
		* Constructeur = initialisation de la connexion vers le SGBD
		*/
        public function __construct($db) {
            $this->_db=$db;
        }

	/**
	* @return Utilisateur[]
	*/
		
		public function listeUtilisateur() {
			$utilisateurs = array();
			$req = "SELECT * FROM utilisateur";
			$stmt = $this->_db->prepare($req);
			$stmt->execute();
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
			// récup des données
			while ($donnees = $stmt->fetch())
			{
				$utilisateurs[] = new Utilisateur($donnees);
			}
			return $utilisateurs;
		}

		public function uti($pseudo) {
			$req = "SELECT * FROM utilisateur where pseudo = ?";
			$stmt = $this->_db->prepare($req);
			$stmt->execute(array($pseudo));
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
			// récup des données
				$uti = new Utilisateur($stmt->fetch());
			
			return $uti;
		}

		public function ajoutUtilisateur($uti){
			$req = "INSERT INTO `utilisateur`(`pseudo`, `prenom`, `nom`, `adresse_mail`, `date_naiss`, `mot_de_passe`, date_inscription, admin) VALUES (?,?,?,?,?,?,?,0)";
			$stmt=$this->_db->prepare($req);
			$stmt->execute(array($uti->pseudo(), $uti->prenom(), $uti->nom(), $uti->adresse_mail(), $uti->date_naiss(), $uti->mot_de_passe(), date("Y-m-d H:i:s")));
			if ($uti=$stmt->fetch()){
				$utilisateur =new Utilisateur($uti);
				return $utilisateur;
				}
			else return false;
			}
		

		/**
		* verification de l'identité d'un membre (Login/password)
		* @param string $login
		* @param string $password
		* @return Utilisateur si authentification ok, false sinon
		*/
		public function verif_identification($login, $password) {
		//echo $login." : ".$password;
		$req ="SELECT pseudo, nom, prenom, adresse_mail, date_naiss, date_inscription, mot_de_passe, admin FROM utilisateur WHERE adresse_mail=? and mot_de_passe=?";
		$stmt =$this ->_db->prepare($req);
		$stmt->execute(array($login, $password));
		if ($data=$stmt->fetch()){
			$utilisateur =new Utilisateur($data);
			return $utilisateur;
			}
		else return false;
		}
	}
		
?>