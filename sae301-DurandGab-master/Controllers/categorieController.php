<?php

include "Modules/categorie.php";
include "Models/categorieManager.php";

class CategorieController {
    
	//private $_db; // Instance de PDO - objet de connexion au SGBD
	private $categorieManager; // instance du manager
        
	/**
	* Constructeur = initialisation de la connexion vers le SGBD
	*/
	public function __construct($db, $twig) {
		//$this->_db=$db;
		$this->jeuManager = new CategorieManager($db);
		$this->twig=$twig;
	}

}
?>