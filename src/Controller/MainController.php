<?php
namespace App\Controller;
use App\Entity\Books;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{   /**
    * @Route("/", name="main")
    */
    public function number():Response{
        if(!isset($_SESSION)){
            session_start();
        }
        $logged = NULL;
        $login = NULL;
        if(isset($_SESSION['logged'])){
            $logged = $_SESSION['logged'];
            $login = $_SESSION['login'];
        }
        $entityManager = $this->getDoctrine()->getManager();
        for($i = 0; $i < 1000; $i++){
            $book = new Books();
            $categories = array("rodzinne","imprezowe","serialowe","dla dzieci","erotyczne");
            $title = "Przykladowa nazwa gry ".$i;
            $desc = "Początek traktatu czasu być cnotliwym lub przyrachowane. W przyczytaniu musi być mogą. Te ostatnie zostawił to Pan Żochowski w roku życia takich skoropisów utworzyło się uczynku nastąpić ma. Najwyższa zasada prawodawstwa koniecznie po boru a wszakże Dobro więc wkradło się różne predykaty czyli pobudkę do złego przez rychłą pokutę wszelkich religiów, podporą i dla tego wyłączyć, ponieważ mu dał mu się przyszło dorozumiewał ";
            $author = "-";
            $price = rand(10,100);
            $img_src = rand(1,10);
            $year = rand(2013,2020);
            $month = rand(1,12);
            $day = rand(1,28);
            $book->setAuthor($author);
            $book->setSubcategory($categories[rand(0,4)]);
            $book->setDescribtion($desc);
            $book->setPrice($price);
            $book->setDateOfAdding(\DateTime::createFromFormat('Y-m-d', $year."-".$month."-".$day));
            $book->setCategory("gra");
            $book->setImageSrc($img_src);
            $book->setTitle($title);
            $entityManager->persist($book);
            $entityManager->flush();
        }
        $books = $this->getDoctrine()->getRepository(Books::class)->get4newest();
        return $this->render('index.html.twig',['logged' => $logged, 'login' => $login, 'books' => $books]);
    }
}