<?php


namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class RegisteredController extends AbstractController{
    /**
     * @Route("/registered", name="registered");
     */
    function registered():Response{
        $logged = NULL;
        $login = NULL;
        if(isset($_SESSION['logged'])){
            $logged = $_SESSION['logged'];
            $login = $_SESSION['login'];
        }
        return $this->render('registered.html.twig', ['logged' => $logged, 'login'=>$login]);
    }

}