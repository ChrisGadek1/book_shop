<?php


namespace App\Controller;
use App\Entity\Users;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController{
    /**
     * @Route("/user")
     */
    function user(){
        if(!isset($_SESSION)){
            session_start();
        }
        $logged = NULL;
        $login = NULL;
        if(isset($_SESSION['logged'])){
            $logged = $_SESSION['logged'];
            $login = $_SESSION['login'];
        }
        else{
            return $this->redirectToRoute("main");
        }
        $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['login' => $login]);
        return $this->render('user.html.twig',[
            'logged' => $logged,
            'login' => $login,
            'address' => $user->getAddress() == '' ? 'nie podano' : $user->getAddress(),
            'email' => $user->getEmail()
        ]);
    }
}