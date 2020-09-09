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
            $categories = array("romans","literatura piekna","kryminal","fantasy","przygodowa");
            $title = "Przykladowy tytul ksiazki ".$i;
            $desc = "Litwo! Ojczyzno moja! Ty jesteś jak zdrowie. Nazywał się w końcu dzieje chciano zamknąć w moim dom i z Bonapartą. tu świeccy, do marszu! Pójdziem, czy moda odmieniła z opieki nie wyszli witać, ale nic - nowe dziwo w której wytryskał rumieniec, ilekroć z dziecinną radością pociągnął za stołem siadał i zalety Ściągnęły wzrok stryja ku drzwiom odprowadzał i zgasło. I tak rzadka ciche grusze siedzą. Śród takich pól malowanych zbożem rozmaitem wyzłacanych ";
            $author = array("Adam Mickiewicz", "Napoleon Bonaparte","Bolesław Prus","J.K.Rowling","Grzegorz Brzęczyszczykiewicz");
            $price = rand(10,100);
            $img_src = rand(1,10);
            $year = rand(2013,2020);
            $month = rand(1,12);
            $day = rand(1,28);
            $book->setAuthor($author[rand(0,4)]);
            $book->setSubcategory($categories[rand(0,4)]);
            $book->setDescribtion($desc);
            $book->setPrice($price);
            $book->setDateOfAdding(\DateTime::createFromFormat('Y-m-d', $year."-".$month."-".$day));
            $book->setCategory("ksiazka");
            $book->setImageSrc($img_src);
            $book->setTitle($title);
            $entityManager->persist($book);
            $entityManager->flush();
        }
        $books = $this->getDoctrine()->getRepository(Books::class)->get4newest();
        return $this->render('index.html.twig',['logged' => $logged, 'login' => $login, 'books' => $books]);
    }
}