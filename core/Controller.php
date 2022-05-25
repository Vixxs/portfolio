<?php 
class Controller
{
    public function __construct()
    {
        $this->twig = View::init();
    }
}