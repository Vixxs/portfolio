<?php

final class View
{

    public static function init(){
        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader, [
        ]);
        $twig->addGlobal('session', $_SESSION);
        return $twig;
    }
}