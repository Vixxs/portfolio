<?php
// Ce fichier est le point d'entrée de votre application
    require './vendor/autoload.php';
    require './core/AutoLoad.php';

    $url = isset($_GET['url']) ? $_GET['url'] : null;
    $postParams = isset($_POST) ? $_POST : null;
    try
    {
        $dispatcher = new Dispatcher($url, $postParams);
        $dispatcher->run();
    }
    catch (ControleurException $exception)
    {
        echo ('Une erreur s\'est produite : ' . $exception->getMessage());
    }

    // Les différentes sous-vues ont été "crachées" dans le tampon d'affichage, on les récupère