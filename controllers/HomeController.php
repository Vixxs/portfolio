<?php

final class HomeController extends Controller
{
        
    /**
     * Action par defaut à executer à la racine 
     *
     * @return void
     */
    public function defautAction()
    {
        echo $this->twig->render('home.twig');
    }
    
}