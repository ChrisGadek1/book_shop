<?php

namespace App\Controller;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController{
    /**
     * @Route ("/login")
     */
    function create():Response{
        $logged = NULL;
        $login = NULL;
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['logged'])){
            $logged = $_SESSION['logged'];
            $login = $_SESSION['login'];
        }
        if(isset($_POST['user_name'])){
            $entityManager = $this->getDoctrine()->getRepository(Users::class);
            $user = $entityManager->findOneBy(['login' => $_POST['user_name']]);
            if(!$user || !password_verify($_POST['password'],$user->getPassword())){
                return $this->render('login.html.twig', ['logged' => $logged, 'login' => $login, 'login_failed' => true]);
            }
            else{
                $_SESSION['logged'] = true;
                $_SESSION['login'] = $user->getLogin();
                return $this->redirectToRoute("main");
            }
        }
        return $this->render('login.html.twig',['logged' => $logged, 'login' => $login]);

    }
}