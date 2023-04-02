<?php
/**
* Définition d'une classe permettant de gérer les itinéraires 
*   en relation avec la base de données	
*/
class JeuManager {
    
	private $_db; // Instance de PDO - objet de connexion au SGBD
        
	/**
	* Constructeur = initialisation de la connexion vers le SGBD
	*/
	public function __construct($db) {
		$this->_db=$db;
	}
        
	public function ajoutJeu(Jeu $jeu) {
		// calcul d'un nouveau code d'itineraire non déja utilisé = Maximum + 1
		$stmt = $this->_db->prepare("SELECT max(id_jeu) AS maximum FROM jeu");
		$stmt->execute();
		$jeu->setid_jeu($stmt->fetchColumn()+1);
		
		// requete d'ajout dans la BD
		$req = "INSERT INTO jeu (id_jeu, nom_jeu, regles, temps_de_jeu_moyen, materiel, nb_joueurs_minimum, age_minimum, img_jeu, pseudo, nom_categorie) VALUES (?,?,?,?,?,?,?,?,?,?)";
		$stmt = $this->_db->prepare($req);
		$res  = $stmt->execute(array($jeu->id_jeu(), $jeu->nom_jeu(), $jeu->regles(), $jeu->temps_de_jeu_moyen(), $jeu->materiel(), $jeu->nb_joueurs_minimum(), $jeu->age_minimum(), $jeu->img_jeu(), $jeu->pseudo(), $jeu->nom_categorie()));		
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		return $res;
	}
        
	public function count() {
		$stmt = $this->_db->prepare('SELECT COUNT(*) FROM jeu');
		$stmt->execute();
		return $stmt->fetchColumn();
	}

	public function deleteJeu(Jeu $jeu) {
		$req = "DELETE FROM noter_et_commenter WHERE id_jeu = ?";
		$stmt = $this->_db->prepare($req);
		$req1 = $stmt->execute(array($jeu->id_jeu()));

		$req = "DELETE FROM jeu WHERE id_jeu = ?";
		$stmt = $this->_db->prepare($req);
		$req2 = $stmt->execute(array($jeu->id_jeu()));
		$jeu = array($req1, $req2);
		return $jeu;
	}
		
	public function get($id_jeu) {	
		$jeu = array();
		$req = 'SELECT * FROM jeu WHERE id_jeu=?';
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($id_jeu));
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
			
		}
			$jeu = new Jeu($stmt->fetch());
		
		return $jeu;
	}


		
	public function listJeu() {
		$jeux = array();
		$req = "SELECT * FROM jeu";
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
			$jeux[] = new Jeu($donnees);
		}
		return $jeux;
	}

	public function jeu($id) {
		$req = "SELECT * FROM jeu where id_jeu = ?";
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($id));
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		// récup des données
			$jeu = new Jeu($stmt->fetch());
		
		return $jeu;
	}

	public function mesjeux($pseudo) {
		$jeux = array();
		$req = "SELECT * FROM jeu WHERE pseudo=?";
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($pseudo));
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		// recup des données
		while ($donnees = $stmt->fetch())
		{
			$jeux[] = new Jeu($donnees);
		}
		return $jeux;
	}

	public function search($nom_jeu, $nom_categorie, $materiel) {
		$req = "SELECT * FROM jeu";
		$cond = '';

		if ($nom_jeu<>"") 
		{ 	$cond = $cond . " nom_jeu like '%". $nom_jeu ."%'";
		}
		if ($nom_categorie<>"") 
		{ 	if ($cond<>"") $cond .= " AND ";
			$cond = $cond . " nom_categorie like '%" . $nom_categorie ."%'";
		}
		if ($materiel<>"") 
		{ 	if ($cond<>"") $cond .= " AND ";
			$cond = $cond . " materiel like '%" . $materiel . "%'";
		}
		if ($cond <>"")
		{ 	$req .= " WHERE " . $cond;
		}
		// execution de la requete				
		$stmt = $this->_db->prepare($req);
		$stmt->execute();
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		$jeux = array();

		while ($donnees = $stmt->fetch())
		{
			$jeux[] = new Jeu($donnees);
		}
		return $jeux;
		
	}
	
	public function update(Jeu $jeu) {
		$req = "UPDATE jeu SET nom_jeu = :nom_jeu, "
					. "regles = :regles, "
					. "temps_de_jeu_moyen = :temps_de_jeu_moyen, "
					. "materiel  = :materiel, "
					. "nb_joueurs_minimum = :nb_joueurs_minimum, "
					. "age_minimum = :age_minimum, "
					
					. "nom_categorie = :nom_categorie" 
					. " WHERE id_jeu = :id_jeu";

		$stmt = $this->_db->prepare($req);
		$stmt->execute(array(":nom_jeu" => $jeu->nom_jeu(),
								":regles" => $jeu->regles(),
								":temps_de_jeu_moyen" => $jeu->temps_de_jeu_moyen(),
								":materiel" => $jeu->materiel(),
								":nb_joueurs_minimum" => $jeu->nb_joueurs_minimum(), 
								":age_minimum" => $jeu->age_minimum(),
								
								":nom_categorie" => $jeu->nom_categorie(),
								":id_jeu" => $jeu->id_jeu() ));
		return $stmt->rowCount();
	}
}

// fontion de changement de format d'une date
// tranformation de la date au format j/m/a au format a/m/j
function dateChgmtFormat($date) {
//echo "date:".$date;
		list($j,$m,$a) = explode("/",$date);
		return "$a/$m/$j";
}
?>