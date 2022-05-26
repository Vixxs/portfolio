<?php

final class Dispatcher
{
    private $url;
    private $urlParams;
    private $postParams;

    public function __construct ($url, $postParams)
    {
        session_start();
        // On élimine l'éventuel slash en fin d'URL sinon notre explode renverra une dernière entrée vide
        if ('/' == substr($url, -1, 1)) {
            $url = substr($url, 0, strlen($url) - 1);
        }
        // On éclate l'URL, elle va prendre place dans un tableau
        $url = explode('/', $url);
        if (empty($url[0])) {
            // Nous avons pris le parti de préfixer tous les controleurs par "Controller"
            $url[0] = 'HomeController';
        } else {
            $url[0] =  ucfirst($url[0]) . 'Controller' ;
        }

        if (empty($url[1])) {
            // L'action est vide ! On la valorise par défaut
            $url[1] = 'defautAction';
        } else {
            // On part du principe que toutes nos actions sont suffixées par 'Action'...à nous de le rajouter
            $url[1] = $url[1] . 'Action';
        }


        // on dépile 2 fois de suite depuis le début, c'est à dire qu'on enlève de notre tableau le contrôleur et l'action
        // il ne reste donc que les éventuels parametres (si nous en avons)...
        $this->url['controleur'] = array_shift($url); // on recupere le contrôleur
        $this->url['action']     = array_shift($url); // puis l'action

        // ...on stocke ces éventuels parametres dans la variable d'instance qui leur est réservée
        $this->urlParams = $url;

        // On  s'occupe du tableau $postParams
        $this->postParams = $postParams;
        $this->twig = View::init();
    }

    /**
     * Méthode qui va exécuter le contrôleur et l'action demandé
     *
     * @return void
     */
    public function run()
    {
        if (!class_exists($this->url['controleur'])) {
            $this->url['controleur'] = 'HomeController';          
        }

        if (!method_exists($this->url['controleur'], $this->url['action'])) {
            throw new ControllerException($this->url['action'] . " du contrôleur " .
                $this->url['controleur'] . " n'est pas une action valide.");
        }

        $called = call_user_func_array(array(new $this->url['controleur'],$this->url['action']), array($this->urlParams, $this->postParams ));

        if (false === $called) {
            throw new ControllerException("L'action " . $this->url['action'] .
                " du contrôleur " . $this->url['controleur'] . " a rencontré une erreur.");
        }
    }
}