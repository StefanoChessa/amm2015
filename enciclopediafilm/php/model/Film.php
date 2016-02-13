<?php

/**
 * @author StefanoChessa
 * Classe Film
 */
class Film {

    /**
     * Categoria del film
     * @var categoria
     */
    private $categoria;

    /**
     * Anno di produzione del film
     * @var int
     */
    private $anno;


    /**
     * Titolo del film
     * @var String
     */
    private $titolo;
    
    /**
     * Costruttore
     */
    public function __costruct() {
        
    }

    /**
     * id unico per il film
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Imposta un id unico per il film
     * @param int $id
     * @return boolean true se il valore e' stato aggiornato correttamente,
     * false altrimenti
     */
    public function setId($id) {
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        $this->id = $intVal;
    }

    public function setAnno($anno) {
        $intVal = filter_var($anno, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (isset($intVal)) {
            if ($intVal > 1900 && $intVal <= date("Y")) {
                $this->anno = $intVal;
                return true;
            }
        }
        return false;
    }

    public function getAnno() {
        return $this->anno;
    }


    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getTitolo() {
        return $this->titolo;
    }

    public function setTitolo($titolo) {
        $this->titolo = $titolo;
    }

}

?>
