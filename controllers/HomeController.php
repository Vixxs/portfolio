<?php

final class HomeController extends Controller
{
    private $likeFile;

    public function __construct()
    {
        $this->likeFile = Constants::assetsDirectory() . 'files/likes.txt';
        parent::__construct();
    }

    /**
     * Action par defaut à executer à la racine 
     *
     * @return void
     */
    public function defautAction()
    {
        if(!file_exists($this->likeFile)) {
            file_put_contents($this->likeFile, 0);
        }
        $likesCount = (int)file_get_contents($this->likeFile);

        echo $this->twig->render('home.twig', [
            'likesCount' => $likesCount
        ]);
    }
    
    public function likeAction()
    {   
        if (!isset($_GET['ajax']) || $_GET['ajax'] != 'true') {
            header('Location: /');
        }
        if(!file_exists($this->likeFile)) {
            file_put_contents($this->likeFile, 0);
        }
        $likesCount = (int)file_get_contents($this->likeFile);
        if (!isset($_SESSION['like']) || $_SESSION['like'] != true) {
            $_SESSION['like'] = true;
            $likesCount = $likesCount + 1;
        }
        elseif ($_SESSION['like'] == true) {
            $_SESSION['like'] = false;
            if ($likesCount > 0) {
                $likesCount = $likesCount - 1;
            }
        }
        file_put_contents($this->likeFile, $likesCount);
        echo json_encode(['likesCount' => $likesCount]);
    }

}