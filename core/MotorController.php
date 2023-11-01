<?php

/**
 * classe PRINCIPALE du framework, elle est responsable de l'appelle dynamique du bon controlleur selon l'url
 *
 * elle joue le role de routeur, (elle est le point d'entrée de l'application) juste apres l'index
 * on check les sessions a l'entrée de cette classe, et les droits d'acces aux pages afin de rediriger
 *
 * note : on l'appelle souvent routoController
 * note2 : on pourra penser a afficher du message d'erreur sous forme de 404 si la page n'existe pas
 * @see index.php
 * @see /controllers
 * @see SessionManager
 *
 * @package core
 * @since 1.0
 * @version 1.0
 * @category motorController
 * @author Tom Carvajal & Killian Ferrier
 */
final class MotorController
{
    /**
     * @var array (contient le tableau de l'url dont chaque élement était séparé par un /)
     */
    private array $_mapOfSplitUrl;

    /**
     * @var array (contient le tableau des parametres résiduels) (apres le controller et l'action)
     */
    private array $_mapOfResidualParameters;

    /**
     * @var array (contient le tableau des parametres post)
     */
    private array $_mapOfPostParameters;

    /**
     * @var bool (contient un booléen qui indique si on doit rediriger vers la page d'authentification)
     */
    private bool $_redirectionNeededBecauseOfAuthentification;


    /**
     * Constructeur de la classe MotorController
     *
     * on crée une session et on verifie si elle est pas perimé
     *
     *
     * @param mixed|null $S_url
     * @param array|null $mapOfPostParameters
     */
    public function __construct(mixed $S_url, ?array $mapOfPostParameters)
    {
        SessionManager::createSession();
        SessionManager::checkValiditySessionTime();


        // On élimine l'éventuel slash en fin d'URL sinon notre explode renverra une dernière entrée vide et on vérifie qu'il n'est pas null
        if ($S_url !== null && str_ends_with($S_url, '/')) {
            $S_url = substr($S_url, 0, strlen($S_url) - 1);
        }

        if ($S_url !== null) {
            // On éclate l'URL, elle va prendre place dans un tableau
            $arrayOfSplitUrl = explode('/', $S_url);
        }

        if (empty($arrayOfSplitUrl[0])) {
            // Nous avons pris le parti de nommer tout les controleur Controller<nom controleur>
            $arrayOfSplitUrl[0] = 'ControllerDefault';
        } else {
            $arrayOfSplitUrl[0] = 'Controller' . ucfirst($arrayOfSplitUrl[0]);
        }

        if (empty($arrayOfSplitUrl[1])) {
            // L'action est vide ! On la valorise par défaut
            $arrayOfSplitUrl[1] = 'DefaultAction';
        } else {
            // On part du principe que toutes nos actions sont suffixées par 'Action'...à nous de le rajouter
            $arrayOfSplitUrl[1] = $arrayOfSplitUrl[1] . 'Action';
        }


        // on dépile 2 fois de suite depuis le début, c'est à dire qu'on enlève de notre tableau le contrôleur et l'action
        // il ne reste donc que les éventuels parametres (si nous en avons)...
        $this->_mapOfSplitUrl['controller'] = array_shift($arrayOfSplitUrl); // on recupere le contrôleur
        $this->_mapOfSplitUrl['action'] = array_shift($arrayOfSplitUrl); // puis l'action

        // ...on stocke ces éventuels parametres dans la variable d'instance qui leur est réservée
        $this->_mapOfResidualParameters = $arrayOfSplitUrl;

        // On s'occupe du tableau $mapOfPostParameters
        $this->_mapOfPostParameters = $mapOfPostParameters;

        // regle de redirection
        if (!isset($_SESSION['UserId']) && ($this->_mapOfSplitUrl['controller'] !== 'ControllerAuth' &&
                $this->_mapOfSplitUrl['controller'] !== 'ControllerDefault') &&
            ($this->_mapOfSplitUrl['controller'] !== 'ControllerMenu')) {
            // TODO A ameliorer avec les roles, voir ce faire des regles d'acces dans un fichier json
            // on verifie si session + page accessible ou non .

            $this->_redirectionNeededBecauseOfAuthentification = true;
        } else {
            $this->_redirectionNeededBecauseOfAuthentification = false;
        }
    }

    // On exécute notre triplet

    /**
     * methode run qui permet d'appeller les bons controlleur selon nos conventions de nommage
     * on verifie si le controlleur existe, si l'action existe, si l'utilisateur a le droit d'acceder a la page
     * et on appelle la bonne methode
     * et si une erreur survient on la renvoie
     *
     * @throws ExceptionsController
     */
    public function run(): void
    {
        if (!class_exists($this->_mapOfSplitUrl['controller'])) {
            throw new ExceptionsController($this->_mapOfSplitUrl['controller'] . " n'est pas un controleur valide.");
        }

        if (!method_exists($this->_mapOfSplitUrl['controller'], $this->_mapOfSplitUrl['action'])) {
            throw new ExceptionsController($this->_mapOfSplitUrl['action'] . " du contrôleur " .
                $this->_mapOfSplitUrl['controller'] . " n'est pas une action valide.");
        }

        if ($this->_redirectionNeededBecauseOfAuthentification) {
            // TODO sinon on redirige vers page d'authentification

            error_log("redirectionNeededBecauseOfAuthentification"); //TODO AMELIORER LOG
            header("Location: /Auth/Login");
            exit;
        }
        $B_called = call_user_func_array(array(new $this->_mapOfSplitUrl['controller'],
            $this->_mapOfSplitUrl['action']), array($this->_mapOfResidualParameters, $this->_mapOfPostParameters));

        if (false === $B_called) {
            throw new ExceptionsController("L'action " . $this->_mapOfSplitUrl['action'] .
                " du contrôleur " . $this->_mapOfSplitUrl['controller'] . " a rencontré une erreur.");
        }
    }
}