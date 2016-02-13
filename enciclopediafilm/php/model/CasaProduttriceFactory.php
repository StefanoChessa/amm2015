<?php

include_once 'CasaProduttrice.php';
include_once 'Db.php';

class CasaProduttriceFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
* Restituisce un singleton per creare la CasaProduttrice
* @return CasaProduttriceFactory
*/
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new CasaProduttriceFactory();
        }

        return self::$singleton;
    }

    public function &getCasaProduttricePerId($id) {
        $casaproduttrice = new CasaProduttrice();
        $query = "select * from caseproduttrici where id = ?";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getCasaProduttricePerId] impossibile inizializzare il database");
            $mysqli->close();
            return $casaproduttrice;
        }


        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getCasaProduttricePerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $casaproduttrice;
        }

        if (!$stmt->bind_param('i', $id)) {
            error_log("[getCasaProduttricePerId] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return $casaproduttrice;
        }

        if (!$stmt->execute()) {
            error_log("[getCasaProduttricePerId] impossibile" .
                    " eseguire lo statement");
            return $casaproduttrice;
        }

        $id = 0;
        $nome = "";

        if (!$stmt->bind_result($id, $nome)) {
            error_log("[getCasaProduttricePerId] impossibile" .
                    " effettuare il binding in output");
            return null;
        }
        while ($stmt->fetch()) {
            $casaproduttrice->setId($id);
            $casaproduttrice->setNome($nome);
        }
        

        $mysqli->close();
        return $casaproduttrice;
    }

    /**
* Restituisce la lista di case produttrici
* @return array|\Costruttore
*/
    public function &getCaseProduttrici() {

        $caseproduttrici = array();
        $query = "select * from caseproduttrici";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getCaseProduttrici] impossibile inizializzare il database");
            $mysqli->close();
            return $caseproduttrici;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getCaseProduttrici] impossibile eseguire la query");
            $mysqli->close();
            return $caseproduttrici;
        }

        while ($row = $result->fetch_array()) {
            $caseproduttrici[] = self::getCaseProduttrici($row);
        }

        $mysqli->close();
        return $caseproduttrici;
    }

    /**
* Crea un oggetto di tipo Costruttore a partire da una riga del DB
* @param type $row
* @return \Costruttore
*/
    private function getCasaProduttrice($row) {
        $casaproduttrice = new CasaProduttrice();
        $casaproduttrice->setId($row['id']);
        $casaproduttrice->setNome($row['nomecasaproduttrice']);
        return $casaproduttrice;
    }

}

?>
