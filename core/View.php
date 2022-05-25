<?php

final class View
{

    public static function init(){
        $loader = new \Twig\Loader\FilesystemLoader('views');
        return new \Twig\Environment($loader, [
        ]);
    }
}