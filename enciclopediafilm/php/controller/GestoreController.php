<?php

include_once 'BaseController.php';
include_once basename(__DIR__) . '/../model/UserFactory.php';
include_once basename(__DIR__) . '/../model/Film.php';
include_once basename(__DIR__) . '/../model/FilmFactory.php';

/**
 * Controller gestore
 */
class GestoreController extends BaseController {

    const elenco = 'elenco';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Metodo per gestire l'input dell'utente.
     * @param type $request la richiesta da gestire
     */
    public function handleInput(&$request) {

        // creo il descrittore della vista
        $vd = new ViewDescriptor();

        // imposto la pagina
        $vd->setPagina($request['page']);

        if (!$this->loggedIn()) {
            // utente non autenticato, rimando alla home
            $this->showLoginPage($vd);
        } else {
            // utente autenticato
            $user = UserFactory::instance()->cercaUtentePerId(
                    $_SESSION[BaseController::user], $_SESSION[BaseController::role]);

            // verifico quale sia la sottopagina della categoria
            // Dipendete da servire ed imposto il descrittore
            // della vista per caricare i "pezzi" delle pagine corretti
            // tutte le variabili che vengono create senza essere utilizzate
            // direttamente in questo switch, sono quelle che vengono poi lette
            // dalla vista, ed utilizzano le classi del modello
            if (isset($request["subpage"])) {
                switch ($request["subpage"]) {

                    // modifica dei dati anagrafici
                    case 'anagrafica':
                        $vd->setSottoPagina('anagrafica');
                        
                        break;

                    //visual film
                    case 'film':
                        $filmi = FilmFactory::instance()->getFilmi();
                        $vd->setSottoPagina('elencoFilm');
                        break;

                    default:
                        $vd->setSottoPagina('home');
                        break;
                }
            }


            // gestione dei comandi inviati dall'utente
            if (isset($request["cmd"])) {

                switch ($request["cmd"]) {

                    // logout
                    case 'logout':
                        $this->logout($vd);
                        break;

                    // cambio email
                    case 'email':
                        // in questo array inserisco i messaggi di
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaEmail($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Email aggiornata");
                        $this->showHomeUtente($vd);
                        break;

                    // aggiornamento indirizzo
                    case 'indirizzo':

                        // in questo array inserisco i messaggi di
                        // cio' che non viene validato
                        $msg = array();               
                        $this->aggiornaIndirizzo($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Indirizzo aggiornato");
                        $this->showHomeUtente($vd);
                        break;

                    // modifica della password
                    case 'password':
                        $msg = array();
                        $this->aggiornaPassword($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Password aggiornata");
                        $this->showHomeUtente($vd);
                        break;


                    // l'utente non vuole modificare l'appello selezionato
                    case 'filmi_annulla':
                        $vd->setSottoPagina('elencoFilm');
                        $this->showHomeUtente($vd);
                        break;


                    //form per la creazione di un film
                    case 'new_film':
                        $categorie = CategoriaFactory::instance()->getCategorie();
                        $vd->setSottoPagina('crea_film');
                        $this->showHomeUtente($vd);
                        break;

                    // creazione di un nuovo film
                    case 'film_nuovo':
                        $vd->setSottoPagina('elencoFilm');
                        $msg = array();
                        $nuovo = new Film();
                        $nuovo->setId(-1);
                        $nuovo->setCategoria(CategoriaFactory::instance()->getCategoriaPerId($request['categoria']));

                        if ($request['anno'] != "") {
                            $nuovo->setAnno($request['anno']);
                        } else {
                            $msg[] = '<li> Inserire un anno valido </li>';
                        }
                        if ($request['titolo'] != "") {
                            $nuovo->setTitolo($request['titolo']);
                        } else {
                            $msg[] = '<li> Inserire un titolo valido </li>';
                        }

                        if (count($msg) == 0) {
                            $vd->setSottoPagina('elencoFilm');
                            if (FilmFactory::instance()->nuovo($nuovo) != 1) {
                                $msg[] = '<li> Impossibile creare il film </li>';
                            }
                        }

                        $this->creaFeedbackUtente($msg, $vd, "Film creato");

                        $filmi = FilmFactory::instance()->getFilmi();
                        $this->showHomeUtente($vd);
                        break;


                    // cancella un film
                    case 'cancella_film':
                        if (isset($request['film'])) {
                            $intVal = filter_var($request['film'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {

                                if (FilmFactory::instance()->cancellaPerId($intVal) != 1) {
                                    $msg[] = '<li> Impossibile cancellare il Film </li>';
                                }


                                $this->creaFeedbackUtente($msg, $vd, "Film eliminato");
                            }
                        }
                        $filmi = FilmFactory::instance()->getFilmi();
                        $this->showHomeUtente($vd);
                        break;
               
                    // default
                    default:
                        $this->showHomeUtente($vd);
                        break;
                }
            } else {
                // nessun comando, dobbiamo semplicemente visualizzare
                // la vista
                // nessun comando
                $user = UserFactory::instance()->cercaUtentePerId(
                        $_SESSION[BaseController::user], $_SESSION[BaseController::role]);
                $this->showHomeUtente($vd);
            }
        }


        // richiamo la vista
        require basename(__DIR__) . '/../view/master.php';
	}


}

?>
