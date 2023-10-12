<?php
final class motorController
{
    private array $_mapOfSplitUrl;

    private array $_mapOfResidualParameters;

    private $_mapOfPostParameters;

    public function __construct($S_url, $mapOfPostParameters)
    {
        // On élimine l'éventuel slash en fin d'URL sinon notre explode renverra une dernière entrée vide et on vérifie qu'il n'est pas null
        if ($S_url !== null && str_ends_with($S_url, '/')) {
            $S_url = substr($S_url, 0, strlen($S_url) - 1);
        }

        if ($S_url !== null) {
            // On éclate l'URL, elle va prendre place dans un tableau
            $arrayOfSplitUrl = explode('/', $S_url);
        }

        if (empty($arrayOfSplitUrl[0])) {
            // Nous avons pris le parti de nommer tout les controleur <nom controleur>Controller
            $arrayOfSplitUrl[0] = 'DefaultController';
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

        // On  s'occupe du tableau $mapOfPostParameters
        $this->_mapOfPostParameters = $mapOfPostParameters;

    }

    // On exécute notre triplet

    public function run(): void
    {
        if (!class_exists($this->_mapOfSplitUrl['controller'])) {
            throw new ExceptionsController($this->_mapOfSplitUrl['controller'] . " n'est pas un controleur valide.");
        }

        if (!method_exists($this->_mapOfSplitUrl['controller'], $this->_mapOfSplitUrl['action'])) {
            throw new ExceptionsController($this->_mapOfSplitUrl['action'] . " du contrôleur " .
                $this->_mapOfSplitUrl['controller'] . " n'est pas une action valide.");
        }

        $B_called = call_user_func_array(array(new $this->_mapOfSplitUrl['controller'],
            $this->_mapOfSplitUrl['action']), array($this->_mapOfResidualParameters, $this->_mapOfPostParameters));

        if (false === $B_called) {
            throw new ExceptionsController("L'action " . $this->_mapOfSplitUrl['action'] .
                " du contrôleur " . $this->_mapOfSplitUrl['controller'] . " a rencontré une erreur.");
        }
    }
}