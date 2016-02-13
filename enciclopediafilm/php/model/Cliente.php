<?php

include_once 'User.php';

/**
* @author StefanoChessa
* Classe che rappresenta il cliente
*/
class Cliente extends User {

/**
* Costruttore
*/
    public function __construct() {
        // richiamo il costruttore della superclasse
        parent::__construct();
        $this->setRuolo(User::Cliente);
        
    }

}

?>


