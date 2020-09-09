<?php


namespace App\Controller;
use App\Entity\Users;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ChangeDataController extends AbstractController{
    /**
     * @Route("/changeData")
     */
    function changeData():Response{
        try{
            $what = $_REQUEST['what'];
            $newData = $_REQUEST['newdata'];
            $login = $_REQUEST['login'];
            if(!isset($_SESSION)){
                session_start();
            }
            $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['login' => $login]);
            if($what == "login"){
                if(!ctype_alnum($newData)){
                    return new Response("login może składać się tylko z liter i cyfr");
                }
                $user->setLogin($newData);
                $_SESSION['login'] = $newData;
            }
            else if($what == "email"){
                if(!filter_var($newData, FILTER_VALIDATE_EMAIL)){
                    return new Response("podaj poprawny email");
                }
                $user->setEmail($newData);
            }
            else{
                $user->setAddress($newData);
            }
            $this->getDoctrine()->getManager()->flush();
            return new Response("ok");
        }
        catch (\Exception $e){
            return new Response($e->getMessage());
        }
    }
}