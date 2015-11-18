<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MainController extends Controller
{
    /**
    * @Route("/")
    */
    public function indexAction(){
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/login")
     */
    public function loginAction(){
        return $this->render('login.html.twig');
    }

    /**
     * @Route("/reg")
     */
    public function regAction(){
        return $this->render('reg.html.twig');
    }

    /**
     * @Route("/createUser")
     * @Method("POST")
     */
    public function createUser() {
        return $this->render('index.html.twig');
    }
}