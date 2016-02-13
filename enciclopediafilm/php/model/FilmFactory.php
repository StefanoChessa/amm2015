<?php

include_once 'Db.php';
include_once 'Film.php';
include_once 'CategoriaFactory.php';


class FilmFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
* Restituisce un singleton per creare i film
* @return \VeicoloFactory
*/
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new FilmFactory();
        }

        return self::$singleton;
    }

    /**
* Restituisce i film presenti in memoria
* @return array|\Filmi
*/
    public function &getFilmi() {
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getFilmi] impossibile inizializzare il database");
            return array();
        }

        $query = "SELECT * from filmi";
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getFilmi] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return array();
        }

        $toRet = self::inizializzaListaFilmi($stmt);
        $mysqli->close();
        return $toRet;
    }

    /**
* riempie una lista di film con una query variabile
* @param mysqli_stmt $stmt
* @return array|\Film
*/
    private function &inizializzaListaFilmi(mysqli_stmt $stmt) {
        $veicoli = array();

        if (!$stmt->execute()) {
            error_log("[inizializzaListaFilm] impossibile" .
                    " eseguire lo statement");
            return $filmi;
        }

        $id = 0;
        $idcategoria = 0;
        $anno = 0;
        $titolo = "";



        if (!$stmt->bind_result($id, $idcategoria, $anno, $titolo)) {
            error_log("[inizializzaListaFilm] impossibile" .
                    " effettuare il binding in output");
            return array();
        }
        while ($stmt->fetch()) {
            $film = new Film();
            $film->setId($id);
            $film->setCategoria(CategoriaFactory::instance()->getCategoriaPerId($idcategoria));
            $film->setAnno($anno);
            $film->setTitolo($titolo);
            $filmi[] = $film;
        }
        return $filmi;
    }

    public function creaFilmDaArray($row) {
        $film = new Film();
        $film->setId($row['filmi_id']);
        $film->setCategoria(CategoriaFactory::instance()->getCategoriaPerId($row['filmi_idcategoria']));
        $film->setAnno($row['filmi_anno']);
        $film->setTitolo($row['filmi_titolo']);
        return $film;
    }
    
    /**
* Salva il film nel DB
* @param Film $film
* @return true se è stato salvato
*/
    public function nuovo($film) {
        $query = "insert into filmi (idcategoria, anno, titolo)
values (?, ?, ?)";

        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[nuovo] impossibile inizializzare il database");
            return 0;
        }

        $stmt = $mysqli->stmt_init();

        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[nuovo] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return 0;
        }

        if (!$stmt->bind_param('iis', $film->getCategoria()->getId(), $film->getAnno(), $film->getTitolo())){
        error_log("[nuovo] impossibile" .
                " effettuare il binding in input");
        $mysqli->close();
        return 0;
        }

        if (!$stmt->execute()) {
            error_log("[nuovo] impossibile" .
                    " eseguire lo statement");
            $mysqli->close();
            return 0;
        }

        $mysqli->close();
        return $stmt->affected_rows;
    }
    
    /**
* Cancella il film con per un id specifico
* @param int $id
* @return true se è stato cancellato
*/
    public function cancellaPerId($id) {
        $query = "delete from filmi where id = ?";

        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cancellaPerId] impossibile inizializzare il database");
            return 0;
        }

        $stmt = $mysqli->stmt_init();

        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[cancellaPerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return 0;
        }

        if (!$stmt->bind_param('i', $id)){
        error_log("[cancellaPerId] impossibile" .
                " effettuare il binding in input");
        $mysqli->close();
        return 0;
        }

        if (!$stmt->execute()) {
            error_log("[cancellaPerId] impossibile" .
                    " eseguire lo statement");
            $mysqli->close();
            return 0;
        }

        $mysqli->close();
        return $stmt->affected_rows;
    }
    
    /**
* Dato un id viene restituito il film
* @param int $id Identificatore
* @return \Film
*/
    public function &getFilmPerId($id){
        $film = new Film();
        $query = "select * from filmi where id = ?";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getFilmPerId] impossibile inizializzare il database");
            $mysqli->close();
            return $film;
        }


        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getFilmPerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $film;
        }

        if (!$stmt->bind_param('i', $id)) {
            error_log("[getFilmPerId] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return $film;
        }

        if (!$stmt->execute()) {
            error_log("[getFilmPerId] impossibile" .
                    " eseguire lo statement");
            return $film;
        }

        $id = 0;
        $idcategoria = 0;
        $anno = 0;
        $titolo = "";

        if (!$stmt->bind_result($id, $idcategoria, $anno, $titolo)) {
            error_log("[getFilmPerId] impossibile" .
                    " effettuare il binding in output");
            return $film;
        }
        while ($stmt->fetch()) {
            $film->setId($id);
            $film->setAnno($anno);
            $film->setTitolo($titolo);
            $film->setCategoria(CategoriaFactory::instance()->getCategoriaPerId($idcategoria));
          }


        $mysqli->close();
        return $film;
    }
}

?>
