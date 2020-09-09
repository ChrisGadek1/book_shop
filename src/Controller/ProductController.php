<?php


namespace App\Controller;
use App\Entity\Books;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController{
    /**
     * @Route("/product/{id}")
     * @param $id
     * @return Response
     */
    function displayProduct($id):Response{
        $logged = NULL;
        $login = NULL;
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['logged'])){
            $logged = $_SESSION['logged'];
            $login = $_SESSION['login'];
        }
        $result = $this->getDoctrine()->getRepository(Books::class)->findById($id);
        return $this->render('product.html.twig',[
            'logged' => $logged,
            'login' => $login,
            'id' => $id,
            'title' => $result[0]->getTitle(),
            'author' => $result[0]->getAuthor(),
            'price' => $result[0]->getPrice()
        ]);
    }
}