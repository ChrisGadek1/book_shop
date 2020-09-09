<?php


namespace App\Controller;
use App\Entity\Books;
use App\Entity\Opinions;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AddCommentController extends AbstractController{
    /**
     * @Route("/addComment")
     */
    function addComment(){

        try{
            $comment = $_REQUEST['comment'];
            $login_send = $_REQUEST['login'];
            $id = $_REQUEST['id'];
            $ocena = $_REQUEST['ocena'];
            $manager = $this->getDoctrine()->getManager();
            $opinion = new Opinions();
            $opinion->setBook($this->getDoctrine()->getRepository(Books::class)->find($id));
            $opinion->setOpinia($comment);
            $opinion->setUser($this->getDoctrine()->getRepository(Users::class)->findOneBy(['login' => $login_send]));
            $opinion->setOcena($ocena);
            $d = new \DateTime();
            $d->format('Y-m-d');
            $opinion->setDataDodania($d);
            $manager->persist($opinion);
            $manager->flush();
        }
        catch (\Exception $e){
            echo 'Caught exception: ',  $e->getMessage(), " błąd przy wprowadzaniu do bazy danych";
        }
        return new Response("dziala");
    }
}