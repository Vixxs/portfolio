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
    
    public function likeAction()
    {
        $likesCount = 0 ;
        if (!isset($_SESSION['like'])){
            $_SESSION['like'] = true;
            $likesCount = $likesCount + 1;
            var_dump($likesCount);
            die();
        }
        file_put_contents('like.txt', $likesCount);
    }

}