<?php


namespace App\Controller;
use App\Entity\Books;
use App\Entity\Orders;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BuyController extends AbstractController{
    /**
     * @Route("/buy")
     */
    function buy(){
        $login = $_REQUEST['login'];
        $id = $_REQUEST['id'];
        $order = new Orders();
        $order->setIdBook($this->getDoctrine()->getRepository(Books::class)->find($id));
        $order->setIdClient($this->getDoctrine()->getRepository(Users::class)->findOneBy(['login' => $login]));
        $d = new \DateTime();
        $d->format("Y-m-d H:i");
        $order->setDate($d);
        $this->getDoctrine()->getManager()->persist($order);
        $this->getDoctrine()->getManager()->flush();
        return new Response("OK");
    }
}