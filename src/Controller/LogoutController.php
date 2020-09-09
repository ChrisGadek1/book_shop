<?php

namespace App\Controller;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogoutController extends AbstractController{
    /**
     * @Route("/logout");
     */
    function logout():Response{
        if(!isset($_SESSION)){
            session_start();
        }
        session_unset();
        return $this->redirectToRoute("main");
    }
}