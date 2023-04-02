<?php
/**
* Définition d'une classe permettant de gérer les itinéraires 
*   en relation avec la base de données	
*/
class NoterManager {
    
	private $_db; // Instance de PDO - objet de connexion au SGBD
        
	/**
	* Constructeur = initialisation de la connexion vers le SGBD
	*/
	public function __construct($db) {
		$this->_db=$db;
	}

	public function note($id) {
		$notes = array();
		$req = "SELECT * FROM noter_et_commenter where id_jeu=?";
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($id));
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		// récup des données
		while ($donnees = $stmt->fetch())
		{
			$notes[] = new Noter($donnees);
		}
		return $notes;
	}

	public function validNote($note) {
		$req = "INSERT INTO noter_et_commenter (pseudo, id_jeu, Ajout, Commentaire, Note) VALUES (?,?,?,?,?)";
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($note->pseudo(),$note->id_jeu(),date("Y-m-d H:i:s"),$note->Commentaire(),$note->Note()));
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		// récup des données
		while ($donnees = $stmt->fetch())
		{
			$note[] = new Noter($donnees);
		}
		return $note;
	}
}
?>