<?php


namespace App\Controller;
use App\Entity\Orders;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\JsonResponse;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ReadOrdersController extends AbstractController{
    /**
     * @Route("/readOrders")
     */
    function readOrders(){
        $login = $_REQUEST['login'];
        $page = $_REQUEST['page'];
        $numberOfRecords = 7;
        $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['login' => $login]);
        $orders = $this->getDoctrine()->getRepository(Orders::class)->getUserOrders($user->getId());
        $price = 0;
        for($i = 0; $i < count($orders); $i++){
            $price += $orders[$i]->getIdBook()->getPrice();
        }
        for($i = ($page-1)*$numberOfRecords; $i < count($orders) && $i < $numberOfRecords*$page; $i++){
            $result[] = array(
                'title' => $orders[$i]->getIdBook()->getTitle(),
                'price' => $orders[$i]->getIdBook()->getPrice(),
                'author' => $orders[$i]->getIdBook()->getAuthor()
            );
        }
        $result[] = array('price' => $price);
        if(count($orders) < $numberOfRecords) $result[] = array('more' => false);
        else $result[] = array('more' => true);
        if(count($orders) <= $page*$numberOfRecords) $result[] = array('last' => true);
        else $result[] = array('last' => false);
        return new JsonResponse(json_encode($result));
    }
}