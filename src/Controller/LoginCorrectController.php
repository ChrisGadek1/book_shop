<?php


namespace App\Controller;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LoginCorrectController extends AbstractController {
    /**
     * @Route("/registerLogin")
     */
    function registerLogin(){
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $q = $_REQUEST["q"];
        $user = $repository->findOneBy(['login' => $q]);
        if($user){
            return new Response("T");
        }
        else{
            return new Response("F");
        }
    }
}