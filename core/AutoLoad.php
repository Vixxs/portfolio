<?php

require 'core/Constants.php';

final class AutoLoad
{
    public static function loadClassesCore ($className)
    {
        $file = Constants::coreDirectory() . "$className.php";
        return static::_load($file);
    }

    public static function loadClassesException ($className)
    {
        $file = Constants::exceptionsDirectory() . "$className.php";

        return static::_load($file);
    }

    public static function loadClassesModel ($className)
    {
        $file = Constants::modelsDirectory() . "$className.php";

        return static::_load($file);
    }


    public static function loadClassesView ($className)
    {
        $file = Constants::viewsDirectory() . "$className.php";

        return static::_load($file);
    }

    public static function loadClassesController ($className)
    {
        $file = Constants::controllersDirectory() . "$className.php";

        return static::_load($file);
    }

    private static function _load ($S_fichierACharger)
    {
        if (is_readable($S_fichierACharger))
        {
            require $S_fichierACharger;
        }
    }
}

spl_autoload_register('AutoLoad::loadClassesCore');
spl_autoload_register('AutoLoad::loadClassesException');
spl_autoload_register('AutoLoad::loadClassesModel');
spl_autoload_register('AutoLoad::loadClassesView');
spl_autoload_register('AutoLoad::loadClassesController');


