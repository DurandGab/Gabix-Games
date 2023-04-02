<?php

include "Modules/noteretcommenter.php";
include "Models/noteretcommenterManager.php";

class NoterController {
    
	//private $_db; // Instance de PDO - objet de connexion au SGBD
	private $noteretcommenterManager; // instance du manager
        
	/**
	* Constructeur = initialisation de la connexion vers le SGBD
	*/
	public function __construct($db, $twig) {
		//$this->_db=$db;
		$this->noteretcommenterManager = new NoterManager($db);
		$this->twig=$twig;
	}

	public function validerNote(){
		$note =  new Noter($_POST);
		$note = $this->noteretcommenterManager->validNote($note);
	
		if ($note){
			$message = "Commentaire et note effectué" ;
		} 
		else{
			$message = "probleme lors de la ";
		} 
		return $message;
	}
	}

?>